<?php

if (SF_APP == 'backend') {
    stPluginHelper::addEnableModule('stPaczkomatyBackend', 'backend');
    stPluginHelper::addRouting('stPaczkomatyPlugin', '/paczkomaty/:action/*', 'stPaczkomatyBackend', 'list', 'backend');
    stPluginHelper::addRouting('stPaczkomatyPluginDefault', '/paczkomaty', 'stPaczkomatyBackend', 'list', 'backend');
    stPluginHelper::addRouting('stPaczkomatyCreatePack', '/paczkomaty/create/*', 'stPaczkomatyBackend', 'create', 'backend');

    stSocketView::addComponent('stOrder.backend.delivery', 'stPaczkomatyBackend', 'orderDelivery');
    
    stConfiguration::addModule('stPaczkomatyPlugin', 'group_2', 1);

    $dispatcher->connect('autoStProductActions.postGetPaczkomatyOrCreate', array('stPaczkomatyListener', 'postGetPaczkomatyOrCreate'));
    $dispatcher->connect('autoStProductActions.postUpdatePaczkomatyFromRequest', array('stPaczkomatyListener', 'postUpdatePaczkomatyFromRequest'));
} elseif (SF_APP == 'frontend') {
    stPluginHelper::addEnableModule('stPaczkomatyFrontend', 'frontend');

    stPluginHelper::addRouting('stPaczkomatyPlugin', '/paczkomaty/:action/*', 'stPaczkomatyFrontend', 'index', 'frontend');
    
    stPluginHelper::addRouting('stPaczkomatyShowMap', '/paczkomaty/showMap/:deliveryId', 'stPaczkomatyFrontend', 'showMap', 'frontend');
    
    stSocketView::addComponent('under_basket_socket','stPaczkomatyFrontend', 'basketTerms');

    stSocketView::addComponent('stDeliveryElementOnBasketList','stPaczkomatyFrontend', 'deliveryOnBasketList');
    
    $dispatcher->connect('smarty.slot.append', array('stPaczkomatyListener', 'smartySlotAppend'));
    $dispatcher->connect('stOrderActions.postExecuteConfirm', array('stPaczkomatyListener', 'postOrderConfirm'));
    $dispatcher->connect('stBasketActions.preExecuteIndex', array('stPaczkomatyListener', 'postExecuteIndex'));
    $dispatcher->connect('stOrderActions.postExecuteSave', array('stPaczkomatyListener', 'postExecuteOrderSave', true));
    $dispatcher->connect('stOrderActions.preExecuteSave', array('stPaczkomatyListener', 'preExecuteOrderSave', true));
    $dispatcher->connect('stDeliveryFrontendActions.postExecuteAjaxDeliveryCountryUpdate', array('stPaczkomatyListener', 'postExecuteAjaxDeliveryCountryUpdate'));
}
