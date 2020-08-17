<?php
/** 
 * SOTESHOP/stProductOptionsPlugin 
 * 
 * Ten plik należy do aplikacji stProductOptionsPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stProductOptionsPlugin
 * @subpackage  configs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: config.php 16306 2011-11-30 12:07:17Z piotr $
 * @author      Daniel Mendalka <daniel.mendalka@sote.pl>
 */

/** 
 * Włączanie modułów
 */
stPluginHelper::addEnableModule('stProductOptionsTemplateBackend', 'backend');
stPluginHelper::addEnableModule('stProductOptionsTreeBackend', 'backend');
stPluginHelper::addEnableModule('stProductOptionsBackend', 'backend');
stPluginHelper::addEnableModule('stProductOptionsStockBackend', 'backend');

stPluginHelper::addEnableModule('stProductOptionsStockFrontend', 'frontend');
stPluginHelper::addEnableModule('stProductOptionsFrontend', 'frontend');

/** 
 * Dodawanie routingów
 */
stPluginHelper::addRouting('stProductOptionsPlugin', '/product_options_template/:action/*', 'stProductOptionsTemplateBackend', null, 'backend');
stPluginHelper::addRouting('stProductOptionsPluginDefault', '/product_options_template', 'stProductOptionsTemplateBackend', 'list', 'backend');

stPluginHelper::addRouting('stProductOptionsFrontend', '/product_options/:action/*', 'stProductOptionsFrontend', null, 'frontend');
stPluginHelper::addRouting('stProductOptionsStockFrontend', '/product_options_stock/:action/*', 'stProductOptionsStockFrontend', null, 'frontend');

/** 
 * dodaje sluchacza dla zdarzenia generator.generate
 */
switch(SF_APP)
{
    case 'backend':
        $dispatcher->connect('stAdminGenerator.generateStProduct', array('stProductOptionsPluginListener', 'generate')); 
        $dispatcher->connect('autostProductActions.preExecuteOptionsTemplatesEdit', array('stProductOptionsPluginListener', 'preExecuteOptionsTemplatesEdit'));
        $dispatcher->connect('autostProductActions.preExecuteOptionsEdit', array('stProductOptionsPluginListener', 'preExecuteOptionsEdit'));
        $dispatcher->connect('autostProductActions.postExecuteOptionsEdit', array('stProductOptionsPluginListener', 'postExecuteOptionsEdit'));
        $dispatcher->connect('autostProductActions.preExecuteOptionsTemplatesList', array('stProductOptionsPluginListener', 'preExecuteOptionsTemplatesList'));
        $dispatcher->connect('autoStProductActions.updateOptionsStockListItem', array('stProductOptionsStockListener', 'updateOptionsStockListItem'));
        $dispatcher->connect('autostProductActions.postExecuteOptionsStockList', array('stProductOptionsStockListener', 'postExecuteOptionsStockList'));
        $dispatcher->connect('autostProductActions.preExecuteOptionsStockDelete', array('stProductOptionsStockListener', 'preExecuteOptionsStockDelete'));
        $dispatcher->connect('autoStProductActions.postSave', array('stProductOptionsStockListener', 'postProductSave'));
        $dispatcher->connect('stProductActions.postExecuteDuplicate', array('stProductOptionsPluginListener', 'productPostExecuteDuplicate'));
        $dispatcher->connect('stProductActions.validateConfig', array('stProductOptionsStockListener', 'validateProductConfig'));
        $dispatcher->connect('autoStProductActions.postOptionsStockUpdateList', array('stProductOptionsStockListener', 'clearFastCache'));
        $dispatcher->connect('autoStProductActions.addOptionsFiltersFiltersCriteria', array('stProductOptionsPluginListener', 'addOptionsFiltersFiltersCriteria'));

        break;
        
    case 'frontend':
        $dispatcher->connect('stProductActions.preProductPagerInit', array('stNewProductOptions', 'listFilter'));

    	$dispatcher->connect('stProductActions.postExecuteShow', array('stProductOptionsPluginListener', 'productPostExecuteShow'));
        $dispatcher->connect('stProductActions.postExecuteFilter', array('stProductOptionsPluginListener', 'postExecuteFilter'));
        $dispatcher->connect('stProductActions.postExecuteClearFilter', array('stProductOptionsPluginListener', 'postExecuteClearFilter'));
        break;
}
$dispatcher->connect('Product.getHasOptions', array('stProductOptionsPluginListener', 'productGetHasOptions'));
$dispatcher->connect('Product.preSave', array('stProductOptionsPluginListener', 'productPreSave'));