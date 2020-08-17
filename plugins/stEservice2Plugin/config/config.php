<?php

stPluginHelper::addConfigValue('stPaymentType', 'stEservice2Plugin', array('name' => 'stEservice2', 'description' => 'Płatność przez serwis eService - Nowe API'));

if (SF_APP == 'backend') {
    stPluginHelper::addEnableModule('stEservice2Backend', 'backend');
    stPluginHelper::addRouting('stEservice2Plugin', '/eservice2', 'stEservice2Backend', 'index', 'backend');
    stConfiguration::addModule('stEservice2Plugin', 'group_3', 1);
} elseif (SF_APP == 'frontend') {
    stLanguage::addModuleToRemoveLangParameter('stEservice2Frontend', 'return');
    stPluginHelper::addRouting('stEservice2Plugin', '/eservice2/:action/*', 'stEservice2Frontend', 'index', 'frontend');
    stPluginHelper::addRouting('stEservice2Notify', '/eservice2/notify/:order_id/:hash/:payment_id', 'stEservice2Frontend', 'notify', 'frontend');
    stPluginHelper::addRouting('stEservice2Return', '/eservice2/return/:order_id/:hash', 'stEservice2Frontend', 'return', 'frontend');
    stPluginHelper::addEnableModule('stEservice2Frontend', 'frontend');
}
