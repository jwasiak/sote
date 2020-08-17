<?php
st_theme_use_stylesheet('stPayment.css');
$smarty->assign("check_configuration",$stMoneybookers->checkPaymentConfiguration());
if ($stMoneybookers->checkPaymentConfiguration())
{
    $smarty->assign("form_start", form_tag($stMoneybookers->getUrl(), array('class' => 'st_form')));
    $smarty->assign("input_pay_to_email", input_hidden_tag('pay_to_email', $stMoneybookers->getPayToEmail()));
    $smarty->assign("input_recipient_description", input_hidden_tag('recipient_description', $stMoneybookers->getShopDescription()));
    $smarty->assign("input_transaction_id", input_hidden_tag('transaction_id', $order->getId()));
    $smarty->assign("input_return_url", input_hidden_tag('return_url', 'http://'.$stWebRequest->getHost().'/moneybookers/returnSuccess'));
    $smarty->assign("input_return_url_text", input_hidden_tag('return_url_text', $stMoneybookers->getReturnText()));
    $smarty->assign("input_cancel_url", input_hidden_tag('cancel_url', 'http://'.$stWebRequest->getHost().'/moneybookers/returnFail'));
    $smarty->assign("input_status_url", input_hidden_tag('status_url', 'http://'.$stWebRequest->getHost().'/moneybookers/statusReport'));
    $smarty->assign("input_language", input_hidden_tag('language', $lang));
    $smarty->assign("input_firstname", input_hidden_tag('firstname', $user->getName()));
    $smarty->assign("input_lastname", input_hidden_tag('lastname', $user->getSurname()));
    $smarty->assign("input_address", input_hidden_tag('address', $user->getStreet().' '.$user->getHouse().''.$user->getFlat()));
    $smarty->assign("input_postal_code", input_hidden_tag('postal_code', $user->getCode()));
    $smarty->assign("input_city", input_hidden_tag('city', $user->getTown()));
    $smarty->assign("input_country", input_hidden_tag('country', $country->getIsoA3()));
    $smarty->assign("input_amount", input_hidden_tag('amount', $stMoneybookers->getOrderAmount(stPayment::getUnpayedAmountByOrder($order))));
    $smarty->assign("input_currency", input_hidden_tag('currency', $order->getOrderCurrency()->getShortcut()));
    $smarty->assign("input_detail1_description", input_hidden_tag('detail1_description', __('Numer zamówienia:')));
    $smarty->assign("input_detail1_text", input_hidden_tag('detail1_text', $order->getId()));
    $smarty->assign("input_merchant_fields", input_hidden_tag('merchant_fields', 'hash, referring_platform'));
    $smarty->assign("input_hash", input_hidden_tag('hash', $hash));
    $smarty->assign("input_referring_platform", input_hidden_tag('referring_platform', 'SOTESHOP'));
    $smarty->assign("input_hide_login", input_hidden_tag('hide_login', 1));
    $smarty->assign("input_pay_from_email", input_hidden_tag('pay_from_email', $order->getGuardUser()->getUsername()));
    $smarty->assign("input_payment_methods", input_hidden_tag('payment_methods', "ACC,PWY,"));
    $smarty->assign("submit_button", submit_tag(__('Zapłać')));
    $smarty->assign("description", stPaymentType::getSummaryDescriptionByOrderIdAndHash($order->getId()));
}
$smarty->display("moneybookers_show_payment.html");