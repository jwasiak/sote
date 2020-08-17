<?php

/**
 * SOTESHOP/stOrder
 *
 * Ten plik należy do aplikacji stOrder opartej na licencji (Professional License SOTE).
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stOrder
 * @subpackage  helpers
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stOrderHelper.php 13690 2011-06-20 06:58:55Z marcin $
 */
use_helper('Number', 'Tag', 'stCurrency');

function st_order_status_select_tag($name, $selected, $options = array())
{
   $select_options_params = array();

   if (isset($options['include_custom']))
   {
      $select_options_params['include_custom'] = '---';
      unset($options['include_custom']);
   }

   $culture = sfContext::getInstance()->getUser()->getCulture();   

   $select_options = _order_status_select_tag($culture, 'getNameWithMailNotification');

   return select_tag($name, options_for_select($select_options, $selected, $select_options_params), $options);
}

function st_order_select_status() 
{
   $culture = sfContext::getInstance()->getUser()->getCulture(); 

   $results = OrderStatusPeer::doSelectCached($culture);

   foreach ($results as $status)
   {
      $options[$status->getId()] = $status->getName();
   }

   return $options;  
}

function st_order_status_filter_select_tag($name, $selected, $options = array())
{   
   $culture = sfContext::getInstance()->getUser()->getCulture();   

   $types = array();

   $status_types = OrderStatusPeer::getTypes();

   foreach ($status_types as $value => $label)
   {
      $types[$value] = ucfirst(__($label));
   }

   $results = OrderStatusPeer::doSelectCached($culture);

   $cnt = count($results);

   $select_options = array();

   foreach ($results as $status)
   {
      $select_options[$status->getId()] = $status->getName();
   }   

   return select_tag($name, options_for_select(array(
      __("Pokaż wszystkie", null, 'stOrder').":" => $types,
      __("Pokaż indywidualne", null, 'stOrder').":" => $select_options,
   ), $selected, array('include_custom' => '---')), $options);   
}

function _order_status_select_tag($culture, $method = null)
{
   $results = OrderStatusPeer::doSelectCached($culture);

   foreach ($results as $status)
   {
      $options[$status->getId()] = null !== $method ? $status->$method() : $status->getName();
   }

   return $options;
}

function st_order_info_tooltip(Order $order)
{
   $tooltip = '';

   $client_name = trim($order->getOptClientName());

   if ($client_name)
   {
      $tooltip .= '<p>'.$client_name.'</p>';
   }

   if ($order->getOptClientCompany())
   {
      $tooltip .= '<p>'.$order->getOptClientCompany().'</p>';
   }

   return htmlspecialchars($tooltip.'<p>'.$order->getOptClientEmail().'</p>');
}

function st_order_client_name(Order $order, $target = '_self', $with_tooltip = true)
{
   $client_name = trim($order->getOptClientName());

   $company = $order->getOptClientCompany();

   $name = '';

   if ($client_name)
   {
      $name .= $client_name;
   }

   if ($company)
   {
      if (!$name) 
      {
         $name = $company;
      }
      else
      {
         $name .= ' ('.$company.')';
      }
   }  

   if ($with_tooltip)
   {
       $tooltip = st_order_info_tooltip($order);

       if ($order->getsfGuardUserId())
       {
          $name = '<a class="list_tooltip" target="'.$target.'" href="'.st_url_for('stUser/edit?id='.$order->getsfGuardUserId()).'" title="'.$tooltip.'"><img src="/images/backend/beta/icons/16x16/user.png" style="vertical-align: middle; padding-right: 3px;" /></a> '.mb_strimwidth($name,0,30,'...','utf-8');
       }
       else 
       {
          $name = '<img class="list_tooltip" title="'.$tooltip.'" src="/images/backend/beta/icons/16x16/user.png" style="vertical-align: middle; padding-right: 3px;" /> '.mb_strimwidth($name,0,30,'...','utf-8');
       }
   } 

   return $name;
}

function st_order_price_format($amount, $currency)
{
   return $currency->getFrontSymbol().st_format_price($amount).' '.$currency->getBackSymbol();
}

function st_order_product_price(OrderProduct $product, $with_tax = false, $with_discount = true)
{
   $currency = $product->getGlobalCurrency();

   return st_order_price_format($product->getPrice($with_tax, true, $with_discount), $currency);
}

function st_order_product_total_amount($object, $with_tax = true, $with_discount = true)
{
   $currency = $object instanceof OrderProduct ? $object->getGlobalCurrency() : $object->getOrderCurrency();

   return st_order_price_format($object->getTotalAmount($with_tax, true, $with_discount), $currency);
}

function st_order_delivery_cost(Order $order, $with_tax = false)
{
   $currency = $order->getOrderCurrency();

   return st_order_price_format($order->getOrderDelivery()->getCost($with_tax, true), $currency);
}

