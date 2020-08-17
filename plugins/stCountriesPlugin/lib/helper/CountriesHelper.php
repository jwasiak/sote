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
 * @subpackage  helpers
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: CountriesHelper.php 4 2009-08-24 08:52:56Z marcin $
 * @author      Marcin Olejniczak <marcin.olejniczak@sote.pl>
 */

/** 
 * Pobieranie nazwy kraju
 *
 * @param   integer     $country            numer kraju
 * @return  string      nazwa kraju
 */
function getName($country)
{
    $country = CountriesPeer::retrieveByPK($country);
    return $country->getName();
}

/** 
 * Pobieranie strefy kraju
 *
 * @param   integer     $country            numer kraju
 * @return  integer     strefa kraju
 */
function getArea($country)
{
    $c = new Criteria();
    $c->add(CountriesAreaHasCountriesPeer::COUNTRIES_ID , $country);
    $country_area = CountriesAreaHasCountriesPeer::doSelectOne($c);
    
    return $country_area->getCountriesAreaId();
}

function st_countries_select_tag($name, $value, array $params = array())
{
    $countries = CountriesPeer::doSelectActiveCached();

    $eu = array();
    $outsideEu = array();
    $iso = false;

    if (isset($params['iso']))
    {     
        $iso = $params['iso'];
        unset($params['iso']);
    }

    foreach ($countries as $country)
    {    
        if ($country->isEU())
        {
            $eu[$iso ? $country->getIsoA2() : $country->getOptName()] = $country->getName();     
        }
        else
        {
            $outsideEu[$iso ? $country->getIsoA2() : $country->getOptName()] = $country->getName(); 
        }
    }   

    $options = array("Unia Europejska" => $eu, "Państwa spoza Unii Europejskiej" => $outsideEu);

    return select_tag($name, options_for_select($options, $value), $params);
}