<?php
st_theme_use_stylesheet('stPaypal.css');
$smarty->assign('already_payed', $order->getIsPayed() || strpos($order_payment->getHash(), 'PAYPAL-') !== false);
$smarty->assign('paypal_button', link_to(image_tag('https://www.paypal.com/' . stPaypal::getButtonLocaleByCulture($sf_user->getCulture()) . '/i/btn/btn_xpressCheckout.gif', array('alt' => __('Zapłać w systemie PayPal'))), '@stPaypalSetExpressCheckout?order_id=' . $order->getId() . '&order_hash=' . $order->getHashCode()));
$smarty->assign('description', stPaymentType::getSummaryDescriptionByOrderIdAndHash($order->getId()));
$smarty->display('paypal_show_payment.html');
