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
 * @version     $Id: components.class.php 10 2009-08-24 09:32:18Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>,
 */

/** 
 * Klasa stPaymentComponents
 *
 * @package     stPayment
 * @subpackage  actions
 */
class stPaymentComponents extends autoStPaymentComponents
{
    /** 
     * Pokazywanie płatności w zamówieniu
     */
    public function executePaymentsInOrder()
    {
        $c = new Criteria();
        $c->addJoin(PaymentPeer::ID, OrderHasPaymentPeer::PAYMENT_ID);
        $c->add(OrderHasPaymentPeer::ORDER_ID, $this->order->getId());
        $this->payments = PaymentPeer::doSelect($c);
    }
} 