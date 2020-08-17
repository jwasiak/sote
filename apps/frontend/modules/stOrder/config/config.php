<?php
/** 
 * SOTESHOP/stOrder 
 * 
 * Ten plik należy do aplikacji stOrder opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stOrder
 * @subpackage  configs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: config.php 13690 2011-06-20 06:58:55Z marcin $
 */

/** 
 * Akcje aplikacji stOrder
 *
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 * @package stOrder
 * @subpackage actions
 */
stPluginHelper::addRouting('stOrder', '/order/:action/*', 'stOrder', null, 'frontend');


stPluginHelper::addRouting('stOrderConfirmForUser', '/order/emailConfirm/:id/:hash_code/:register/:cancel', 'stOrder', 'show', 'frontend', array('confirm' => true));
stPluginHelper::addRouting('stOrderListShowForUser', '/order/show/:id/:hash_code', 'stOrder', 'show', 'frontend');
stPluginHelper::addRouting('stOrderShowForUser', '/order/show/:id/:hash_code', 'stOrder', 'show', 'frontend');
stPluginHelper::addRouting('stGoToOrder', '/order/edit/id/:order', 'stOrder', 'edit', 'frontend');
stPluginHelper::addRouting('stOrderSummary', '/order/summary/:id/:hash_code', 'stOrder', 'summary', 'frontend');
$dispatcher = stEventDispatcher::getInstance();
$dispatcher->connect('stUserDataComponents.postExecuteUserPanelMenu', array('stOrderListener', 'postExecuteUserPanelMenu'));
$dispatcher->connect('stDeliveryFrontendActions.postExecuteAjaxDeliveryCountryUpdate', array('stOrderListener', 'postExecuteAjaxDeliveryUpdate'));
$dispatcher->connect('stDeliveryFrontendActions.postExecuteAjaxDeliveryUpdate', array('stOrderListener', 'postExecuteAjaxDeliveryUpdate'));