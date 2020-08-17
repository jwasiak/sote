<?php

/**
 * Subclass for representing a row from the 'st_mail_description' table.
 *
 * 
 *
 * @package plugins.stMailPlugin.lib.model
 */ 
class MailDescription extends BaseMailDescription
{
/**
     * Przeciążenie hydrate
     *
     * @param ResultSet $rs
     * @param int $startcol
     * @return object
     */
    public function hydrate(ResultSet $rs, $startcol = 1)
    {
        $this->setCulture(stLanguage::getHydrateCulture());
        return parent::hydrate($rs, $startcol);
    }

    /**
     * Przeciążenie getDescription
     *
     * @return string
     */
    public function getDescription()
    {
        if ($this->getCulture() == stLanguage::getOptLanguage()) return stLanguage::getDefaultValue($this, __METHOD__);   
        
        $v = parent::getDescription();
        if (is_null($v)) $v = stLanguage::getDefaultValue($this, __METHOD__);
        return $v;
    }
    
    /**
     * Przeciążenie setName
     * 
     * @param string $v
     */
    public function setDescription($v)
    {
        if ($this->getCulture() == stLanguage::getOptLanguage()) stLanguage::setDefaultValue($this, __METHOD__, $v);
        
        parent::setDescription($v);
    }

        /**
     * Przeciążenie getName
     *
     * @return string
     */
    public function getName()
    {
        if ($this->getCulture() == stLanguage::getOptLanguage()) return stLanguage::getDefaultValue($this, __METHOD__);

        $v = parent::getName();
        if (is_null($v)) $v = stLanguage::getDefaultValue($this, __METHOD__);
        return $v;
    }

    /**
     * Przeciążenie setName
     *
     * @param string $v
     */
    public function setName($v)
    {
        if ($this->getCulture() == stLanguage::getOptLanguage()) stLanguage::setDefaultValue($this, __METHOD__, $v);

        parent::setName($v);
    }
}