function st_order_display_product_options(OrderProduct $order_product)
{
   echo st_order_render_product_options($order_product);
}


function st_order_display_product_set(OrderProduct $order_product)
{
   if ($order_product->getVersion() >= 3)
   {
      echo '<ul class="st_order-product-options">';

      foreach ($order_product->getOrderProductHasSets() as $set)
      {
         echo '<li>['.$set->getCode().'] <a href="'.st_url_for('@stProductEdit?id='.$set->getProductId()).'">'.$set->getName().'</a></li>';
      }

      echo '</ul>';
   }
   else
   {
      $ids = array();

      foreach ($order_product->getOrderProductHasSets() as $set) 
      {
         $ids[] = $set->getProductId();
      }

      $c = new Criteria();
      $c->add(ProductPeer::ID, $ids, Criteria::IN);

      $content = '<ul class="st_order-product-options">';

      if ($order_product->getProduct())
      {
         $content .= '<li>['.$order_product->getProduct()->getCode().'] <a href="'.st_url_for('@stProductEdit?id='.$order_product->getProductId()).'">'.$order_product->getProduct()->getName().'</a></li>';
      }

      foreach (ProductPeer::doSelectWithI18n($c) as $product)
      {
         $content .= '<li>['.$product->getCode().'] <a href="'.st_url_for('@stProductEdit?id='.$product->getId()).'">'.$product->getName().'</a></li>';
      }

      $content .= '</ul>';

      echo $content;
   }
}

function st_order_render_product_options(OrderProduct $order_product)
{
   if ($order_product->hasOldOptions())
   {
      $options = $order_product->getOptions(true);

      $content = '';

      foreach ($options as $option)
      {
         $content .= content_tag('li', $option);
      }

      return content_tag('ul', $content, array('class' => 'st_order-product-options'));
   }
   else
   {
      $price_modifiers = $order_product->getPriceModifiers();

      $content = '';

      foreach ($price_modifiers as $price_modifier)
      {
         if (isset($price_modifier['custom']['field']))
         {
            $content .= content_tag('li', $price_modifier['custom']['field'].': '.$price_modifier['label']);
         }
         else
         {
            $content .= content_tag('li', $price_modifier['label']);
         }
      }

      return content_tag('ul', $content, array('class' => 'st_order-product-options'));
   }
}

function st_order_status($order_status)
{
   switch ($order_status->getType())
   {
      case 'ST_CANCELED':
         $color = '#b22222';
         break;
      case 'ST_PENDING':
         $color = '#daa520';
         break;
      case 'ST_COMPLETE':
         $color = '#008000';
         break;
   }

   return content_tag('b', $order_status, array('style' => 'color: '.$color));
}

/**
 * Zwraca przekazana cenę w poprawnym formacie i walucie
 *
 * @param                float       $price              Cena
 * @param   OrderCurrency $order_currency   Obiekt waluty
 * @return   string
 */
function st_order_price($price, $order_currency)
{
   return $order_currency->getFrontSymbol().' '.format_currency($order_currency->getPrice($price)).' '.$order_currency->getBackSymbol();
}

/**
 * Zwraca łaczna kwotę zamówienia (uwzglednia format i walutę)
 *
 * @param   Order       $order              Obiekt zamówienia
 * @return   string
 */
function st_order_total_amount($order, $with_tax = true, $with_currency = true, $with_discount = true)
{
   $order_currency = $order->getOrderCurrency();

   $total_amount = $order->getTotalAmount($with_tax, $with_currency, $with_discount);

   $delivery_cost = $order->getOrderDelivery()->getCost($with_tax, $with_currency);

   if (!$with_currency)
   {
      $order_currency = stCurrency::getInstance(sfContext::getInstance())->getBackendMainCurrency();
   }

   return st_order_price_format($total_amount + $delivery_cost, $order_currency);
}

/**
 * Funkcja pomocnicza obliczajaca łaczna cenę produktu (uwzględnia walutę)
 *
 * @param   OrderProduct $order_product     Obiekt produktu
 * @param   OrderCurrency $order_currency   Obiekt waluty
 * @return   float
 */
function _st_order_product_total_amount($order_product, $order_currency)
{
   return $order_product->getPrice(true, true) * $order_product->getQuantity();
}

/**
 * Funkcja pomocnicza obliczajaca łaczna kwotę zamówienia (uwzglednia walutę)
 *
 * @param   array       $order_products     Lista obiektów OrderProduct
 * @param   OrderCurrency $order_currency   Obiekt waluty
 * @return   float
 */
function _st_order_total_amount($order_products, $order_currency)
{
   $total_amount = 0;

   foreach ($order_products as $order_product)
   {
      $total_amount += _st_order_product_total_amount($order_product, $order_currency);
   }

   return $total_amount;
}