<?php

use_helper('stCurrency', 'Javascript', 'Validation', 'stProductImage', 'stBasket', 'stUrl', 'stProductOptions');

sfLoader::loadHelpers('stProduct', 'stProduct');

use_javascript('stPrice.js');

if (!isset($smarty))
{
  $smarty = new stSmarty('stBasket');
}

if ($sf_request->hasErrors() && $sf_request->hasParameter('option_list'))
{
   $hidden = input_hidden_tag('option_list', $sf_request->getParameter('option_list'));

   $hidden .= input_hidden_tag('product_id', $sf_request->getParameter('product_id'));

   $smarty->assign("form_start", form_tag('stBasket/index', 'id=st_basket-form class=st_form').$hidden);
}
else
{
   $smarty->assign("form_start", form_tag('stBasket/index', 'id=st_basket-form class=st_form'));
}

$results = array();

$version = stTheme::getInstance($sf_context)->getVersion();

$smarty->assign('products', $basket->getItems());

foreach ($basket->getItems() as $index => $product)
{
    if ($product->isDeleted())
    {
        continue;
    }
    
	$is_valid = $product->productValidate();

	$url = $is_valid && !$product->getIsGift() ? st_url_for('stProduct/show?url='.$product->getProduct()->getFriendlyUrl()) : null;

   $results[$index]['id'] = $product->getItemId();

   $results[$index]['if_form_error'] = $sf_request->hasError('basket{products}{'.$product->getItemId().'}');

   $results[$index]['error_show'] = $sf_request->getError('basket{products}{'.$product->getItemId().'}');

   if ($version < 7)
   {
      $results[$index]['product_url'] = $url;

      if ($is_valid)
      {
         if ($url)
         {
            $results[$index]['photo'] = st_product_image_tag($product->getProduct(), 'icon');  
         }
         else
         {
            $results[$index]['photo'] = '<a href="'.$url.'">'.st_product_image_tag($product->getProduct(), 'icon').'</a>';
         }
      }
      else
      {
         $results[$index]['photo'] = st_product_image_tag(null, 'icon');
      }

      $results[$index]['preview'] = st_product_image_tag($product->getProduct(), 'small');
   }
   else
   {
      $results[$index]['url'] = $url;

      if ($is_valid)
      {
         $results[$index]['photo'] = st_product_image_path($product->getProduct(), 'small');   
      }
      else
      {
         $results[$index]['photo'] = st_product_image_path(null, 'small');
      }      
   }

   $results[$index]['instance'] = $product;

   if ($version < 7)
   {
      if ($url)
      {
         $results[$index]['name'] = '<a href="'.$url.'">'.$product->getName().'</a>';     
      }
      else
      {
         $results[$index]['name'] = $product->getName();
      }

      if ($product->hasPriceModifiers())
      {
         $results[$index]['name'] = content_tag('div', $results[$index]['name'], array('class' => 'st_product_name_with_options')).st_product_options_get_view($product);
      } 
   }
   else
   {
      $results[$index]['name'] = $product->getName();  
   }

   $results[$index]['code'] = $product->getCode();

   $results[$index]['price_netto'] = st_currency_format($product->getPriceNetto(true));

   $results[$index]['tax'] = $product->getVat();

   $results[$index]['price_brutto'] = st_currency_format($product->getPriceBrutto(true));
   
   if(null === $product->getProduct() || $product->getProduct()->getPointsValue() * $product->getQuantity() == 0){
       $results[$index]['points_value'] = "";
       $results[$index]['points_sum_value'] = "";   
   }else{
       $results[$index]['points_value'] = $product->getProduct()->getPointsValue();
       $results[$index]['points_sum_value'] = $product->getProduct()->getPointsValue() * $product->getQuantity();
   }
   
   $results[$index]['points_only']= $product->getProduct() ? $product->getProduct()->getPointsOnly() : 0;
   
   $results[$index]['points_earn'] = $product->getPointsEarn() * $product->getQuantity();
      
   if(null !== $product->getProduct() && $product->getProduct()->getPointsValue() * $product->getQuantity() <= stPoints::getLoginStatusPoints() && $product->getProduct()->getPointsValue()>0){
       $results[$index]['show_pay_by_points'] = true;
   }else{
       $results[$index]['show_pay_by_points'] = false;
   }    
   
   if(stPoints::isItemByPoints($product->getItemId())){
       $results[$index]['show_pay_by_money'] = true;
   }else{
       $results[$index]['show_pay_by_money'] = false;
   }
   
   $results[$index]['is_item_by_points'] = stPoints::isItemByPoints($product->getItemId());
   
   $results[$index]['is_set_discount'] = $product->getProductSetDiscount();
   
   $results[$index]['url_by_money'] = st_url_for("stBasket/payByPoints?item_id=".$product->getItemId()."&clear=1");
       
   $results[$index]['url_by_points'] = st_url_for("stBasket/payByPoints?item_id=".$product->getItemId());
   
   $results[$index]['num_onmouseover'] = st_basket_js_num_buttons_show($product);

   $results[$index]['num_onmouseout'] = st_basket_js_num_buttons_hide($product);

   if ($version < 7)
   {
      if ($product->getIsGift())
      {
         $results[$index]['num'] = input_tag('basket[products]['.$product->getItemId().']', $product->getQuantity(), array('readonly' => true, 'size' => 3, 'class' => 'form-control'));    
      }
      else
      {
         if ($sf_request->hasError('basket{products}{'.$product->getItemId().'}'))
         {
            if ($product->getProductStepQty())
            {
               $results[$index]['num'] = st_product_quantity_list('basket[products]['.$product->getItemId().']', $product->getProduct(), $sf_request->getParameter('basket[products]['.$product->getItemId().']'), array('class' => 'st_form-error'));
            }
            else
            {
               $results[$index]['num'] = input_tag('basket[products]['.$product->getItemId().']', $sf_request->getParameter('basket[products]['.$product->getItemId().']'), array(
                   'class' => 'st_form-error', 
                   'size' => 3, 
                   'maxlength' => 11,
                   'onchange' => 'this.value = stPrice.fixNumberFormat(this.value, '.$product->getProductStockInDecimals().');'
                   ));
            }
         }
         else
         {
            if ($product->getProductStepQty())
            {
               $results[$index]['num'] = st_product_quantity_list('basket[products]['.$product->getItemId().']', $product->getProduct(), $product->getQuantity());
            }
            else
            {
               $results[$index]['num'] = input_tag('basket[products]['.$product->getItemId().']', stPrice::round($product->getQuantity(), $product->getProductStockInDecimals()), array(
                   'size' => 3, 
                   'maxlength' => 11,
                   'onchange' => 'this.value = stPrice.fixNumberFormat(this.value, '.$product->getProductStockInDecimals().');'
                   ));
            }
         }

         if (!$product->getProductStepQty())
         {
            if ($product->getQuantity() > $product->getProductMinQty() && !$sf_request->hasErrors())
            {
               $results[$index]['minus'] = link_to(st_theme_image_tag('minus.gif', array('alt' => '')), 'stBasket/setProduct?product_id='.$product->getItemId().'&quantity='.($product->getQuantity() - 1));
            }
            else
            {
               $results[$index]['minus'] = st_theme_image_tag('minus.gif', array('alt' => ''));
            }

            if (null === $product->getMaxQuantity() || $product->getQuantity() < $product->getMaxQuantity() && !$sf_request->hasErrors())
            {
               if($product->getProduct()->getPointsOnly()==1 && $product->getProduct()->getPointsValue() > stPoints::getUnusedUserPoints()){        
                  $results[$index]['plus'] = st_theme_image_tag('plus.gif', array('alt' => ''));    
               }else{
                  $results[$index]['plus'] = link_to(st_theme_image_tag('plus.gif', array('alt' => '')), 'stBasket/setProduct?product_id='.$product->getItemId().'&quantity='.($product->getQuantity() + 1));    
               }
               
            }
            else
            {
               $results[$index]['plus'] = st_theme_image_tag('plus.gif', array('alt' => ''));
            }
         }
      }
   }
   else
   {
      if ($product->getIsGift())
      {
         $results[$index]['num'] = input_tag('basket[products]['.$product->getItemId().']', $product->getQuantity(), array('readonly' => true, 'size' => 3, 'class' => 'form-control'));    
      }
      else
      {
         $has_error = $sf_request->hasError('basket{products}{'.$product->getItemId().'}');

         $quantity = $has_error ? $sf_request->getParameter('basket[products]['.$product->getItemId().']') : $product->getQuantity();

         if ($product->getProductStepQty())
         {
            $results[$index]['num'] = st_product_quantity_list('basket[products]['.$product->getItemId().']', $product->getProduct(), $product->getQuantity(), array('class' => 'form-control'));
         }
         else
         {
            $results[$index]['num'] = input_tag('basket[products]['.$product->getItemId().']', stPrice::round($product->getQuantity(), $product->getProductStockInDecimals()), array(
               'class' => 'form-control', 
               'size' => 3, 
               'maxlength' => 11,
               'onchange' => 'this.value = stPrice.fixNumberFormat(this.value, '.$product->getProductStockInDecimals().');',
            ));
         }

         if ($has_error)
         {
            $results[$index]['num'] = '<span class="has-error">'.$results[$index]['num'].'</span>';
         }        
      } 
   }
   
   $results[$index]['discount'] = $product->getDiscountInPercent();

   $results[$index]['uom'] = st_product_uom($product->getProduct());

   $results[$index]['total_amount'] = st_currency_format($product->getTotalAmount(true, true), array('with_exchange' => false));

   if ($version < 7)
   {
      $results[$index]['delete'] = link_to(st_theme_image_tag('delete.png', array('alt' => '')), 'stBasket/remove?product_id='.$product->getItemId());
   }
   else
   {
      $results[$index]['delete_url'] = st_url_for('stBasket/remove?product_id='.$product->getItemId());
   }
}

