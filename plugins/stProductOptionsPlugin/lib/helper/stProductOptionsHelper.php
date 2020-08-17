<?php
/**
 * SOTESHOP/stProductOptionsPlugin
 *
 * Ten plik należy do aplikacji stProductOptionsPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE.
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stProductOptionsPlugin
 * @subpackage  helpers
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stProductOptionsHelper.php 17609 2012-04-02 07:40:06Z marcin $
 * @author      Daniel Mendalka <daniel.mendalka@sote.pl>
 */

use_helper('stTheme', 'Form');

function get_asset_data_for_options($option_ids, $options = null, $object = false)
{
   $result = array();
   $asset = null;
   sfLoader::loadHelpers(array('Helper', 'Url', 'stAsset'));
   if($options == null)
   {
      if(!is_array($option_ids))
      {
         $ids = explode('-', $option_ids);
      }
      else
      {
         $ids = $option_ids;
      }
      $options = ProductOptionsValuePeer::retrieveByPks($ids);
   }

   if(count($options) && $asset = end($options)->getsfAsset())
   {
      if($object)
      {
         return $asset;
      }

      $link = url_for('@stProductShowImage?folder=' . end($options)->getProduct()->getOptImageFolderId() . '&image=' . $asset->getFilename());
      $src = st_asset_image_path($asset, 'large');
      $alt = (string)$asset->getDescription();
      if(!empty($link) && !empty($src))
      {
         $result['link'] = $link;
         $result['src'] = $src;
         $result['photo_title'] = $alt;
      }
   }
   else
   {
      $marked_path = false;
      foreach($options as $index => $option)
      {
         if(!$marked_path || !$option->getParent()->isRoot() || empty($asset_remeber))
         {
            if($marked_path && $option->getParent()->isRoot())
            {
               $marked_path = false;
            }

            if($asset = $option->getsfAsset())
            {
               $asset_remeber = $asset;
               $link = url_for('@stProductShowImage?folder=' . $option->getProduct()->getOptImageFolderId() . '&image=' . $asset->getFilename());
               $src = st_asset_image_path($asset, 'large');
               $alt = (string)$asset->getDescription();
               if(!empty($link) && !empty($src))
               {
                  $result['link'] = $link;
                  $result['src'] = $src;
                  $result['photo_title'] = $alt;
               }
            }

            if($option->getId() == end($options)->getId())
            {
               $marked_path = true;
            }
         }
         else
         {
            break;
         }
      }

      if($object)
      {
         return !empty($asset_remeber) ? $asset_remeber : null;
      }
   }

   return $result;
}

/**
 * Get data information about changes in product card
 *
 * @return array()
 */
function get_update_data($selected_option, $selected_ids = null)
{
   $result = array();

   if($selected_ids)
   {
      $option_ids = explode('-', $selected_ids);

      $options = ProductOptionsValuePeer::retrieveByPksWithProduct($option_ids);
   }

   // zdjecie
   $result = get_asset_data_for_options(null, $options);


   // stan magazynowy
   if(!empty($options))
   {
      $result['stock'] = get_stock_for_options(null, $options);
   }
   else
   {
      $result['stock'] = $selected_option->getStock();
   }

   // dostępność
   if($result['stock'] !== null)
   {
      if($selected_option->getProduct()->getAvailabilityId()===null)
      {
         $result['avalibility'] = show_availability_by_stock($result['stock']);
      }
   }

   $product_config = stConfig::getInstance(sfContext::getInstance(), null, 'stProduct');
   $product_config->load();
   $result['check_stock'] = ($product_config->get('depository_basket') || ProductOptionsValuePeer::$hide_no_stock);
   $i18n = sfContext::getInstance()->getI18N();
   $result['basket_disabled'] = $i18n->__('Brak w magazynie', '', 'stProductOptionsFrontend');
   $result['basket_enabled'] = $i18n->__('Dodaj do koszyka', '', 'stBasket');

   // cena
   $price = array();

   //ustawianie modyfiaktora ceny;
//    ProductOptionsValuePeer::setSelectedItems($selected_option->getProduct()->getId(), explode('-', $selected_ids));
   $price['brutto'] = $selected_option->getProduct()->getPriceBrutto();
//    ProductOptionsValuePeer::setSelectedItems($selected_option->getProduct()->getId(), explode('-', $selected_ids));
   $price['netto'] = $selected_option->getProduct()->getPriceNetto();

   //$price = modify_price($selected_option, null, $selected_ids);



   if(!empty($price))
   {
      if(isset($price['brutto']))
      {
         $result['price_brutto'] =  st_price($price['brutto'], true, true);
      }
      if(isset($price['netto']))
      {
         $result['price_netto'] =  st_price($price['netto'], true, true);
      }
   }

   return $result;
}


