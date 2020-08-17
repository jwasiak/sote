<?php
/** 
 * SOTESHOP/stWebpagePlugin
 *
 * Ten plik należy do aplikacji stWebpagePlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE.
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stWebpagePlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: WebpageGroupPeer.php 6721 2010-07-21 11:43:09Z krzysiek $
 * @author      Krzysztof Bebło <krzysztof.beblo@sote.pl>
 */

/** 
 * Klasa WebpageGroupPeer
 *
 * @package     stWebpagePlugin
 * @subpackage  libs
 */
class WebpageGroupPeer extends BaseWebpageGroupPeer
{

        /**
     * Przeciążenie metody pobierającej grupy strony www w odpowiedniej wersji jezykowej
     *
     * @param Criteria $c Kryteria
     * @param mixed $culture Wersja językowa
     * @param CreoleConnection $con Połączenie z bazą danych
     * @return array Produkty
     */
    public static function doSelectWithI18n(Criteria $c, $culture = null, $con = null)
    {
        if ($culture === null)
        {
            $culture = stLanguage::getHydrateCulture();
        }

        return parent::doSelectWithI18n($c, $culture, $con);
    }

    public static function doCountWithI18n(Criteria $c, $con = null)
    {
        $c = clone $c;
        
        $c->addJoin(WebpageGroupI18nPeer::ID, WebpageGroupPeer::ID);

        $c->add(WebpageGroupI18nPeer::CULTURE, sfContext::getInstance()->getUser()->getCulture());

        return self::doCount($c, $con);
    }
}
