<?php

/**
 * Subclass for performing query and update operations on the 'st_basic_price_unit_measure' table.
 *
 * 
 *
 * @package plugins.stBasicPricePlugin.lib.model
 */ 
class BasicPriceUnitMeasurePeer extends BaseBasicPriceUnitMeasurePeer
{
    protected static $cached = null;

    public static function retrieveCachedArrayByPK($id)
    {
        if (null === self::$cached)
        {
            $fc = new stFunctionCache('BasicPrice');
            self::$cached = $fc->cacheCall(array('BasicPriceUnitMeasurePeer' , 'retrieveArrayByPK'), array($id));
        }

        return isset(self::$cached[$id]) ? self::$cached[$id] : null;
    }

    public static function retrieveArrayByPK($id)
    {
        $c = new Criteria();
        $c->addSelectColumn(self::ID);
        $c->addSelectColumn(self::MULTIPLIER);
        $c->addSelectColumn(self::UNIT_SYMBOL);
        $rs = self::doSelectRs($c);

        return self::hydrate($rs);
    }

    public static function clearCache()
    {
        $fc = new stFunctionCache('BasicPrice');
        $fc->removeAll();
    }

    protected static function hydrate(ResultSet $rs)
    {
        $results = array();

        while($rs->next())
        {
            $row = $rs->getRow();
            $results[$row[0]] = array(
                'multiplier' => $row[1],
                'unit' => $row[2]
            );
        }

        return $results;
    }
}
