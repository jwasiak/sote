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
 * @version     $Id: PaymentPeer.php 13693 2011-06-20 07:03:28Z marcin $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/** 
 * Klasa PaymentPeer
 *
 * @package     stPayment
 * @subpackage  libs
 */
class PaymentPeer extends BasePaymentPeer {
    
    public static function doSelectByOrder(Order $order) {
        $c = new Criteria();
        $c->addJoin(PaymentPeer::ID, OrderHasPaymentPeer::PAYMENT_ID);
        $c->add(OrderHasPaymentPeer::ORDER_ID, $order->getId());
        return self::doSelect($c);
    }

    public static function doSelectJoinAllForList(Criteria $c, $con = null) {
        $c = clone $c;
        $c->addJoin(PaymentPeer::ID, OrderHasPaymentPeer::PAYMENT_ID);
        $c->addJoin(OrderHasPaymentPeer::ORDER_ID, OrderPeer::ID);
        return parent::doSelectJoinAll($c, $con);
    }

    public static function retrieveByIdAndHash($id, $hash)
    {
        $payment = self::retrieveByPK($id);

        return null !== $payment && $payment->getHash() == $hash ? $payment : null;
    }   

    public static function retrieveByTransactionId($transactionId)
    {
        $c = new Criteria();
        $c->add(self::TRANSACTION_ID, $transactionId);

        return self::doSelectOne($c);
    }
}
