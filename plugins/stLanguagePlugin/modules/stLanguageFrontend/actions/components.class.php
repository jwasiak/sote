<?php

class stLanguageFrontendComponents extends sfComponents
{
    public function executeChoose()
    {
        if ($this->getUser()->getParameter('hide', false, 'soteshop/stLanguagePlugin'))
        {
            return sfView::NONE;
        }

        $languages = LanguagePeer::doSelectActive();

        if (!$languages || count($languages) == 1)
        {
            return sfView::NONE;
        }

        $selected = LanguagePeer::retrieveByCulture($this->getUser()->getCulture());
        $smarty = new stSmarty('stLanguageFrontend');
        $smarty->assign('languages', $languages);
        $smarty->assign('selected', $selected);
        $smarty->register_function('url_for_language', array('stLanguageFrontendComponents', 'urlForLanguage'));
        sfLoader::loadHelpers(array('Helper', 'stUrl'));

        return $smarty;
    }

    public static function urlForLanguage($params)
    {
        $language = stLanguage::getInstance(sfContext::getInstance());

        $shortcut = $params['language']->getShortcut();

        if($language->hasLangParameterInUrl($shortcut))
        {
            return st_url_for($language->getPath($shortcut), false, null, null, $shortcut);
        }
        else
        {
            return st_url_for($language->getPath($shortcut), true , null, $language->hasLangParameterInUrl($shortcut, true), $shortcut);
        }
    }    
}