<?php

use_helper('Number', 'stCurrency', 'Date', 'stDelivery');

sfLoader::loadHelpers('stProduct', 'stProduct');

$smarty->assign('host', $sf_request->getHost());

$smarty->assign('created_at', date("d-m-Y H:i", strtotime($order->getCreatedAt())));

$smarty->assign('number', $order->getNumber());

$smarty->assign('username', $order->getSfGuardUser()->getUsername());

$smarty->assign('billing_company', $order->getOrderUserDataBilling()->getCompany());

$smarty->assign('vat_nr', $order->getOrderUserDataBilling()->getVatNumber());

$smarty->assign('billing_full_name', $order->getOrderUserDataBilling()->getFullName());

$smarty->assign('billing_address', $order->getOrderUserDataBilling()->getAddress());

$smarty->assign('billing_address_more', $order->getOrderUserDataBilling()->getAddressMore());

$smarty->assign('billing_region', $order->getOrderUserDataBilling()->getRegion());

$smarty->assign('billing_pesel', $order->getOrderUserDataBilling()->getPesel());

$smarty->assign('billing_code_town', $order->getOrderUserDataBilling()->getCode() . '  ' . $order->getOrderUserDataBilling()->getTown());

$smarty->assign('billing_country', $order->getOrderUserDataBilling()->getCountry());

$smarty->assign('billing_full_phone', $order->getOrderUserDataBilling()->getPhone());

$smarty->assign('delivery_company', $order->getOrderUserDataDelivery()->getCompany());

$smarty->assign('delivery_full_name', $order->getOrderUserDataDelivery()->getFullName());

$smarty->assign('delivery_address', $order->getOrderUserDataDelivery()->getAddress());

$smarty->assign('delivery_address_more', $order->getOrderUserDataDelivery()->getAddressMore());

$smarty->assign('delivery_region', $order->getOrderUserDataDelivery()->getRegion());

$smarty->assign('delivery_code_town', $order->getOrderUserDataDelivery()->getCode() . '  ' . $order->getOrderUserDataDelivery()->getTown());

$smarty->assign('delivery_country', $order->getOrderUserDataDelivery()->getCountry());

$smarty->assign('delivery_full_phone', $order->getOrderUserDataDelivery()->getPhone());

$total_points_value = 0;
$order_for_points = 0;
foreach ($order->getOrderProducts() as $product){
    if($product->getProductForPoints()){
        $total_points_value += $product->getPointsValue() * $product->getQuantity();
        $order_for_points = 1;    
    }
}  


$results = array();

foreach ($order->getOrderProducts() as $product)
{
    $row['instance'] = $product;
    
    $row['code'] = $product->getCode();

    $options = '';

    if ($product->hasPriceModifiers())
    {
        foreach ($product->getPriceModifiers() as $price_modifier)
        {
            if (isset($price_modifier['custom']['field']))
            {
                $options .= ', '.$price_modifier['custom']['field'].': '.$price_modifier['label'];
            }
            else
            {
                $options .= ', '.$price_modifier['label'];
            }
        }

        $options = '(' . ltrim($options, ', ') . ')';
    }

    $row['name'] = $product->getName() . '<br/>' . $options;

    $row['netto'] = st_currency_format($product->getPriceNetto(true));

    $row['vat'] = $product->getVat();

    $row['brutto'] = st_currency_format($product->getPriceBrutto(true));
    
    if($product->getPointsValue() * $product->getQuantity() == 0){
       $row['points_value'] = "";
       $row['points_sum_value'] = "";   
    }else{
       $row['points_value'] = $product->getPointsValue();
       $row['points_sum_value'] = $product->getPointsValue() * $product->getQuantity();
    }

    $row['is_item_by_points'] = $product->getProductForPoints();

    $row['quantity'] = $product->getQuantity();
    
    $row['uom'] = st_product_uom($product->getProduct());

    $row['total_amount'] = st_currency_format($product->getTotalAmount(true, true));

    $results[] = $row;
}

$total_amount = $order->getTotalAmount(true, true, false);

$final_total_amount = $order->getUnpaidAmount();

$smarty->assign('total_amount_plain', st_currency_format($total_amount));

$smarty->assign('total_amount', st_currency_format($total_amount));

if ($order->getPaidAmount() > 0)
{
   $smarty->assign('paid', st_currency_format($order->getPaidAmount()));
}

if ($order->hasDiscount())
{
    $smarty->assign('discount', st_currency_format($order->getTotalProductDiscountAmount(true, true)));
    $smarty->assign('discount_name', $order->getDiscount()->getName());
}

$smarty->assign('front_symbol', st_front_symbol());

$smarty->assign('total_amount_html', st_currency_format($final_total_amount));

$smarty->assign('final_total_amount', st_currency_format($final_total_amount));

