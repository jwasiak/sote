<?php
st_theme_use_stylesheet('stPayment.css');
st_theme_use_stylesheet('stCashBillPlugin.css');
$smarty->assign('check_configuration', $stCashBill->checkPaymentConfiguration());
if ($stCashBill->checkPaymentConfiguration()) {
    $smarty->assign('form_start', form_tag('@stCashBillPluginNewPayment?id='.$order->getId().'&hash='.$order->getHashCode(), array('class' => 'st_form', 'id' => 'st_cashbill_form_new_payment')));
    $smarty->assign('pay_submit', submit_tag(__('Zapłać')));
    $smarty->assign('channels', $channels);
    $smarty->assign('redirect', $redirect);
    $smarty->assign('show_variant', $stCashBill->getShowVariant());
}
$smarty->assign('description', stPaymentType::getSummaryDescriptionByOrderIdAndHash($order->getId()));
$smarty->display('cashbill_show_payment.html');
