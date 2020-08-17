<?php
/** 
 * SOTESHOP/stSearchPlugin 
 * 
 * Ten plik należy do aplikacji stSearchPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stSearchPlugin
 * @subpackage  configs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: config.php 3428 2010-02-10 11:48:32Z piotr $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/** 
 * Enabling frontend and backend modules
 */
stPluginHelper::addEnableModule('stSearchFrontend', 'frontend');
stPluginHelper::addEnableModule('stNewSearchFrontend', 'frontend');
stPluginHelper::addEnableModule('stSearchBackend', 'backend');

/** 
 * Adding nessesary Routing
 */
stPluginHelper::addRouting('stSearchPlugin', '/search/:action/*', 'stSearchFrontend', 'search', 'frontend');
stPluginHelper::addRouting('stSearchPlugin', '/search/:action/*', 'stSearchBackend', 'index', 'backend');

/**
 * Connecting dispachers
 */
$dispatcher = stEventDispatcher::getInstance();
$dispatcher->connect('autoStProductActions.postSave', array('stSimpleSearch', 'productSave'));
$dispatcher->connect('autoStProductActions.postSave', array('stAdvancedSearch', 'productSave'));
$dispatcher->connect('autoStProductActions.postSave', array('stNewSearch', 'productPostSave'));

$dispatcher->connect('stSearchFrontend.SimpleCriteria.post', array('stSearchListener', 'producerLimitAdv'));

$dispatcher->connect('stSearchFrontend.AdvanceCriteria.post', array('stSearchListener', 'priceLimitAdv'));
$dispatcher->connect('stSearchFrontend.AdvanceCriteria.post', array('stSearchListener', 'producerLimitAdv'));
$dispatcher->connect('stSearchFrontend.AdvanceCriteria.post', array('stSearchListener', 'categoryLimitAdv'));
$dispatcher->connect('stImportExport.Import_Product', array('stSearchListener', 'importProductIndex'));

$dispatcher->connect('stSimpleSearch.generateIndexes', array('stSearchListener', 'generateSimpleIndexes'));
$dispatcher->connect('stAdvancedSearch.generateIndexes', array('stSearchListener', 'generateAdvancedIndexes'));

