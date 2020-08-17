<?php

use_helper('Number', 'stCurrency', 'Date', 'stApplication', 'stDelivery');

sfLoader::loadHelpers('stProduct', 'stProduct');

$smarty->assign('host', $sf_request->getHost());

$smarty->assign('username', $order->getSfGuardUser()->getUsername());

$smarty->assign('created_at', date("d-m-Y H:i", strtotime($order->getCreatedAt())));

$smarty->assign('id', $order->getId());

$smarty->assign('number', $order->getNumber());

$smarty->assign('is_invoice_request', $invoice);

$color_link = "color:#".$mail_config->get('bg_action_link_color');

$smarty->assign('order_link', st_link_to(__("Przejdź do zamówienia."), '@stGoToOrder?order=' . $order->getId(), array('style' => $color_link, 'absolute' => true, 'for_app'=>'backend')));

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

$smarty->assign('user_link', st_link_to(__("Przejdź do konta."), '@stGoToUser?user=' . $order->getSfGuardUser()->getId(), array('style' => $color_link, 'absolute' => true, 'for_app'=>'backend')));

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

$smarty->assign('total_amount_html', st_currency_format($final_total_amount));

$smarty->assign('final_total_amount', st_currency_format($final_total_amount));

$payments = array();

foreach ($order->getOrderPayments() as $payment)
{
    $payments[] = $payment->getGiftCardId() ? __('Bon zakupowy: %code%', array('%code%' => $payment->getGiftCard()->getCode())) : $payment->getPaymentType()->getName();
}

$smarty->assign('payment_name',  implode(', ', $payments));

$smarty->assign('delivery_name', $order->getOrderDelivery()->getDelivery()->getName());

$smarty->assign('delivery_cost', st_currency_format($order->getOrderDelivery()->getCostBrutto(true)));

$smarty->assign('delivery_date', getDeliveryDateFormat($order->getOrderDelivery()->getDeliveryDate()));

$smarty->assign('comment', $order->getDescription());

$smarty->assign('results', $results);

$smarty->assign('user_head', $head);

$smarty->assign('user_foot', $foot);

//points system
$smarty->assign('points_system_is_active', stPoints::isPointsSystemActive());
$smarty->assign('points_shortcut', $config_points->get('points_shortcut', null, true));
$smarty->assign('total_points_value', $total_points_value);
$smarty->assign('order_for_points', $order_for_points);
$smarty->assign('order_total_points_earn', stPoints::getOrderTotalPointsEarn($order));

$smarty->assign('bg_header_color', $mail_config->get('bg_header_color'));
$smarty->assign('bg_footer_color', $mail_config->get('bg_footer_color'));
$smarty->assign('bg_action_color', $mail_config->get('bg_action_color'));
$smarty->assign('bg_action_link_color', $mail_config->get('bg_action_link_color'));
$smarty->assign('link_color', $mail_config->get('link_color'));
$smarty->assign('logo', $mail_config->get('logo'));

$smarty->display('order_send_order_to_admin_html_mail.html');
