<?php

/**
 * Subclass for representing a row from the 'st_delivery_has_payment_type' table.
 *
 *
 *
 * @package plugins.stDeliveryPlugin.lib.model
 */
class DeliveryHasPaymentType extends BaseDeliveryHasPaymentType
{
    protected static
            $currency = null,
            $tax = array();

    public function  __construct()
    {
        if (null === self::$currency && SF_APP == 'frontend')
        {
            self::$currency = stCurrency::getInstance(sfContext::getInstance())->get();
        }
    }

    public function getFreeFrom()
    {
        if (SF_APP == 'frontend' && sfContext::getInstance()->getUser()->hasVatEu())
        {
            return stPrice::extract(parent::getFreeFrom(), $this->getVat(false));
        }

        return $this->format(parent::getFreeFrom());
    }

    public function getCost()
    {
        return $this->format(parent::getCost());
    }

    public function getCostNetto($with_currency = false)
    {
        $v = $this->getCost();

        if ($with_currency)
        {
            $v = self::$currency->exchange($v);
        }

        return $v;
    }

    public function setCostNetto($v)
    {
        $this->setCost($v);
    }

    public function getTax($con = null, $with_eu_tax = true)
    {
        if (SF_APP == 'frontend' && $with_eu_tax && sfContext::getInstance()->getUser()->hasVatEu())
        {
            return TaxPeer::retrieveByTax(0);
        }

        $id = $this->delivery_id;

        if (!isset(self::$tax[$id]))
        {
            self::$tax[$id] = $this->getDelivery()->getTax(null, $with_eu_tax);
        }

        return self::$tax[$id];
    }

    public function getVat($with_eu_tax = true)
    {
        return $this->getTax(null, $with_eu_tax)->getVat();
    }

    public function getCostBrutto($with_currency = false)
    {
        $v = parent::getCostBrutto();

        if (null === $v)
        {
            $v = stPrice::calculate($this->getCostNetto(), $this->getTax()->getVat());

            $this->setCostBrutto($v);
        }

        if ($with_currency)
        {
            $v = self::$currency->exchange($v);
        }

        return $this->format($v);
    }

    public function getCourierCost($with_currency = false)
    {
        $v = parent::getCourierCost();

        if ($with_currency)
        {
            $v = self::$currency->exchange($v);
        }

        return $this->format($v);
    }    

    public function getPayment()
    {
        return $this->getPaymentType();
    }

    public function getPaymentType($con = null)
    {
        if (null === $this->aPaymentType)
        {
            $payments = PaymentTypePeer::doSelectCached();

            $this->aPaymentType = isset($payments[$this->getPaymentTypeId()]) ? $payments[$this->getPaymentTypeId()] : null;
        }

        return $this->aPaymentType;
    }

    protected function format($v)
    {
        $v = $v ? $v : 0.00;

        if (is_numeric($v))
        {
            return stCurrency::formatPrice($v);
        }

        return $v;
    }
}
