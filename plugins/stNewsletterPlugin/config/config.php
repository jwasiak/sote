<?php
/** 
 * SOTESHOP/stNewsletterPlugin 
 * 
 * Ten plik należy do aplikacji stNewsletterPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stNewsletterPlugin
 * @subpackage  configs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: config.php 12207 2011-04-13 12:12:14Z marcin $
 * @author      Karol Blejwas <karol.blejwas@sote.pl>
 */

/**
 * Włączanie modułów
 */
stPluginHelper::addEnableModule('stNewsletterFrontend', 'frontend');
stPluginHelper::addEnableModule('stNewsletterBackend', 'backend');

/**
 * Routingi
 */
stPluginHelper::addRouting('stNewsletterPlugin', '/newsletter/:action/*', 'stNewsletterFrontend', 'index', 'frontend');
stPluginHelper::addRouting('stNewsletterPlugin', '/newsletter/:action/*', 'stNewsletterBackend', null, 'backend');
stPluginHelper::addRouting('stNewsletterPluginDefault', '/newsletter', 'stNewsletterBackend', 'list', 'backend');
stPluginHelper::addRouting('stNewsletterConfirm', '/newsletter/confirm/:id/:hash_code', 'stNewsletterFrontend', 'confirm', 'frontend', array('confirm' => true));
stPluginHelper::addRouting('stNewsletterRemove', '/newsletter/remove/:id/:hash_code', 'stNewsletterFrontend', 'remove', 'frontend', array('remove' => true));
stPluginHelper::addRouting('stNewsletterConfirm', '/newsletter/confirm/:id/:hash_code', 'stNewsletterFrontend', 'confirm', 'backend', array('confirm' => true));
stPluginHelper::addRouting('stNewsletterUnsubscribe', '/newsletter/unsubscribe', 'stNewsletterFrontend', 'unsubscribe', 'frontend');
stPluginHelper::addRouting('stNewsletterUnsubscribe', '/newsletter/unsubscribe', 'stNewsletterFrontend', 'unsubscribe', 'backend');
stSocketView::addComponent('under_basket_socket','stNewsletterFrontend','requestNewsletter');
stSocketView::addComponent('stNewsletterBackend.configCustom.Content','stNewsletterBackend','configContent');

$dispatcher = stEventDispatcher::getInstance();
$dispatcher->connect('stUserDataComponents.postExecuteUserPanelMenu', array('stNewsletterListener', 'postExecuteUserPanelMenu'));
$dispatcher->connect('stOrderActions.postExecuteSave', array('stNewsletterListener', 'postExecuteOrderSave', true));
