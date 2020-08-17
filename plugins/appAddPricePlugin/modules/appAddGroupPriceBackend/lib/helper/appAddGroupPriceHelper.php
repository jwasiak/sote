<?php

use_helper('Asset', 'stPrice', 'I18N', 'stProductImage', 'stCurrency');

sfLoader::loadHelpers(array('stProduct'), 'stProduct');

function object_add_group_price_tax(AddGroupPrice $addGroupPrice, $method, $options = array())
{
   use_helper('stPrice');

   $cache = new stFunctionCache('stTax');

   $tax_info = $cache->cacheCall('_object_product_tax_helper');

   st_price_tax_managment_init(array(
           'taxField' => 'add_group_price_tax_id',
           'taxValues' => $tax_info['values'],
           'priceFields' => array(
                   array('price' => 'add_group_price_price_netto', 'priceWithTax' => 'add_group_price_price_brutto'),
                   array('price' => 'add_group_price_old_price_netto', 'priceWithTax' => 'add_group_price_old_price_brutto'),
           
           ))); 

   return select_tag('add_group_price[tax_id]', options_for_select($tax_info['names'], $addGroupPrice->getTaxId() ? $addGroupPrice->getTaxId() : $tax_info['default'])); 
}