<?php
/** 
 * SOTESHOP/stAllegroPlugin 
 * 
 * Ten plik należy do aplikacji stAllegroPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stAllegroPlugin
 * @subpackage  configs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: config.php 15779 2011-10-26 09:05:45Z piotr $
 */

if (SF_APP == 'backend') {
    stPluginHelper::addEnableModule('stAllegroBackend', 'backend');
    stPluginHelper::addEnableModule('stAllegroTemplateBackend', 'backend');
    stPluginHelper::addEnableModule('stAllegroDeliveryBackend', 'backend');
    
    stPluginHelper::addRouting('stAllegroPlugin', '/allegro/:action/*', 'stAllegroBackend', 'list', 'backend');
    stPluginHelper::addRouting('stAllegroDefault', '/allegro/:action/*', 'stAllegroBackend', 'list', 'backend');
    stPluginHelper::addRouting('stAllegroTemplate', '/allegro_template/:action/*', 'stAllegroTemplateBackend', 'list', 'backend');
    stPluginHelper::addRouting('stAllegroDelivery', '/allegro_delivery/:action/*', 'stAllegroDeliveryBackend', 'list', 'backend');
    stPluginHelper::addRouting('stAllegroGetAjaxCategoryTree', '/allegro/ajaxCategoryTree', 'stAllegroBackend', 'ajaxCategoryTree', 'backend');
    stPluginHelper::addRouting('stAllegroGetAjaxCategoryToken', '/allegro/ajaxCategoryToken', 'stAllegroBackend', 'ajaxCategoryToken', 'backend');

    $dispatcher->connect('stAdminGenerator.generateStProduct', array('stAllegroListener', 'generateStProduct'));
    $dispatcher->connect('stAdminGenerator.generateStOrder', array('stAllegroListener', 'generateStOrder'));
    $dispatcher->connect('autoStProductActions.postExecuteAllegroCustom', array('stAllegroListener', 'postExecuteAllegroCustom'));
    $dispatcher->connect('autostProductActions.preExecuteAllegroEdit', array('stAllegroListener', 'preExecuteAllegroEdit'));
    $dispatcher->connect('autoStProductActions.preDeleteAllegro', array('stAllegroListener', 'preDeleteAllegro'));
    $dispatcher->connect('autoStProductActions.postGetAllegroOrCreate', array('stAllegroListener', 'GetAllegroOrCreate'));
    $dispatcher->connect('autoStProductActions.postUpdateAllegroFromRequest', array('stAllegroListener', 'postUpdateAllegroFromRequest'));
    $dispatcher->connect('autoStProductActions.postSaveAllegro', array('stAllegroListener', 'postSaveAllegro'));
    $dispatcher->connect('autoStOrderActions.addAllegroFiltersCriteria', array('stAllegroListener', 'addAllegroFiltersCriteria'));
    $dispatcher->connect('stProductActions.validateAllegroEdit', array('stAllegroListener', 'validateAllegroEdit'));

    stSocketView::addComponent('stProduct.allegroCustom.Content', 'stAllegroBackend', 'productAllegroCustom');

    $dispatcher->connect('stTaskScheluder.initialize', array('stAllegroListener', 'taskScheluderInitialize'));
}

if (floatval(phpversion()) >= 7.1)
{
    stTaskConfiguration::addTask(
        'allegro_order_import', 
        'stAllegroOrderImportTask',
        'Import zamówień Allegro',
        array(
            'time_interval' => stTaskConfiguration::TIME_INTERVAL_10MIN,
            'priority' => stTaskConfiguration::PRIORITY_FIRST,
            'is_active' => false,
        )
    );

    stTaskConfiguration::addTask(
        'allegro_sync', 
        'stAllegroSyncTask',
        'Synchronizacja ofert Allegro',
        array(
            'time_interval' => stTaskConfiguration::TIME_INTERVAL_10MIN,
            'priority' => stTaskConfiguration::PRIORITY_FIRST+1,
            'is_active' => false,
        )
    );
}

stLicenseTypeHelper::addCommercialModule('stAllegroPlugin');
