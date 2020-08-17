<?php

/**
 * Subclass for representing a row from the 'st_product_options_filter' table.
 *
 * 
 *
 * @package plugins.stProductOptionsPlugin.lib.model
 */ 
class ProductOptionsFilter extends BaseProductOptionsFilter
{
    public function __toString()
    {
        return $this->getName();
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

    public function getPriceFrom($currency = true)
    {
        if (SF_APP == 'frontend' && $currency) {

            return stCurrency::getInstance(sfContext::getInstance())->get()->exchange($this->price_from, false, null);
        }
        return $this->price_from;
    }

    public function getPriceTo($currency = true)
    {
        if (SF_APP == 'frontend' && $currency) {

            return stCurrency::getInstance(sfContext::getInstance())->get()->exchange($this->price_to, false, null);
        }
        return $this->price_to;
    }

    public function save($con = null)
    {
        $ret = parent::save();

        stFunctionCache::getInstance('stProductOptionsPlugin')->removeAll();

        return $ret;
    }

    public function delete($con = null)
    {
        $ret = parent::delete($con);

        stFunctionCache::getInstance('stProductOptionsPlugin')->removeAll();

        return $ret;
    }


}
