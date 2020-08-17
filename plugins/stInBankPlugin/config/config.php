<?php

stPluginHelper::addConfigValue('stPaymentType', 'stInBankPlugin', array('name' => 'stInBank', 'description' => 'Płatność przez serwis RATY Inbank'));

if (SF_APP == 'backend')
{
    stPluginHelper::addEnableModule('stInBankBackend', 'backend');
    stPluginHelper::addRouting('stInBankBackend', '/inbank/:action/*', 'stInBankBackend', 'index', 'backend');
    stConfiguration::addModule(array('label' => 'RATY Inbank', 'route' => '@stInBankBackend', 'icon' => 'stInBankPlugin'), 'Płatności');
} 

if (SF_APP == 'frontend')
{
    stPluginHelper::addEnableModule('stInBankFrontend', 'frontend');
    stPluginHelper::addRouting('stInBankFrontend', '/inbank/:action/*', 'stInBankFrontend', 'config', 'frontend');
    $dispatcher->connect('smarty.slot.append', array('stInBankListener', 'smartySlotAppend'));
    stSocketView::addComponent('stPayment_show_stInBank_info', 'stInBankFrontend', 'calculate');
}

stLicenseTypeHelper::addCommercialModule('stInBankPlugin');