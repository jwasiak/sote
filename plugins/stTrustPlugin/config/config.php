<?php
/** 
 * SOTESHOP/stTrustPlugin
 * 
 * 
 * @package     stTrustPlugin
 * @author      Bartosz Alejski <bartosz.alejski@sote.pl>
 */

/** 
 * Enabling frontend and backend modules
 */
stPluginHelper::addEnableModule('stTrustBackend', 'backend');
stPluginHelper::addEnableModule('stTrustFrontend', 'frontend');

/**
* Dodanie do panelu sklepu
*/


/** 
 * Adding nessesary Routing
 */
stPluginHelper::addRouting('stTrustPlugin', '/trust/:action/*', 'stTrustBackend', 'config', 'backend'); 
//stPluginHelper::addRouting('stTrustPlugin', '/trust/*', 'stTrustBackend', 'config', 'backend');
//stPluginHelper::addRouting('stTrustPluginDefault', '/trust', 'stTrustBackend', 'config', 'backend');

stPluginHelper::addRouting('stTrustPlugin', '/trust/*', 'stTrustFrontend', 'show', 'frontend');

/**
 * Dodanie do konfiguracji
 */
stConfiguration::addModule('stTrustPlugin', 'group_2');


/** 
 * Pobiera instancję obiektu sfEventDispatcher
 */
$dispatcher = stEventDispatcher::getInstance();

/** 
 * Dodaje sluchacza dla zdarzenia generator.generate
 */
$dispatcher->connect('stAdminGenerator.generateStProduct', array('stTrustListener', 'generate')); 
$dispatcher->connect('autoStProductActions.preSaveTrust', array('stTrustListener', 'preSaveProduct'));
$dispatcher->connect('autoStProductActions.preGetTrustOrCreate', array('stTrustListener', 'preGetOrCreateProduct'));
