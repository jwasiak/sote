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
 * @version     $Id: stImportExport2xml2003Listener.class.php 13384 2011-06-02 11:30:57Z piotr $
 * @author      Piotr Halas <piotr.halas@sote.pl>
 */
 
/** 
 * Klasa sluchacza stImportExport2xml2003
 *
 * @package     stImportExportPlugin
 * @subpackage  libs
 */
class stImportExport2xml2003Listener {
    
    /** 
     * Funkcja dodaje do kazdego generowanego modulu informacje o dostepnych imporerach i eksporterach
     *
     * @param       sfEvent     $event
     */
    public static function generate(sfEvent $event)
    {
        if (is_file(sfConfig::get('sf_root_dir').'/packages/appImportExportOffice2003Plugin/package.yml'))
        {
            $event->getSubject()->attachAdminGeneratorFile('stImportExportPlugin', 'stImportExport2xml2003.yml');
        }
    }
}
