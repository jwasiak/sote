<?php


if (SF_APP == 'backend')
{
    stPluginHelper::addEnableModule('stPocztaPolskaBackend', 'backend');
    stPluginHelper::addRouting('stPocztaPolskaBackend', '/poczta-polska/:action/*', 'stPocztaPolskaBackend', 'list', 'backend');
    stLicenseTypeHelper::addCommercialModule('stPocztaPolskaBackend');
    stSocketView::addComponent('stOrder.backend.delivery', 'stPocztaPolskaBackend', 'orderDelivery');
    stConfiguration::addModule(array('label' => 'Poczta Polska', 'route' => '@stPocztaPolskaBackend?action=config', 'icon' => 'stPocztaPolskaPlugin'), 'Konfiguracja modułów');

}
elseif (SF_APP == 'frontend')
{
    stPluginHelper::addEnableModule('stPocztaPolskaFrontend', 'frontend');
    stPluginHelper::addRouting('stPocztaPolskaFrontend', '/poczta-polska/:action/*', 'stPocztaPolskaFrontend', 'chooseDeliveryPoint', 'frontend');
    stSocketView::addComponent('stDeliveryElementOnBasketList', 'stPocztaPolskaFrontend', 'chooseDeliveryPoint');
    stSocketView::addPartial('under_basket_socket', 'stPocztaPolskaFrontend/basket_socket');
    $dispatcher->connect('stOrderActions.postExecuteConfirm', array('stPocztaPolskaListener', 'postOrderConfirm'));
    $dispatcher->connect('stOrderActions.postExecuteSave', array('stPocztaPolskaListener', 'postExecuteOrderSave', true));
    $dispatcher->connect('stOrderActions.preExecuteSave', array('stPocztaPolskaListener', 'preExecuteOrderSave', true));
    $dispatcher->connect('stOrderActions.preExecuteSave', array('stPocztaPolskaListener', 'preExecuteOrderSave', true));
    $dispatcher->connect('stOrderActions.filterOrderSave', array('stPocztaPolskaListener', 'filterOrderSave', true));
    $dispatcher->connect('stDeliveryFrontendActions.postExecuteAjaxDeliveryCountryUpdate', array('stPocztaPolskaListener', 'postExecuteAjaxDeliveryCountryUpdate'));
    $dispatcher->connect('smarty.slot.append', array('stPocztaPolskaListener', 'smartySlotAppend'));
}