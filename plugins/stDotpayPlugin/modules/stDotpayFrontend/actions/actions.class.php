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
 * @version     $Id: actions.class.php 10 2009-08-24 09:32:18Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/** 
 * Klasa stDotpayFrontendActions
 *
 * @package     stDotpayPlugin
 * @subpackage  actions
 */
class stDotpayFrontendActions extends stActions
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
                $this->forward('stDotpayFrontend', 'returnSuccess');
            }
        }
        $this->forward('stDotpayFrontend', 'returnFail');
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
        $api = new stDotpay();

        if ($api->verifySignature($this->getRequest()))
        {
            $order_id = $this->getRequestParameter('order_id');
            $order_hash = $this->getRequestParameter('hash');

            $order = OrderPeer::retrieveByIdAndHashCode($order_id, $order_hash);

            if (null !== $order) 
            {
                $payment = $order->getOrderPayment();

                if (null !== $payment)
                {
                    if ($this->getRequestParameter('operation_status') == 'completed')
                    {                        
                        $payment->setStatus(true);
                        $payment->save();
                        stPayment::log('dotpay', "Status Report (order_id: $order_id) - Order paid successfully");
                    }
                }
                else
                {
                    stPayment::log('dotpay', "Status Report (order_id: $order_id) - Missing payment instance");

                    return $this->renderText('Missing payment instance');
                }
            }
            else
            {
                stPayment::log('dotpay', "Status Report (order_id: $order_id) - Missing order instance");

                return $this->renderText('Missing order instance');
            }
        }
        else
        {
            stPayment::log('dotpay', "Status Report (order_id: $order_id) - Wrong signature for params: " . var_export($this->getRequest()->getParameterHolder()->getAll(), true));

            return $this->renderText('Wrong signature');
        }

        return $this->renderText('OK');
    }
}