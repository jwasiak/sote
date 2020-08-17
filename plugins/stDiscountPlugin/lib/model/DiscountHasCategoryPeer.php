<?php

/**
 * Subclass for performing query and update operations on the 'st_discount_has_category' table.
 *
 * 
 *
 * @package plugins.stDiscountPlugin.lib.model
 */ 
class DiscountHasCategoryPeer extends BaseDiscountHasCategoryPeer
{
    public static function doSelectCategoriesForTokenInput(Discount $discount)
    {   
        $c = new Criteria();
 
        $c->add(self::DISCOUNT_ID, $discount->getId());

        $c->add(self::IS_OPT, false);
 
        $c->addJoin(self::CATEGORY_ID, CategoryPeer::ID);
 
        $c->addAscendingOrderByColumn(self::CATEGORY_ID); 
 
        return CategoryPeer::doSelectCategoriesTokens($c);
    } 
}
