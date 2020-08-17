<?php

stPluginHelper::addConfigValue('stPaymentType', 'stPayNowPlugin', array('name' => 'stPayNow', 'description' => 'Płatność przez serwis Paynow'));


if (SF_APP == 'frontend')
{
    stPluginHelper::addEnableModule('stPayNowFrontend', 'frontend');
    stPluginHelper::addRouting('stPayNowReturn', '/paynow/return/:id/:hash_code', 'stPayNowFrontend', 'return', 'frontend');
    stPluginHelper::addRouting('stPayNowNotify', '/paynow/notify/:token', 'stPayNowFrontend', 'notify', 'frontend');
    stPluginHelper::addRouting('stPayNowFail', '/paynow/fail/:id/:hash_code', 'stPayNowFrontend', 'fail', 'frontend');
}

if (SF_APP == 'backend')
{
    stPluginHelper::addEnableModule('stPayNowBackend', 'backend');
    stPluginHelper::addRouting('stPayNowPlugin', '/paynow/:action/*', 'stPayNowBackend', 'index', 'backend');
    stPluginHelper::addRouting('stPayNowNotify', '/paynow/notify/:token', 'stPayNowFrontend', 'notify', 'backend');
    stConfiguration::addModule(array('label' => 'Paynow', 'route' => '@stPayNowPlugin', 'icon' => 'stPayNowPlugin'), 'Płatności');
}