<?php
/** 
 * SOTESHOP/stWebpagePlugin 
 * 
 * Ten plik należy do aplikacji stWebpagePlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stWebpagePlugin
 * @subpackage  configs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: config.php 617 2009-09-17 13:22:29Z piotr $
 * @author      Krzysztof Bebło <krzysztof.beblo@sote.pl>
 */

/** 
 * Włączanie modułów
 */
stPluginHelper::addEnableModule('stWebpageBackend', 'backend');
stPluginHelper::addEnableModule('stWebpageGroupBackend', 'backend');
stPluginHelper::addEnableModule('stWebpageGroupHasWebpageBackend', 'backend');
stPluginHelper::addEnableModule('stWebpageRelationBackend', 'backend');

stPluginHelper::addEnableModule('stWebpageFrontend', 'frontend');

/** 
 * Dodawanie routingów
 */
stPluginHelper::addRouting('stWebpagePlugin', '/webpage/:action/*', 'stWebpageBackend', 'list', 'backend');
stPluginHelper::addRouting('stWebpageGroupBackend', '/webpage_group/:action/*', 'stWebpageGroupBackend', 'list', 'backend');
stPluginHelper::addRouting('stWebpageGroupHasWebpageBackend', '/webpage_group_has_webpage/:action/*', 'stWebpageGroupHasWebpageBackend', 'list', 'backend');
stPluginHelper::addRouting('webpage', '/webpage/:action/*', 'stWebpageBackend', 'list', 'backend');
stPluginHelper::addRouting('webpage_group', '/webpage_group/:action/*', 'stWebpageGroupBackend', 'list', 'backend');
stPluginHelper::addRouting('webpage_group_has_webpage', '/webpage_group_has_webpage/:action/*', 'stWebpageGroupHasWebpageBackend', 'list', 'backend');

stPluginHelper::addRouting('webpage_export', '/webpage/export/:export/:page_name', 'stWebpageFrontend', 'export', 'frontend');
stPluginHelper::addRouting('webpage_page_name', '/webpage/:page_name', 'stWebpageFrontend', 'index', 'frontend');
stPluginHelper::addRouting('webpage', '/webpage/:action/*', 'stWebpageFrontend', 'list', 'frontend');
stPluginHelper::addRouting('stWebpageUrlLang', '/webpage/:lang/:url.html', 'stWebpageFrontend', 'index', 'frontend');
stPluginHelper::addRouting('stWebpageUrl', '/webpage/:url.html', 'stWebpageFrontend', 'index', 'frontend');

/** 
 * usuwanie cachy
 */
sfMixer::register('BaseWebpage:save:post', array('stWebpageCache', 'deleteCacheWebpage'));
sfMixer::register('BaseWebpage:delete:post', array('stWebpageCache', 'deleteCacheWebpage'));
sfMixer::register('BaseWebpageGroupHasWebpage:save:post', array('stWebpageCache', 'deleteCacheWebgroup'));
sfMixer::register('BaseWebpageGroupHasWebpage:delete:post', array('stWebpageCache', 'deleteCacheWebgroup'));
stEventDispatcher::getInstance()->connect('autostWebpageBackendActions.preExecuteWebpageGroupRemoveGroup', array('stWebpageCache', 'deleteCacheWebgroup'));

