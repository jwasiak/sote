<?php
/**
 * SOTESHOP/stDiscountPlugin
 *
 * Ten plik należy do aplikacji stDiscountPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stDiscountPlugin
 * @subpackage  configs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: config.php 17254 2012-02-24 10:56:46Z marcin $
 */

switch (SF_APP){
    case 'backend':

        stPluginHelper::addEnableModule('stDiscountBackend', 'backend');
        stPluginHelper::addEnableModule('stDiscountCouponCodeBackend', 'backend');

        stPluginHelper::addRouting('stDiscountPlugin', '/discount/:action/*', 'stDiscountBackend', 'list', 'backend');
        stPluginHelper::addRouting('stDiscountPluginDefault', '/discount/:action/*', 'stDiscountBackend', 'list', 'backend');

        $dispatcher->connect('stAdminGenerator.generateStUser', array('stDiscountListener', 'generateStUser'));
        $dispatcher->connect('autoStUserActions.preGetAlldiscountOrCreate', array('stDiscountListener', 'preGetAlldiscountOrCreate'));

        $dispatcher->connect('autostProductActions.preExecuteDiscountAddGroup', array('stDiscountListener', 'preExecuteProductDiscountAddGroup'));
        $dispatcher->connect('autostUserActions.preExecuteDiscountAddGroup', array('stDiscountListener', 'preExecuteUserDiscountAddGroup'));
        $dispatcher->connect('stProductActions.postExecuteDuplicate', array('stDiscountListener', 'postExecuteDuplicate'));
        break;
    case 'frontend':
    	stPluginHelper::addEnableModule('stDiscountFrontend', 'frontend');
    	stPluginHelper::addRouting('stDiscountPlugin', '/discount/:action/*', 'stDiscountFrontend', 'discountInfo', 'frontend');
    	$dispatcher->connect('stUserDataComponents.postExecuteUserPanelMenu', array('stDiscountListener', 'postExecuteUserPanelMenu'));
        $dispatcher->connect('Product.postHydrate', array('stDiscountListener', 'getPrice', 'last'));
        break;
}

sfMixer::register('BasesfGuardUser:save:pre', array('stDiscountListener', 'preSaveUser'));
sfMixer::register('BaseOrder:delete:post', array('stDiscountListener', 'orderPostDelete'));
sfMixer::register('BaseOrder:save:post', array('stDiscountListener', 'orderPostSave'));