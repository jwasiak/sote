<?php
/**
 * SOTESHOP/stPolcardPlugin
 *
 * Ten plik należy do aplikacji stPolcardPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stPolcardPlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: components.class.php 10 2009-08-24 09:32:18Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stPolcardFrontendComponents
 *
 * @package     stPolcardPlugin
 * @subpackage  actions
 */
class stPolcardFrontendComponents extends sfComponents {
    
    /**
     * Pokazywanie formularza płatności
     */
    public function executeShowPayment() {
        $this->smarty = new stSmarty('stPolcardFrontend');

      
        $order = stPaymentType::getOrderInSummary();

        $api = new stPolcard();
        $params = $api->getFormParams($order); 

        $this->smarty->assign('params', $params);
        $this->smarty->assign('url', $api->getUrl());
        $this->smarty->assign('check_configuration', $api->checkPaymentConfiguration()); 
    }
}