<?php
/**
 * SOTESHOP/stPartnerPlugin
 *
 * Ten plik należy do aplikacji stPartnerPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stPartnerPlugin
 * @subpackage  configs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: config.php 1858 2009-06-25 13:59:29Z bartek $
 * @author      Bartosz Alejski <bartosz.alejski@sote.pl>
 */

/**
 * Włączanie modułów
 */
stPluginHelper::addEnableModule('stPartnerFrontend', 'frontend');
stPluginHelper::addEnableModule('stPartnerBackend', 'backend');

/**
 * Routingi
 */
stPluginHelper::addRouting('stPartnerPlugin', '/partner/:action/*', 'stPartnerFrontend', 'index', 'frontend');
stPluginHelper::addRouting('stPartnerPlugin', '/partner/:action/*', 'stPartnerBackend', 'index', 'backend');
stPluginHelper::addRouting('stPartnerPluginDefault', '/partner', 'stPartnerBackend', 'list', 'backend');




/**
 * Dodaje sluchacza dla akcji stUserData
 */

$dispatcher = stEventDispatcher::getInstance();
$dispatcher->connect('stUserDataComponents.postExecuteUserPanelMenu', array('stPartnerListener', 'postExecuteUserPanelMenu'));

$dispatcher->connect('stAdminGenerator.generateStUser', array('stPartnerListener', 'generateStUser'));

$dispatcher->connect('autostUserActions.postExecutePartnerList', array('stPartnerListener', 'postExecutePartnerList'));

$dispatcher->connect('stOrderActions.filterOrderSave', array('stPartnerListener', 'filterOrderSave'));

stSocketView::addComponent('stPartnerBackend.configCustom.Content','stPartnerBackend','configContent');