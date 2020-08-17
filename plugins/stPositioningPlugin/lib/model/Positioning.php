<?php
/**
 * SOTESHOP/stPositioningPlugin
 *
 * Ten plik należy do aplikacji stPositioningPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stPositioningPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: Positioning.php 10204 2011-01-13 11:06:34Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa Positioning
 *
 * @package     stPositioningPlugin
 * @subpackage  libs
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */
class Positioning extends BasePositioning
{
    /**
     * Przeciążenie metody hydrate
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
     * Przeciążenie metody getType
     *
     * @return string
     */
    public function getType()
    {
        if ($this->getCulture() == stLanguage::getOptLanguage()) return stLanguage::getDefaultValue($this, __METHOD__);

        $v = parent::getType();
        if (is_null($v)) $v = stLanguage::getDefaultValue($this, __METHOD__);
        return $v;
    }

    /**
     * Przeciążenie metody setType
     *
     * @param string $v
     */
    public function setType($v)
    {
        if ($this->getCulture() == stLanguage::getOptLanguage()) stLanguage::setDefaultValue($this, __METHOD__, $v);
        parent::setType($v);
    }

    /**
     * Przeciążenie metody getTitle
     *
     * @return string
     */
    public function getTitle()
    {
        if ($this->getCulture() == stLanguage::getOptLanguage()) return stLanguage::getDefaultValue($this, __METHOD__);

        $v = parent::getTitle();
        if (is_null($v)) $v = stLanguage::getDefaultValue($this, __METHOD__);
        return $v;
    }

    /**
     * Przeciążenie metody setTitle
     *
     * @param string $v
     */
    public function setTitle($v)
    {
        if ($this->getCulture() == stLanguage::getOptLanguage()) stLanguage::setDefaultValue($this, __METHOD__, $v);
        parent::setTitle($v);
    }

    /**
     * Przeciążenie metody getTitle
     *
     * @return string
     */
    public function getTitleProduct()
    {
        if ($this->getCulture() == stLanguage::getOptLanguage()) return stLanguage::getDefaultValue($this, __METHOD__);

        $v = parent::getTitleProduct();
        if (is_null($v)) $v = stLanguage::getDefaultValue($this, __METHOD__);
        return $v;
    }

    /**
     * Przeciążenie metody setTitle
     *
     * @param string $v
     */
    public function setTitleProduct($v)
    {
        if ($this->getCulture() == stLanguage::getOptLanguage()) stLanguage::setDefaultValue($this, __METHOD__, $v);
        parent::setTitleProduct($v);
    }


    /**
     * Przeciążenie metody getTitle
     *
     * @return string
     */
    public function getTitleCategory()
    {
        if ($this->getCulture() == stLanguage::getOptLanguage()) return stLanguage::getDefaultValue($this, __METHOD__);

        $v = parent::getTitleCategory();
        if (is_null($v)) $v = stLanguage::getDefaultValue($this, __METHOD__);
        return $v;
    }

    /**
     * Przeciążenie metody setTitle
     *
     * @param string $v
     */
    public function setTitleCategory($v)
    {
        if ($this->getCulture() == stLanguage::getOptLanguage()) stLanguage::setDefaultValue($this, __METHOD__, $v);
        parent::setTitleCategory($v);
    }

    /**
     * Przeciążenie metody getTitle
     *
     * @return string
     */
    public function getTitleManufacteur()
    {
        if ($this->getCulture() == stLanguage::getOptLanguage()) return stLanguage::getDefaultValue($this, __METHOD__);

        $v = parent::getTitleManufacteur();
        if (is_null($v)) $v = stLanguage::getDefaultValue($this, __METHOD__);
        return $v;
    }

    /**
     * Przeciążenie metody setTitle
     *
     * @param string $v
     */
    public function setTitleManufacteur($v)
    {
        if ($this->getCulture() == stLanguage::getOptLanguage()) stLanguage::setDefaultValue($this, __METHOD__, $v);
        parent::setTitleManufacteur($v);
    }

        /**
     * Przeciążenie metody getTitle
     *
     * @return string
     */
    public function getTitleBlog()
    {
        if ($this->getCulture() == stLanguage::getOptLanguage()) return stLanguage::getDefaultValue($this, __METHOD__);

        $v = parent::getTitleBlog();
        if (is_null($v)) $v = stLanguage::getDefaultValue($this, __METHOD__);
        return $v;
    }

    /**
     * Przeciążenie metody setTitle
     *
     * @param string $v
     */
    public function setTitleBlog($v)
    {
        if ($this->getCulture() == stLanguage::getOptLanguage()) stLanguage::setDefaultValue($this, __METHOD__, $v);
        parent::setTitleBlog($v);
    }

            /**
     * Przeciążenie metody getTitle
     *
     * @return string
     */
    public function getTitleProductGroup()
    {
        if ($this->getCulture() == stLanguage::getOptLanguage()) return stLanguage::getDefaultValue($this, __METHOD__);

        $v = parent::getTitleProductGroup();
        if (is_null($v)) $v = stLanguage::getDefaultValue($this, __METHOD__);
        return $v;
    }

    /**
     * Przeciążenie metody setTitle
     *
     * @param string $v
     */
    public function setTitleProductGroup($v)
    {
        if ($this->getCulture() == stLanguage::getOptLanguage()) stLanguage::setDefaultValue($this, __METHOD__, $v);
        parent::setTitleProductGroup($v);
    }

     /**
     * Przeciążenie metody getTitle
     *
     * @return string
     */
    public function getTitleWebpage()
    {
        if ($this->getCulture() == stLanguage::getOptLanguage()) return stLanguage::getDefaultValue($this, __METHOD__);

        $v = parent::getTitleWebpage();
        if (is_null($v)) $v = stLanguage::getDefaultValue($this, __METHOD__);
        return $v;
    }

    /**
     * Przeciążenie metody setTitle
     *
     * @param string $v
     */
    public function setTitleWebpage($v)
    {
        if ($this->getCulture() == stLanguage::getOptLanguage()) stLanguage::setDefaultValue($this, __METHOD__, $v);
        parent::setTitleWebpage($v);
    }

    /**
     * Przeciążenie metody getKeywords
     *
     * @return string
     */
    public function getKeywords()
    {
        if ($this->getCulture() == stLanguage::getOptLanguage()) return stLanguage::getDefaultValue($this, __METHOD__);

        $v = parent::getKeywords();
        if (is_null($v)) $v = stLanguage::getDefaultValue($this, __METHOD__);
        return $v;
    }

    /**
     * Przeciążenie metody setKeywords
     *
     * @param string $v
     */
    public function setKeywords($v)
    {
        if ($this->getCulture() == stLanguage::getOptLanguage()) stLanguage::setDefaultValue($this, __METHOD__, $v);
        parent::setKeywords($v);
    }

    /**
     * Przeciążenie metody getDescription
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
     * Przeciążenie metody setDescription
     *
     * @param string $v
     */
    public function setDescription($v)
    {
        if ($this->getCulture() == stLanguage::getOptLanguage()) stLanguage::setDefaultValue($this, __METHOD__, $v);
        parent::setDescription($v);
    }

/**
     * Przeciążenie zapisu
     */
    public function save($con = null)
    {
        $stCache = new stFunctionCache('stPositioningPlugin');
        $stCache->clearFunction('getDefaultValues');
        
        return parent::save($con);
    }
}