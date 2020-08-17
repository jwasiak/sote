<?php

/**
 * Subclass for representing a row from the 'st_theme_content' table.
 *
 * 
 *
 * @package plugins.stThemePlugin.lib.model
 */ 
class ThemeContent extends BaseThemeContent
{
    public function hydrate(ResultSet $rs, $startcol = 1)
    {
       $this->setCulture(stLanguage::getHydrateCulture());
 
       return parent::hydrate($rs, $startcol);
    }
    
    public function setName($v)
    {
        if ($this->getCulture() == stLanguage::getOptLanguage())
        {
            stLanguage::setDefaultValue($this, __METHOD__, $v);
        }

        parent::setName($v);
    }

    public function getBackendName()
    {
        $culture = $this->getCulture();
        $this->setCulture(sfContext::getInstance()->getUser()->getCulture());
        $name = $this->getName();
        $this->setCulture($culture);

        return $name;
    }

    public function getName()
    {
        if ($this->getCulture() == stLanguage::getOptLanguage())
        {
            return stLanguage::getDefaultValue($this, __METHOD__);
        }

        $v = parent::getName();

        if (null === $v)
        {
            $v = stLanguage::getDefaultValue($this, __METHOD__);
        }

        return $v;
    }

    public function setContent($v)
    {
        if ($this->getCulture() == stLanguage::getOptLanguage())
        {
            stLanguage::setDefaultValue($this, __METHOD__, $v);
        }

        parent::setContent($v);
    }

    public function getContent()
    {
        if ($this->getCulture() == stLanguage::getOptLanguage())
        {
            return stLanguage::getDefaultValue($this, __METHOD__);
        }

        $v = parent::getContent();

        if (null === $v)
        {
            $v = stLanguage::getDefaultValue($this, __METHOD__);
        }

        return trim($v);
    }

    public function save($con = null)
    {
        $ret = parent::save($con);

        stFunctionCache::getInstance('stThemePlugin')->removeAll();

        return $ret;
    }
}