function show_availability_by_stock($stock)
{
   $c = new Criteria();
   $c->add(AvailabilityPeer::STOCK_FROM,$stock,Criteria::LESS_EQUAL);
   $c->addDescendingOrderByColumn(AvailabilityPeer::STOCK_FROM);
   if($availability=AvailabilityPeer::doSelectOne($c))
   {
      $availability=$availability->getAvailabilityName();
   }
   else
   {
      $availability = null;
   }
   return $availability;
}

function st_product_options_get_view($product)
{
   static $smarty = null;

   if (null === $smarty)
   {
      st_theme_use_stylesheet('stProductOptionsPlugin.css');

      $smarty = new stSmarty('stProductOptionsFrontend');
   }

   $smarty->assign('product_options', $product->getPriceModifiers());

   return $smarty->fetch('options_view.html');
}

function st_product_options_get_form($product, $selected_ids = array())
{
   // var_export($selected_ids);
   if (count($selected_ids)==0) return "";
   
   $debug = sfConfig::get('sf_logging_enabled') && sfConfig::get('sf_debug');

   if ($debug)
   {
      $timer = sfTimerManager::getTimer('__SOTE helper st_product_options_get_form');
   }

   st_theme_use_stylesheet("stProductOptionsViewselect.css");

   $smarty = new stSmarty('stProductOptionsFrontend');

   $options = ProductOptionsValuePeer::doSelectByProduct($product);

   $price_type = ProductOptionsValuePeer::getPriceType($product);

   ob_start();

   _st_product_options_form_content($smarty, $product, $options, $selected_ids, $price_type);

   $smarty->assign('form_head', form_tag('#', array('id' => 'st_update_product_options_form', "autocomplete"=>"off" )));

   $smarty->assign('options', ob_get_clean());

   $smarty->assign('head', '<ul id="st_product_options_form">');

   $smarty->assign('foot', '</ul>');

   $smarty->assign('form_foot', '</form>');

   $smarty->assign('config', $product->getConfiguration());

   $smarty->assign('url', '@stProductOptionsFrontend?action=ajaxNewUpdateProduct&product_id='.$product->getId());

   $ret = $smarty->fetch('options_template.html');

   if ($debug)
   {
      $timer->addTime();
   }

   return $ret;
}

