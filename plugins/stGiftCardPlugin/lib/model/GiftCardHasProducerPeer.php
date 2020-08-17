<?php

/**
 * Subclass for performing query and update operations on the 'st_gift_card_has_producer' table.
 *
 * 
 *
 * @package plugins.stGiftCardPlugin.lib.model
 */ 
class GiftCardHasProducerPeer extends BaseGiftCardHasProducerPeer
{
    public static function doSelectProducerForTokenInput(GiftCard $giftCard)
    {
        $c = new Criteria();
 
        $c->add(self::GIFT_CARD_ID, $giftCard->getId());
 
        $c->addJoin(self::PRODUCER_ID, ProducerPeer::ID);
 
        $c->addAscendingOrderByColumn(self::PRODUCER_ID); 
 
        return ProducerPeer::doSelectTokens($c);
    } 
}
