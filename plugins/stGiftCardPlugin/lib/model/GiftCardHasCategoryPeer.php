<?php

/**
 * Subclass for performing query and update operations on the 'st_gift_card_has_category' table.
 *
 * 
 *
 * @package plugins.stGiftCardPlugin.lib.model
 */ 
class GiftCardHasCategoryPeer extends BaseGiftCardHasCategoryPeer
{
    public static function doSelectCategoriesForTokenInput(GiftCard $giftCard)
    {
        $c = new Criteria();
 
        $c->add(self::GIFT_CARD_ID, $giftCard->getId());

        $c->add(self::IS_OPT, false);
 
        $c->addJoin(self::CATEGORY_ID, CategoryPeer::ID);
 
        $c->addAscendingOrderByColumn(self::CATEGORY_ID); 
 
        return CategoryPeer::doSelectCategoriesTokens($c);
    } 
}
