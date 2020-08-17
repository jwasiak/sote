<?php

stPluginHelper::addConfigValue('stPaymentType', 'stCashBillPlugin', array('name' => 'stCashBill', 'description' => 'Płatność przez serwis CashBill'));

if (SF_APP == 'backend') {
    stPluginHelper::addEnableModule('stCashBillBackend', 'backend');
    stPluginHelper::addRouting('stCashBillPlugin', '/cashbill', 'stCashBillBackend', 'index', 'backend');
    stConfiguration::addModule('stCashBillPlugin', 'group_3', 1);
} elseif (SF_APP == 'frontend') {
    stLanguage::addModuleToRemoveLangParameter('stCashBillFrontend', 'return');
    stPluginHelper::addRouting('stCashBillPlugin', '/cashbill/:action/*', 'stCashBillFrontend', 'index', 'frontend');
    stPluginHelper::addRouting('stCashBillPluginNewPayment', '/cashbill/newPayment/:id/:hash', 'stCashBillFrontend', 'newPayment', 'frontend');
    stPluginHelper::addRouting('stCashBillPluginNewPaymentFail', '/cashbill/newPaymentFail', 'stCashBillFrontend', 'newPaymentFail', 'frontend');
    stPluginHelper::addEnableModule('stCashBillFrontend', 'frontend');
}
