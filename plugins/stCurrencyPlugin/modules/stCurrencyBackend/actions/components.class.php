<?php
/** 
 * SOTESHOP/stCurrencyPlugin 
 * 
 * Ten plik należy do aplikacji stCurrencyPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stCurrencyPlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: components.class.php 13226 2011-05-30 14:29:24Z marcin $
 */

/** 
 * Komponenty dla modułu stCurrencyBackend
 *
 * @author Marcin Olejniczak <marcin.olejniczak@sote.pl>
 *
 * @package     stCurrencyPlugin
 * @subpackage  actions
 */
class stCurrencyBackendComponents extends autostCurrencyBackendComponents
{
    public function executeEditIsoCode()
    {
        $this->currencies = sfConfig::get('app_stCurrencyPlugin_currency_list');

        $currency_options = array();

        $this->system_default = $this->currency->getConfiguration()->get('default_currency');

        foreach ($this->currencies as $iso => $currency)
        {
            $currency_options[$iso] = $iso . ' - ' . __($currency['label']);
        }

        asort($currency_options);

        $this->currency_options = array('' => __('Nowa waluta')) + $currency_options;

        $this->selected = $this->currency->getEditIsoCode();
    }
}