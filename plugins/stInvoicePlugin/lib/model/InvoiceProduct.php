<?php

/**
 * Subclass for representing a row from the 'st_invoice_product' table.
 *
 * 
 *
 * @package plugins.stInvoicePlugin.lib.model
 */ 
class InvoiceProduct extends BaseInvoiceProduct
{
    public function getPriceBrutto()
    {
        $price = parent::getPriceBrutto();

        if (null === $price)
        {
            $price = stPrice::calculate($this->getPriceNetto(), $this->getVat());
        }

        return $price;
    }

    public function getName()
    {
       $name = parent::getName();

       if (preg_match_all('/<li>([^<]+)<\/li>/', $name, $m1))
       {
          if (preg_match('/([^<]+)<ul/', $name, $m2))
          {
             $name = $m2[1];
          }

          $name .= ' ['.implode(', ',$m1[1]).']';
       }

       return strip_tags($name);
    }

}
