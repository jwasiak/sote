<?php

/**
 * Subclass for performing query and update operations on the 'st_product_dimension' table.
 *
 * 
 *
 * @package lib.model
 */ 
class ProductDimensionPeer extends BaseProductDimensionPeer
{
    protected static $namesCached = null;
    public static function doSelectNamesCached()
    {
        if (null === self::$namesCached)
        {
            $fc = new stFunctionCache('ProductDimension');
            self::$namesCached = $fc->cacheCall(array('ProductDimensionPeer', 'doSelectNames'));
        }

        return self::$namesCached;
    }

    public static function doSelectNames(Criteria $c = null)
    {
        $c = $c ? clone $c : new Criteria;
        $c->addAscendingOrderByColumn(self::NAME);
        $rs = self::doSelectRs($c);

        $results = array();

        while($rs->next())
        {
            $row = $rs->getRow();
            $results[$row[0]] = $row[1].' ('.$row[2].'x'.$row[3].'x'.$row[4].' cm)';
        }

        return $results;        
    }

    public function clearCache()
    {
        $fc = new stFunctionCache('ProductDimension');
        $fc->removeAll();
    }
}
