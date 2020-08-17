<?php

/**
 * Subclass for representing a row from the 'st_box' table.
 *
 * 
 *
 * @package plugins.stBoxPlugin.lib.model
 */ 
class Box extends BaseBox
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
     * Przeciążenie getName
     *
     * @return string
     */
    public function getName()
    {
        if ($this->getCulture() == stLanguage::getOptLanguage())
        {
            return stLanguage::getDefaultValue($this, __METHOD__);   
        }   
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
        if ($this->getCulture() == stLanguage::getOptLanguage())
        {
            stLanguage::setDefaultValue($this, __METHOD__, $v);
        }
        
        parent::setName($v);
    }
    
    /**
     * Przeciążenie getContent
     *
     * @return string
     */
    public function getContent()
    {
        if ($this->getCulture() == stLanguage::getOptLanguage())
        {
            return stLanguage::getDefaultValue($this, __METHOD__);   
        }   
        $v = parent::getContent();
        if (is_null($v)) $v = stLanguage::getDefaultValue($this, __METHOD__);
        return $v;
    }
    
    /**
     * Przeciążenie setContent
     * 
     * @param string $v
     */
    public function setContent($v)
    {
        if ($this->getCulture() == stLanguage::getOptLanguage())
        {
            stLanguage::setDefaultValue($this, __METHOD__, $v);
        }
        
        parent::setContent($v);
    }

    public function save($con = null)
    {
        if (SF_APP != 'update' && sfContext::hasInstance() && ($this->isColumnModified(BoxPeer::ACTIVE) || $this->isColumnModified(BoxPeer::BOX_GROUP_ID)))
        {
            stTheme::clearSmartyCache();
        }

        return parent::save($con);
    }

    public function delete($con = null)
    {
        stTheme::clearSmartyCache();

        return parent::delete($con);
    }
}
