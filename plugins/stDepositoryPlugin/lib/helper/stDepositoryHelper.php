<?php

use_helper('stPrice');

function list_stock(Product $product, $list_mode = null)
{
    if (!$product->hasStockManagmentWithOptions())
    {
        $stock = stPrice::round($product->getStock());
    }
    else
    {
        $c = new Criteria();
        $c->addSelectColumn('SUM('.ProductOptionsValuePeer::STOCK.')');
        $c->add(ProductOptionsValuePeer::PRODUCT_ID, $product->getId());
        $c->add(ProductOptionsValuePeer::LFT, sprintf('%s - %s = 1', ProductOptionsValuePeer::RGT, ProductOptionsValuePeer::LFT) , Criteria::CUSTOM);

        $rs = ProductOptionsValuePeer::doSelectRS($c);

        $stock = stPrice::round($rs->next() ? $rs->get(1) : 0);
    }

    if ($list_mode == 'edit')
    {
        if (!$product->hasStockManagmentWithOptions())
        {
            return '<input type="text" name="product['.$product->getId().'][list_stock]" value="'.$stock.'" onchange="this.value=stPrice.fixNumberFormat(this.value, 2)" size="6" />'; 
        }
        else
        {
            return '<input type="text" name="product['.$product->getId().'][list_stock]" value="'.$stock.'" size="6" disabled="disabled" />';
        }
    }
    else
    {
        return $stock;
    }
}