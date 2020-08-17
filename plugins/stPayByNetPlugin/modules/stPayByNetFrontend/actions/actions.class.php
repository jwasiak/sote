<?php
class stPayByNetFrontendActions extends stActions {

    public function executeReturnSuccess() {
        $this->smarty = new stSmarty($this->getModuleName());
    }

    public function executeReturnFail() {
        $this->smarty = new stSmarty($this->getModuleName());
        $this->contactPage = WebpagePeer::retrieveByState('CONTACT');
    }

    public function executeStatusReport() {
        $this->smarty = new stSmarty($this->getModuleName());

        $this->setLayout(false);

        $stPayByNet = new stPayByNet();

        $requestNewStatus = $this->getRequestParameter('newStatus');
        $requestTransAmount = $this->getRequestParameter('transAmount');
        $requestPaymentId = $this->getRequestParameter('paymentId');
        $requestHash = $this->getRequestParameter('hash');

        $shopHash = sha1($requestNewStatus.$requestTransAmount.$requestPaymentId.$stPayByNet->getPassword()); 
        
        if ($requestHash == $shopHash) {
            
            $order = OrderPeer::retrieveByPK($requestPaymentId);

            if ($order)
            {
                $payment = $order->getOrderPayment();

                if ($payment)
                {
                    if (in_array($requestNewStatus, array('2203', '2303'))) {
                        $payment->setStatus(true);
                        $payment->save();
                    }
                    
                    if (in_array($requestNewStatus, array('1000', '2202', '2302'))) {
                        $stPayment->cancelPayment($payment->getHash());
                    }
                }
                else
                {
                   file_put_contents(sfConfig::get('sf_root_dir').'/log/paybynet.txt', '['.date('d-m-Y H:i:s')."] payment for order \"$requestPaymentId\" doest not exits\n", FILE_APPEND); 
                   file_put_contents(sfConfig::get('sf_root_dir').'/log/paybynet.txt', '['.date('d-m-Y H:i:s').'] '.var_export($_REQUEST, true)."\n", FILE_APPEND);
                }
            } 
            else 
            {
               file_put_contents(sfConfig::get('sf_root_dir').'/log/paybynet.txt', '['.date('d-m-Y H:i:s')."] order with id \"$requestPaymentId\" doest not exits\n", FILE_APPEND); 
               file_put_contents(sfConfig::get('sf_root_dir').'/log/paybynet.txt', '['.date('d-m-Y H:i:s').'] '.var_export($_REQUEST, true)."\n", FILE_APPEND);
            }
        } else {
            file_put_contents(sfConfig::get('sf_root_dir').'/log/paybynet.txt', '['.date('d-m-Y H:i:s')."] hashtrans validation failed ($requestHash != $shopHash)\n", FILE_APPEND);
            file_put_contents(sfConfig::get('sf_root_dir').'/log/paybynet.txt', '['.date('d-m-Y H:i:s').'] '.var_export($_REQUEST, true)."\n", FILE_APPEND);
        }

        return $this->renderText("OK");
    }
}
