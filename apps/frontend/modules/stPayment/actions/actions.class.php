<?php
/**
 * SOTESHOP/stPayment
 *
 * Ten plik należy do aplikacji stPayment opartej na licencji (Professional License SOTE).
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stPayment
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: actions.class.php 10 2009-08-24 09:32:18Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>,
 */

/**
 * Klasa stPaymentActions
 *
 * @package     stPayment
 * @subpackage  actions
 */
class stPaymentActions extends stActions {
    
    /**
     * Undocumented variable
     *
     * @var Order
     */
    protected $order;
    /**
     * Przekierowanie na strone główną sklepu jeżeli nie została wybrana żadna akcja
     */
    public function executeIndex() {
        $this->redirect('@homepage');
    }

    /**
     * Aktualizowanie dostawy za pomocą Ajax
     */
    public function executeAjaxPaymentTypeUpdate() {
        $paymnetTypeId = $this->getRequestParameter('id');
        stPayment::getInstance($this->getContext())->set($paymnetTypeId);
    }

    public function executePay() {
        $this->order = OrderPeer::retrieveByIdAndHashCode($this->getRequestParameter('id'), $this->getRequestParameter('hash_code'));

        $currency = stCurrency::getInstance($this->getContext());

        $currency->setByIso($this->order->getOrderCurrency()->getShortcut());

        if ($this->order->getIsPayed())
        {
            return $this->redirect('@stOrderSummary?id='.$this->order->getId().'&hash_code='.$this->order->getHashCode());
        }

        $this->smarty = new stSmarty($this->getModuleName());
    }
}