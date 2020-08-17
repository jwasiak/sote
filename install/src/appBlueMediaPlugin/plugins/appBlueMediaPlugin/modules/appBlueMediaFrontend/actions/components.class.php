<?php

class appBlueMediaFrontendComponents extends sfComponents
{
    public function executeHelper()
    {
        if (stTheme::getInstance($this->getContext())->getVersion() < 7 || !stConfig::getInstance('appBlueMedia')->get('gateways_popup'))
        {
            return sfView::NONE;
        }
        
        $smarty = new stSmarty('appBlueMediaFrontend');
        $payment = appBlueMedia::getBlueMediaPayment();
        
        if (null === $payment)
        {
            return sfView::NONE;
        }

        $smarty->assign('payment', $payment);
        return $smarty;
    }

    public function executeGateway()
    {
        if (stTheme::getInstance($this->getContext())->getVersion() < 7)
        {
            return sfView::NONE;
        }

        $smarty = new stSmarty('appBlueMediaFrontend');
        $smarty->assign('gateway', $this->getRequestParameter('user_data_billing[bluemedia_gateway]'));
        return $smarty;
    }

    public function executeShowPayment()
    {
        $api = new appBlueMedia();
        $order = $this->order;

        sfLoader::loadHelpers(array('Helper', 'stUrl'));

        try
        {
            $response = $api->createPayment($order, array()); 
            
            if (isset($response['confirmation'])) 
            {                
                if ($response['confirmation'] == 'NOTCONFIRMED' || $response['paymentStatus'] == 'FAILURE')
                {
                    $this->log('[appBlueMedia::createPayment] with response:\n'.var_export($response, true));

                    $this->getController()->redirect(st_url_for('@appBlueMediaFrontend?action=returnFail&blik='.$api->isBlik($order).'&order_id='.$order->getId().'&hash='.$order->getHashCode()));
                    throw new sfStopException();
                }

                $this->getUser()->setAttribute('code', null, 'soteshop/appBlueMediaPlugin');
                
                $this->getController()->redirect(st_url_for('@appBlueMediaFrontend?action=return&blik='.$api->isBlik($order).'&order_id='.$order->getId().'&hash='.$order->getHashCode()));
                throw new sfStopException();
            }
            elseif (isset($response['redirecturl']))
            {
                $this->getController()->redirect($response['redirecturl']);
                throw new sfStopException();
            }
            else
            {
                $this->log('[appBlueMedia::createPayment] with response:\n'.var_export($response, true));
            }
        }   
        catch (sfStopException $e)
        {
            throw $e;
        }
        catch (Exception $e) 
        {
            $this->log('[appBlueMedia::createPayment] with exception:\n'.$e->getMessage());          
        } 

        $this->getController()->redirect(st_url_for('@appBlueMediaFrontend?action=returnFail'));   
        throw new sfStopException();     
    }

    public function executeShowBlik()
    {     
        if (stTheme::getInstance($this->getContext())->getVersion() < 7)
        {
            return sfView::NONE;
        }

        $paymentType = $this->payment->getPayment();

        $config = stConfig::getInstance('appBlueMedia');

        if (!$paymentType || $paymentType->getModuleName() != 'appBlueMedia' || !$config->get('gateways_popup') && $paymentType->getConfigurationParameter('gateway_id') != appBlueMedia::BLIK_GATEWAY)
        {
            return sfView::NONE;
        } 
        
        $smarty = new stSmarty('appBlueMediaFrontend');

        if ($paymentType->getConfigurationParameter('gateway_id') != appBlueMedia::BLIK_GATEWAY)
        {
            $id = $this->getRequestParameter('user_data_billing[bluemedia_gateway]');
            $gateway = appBlueMedia::getInstance()->getGatewayInfo($id);
            $smarty->assign('gateway', $gateway);
        }
        else
        {
            return sfView::NONE;
            
            if ($this->getRequestParameter('app_bluemedia_blik_code'))
            {
                $this->getUser()->setAttribute('code', $this->getRequestParameter('app_bluemedia_blik_code'), 'soteshop/appBlueMediaPlugin');
            }

            $smarty->assign('payment', $this->payment);
            $smarty->assign('show', $this->payment->getId() == $this->getUser()->getAttribute('delivery_payment', null, stDeliveryFrontend::SESSION_NAMESPACE));
            $smarty->assign('code', $this->getUser()->getAttribute('code', null, 'soteshop/appBlueMediaPlugin'));
        }   

        $smarty->assign('config', $config);

        return $smarty;
    }

    public function log($message)
    {
        stPayment::log("bluemedia", $message);
    }
}