<?php
/** 
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/** 
 * Klasa stEcardFrontendActions
 *
 * @package     stEcardPlugin
 * @subpackage  actions
 */
class stEcardFrontendActions extends stActions
{
    /** 
     * Pozytywny powrót z płatności
     */
    public function executeReturn()
    {
        if ($this->getRequest()->hasParameter('status'))
        {
            if($this->getRequest()->getParameter('status') == 'OK')
            {
                $this->forward('stEcardFrontend', 'returnSuccess');
            }
        }
        $this->forward('stEcardFrontend', 'returnFail');
    }

    /** 
     * Pozytywny powrót z płatności
     */
    public function executeReturnSuccess()
    {
        $this->smarty = new stSmarty($this->getModuleName());
    }

    /** 
     * Negatywny powrót z płatności
     */
    public function executeReturnFail()
    {
        $this->smarty = new stSmarty($this->getModuleName());
        $this->contactPage = WebpagePeer::retrieveByState('CONTACT');
    }

    /** 
     * Odbieranie statusu transakcji
     */
    public function executeStatusReport()
    {
        $state = $this->getRequestParameter('CURRENTSTATE');

        if ($state == 'payment_deposited' || $state == 'payment_closed' || $state == 'transfer_closed')
        {
            if ($this->getRequestParameter('hash') == stEcard::getPostSecureHash())
            {        
                $id = $this->getRequestParameter('ORDERNUMBER');
                $transaction = EcardTransactionPeer::retrieveByPK($id);

                $transaction_id = $transaction ? $transaction->getOrderId() : $id;

                $order = OrderPeer::retrieveByPK($transaction_id);

                if ($order && $order->getOrderPayment())
                {
                    $order->getOrderPayment()->setStatus(1);
                    $order->getOrderPayment()->setTransactionId($transaction_id);
                    $order->getOrderPayment()->save();
                }
            }
        }

        return $this->renderText('OK');
    }
}