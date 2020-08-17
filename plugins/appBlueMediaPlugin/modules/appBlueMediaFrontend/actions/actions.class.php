<?php

class appBlueMediaFrontendActions extends stActions
{
    public function executeGatewayList()
    {
        $gateways = array();

        $this->smarty = new stSmarty($this->getModuleName());

        $config = stConfig::getInstance('appBlueMedia');

        $available = $config->get('gateways');

        foreach (appBlueMedia::getInstance()->getGatewayList() as $id => $gateway)
        {
            if (isset($available[$id]))
            {
                $gateways[$id] = $gateway;
            }
        }   

        $this->smarty->assign('gateways', $gateways);
    }

    public function executeBlik()
    {
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $code = $this->getRequestParameter('code');

            $this->getUser()->setAttribute('code', $code, 'soteshop/appBlueMediaPlugin');

            sfLoader::loadHelpers(array('Helper', 'stUrl'));

            return $this->redirect('@stPaymentPay?id='.$this->getRequestParameter('order_id').'&hash_code='.$this->getRequestParameter('hash'));
        }

        return $this->forward404();
    }

    public function executeReturn()
    {
        if (!$this->hasRequestParameter('blik'))
        {
            $api = appBlueMedia::getInstance();

            $params = array(
                'ServiceID' => $this->getRequestParameter('ServiceID'),
                'OrderID' => $this->getRequestParameter('OrderID'),
                'Hash' => $this->getRequestParameter('Hash'),
            );

            if ($api->verifyHash($params['Hash'], $params))
            {
                $order = OrderPeer::retrieveByPK($params['OrderID']);

                if (!$order)
                {
                    self::log("Return from payment - order {$params['OrderID']} does not exist:\n".$params);

                    return $this->forward('appBlueMediaFrontend', 'returnFail');
                }

                $this->smarty = new stSmarty($this->getModuleName());
            }
            else
            {
                self::log("Return from payment - hash verification failure:\n".$params);

                return $this->forward('appBlueMediaFrontend', 'returnFail');
            }
        }

        $this->smarty = new stSmarty($this->getModuleName());
    }

    public function executeItn()
    {
        $data = base64_decode($this->getRequestParameter('transactions'));

        $api = appBlueMedia::getInstance();

        if ($this->getRequestParameter('hash') != appBlueMedia::getPostSecureHash())
        {
            $message = '"'.$this->getRequestParameter('hash').'" != "'.appBlueMedia::getPostSecureHash().'"';
            self::log("ITN POST security hash verification failed: $message");
        }
        elseif ($data)
        {
            $ok = true;

            self::log("ITN START:\n".trim($data));

            $transaction = $api->readNotifyRequest($data);

            if ($transaction)
            {
                if ($api->verifyHash($transaction['Hash'], $transaction))
                {
                    if ($transaction['PaymentStatus'] == 'SUCCESS')
                    {
                        $order = OrderPeer::retrieveByPK($transaction['OrderID']);

                        if ($order)
                        {
                            $payment = $order->getOrderPayment();

                            if ($payment)
                            {
                                $payment->setStatus(true);
                                $payment->save();
                                self::log("OrderID {$transaction['OrderID']} has been paid successfully");
                            }
                            else
                            {
                                self::log("Payment for OrderID {$transaction['OrderID']} does not exist");
                                $ok = false;
                            }
                        }
                        else
                        {
                            self::log("OrderID {$transaction['OrderID']} does not exist");
                            $ok = false;
                        }
                    }
                    elseif ($transaction['paymentStatus'] == 'FAILURE')
                    {
                        self::log("OrderID {$transaction['OrderID']} payment failure: ".$transaction['paymentStatusDetails']);
                        $ok = false;
                    }
                }
                else
                {
                    self::log("Hash verification failure");
                    $ok = false;
                }
            } 
            else
            {
                self::log("Couldn't parse the request");
                $ok = false;
            }
            
            self::log("ITN END");

            $this->getResponse()->clearHttpHeaders();
            $this->getResponse()->setContentType('application/xml');

            $response = array(
                'ServiceID' => $transaction['ServiceID'],
                'OrderID' => $transaction['OrderID'],
                'Status' => $ok ? 'CONFIRMED' : 'NOTCONFIRMED',
            );

            return $this->renderText($api->returnNotifyStatus($response));
        }

        return $this->renderText('OK');
    }

    public function executeProcessPayment()
    {
        $this->smarty = new stSmarty($this->getModuleName());

        $api = new appBlueMedia();
        $order = OrderPeer::retrieveByIdAndHashCode($this->getRequestParameter('id'), $this->getRequestParameter('hash'));

        sfLoader::loadHelpers(array('Helper', 'stUrl'));

        try
        {
            $response = $api->createPayment($order, $api->isBlik($order) ? array('AuthorizationCode' => $this->getUser()->getAttribute('code', null, 'soteshop/appBlueMediaPlugin')) : array()); 
            
            if (isset($response['confirmation'])) 
            {                
                if ($response['confirmation'] == 'NOTCONFIRMED' || $response['paymentStatus'] == 'FAILURE')
                {
                    $this->log('[appBlueMedia::createPayment] with response:\n'.var_export($response, true));

                    return $this->renderJSON(array('redirect' => st_url_for('@appBlueMediaFrontend?action=returnFail&blik='.$api->isBlik($order).'&order_id='.$order->getId().'&hash='.$order->getHashCode())));
                }

                $this->getUser()->setAttribute('code', null, 'soteshop/appBlueMediaPlugin');
                
                return $this->renderJSON(array('redirect' => st_url_for('@appBlueMediaFrontend?action=return&blik='.$api->isBlik($order).'&order_id='.$order->getId().'&hash='.$order->getHashCode())));
            }
            elseif (isset($response['redirecturl']))
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

        return $this->renderJSON(array('redirect' => st_url_for('@appBlueMediaFrontend?action=returnFail')));
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

        $this->smarty->assign('blik', $this->getRequestParameter('blik') ? array(
            'url' => st_url_for('@appBlueMediaFrontend?action=blik&order_id='.$this->getRequestParameter('order_id').'&hash='.$this->getRequestParameter('hash')), 
            'code' => $this->getUser()->getAttribute('code', null, 'soteshop/appBlueMediaPlugin'),
        ) : false);
    }

    public function log($message)
    {
        stPayment::log("bluemedia", $message);
    }
}