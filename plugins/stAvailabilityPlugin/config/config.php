<?php
/** 
 * SOTESHOP/stAvailabilityPlugin 
 * 
 * Ten plik należy do aplikacji stAvailabilityPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stAvailabilityPlugin
 * @subpackage  configs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: config.php 617 2009-04-09 13:02:31Z michal $
 */

/** 
 * Konfiguracja modułu stAvailabilityPlugin
 *
 * @package stAvailabilityPlugin
 * @author Krzysztof Bebło <krzysztof.beblo@sote.pl> 
 */

/** 
 * Włączanie modułów
 */
stPluginHelper::addEnableModule('stAvailabilityBackend', 'backend');
stPluginHelper::addEnableModule('stAvailabilityProductBackend', 'backend');
stPluginHelper::addEnableModule('stAvailabilityFrontend', 'frontend');

/** 
 * Pobiera instancję obiektu sfEventDispatcher
 */
$dispatcher = stEventDispatcher::getInstance();

/** 
 * Dodaje sluchacza
 */
$dispatcher->connect('stAdminGenerator.generateStProduct', array('stAvailabilityPluginListener', 'generate')); 
$dispatcher->connect('autoStProductActions.postSave', array('stAvailabilityPluginListener', 'postSave')); 
$dispatcher->connect('autoStProductActions.Edit', array('stAvailabilityPluginListener', 'Edit'));
$dispatcher->connect('stProductActions.postAddProductCriteria', array('stAvailabilityPluginListener', 'addProductCriteria'));
$dispatcher->connect('stNavigationFrontendActions.postShowHistoryCriteria', array('stAvailabilityPluginListener', 'addProductCriteria'));
$dispatcher->connect('stNavigationFrontendComponents.postProductsBoxCriteria', array('stAvailabilityPluginListener', 'addProductCriteria'));
$dispatcher->connect('stCategoryModel.postGetProducers', array('stAvailabilityPluginListener', 'addProductCriteria'));


/** 
 * Dodawanie routingów
 */
stPluginHelper::addRouting('stAvailabilityPlugin', '/availability/:action/*', 'stAvailabilityBackend', 'list', 'backend');
/** 
 * dodaje obsługę pola dostępności w produkcie
 */
sfPropelBehavior::registerHooks('stPropelProducts', array('stPropelProducts'));

sfPropelBehavior::add('Product', array('stPropelProducts')); 