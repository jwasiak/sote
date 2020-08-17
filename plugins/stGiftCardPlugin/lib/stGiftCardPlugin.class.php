<?php

class stGiftCardPlugin
{
   const SESSION_NAMESPACE = 'soteshop/stGiftCardPlugin';

   protected static $objectPool = array();

   protected static $basketProductIds = array();

   protected static $hasValidBasketProducts = null;

   public static function calculateAmountLeft($amount, $gift_cards = array())
   {
      $amount -= self::getTotalAmountPaid($gift_cards);
      
      return $amount >= 0 ? $amount : 0;
   }
   
   public static function getTotalAmountPaid($gift_cards = array())
   {
      $total = 0;
      
      if (!$gift_cards)
      {
         $gift_cards = self::get();
      }
      
      foreach ($gift_cards as $gift_card)
      {
         $total += $gift_card->getAmount();
      }   
      
      return $total;
   }
   
   public static function isActive()
   {
      $value = self::get();
      return !empty($value);
   }
   
   public static function get()
   {
      $sf_context = sfContext::getInstance();

      if (!self::$objectPool)
      {
         $gift_cards = $sf_context->getUser()->getAttribute('active', array(), self::SESSION_NAMESPACE);

         if ($gift_cards)
         {
            $currency_id = stCurrency::getInstance($sf_context)->get()->getId();
    
            $c = new Criteria();
            
            $c->add(GiftCardPeer::CURRENCY_ID, $currency_id);
            
            $c->add(GiftCardPeer::ID, $gift_cards, Criteria::IN);
            
            self::$objectPool = GiftCardPeer::doSelect($c);
         }
      }

      // if (self::$objectPool)
      // {
      //    $i18n = $sf_context->getI18N();

      //    foreach (self::$objectPool as $giftcard)
      //    {
      //       if (!$giftcard->isValidOrderAmount($sf_context->getUser()->getBasket()->getTotalAmount(true, true)))
      //       {
      //          sfLoader::loadHelpers(array('Helper', 'stCurrency'));
      //          $sf_context->getActionStack()->getLastEntry()->getActionInstance()->setFlash('st_gift_card_error', $i18n->__('Musisz złożyć zamówienie za minimum %%amount%%', array(
      //          '%%amount%%' => st_currency_format($giftcard->getMinOrderAmount(), array('digits' => 0))
      //          ), 'stGiftCardFrontend'));
      //          self::remove($giftcard);
      //       }
      //       elseif (!self::hasValidBasketProducts($giftcard))
      //       {
      //          $sf_context->getActionStack()->getLastEntry()->getActionInstance()->setFlash('st_gift_card_error', $i18n->__('Bon o kodzie %%code%% nie może być zrealizowany z produktami znajdującymi się w koszyku', array('%%code%%' => $giftcard->getCode()), 'stGiftCardFrontend'));  
      //          self::remove($giftcard);             
      //       }
      //    }
      // }

      return self::$objectPool;
   }

   public static function has(GiftCard $gift_card = null)
   {
      $gift_cards = sfContext::getInstance()->getUser()->getAttribute('active', array(), self::SESSION_NAMESPACE);

      return isset($gift_cards[$gift_card->getCode()]) && self::isActive();
   }

   public static function add(GiftCard $gift_card)
   {
      $user = sfContext::getInstance()->getUser();

      $gift_cards = $user->getAttribute('active', array(), self::SESSION_NAMESPACE);

      $gift_cards[$gift_card->getCode()] = $gift_card->getId();

      $user->setAttribute('active', $gift_cards, self::SESSION_NAMESPACE);

      self::$objectPool = array();
   }

   public static function remove(GiftCard $gift_card)
   {
      $user = sfContext::getInstance()->getUser();

      $gift_cards = $user->getAttribute('active', array(), self::SESSION_NAMESPACE);

      unset($gift_cards[$gift_card->getCode()]);

      $user->setAttribute('active', $gift_cards, self::SESSION_NAMESPACE);

      self::$objectPool = array();
   }
   
   public static function clear()
   {
      sfContext::getInstance()->getUser()->setAttribute('active', array(), self::SESSION_NAMESPACE);
   }

   public static function hasValidBasketProducts(GiftCard $giftCard, array &$invalidBasketItemIds = null)
   {
      if (null === self::$hasValidBasketProducts)
      {
         if (null === $giftCard->getAllowAllProducts() || $giftCard->getAllowAllProducts())
         {
            self::$hasValidBasketProducts = array('valid' => true, 'invalidIds' => array());
            $invalidBasketItemIds = array();
         }
         else
         {
            $ok = array();
            
            $ids = array();

            $itemIds = array();

            foreach (sfContext::getInstance()->getUser()->getBasket()->getItems() as $item)
            {
               /**
                * @var Product $product
               */
               $product = $item->getProduct();

               if ($product && !$product->getIsGift())
               {
                  if (!in_array($item->getProductId(), $ids))
                  {
                     $ids[] = $item->getProductId();
                     $itemIds[] = $item->getItemId();
                  }
               }
            }

            $c = new Criteria();
            $c->addSelectColumn(GiftCardHasProductPeer::PRODUCT_ID);
            $c->add(GiftCardHasProductPeer::GIFT_CARD_ID, $giftCard->getId());
            $c->add(GiftCardHasProductPeer::PRODUCT_ID, $ids, Criteria::IN);

            $rs = GiftCardHasProductPeer::doSelectRS($c);

            while($rs->next())
            {
               $row = $rs->getRow();
               $ok[$row[0]] = $row[0];
            }

            $c = new Criteria();
            $c->addSelectColumn(ProductHasCategoryPeer::PRODUCT_ID);
            $c->addJoin(GiftCardHasCategoryPeer::CATEGORY_ID, ProductHasCategoryPeer::CATEGORY_ID);
            $c->add(GiftCardHasCategoryPeer::GIFT_CARD_ID, $giftCard->getId());
            $c->add(ProductHasCategoryPeer::PRODUCT_ID, $ids, Criteria::IN);
            $rs = GiftCardHasCategoryPeer::doSelectRS($c);

            while($rs->next())
            {
               $row = $rs->getRow();
               $ok[$row[0]] = $row[0];
            }

            $c = new Criteria();
            $c->addSelectColumn(ProductPeer::ID);
            $c->addJoin(GiftCardHasProducerPeer::PRODUCER_ID, ProductPeer::PRODUCER_ID);
            $c->add(GiftCardHasProducerPeer::GIFT_CARD_ID, $giftCard->getId());
            $c->add(ProductPeer::ID, $ids, Criteria::IN);
            $rs = GiftCardHasProducerPeer::doSelectRS($c);

            while($rs->next())
            {
               $row = $rs->getRow();
               $ok[$row[0]] = $row[0];
            }

            self::$hasValidBasketProducts = array('valid' => count($ok) == count($ids));

            if (!self::$hasValidBasketProducts['valid'])
            {
               $invalidIds = array_diff($ids, $ok);
               $invalidBasketItemIds = array_intersect_key($itemIds, $invalidIds);
            }
            else
            {
               $invalidBasketItemIds = array();
            }

            self::$hasValidBasketProducts['invalidIds'] = $invalidBasketItemIds;
         }
      }
      else
      {
         $invalidBasketItemIds = self::$hasValidBasketProducts['invalidIds'];
      }

      return self::$hasValidBasketProducts['valid'];
   }
}