if ($version < 7)
{
   $smarty->assign("delete_img", st_theme_image_tag('delete.png', array('alt' => '', 'style'=>'margin:0px 0px -2px 2px;')));

   $smarty->assign("button_update", submit_tag(__('Uaktualnij koszyk')));
}

$clear_url = st_url_for('stBasket/clear');

$smarty->assign("button_clear", link_to(__("Opróżnij koszyk"), $clear_url, array('onclick' => "javascript: return window.confirm('".__('Czy na pewno opróżnić koszyk?')."')")));

//points system
$smarty->assign('points_system_is_active', stPoints::isPointsSystemActive());
$smarty->assign('show_points', $config_points->get('product_full_list_show_points'));
$smarty->assign('display_type', $config_points->get('product_full_list_display_type'));
$smarty->assign('points_shortcut', $config_points->get('points_shortcut', null, true));
$smarty->assign('user_points', stPoints::getUserPoints());
$smarty->assign('user_points_status', stPoints::getLoginStatusPoints());
$smarty->assign('currency', stCurrency::getInstance(sfContext::getInstance())->get());
$smarty->assign('is_authenticated', sfContext::getInstance() -> getUser() -> isAuthenticated());
$smarty->assign('is_release', stPoints::isReleasePointsSystemForUser());


//default2
$smarty->assign('clear_url', $clear_url);

$smarty->assign('results', $results);

$smarty->assign("show_code_in_basket", $basket_config->get('show_code_in_basket'));

$smarty->assign("show_photo_in_basket", $basket_config->get('show_photo_in_basket'));

$smarty->assign("show_netto_in_basket", $basket_config->get('show_netto_in_basket'));

$smarty->assign("show_tax_in_basket", $basket_config->get('show_tax_in_basket'));
            
$smarty->assign("show_uom_in_basket", $basket_config->get('show_uom_in_basket'));

$smarty->assign("show_discount_in_basket", $basket_config->get('show_discount_in_basket'));

if (stConfig::getInstance('stInvoiceBackend')->get('vat_eu'))
{
    $smarty->assign("vat_eu", label_for('basket[vat_eu]', __('Posiadam VAT UE')).checkbox_tag('basket[vat_eu]', true, $sf_user->hasVatEu(), array('onclick' => 'this.form.submit(); jQuery(\'#st_basket_vat_eu,#basket_index\').css({ cursor: \'wait\' })')));
}

$smarty->display('basket_products_list.html');
?>