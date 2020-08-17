<?php

function list_gift_group_price_label($label)
{
   $currency = stCurrency::getInstance(sfContext::getInstance())->getBackendMainCurrency();

   return __($label, null, 'stGiftGroup').' ['.$currency->getFrontSymbol().$currency->getBackSymbol().']';
}

function object_gift_group_price(ProductGroup $product_group, $method, $options)
{
   sfLoader::loadHelpers(array('Helper', 'stPrice'));
   $currency = stCurrency::getInstance(sfContext::getInstance())->getBackendMainCurrency();
   return input_tag('product_group[from_basket_value]', $product_group->getFromBasketValue(), array('size' => 6, 'style' => 'vertical-align: middle')).' <span style="vertical-align: middle">'.$currency->getShortcut().'</span>'.st_price_add_format_behavior('product_group_from_basket_value', 0);
}