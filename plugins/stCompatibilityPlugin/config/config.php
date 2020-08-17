<?php

if (SF_APP == 'backend') {
	stPluginHelper::addEnableModule('stCompatibilityBackend', 'backend');
	stPluginHelper::addRouting('stCompatibilityPlugin', '/compatibility/:action/*', 'stCompatibilityBackend', 'index', 'backend');
    stConfiguration::addModule('stCompatibilityPlugin', 'group_2');
} 

if (SF_APP == 'frontend') {
	stPluginHelper::addEnableModule('stCompatibilityFrontend', 'frontend');
	stPluginHelper::addRouting('stCompatibilityPlugin', '/compatibility/:action/*', 'stCompatibilityFrontend', 'index', 'frontend');
    $dispatcher->connect('smarty.slot.append', array('stCompatibilityListener', 'append'));
    $dispatcher->connect('stOrderActions.postExecuteSave', array('stCompatibilityListener', 'postExecuteOrderSave', 'last'));
    stSocketView::addComponent('under_basket_socket','stCompatibilityFrontend','opinionBasketCheckbox');
}
