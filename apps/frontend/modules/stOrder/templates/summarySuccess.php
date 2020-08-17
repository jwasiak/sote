<?php
use_helper('stOrder', 'stCurrency', 'stUrl');
st_theme_use_stylesheet('stOrder.css');
st_theme_use_stylesheet('stUser.css');

$smarty->assign('admin', $admin);

if($admin!=1){

$smarty->assign('order_number', $order->getNumber());
$smarty->assign('instance', $order);
$smarty->assign('id', $id);
$smarty->assign('hash_code', $hash_code);
$smarty->assign('order_session_hash', $order->getSessionHash());
$smarty->assign('session_hash', session_id());
$smarty->assign('payment_url', st_url_for('@stPaymentPay?id='.$id.'&hash_code='.$hash_code));
$smarty->assign('show_payment_button', $order->showPayment());
$smarty->assign('payment_type_summary_description', stPaymentType::getSummaryDescriptionByOrderIdAndHash($id, $hash_code));
$smarty->assign('order_total_amount', st_currency_format($total_amount));
$smarty->assign('order_total_points_value', stPoints::getOrderTotalPointsValue($order));
$smarty->assign('order_total_points_earn', stPoints::getOrderTotalPointsEarn($order));

$payment_name = $order->getOrderPayment()->getPaymentType()->getModuleName();
if ($payment_name == 'stSantander' || $payment_name == 'stLukas') {
    $smarty->assign('credit', 1);
}

//points system
$smarty->assign('points_system_is_active', stPoints::isPointsSystemActive());
$smarty->assign('points_shortcut', $config_points->get('points_shortcut', null, true));

$smarty->assign('order_summary_socket', stSocketView::openComponents('stOrderSummary'));
$smarty->assign('order_summary_socket_after_amount', stSocketView::openComponents('stOrderSummaryAfterAmount'));

if($order_summary_text && $order_summary_text->getActive()==1) 
{
	$smarty->assign('order_summary_text', str_replace(array('{NUMBER}', '{COMPANY}', '{VATNUMBER}', '{STREET}', '{HOUSE}', '{FLAT}', '{CODE}', '{TOWN}', '{PHONE}', '{FAX}', '{BANK}', '{EMAIL}'), array($order->getNumber(), $company, $nip, $street, $house, $flat, $code, $town, $phone, $fax, $bank, $email), $order_summary_text->getContent()));
}

}

$smarty->display('order_summary.html');