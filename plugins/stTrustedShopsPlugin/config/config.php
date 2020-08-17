<?php

if (SF_APP == 'backend') {
	stPluginHelper::addEnableModule('stTrustedShopsBackend', 'backend');
	stPluginHelper::addRouting('stTrustedShopsPlugin', '/trustedshops/:action/*', 'stTrustedShopsBackend', 'index', 'backend');
	$dispatcher->connect('TrustedShops.postSave', array('stTrustedShopsListener', 'saveTrustedShops'));
} 

if (SF_APP == 'frontend') {
	stPluginHelper::addEnableModule('stTrustedShopsFrontend', 'frontend');
	stPluginHelper::addRouting('stTrustedShopsPlugin', '/trustedshops/:action/*', 'stTrustedShopsFrontend', 'index', 'frontend');
	stSocketView::addComponent('stOrderSummary', 'stTrustedShopsFrontend', 'showClassicBuyerProtection');
	//$dispatcher->connect('stDeliveryFrontendComponents.preExecuteBasketSummary', array('stTrustedShopsListener', 'preBasketSummary'));
	$dispatcher->connect('stDeliveryFrontendActions.postExecuteAjaxDeliveryUpdate', array('stTrustedShopsListener', 'postAjaxPaymentUpdate'));
	$dispatcher->connect('stDeliveryFrontendActions.postExecuteAjaxPaymentUpdate', array('stTrustedShopsListener', 'postAjaxPaymentUpdate'));
	//$dispatcher->connect('stBasketActions.preExecuteIndex', array('stTrustedShopsListener', 'preBasketIndex'));
	$dispatcher->connect('stOrderActions.preExecuteConfirm', array('stTrustedShopsListener', 'preOrderConfirm'));
	$dispatcher->connect('stOrderActions.filterOrderSave', array('stTrustedShopsListener', 'postOrderSave'));
	
	stSocketView::addComponent('stOrderSummary', 'stTrustedShopsFrontend', 'orderSummary');
    $dispatcher->connect('smarty.slot.append', array('stTrustedShopsListener', 'append'));
	
}
