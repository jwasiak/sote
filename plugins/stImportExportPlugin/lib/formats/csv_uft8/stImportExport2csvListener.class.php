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
 * @version     $Id: stImportExport2csvListener.class.php 13384 2011-06-02 11:30:57Z piotr $
 * @author      Piotr Halas <piotr.halas@sote.pl>
 */
 
/** 
 * Klasa słuchacza stImportExport2csv
 *
 * @package     stImportExportPlugin
 * @subpackage  libs
 */
class stImportExport2csvListener {
    public static function generate(sfEvent $event)
    {
        // możemy wywoływać podaną metodę wielokrotnie co powoduje dołączenie kolejnych plików
           $event->getSubject()->attachAdminGeneratorFile('stImportExportPlugin', 'stImportExport2csv.yml');
    }
}
