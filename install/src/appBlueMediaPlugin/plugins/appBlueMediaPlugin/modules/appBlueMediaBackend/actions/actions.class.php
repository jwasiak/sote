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
 * @version     $Id: actions.class.php 15168 2011-09-20 11:56:58Z michal $
 * @author      Marcin Butlak <marcin.butlak@sote.pl>
 */

/**
 * Klasa appBlueMediaBackendActions
 *
 * @package     stPlatnosciPlPlugin
 * @subpackage  actions
 */
class appBlueMediaBackendActions extends stActions
{
    public function executeProcessPayment()
    {
        $order = OrderPeer::retrieveByIdAndHashCode($this->getRequestParameter('id'), $this->getRequestParameter('hash'));

        $api = new appBlueMedia();

        try
        {
            $response = $api->createPayment($order, array()); 
            
            if (isset($response['redirecturl']))
            {
                return $this->renderJSON(array('redirect' => $response['redirecturl']));
            }
            else
            {
                $this->log('[appBlueMedia::createPayment] with response:\n'.var_export($response, true));
            }
        }   
        catch (Exception $e) 
        {
            $this->log('[appBlueMedia::createPayment] with exception:\n'.$e->getMessage());          
        } 

        sfLoader::loadHelpers(array('Helper', 'stUrl'));
        return $this->renderJSON(array('redirect' => st_url_for('@appBlueMediaFrontend?action=returnFail')));
    }

    /**
     * Wyświetla konfigurację modułu
     */
    public function executeIndex()
    {
        $this->labels = $this->getLabels();

        $fc = stFunctionCache::getInstance('appBlueMediaPlugin');
        $fc->removeAll();
           	
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $this->config->save();
            $this->setFlash('notice', 'Twoje zmiany zostały zapisane');
        }
    }

    public function validateIndex()
    {
        $this->config = stConfig::getInstance('appBlueMedia');

        $payments = appBlueMedia::getPayments(false);

        $ok = true;

        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            stAuthUsersListener::checkModificationCredentials($this, $this->getRequest(), $this->getModuleName());

            $data = $this->getRequestParameter('config');

            $i18n = $this->getContext()->getI18N();

            if (stTheme::getInstance($this->getContext())->getVersion() < 7)
            {
                $this->getRequest()->setError('api', $i18n->__('Funkcjonalność dostępna tylko i wyłącznie dla nowych tematów responsywnych'));
                $ok = false;
            } 

            if (!$data['id'])
            {
                $this->getRequest()->setError('config{id}', $i18n->__('Proszę uzupełnić pole.'));

                $ok = false;
            }

            if (!$data['key'])
            {
                $this->getRequest()->setError('config{key}', $i18n->__('Proszę uzupełnić pole.'));

                $ok = false;
            }

            $this->config->setFromRequest('config');

            if ($ok)
            {
                $api = appBlueMedia::getInstance();

                try
                {
                    $gatewayList = $api->getGatewayList(true);
                }
                catch(Exception $e)
                {
                    sfLogger::getInstance()->err('{appBlueMediaPlugin} '.$e->getMessage());
                    $this->getRequest()->setError('api', $i18n->__('Wystąpił błąd podczas próby połączenia się z serwisem. Proszę sprawdzić czy wprowadzone dane są poprawne i spróbować ponownie.'));
                    $ok = false;
                } 

                if ($ok)
                {
                    $tokens = stJQueryToolsHelper::parseTokensFromRequest($this->getRequestParameter('gateways')); 
                        
                    if (!$tokens)
                    {
                        $this->getRequest()->setError('gateways', $i18n->__('Proszę uzupełnić pole.'));
                        $this->config->set('gateways', array());
                    }
                    else
                    {
                        if ($this->config->get('gateways_popup')) 
                        {
                            foreach ($payments as $activeGateway)
                            {
                                $activeGateway->setActive(false);
                                $activeGateway->save();
                            }

                            if (!appBlueMedia::getBlueMediaPayment()) 
                            {
                                $activeGateway = new PaymentType();
                                $activeGateway->setActive(true);
                                $activeGateway->setCulture(stLanguage::getOptLanguage());
                                $activeGateway->setName('Blue Media');
                                $activeGateway->setModuleName('appBlueMedia');
                                $activeGateway->setConfigurationParameter('gateway_id', 0); 
                                $activeGateway->save();                               
                            }
                            else
                            {
                                $activeGateway = appBlueMedia::getBlueMediaPayment();
                                $activeGateway->setActive(true);
                                $activeGateway->save();
                            }

                            $gateways = array();

                            foreach ($tokens as $token)
                            {
                                $gateways[$token['id']] = $token['id'];
                            }

                            $this->activeGateways = $gateways;

                            $this->config->set('gateways', $gateways);
                        }
                        else
                        {                           
                            foreach ($payments as $payment)
                            {
                                $payment->setActive(false);
                            }

                            foreach ($tokens as $token)
                            {
                                $gatewayId = $token['id'];

                                if (!isset($payments[$gatewayId]))
                                {
                                    $payment = new PaymentType();
                                    $payment->setCulture(stLanguage::getOptLanguage());
                                    $payment->setName($gatewayList[$gatewayId]['name']);
                                    $payment->setModuleName('appBlueMedia');
                                    $payment->setHideForConfiguration(true);
                                    $payment->setConfigurationParameter('gateway_id', $gatewayId);

                                    $payments[$gatewayId] = $payment;
                                }

                                $payments[$gatewayId]->setActive(true);
                            }

                            foreach ($payments as $id => $payment)
                            {
                                if (!$payment->getActive())
                                {
                                    unset($payments[$id]);
                                } 
                                
                                $payment->save();
                            }  
                        }          

                        $this->config->set('configuration_check', true);
                    }
                }
            }
        }

        if ($ok)
        {
            try
            {
                $this->gateways = appBlueMedia::getInstance()->getGatewayList($this->getRequest()->getMethod() == sfRequest::POST);
            }
            catch(Exception $e)
            {
                $this->gateways = array();
            }
        }

        if ($this->config->get('gateways_popup'))
        {
            $this->activeGateways = $this->config->get('gateways');
        }
        else
        {
            $activeGateways = array();

            foreach ($payments as $payment)
            {
                if ($payment->getActive())
                {
                    $activeGateways[$payment->getConfigurationParameter('gateway_id')] = $payment->getConfigurationParameter('gateway_id');
                }
            }

            $this->activeGateways = $activeGateways;
        }
        
        return !$this->getRequest()->hasErrors();
    }   

    public function getLabels()
    {
        return array(
            'config{id}' => 'ID',
            'config{key}' => $this->getContext()->getI18n()->__('Klucz'),
            'api' => 'Blue Media',
            'gateways' => $this->getContext()->getI18n()->__('Kanały płatności'),
        );   
    }   

    /**
     * Akcja w przypadku błędu w uzupełnianiu pól
     */
    public function handleErrorIndex()
    {        
        $this->labels = $this->getLabels();
        
        return sfView::SUCCESS;
    }
}