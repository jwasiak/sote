<?php
/** 
 * SOTESHOP/stProducer 
 * 
 * Ten plik należy do aplikacji stProducer opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stProducer
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stProducerInProductImportExportListener.class.php 617 2009-04-09 13:02:31Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/** 
 * Klasa stProducerInProductImportExportListener
 *
 * @package     stProducer
 * @subpackage  libs
 */
class stProducerInProductImportExportListener {
    
    /** 
     * Funkcja generate
     *
     * @param       sfEvent     $event
     */
    public static function generate(sfEvent $event)
    {
        $event->getSubject()->attachAdminGeneratorFile('stProducer', 'stProducerInProductImportExportListener.yml');
    }
}