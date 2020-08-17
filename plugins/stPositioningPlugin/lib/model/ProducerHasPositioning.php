<?php

/**
 * Subclass for representing a row from the 'st_producer_has_positioning' table.
 *
 * 
 *
 * @package plugins.stPositioningPlugin.lib.model
 */ 
class ProducerHasPositioning extends BaseProducerHasPositioning
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

    public function setProducerUrl($v)
    {
        $this->getProducer()->setUrl($v);
    }
}
