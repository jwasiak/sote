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
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stImportExportListener.class.php 13384 2011-06-02 11:30:57Z piotr $
 */

class stImportExportListener {
    public static function StImportExportGenerate(sfEvent $event) {
        $event->getSubject()->attachAdminGeneratorFile('stImportExportPlugin', 'importExport.yml');
        $event->getSubject()->attachAdminGeneratorFile('stImportExportPlugin', 'productCustomData.yml');
    }
}