<?php

/**
 * Subclass for performing query and update operations on the 'st_discount_has_producer' table.
 *
 * 
 *
 * @package plugins.stDiscountPlugin.lib.model
 */ 
class DiscountHasProducerPeer extends BaseDiscountHasProducerPeer
{
    public static function doSelectProducerForTokenInput(Discount $discount)
    {
        $c = new Criteria();
 
        $c->add(self::DISCOUNT_ID, $discount->getId());
 
        $c->addJoin(self::PRODUCER_ID, ProducerPeer::ID);
 
        $c->addAscendingOrderByColumn(self::PRODUCER_ID);         
 
        return ProducerPeer::doSelectTokens($c);
    } 
}
