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
 * @version     $Id: CountriesArea.php 227 2009-09-02 10:44:09Z marcin $
 * @author      Marcin Olejniczak <marcin.olejniczak@sote.pl>
 */

/** 
 * Klasa CountriesArea
 *
 * @package     stCountriesPlugin
 * @subpackage  libs
 */
class CountriesArea extends BaseCountriesArea
{
    /** 
     * Pobierania nazwy kraju
     *
     * @return   string
     */
    public function __toString()
    {
        return $this->getName();
    }

    /**
     *
     * Metoda dodana na potrzeby admin generator - przypisuje przekazana liste krajow
     *
     * @param array $countries Lista krajow (format: array('id1', 'id2', ...))
     */
    public function setEditCountries($ids)
    {
        $c = new Criteria();

        $c->add(CountriesAreaHasCountriesPeer::COUNTRIES_AREA_ID, $this->getId());

        CountriesAreaHasCountriesPeer::doDelete($c);

        foreach($ids as $id)
        {
            $cahc = new CountriesAreaHasCountries();

            $cahc->setCountriesId($id);

            $this->addCountriesAreaHasCountries($cahc);
        }
    }

    public function getAvailableCountries()
    {
        $c = new Criteria();

        $c->add(CountriesPeer::IS_ACTIVE, true);

        $c->addJoin(CountriesPeer::ID, CountriesAreaHasCountriesPeer::COUNTRIES_ID, Criteria::LEFT_JOIN);

        $c1 = $c->getNewCriterion(CountriesAreaHasCountriesPeer::ID, null, Criteria::ISNULL);

        $c1->addOr($c->getNewCriterion(CountriesAreaHasCountriesPeer::COUNTRIES_AREA_ID, $this->getId()));

        $c->add($c1);

        return CountriesPeer::doSelect($c);
    }
}