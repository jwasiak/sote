<?php
/** 
 * SOTESHOP/stImportExportPlugin 
 * 
 * Ten plik należy do aplikacji stImportExportPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stImportExportPlugin
 * @subpackage  configs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: config.php 13384 2011-06-02 11:30:57Z piotr $
 */

// pobieramy instancję obiektu sfEventDispatcher

if (SF_APP == 'backend') {
    stPluginHelper::addEnableModule('stImportExportBackend', 'backend');
    stPluginHelper::addRouting('stImportExportPlugin', '/stImportExportBackend/:action/*', 'stImportExportBackend', 'list', 'backend');

    $dispatcher = stEventDispatcher::getInstance();
    $dispatcher->connect('stAdminGenerator.generateStProduct', array('stImportExportListener', 'StImportExportGenerate'));
    $dispatcher->connect('stAdminGenerator.generate', array('stImportExport2xml2003Listener', 'generate')); 
    $dispatcher->connect('stAdminGenerator.generate', array('stImportExport2csvListener', 'generate'));
    $dispatcher->connect('stAdminGenerator.generate', array('stImportExport2csv1250Listener', 'generate'));
}
?>