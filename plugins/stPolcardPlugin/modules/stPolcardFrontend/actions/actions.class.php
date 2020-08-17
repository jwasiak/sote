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
 * @version     $Id: actions.class.php 10 2009-08-24 09:32:18Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stPolcardFrontendActions
 *
 * @package     stPolcardPlugin
 * @subpackage  actions
 */
class stPolcardFrontendActions extends stActions
{
    /**
     * Pozytywny powrót z płatności
     */
    public function executeReturnSuccess()
    {
        $this->smarty = new stSmarty($this->getModuleName());

        $params = $this->getRequest()->getParameterHolder()->getAll();

        $this->processResponse($params);        
    }

    /**
     * Brak autoryzacji płatności
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

    public function executeStatusReport()
    {
        $params = $this->getRequest()->getParameterHolder()->getAll();

        return $this->renderText($this->processResponse($params));
    }

    protected function processResponse($params)
    {
        $api = new stPolcard();

        stPayment::log('payeezy', json_encode($params, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE));

        if ($api->isValid($params) && isset($params['order_id']) && isset($params['response_code']) && in_array($params['response_code'], array(30, 35)))
        {
            $order = OrderPeer::retrieveByNumber($params['order_id']);

            if ($order)
            {
                $payment = $order->getOrderPayment();

                if ($payment)
                {
                    $payment->setStatus(1);
                    $payment->save();
                    stPayment::log('payeezy', sprintf("Zamówienie o numerze \"%s\" zostało opłacone", $params['order_id']));
                }
                else
                {
                    $log = sprintf("Zamówienie o numerze \"%s\" nie posiada płatności", $params['order_id']);
                    stPayment::log('payeezy', $log);
                    return $log; 
                }
            }
            else
            {
                $log = sprintf("Zamówienie o numerze \"%s\" nie istnieje", $params['order_id']);
                stPayment::log('payeezy', $log);
                return $log; 
            }
        }
        else
        {
            $log = "Brak zgodności sum kontrolnych";
            stPayment::log('payeezy', $log);
            return $log; 
        }

        return "OK";        
    }
}