<?php

class stPayNowFrontendActions extends stActions
{
    public function executeReturn()
    {
        $status = $this->getRequestParameter('paymentStatus');
        $id = $this->getRequestParameter('id');
        $hash_code = $this->getRequestParameter('hash_code');

        $order = OrderPeer::retrieveByIdAndHashCode($id, $hash_code);

        if ($status == 'ERROR')
        {
            return $this->redirect('@stPayNowFail?id='.$id.'&hash_code='.$hash_code);
        }
        elseif ($status != 'CONFIRMED')
        {
            $order->getOrderPayment()->setInProgress(true);
            $order->getOrderPayment()->save();
        }
        else
        {
            $order->getOrderPayment()->setInProgress(false);
            $order->getOrderPayment()->save();
        }

        $this->smarty = new stSmarty($this->getModuleName());

        $this->smarty->assign('status', $status);
    }

    public function executeFail()
    {
        $this->smarty = new stSmarty($this->getModuleName());

        $webpage = WebpagePeer::retrieveByState('CONTACT');

        sfLoader::loadHelpers(array('Helper', 'stUrl'));

        $id = $this->getRequestParameter('id');
        $hash_code = $this->getRequestParameter('hash_code');

        if ($webpage)
        {
            $this->smarty->assign('contact_url', st_url_for('stWebpageFrontend/index?url='.$webpage->getFriendlyUrl()));
        }

        $this->smarty->assign('payment_url', st_url_for('@stPaymentPay?id='.$id.'&hash_code='.$hash_code));
    }

    public function executeProcessPayment()
    {
        $order = OrderPeer::retrieveByIdAndHashCode($this->getRequestParameter('id'), $this->getRequestParameter('hash'));

        stPayment::log('paynow', 'Creating new payment for order: '. $order->getNumber());

        $api = new stPayNow();
        
        $url = $api->createPayment($order);

        if ($url)
        {
            stPayment::log('paynow', 'Success: '. $url);

            return $this->renderJSON(array('redirect' => $url));
        }

        stPayment::log('paynow', 'Failure: '. $api->getLastError());

        return $this->renderJSON(array('redirect' => $this->getController()->genUrl('@stPayNowFail?id='.$order->getId().'&hash_code='.$order->getHashCode())));
    }

    public function executeNotify()
    {
        $data = trim(file_get_contents('php://input'));
        $headers = getallheaders();

        stPayment::log('paynow', 'Payment notification: '. $data);

        if ($this->getRequestParameter('token') != stPayNow::getSecurityToken())
        {
            stPayment::log('paynow', 'Wrong shop security token');
            $this->getResponse()->setStatusCode(400);
            return sfView::HEADER_ONLY;
        }

        $api = new stPayNow();
        $notification = $api->parseStatusNotification($data, $headers);

        if (false === $notification)
        {
            stPayment::log('paynow', 'Wrong signature');
            $this->getResponse()->setStatusCode(400);
            return sfView::HEADER_ONLY;
        }

        $order = OrderPeer::retrieveByNumber($notification['externalId']);

        if (!$order)
        {
            stPayment::log('paynow', sprintf('Order "%s" does not exist', $notification['externalId']));
            $this->getResponse()->setStatusCode(400);
            return sfView::HEADER_ONLY;
        }
        elseif ($order->getOrderPayment())
        {
            switch ($notification['status'])
            {
                case 'CONFIRMED':
                    $payment = $order->getOrderPayment();
                    $payment->setInProgress(false);
                    $payment->setStatus(true);
                    $payment->save();

                    stPayment::log('paynow', sprintf('Payment status for order "%s" updated succesfully', $order->getNumber()));
                break;

                case 'PENDING':
                    $payment->setInProgress(true);
                break;

                case 'REJECTED':
                    $payment->setInProgress(false);
                break;
            }
        }
        else
        {
            stPayment::log('paynow', sprintf('Payment for order "%s" does not exist', $notification['externalId']));
            $this->getResponse()->setStatusCode(400);
            return sfView::HEADER_ONLY;
        }
   
        return $this->renderResponse('OK');
    }
}