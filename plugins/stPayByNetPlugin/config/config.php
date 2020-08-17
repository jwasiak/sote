<?php

stPluginHelper::addConfigValue('stPaymentType', 'stPayByNetPlugin', array('name' => 'stPayByNet', 'description' => 'Płatność przez serwis PayByNet'));

if (SF_APP == 'backend') {
    stPluginHelper::addEnableModule('stPayByNetBackend', 'backend');
    stPluginHelper::addRouting('stPayByNetPlugin', '/paybynet', 'stPayByNetBackend', 'index', 'backend');
    stConfiguration::addModule('stPayByNetPlugin', 'group_3', 1);
}

if (SF_APP == 'frontend') { 
    stPluginHelper::addEnableModule('stPayByNetFrontend', 'frontend');
    stPluginHelper::addRouting('stPayByNetPlugin', '/paybynet/:action/*', 'stPayByNetFrontend', 'index', 'frontend');

    stSocketView::addComponent('stPayment_show_stPayByNet_info', 'stPayByNetFrontend', 'showPaymentType');
    stSocketView::addComponent('under_basket_socket', 'stPayByNetFrontend', 'paymentTypeHidden');

    $dispatcher->connect('stOrderActions.postExecuteSave', array('stPayByNetListener', 'postExecuteOrderSave'));
}
