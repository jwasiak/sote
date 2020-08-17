<?php

use_helper('Number', 'stCurrency', 'Date', 'nifty', 'stUrl', 'stProductOptions', 'stProductImage', 'stCaptchaGD', 'Validation');

$delivery_id = $delivery->getDefaultDelivery()->getId();
$payment_id = $delivery->getDefaultDelivery()->getDefaultPayment()->getId();

use_javascript('jquery.infieldlabel.js', 'last');

sfLoader::loadHelpers('stProduct', 'stProduct');

st_theme_use_stylesheet('stUser.css');

st_theme_use_stylesheet('stOrder.css');
 
$smarty->assign('is_authenticated', $is_authenticated);

$smarty->assign('label_description', label_for('order_description',__('Uwagi do zamówienia')));

$smarty->assign('description', stXssSafe::clean($user_data_billing['description']));
$smarty->assign('hidden_description', input_hidden_tag('user_data_billing[description]', $user_data_billing['description']));



if($user_data_billing['customer_type']==1)
{
	$user_data_billing['company']="";
	$user_data_billing['vat_number']="";
}

if($user_data_delivery['customer_type']==1)
{
	$user_data_delivery['company']="";
}

if(isset($user_data_billing['email']))
{
   $smarty->assign('user_data_billing_email', stXssSafe::clean($user_data_billing['email']));
}

if(isset($user_data_billing['invoice']))
{
   $smarty->assign('user_data_billing_invoice', $user_data_billing['invoice']);
}

$smarty->assign('user_data_billing_company', stXssSafe::clean($user_data_billing['company']));

$smarty->assign('user_data_billing_vat_number', stXssSafe::clean($user_data_billing['vat_number']));

$smarty->assign('user_data_billing_full_name', stXssSafe::clean($user_data_billing['full_name']));

$smarty->assign('user_data_billing_address', stXssSafe::clean($user_data_billing['address']));

$smarty->assign('user_data_billing_address_more', isset($user_data_billing['address_more']) ? stXssSafe::clean($user_data_billing['address_more']) : null);

$smarty->assign('user_data_billing_region', isset($user_data_billing['region']) ? stXssSafe::clean($user_data_billing['region']) : null);

$smarty->assign('user_data_billing_code', stXssSafe::clean($user_data_billing['code']));

$smarty->assign('user_data_billing_town', stXssSafe::clean($user_data_billing['town']));

$smarty->assign('user_data_billing_country', CountriesPeer::retrieveByPK($user_data_billing['country']));

$smarty->assign('user_data_billing_phone', stXssSafe::clean($user_data_billing['phone']));
  
$smarty->assign('newsletter_form', st_get_component('stNewsletterFrontend', 'requestNewsletter'));



$smarty->assign('user_data_delivery_company', stXssSafe::clean($user_data_delivery['company']));

$smarty->assign('user_data_delivery_full_name', stXssSafe::clean($user_data_delivery['full_name']));

$smarty->assign('user_data_delivery_address', stXssSafe::clean($user_data_delivery['address']));

$smarty->assign('user_data_delivery_address_more', isset($user_data_delivery['address_more']) ? stXssSafe::clean($user_data_delivery['address_more']) : null);

$smarty->assign('user_data_delivery_region', isset($user_data_delivery['region']) ? stXssSafe::clean($user_data_delivery['region']) : null);

$smarty->assign('user_data_delivery_code', stXssSafe::clean($user_data_delivery['code']));

$smarty->assign('user_data_delivery_town', stXssSafe::clean($user_data_delivery['town']));

$smarty->assign('user_data_delivery_country', CountriesPeer::retrieveByPK($user_data_delivery['country']));

$smarty->assign('user_data_delivery_phone', stXssSafe::clean($user_data_delivery['phone']));


$results = array();

$basket_total_amount = 0;

