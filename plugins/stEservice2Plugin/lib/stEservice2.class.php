<?php

require __DIR__ . '/../vendor/eservice-sdk/payments.php';

use Eservice\Config as EserviceConfig;
use Eservice\Payments as EservicePayments;
use Eservice\ResponseInfo as EserviceResponseInfo;

class stEservice2 implements stPaymentInterface
{
    const API_TEST_TOKEN_URL = 'https://apiuat.test.secure.eservice.com.pl/token';
    const API_TEST_ACTION_URL = 'https://apiuat.test.secure.eservice.com.pl/payments';
    const API_TEST_JS_URL = 'https://cashierui-apiuat.test.secure.eservice.com.pl/js/api.js';
    const API_TEST_CASHIER_URL = 'https://cashierui-apiuat.test.secure.eservice.com.pl';
    const API_TOKEN_URL = 'https://api.secure.eservice.com.pl/token';
    const API_ACTION_URL = 'https://api.secure.eservice.com.pl/payments';
    const API_JS_URL = 'https://cashierui-api.secure.eservice.com.pl/js/api.js';
    const API_CASHIER_URL = 'https://cashierui-api.secure.eservice.com.pl';

    /**
     * Konfiguracja płatności
     *
     * @var stConfig
     */
    protected $config;

    /**
     * API
     *
     * @var @EservicePayments
     */
    protected $api;

    public function __construct()
    {
        $this->config = stConfig::getInstance('stEservice2Backend');

        EserviceConfig::$MerchantId = $this->config->get('client_id');
        EserviceConfig::$Password = $this->config->get('password');
        $this->api = new EservicePayments();

        if ($this->isSandbox())
        {
            EserviceConfig::buildEvoEnv4Test(self::API_TEST_CASHIER_URL, self::API_TEST_JS_URL, self::API_TEST_TOKEN_URL, self::API_TEST_ACTION_URL);
        }
        else
        {
            EserviceConfig::buildEvoEnv4Prod(self::API_CASHIER_URL, self::API_JS_URL, self::API_TOKEN_URL, self::API_ACTION_URL);
        }
    }

    public function isAutoRedirectEnabled()
    {
        return $this->config->get('autoredirect');
    }

    public function getLogoPath()
    {
        return '/plugins/stEservice2Plugin/images/logo.png';
    }

    public function parseAmount($amount)
    {
        return number_format($amount, 2, '.', '');
    }

    /**
     * Pobiera token dla płatności
     *
     * @param Order $order
     * @return EserviceResponseInfo
     */
    public function getToken(Order $order)
    {
        /**
         * @var \Eservice\RequestPurchase $purchase
         */
        $purchase = $this->api->purchase();
        $purchase->allowOriginUrl(sfContext::getInstance()->getRequest()->getHost());
        $purchase->channel(EservicePayments::CHANNEL_ECOM);
        $purchase->amount($order->getUnpaidAmount());
        $purchase->currency($order->getOrderCurrency()->getShortcut());
        $purchase->country($order->getOrderUserDataBilling()->getCountry()->getIsoA2());
        $culture = $order->getClientCulture();

        if ($culture == 'pl_PL')
        {
            $culture = 'pl';
        }
        elseif ($culture == 'en_US')
        {
            $culture = 'en';
        }

        $purchase->language(strtolower($culture));

        if ($this->config->get('brand_id'))
        {
            $purchase->brandId($this->config->get('brand_id'));
        }
        $purchase->paymentSolutionId('');
        $purchase->merchantNotificationUrl(sfContext::getInstance()->getController()->genUrl('@stEservice2Notify?order_id='.$order->getId().'&hash='.$order->getHashCode().'&payment_id='.$order->getOrderPayment()->getId(), true));  
        $purchase->merchantLandingPageUrl(sfContext::getInstance()->getController()->genUrl('@stEservice2Return?order_id='.$order->getId().'&hash='.$order->getHashCode(), true));
        $purchase->customerFirstName($order->getOrderUserDataBilling()->getName());
        $purchase->customerLastName($order->getOrderUserDataBilling()->getSurname());
        $purchase->customerBillingAddressPostalCode($order->getOrderUserDataBilling()->getCode());
        $purchase->customerBillingAddressCity($order->getOrderUserDataBilling()->getTown());
        $purchase->customerBillingAddressCountry($order->getOrderUserDataBilling()->getCountry()->getIsoA2());
        $purchase->customerBillingAddressStreet($order->getOrderUserDataBilling()->getAddress());

        $serialized = $purchase->serialize();

        try
        {
            stPayment::log('eservice', 'Requesting token');

            /**
             * @var EserviceResponseInfo $response
             */
            $response = $purchase->token();

            stPayment::log('eservice', 'With Params: '.self::format($purchase));

            if ($response->result == 'failure')
            {
                stPayment::log('eservice', 'Failure: ' . self::format($response));

                return null;
            }
            else
            {
                stPayment::log('eservice', 'Success: ' . self::format($response));
            }
        }
        catch(Exception $e)
        {
            stPayment::log('eservice', 'Exception: '.$e->getMessage());

            return null;
        }
        

        return $response;
    }

    /**
     * Pobiera status płatności po merchantTxId
     *
     * @param string $merchantTxId
     * @return EserviceResponseInfo
     */
    public function checkStatusByMerchantTxId($merchantTxId)
    {
        $status_check = $this->api->status_check();
        $status_check
            ->merchantTxId($merchantTxId)
            ->action('GET_STATUS')
            ->allowOriginUrl(self::getAllowOriginUrl());

        return $status_check->execute();
    }

    /**
     * Pobiera status płatności po txId
     *
     * @param string $txId
     * @return EserviceResponseInfo
     */
    public function checkStatusByTxId($txId)
    {
        $status_check = $this->api->status_check();
        $status_check->txId($txId);
        $status_check
            ->action('GET_STATUS')
            ->allowOriginUrl(self::getAllowOriginUrl());

        return $status_check->execute();
    }

    /**
     * Weryfikuje konfiguracje płatności eservice
     *
     * @return bool
     */
    public function validatePaymentConfiguration()
    {
        /**
         * @var \Eservice\RequestPurchase $purchase
         */
        $purchase = $this->api->purchase();
        $purchase->allowOriginUrl(sfContext::getInstance()->getRequest()->getHost());
        $purchase->channel(EservicePayments::CHANNEL_ECOM);
        $purchase->amount(1000);
        $purchase->currency('PLN');
        $purchase->country('PL');
        $purchase->paymentSolutionId('');

        if ($this->config->get('brand_id'))
        {
            $purchase->brandId($this->config->get('brand_id'));
        }

        $purchase->merchantNotificationUrl(sfContext::getInstance()->getController()->genUrl('@stEservice2Plugin', true));
        /**
         * @var EserviceResponseInfo 
         */
        $response = $purchase->token();

        return $response->result == 'success';
    }


    public function checkPaymentConfiguration()
    {
        return $this->config->get('client_id') && $this->config->get('password') && $this->config->get('enabled');
    }

    public function isSandbox()
    {
        return $this->config->get('test');
    }

    public function getPaymentUrl()
    {
        return $this->isSandbox() ? self::API_TEST_CASHIER_URL : self::API_CASHIER_URL;
    }

    public static function format($object)
    {
        return json_encode($object->__debugInfo(), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }

    public static function getAllowOriginUrl()
    {
        return sfContext::getInstance()->getRequest()->getHost();
    }
}