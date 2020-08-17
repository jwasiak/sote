<?php
/** 
 * SOTESHOP/stCategory 
 * 
 * Ten plik należy do aplikacji stCategory opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stCategory
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stCategoryInProductImportExportListener.class.php 318 2009-09-07 12:39:29Z michal $
 */

/** 
 * Enter description here...
 *
 * @package     stCategory
 * @subpackage  libs
 */
class stCategoryInProductImportExportListener {
    public static function generate(sfEvent $event)
    {
        
        // możemy wywoływać podaną metodę wielokrotnie co powoduje dołączenie kolejnych plików
           $event->getSubject()->attachAdminGeneratorFile('stCategory', 'stCategoryInProductImportExportListener.yml');
    }
}
?>