foreach ($basket->getItems() as $basket_product)
{
   $row['instance'] = $basket_product;
   $row['code'] = $basket_product->getCode();

   $row['validate'] = $basket_product->productValidate();

   if($row['validate'])
   {
      $row['photo'] = st_link_to(st_product_image_tag($basket_product, 'icon'), 'stProduct/show?url='.$basket_product->getProduct()->getFriendlyUrl());
   }
   else
   {
      $row['photo'] = st_product_image_tag(null, 'icon');
      
      if($basket_product->getProductId()==0){
        $row['photo'] = '<a href="#"><img alt="TrustedShops" src="/images/frontend/theme/default2/stTrustedShopsPlugin/logo.png"></a>';           
      }      
   }
	
   if ($row['validate'])
   {
      $row['name_show'] = st_link_to($basket_product->getName(), 'stProduct/show?url=' . $basket_product->getProduct()->getFriendlyUrl());
   }
   else
   {
      $row['name_show'] = $basket_product->getName();
   }

   if ($basket_product->hasPriceModifiers())
   {
      $row['name_show'] = content_tag('div', $row['name_show'], array('class' => 'st_product_name_with_options')) . st_product_options_get_view($basket_product);
   }

   $row['price'] = st_currency_format($basket_product->getPrice(false, true), array('with_exchange' => false));

   $row['vat'] = $basket_product->getVat();

   $row['price_brutto'] = st_currency_format($basket_product->getPrice(true, true), array('with_exchange' => false));
   
    if ($row['validate']) {
      if($basket_product->getProduct()->getPointsValue() * $basket_product->getQuantity() == 0){
        $row['points_value'] = "";
        $row['points_sum_value'] = "";   
      }else{
        $row['points_value'] = $basket_product->getProduct()->getPointsValue();
        $row['points_sum_value'] = $basket_product->getProduct()->getPointsValue() * $basket_product->getQuantity();
      }
    }
   
   $row['is_item_by_points'] = stPoints::isItemByPoints($basket_product->getItemId());

   $row['quantity'] = $basket_product->getQuantity();

   $product_total_amount = $basket_product->getTotalAmount(true, true);

   $row['total_amount'] = st_currency_format($product_total_amount, array('with_exchange' => false));
   
   $row['uom'] = st_product_uom($basket_product->getProduct());
   
   $errors = array();
   
   if ($sf_request->getError('quantity_'.$basket_product->getItemId()))
   {
      $errors['quantity'] = $sf_request->getError('quantity_'.$basket_product->getItemId());
   }
   
   $row['errors'] = $errors;


   $results[] = $row;
   
   $basket_total_amount += $product_total_amount;
}

$smarty->assign('total_product_price', st_currency_format($basket_total_amount, array('with_exchange' => false)));

if(stPoints::isOrderOnlyForPoints()){
    $smarty->assign('payment_name', __("Płatność punktami"));
}else{
    $smarty->assign('payment_name', $paymentType->getName());   
}

$smarty->assign('is_order_only_for_points', stPoints::isOrderOnlyForPoints());

$smarty->assign('is_basket_only_for_points', stPoints::isBasketOnlyForPoints());

$smarty->assign('payment_description', $paymentType->getDescription());

$smarty->assign('delivery_name', $delivery->getDefaultDelivery()->getName());

$smarty->assign('delivery_description', $delivery->getDefaultDelivery()->getDescription());

if (stCompatibilityLaw::isSection("courier_fee_countrys",stCompatibilityLaw::getIsoCountry($user_data_billing['country'])))
{ 
    if($delivery->getDefaultDelivery()->getDefaultPayment()->getCourierCost() > 0)
    {
        $smarty->assign('delivery_courier_cost', st_currency_format($delivery->getDefaultDelivery()->getDefaultPayment()->getCourierCost()));     
    } 
}

$smarty->assign('order_cost', st_currency_format($delivery->getTotalDeliveryCost(true, true)));

$smarty->assign('order_total_amount', st_currency_format($total_amount));

$smarty->assign('paid', $paid ? st_currency_format($paid) : null);

$smarty->assign('discount', $basket->hasDiscount() ? st_currency_format($basket->getTotalProductDiscountAmount(true, true)) : null);

$smarty->assign('discount_name', $basket->hasDiscount() ? $basket->getDiscount()->getName() : null);

$points_value = stPoints::getBasketPointsValue()." ".$config_points->get('points_shortcut', null, true);

if(stPoints::isOrderOnlyForPoints()){
    
    $smarty->assign('final_total_amount', $points_value);
    
}elseif(stPoints::getBasketPointsValue()>0){
    
    $smarty->assign('final_total_amount', st_currency_format($final_total_amount)." / ".$points_value);
       
}else{
    
    $smarty->assign('final_total_amount', st_currency_format($final_total_amount));
}

