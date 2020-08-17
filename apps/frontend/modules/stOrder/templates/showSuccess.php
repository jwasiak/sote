<?php

use_helper('nifty', 'stOrder', 'stUrl', 'stProductOptions', 'stProductImage', 'stDelivery');

sfLoader::loadHelpers('stProduct', 'stProduct');

sfContext::getInstance()->getResponse()->addMeta('robots', "noindex");

st_theme_use_stylesheet('stUser.css');

st_theme_use_stylesheet('stOrder.css');

if ($sf_user->isAuthenticated())
{

    $smarty->assign('user', $sf_user->isAuthenticated());
    
    if(stTheme::is_responsive()):
    
        if($sf_user->checkPassword("anonymous") && $sf_user->getGuardUser()->getExternalAccount()==null)
        {
            $smarty->assign('user', 0);
        }
        else
        {
            $smarty->assign('user', 1);
        }
        
    endif;
    
    if($order->getSfGuardUserId()!=$sf_user->getGuardUser()->getId()){
        $smarty->assign('user', 0);
    }

    $smarty->assign('order_number', __('Zamówienie numer %number%', array('%number%' => $order->getNumber())));

    $smarty->assign('user_panel_menu', st_get_component('stUserData', 'userPanelMenu', array('action'=>'list')));
}

$smarty->assign('order_number', __('Zamówienie numer %number%', array('%number%' => $order->getNumber())));

if ($sf_flash->has('notice'))
{

    $smarty->assign('notice_flash', $sf_flash->has('notice'));

    $smarty->assign('notice', __($sf_flash->get('notice')));
}


if ($user_data_billing->getCompany())
{

    $smarty->assign('user_data_billing_company', $user_data_billing->getCompany());
}

$smarty->assign('user_data_billing_full_name', $user_data_billing->getFullName());

$smarty->assign('user_data_billing_address', $user_data_billing->getAddress());

$smarty->assign('user_data_billing_address_more', $user_data_billing->getAddressMore());

$smarty->assign('user_data_billing_region', $user_data_billing->getRegion());

$smarty->assign('user_data_billing_pesel', $user_data_billing->getPesel());

$smarty->assign('user_data_billing_code', $user_data_billing->getCode());

$smarty->assign('user_data_billing_town', $user_data_billing->getTown());

$smarty->assign('user_data_billing_country', $user_data_billing->getCountry());

$smarty->assign('user_data_billing_phone', $user_data_billing->getPhone());

if ($user_data_billing->getVatNumber())
{

    $smarty->assign('user_data_billing_vat_number', $user_data_billing->getVatNumber());
}

if ($user_data_delivery->getCompany())
{

    $smarty->assign('user_data_delivery_company', $user_data_delivery->getCompany());
}

$smarty->assign('user_data_delivery_full_name', $user_data_delivery->getFullName());

$smarty->assign('user_data_delivery_address', $user_data_delivery->getAddress());

$smarty->assign('user_data_delivery_address_more', $user_data_delivery->getAddressMore());

$smarty->assign('user_data_delivery_region', $user_data_delivery->getRegion());

$smarty->assign('user_data_delivery_code', $user_data_delivery->getCode());

$smarty->assign('user_data_delivery_town', $user_data_delivery->getTown());

$smarty->assign('user_data_delivery_country', $user_data_delivery->getCountry());

$smarty->assign('user_data_delivery_phone', $user_data_delivery->getPhone());

$results = array();

foreach ($order_products as $order_product)
{
    $row['code'] = $order_product->getCode();

    $row['validate'] = $order_product->productValidate();

	if($row['validate'])
    {
        $row['photo'] = st_link_to(st_product_image_tag($order_product, 'icon'), 'stProduct/show?url='.$order_product->getProduct()->getFriendlyUrl());
    }
    else
    {
        $row['photo'] = st_product_image_tag(null, 'icon');
    }

    if ($order_product->productValidate())
    {
        $row['name_show'] = st_link_to($order_product->getName(), 'stProduct/show?url=' . $order_product->getProduct()->getFriendlyUrl());
    }
    else
    {
        $row['name_show'] = $order_product->getName();
    }

    if ($order_product->hasPriceModifiers())
    {
        $row['name_show'] = content_tag('div', $row['name_show'], array('class' => 'st_product_name_with_options')).st_product_options_get_view($order_product);
    }

    $row['price'] = st_order_price_format($order_product->getPriceNetto(true), $currency);

    $row['vat'] = $order_product->getVat();

    $row['price_true'] = st_order_price_format($order_product->getPriceBrutto(true), $currency);
    
    if($order_product->getPointsValue() * $order_product->getQuantity() == 0){
        $row['points_value'] = "";
        $row['points_sum_value'] = "";   
       }else{
        $row['points_value'] = $order_product->getPointsValue();
        $row['points_sum_value'] = $order_product->getPointsValue() * $order_product->getQuantity();
    }
   
    $row['is_item_by_points'] = $order_product->getProductForPoints();
    
    if($order_product->getProductForPoints()){
        $points_value += $order_product->getPointsValue() * $order_product->getQuantity();   
    } 

    $row['quantity'] = $order_product->getQuantity();

    $row['uom'] = st_product_uom($order_product->getProduct());

    $total_amount = $order_product->getTotalAmount(true, true);
    
    $row['total_amount'] = st_order_price_format($total_amount, $currency);

    $results[] = $row;
}

