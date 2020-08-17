<?php

/**
 * Subclass for representing a row from the 'st_delivery_sections' table.
 *
 *
 *
 * @package plugins.stDeliveryPlugin.lib.model
 */
class DeliverySections extends BaseDeliverySections
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

    public function setFrom($v)
    {
        $this->setValueFrom($v);
    }

    public function setCost($v)
    {
        $this->setAmount($v);
    }

    public function getCostNetto($with_currency = false)
    {
        $v = $this->getAmount();

        if ($with_currency)
        {
            $v = self::$currency->exchange($v);
        }

        return $v;
    }

    public function setCostNetto($v)
    {
        $this->setAmount($v);
    }

    public function getTax()
    {
        if (SF_APP == 'frontend' && (sfContext::getInstance()->getUser()->hasVatEu() || sfContext::getInstance()->getUser()->hasVatEx()))
        {
            return TaxPeer::retrieveByTax(0);
        }

        $id = $this->delivery_id;

        if (!isset(self::$tax[$id]))
        {
            self::$tax[$id] = $this->getDelivery()->getTax();
        }

        return self::$tax[$id];
    }

    public function getCostBrutto($with_currency = false)
    {
        if (SF_APP == 'frontend' && (sfContext::getInstance()->getUser()->hasVatEu() || sfContext::getInstance()->getUser()->hasVatEx()))
        {
            return $this->getCostNetto($with_currency);
        }

        $v =  $this->getAmountBrutto();

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

    public function setCostBrutto($v)
    {
        $this->setAmountBrutto($v);
    }

    public function getFrom()
    {
        return $this->getValueFrom();
    }

    public function getCost()
    {
        return $this->getAmount();
    }

    public function getValueFrom()
    {
        $v = parent::getValueFrom();

        if (strpos($v, '.') !== false)
        {
            return $this->format(parent::getValueFrom());
        }

        return parent::getValueFrom();
    }

    public function getAmount()
    {
        return $this->format(parent::getAmount());
    }

    protected function format($v)
    {
        if (is_numeric($v))
        {
            return stCurrency::formatPrice($v);
        }

        return $v;
    }
}
