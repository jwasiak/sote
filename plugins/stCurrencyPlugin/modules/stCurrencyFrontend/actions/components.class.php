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
 * @version     $Id: components.class.php 97 2009-08-26 08:04:10Z marcin $
 * @author      Marcin Olejniczak <marcin.olejniczak@sote.pl>
 */


/** 
 * Akcje komponentu currency
 *
 * @package     stCurrencyPlugin
 * @subpackage  actions
 */
class stCurrencyFrontendComponents extends sfComponents
{
    /** 
     * Funkcja wyświetlenia componentu do zmiany waluty
     */
    public function executePickCurrency()
    {
        if ($this->getUser()->getParameter('hide', false, 'soteshop/stCurrencyPlugin'))
        {
            return sfView::NONE;
        }

        $config = stConfig::getInstance('stProduct');

        if ($config->get('hide_price') || $this->hasFlash('stCurrency-hide_list'))
        {
            return sfView::NONE;
        }

        $currencies = CurrencyPeer::doSelectActive();

        if (!$currencies || count($currencies) == 1)
        {
            return sfView::NONE;
        }

        $smarty = new stSmarty('stCurrencyFrontend');
        $selected = stCurrency::getInstance($this->getContext())->get();

        if ($this->getController()->getTheme()->getVersion() < 7)
        {
            $this->currencies = array();

            foreach ($currencies as $currency)
            {
                $this->currencies[$currency->getId()] = $currency->getShortcut();
            }

            $this->selected = $selected->getId();
            $this->smarty = $smarty;
        }
        else
        {
            sfLoader::loadHelpers(array('Helper', 'stUrl'));
            $smarty->assign('currencies', $currencies);
            $smarty->assign('selected', $selected);
            $smarty->register_function('url_for_currency', array('stCurrencyFrontendComponents', 'urlForCurrency'));
            return $smarty;
        }
    }    

    public static function urlForCurrency($params)
    {
        return st_url_for('@stCurrencyFrontend?action=change&currency='.$params['currency']->getId());
    }
}