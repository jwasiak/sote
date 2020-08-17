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
 * @version     $Id: actions.class.php 472 2009-09-10 14:42:24Z marcin $
 * @author      Marcin Olejniczak <marcin.olejniczak@sote.pl>
 */

/** 
 * Komponenty dla modułu stCountriesBackend
 *
 * @package     stCountriesPlugin
 * @subpackage  actions
 */
class stCountriesBackendActions extends autoStCountriesBackendActions
{
    public function executeActivateCountry()
    {
        $selected = $this->getRequestParameter('countries[selected]');

        if ($selected)
        {
            $this->doActiveUpdate($selected, true);
        }

        return $this->redirect($this->getRequest()->getReferer());
    }

    public function executeDeactivateCountry()
    {
        $selected = $this->getRequestParameter('countries[selected]');

        if ($selected)
        {
            $this->doActiveUpdate($selected, false);
        }

        return $this->redirect($this->getRequest()->getReferer());
    }

    protected function doActiveUpdate($selected, $active)
    {
        $c = new Criteria();

        $c->add(CountriesPeer::ID, $selected, Criteria::IN);

        $c->add(CountriesPeer::IS_ACTIVE, $active);

        return CountriesPeer::doUpdate($c);
    }

    protected function updateCountriesFromRequest()
    {
        parent::updateCountriesFromRequest();

        $countries = $this->getRequestParameter('countries');

        $this->countries->setIsDefault(isset($countries['is_default']) ? $countries['is_default'] : null);
    }

    protected function addSortCriteria($c)
    {
        if ($sort_column = $this->getUser()->getAttribute('sort', null, 'sf_admin/autoStCountriesBackend/sort'))
        {
            $sort_column=$this->translateSortColumn($sort_column);

            if ($sort_column == CountriesPeer::OPT_NAME)
            {
                $sort_column .= ' COLLATE utf8_polish_ci';
            }

            if ($this->getUser()->getAttribute('type', null, 'sf_admin/autoStCountriesBackend/sort') == 'asc')
            {
                $c->addAscendingOrderByColumn($sort_column);
            }
            else
            {
                $c->addDescendingOrderByColumn($sort_column);
            }
        }
    }
}