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
 * @version     $Id: actions.class.php 97 2009-08-26 08:04:10Z marcin $
 * @author      Marcin Olejniczak <marcin.olejniczak@sote.pl>
 */

/** 
 * stCurrencyFrontend actions.
 *
 * @package     stCurrencyPlugin
 * @subpackage  actions
 */
class stCurrencyFrontendActions extends stActions
{
    public function initialize($context)
    {
        $ret = parent::initialize($context);

        stLanguage::disablePath();

        return $ret;
    }

    public function executeChange()
    {
        $this->executeAddCurrency();
    }
    /** 
     * Funkcja zapisujaca wybrana walute
     */
    public function executeAddCurrency()
    {
        $referer = $this->getRequest()->getReferer();
        $currency = stCurrency::getInstance($this->getContext());
        $currency->set($this->getRequestParameter('currency'));
        
        // disable Fast Cache for this session if currency is different that default
        stFastCacheController::disable();
        
        $filters = $this->getUser()->getAttribute('filters', array(), 'soteshop/stProduct');
        
        if (isset($filters['price']))
        {
            unset($filters['price']);
        }

        $this->getUser()->setAttribute('filters', $filters, 'soteshop/stProduct');

        $this->postExecute();

        return $this->redirect($referer);
    }   
}
