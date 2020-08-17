<?php

/**
 * Subclass for representing a row from the 'st_basic_price_unit_measure' table.
 *
 * 
 *
 * @package plugins.stBasicPricePlugin.lib.model
 */ 
class BasicPriceUnitMeasure extends BaseBasicPriceUnitMeasure
{
    public function __toString()
    {
        return $this->getUnitSymbol();
    }

    public function save($con = null)
    {
        $ret = parent::save($con);

        BasicPriceUnitMeasurePeer::clearCache();

        return $ret;
    }

    public function delete($con = null)
    {
        $ret = parent::delete($con);

        BasicPriceUnitMeasurePeer::clearCache();

        return $ret;
    }    
}
