<?php

use_helper('stCurrency');

sfLoader::loadHelpers('stProduct', 'stProduct');

$smarty->assign('created_at', $order->getCreatedAt());

$smarty->assign('id', $order->getId());

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

$smarty->assign('billing_full_phone', $order->getOrderUserDataBilling()->getPhone());


$smarty->assign('delivery_company', $order->getOrderUserDataDelivery()->getCompany());

$smarty->assign('delivery_full_name', $order->getOrderUserDataDelivery()->getFullName());

$smarty->assign('delivery_address', $order->getOrderUserDataDelivery()->getAddress());

$smarty->assign('delivery_address_more', $order->getOrderUserDataDelivery()->getAddressMore());

$smarty->assign('delivery_region', $order->getOrderUserDataDelivery()->getRegion());

$smarty->assign('delivery_code_town', $order->getOrderUserDataDelivery()->getCode() . '  ' . $order->getOrderUserDataDelivery()->getTown());

$smarty->assign('delivery_full_phone', $order->getOrderUserDataDelivery()->getPhone());

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

        $options = '('.ltrim($options, ', ').')';
    }

    $row['name'] = $product->getName() . " " . $options;

    $row['netto'] = st_currency_format($product->getPriceNetto(true));

    $row['vat'] = $product->getVat();

    $row['brutto'] = st_currency_format($product->getPriceBrutto(true));

    $row['quantity'] = $product->getQuantity();
    
    $row['uom'] = st_product_uom($product->getProduct());

    $row['total_amount'] = st_currency_format($product->getTotalAmount(true, true));

    $results[] = $row;
}

$total_amount = $order->getTotalAmount(true, true);

$final_total_amount = $order->getUnpaidAmount();

$smarty->assign('total_amount_plain', st_currency_format($total_amount));

$smarty->assign('total_amount', st_currency_format($total_amount));

if ($order->getPaidAmount() > 0)
{
   $smarty->assign('paid', st_currency_format($order->getPaidAmount()));
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

$smarty->assign('delivery_cost', st_currency_format($order->getOrderDelivery()->getCostBrutto(true)));

$smarty->assign('create_account', $create_account);

$smarty->assign('password', $password);


if (!$sf_context->getUser()->isAuthenticated() && stUser::isFullAccount($order->getSfGuardUser()->getUsername()) && $order->getSfGuardUser()->getIsConfirm() == 1)
{

    $smarty->assign('order_submit', link_to(__('Potwierdź zamówienie'), '@stOrderConfirmForUser?id=' . $order->getId() . '&hash_code=' . $order->getHashCode() . '&register=0' . '&cancel=0', 'absolute=true'));

    $smarty->assign('order_submit_text', __('Twoje zamówienie nie będzie zrealizowane dopóki go nie potwierdzisz.'));
}


if ($sf_context->getUser()->isAuthenticated() && !stUser::isFullAccount($order->getSfGuardUser()->getUsername()))
{

    $smarty->assign('order_submit', link_to(__('Potwierdź zamówienie'), '@stOrderConfirmForUser?id=' . $order->getId() . '&hash_code=' . $order->getHashCode() . '&register=0' . '&cancel=0', 'absolute=true'));

    $smarty->assign('order_submit_text', __('Twoje zamówienie nie będzie zrealizowane dopóki go nie potwierdzisz.'));
}


if (stUser::isFullAccount($order->getSfGuardUser()->getUsername()) && $order->getSfGuardUser()->getIsConfirm() == 0)
{

    $smarty->assign('order_submit', link_to(__('Potwierdź zamówienie i rejestrację konta'), '@stOrderConfirmForUser?id=' . $order->getId() . '&hash_code=' . $order->getHashCode() . '&register=1' . '&cancel=0', 'absolute=true'));

    $smarty->assign('order_submit_text', __('Twoje zamówienie nie będzie zrealizowane dopóki go nie potwierdzisz. Skorzystaj z linku powyżej aby potwierdzić zamówienie i aktywować konto.'));
}

$smarty->assign('results', $results);

$smarty->display('order_send_order_to_user_plain_mail.html');