$smarty->assign('back_symbol', st_back_symbol());

$payments = array();

foreach ($order->getOrderPayments() as $payment)
{
    $payments[] = $payment->getGiftCardId() ? __('Bon zakupowy: %code%', array('%code%' => $payment->getGiftCard()->getCode())) : $payment->getPaymentType()->getName();
}

$smarty->assign('payment_name',  implode(', ', $payments));


$smarty->assign('delivery_name', $order->getOrderDelivery()->getName());

$smarty->assign('delivery_date', getDeliveryDateFormat($order->getOrderDelivery()->getDeliveryDate()));

$smarty->assign('delivery_cost', st_currency_format($order->getOrderDelivery()->getCostBrutto(true)));

$smarty->assign('comment', $order->getDescription());

$smarty->assign('create_account', $create_account);

$smarty->assign('password', $password);

$color_link = "color:#".$mail_config->get('bg_action_link_color');

if ($sf_context->getUser()->isAuthenticated() && stUser::isFullAccount($order->getSfGuardUser()->getUsername()))
{

}
elseif (stUser::isFullAccount($order->getSfGuardUser()->getUsername()) && $order->getSfGuardUser()->getIsConfirm() == 0)
{
    $smarty->assign('order_confirm', array(
        'url' => st_url_for('@stOrderConfirmForUser?id=' . $order->getId() . '&hash_code=' . $order->getHashCode() . '&register=1' . '&cancel=0'),
        'label' => __('Potwierdź zamówienie i rejestrację konta'),
    ));

    $smarty->assign('order_submit', link_to(__('Potwierdź zamówienie i rejestrację konta'), '@stOrderConfirmForUser?id=' . $order->getId() . '&hash_code=' . $order->getHashCode() . '&register=1' . '&cancel=0', array('style' => $color_link, 'absolute' => true)));

    // $smarty->assign('order_submit_text', __('Twoje zamówienie nie będzie zrealizowane dopóki go nie potwierdzisz. Skorzystaj z linku powyżej aby potwierdzić zamówienie i aktywować konto.')); 
}
else
{
    $smarty->assign('order_confirm', array(
        'url' => st_url_for('@stOrderConfirmForUser?id=' . $order->getId() . '&hash_code=' . $order->getHashCode() . '&register=0' . '&cancel=0'),
        'label' => __('Potwierdź zamówienie'),
    ));
    
    $smarty->assign('order_submit', link_to(__('Potwierdź zamówienie'), '@stOrderConfirmForUser?id=' . $order->getId() . '&hash_code=' . $order->getHashCode() . '&register=0' . '&cancel=0', array('style' => $color_link, 'absolute' => true)));
    // $smarty->assign('order_submit_text', __('Twoje zamówienie nie będzie zrealizowane dopóki go nie potwierdzisz.'));  
}

$smarty->assign('results', $results);

$smarty->assign('user_head', $head);

$smarty->assign('user_foot', $foot);

$smarty->assign('user_content_head', $head_content);

$smarty->assign('user_content_foot', $foot_content);

if($webpage_terms_in_mail!=""){
$smarty->assign('webpage_terms_content', $webpage_terms_in_mail->getContent());

$smarty->assign('webpage_terms_name', $webpage_terms_in_mail->getName());
}

if($webpage_right_2_cancel_in_mail!=""){
$smarty->assign('webpage_right_2_cancel_content', $webpage_right_2_cancel_in_mail->getContent());

$smarty->assign('webpage_right_2_cancel_name', $webpage_right_2_cancel_in_mail->getName());
}

//points system
$smarty->assign('points_system_is_active', stPoints::isPointsSystemActive());
$smarty->assign('points_shortcut', $config_points->get('points_shortcut', null, true));
$smarty->assign('total_points_value', $total_points_value);
$smarty->assign('order_for_points', $order_for_points);
$smarty->assign('order_total_points_earn', stPoints::getOrderTotalPointsEarn($order));
$smarty->assign('payment_url', st_url_for('@stPaymentPay?id='.$order->getId().'&hash_code='.$order->getHashCode()));
$smarty->assign('show_payment_button', $order->showPayment());

$smarty->assign('additional_costs_socket', stSocketView::openComponents('stOrderMailToUserAdditionalCosts', array('order' => $order)));

$smarty->assign('bg_header_color', $mail_config->get('bg_header_color'));
$smarty->assign('bg_footer_color', $mail_config->get('bg_footer_color'));
$smarty->assign('bg_action_color', $mail_config->get('bg_action_color'));
$smarty->assign('bg_action_link_color', $mail_config->get('bg_action_link_color'));
$smarty->assign('link_color', $mail_config->get('link_color'));
$smarty->assign('logo', $mail_config->get('logo'));

$smarty->display('order_send_order_to_user_html_mail.html');
