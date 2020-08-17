<?php
st_theme_use_stylesheet('stPayment.css');
$smarty->assign("check_configuration",$stEcard->checkPaymentConfiguration());
$smarty->assign('url', 'https://pay.ecard.pl/payment/PS');
if ($stEcard->checkPaymentConfiguration())
{
    // if ($stEcard->getTest())
    // {
    //     $smarty->assign("form_start", form_tag($stEcard->getTestUrl(), array('class' => 'st_form')));
    // }else
    // {
    //     $smarty->assign("form_start", form_tag($stEcard->getUrl(), array('class' => 'st_form')));
    // }
    // $smarty->assign("input_order_number", input_hidden_tag('ORDERNUMBER', $order->getId()));
    // $smarty->assign("input_merchant_id", input_hidden_tag('MERCHANTID', $stEcard->getEcardId()));
    // $smarty->assign("input_order_description", input_hidden_tag('ORDERDESCRIPTION', $order->getId()));
    // $smarty->assign("input_amount", input_hidden_tag('AMOUNT', $stEcard->getOrderAmount(stPayment::getUnpayedAmountByOrder($order))));
    // $smarty->assign("input_currency", input_hidden_tag('CURRENCY', $currency->getCode()));
    // $smarty->assign("input_session_id", input_hidden_tag('SESSIONID', $hash));
    // $smarty->assign("input_name", input_hidden_tag('NAME', $user->getName()));
    // $smarty->assign("input_surname", input_hidden_tag('SURNAME', $user->getSurname()));
    // $smarty->assign("input_autodeposit", input_hidden_tag('AUTODEPOSIT', '1'));
    // $smarty->assign("input_bin", input_hidden_tag('BIN', ''));
    // $smarty->assign("input_language", input_hidden_tag('LANGUAGE', $lang));
    // $smarty->assign("input_charset", input_hidden_tag('CHARSET', 'UTF-8'));
    // $smarty->assign("input_country", input_hidden_tag('COUNTRY', '616'));
    // $smarty->assign("input_js", input_hidden_tag('JS', '1'));
    // $smarty->assign("input_hash", input_hidden_tag('HASH', $hash));
    // $smarty->assign("input_payment_type", input_hidden_tag('PAYMENTTYPE', $stEcard->getPaymentType()));
    // $smarty->assign("input_link_fail", input_hidden_tag('LINKFAIL', 'http://'.$stWebRequest->getHost().'/ecard/returnFail?'));
    // $smarty->assign("input_link_ok", input_hidden_tag('LINKOK', 'http://'.$stWebRequest->getHost().'/ecard/returnSuccess?'));
    // $smarty->assign("input_transparent_pages", input_hidden_tag('TRANSPARENTPAGES', '0'));
    // $smarty->assign("submit_button", submit_tag(__('Zapłać')));
    // $smarty->assign("description", stPaymentType::getSummaryDescriptionByOrderIdAndHash($order->getId()));
    $smarty->assign('params', $params);
}
$smarty->display("ecard_show_payment.html");
?>