$smarty->assign('total_product_price', st_order_product_total_amount($order));

$smarty->assign("show_code_in_basket", $basket_config->get('show_code_in_basket'));

$smarty->assign("show_photo_in_basket", $basket_config->get('show_photo_in_basket'));

$smarty->assign("show_netto_in_basket", $basket_config->get('show_netto_in_basket'));

$smarty->assign("show_tax_in_basket", $basket_config->get('show_tax_in_basket'));
            
$smarty->assign("show_uom_in_basket", $basket_config->get('show_uom_in_basket'));

if(isset ($payment))
{
   $smarty->assign('payment_name', $payment->getName());
}

$smarty->assign('delivery_number', $delivery->getNumber());

$smarty->assign('delivery_name', $delivery->getName());

if ($delivery->getDeliveryDate() != null)
{
    $smarty->assign('delivery_date', getDeliveryDateFormat($delivery->getDeliveryDate()));
}

if ($order->hasDiscount())
{
    $discount = $order->getTotalProductDiscountAmount(true, true);
    $smarty->assign('discount', st_order_price_format($discount, $currency));
}

$smarty->assign('order_cost', st_order_price_format($delivery->getCost(true), $currency));

$smarty->assign('order_total_amount', st_order_total_amount($order));

$smarty->assign('paid', $order->getPaidAmount() ? st_order_price_format($order->getPaidAmount(), $order->getOrderCurrency()) : null);

$smarty->assign('final_total_amount', st_order_price_format($order->getUnpaidAmount(), $order->getOrderCurrency()));
 
$created_at = explode(" ",$order->getCreatedAt());
$date = explode("-",$created_at[0]);
	

$smarty->assign('created_at', $date[2]."-".$date[1]."-".$date[0]." ".$created_at[1]);

$smarty->assign('status', st_order_status($order->getOrderStatus()));

$smarty->assign('description', $order->getDescription());

$smarty->assign('is_paid', $order->getIsPayed() ? __('tak') : __('nie'));

if ($order->getIsConfirmed() == 0 && $order->getOrderStatusId() == 1)
{

    $smarty->assign('is_confirmed', __('nie'));
}
else
{

    $smarty->assign('is_confirmed', $order->getIsConfirmed() ? __('tak') : link_to(__('potwierdź'), '@stOrderConfirmForUser?id=' . $order->getId() . '&hash_code=' . $order->getHashCode() . '&register=0' . '&cancel=0', array("style"=>"color:green;")));
}

if ($sf_user->isAuthenticated())
{
    if($order->getSfGuardUserId()==$sf_user->getGuardUser()->getId()){
            $smarty->assign('invoice', st_get_component('stInvoicePdf', 'orderInvoice', array('order' => $order)));
    }
}

$smarty->assign('show_payment', !$order->showPayment());

$smarty->assign('payment_url', st_url_for('@stPaymentPay?id='.$order->getId().'&hash_code='.$order->getHashCode()));

$smarty->assign('results', $results);

//points system
$smarty->assign('points_system_is_active', stPoints::isPointsSystemActive());
$smarty->assign('points_shortcut', $config_points->get('points_shortcut', null, true));
$smarty->assign('user_points', stPoints::getUserPoints());
$smarty->assign('currency', stCurrency::getInstance(sfContext::getInstance())->get());
$smarty->assign('is_authenticated', sfContext::getInstance() -> getUser() -> isAuthenticated());
if (isset($points_value)) 
{
    $smarty->assign("points_value", $points_value);
}

$smarty->display('order_show.html');
