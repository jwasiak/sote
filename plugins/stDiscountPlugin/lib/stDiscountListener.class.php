<?php

/**
 * SOTESHOP/stDiscountPlugin
 *
 * Ten plik należy do aplikacji stDiscountPlugin opartej na licencji (Professional License SOTE).
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stDiscountPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stDiscountListener.class.php 10157 2011-01-12 09:30:11Z piotr $
 */
class stDiscountListener
{
   public static function generateStProduct(sfEvent $event)
   {
      $event->getSubject()->attachAdminGeneratorFile('stDiscountPlugin', 'stProductDiscount.yml');
   }

   public static function generateStUser(sfEvent $event)
   {
      $event->getSubject()->attachAdminGeneratorFile('stDiscountPlugin', 'stUserDiscount.yml');
   }

   public static function getPrice(sfEvent $event)
   {
      stDiscount::setDiscountForProduct($event->getSubject());
   }

   public static function orderPostDelete($order, $con)
   {
      self::orderPostSave($order, $con);
   }

   public static function orderPostSave($order, $con)
   {
   	  $user_id = $order->getSfGuardUserId();
   	  if (!empty($user_id)) 
   	  {
	      $sum = stDiscount::getOrderSumForUser($order);
	
	      $c2 = new Criteria();
	      $c2->add(DiscountRangePeer::DISCOUNT_ID, null, Criteria::ISNOTNULL);
	      $c2->add(DiscountRangePeer::TOTAL_VALUE, $sum, Criteria::LESS_EQUAL);
	      $c2->addDescendingOrderByColumn(DiscountRangePeer::TOTAL_VALUE);
	
	      $discount = DiscountRangePeer::doSelectOne($c2);
	
	      if ($discount)
	      {
	         stDiscount::AddUserDiscount($user_id, $discount->getDiscountId());
	      }
	      else
	      {
	         $c = new Criteria();
	         $c->add(UserHasDiscountPeer::SF_GUARD_USER_ID, $user_id);
	         $c->add(UserHasDiscountPeer::AUTO, true);
	         UserHasDiscountPeer::doDelete($c);
	      }
   	  }
   }

   public static function preGetAlldiscountOrCreate(sfEvent $event)
   {
      $event->setProcessed(true);

      if ($event->getSubject()->getRequestParameter('id'))
      {
         $event->getSubject()->discount_user = DiscountUserPeer::retrieveByPk($event->getSubject()->getRequestParameter('id'));
      }
      else
      {

         $c = new Criteria();
         $c->add(DiscountUserPeer::SF_GUARD_USER_ID, $event->getSubject()->getRequestParameter('user_id'));
         $event->getSubject()->discount_user = DiscountUserPeer::doSelectOne($c);

         if (!is_object($event->getSubject()->discount_user))
            $event->getSubject()->discount_user = new DiscountUser();
      }
   }

   public static function preExecuteProductDiscountAddGroup(sfEvent $event)
   {
      if (count($event->getSubject()->getRequestParameter('discount[selected]', array())) == 0)
         $event->getSubject()->redirect($event->getSubject()->getRequest()->getReferer());
   }

   public static function preExecuteUserDiscountAddGroup(sfEvent $event)
   {
      if (count($event->getSubject()->getRequestParameter('discount[selected]', array())) == 0)
         $event->getSubject()->redirect($event->getSubject()->getRequest()->getReferer());
   }

   /**
    * Automatycznie przypisz rabaty podczas rejesracji
    * @param object $modelInstance
    * @param object $con
    */
   public static function preSaveUser($modelInstance, $con)
   {
      if ($modelInstance->isNew())
      {
         $c = new Criteria();
         $c->add(DiscountPeer::AUTO_ACTIVE, 0, Criteria::NOT_EQUAL);

         foreach (DiscountPeer::doSelect($c) as $discount)
         {
            $hasDiscount = new UserHasDiscount();
            $hasDiscount->setDiscount($discount);
            $modelInstance->addUserHasDiscount($hasDiscount);
         }
      }
   }

   public static function postExecuteUserPanelMenu(sfEvent $event)
   {
      $user = sfContext::getInstance()->getUser()->getGuardUser();

      if (is_object($user))
      {
         $c = new Criteria();
         $c->add(DiscountUserPeer::SF_GUARD_USER_ID, $user->getId());
         $userDiscount = DiscountUserPeer::doSelectOne($c);

         $c = new Criteria();
         $c->add(UserHasDiscountPeer::SF_GUARD_USER_ID, $user->getId());
         $c->addJoin(DiscountPeer::ID, UserHasDiscountPeer::DISCOUNT_ID);
         $c->add(DiscountPeer::ACTIVE, true);
         $discounts = DiscountPeer::doCount($c);

         if ($discounts || (is_object($userDiscount) && $userDiscount->getDiscount()))
         {
            $event->getSubject()->panel_navigator->addTab(__('Rabaty', '', 'stDiscountFrontend'), 'stDiscountFrontend', 'discountInfo', null, 'discountInfo');
         }
      }
   }

   /**
    *  Duplikowanie rabatu produktu
    */
   public static function postExecuteDuplicate(sfEvent $event)
   {
      $c = new Criteria();
      $c->add(DiscountHasProductPeer::PRODUCT_ID, $event['id']);
      $discount_has_products = DiscountHasProductPeer::doSelect($c);
      foreach ($discount_has_products as $discount_has_product)
      {
         $duplicate_discount_has_product = $discount_has_product->copy();
         $duplicate_discount_has_product->setDiscountId($discount_has_product->getDiscountId());
         $duplicate_discount_has_product->setProductId($event['duplicate_id']);
         $duplicate_discount_has_product->save();
      }
   }
}

