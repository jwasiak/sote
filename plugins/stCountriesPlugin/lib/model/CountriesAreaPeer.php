<?php
/** 
 * SOTESHOP/stCountriesPlugin 
 * 
 * Ten plik należy do aplikacji stCountriesPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stCountriesPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: CountriesAreaPeer.php 552 2009-09-16 11:22:06Z marcin $
 * @author      Marcin Olejniczak <marcin.olejniczak@sote.pl>
 */

/** 
 * Klasa CountriesAreaPeer
 *
 * @package     stCountriesPlugin
 * @subpackage  libs
 */
class CountriesAreaPeer extends BaseCountriesAreaPeer
{
    public static function doSelectActive(Criteria $c, $con = null)
    {
        $c = clone $c;

        $c->addAscendingOrderByColumn(self::NAME . ' COLLATE utf8_polish_ci');

        $c->add(self::IS_ACTIVE, true);

        return self::doSelect($c, $con);
    }
}