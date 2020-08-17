<?php

use_javascript('stPrice.js?v4');

function st_price_tax_managment_init($params)
{
   if (isset($params['onChange']))
   {
      $on_change = $params['onChange'];
      
      unset($params['onChange']);
   }
   else
   {
      $on_change = '';
   }

   $params = json_encode($params);



   $content = <<<JS
    document.observe("dom:loaded", function ()
    {
        var params = $params;

        Object.extend(params, {onChange: function(price, priceWithTax) { $on_change }});

        stPriceTaxManagment.instance = new stPriceTaxManagment(params);
    });
JS;

   echo javascript_tag($content);
}

function st_price_add_format_behavior($field, $precision = 2, $max_length = 11)
{
   $content = <<<JS
    document.observe("dom:loaded", function ()
    {
        stPrice.addFormatBehavior('$field', $precision, $max_length);
    });
JS;

   return javascript_tag($content);
}

function st_price_tax_manager_add_price_field($field)
{
   $field = json_encode($field);

   $content = <<<JS
    document.observe("dom:loaded", function ()
    {
        stPriceTaxManagment.instance.addPriceField($field);
    });
JS;

   echo javascript_tag($content);
}

function st_price_format($price)
{
   return number_format($price, 2, '.', '');
}
