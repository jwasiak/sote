<?php
/** 
 * SOTESHOP/stNokautPlugin 
 * 
 * Ten plik należy do aplikacji stNokautPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stNokautPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stNokautPluginListener.class.php 10 2009-08-24 09:32:18Z michal $
 * @author      Piotr Halas <piotr.halas@sote.pl>
 */
 
/** 
 * Klasa stHandeloPluginListener
 *
 * @package     stNokautPlugin
 * @subpackage  libs
 */
class stNokautPluginListener
{
    /** 
     * Dodaje konfiugracje do importu/eksportu produktu
     *
     * @param       sfEvent     $event
     */
    public static function generate(sfEvent $event)
    {
        // możemy wywoływać podaną metodę wielokrotnie co powoduje dołączenie kolejnych plików
        $event->getSubject()->attachAdminGeneratorFile('stNokautPlugin', 'stNokautInProduct.yml');
    }
}