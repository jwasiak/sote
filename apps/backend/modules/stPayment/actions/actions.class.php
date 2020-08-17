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
class stPaymentActions extends autostPaymentActions
{
    protected $join = false;
    /** 
     * Zmiana statusu zamówienia
     */
    public function executeUpdatePaymentInOrderEdit()
    {
        $paymentId = $this->getRequestParameter('id');

        $payment = PaymentPeer::retrieveByPK($paymentId);
        if (is_object($payment))
        {
            $payment->setStatus(1);
            $payment->save();
        }

        $this->order = OrderPeer::retrieveByPK($this->getRequestParameter('order_id'));
    }

    /** 
     * Dodanie filtrów
     *
     * @param      Criteria    $c
     */
    protected function addFiltersCriteria($c)
    {
        parent::addFiltersCriteria($c);

        if (isset($this->filters['order_code']) && $this->filters['order_code'] !== '')
        {
            $this->addJoinCriteria($c);
            $c->add(OrderPeer::NUMBER, '%' . $this->filters['order_code'] . '%', Criteria::LIKE);
        }
    }

    protected function addSortCriteria($c)
    {
        $sort_column = $this->getUser()->getAttribute('sort', null, 'sf_admin/autoStPayment/sort');

        if ($sort_column == 'order_code') {
            $this->addJoinCriteria($c);
        }

        parent::addSortCriteria($c);
    }

    protected function addJoinCriteria(Criteria $c)
    {
        if (!$this->join)
        {
            $this->join = true;
            $c->addJoin(PaymentPeer::ID,OrderHasPaymentPeer::PAYMENT_ID, Criteria::LEFT_JOIN);
            $c->addJoin(OrderHasPaymentPeer::ORDER_ID,OrderPeer::ID, Criteria::LEFT_JOIN);
            $c->addGroupByColumn(PaymentPeer::ID);
        }        
    }
}