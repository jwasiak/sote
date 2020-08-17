<?php
/**
 * SOTESHOP/stLanguagePlugin
 *
 * Ten plik należy do aplikacji stLanguagePlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stLanguagePlugin
 * @subpackage  configs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stLanguageListener.class.php 9 2009-08-24 09:31:16Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stLanguageListener
 *
 * @package     stLanguagePlugin
 * @subpackage  libs
 */
class stLanguageListener
{
    /**
     * Usunięcie zmiany języka w potwierdzeniu zamówienia
     *
     * @param $event sfEvent
     */
    public static function addOrderConfirm(sfEvent $event)
    {
        $context = $event->getSubject();
        $context->setFlash('stLanguage-hideLanguages', true, false);
    }
    
    /**
     * Usunięcie zmiany języka w podsumowania zamówienia
     *
     * @param $event sfEvent
     */
    public static function addOrderSummary(sfEvent $event)
    {
        $context = $event->getSubject();
        $context->setFlash('stLanguage-hideLanguages', true, false);
    }
}