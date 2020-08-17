<?php
st_theme_use_stylesheet('stTrustedShopsPlugin.css');
$smarty->assign('certificate', $certificate);
$smarty->assign('amount', $amount);
$smarty->assign('price', $price);
$smarty->assign('currency', $currency);
$smarty->assign('checkbox', checkbox_tag('trusted_shops', '1', $checked, array('id' => 'trustedShopsCheckbox' ,'onClick' => "jQuery(function($){stDelivery.executeAjaxUpdate($(stDelivery.deliveryPaymentChecked),'".url_for('stTrustedShopsFrontend/ajaxBasketUpdate')."', {ts_checked:$('#trustedShopsCheckbox').attr('checked')})})")));
$smarty->display("trusted_shops_buyer_protection_excellence.html");