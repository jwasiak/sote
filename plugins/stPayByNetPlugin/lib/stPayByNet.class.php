<?php

define('PAYBYNET_URL', 'https://pbn.paybynet.com.pl/PayByNet/trans.do');
define('PAYBYNET_URL_SANDBOX', 'https://pbn.paybynet.com.pl/PayByNetT/trans.do');
define('PAYBYNET_BANK_LIST_URL', 'https://pbn.paybynet.com.pl/PayByNet/update/os/banks.xml');
define('PAYBYNET_BANK_LIST_URL_SANDBOX', 'https://pbn.paybynet.com.pl/PayByNetT/update/os/banks.xml');

class stPayByNet {
    
    private $config = array();

    public function __construct() {
        $this->config = stPaymentType::getConfiguration(__CLASS__);
    }

    public function __call($method, $arguments) {
        return stPaymentType::call($method, $this->config);
    }

    public function getOrderAmount($orderAmountBrutto) {
        return number_format($orderAmountBrutto, 2, ',', '');
    }

    public function parseOrderId($id) {
        while(strlen($id) < 10) {
            $id = '0'.$id;
        }
        return $id;
    }

    public function getPayByNetUrl() {
        if ($this->config['test']) return PAYBYNET_URL_SANDBOX;
        return PAYBYNET_URL;
    }

    public function getPayByNetBankListUrl() {
        if ($this->config['test']) return PAYBYNET_BANK_LIST_URL_SANDBOX;
        return PAYBYNET_BANK_LIST_URL;
    }

    public function getAccname() {

        $country = CountriesPeer::retrieveByPK($this->config['account_country']);

        return $this->config['account_name'].'^NM^'
               .$this->config['account_code'].'^ZP^'
               .$this->config['account_city'].'^CI^'
               .$this->config['account_street'].'^ST^'
               .$country->getName().'^CT^';
    }

    public function checkPaymentConfiguration() {
        if (!$this->hasIdClient()) return false;
        if (!$this->hasPassword()) return false;
		if (SF_APP == 'frontend' && stCurrency::getInstance(sfContext::getInstance())->get()->getShortcut() != 'PLN') return false;
        return true;
    }
}
