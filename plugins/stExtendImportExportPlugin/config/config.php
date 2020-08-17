<?php
/** 
 * SOTESHOP/stExtendImportExportPlugin
 * 
 * 
 * @package     stExtendImportExportPlugin
 * @author      Pawel Byszewski <pawel.byszewski@sote.pl>
 */

stPluginHelper::addEnableModule('stExtendImportExportBackend', 'backend');

if (SF_APP == 'backend') {
	stPluginHelper::addRouting('stExtendImportExportPlugin', '/extend-importexport/:action/*', 'stExtendImportExportBackend', 'list', 'backend');
	stPluginHelper::addRouting('stExtendImportExportBackend', '/extend-importexport/:action/*', 'stExtendImportExportBackend', 'list', 'backend');
    $dispatcher->connect('stAdminGenerator.generateStProduct', array('stExtendImportExportPluginListener', 'generateProduct'));
}