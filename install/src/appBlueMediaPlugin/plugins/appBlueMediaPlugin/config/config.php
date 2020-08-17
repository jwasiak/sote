<?php

stPluginHelper::addConfigValue('stPaymentType', 'appBlueMediaPlugin', array('name' => 'appBlueMedia', 'description' => 'Płatność przez serwis Blue Media'));

if (SF_APP == 'backend')
{
    stConfiguration::addModule(array('label' => 'Blue Media', 'route' => '@appBlueMediaBackend', 'icon' => 'appBlueMediaPlugin'), 'Płatności');
    stPluginHelper::addEnableModule('appBlueMediaBackend', 'backend');
    stPluginHelper::addRouting('appBlueMediaBackend', '/bm/:action/*', 'appBlueMediaBackend', 'index', 'backend');    
}
elseif (SF_APP == 'frontend')
{
    stPluginHelper::addEnableModule('appBlueMediaFrontend', 'frontend');
    stPluginHelper::addRouting('appBlueMediaFrontend', '/bm/:action/*', 'appBlueMediaFrontend', 'itn', 'frontend'); 
    stPluginHelper::addRouting('appBlueMediaFrontendItn', '/bm/itn/:hash', 'appBlueMediaFrontend', 'itn', 'frontend');  
    stSocketView::addComponent('stPayment_show_appBlueMedia_info', 'appBlueMediaFrontend', 'showBlik');
    stSocketView::addComponent('under_basket_socket','appBlueMediaFrontend', 'gateway');
    $dispatcher->connect('smarty.slot.append', array('appBlueMediaListener', 'smartySlotAppend'));
    $dispatcher->connect('stOrderActions.postExecuteSave', array('appBlueMediaListener', 'postExecuteSaveOrder', 'last')); 
    $dispatcher->connect('stSmarty.render.order_confirm.html', array('appBlueMediaListener', 'smartyRenderOrderConfirm')); 
}