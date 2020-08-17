<?php

/**
 * Subclass for representing a row from the 'st_box_group' table.
 *
 * 
 *
 * @package plugins.stBoxPlugin.lib.model
 */ 
class BoxGroup extends BaseBoxGroup
{
        /**
     * Pobieranie nazwy
     *
     * @return   string
     */
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Zapisuje wartości domyślne dla zapisanej strony
     *
     * @param   string      domyślna           wartość stron $page
     */
    public function setDefaultGroupBox($box_group)
    {
        if ($box_group=="NONE") $box_group=NULL;
        $this->setBoxGroup($box_group);
    }

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
    
}
