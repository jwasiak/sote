<?php

/**
 * Subclass for performing query and update operations on the 'st_poczta_polska_paczka' table.
 *
 * 
 *
 * @package plugins.stPocztaPolskaPlugin.lib.model
 */ 
class PocztaPolskaPaczkaPeer extends BasePocztaPolskaPaczkaPeer
{
    protected static $orderPool = array();

    public static function isPobranie(PaymentType $pt)
    {
        $config = stConfig::getInstance('stPocztaPolskaBackend');
        $payment = $config->get('payment');
        return in_array($pt->getId(), $payment);
    }

    public static function retrieveByOrder(Order $order)
    {
        if (!isset(self::$orderPool[$order->getId()]) && !array_key_exists($order->getId(), self::$orderPool))
        {
            $c = new Criteria();
            $c->add(self::ORDER_ID, $order->getId());

            self::$orderPool[$order->getId()] = self::doSelectOne($c);
        }

        return self::$orderPool[$order->getId()];
    }
}
