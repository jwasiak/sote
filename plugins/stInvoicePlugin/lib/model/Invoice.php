<?php

/**
 * Subclass for representing a row from the 'st_invoice' table.
 *
 * 
 *
 * @package plugins.stInvoicePlugin.lib.model
 */ 
class Invoice extends BaseInvoice
{
    protected $status = null;

    public function getTotalAmount($with_discount = true)
    {
        $total_amount = $this->getOptTotalAmmountBrutto();

        if ($with_discount && $this->getIsProforma() && $this->hasDiscount())
        {
            return $total_amount - $this->getOrderDiscount();
        }

        return $total_amount; 
    }

    public function getTotalDiscountAmount()
    {
        return $this->getTotalAmount(false) - $this->getTotalAmount();
    }

    public function hasDiscount()
    {
        return $this->getOrderDiscount() > 0;
    }

    public function getStatus()
    {
        if (null === $this->status)
        {
            $c = new Criteria();
            $c->setLimit(1);

            list($this->status) = $this->getInvoiceStatuss($c);
        }

        return $this->status;
    }
}