function _st_product_options_form_content($smarty, $product, $options, $selected_ids = array(), $price_type)
{
   $product_config = $product->getConfiguration();

   $select_options = array();

   $field_id = $options[0]->getProductOptionsField()->getId();

   $selected = $options[0];

   $last_option_id = end($options)->getId();

   foreach ($options as $option)
   {
      $option_id = $option->getId();

      $field = $option->getProductOptionsField();

      $current_field_id = $field->getId();

      $selected_id = isset($selected_ids[$current_field_id]) ? $selected_ids[$current_field_id] : null;

      if ($field_id != $current_field_id)
      {
         if (is_object($selected->getProductOptionsField()->getProductOptionsFilter()) && $selected->getProductOptionsField()->getProductOptionsFilter()->getFilterType()==2) 
         {
            _st_product_options_form_color($smarty, $select_options, $selected);
         }
         else    
         {
            _st_product_options_form_select($smarty, $select_options, $selected);
         }

         if ($selected->hasChildren())
         {
            _st_product_options_form_content($smarty, $product, $selected->getChildOptions($product_config->get('hide_options_with_empty_stock')), $selected_ids, $price_type);
         }

         $select_options = array();

         $field_id = $current_field_id;

         $selected = $option;
      }
      elseif ($selected_id && $selected_id == $option_id || null === $selected_id && $option->getOptValue() == $field->getOptDefaultValue())
      {
         $selected = $option;
      }

      $select_options[$option_id]['label'] = $option->getValue();

      $select_options[$option_id]['color'] = $option->getUseImageAsColor() ? $option->getColorImagePath() : '#'.$option->getColor();

      $select_options[$option_id]['modify'] = _st_product_options_form_option_price($product, $option, $price_type);

      $select_options[$option_id]['stock'] = $option->getStock() ? $option->getStock() : 0;

      $select_options[$option_id]['instance'] = $option;

      if ($last_option_id == $option_id)
      {
         if (is_object($selected->getProductOptionsField()->getProductOptionsFilter()) && $selected->getProductOptionsField()->getProductOptionsFilter()->getFilterType()==2) 
         {
            _st_product_options_form_color($smarty, $select_options, $selected);
         }
         else 
         {
            _st_product_options_form_select($smarty, $select_options, $selected);
         }

         if ($selected->hasChildren())
         {
            _st_product_options_form_content($smarty, $product, $selected->getChildOptions($product_config->get('hide_options_with_empty_stock')), $selected_ids, $price_type);
         }
      }
   }
}

function _st_product_options_form_select($smarty, $select_options, $selected)
{
   $field = $selected->getProductOptionsField();

   $smarty->assign('field_instance', $field);

   $smarty->assign('field_name', 'st_product_options['.$field->getId().']');

   $smarty->assign('field_id', 'st_product_options_'.$field->getId());

   $smarty->assign('field_label', $field->getName());

   $smarty->assign('selected', $selected->getId());

   $smarty->assign('options', $select_options);

   $smarty->display('options_view_select.html');
}

function _st_product_options_form_color($smarty, $select_options, $selected)
{
   $field = $selected->getProductOptionsField();

   $smarty->assign('field_instance', $field);

   $smarty->assign('field_name', 'st_product_options['.$field->getId().']');

   $smarty->assign('field_id', 'st_product_options_'.$field->getId());

   $smarty->assign('field_label', $field->getName());

   $smarty->assign('selected', $selected->getId());

   $smarty->assign('options', $select_options);

   $smarty->assign('unavail_image', st_theme_image_tag('stProductOptionsPlugin/unavail.png', array('class'=>'st_product_option-color_unavail')));

   $smarty->display('options_view_color_select.html');
}

function _st_product_options_form_option_price($product, $option, $price_type)
{
   if (!$product->isPriceVisible()) {
      return '';
   }
   
   $option_price = $option->getPrice();

   if ($option_price && substr($option_price, -1) != '%')
   {
      $product_currency = $product->getCurrency();

      $currency = stCurrency::getInstance(sfContext::getInstance())->get();

      $prefix = $option_price{0} == '+' || $option_price{0} == '-' ? $option_price{0} : null;

      $option_price = ltrim($option_price, '+-');

      if ($product_currency->getExchange() != 1 && $product_currency->getId() != $currency->getId())
      {
         $option_price = $product_currency->exchange($option_price, true, $product->getCurrencyExchange());

         $option_price = $currency->exchange($option_price);
      }

      if ($product_currency->getExchange() != 1)
      {
         $price_type = 'brutto';
      }

      $view = $product->getConfiguration()->get('price_view');

      if (($view == 'only_gross' || $view == 'gross_net') && $price_type == 'netto')
      {
         $option_price = stPrice::calculate($option_price, $product->getVatValue());
      }
      elseif (($view == 'only_net' || $view == 'net_gross') && $price_type == 'brutto')
      {
         $option_price = stPrice::extract($option_price, $product->getVatValue());
      }

      if ($product_currency->getExchange() == 1)
      {
         $option_price = $currency->exchange($option_price);
      }

      $option_price = $prefix.st_currency_format($option_price);
   }

   return $option_price;
}
