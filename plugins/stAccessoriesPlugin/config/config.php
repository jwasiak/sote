<?php
/** 
 * SOTESHOP/stAccessoriesPlugin 
 * 
 * Ten plik należy do aplikacji stAccessoriesPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stAccessoriesPlugin
 * @subpackage  configs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: config.php 7772 2010-08-23 14:33:34Z krzysiek $
 * @author      Krzysztof Bebło <krzysztof.beblo@sote.pl>  
 */

/** 
 * Konfiguracja modułu stAccessoriesPlugin
 *
 * @package stAccessoriesPlugin
 * @author Krzysztof Bebło <krzysztof.beblo@sote.pl>  
 */

/** 
 * włączanie modułu
 */

stPluginHelper::addEnableModule('stAccessoriesFrontend', 'frontend');
stPluginHelper::addEnableModule('stAccessoriesBackend', 'backend');

/** 
 * pobiera instancję obiektu sfEventDispatcher
 */
$dispatcher = stEventDispatcher::getInstance();

/** 
 * dodaje sluchacza dla zdarzenia generator.generate
 */
$dispatcher->connect('stAdminGenerator.generateStProduct', array('stAccessoriesPluginListener', 'generate')); 
$dispatcher->connect('autostProductActions.postExecuteManageAccessoriesList', array('stAccessoriesPluginListener', 'postExecuteManageAccessoriesList'));
$dispatcher->connect('autostProductActions.postExecuteProductInAccessoriesList', array('stAccessoriesPluginListener', 'postExecuteProductInAccessoriesList'));
$dispatcher->connect('stProductActions.postExecuteShow', array('stAccessoriesPluginListener', 'postExecuteShowAccessoriesList'));
$dispatcher->connect('stProductActions.postExecuteDuplicate', array('stAccessoriesPluginListener', 'postExecuteDuplicate'));
