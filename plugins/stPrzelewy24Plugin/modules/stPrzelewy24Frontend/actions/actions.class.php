<?php
/**
* SOTESHOP/stPrzelewy24Plugin
*
* Ten plik należy do aplikacji stPrzelewy24Plugin opartej na licencji (Professional License SOTE).
* Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
* Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
* oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
*
* @package     stPrzelewy24Plugin
* @subpackage  actions
* @copyright   SOTE (www.sote.pl)
* @license     http://www.sote.pl/license/sote (Professional License SOTE)
* @version     $Id: actions.class.php 10 2009-08-24 09:32:18Z michal $
* @author      Michal Prochowski <michal.prochowski@sote.pl>
*/

/**
 * Klasa stPrzelewy24FrontendActions
 *
 * @package     stPrzelewy24Plugin
 * @subpackage  actions
 */
class stPrzelewy24FrontendActions extends stActions 
{
    
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
        $this->smarty = new stSmarty('stPrzelewy24Frontend');

        $webpage = WebpagePeer::retrieveByState('CONTACT');
        
        if ($webpage)
        {
            sfLoader::loadHelpers(array('Helper', 'stUrl'));
            $this->smarty->assign('contact_url', st_url_for('stWebpageFrontend/index?url='.$webpage->getFriendlyUrl()));
        } 
    }

    public function executeProcessPayment()
    {
        $request = $this->getRequest();

        $order = OrderPeer::retrieveByIdAndHashCode($this->getRequestParameter('id'), $this->getRequestParameter('hash'));

        if ($order)
        {
            $this->api = new stPrzelewy24();

            try
            {
                $url = $this->api->getPaymentUrl($order);

                stPayment::log("przelewy24", "Generate payment url for order with id {$order->getId()}: $url");   
            }
            catch (Exception $e)
            {
                stPayment::log("przelewy24", "Generate payment url exception for order with id {$order->getId()}: {$e->getMessage()}");   
            }

            if ($url) 
            {
                return $this->renderJSON(array('redirect' => $url));
            }
        }

        return $this->renderJSON(array('redirect' => $this->getController()->genUrl('stPrzelewy24Frontend/returnFail')));    
    }

    public function executeStatus()
    {
        $request = $this->getRequest();

        $order = OrderPeer::retrieveByIdAndHashCode($request->getParameter('id'), $request->getParameter('hash'));

        if ($order)
        {
            $api = new stPrzelewy24();

            try
            {
                if ($api->verify($order, $request))
                {
                    $payment = $order->getOrderPayment();

                    if ($payment)
                    {
                        $payment->setStatus(true);
                        $payment->save();

                        stPayment::log("przelewy24", "Payment status update for order with id {$order->getId()}: successful");
                    } 
                    else 
                    {
                        stPayment::log("przelewy24", "Payment status update: Payment for order with id {$order->getId()} does not exist");
                    }
                }
            } catch (Exception $e)
            {
                stPayment::log("przelewy24", "Payment status update exception for order with id {$order->getId()}: ". $e->getMessage());
            }
        }
        else 
        {
            stPayment::log("przelewy24", "Payment status update: Order with id {$request->getParameter('id')} does not exist");   
        }

        return $this->renderText("OK");
    }
}
