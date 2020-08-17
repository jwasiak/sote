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
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: components.class.php 494 2009-09-11 11:35:32Z marcin $
 * @author      Marcin Olejniczak <marcin.olejniczak@sote.pl>
 */

/** 
 * Komponenty dla modułu stCountriesBackend
 *
 * @package     stCountriesPlugin
 * @subpackage  actions
 */
class stCountriesBackendComponents extends autoStCountriesBackendComponents
{
    public function executeEditCountries()
    {
        $this->count = CountriesPeer::doCountActive(new Criteria());


        $this->selected = array();

        if ($this->getRequest()->hasErrors())
        {
            $this->selected = $this->getRequestParameter('countries_area[edit_countries]');
        }
        elseif ($this->count)
        {
            $con = Propel::getConnection();

            $c = new Criteria();

            $c->addSelectColumn(CountriesAreaHasCountriesPeer::COUNTRIES_ID);

            $c->addJoin(CountriesAreaHasCountriesPeer::COUNTRIES_ID, CountriesPeer::ID);

            $c->add(CountriesPeer::IS_ACTIVE, true);

            $c->add(CountriesAreaHasCountriesPeer::COUNTRIES_AREA_ID, $this->countries_area->getId());

            $rs = BasePeer::doSelect($c, $con);

            while($rs->next())
            {
                $this->selected[] = $rs->getInt(1);
            }


        }
    }
}