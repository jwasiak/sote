<?php

class stTrustedShopsConnector {

    protected $backendUrls = array( 'production' => 'https://www.trustedshops.de/ts/services/TsProtection?wsdl', 
                                    'sandbox' => 'https://qa.trustedshops.de/ts/services/TsProtection?wsdl');

    protected $frontendUrls = array('production' => 'https://protection.trustedshops.com/ts/protectionservices/ApplicationRequestService?wsdl', 
                                    'sandbox' => 'https://protection-qa.trustedshops.com/ts/protectionservices/ApplicationRequestService?wsdl');

    protected $ratingUrls = array(  'production' => 'https://www.trustedshops.com/ts/services/TsRating?wsdl',
                                    'sandbox' => 'https://qa.trustedshops.com/ts/services/TsRating?wsdl');

    protected $enviroment = 'production';

    public function __construct() { 
        $config = stConfig::getInstance('stTrustedShopsBackend');
        if ($config->get('test')) $this->enviroment = 'sandbox';
    }

    public function getSoapClient($url = 'backend') { 
        return new SoapClient($this->{$url.'Urls'}[$this->enviroment], array('cache_wsdl' => 0, 'trace' => 1));
    }

    public static function updateRating($certificate, $status) {
        try {
            $connector = new self;
            $result = $connector->getSoapClient('rating')->updateRatingWidgetState($certificate, $status, 'SOTEwsUser', 'r5JQjcw5', 'SOTESHOP');
        } catch (Exception $e) {
            $result = false;
        }

        return $result;
    }

    public static function checkCertificate($certificate) {
        try {
            $connector = new self;
            $result = $connector->getSoapClient()->checkCertificate($certificate);
        } catch (Exception $e) {
            $result = false;
        }

        return $result;
    }

    public static function checkLogin($certificate, $login, $password) {
        try {
            $connector = new self;
            $result = $connector->getSoapClient()->checkLogin($certificate, $login, $password);
        } catch (Exception $e) {
            $result = false;
        }

        return $result;
    }

    public static function getProtectionItems($certificate) {
        try {
            $connector = new self;
            $result = $connector->getSoapClient()->getProtectionItems($certificate);
        } catch (Exception $e) {
            $result = false;
        }

        return $result;
    }

    public static function requestForProtectionV2($certificace, $tsProductId, $amount, $currency, $paymentType, $buyerEmail, $shopCustomerId, $shopOrderId, $orderDate, $shopSystemVersion, $wsUser, $wsPassword) {
        try {
            $connector = new self;
            $result = $connector->getSoapClient('frontend')->requestForProtectionV2($certificace, $tsProductId, $amount, $currency, $paymentType, $buyerEmail, $shopCustomerId, $shopOrderId, $orderDate, $shopSystemVersion, $wsUser, $wsPassword);
        } catch (Exception $e) {
            $result = false;
        }

        return $result;
    }

    public static function getCheckLoginError($errorCode) {
        $messages = array('-10001' => 'Nazwa użytkownika lub hasło są nieprawidłowe. Skontaktuj się z Trusted Shops pod adresem service@trustedshops.pl',
                          '-10002' => 'Ramy kredytowe w Trusted Shops zostały unieważnione. Skontaktuj się z Trusted Shops pod adresem service@trustedshops.pl',
                          '-10011' => 'Brak ram kredytowych w Trusted Shops. Skontaktuj się z Trusted Shops pod adresem service@trustedshops.pl',
                          '-11111' => 'Dane nie mogły zostać zapisane. Skontaktuj się z Trusted Shops pod adresem service@trustedshops.pl');

        return $messages[$errorCode];
    }
}