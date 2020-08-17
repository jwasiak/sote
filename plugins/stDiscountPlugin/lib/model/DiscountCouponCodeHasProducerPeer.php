<?php

/**
 * Subclass for performing query and update operations on the 'st_discount_coupon_code_has_producer' table.
 *
 * 
 *
 * @package plugins.stDiscountPlugin.lib.model
 */ 
class DiscountCouponCodeHasProducerPeer extends BaseDiscountCouponCodeHasProducerPeer
{
    public static function doSelectProducerForTokenInput(DiscountCouponCode $discount)
    {
        $c = new Criteria();
 
        $c->add(self::DISCOUNT_COUPON_CODE_ID, $discount->getId());
 
        $c->addJoin(self::PRODUCER_ID, ProducerPeer::ID);
 
        $c->addAscendingOrderByColumn(self::PRODUCER_ID); 
 
        return ProducerPeer::doSelectTokens($c);
    } 
}
