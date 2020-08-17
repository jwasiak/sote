<?php

if ($basket_product->hasPriceModifiers())
{
   echo content_tag('div', $basket_product->getName(), array('style' => 'text-align: left'));

   $content = '';

   foreach ($basket_product->getPriceModifiers() as $price_modifier)
   {
      $content .= content_tag('li', $price_modifier['label'], array('style' => 'list-style: circle inside none'));
   }

   echo content_tag('ul', $content, array('style' => 'text-align: left'));
}
else
{
   echo $basket_product->getName();
}