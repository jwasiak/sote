<?php

/**
 * Subclass for performing query and update operations on the 'st_discount_user' table.
 *
 * 
 *
 * @package plugins.stDiscountPlugin.lib.model
 */ 
class DiscountUserPeer extends BaseDiscountUserPeer
{
    protected static $discounts = array();

    public static function doSelectOneByUser($user)
    {
        if (!isset(self::$discounts[$user->getId()]))
        {
            $c = new Criteria();
            $c->add(DiscountUserPeer::SF_GUARD_USER_ID, $user->getId());
            $discount = self::doSelectOne($c);
            self::$discounts[$user->getId()] = $discount && $discount->getValue() > 0 ? $discount : false;   
        }

        return self::$discounts[$user->getId()] ? self::$discounts[$user->getId()] : null;      
    }
}
