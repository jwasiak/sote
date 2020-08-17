<?php
/** 
 * SOTESHOP/stAddPricePlugin
 * 
 * 
 * @package     stAddPricePlugin
 * @author      Bartosz Alejski <bartosz.alejski@sote.pl>
 */

/**
 * Włączanie modułów
 */

stPluginHelper::addEnableModule('appAddPriceFrontend', 'frontend');


/**
 * Routingi
 */

if (SF_APP == 'backend')
{

stPluginHelper::addEnableModule('appAddPriceBackend', 'backend');
stPluginHelper::addEnableModule('appAddGroupPriceBackend', 'backend');

stPluginHelper::addRouting('appAddPricePlugin', '/addPrice/:action/*', 'appAddPriceBackend', 'list', 'backend');

$dispatcher->connect('stAdminGenerator.generateStProduct', array('appAddPricePluginListener', 'generateStProduct'));
$dispatcher->connect('stAdminGenerator.generateStGroupPriceBackend', array('appAddPricePluginListener', 'generateStGroupPrice'));

$dispatcher->connect('autoStProductActions.postGetAddPriceOrCreate', array('appAddPricePluginListener', 'postGetAddPriceOrCreate'));
$dispatcher->connect('autoStGroupPriceBackendActions.postGetAddGroupPriceOrCreate', array('appAddPricePluginListener', 'postGetAddGroupPriceOrCreate'));

$dispatcher->connect('autoStProductActions.postUpdateAddPriceFromRequest', array('appAddPricePluginListener', 'postUpdateAddPriceFromRequest'));
$dispatcher->connect('autoStGroupPriceBackendActions.postUpdateAddGroupPriceFromRequest', array('appAddPricePluginListener', 'postUpdateAddGroupPriceFromRequest'));

$dispatcher->connect('autoStProductActions.addAddPriceFiltersCriteria', array('appAddPricePluginListener', 'addAddPriceFiltersCriteria'));
$dispatcher->connect('autoStGroupPriceBackendActions.addAddGroupPriceFiltersCriteria', array('appAddPricePluginListener', 'addAddGroupPriceFiltersCriteria'));

stLicenseTypeHelper::addCommercialModule('appAddPricePlugin');

}
elseif (SF_APP == 'frontend')
{
	$dispatcher->connect('Product.postHydrate', array('appAddPricePluginListener', 'productPostHydrate'));
	$dispatcher->connect('ProductOptionsValue.postHydrate', array('appAddPricePluginListener', 'productOptionsValuePostHydrate'));
	$dispatcher->connect('ProductPeer.postAddSelectColumns', array('appAddPricePluginListener', 'productPostAddSelectColumns'));
	$dispatcher->connect('BasePeer.preDoSelectRs', array('appAddPricePluginListener', 'preDoSelectRs'));	
}