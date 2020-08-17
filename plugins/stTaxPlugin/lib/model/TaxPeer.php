<?php

/**
 * Subclass for performing query and update operations on the 'st_tax' table.
 *
 * 
 *
 * @package plugins.stTaxPlugin.lib.model
 */ 
class TaxPeer extends BaseTaxPeer
{
    public static function doSelectDefaultOne(Criteria $c, $con = null)
    {
        $c = clone $c;

        $c->add(self::IS_DEFAULT, true);

        $tax = self::doSelectOne($c);

        return $tax ? $tax : self::doSelectOne(new Criteria());
    }

    public static function retrieveByTax($value)
    {
        return stTax::getByValue($value);
    }

    public static function doSelectActive()
    {
        $c = new Criteria();
        $c->add(self::IS_ACTIVE, true);

        $rs = self::doSelectRS($c);

        $results = array();

        while($rs->next())
        {
            $tax = new Tax();
            $tax->hydrate($rs);
            $results[$tax->getId()] = $tax;
        }

        return $results;        
    }

    public static function clearCache()
    {
        $cache = new stFunctionCache('stTax');
        $cache->removeAll();      
    }
}
