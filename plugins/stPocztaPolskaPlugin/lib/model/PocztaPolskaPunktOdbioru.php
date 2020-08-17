<?php

/**
 * Subclass for representing a row from the 'st_poczta_polska_punkt_odbioru' table.
 *
 * 
 *
 * @package plugins.stPocztaPolskaPlugin.lib.model
 */ 
class PocztaPolskaPunktOdbioru extends BasePocztaPolskaPunktOdbioru
{
    public function getShortName()
    {
        return $this->name.', '.$this->street.' '.$this->zip_code.' '.$this->city;
    }

    public function setPoint($point)
    {
        $this->fromArray($point, BasePeer::TYPE_FIELDNAME);
        $this->setZipCode($point['zipCode']);
        $this->setPaczkaEkstra24($point['paczkaEkstra24']);
    }

    public function getPoint()
    {
        $point = $this->toArray(BasePeer::TYPE_FIELDNAME);
        $point['zipCode'] = $point['zip_code'];
        $point['paczkaEkstra24'] = $point['paczka_ekstra24'];

        unset($point['zip_code']);
        unset($point['paczka_ekstra24']);

        return $point;
    }
 
    public function isPobranie()
    {
        $payment = $this->getOrder()->getOrderPayment();
        return $payment && $payment->getPaymentType() && PocztaPolskaPunktOdbioruPeer::isPobranie($payment->getPaymentType());
    }
}
