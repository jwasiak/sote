<?php

/**
 * Subclass for representing a row from the 'st_discount_user' table.
 *
 * 
 *
 * @package plugins.stDiscountPlugin.lib.model
 */ 
class DiscountUser extends BaseDiscountUser
{
    public function getValue()
    {
        return $this->discount;
    }

    public function getPriceType()
    {
        return '%';
    }

    public function apply($amount)
    {
        if ($this->getPriceType() == '%')
        {
            $amount = stPrice::applyDiscount($amount, $this->getValue());
        }
        else
        {
            $amount -= stCurrency::exchange($this->getValue());
        }

        return $amount > 0 ? $amount : 0;
    }
}
