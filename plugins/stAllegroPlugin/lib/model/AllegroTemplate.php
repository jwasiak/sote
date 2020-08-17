<?php

class AllegroTemplate extends BaseAllegroTemplate {

    protected $themeInstance = null;

    public function __toString() {
        return $this->getName();
    }

    public function save($con = null) {
        if ($this->isColumnModified(AllegroTemplatePeer::IS_DEFAULT) && $this->getIsDefault()) {
            $s = new Criteria();
            $s->add(AllegroTemplatePeer::IS_DEFAULT, true);

            $u = new Criteria();
            $u->add(AllegroTemplatePeer::IS_DEFAULT, false);

            BasePeer::doUpdate($s, $u, Propel::getConnection());
        }

        parent::save($con);
    }

    public function getThemeInstance()
    {
        if (null === $this->themeInstance)
        {
            $this->themeInstance = $this->theme ? ThemePeer::doSelectByName($this->theme) : null;
        }

        return $this->themeInstance;
    }

    public function render($parameters)
    {
        $search = array_keys($parameters);
        $replace = array_values($parameters);
        
        if (null !== $this->getTheme())
        {
            $theme = $this->getThemeInstance();
            $theme_editor = new stThemeEditorConfig();
            $theme_editor->load($theme->getThemeConfig());
            $theme_generator = new stThemeConfigGenerator($theme_editor);
        
            $search[] = '{LOGO}';
            $search[] = '{BANNER}';
            $search[] = '{STYLE}';

            $replace[] = stTheme::getImagePath('logo.png', $theme);
            $replace[] = stTheme::getImagePath('banner.jpg', $theme);
            $replace[] = $theme_generator->compileCss('allegro_template');
        }
             
        return str_replace($search, $replace, $this->getTemplate());        
    }
}
