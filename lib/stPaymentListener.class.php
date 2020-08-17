<?php

/**
 * SOTESHOP/stPayment 
 * 
 * Ten plik należy do aplikacji stPayment opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stPayment
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stPaymentListener.class.php 14099 2011-07-13 07:26:40Z marcin $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stPaymentListener
 *
 * @package     stPayment
 * @subpackage  libs
 */
class stPaymentListener
{

   /**
    * Przeciazanie zapisywania zamówienia
    *
    * @param       sfEvent     $event
    */
   public static function saveOrder(sfEvent $event)
   {
      $action = $event->getSubject();

      $order = $action->order;

      $left_to_pay = stPayment::getUnpayedAmountByOrder($order);

      if ($left_to_pay > 0 || !$order->getOrderHasPayments())
      {
         // $stPayment = new stPayment();

         $basket = stBasket::getInstance($action->getUser());

         $delivery = stDeliveryFrontend::getInstance($basket);
        
         // $paymentId = $stPayment->add($order->getGuardUser()->getId(), $delivery->getDefaultDelivery()->getDefaultPayment()->getId(), $left_to_pay);

         $paymentType = $delivery->getDefaultDelivery()->getDefaultPayment()->getPayment();

         $payment = stPayment::newPaymentInstance($paymentType->getId(), $left_to_pay, array('user_id' => $order->getGuardUser()->getId()));

         $payment->setConfiguration($paymentType->getConfiguration());

         $ohp = new OrderHasPayment();
         $ohp->setOrder($order);
         $ohp->setPayment($payment);
         $ohp->save();

         $order->setOrderPayment($payment);
      }
   }

}