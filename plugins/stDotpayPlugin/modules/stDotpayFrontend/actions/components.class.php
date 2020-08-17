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
 * @version     $Id: components.class.php 15922 2011-11-03 08:43:32Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stDotpayFrontendComponents
 *
 * @package     stDotpayPlugin
 * @subpackage  actions
 */
class stDotpayFrontendComponents extends sfComponents
{
    /**
     * Pokazywanie formularza płatności
     */
    public function executeShowPayment()
    {
        $this->smarty = new stSmarty('stDotpayFrontend');
       
        $api = new stDotpay();

        $this->smarty->assign('params', $api->getParams($this->order));
        $this->smarty->assign('url', $api->getUrl());
        $this->smarty->assign('check_configuration', $api->checkPaymentConfiguration());
        
    }
}