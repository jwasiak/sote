<?php

stPluginHelper::addConfigValue('stPaymentType', 'stPaypalPlugin', array('name' => 'stPaypal', 'description' => 'Płatność przez serwis Paypal'));

if (SF_APP == 'frontend') {
    stPluginHelper::addEnableModule('stPaypalFrontend', 'frontend');
    stPluginHelper::addRouting('stPaypalDoExpressCheckout', '/paypal/do-express-checkout/:order_id/:order_hash', 'stPaypalFrontend', 'doExpressCheckout', 'frontend');
    stPluginHelper::addRouting('stPaypalSetExpressCheckout', '/paypal/set-express-checkout/:order_id/:order_hash', 'stPaypalFrontend', 'setExpressCheckout', 'frontend');
    stPluginHelper::addRouting('stPaypalIpn', '/paypal/ipn/:order_id/:order_hash', 'stPaypalFrontend', 'ipn', 'frontend');
    stPluginHelper::addRouting('stPaypalBuyProduct', '/paypal/buy-product/:product_id', 'stPaypalFrontend', 'buyProduct', 'frontend');
    stPluginHelper::addRouting('stPaypalCreateOrder', '/paypal/create-order', 'stPaypalFrontend', 'createOrder', 'frontend');
    stPluginHelper::addRouting('stPaypalDoExpressCheckoutForProduct', '/paypal/do-express-checkout-for-product/:order_id/:order_hash/:token', 'stPaypalFrontend', 'doExpressCheckoutForProduct', 'frontend');
}

if (SF_APP == 'backend') {
    stPluginHelper::addEnableModule('stPaypalBackend', 'backend');
    stPluginHelper::addRouting('stPaypalPlugin', '/paypal', 'stPaypalBackend', 'config', 'backend');
    stPluginHelper::addRouting('stPaypalActionPlugin', '/paypal/:action/*', 'stPaypalBackend', null, 'backend');
    stConfiguration::addModule('stPaypalPlugin', 'group_3', 1);
}
