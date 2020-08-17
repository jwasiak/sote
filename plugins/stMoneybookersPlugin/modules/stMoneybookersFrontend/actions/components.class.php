<?php
/**
 * SOTESHOP/stMoneybookersPlugin
 *
 * Ten plik należy do aplikacji stMoneybookersPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stMoneybookersPlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: components.class.php 10 2009-08-24 09:32:18Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/** 
 * Klasa stMoneybookersFrontendComponents
 *
 * @package stMoneybookersPlugin
 * @subpackage actions
 */
class stMoneybookersFrontendComponents extends sfComponents
{
    /**
     * Pokazywanie formularza płatności
     */
    public function executeShowPayment()
    {
        $this->smarty = new stSmarty('stMoneybookersFrontend');
        if (stPaymentType::hasOrderInSummary())
        {
            $this->stMoneybookers = new stMoneybookers();
            $this->stWebRequest = new stWebRequest();
            
            $this->order = stPaymentType::getOrderInSummary();
            $this->user = $this->order->getOrderUserDataBilling();
            $this->lang = stPaymentType::getLanguage();
            $this->hash = stPaymentType::getPaymentHash($this->order->getId());
            $this->country = stPaymentType::getCountry($this->user);
        }
    }
}