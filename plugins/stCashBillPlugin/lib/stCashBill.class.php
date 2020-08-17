<?php

class stCashBill {

    const SOAP_URI_PROD = 'https://pay.cashbill.pl/ws/soap/PaymentService?wsdl';

    const SOAP_URI_TEST = 'https://pay.cashbill.pl/testws/soap/PaymentService?wsdl';

    public function __construct() {
        $this->config = stPaymentType::getConfiguration(__CLASS__);
    }

    public function __call($method, $arguments) {
        return stPaymentType::call($method, $this->config);
    }

    public function parseAmount($amount) {
        return number_format($amount, 2, '.', '');
    }

    public function checkPaymentConfiguration() {
        if (!$this->hasShopId()) return false;
        if (!$this->hasSecretKey()) return false;
        if (SF_APP == 'frontend' && stCurrency::getInstance(sfContext::getInstance())->get()->getShortcut() != 'PLN') return false;
        return true;
    }

    public function getSoapUri() {
        return $this->getTest() ? self::SOAP_URI_TEST : self::SOAP_URI_PROD;
    }

    public function getPaymentChannels() {
        try {
            $client = new stCashBillSoapClient($this->getSoapUri());
            $response = $client->availablePaymentChannels(array('languageCode' => stPaymentType::getLanguage(array('PL', 'EN'))));
            return is_object($response->return) ? array($response->return) : $response->return;
        } catch (SoapFault $e) { }
        return array();
    }
}
