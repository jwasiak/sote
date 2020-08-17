<?php
/**
 * SOTESHOP/stLukasPlugin
 *
 * Ten plik należy do aplikacji stLukasPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stLukasPlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: components.class.php 2020 2009-11-05 15:03:10Z krzysiek $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stLukasFrontendComponents
 *
 * @package     stLukasPlugin
 * @subpackage  actions
 */
class stLukasFrontendComponents extends sfComponents {

    /**
     * Pokazywanie formularza płatności
     */
    public function executeShowPayment() {
        $this->smarty = new stSmarty('stLukasFrontend');
        if (stPaymentType::hasOrderInSummary()) {
            $this->stLukas = new stLukas();
            $this->order = stPaymentType::getOrderInSummary();
        }
    }

    /**
     * Obliczanie rat w produkcie
     */
    public function executeCalculate() {
        $this->smarty = new stSmarty('stLukasFrontend');

        if (!stLukas::isActive() || !stLukas::showInProduct(ProductPeer::getShowedProduct()))
            return sfView::NONE;
    }

    /**
     * Obliczanie rat w koszyku
     */
    public function executeCalculateInBasket() {
        $this->smarty = new stSmarty('stLukasFrontend');
    }

    /**
     * Obliczanie rat w potwierdzeniu zamówienia
     */
    public function executeOrderSummary() {
        $this->smarty = new stSmarty('stLukasFrontend');

        $this->basket = stBasket::getInstance(sfContext::getInstance()->getUser());
        $this->delivery = stDeliveryFrontend::getInstance($this->basket);
    }
}