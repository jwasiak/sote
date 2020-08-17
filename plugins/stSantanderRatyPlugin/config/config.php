<?php

stPluginHelper::addConfigValue('stPaymentType', 'stSantaderPlugin', array('name' => 'stSantander', 'description' => 'Płatność eRaty Santander Consumer Bank'));

if (SF_APP == 'frontend')
{
    stPluginHelper::addEnableModule('stSantanderFrontend', 'frontend');
    stPluginHelper::addRouting('stSantanderFrontend', '/eraty-santander/:action/*', 'stSantanderFrontend', 'list', 'frontend');
    $dispatcher->connect('stUserDataActions.validateAddBasketUser', array('stSantanderListener', 'validateAddBasketUser'));
    stSocketView::addComponent('stPayment_show_stSantander_info', 'stSantanderFrontend', 'calculateInBasket');
}
elseif (SF_APP == 'backend')
{
    stConfiguration::addModule(array('label' => 'Santander Consumer Bank', 'route' => '@stSantanderBackend?action=config', 'icon' => 'stSantanderRatyPlugin'), 'Płatności');    
    stPluginHelper::addEnableModule('stSantanderBackend', 'backend');
    stPluginHelper::addRouting('stSantanderBackend', '/eraty-santander/:action/*', 'stSantanderBackend', 'list', 'backend');
}