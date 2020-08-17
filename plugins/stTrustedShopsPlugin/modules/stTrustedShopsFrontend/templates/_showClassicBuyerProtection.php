<?php
st_theme_use_stylesheet('stTrustedShopsPlugin.css');
$smarty->assign('certificate', $certificate);
$smarty->assign('form', form_tag('https://www.trustedshops.com/shop/protection.php', array('id' => 'trustedShopsForm', 'target' => '_blank')));
$smarty->assign('charset', input_hidden_tag('charset', 'UTF-8'));
$smarty->assign('shopId', input_hidden_tag('shop_id', $certificate));
$smarty->assign('email', input_hidden_tag('email', $email));
$smarty->assign('amount', input_hidden_tag('amount', $orderAmount));
$smarty->assign('curr', input_hidden_tag('curr', $currency));
$smarty->assign('paymentType', input_hidden_tag('paymentType', $paymentType));
$smarty->assign('kdnr', input_hidden_tag('kdnr', $userId));
$smarty->assign('ordernr', input_hidden_tag('ordernr', $orderId));
$smarty->display("trusted_shops_buyer_protection_classic.html");