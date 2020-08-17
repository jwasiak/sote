<?php
/**
 * SOTESHOP/stOrder
 *
 * Ten plik należy do aplikacji stOrder opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stOrder
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: components.class.php 3622 2010-02-19 14:45:15Z marcin $
 */

/**
 * Klasa stOrderComponents
 * 
 * @package     stOrder
 * @subpackage  actions
 */
class stOrderComponents extends sfComponents
{
    public function executeLastOrdersByUser()
    {
        $this->smarty = new stSmarty('stOrder');
        
        $user_id = $this->getUser()->getGuardUser()->getId();

        $c = new Criteria();

        $c->add(OrderPeer::SF_GUARD_USER_ID, $user_id);

        $c->addDescendingOrderByColumn(OrderPeer::CREATED_AT);

        $this->orders = OrderPeer::doSelectJoinAll($c);

        $this->limit = new Criteria();

        
    }

    public function executeSubmitButton()
    {
        $basket = stBasket::getInstance($this->getUser());

        $delivery = stDeliveryFrontend::getInstance($basket);

        $has_basket_errors = $this->getUser()->getAttribute('is_blocked', false, stBasket::SESSION_NAMESPACE);

        $this->disabled = !$delivery->hasDeliveries() || !$delivery->getDefaultDelivery()->hasDeliveryPayments() || $has_basket_errors;

        $this->smarty = new stSmarty('stOrder');
    }

    /**
     * Wyswietlanie uwag do zamowienia 
     */
    public function executeOrderDescription()
    {
        $this->smarty = new stSmarty('stOrder');
        
        $this->description = "";
        
        if ($this->getRequest()->hasParameter('description'))
        {
            $this->description = $this->getRequestParameter('description');
        }
    }
    
    /**
     * Wyświetlanie listy zamówień klienta
     */
    public function executeOrdersList()
    {
        $this->smarty = new stSmarty('stOrder');
    }
}