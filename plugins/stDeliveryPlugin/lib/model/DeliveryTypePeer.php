<?php

/**
 * Subclass for performing query and update operations on the 'st_delivery_type' table.
 *
 * 
 *
 * @package plugins.stDeliveryPlugin.lib.model
 */ 
class DeliveryTypePeer extends BaseDeliveryTypePeer
{
    protected static $arrayCached = null;
    protected static $namesCached = null;
    protected static $typesCached = null;

    public static function doSelectArrayNamesCached()
    {
        if (null === self::$namesCached)
        {
            $results = array();

            foreach (self::doSelectArrayCached() as $id => $value)
            {
                $results[$id] = $value['name'];
            }

            self::$namesCached = $results;
        }

        return self::$namesCached;
    }

    public static function doSelectArrayCached()
    {
        if (null === self::$arrayCached)
        {
            $fc = new stFunctionCache('Delivery');
            self::$arrayCached = $fc->cacheCall(array('DeliveryTypePeer', 'doSelectArray'));
        }

        return self::$arrayCached;        
    }

    public static function retrieveTypeById($id)
    {
        $types = self::doSelectArrayCached();

        return isset($types[$id]) ? $types[$id]['type'] : null;
    }

    public static function retrieveIdByType($type)
    {
        if (null === self::$typesCached)
        {
            $results = array();

            foreach (self::doSelectArrayCached() as $id => $value)
            {
                $results[$value['type']] = $id;
            }

            self::$typesCached = $results;
        }

        return self::$typesCached && isset(self::$typesCached[$type]) ? self::$typesCached[$type] : null;        
    }

    public static function doSelectArray(Criteria $c = null)
    {
        $c = $c ? clone $c : new Criteria();
        $c->addSelectColumn(self::ID);
        $c->addSelectColumn(self::NAME);
        $c->addSelectColumn(self::TYPE);
        $c->addAscendingOrderByColumn(self::NAME);
        $rs = self::doSelectRs($c);

        $tokens = array();

        while($rs->next())
        {
            $row = $rs->getRow();

            $tokens[$row[0]] = array(
                'name' => $row[1],
                'type' => $row[2]
            );
        }

        return $tokens;
    }

    public static function clearCache()
    {
        $fc = new stFunctionCache('Delivery');   
        $fc->removeAll();     
    }
}
