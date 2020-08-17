<?php

class stCashBillFrontendActions extends stActions {

    public function executeReturnSuccess() {
        $this->smarty = new stSmarty($this->getModuleName());
    }

    public function executeReturnFail() {
        $this->smarty = new stSmarty($this->getModuleName());
        $this->contactPage = WebpagePeer::retrieveByState('CONTACT');
    }

    public function executeNewPaymentFail() {
        $this->smarty = new stSmarty($this->getModuleName());
        $this->contactPage = WebpagePeer::retrieveByState('CONTACT');
    }

    public function executeReportStatus() {
        $this->setLayout(false);

        $cmd = $this->getRequest()->getParameter('cmd');
        $args = $this->getRequest()->getParameter('args');
        $sign = $this->getRequest()->getParameter('sign');

        $stCashBill = new stCashBill();

        $shopSign = md5($cmd.$args.$stCashBill->getSecretKey());

        if ($shopSign == $sign) {
            try {
                $client = new stCashBillSoapClient($stCashBill->getSoapUri());
                $response = $client->getPayment(array('id' => $args));
            } catch (SoapFault $e) {
                $response = null;
            }

            if ($response !== null) {                
                $data = unserialize($response->return->additionalData);

                if (false === $data) {
                  $stPayment = new stPayment();
                  if ($response->return->status == 'PositiveFinish')
                      $stPayment->confirmPayment($response->return->additionalData);
                  elseif ($response->return->status == 'NegativeFinish')
                      $stPayment->cancelPayment($response->return->additionalData);
                } elseif ($response->return->status == 'PositiveFinish') {
                    $payment = PaymentPeer::retrieveByIdAndHash($data['id'], $data['hash']);

                    if ($payment) 
                    {
                      $payment->setStatus(true);
                      $payment->save();
                    }
                    else
                    {
                      file_put_contents(sfConfig::get('sf_root_dir').'/log/cashbill.txt', '['.date('d-m-Y H:i:s').'] No Payment instance for:'.var_export($response->return, true)."\n", FILE_APPEND);
                    }
                }
            }
        }
    }

    public function executeNewPayment() {
        $url = '@stCashBillPluginNewPaymentFail';
        if ($this->getRequest()->hasParameter('id') && $this->getRequest()->hasParameter('hash')) {
            $id = $this->getRequest()->getParameter('id');
            $hash = $this->getRequest()->getParameter('hash');
            $order = OrderPeer::retrieveByIdAndHashCode($id, $hash);

            $channelId = $this->getRequest()->getParameter('channelId', null);

            if (is_object($order)) {
                $stCashBill = new stCashBill();
                $stWebRequest = new stWebRequest();
                $user = $order->getOrderUserDataBilling();
                $payment = $order->getOrderPayment();

                try {
                    $client = new stCashBillSoapClient($stCashBill->getSoapUri());
                    $parameters = array(
                        'title' => $this->getContext()->getI18n()->__('Zamówienie numer:').' '.$order->getNumber(),
                        'amount' => array(
                            'value' => $stCashBill->parseAmount(stPayment::getUnpayedAmountByOrder($order)),
                            'currencyCode' => stPaymentType::getCurrency($order->getId())->getShortcut(),
                        ),
                        'languageCode' => stPaymentType::getLanguage(array('PL', 'EN')),
                        'returnUrl' => 'http://'.$stWebRequest->getHost().'/cashbill/returnSuccess',
                        'negativeReturnUrl' => 'http://'.$stWebRequest->getHost().'/cashbill/returnFail',
                        'personalData' => array(
                            'firstName' => $user->getName(),
                            'surname' => $user->getSurname(),
                            'email' => $order->getGuardUser()->getUsername(),
                        ),
                        'additionalData' => serialize(array('id' => $payment->getId(), 'hash' => $payment->getHash())),
                        'referer' => 'SOTE',
                    );

                    if ($channelId !== null)
                        $parameters['paymentChannel'] = $channelId;

                    $response = $client->newPayment($parameters);

                    if(is_object($response))
                        $url = $response->return->redirectUrl;
                } catch (SoapFault $e) {
                    file_put_contents(sfConfig::get('sf_root_dir').'/log/cashbill.txt', '['.date('d-m-Y H:i:s').'] Order number '.$order->getNumber().':'.var_export($e->getMessage(), true)."\n", FILE_APPEND);
                }
            }
        }
        $this->redirect($url);
        exit();
    }
}
