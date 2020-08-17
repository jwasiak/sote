<?php
/**
 * SOTESHOP/stPositioningPlugin
 *
 * Ten plik należy do aplikacji stPositioningPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE.
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stPositioningPlugin
 * @subpackage  configs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: config.php 13379 2011-06-02 09:58:45Z piotr $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Włączanie modułów
 */
stPluginHelper::addEnableModule('stPositioningBackend', 'backend');

/**
 * Dodanie do panelu sklepu
 */
stConfiguration::addModule('stPositioningPlugin', 'group_2');

/**
 * Dodanie routingu
 */
stPluginHelper::addRouting('stPositioningPlugin', '/positioning/:action/*', 'stPositioningBackend', 'edit', 'backend');
stPluginHelper::addRouting('stPositioningPluginDefault', '/positioning', 'stPositioningBackend', 'edit', 'backend');

/**
 * Dodawanie socketów
 */
stSocketView::addComponent('stPositioningBackend.robotFileCustom.Content', 'stPositioningBackend', 'robotFile');
stSocketView::addComponent('stPositioningBackend.sitemapCustom.Content', 'stPositioningBackend', 'sitemap');
stSocketView::addComponent('stPositioningBackend.verifySearchCustom.Content', 'stPositioningBackend', 'verifySearch');
stSocketView::addComponent('stPositioningBackend.404linksCustom.Content', 'stPositioningBackend', '404links');

/**
 * Ładownie pozycjonowania w modułach sklepu
 */
$dispatcher = stEventDispatcher::getInstance();

/**
 * Produkt
 */
$dispatcher->connect('stAdminGenerator.generateStProduct', array('stPositioningPluginListener', 'generateStProduct'));
$dispatcher->connect('autoStProductActions.preSavePositioning', array('stPositioningPluginListener', 'preSaveProduct'));
$dispatcher->connect('stProductActions.postExecuteShow', array('stPositioningPluginListener', 'preProductShow'));
$dispatcher->connect('autoStProductActions.preGetPositioningOrCreate', array('stPositioningPluginListener', 'preGetOrCreateProduct'));

/**
 * Kategorie
 */
$dispatcher->connect('stAdminGenerator.generateStCategory', array('stPositioningPluginListener', 'generateStCategory'));
$dispatcher->connect('autoStCategoryActions.preSavePositioning', array('stPositioningPluginListener', 'preSaveCategory'));
$dispatcher->connect('autoStCategoryActions.preGetPositioningOrCreate', array('stPositioningPluginListener', 'preGetOrCreateCategory'));
$dispatcher->connect('stProductActions.postExecuteList', array('stPositioningPluginListener', 'preProductList'));

/**
 * Grupy produktów
 */
$dispatcher->connect('stAdminGenerator.generateStProductGroup', array('stPositioningPluginListener', 'generateStProductGroup'));
$dispatcher->connect('autoStProductGroupActions.preSavePositioning', array('stPositioningPluginListener', 'preSaveProductGroup'));
$dispatcher->connect('autoStProductGroupActions.preGetPositioningOrCreate', array('stPositioningPluginListener', 'preGetOrCreateProductGroup'));
$dispatcher->connect('stProductActions.postExecuteGroupList', array('stPositioningPluginListener', 'preProductGroupList'));

/**
 * Strony www
 */
$dispatcher->connect('stAdminGenerator.generateStWebpageBackend', array('stPositioningPluginListener', 'generateStWebpage'));
$dispatcher->connect('autoStWebpageBackendActions.preSavePositioning', array('stPositioningPluginListener', 'preSaveWebpage'));
$dispatcher->connect('stWebpageFrontendActions.postExecuteIndex', array('stPositioningPluginListener', 'postWebpageIndex'));
$dispatcher->connect('autoStWebpageBackendActions.preGetPositioningOrCreate', array('stPositioningPluginListener', 'preGetOrCreateWebpage'));

/**
 * Producent
 */
$dispatcher->connect('stAdminGenerator.generateStProducer', array('stPositioningPluginListener', 'generateStProducer', 'last'));
$dispatcher->connect('autoStProducerActions.preSavePositioning', array('stPositioningPluginListener', 'preSaveProducer'));
$dispatcher->connect('stProductActions.postExecuteProducerList', array('stPositioningPluginListener', 'postProducerIndex'));
$dispatcher->connect('autoStProducerActions.preGetPositioningOrCreate', array('stPositioningPluginListener', 'preGetOrCreateProducer'));

/**
 * Blog
 */
$dispatcher->connect('stAdminGenerator.generateStBlogBackend', array('stPositioningPluginListener', 'generateStBlog'));
$dispatcher->connect('autoStBlogBackendActions.preSavePositioning', array('stPositioningPluginListener', 'preSaveBlog'));
$dispatcher->connect('stBlogFrontendActions.postExecuteShow', array('stPositioningPluginListener', 'postBlogIndex'));
$dispatcher->connect('autoStBlogBackendActions.preGetPositioningOrCreate', array('stPositioningPluginListener', 'preGetOrCreateBlog'));


$dispatcher->connect('autostBackendMainActions.preExecuteList', array('stPositioningPluginListener', 'showRebuildSeoLinks'));
$dispatcher->connect('autostRegisterActions.postExecuteIndex', array('stPositioningPluginListener', 'hideRebuildSeoLinks'));

/**
* Off indexing
*/
$dispatcher->connect('stBasketActions.postExecuteIndex', array('stPositioningPluginListener', 'noIndex'));

/**
* 404 
*/

$dispatcher->connect('stProductActions.preExecuteProductNotFound', array('stPositioningPluginListener', 'redirect'));
$dispatcher->connect('stProductActions.preExecuteCategoryNotFound', array('stPositioningPluginListener', 'redirect'));
$dispatcher->connect('stProductActions.preExecuteProductGroupNotFound', array('stPositioningPluginListener', 'redirect'));
$dispatcher->connect('stProductActions.preExecuteProducerNotFound', array('stPositioningPluginListener', 'redirect'));
$dispatcher->connect('stErrorFrontendActions.preExecuteError404', array('stPositioningPluginListener', 'redirect'));


