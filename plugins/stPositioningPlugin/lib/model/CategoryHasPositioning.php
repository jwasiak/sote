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
 * @version     $Id: CategoryHasPositioning.php 10204 2011-01-13 11:06:34Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa CategoryHasPositioning
 *
 * @package     stPositioningPlugin
 * @subpackage  libs
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */
class CategoryHasPositioning extends BaseCategoryHasPositioning
{
    public function setCategoryUrl($v)
    {
        $this->getCategory()->setUrl($v);
    }

    public function getCategoryPath()
    {
        $categories = $this->getCategory()->getPath();

        $culture = $this->getCategory()->getCulture();

        $path = array();

        foreach ($categories as $category)
        {
            $category->setCulture($culture);

            $path[] = $category->getName();
        }

        $path[] = $this->getCategory()->getName();

        return implode("/", $path);
    }

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
        if ($this->getCulture() == stLanguage::getOptLanguage())
        {
            $v = stLanguage::getDefaultValue($this, __METHOD__);
            if (is_null($v))
            {
                if(strlen($this->getTitle()) != 0 || strlen($this->getKeywords()) != 0 || strlen($this->getDescription()) != 0)
                {
                    $v = stPositioning::TYPE_USER;
                } else {
                    $v = stPositioning::TYPE_GENERATE;
                }
            }
            return $v;
        }

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
}