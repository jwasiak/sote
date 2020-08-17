<?php
st_theme_use_stylesheet('stPayment.css');
$smarty->assign('check_configuration', ($stEservice->checkPaymentConfiguration() && $tokenStatus));
if ($stEservice->checkPaymentConfiguration() && $tokenStatus) {
    $smarty->assign('params', array(
        'ClientId' => $stEservice->getClientId(),
        'StoreType' => $stEservice->getStoreType(),
        'Token' => $token,
        'TranType' => 'Auth',
        'Total' => $stEservice->parseAmount(stPayment::getUnpayedAmountByOrder($order)),
        'Currency' => $currency->getCode(),
        'OrderId' => $orderId,
        'ConsumerName' => $user->getName(),
        'ConsumerSurname' => $user->getSurname(),
        'okUrl' => $sf_context->getController()->genUrl('@stEservicePlugin?action=returnSuccess', true),
        'failUrl' => $sf_context->getController()->genUrl('@stEservicePlugin?action=returnFail', true),
        'pendingUrl' => $sf_context->getController()->genUrl('@stEservicePlugin?action=returnPending', true),
        'lang' => $lang,
        'hashAlgorithm' => 'ver2',
    ));
    $smarty->assign('url', $stEservice->getPostUrl());
    $smarty->assign('description', stPaymentType::getSummaryDescriptionByOrderIdAndHash($order->getId()));
}
$smarty->display('eservice_show_payment.html');
