<?php

class stEserviceFrontendActions extends stActions {

    public function executeReturnSuccess() {
        $this->smarty = new stSmarty($this->getModuleName());
        $this->processPaymentByRequest();
    }

    public function executeReturnFail() {
        $this->smarty = new stSmarty($this->getModuleName());
        $this->processPaymentByRequest();
        $this->contactPage = WebpagePeer::retrieveByState('CONTACT');
    }

    public function executeReturnPending() {
        $this->smarty = new stSmarty($this->getModuleName());
        $this->processPaymentByRequest();
    }

    protected function processPaymentByRequest() {
        if ($this->getRequest()->getMethod() == sfRequest::POST) {

            list(, $orderId) = explode('-', $this->getRequestParameter('OrderId'));
            $amount = $this->getRequestParameter('Total');
            $status = ucfirst($this->getRequestParameter('Response'));

            if ($this->checkHash()) {
                $stPayment = new stPayment();

                $order = OrderPeer::retrieveByPK($orderId);

                if ($order) {
                    $payment = $order->getOrderPayment();

                    if ($payment) {
                        switch ($status) {
                            case stEservice::PAYMENT_PENDING:
                                break;
                            case stEservice::PAYMENT_APPROVED:
                                $stPayment->confirmPayment($payment->getHash());
                                break;
                            case stEservice::PAYMENT_DECLINED:
                                $stPayment->cancelPayment($payment->getHash());
                                break;
                        }
                    }
                }
            }
        }
    }

    protected function checkHash()
    {
        $stEservice = new stEservice();
        $storeKey = $stEservice->getStoreKey();

        $sep = "|";
        $secureCount = 0;

        $params = array();

        foreach(explode($sep, $this->getRequestParameter('HASHPARAMS')) as $hashParam)
        {
            if($hashParam == "ClientId" || $hashParam == "Response" || $hashParam == "OrderId")
            {
                      $secureCount++;
            }
            
            $params[] = $this->getRequestParameter($hashParam, '');      
        }

        $hashParamsVal = implode($sep, $params);
        $hash = base64_encode(hash('sha512', $hashParamsVal .$sep. $storeKey, true));


        if($hashParamsVal != $this->getRequestParameter('HASHPARAMSVAL') || $hash != $this->getRequestParameter('HASH') || $secureCount != 3 || $this->getRequestParameter('TranType') != 'Auth') {
            
            file_put_contents(sfConfig::get('sf_root_dir').'/log/eservice.txt', "[".date('d-m-Y H:i:s')."]\nHASHC: ".$hash."\nHASHO: ".$this->getRequestParameter('HASH')."\n"."\nPARAM1: ".$hashParamsVal."\nPARAM2: ".$this->getRequestParameter('HASHPARAMSVAL')."\n\nPOST:\n".var_export($_POST, true), FILE_APPEND);
            
            return false;
        }        

        return true;
    }
}


