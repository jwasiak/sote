<?php
/**
 * SOTESHOP/stDotpayPlugin
 *
 * Ten plik należy do aplikacji stDotpayPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stDotpayPlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: components.class.php 12055 2011-04-05 11:36:39Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stDotpayFrontendComponents
 *
 * @package     stDotpayPlugin
 * @subpackage  actions
 */
class stEcardFrontendComponents extends sfComponents
{
    /**
     * Pokazywanie formularza płatności
     */
    public function executeShowPayment()
    {
        $this->smarty = new stSmarty('stEcardFrontend');
        if (stPaymentType::hasOrderInSummary())
        {
            $this->stEcard = new stEcard();
            $this->stWebRequest = new stWebRequest();
            
            $this->order = stPaymentType::getOrderInSummary();
            $this->user = $this->order->getOrderUserDataBilling();
            $this->lang = stPaymentType::getLanguage(array('PL', 'EN', 'DE', 'FR', 'RU', 'CZ', 'IT', 'ES'));
            $this->hash = stPaymentType::getPaymentHash($this->order->getId());
            $this->country = stPaymentType::getCountry($this->user);
            $this->currency = stPaymentType::getCurrency($this->order->getId());
            
            /**
             * Pobieranie hash
             */
            // $postParameters = array( 'orderNumber' => $this->order->getId(),
            //                          'orderDescription' => '',
            // 						 'amount' => $this->stEcard->getOrderAmount(stPayment::getUnpayedAmountByOrder($this->order)),
            //                          'currency' => $this->currency->getCode(),
            //                          'merchantId' => $this->stEcard->getEcardId(),
            //                          'password' => $this->stEcard->getEcardPassword(),
            // );

            // $b = new sfWebBrowser(array(), 'sfCurlAdapter', array('ssl_verify' => false));
            // $b->post($this->stEcard->getHashUrl(), $postParameters);
            // $this->hash = trim($b->getResponseText());
            $this->params = $this->stEcard->getPaymentParams($this->order);
        }
    }
}