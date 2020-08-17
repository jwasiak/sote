<?php
class stPayByNetFrontendComponents extends sfComponents {

    public function executeShowPayment() {
        $this->smarty = new stSmarty('stPayByNetFrontend');

        if (stPaymentType::hasOrderInSummary()) {
            $this->stPayByNet = new stPayByNet();
            $this->stWebRequest = new stWebRequest();

            $this->formUrl = $this->stPayByNet->getPayByNetUrl();

            $this->order = stPaymentType::getOrderInSummary();
            $this->user = $this->order->getOrderUserDataBilling();

            $controller = $this->getController();

            $hash = array(
                'id_client' => $this->stPayByNet->getIdClient(),
                'id_trans' => $this->stPayByNet->parseOrderId($this->order->getId()),
                'date_valid' => date('d-m-Y H:i:s', time()+86400),
                'amount' => $this->stPayByNet->getOrderAmount(stPayment::getUnpayedAmountByOrder($this->order)),
                'currency' => 'PLN',
                'email' => $this->order->getGuardUser()->getUsername(),
                'account' => $this->stPayByNet->getAccount(),
                'accname' => $this->stPayByNet->getAccname(),
                'backpage' => $controller->genUrl('@stPayByNetPlugin?action=returnSuccess&id='.$this->order->getId().'&hash='.$this->order->getHashCode(), true),
                'backpagereject' => $controller->genUrl('@stPayByNetPlugin?action=returnFail&id='.$this->order->getId().'&hash='.$this->order->getHashCode(), true),
                'description' => $this->getContext()->getI18N()->__("Zamówienie nr", null, 'stOrder').' '.$this->order->getNumber(),
                );

            $this->hashtrans = '';
            foreach ($hash as $k => $p) {
                $this->hashtrans .= '<'.$k.'>'.$p.'</'.$k.'>';
            }

            $sha1 = sha1($this->hashtrans.'<password>'.$this->stPayByNet->getPassword().'</password>'); 

            $this->hashtrans .= '<hash>'.$sha1.'</hash>';
            $this->hashtrans = base64_encode($this->hashtrans);

            $c = new Criteria();
            $c->add(PaybynetHasOrderPeer::ORDER_ID, $this->order->getId());
            $paybynet = PaybynetHasOrderPeer::doSelectOne($c);

            if (is_object($paybynet)) {
                $type = $paybynet->getPaymentType();
                if (preg_match('/^BS/', $type))
                    list($type,) = explode(',', $type);

                $this->formUrl = $this->stPayByNet->getPayByNetUrl().'?idbank='.$type;
            }
        }
    }

    public function executeShowPaymentType() {
        $this->smarty = new stSmarty('stPayByNetFrontend');
        $this->banks = array();
        $stPayByNet = new stPayByNet();

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $stPayByNet->getPayByNetBankListUrl());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);

        $card = $stPayByNet->getCard();

        $xml = simplexml_load_string($response);
        foreach ($xml->bank as $bank) {
            if (((int)$bank->card == 1 && $card) || !(int)$bank->card)
                $this->banks[(string)$bank->id] = (string)$bank->name;
        }

        if (empty($this->banks))
            return sfView::NONE;
    }

    public function executePaymentTypeHidden() {
        $this->id = '';
        if ($this->getRequest()->getMethod() == sfRequest::POST && $this->getRequestParameter('submit_save'))
            $this->id = $this->getRequestParameter('user_data_billing[paybynet]');
    }
}
