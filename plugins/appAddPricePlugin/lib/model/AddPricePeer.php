<?php

/**
 * Subclass for performing query and update operations on the 'app_add_price' table.
 *
 * 
 *
 * @package plugins.appAddPricePlugin.lib.model
 */ 
class AddPricePeer extends BaseAddPricePeer
{
    public static function addJoinCriteria(Criteria $c, Currency $currency)
    {
        $c->addJoin(ProductPeer::ID, sprintf('%s and %s = %s', AddPricePeer::ID, AddPricePeer::CURRENCY_ID, $currency->getId()), Criteria::LEFT_JOIN);
    }

    public static function exists($id, $currency_id)
    {
        $c = new Criteria();
        $c->add(self::ID, $id);
        $c->add(self::CURRENCY_ID, $currency_id);

        return self::doCount($c) > 0;
    }
}
