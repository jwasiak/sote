<?php

stPluginHelper::addConfigValue('stPaymentType', 'stEservicePlugin', array('name' => 'stEservice', 'description' => 'Płatność przez serwis eService'));

if (SF_APP == 'backend') {
    stPluginHelper::addEnableModule('stEserviceBackend', 'backend');
    stPluginHelper::addRouting('stEservicePlugin', '/eservice', 'stEserviceBackend', 'index', 'backend');
    stConfiguration::addModule('stEservicePlugin', 'group_3', 1);
} elseif (SF_APP == 'frontend') {
    stLanguage::addModuleToRemoveLangParameter('stEserviceFrontend', 'return');
    stPluginHelper::addRouting('stEservicePlugin', '/eservice/:action/*', 'stEserviceFrontend', 'index', 'frontend');
    stPluginHelper::addEnableModule('stEserviceFrontend', 'frontend');
}