$smarty->assign('delivery_date', input_hidden_tag("delivery[date]", $delivery_date));

$smarty->assign('delivery_time', input_hidden_tag("delivery[time]", $delivery_time));

if($delivery_date=="1999-11-30"){$delivery_date="";}
if($delivery_time=="00:00:00"){$delivery_time="";}

$smarty->assign('delivery_date_value', $delivery_date." ".$delivery_time);

$smarty->assign('form_start', form_tag('stOrder/save', array("id"=>"send_form")));

$user_data_billing_hidden = array();

foreach ($user_data_billing as $name => $value)
{
   $row['billing_name'] = input_hidden_tag('user_data_billing[' . $name . ']', $value);

   $user_data_billing_hidden[] = $row;
}

$user_data_delivery_hidden = array();

foreach ($user_data_delivery as $name => $value)
{
   $row['delivery_name'] = input_hidden_tag('user_data_delivery[' . $name . ']', $value);

   $user_data_delivery_hidden[] = $row;
}

$secure_token = stSecureToken::generate(array(
    'billing_country' => $user_data_billing['country'],
    'delivery_country' => $user_data_delivery['country'],
    'delivery_id' => $delivery_id,
    'payment_id' => $payment_id,
));

$user_data_delivery_hidden[] = array('delivery_name' => input_hidden_tag('delivery_id', $delivery_id));

$user_data_delivery_hidden[] = array('delivery_name' => input_hidden_tag('payment_id', $payment_id));

$user_data_delivery_hidden[] = array('delivery_name' => input_hidden_tag('secure_token', $secure_token));

$smarty->assign('user_data_billing_hidden', $user_data_billing_hidden);

$smarty->assign('user_data_delivery_hidden', $user_data_delivery_hidden);

$smarty->assign('create_account_value', $user_data_billing['create_account']);

$smarty->assign('profile_list', st_get_component('stUserData', 'profileList', array('type' => 'billing', 'selected' => $sf_request->getParameter('user_billing_profile'))));

$smarty->assign('order_correction_submit', submit_tag(__('Popraw'), array('onclick' => "this.form.action ='" . url_for('basket/index?submit_save=true') . "'")));

$smarty->assign('order_correction', url_for('basket/index?submit_save=true'));

$smarty->assign('order_submit', submit_tag(__('Potwierdź')));

$smarty->assign('user_data_hidden_form', isset($user_data_form) ? $user_data_form : null);

$smarty->assign('results', $results);


if(stCompatibilityLaw::isSection("terms_digital_countrys",stCompatibilityLaw::getIsoCountry($user_data_billing['country'])) && $compatibility_config->get('terms_digital')==1){
    if ($compatibility_config->get('terms_digital_show_online')) {
        if (stCompatibilityOnlineProducts::isBasketHasProductOnline($basket)) {
            $smarty->assign("terms_digital", 1);
            $smarty->assign("terms_digital_text", $compatibility_config->get('terms_digital_text', null, true));
        } else {
            $smarty->assign("terms_digital", 0);
            $smarty->assign("terms_digital_text", '');
        }
    } else {
        $smarty->assign("terms_digital", 1);
        $smarty->assign("terms_digital_text", $compatibility_config->get('terms_digital_text', null, true));
    }
}

if(stCompatibilityLaw::isSection("terms_service_countrys",stCompatibilityLaw::getIsoCountry($user_data_billing['country'])) && $compatibility_config->get('terms_service')==1){
    if ($compatibility_config->get('terms_service_products')) {
        if (stCompatibilityLaw::isBasketHasProductService($basket)) {
            $smarty->assign("terms_service", 1);
            $smarty->assign("terms_service_text", $compatibility_config->get('terms_service_text', null, true));
        } else {
            $smarty->assign("terms_service", 0);
            $smarty->assign("terms_service_text", '');
        }
    } else {
        $smarty->assign("terms_service", 1);
        $smarty->assign("terms_service_text", $compatibility_config->get('terms_service_text', null, true));
    }
}

