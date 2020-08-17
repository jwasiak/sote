<?php

/**
 * Subclass for performing query and update operations on the 'st_poczta_polska_punkt_odbioru' table.
 *
 * 
 *
 * @package plugins.stPocztaPolskaPlugin.lib.model
 */ 
class PocztaPolskaPunktOdbioruPeer extends BasePocztaPolskaPunktOdbioruPeer
{
    public static function isPobranie(PaymentType $pt)
    {
        $config = stConfig::getInstance('stPocztaPolskaBackend');
        $payment = $config->get('payment');
        return $payment && in_array($pt->getId(), $payment);
    } 
}
