<?php

/**
 * Subclass for performing query and update operations on the 'st_discount_coupon_code_has_category' table.
 *
 * 
 *
 * @package plugins.stDiscountPlugin.lib.model
 */ 
class DiscountCouponCodeHasCategoryPeer extends BaseDiscountCouponCodeHasCategoryPeer
{
    public static function doSelectCategoriesForTokenInput(DiscountCouponCode $discount)
    {
        $c = new Criteria();
 
        $c->add(self::DISCOUNT_COUPON_CODE_ID, $discount->getId());
 
        $c->addJoin(self::CATEGORY_ID, CategoryPeer::ID);

        $c->add(self::IS_OPT, false);
 
        $c->addAscendingOrderByColumn(self::CATEGORY_ID); 
 
        return CategoryPeer::doSelectCategoriesTokens($c);
    } 
}
