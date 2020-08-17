<?php

class stEserviceFrontendComponents extends sfComponents {

    public function executeShowPayment() {
        $this->smarty = new stSmarty('stEserviceFrontend');

        if (stPaymentType::hasOrderInSummary()) {

            $this->stEservice = new stEservice();
            $this->stWebRequest = new stWebRequest();
            
            $this->order = stPaymentType::getOrderInSummary();
            $this->user = $this->order->getOrderUserDataBilling();
            $this->lang = stPaymentType::getLanguage(array('PL', 'EN'), false);
            $this->currency = stPaymentType::getCurrency($this->order->getId());

            $this->orderId = time().'-'.$this->order->getId();
            
            $postParameters = array(
                'ClientId' => $this->stEservice->getClientId(),
                'Password' => $this->stEservice->getPassword(),
                'OrderId' => $this->orderId,
                'Total' => $this->stEservice->parseAmount(stPayment::getUnpayedAmountByOrder($this->order)),
                'Currency' => $this->currency->getCode(),
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->stEservice->getTokenUrl());
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postParameters, '', '&'));
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($ch);

            list($status, $message) = explode('&', $response);
            $this->tokenStatus = preg_match('/=ok$/i', $status);
            $this->token = preg_replace('/^msg=/', '', $message);
        }

        $this->isSecure = $this->getRequest()->isSecure();
    }
}
