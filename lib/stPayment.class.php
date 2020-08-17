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
 * @version     $Id: stPayment.class.php 14293 2011-07-26 08:16:43Z marcin $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stPayment
 *
 * @package     stPayment
 * @subpackage  libs
 */
class stPayment
{
    /**
     * namespace stPayment
     */
    const SESSION_NAMESPACE = 'soteshop/payment';

    /**
     * Instanacja obiektu stPayment
     * @var stPayment object
     */
    protected static $instance = null;
    /**
     * stPayment
     * @var stPayment object
     */
    private $paymentType = null;

    protected static $logCheck = array();

    /**
     * Tworzenie nowej płatności
     *
     * @param       integer     $userId
     * @param       integer     $paymentTypeId
     * @param         float       $amount
     * @return  integer     numer id płatności
     */
    public function add($userId, $paymentTypeId, $amount)
    {
        $payment = self::newPaymentInstance($paymentTypeId, $amount, array('user_id' => $userId));

        $payment->save();

        return $payment->getId();
    }

    public static function log($namespace, $message)
    {
        $file = sfConfig::get('sf_root_dir').'/log/'.$namespace.'.log';
        
        if (!isset(self::$logCheck[$namespace]))
        {
            if (is_file($file) && filesize($file) > 1024 * 1024 * 5)
            {
                $archive = sfConfig::get('sf_root_dir').'/log/'.$namespace.'.archive.log';

                if (is_file($archive))
                {
                    unlink($archive);
                }

                rename($file, $archive);
            }

            self::$logCheck[$namespace] = true;
        }

        file_put_contents($file, '['.date('d-m-Y H:i:s').'] '.$message."\n", FILE_APPEND);        
    }

    /**
     * Tworzenie nowego powiązania płatności z zamówieniem
     *
     * @param       integer     $orderId
     * @param       integer     $paymentId
     */
    public function addPaymentForOrder($orderId, $paymentId)
    {
        $payment = new OrderHasPayment();
        $payment->setOrderId($orderId);
        $payment->setPaymentId($paymentId);
        $payment->save();
    }

    /**
     * Potwierdzenie płatności
     *
     * @param        string      $hash
     */
    public function confirmPayment($hash)
    {
        $c = new Criteria();
        $c->add(PaymentPeer::HASH, $hash);
        $payment = PaymentPeer::doSelectOne($c);

        if (is_object($payment))
        {
            $payment->setStatus(1);
            $payment->save();
        }
    }

    /**
     * Anulowanie płatności
     *
     * @param        string      $hash
     */
    public function cancelPayment($hash)
    {
        $c = new Criteria();
        $c->add(PaymentPeer::HASH, $hash);
        $payment = PaymentPeer::doSelectOne($c);

        if (is_object($payment))
        {
            $payment->setCancel(1);
            $payment->save();
        }
    }

    /**
     * Incjalizacja klasy stPayment
     *
     * @param        string      $context
     */
    public function initialize($context)
    {
        $this->context = $context;
        $this->paymentType = $context->getUser()->getAttribute('paymentType', null, self::SESSION_NAMESPACE);
    }

    /**
     * Zwraca instancje obiektu
     *
     * @param        string      $context
     * @param         float       $order_sum
     * @return   stDelivery
     */
    public static function getInstance($context)
    {
        if (!isset(self::$instance))
        {
            $class = __CLASS__;
            self::$instance = new $class();
            self::$instance->initialize($context);
        }
        return self::$instance;
    }

    /**
     * Zapisuje numer id płatności dla uzytkownika
     *
     * @param   integer     $id                 Numer id typu płatności
     */
    public function set($id)
    {
        $this->paymentType = PaymentTypePeer::retrieveByPK($id);
        $this->context->getUser()->setAttribute('paymentType', $this->paymentType, self::SESSION_NAMESPACE);
    }

    /**
     * Pobiera obiekt PaymentType dla danego uzytkownika
     *
     * @return  PaymentType object
     */
    public function get()
    {
        if (empty($this->paymentType))
        {
            $c = new Criteria();
            $c->add(PaymentTypePeer::ACTIVE, 1);
            $c->add(PaymentTypePeer::IS_DEFAULT, 1);
            $this->paymentType = PaymentTypePeer::doSelectOne($c);
            if (!is_object($this->paymentType))
            {
                $c = new Criteria();
                $c->add(PaymentTypePeer::ACTIVE, 1);
                $c->add(PaymentTypePeer::MODULE_NAME, 'stStandardPayment');
                $this->paymentType = PaymentTypePeer::doSelectOne($c);
            }
        }
        return $this->paymentType;
    }

    public static function newPaymentInstance($payment_type_id, $amount, $params = array())
    {
        $payment = new Payment();

        if (isset($params['user_id']))
        {
            $payment->setSfGuardUserId($params['user_id']);
        }

        $payment->setPaymentTypeId($payment_type_id);

        $payment->setAmount($amount);

        $payment->setStatus(isset($params['is_paid']) && $params['is_paid']);

        return $payment;
    }
     
    public static function getOrderIdInSummary($context)
    {
        return $context->getRequest()->getParameter('id');
    }

    public static function hasOrderIdInSummary($context)
    {
        return $context->getRequest()->hasParameter('id');
    }

    public static function getUnpayedAmountByOrder($order)
    {
        if ($order instanceof Order)
        {
            $orderId = $order->getId();
        }
        else
        {
            $orderId = $order;
            $order = OrderPeer::retrieveByPK($orderId);
        }

        $totalAmount = $order->getTotalAmountWithDelivery(true, true);

        $orderPayments = $order->getOrderHasPayments();

        if (!$orderPayments)
        {
            return $totalAmount;
        }


        foreach ($orderPayments as $orderPayment)
        {
            if ($orderPayment->getPayment()->getStatus())
            {
                $totalAmount -= $orderPayment->getPayment()->getAmount();
            }
        }

        return stPrice::round($totalAmount >= 0 ? $totalAmount : 0);
    }

    public static function hasPaymentToShow($orderId) {
        $c = new Criteria();
        $c->add(OrderHasPaymentPeer::ORDER_ID, $orderId);
        $c->addJoin(OrderHasPaymentPeer::PAYMENT_ID, PaymentPeer::ID);
        $c->add(PaymentPeer::GIFT_CARD_ID, null, Criteria::ISNULL);

        $orderHasPayment = OrderHasPaymentPeer::doSelectOne($c);
        if (is_object($orderHasPayment)) {
            if ($orderHasPayment->getPayment()->getPaymentType()->getModuleName() != 'stStandardPayment') return true;
        }
        return false;
    }
}