<?php
/** 
 * SOTESHOP/stCeneoPlugin 
 * 
 * Ten plik należy do aplikacji stCeneoPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stCeneoPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stCeneoPluginListener.class.php 9523 2010-11-26 11:25:33Z michal $
 * @author      Piotr Halas <piotr.halas@sote.pl>
 */
 
/** 
 * Klasa stCeneoPluginListener
 *
 * @package     stCeneoPlugin
 * @subpackage  libs
 */
class stCeneoPluginListener
{
    /** 
     * Dodaje konfiugracje do importu/eksportu produktu
     *
     * @param       sfEvent     $event
     */
    public static function generate(sfEvent $event)
    {
        // możemy wywoływać podaną metodę wielokrotnie co powoduje dołączenie kolejnych plików
        $event->getSubject()->attachAdminGeneratorFile('stCeneoPlugin', 'stCeneoInProduct.yml');
    }

    public static function preExecuteBasketIndex(sfEvent $event, $ok = false) {
        if (stConfig::getInstance('stCeneoBackend')->get('trusted_opinion_on'))
            stCompatibilityOpinion::setOpinionService('Ceneo');
    return $ok;
    }
}