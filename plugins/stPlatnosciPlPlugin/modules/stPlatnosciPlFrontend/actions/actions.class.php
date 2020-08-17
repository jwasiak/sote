<?php
/**
 * SOTESHOP/stPlatnosciPlPlugin
 *
 * Ten plik należy do aplikacji stPlatnosciPlPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stPlatnosciPlPlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: actions.class.php 5335 2010-05-28 11:39:59Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stPlatnosciPlFrontendActions
 *
 * @package     stPlatnosciPlPlugin
 * @subpackage  actions
 */
class stPlatnosciPlFrontendActions extends stActions
{
    /**
     * Pozytywny powrót z płatności
     */
    public function executeReturnSuccess()
    {
        if ($this->hasRequestParameter('error'))
        {
            return $this->redirect('@stPlatnosciPlPlugin?action=returnFail');
        }
        
        $this->smarty = new stSmarty($this->getModuleName());
    }

    /**
     * Negatywny powrót z płatności
     */
    public function executeReturnFail()
    {
        $this->smarty = new stSmarty($this->getModuleName());

        $webpage = WebpagePeer::retrieveByState('CONTACT');

        if ($webpage)
        {
            sfLoader::loadHelpers(array('Helper', 'stUrl'));
            $this->smarty->assign('contact_url', st_url_for('stWebpageFrontend/index?url='.$webpage->getFriendlyUrl()));
        }
    }

    public function executeProcessPayment()
    {
        $this->smarty = new stSmarty('stPlatnosciPlFrontend');

        $api = new stPlatnosciPl();
        $order = OrderPeer::retrieveByIdAndHashCode($this->getRequestParameter('id'), $this->getRequestParameter('hash'));

        try
        {
            $url = $api->getOrderFormUrl($order); 
            
            if ($url) 
            {                
                return $this->renderJSON(array('redirect' => $url));
            }
        }   
        catch (OpenPayU_Exception $e) 
        {
            stPlatnosciPl::log("Process Payment - Exception:\n".$e->getFile().':'.$e->getLine().':'.$e->getMessage());
        } 

        sfLoader::loadHelpers(array('Helper', 'stUrl'));
        return $this->renderJSON(array('redirect' => st_url_for('stPlatnosciPlFrontend/returnFail?type=process')));
    }

    /**
     * Odbieranie statusu transakcji
     */
    public function executeStatusReport()
    {
        $body = file_get_contents('php://input');
        $data = trim($body);

        stPlatnosciPl::log("Status Report Request:\n".$data);

        $api = new stPlatnosciPl();

        try
        {
            $order = $api->getOrderNotify($data);
        } catch (OpenPayU_Exception $e) {
            stPlatnosciPl::log("Status Report - Exception:\n".$e->getFile().':'.$e->getLine().':'.$e->getMessage());
            throw $e;
        }

        if ($order && $order->status == 'COMPLETED')
        {
            $payment_id = null;

            if ($this->hasRequestParameter('id')) 
            {
                $order = OrderPeer::retrieveByIdAndHashCode($this->getRequestParameter('id'), $this->getRequestParameter('hash'));

                if (null !== $order) 
                {
                    $payment = $order->getOrderPayment();

                    if (!$payment)
                    {
                       stPlatnosciPl::log("Status Report: Payment for order id {$this->getRequestParameter('id')} does not exist"); 
                    }
                }
                else
                {
                    stPlatnosciPl::log("Status Report: Order with id {$this->getRequestParameter('id')} does not exist");
                }
                
            }   
            else
            {
                list($id) = explode(':', $order->extOrderId);
                $payment = PaymentPeer::retrieveByPK($id);    

                if (!$payment)
                {
                    stPlatnosciPl::log("Status Report: Payment with id $id does not exist");
                }
            }

            if ($payment)
            {
                $payment->setStatus(true);
                $payment->save();
                stPlatnosciPl::log("Status Report: Payment with id {$payment->getId()} paid successfully");
            }
        }

        return $this->renderText('OK');
    }
}