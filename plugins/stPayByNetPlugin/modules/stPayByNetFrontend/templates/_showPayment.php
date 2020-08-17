<?php
st_theme_use_stylesheet('stPayment.css');
$smarty->assign('check_configuration', $stPayByNet->checkPaymentConfiguration());
if ($stPayByNet->checkPaymentConfiguration()) {
    $smarty->assign('form_start', form_tag($formUrl, array('class' => 'st_form')));
    $smarty->assign('hidden_hashtrans', input_hidden_tag('hashtrans', $hashtrans));
    $smarty->assign('pay_submit', submit_tag(__('Zapłać')));
}
$smarty->assign('description', stPaymentType::getSummaryDescriptionByOrderIdAndHash($order->getId()));
$smarty->display('paybynet_show_payment.html');