<?php

/**
 * Subclass for performing query and update operations on the 'st_gift_card' table.
 *
 * 
 *
 * @package plugins.stGiftCardPlugin.lib.model
 */ 
class GiftCardPeer extends BaseGiftCardPeer
{
   const STATUS_ACTIVE = 'A';
   const STATUS_PENDING = 'P';
   const STATUS_USED = 'U';
   
   public static function retrieveByCode($code, $con = null)
   {
      $c = new Criteria();
      
      $c->add(self::CODE, $code);
      
      return self::doSelectOne($c, $con);
   }
   
   public static function doSelectByOrder($order)
   {
      $c = new Criteria();
      
      $c->addJoin(self::ID, PaymentPeer::GIFT_CARD_ID);
      
      $c->addJoin(PaymentPeer::ID, OrderHasPaymentPeer::PAYMENT_ID);
      
      $c->add(OrderHasPaymentPeer::ORDER_ID, is_object($order) ? $order->getId() : $order);
      
      return self::doSelect($c);
   }
}
