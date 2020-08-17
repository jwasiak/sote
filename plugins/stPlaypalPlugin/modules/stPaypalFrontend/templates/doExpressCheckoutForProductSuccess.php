<?php
st_theme_use_stylesheet('stPaypal.css');

$smarty->assign('successful', $paypal_response->isSuccessful());
$smarty->assign('already_payed', $paypal_response->hasError(10412) || $paypal_response->hasError(10415));
$smarty->assign('pending', $paypal_response->getPaymentStatus() == 'Pending');
$smarty->assign('paypal_button', link_to(image_tag('https://www.paypal.com/' . stPaypal::getButtonLocaleByCulture($sf_user->getCulture()) . '/i/btn/btn_xpressCheckout.gif', array('alt' => __('Zapłać w systemie PayPal'))), '@stPaypalSetExpressCheckout?order_id=' . $order_id . '&order_hash=' . $hash_code));

$smarty->display('paypal_return.html');
