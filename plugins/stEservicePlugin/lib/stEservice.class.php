<?php

class stEservice {

    const POST_URL_PROD = 'https://pay.eservice.com.pl/fim/eservicegate';

    const POST_URL_TEST = 'https://testvpos.eservice.com.pl/fim/eservicegate';

    const TOKEN_URL_PROD = 'https://pay.eservice.com.pl/pg/token';

    const TOKEN_URL_TEST = 'https://testvpos.eservice.com.pl/pg/token';

    const PAYMENT_PENDING = 'Pending';

    const PAYMENT_APPROVED = 'Approved';

    const PAYMENT_DECLINED = 'Declined';

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
        return $this->hasEnabled() && $this->hasClientId() && $this->hasPassword() && $this->hasStoreKey();
    }

    public function getPostUrl() {
        return $this->getTest() ? self::POST_URL_TEST : self::POST_URL_PROD;
    }

    public function getTokenUrl() {
        return $this->getTest() ? self::TOKEN_URL_TEST : self::TOKEN_URL_PROD;
    }

    public function getStoreType() {
    	return '3d_pay_hosting';  
    }
}