if(stCompatibilityLaw::isSection("terms_right_2_cancel_countrys",stCompatibilityLaw::getIsoCountry($user_data_billing['country'])) && $compatibility_config->get('terms_right_2_cancel')==1){

$smarty->assign("terms_right_2_cancel", 1);
$terms_right_2_cancel_text = $compatibility_config->get('terms_right_2_cancel_text', null, true);


if(stTheme::is_responsive()):
    $terms_text = $terms_right_2_cancel_text;
    
    $terms_text = preg_replace('/{RIGHT_TO_CANCEL}/', '$', $terms_text);
    $terms_text = preg_replace('/{\/RIGHT_TO_CANCEL}/', '$', $terms_text);
    $terms_text = preg_replace('/{TERMS_AND_CONDITIONS}/', '%', $terms_text);
    $terms_text = preg_replace('/{\/TERMS_AND_CONDITIONS}/', '%', $terms_text);
    
    
    $tmp_string_right_to_cancel = explode("$",$terms_text);
    $tmp_string_terms_and_condition = explode("%",$terms_text);
    
    $right_to_cancel = $tmp_string_right_to_cancel[1];
    $terms_and_condition = $tmp_string_terms_and_condition[1];
    
    $terms_text = $terms_right_2_cancel_text;
    
    $terms_text = preg_replace('/{RIGHT_TO_CANCEL}/', '%', $terms_text);
    $terms_text = preg_replace('/{\/RIGHT_TO_CANCEL}/', '%', $terms_text);
    $terms_text = preg_replace('/{TERMS_AND_CONDITIONS}/', '%', $terms_text);
    $terms_text = preg_replace('/{\/TERMS_AND_CONDITIONS}/', '%', $terms_text);
    
    $tmp_string = explode("%",$terms_text);
    
    $string = '';

    foreach ($tmp_string as $value) {
        
        if($value==$right_to_cancel){
            $string .= st_get_component('stWebpageFrontend', 'link', array('state'=>'RIGHT2CANCEL', 'label'=>$right_to_cancel));
        }elseif($value==$terms_and_condition){
            $string .= st_get_component('stWebpageFrontend', 'link', array('state'=>'TERMS', 'label'=>$terms_and_condition));
        }else{
        $string .= $value;    
        }   
    }
    
     
    $smarty->assign("terms_right_2_cancel_text", $string);
else:    
    $terms_right_2_cancel_text = preg_replace('/{RIGHT_TO_CANCEL}/', '<a id="active_right_2_cancel_overlay" class="label_terms_confirm" href="#active_right_2_cancel_overlay">', $terms_right_2_cancel_text);
    $terms_right_2_cancel_text = preg_replace('/{\/RIGHT_TO_CANCEL}/', '</a>', $terms_right_2_cancel_text);
    $terms_right_2_cancel_text = preg_replace('/{TERMS_AND_CONDITIONS}/', '<a id="active_terms_overlay" class="label_terms_confirm" href="#active_terms_overlay">', $terms_right_2_cancel_text);
    $terms_right_2_cancel_text = preg_replace('/{\/TERMS_AND_CONDITIONS}/', '</a>', $terms_right_2_cancel_text);
    $smarty->assign("terms_right_2_cancel_text", $terms_right_2_cancel_text);    
     
endif;


}




if ($additional_confirm_text) $smarty->assign('additional_confirm_text', $additional_confirm_text->getContent());

$smarty->assign("show_code_in_basket", $basket_config->get('show_code_in_basket'));

$smarty->assign("show_photo_in_basket", $basket_config->get('show_photo_in_basket'));

$smarty->assign("show_netto_in_basket", $basket_config->get('show_netto_in_basket'));

$smarty->assign("show_tax_in_basket", $basket_config->get('show_tax_in_basket'));
            
$smarty->assign("show_uom_in_basket", $basket_config->get('show_uom_in_basket'));	

//points system
$smarty->assign('points_system_is_active', stPoints::isPointsSystemActive());
$smarty->assign('points_shortcut', $config_points->get('points_shortcut', null, true));
$smarty->assign('user_points', stPoints::getUserPoints());
$smarty->assign('currency', stCurrency::getInstance(sfContext::getInstance())->get());
$smarty->assign('is_authenticated', sfContext::getInstance() -> getUser() -> isAuthenticated());

if (sfContext::getInstance()->getUser()->isAuthenticated() == 1)
{
    $smarty->assign("points_value", stPoints::getBasketPointsValue());
}

$smarty->assign('additional_costs_socket', stSocketView::openComponents('stOrderConfirmAdditionalCosts'));

$smarty->display('order_confirm.html');
