<?php

use Eservice\ResponseSuccess as EserviceResponseSuccess;

class stEservice2FrontendActions extends stActions 
{

    public function executeReturnSuccess()
    {
        $this->smarty = new stSmarty($this->getModuleName());
    }

    public function executeReturnFail() 
    {
        $this->smarty = new stSmarty($this->getModuleName());
        $this->contactPage = WebpagePeer::retrieveByState('CONTACT');
    }

    public function executeReturn()
    {
        if(!$this->getRequestParameter('merchantTxId') || !$this->getRequestParameter('order_id') || !$this->getRequestParameter('hash'))
        {
            return $this->redirect('@stEservice2Plugin?action=returnFail');
        }

        stPayment::log('eservice', 'Redirect back: '. $this->getRequestParameter('merchantTxId'));

        stPayment::log('eservice', 'Checking payment status: '. $this->getRequestParameter('merchantTxId'));

        $api = new stEservice2();
        $response = $api->checkStatusByMerchantTxId($this->getRequestParameter('merchantTxId'));

        stPayment::log('eservice', 'Payment status response: '. stEservice2::format($response));

        if ($response->result == 'success' && in_array($response->status, array('SET_FOR_CAPTURE', 'CAPTURED')))
        {
            $this->updatePaymentStatus($this->getRequestParameter('order_id'), $this->getRequestParameter('hash'), $response);
            return $this->redirect('@stEservice2Plugin?action=returnSuccess');
        }

        return $this->redirect('@stEservice2Plugin?action=returnFail');
    }

    public function executeNotify()
    {
        stPayment::log('eservice', 'Payment notification: ' . json_encode($this->getRequest()->getParameterHolder()->getAll(), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        $api = new stEservice2();
        $response = $api->checkStatusByTxId($this->getRequestParameter('txId'));

        stPayment::log('eservice', 'Payment status response: '. stEservice2::format($response));

        if ($response->result == 'success')
        {
            $this->updatePaymentStatus($this->getRequestParameter('order_id'), $this->getRequestParameter('hash'), $response);
        }

        return $this->renderText('OK');
    }

    public function executeProcessPayment()
    {
        $smarty = new stSmarty('stEservice2Frontend');
        $api = new stEservice2();
        $order = OrderPeer::retrieveByIdAndHashCode($this->getRequestParameter('id'), $this->getRequestParameter('hash'));
        $response = $api->getToken($order);

        if ($response)
        {
            $smarty->assign('logo', $api->getLogoPath());
            $smarty->assign('url', $api->getPaymentUrl());
            $smarty->assign('params', array(
                'merchantId' => $response->merchantId,
                'token' => $response->token,
                'integrationMode' => 'hostedPayPage',
            ));

            return $this->renderJSON(array(
                'content' => $smarty->fetch('show_payment.html'),
            ));
        }

        return $this->renderJSON(array(
            'redirect' => $this->getController()->genUrl('@stEservice2Plugin?action=returnFail')
        ));
    }

    protected function updatePaymentStatus($orderId, $hash, EserviceResponseSuccess $status)
    {
        if (in_array($status->status, array('SET_FOR_CAPTURE','CAPTURED')))
        {
            $order = OrderPeer::retrieveByIdAndHashCode($orderId, $hash);

            if (null === $order)
            {
                stPayment::log('eservice', sprintf('Order with id "%s" doest not exist', $orderId));
            }
            else
            {
                $payment = $order->getOrderPayment();

                if (null === $payment)
                {
                    stPayment::log('eservice', sprintf('Payment for order "%s" doest not exist', $order->getNumber()));
                }
                else
                {
                    $payment->setStatus(1);
                    $payment->save();

                    stPayment::log('eservice', sprintf('Payment succefull for order "%s"', $order->getNumber()));
                }
            }
        }
    }

    // protected function processPaymentByRequest() {
    //     if ($this->getRequest()->getMethod() == sfRequest::POST) {

    //         list(, $orderId) = explode('-', $this->getRequestParameter('OrderId'));
    //         $amount = $this->getRequestParameter('Total');
    //         $status = ucfirst($this->getRequestParameter('Response'));

    //         if ($this->checkHash()) {
    //             $stPayment = new stPayment();

    //             $order = OrderPeer::retrieveByPK($orderId);

    //             if ($order) {
    //                 $payment = $order->getOrderPayment();

    //                 if ($payment) {
    //                     switch ($status) {
    //                         case stEservice::PAYMENT_PENDING:
    //                             break;
    //                         case stEservice::PAYMENT_APPROVED:
    //                             $stPayment->confirmPayment($payment->getHash());
    //                             break;
    //                         case stEservice::PAYMENT_DECLINED:
    //                             $stPayment->cancelPayment($payment->getHash());
    //                             break;
    //                     }
    //                 }
    //             }
    //         }
    //     }
    // }
}