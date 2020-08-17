<?php

class stInBank
{
    const SANDBOX_ENV = 'https://demo-api.inbank.pl/partner/v2';
    const PROD_ENV = 'https://api.inbank.pl/partner/v2';

    public function __construct()
    {
        $this->config = stConfig::getInstance('stInBank');
    }

    public function createPayment(Order $order)
    {
        $sf_context = sfContext::getInstance();
        $controller = $sf_context->getController();
        $i18n = $sf_context->getI18N();

        sfLoader::loadHelpers(array('Helper', 'stUrl'));

        $body = array(
            'product_code' => $this->config->get('product_code'),
            'total_amount' => $order->getUnpaidAmount(),
            'currency' => $order->getOrderCurrency()->getShortcut(),
            'locale' => $order->getOrderLanguage() ? $order->getOrderLanguage()->getLanguage() : self::getLocaleFromCulture($sf_context->getUser()->getCulture()),
            // 'customer_data' => array('first_name' => trim($order->getOrderUserDataBilling()->getName()), 'last_name' => trim($order->getOrderUserDataBilling()->getSurname())),
            // 'customer_contact_data' => array('email' => $order->getOptClientEmail(), 'mobile' => trim($order->getOrderUserDataBilling()->getPhone())),
            // 'customer_address_data' => array(
            //     'street' => trim($order->getOrderUserDataBilling()->getStreet()),
            //     'house' => trim($order->getOrderUserDataBilling()->getHouse()),
            //     'zip_code' => trim($order->getOrderUserDataBilling()->getCode()),
            //     'city' => trim($order->getOrderUserDataBilling()->getTown()),
            // ),
            'partner_urls' => array(
                'return_url' => $controller->genUrl('@stInBankFrontend?action=return&id='.$order->getId().'&hash='.$order->getHashCode(), true),  
                'cancel_url' => $controller->genUrl('@stInBankFrontend?action=cancel&id='.$order->getId().'&hash='.$order->getHashCode(), true),  
                'callback_url' => $controller->genUrl('@stInBankFrontend?action=callback&id='.$order->getId().'&hash='.$order->getHashCode(), true),            
            ),
            'purchase' => array(
                'purchase_reference' => $order->getNumber(),
                'description' => $i18n->__("Zamówienie nr", null, 'stOrder').' '.$order->getNumber(),
            )
        );

        if ($order->getOrderUserDataBilling()->getFlat())
        {
            $body['customer_address_data']['apartment'] = $order->getOrderUserDataBilling()->getFlat();
        }

        $response = self::apiCall('/shops/' . $this->config->get('uuid') . '/pos_sessions', $this->config->get('api_key'), $body, $this->config->get('sandbox') ? self::SANDBOX_ENV : self::PROD_ENV);

        if ($response && isset($response->redirect_url) && $response->redirect_url) 
        {
            self::log('Init payment for order ' . $order->getNumber() . ': '. var_export($response, true));

            return $response->redirect_url;
        }
        else
        {
            self::log('Init payment for order ' . $order->getNumber() . ': '. var_export($response, true));
        }
    }


    public static function validateCredentials($productCode, $uuid, $apiKey, $sandbox)
    {
        $sf_context = sfContext::getInstance();
        $controller = $sf_context->getController();
        $i18n = $sf_context->getI18N();

        $body = array(
            'product_code' => $productCode,
            'total_amount' => 1000,
            'currency' => 'PLN',
            'locale' => 'pl-PL',
            'partner_urls' => array(
                'return_url' => $controller->genUrl('@stInBankBackend?action=returnSuccess', true),
                'cancel_url' => $controller->genUrl('@stInBankBackend?action=returnCancel', true),
                'callback_url' => $controller->genUrl('@stInBankBackend?action=statusReport', true),            
            ),
            'purchase' => array(
                'purchase_reference' => 'TEST ORDER NUMBER',
                'description' => 'TEST ORDER DESCRIPTION',
            )
        );

        try 
        {
            $response = self::apiCall('/shops/' . $uuid . '/pos_sessions', $apiKey, $body, $sandbox ? self::SANDBOX_ENV : self::PROD_ENV);
        } 
        catch (Exception $e)
        {
            self::log('inbank', 'Credentials validation: ' . $e->getMessage());

            if (sfConfig::get('sf_debug'))
            {
                throw $e;
            }

            return false;
        }

        self::log('inbank', 'Credentials validation: ' . var_export($response, true));

        if (sfConfig::get('sf_debug'))
        {
            sfLogger::getInstance()->info('{stInBank} Credentials validation');
        }

        return $response && isset($response->redirect_url) && $response->redirect_url;
    }


    public static function apiCall($url, $apiKey, array $body, $env = null)
    {
        $jsonBody = json_encode($body, JSON_UNESCAPED_UNICODE);

        self::log("apiCall($url, $apiKey, $jsonBody, $env)");

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, null === $env ? self::PROD_ENV . $url : $env . $url);

        curl_setopt($ch, CURLOPT_VERBOSE, true);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);   
        
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , 'Authorization: Bearer '. $apiKey));

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_POST, 1);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonBody);

        $response = curl_exec($ch);

        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch))
        {
            throw new Exception(curl_error($ch), curl_errno($ch));
        }

        if ($httpcode == 400) 
        {
            throw new Exception(htmlspecialchars($response), $httpcode);
        }

        curl_close($ch);

        return json_decode($response);
    }

    public static function getLocaleFromCulture($culture)
    {
        if ($culture == 'pl_PL') 
        {
            return 'pl-PL';
        }

        if ($culture == 'en_US') 
        {
            return 'en-US';
        }

        return $culture;
    }

    public static function log($message)
    {
        stPayment::log('inbank', $message);
    }

    public static function hasPaymentType()
    {        
        $results = PaymentTypePeer::doSelectByModuleName('stInBank');
        return !empty($results);
    }

    public function verifyPostCallback($hmac, $timestamp, $message)
    {
        $calculated = hash_hmac("sha512", $timestamp.'.'.$message, $this->config->get('api_key'));

        return $hmac == $calculated;
    }

    public function checkPaymentConfiguration()
    {
        $ok = $this->config->get('configuration_check', false);

        if (SF_APP == 'frontend')
        {
            $currency = stCurrency::getInstance(sfContext::getInstance())->get()->getShortcut();

            $ok = $ok && in_array($currency, array('PLN'));
        }

        return $ok;
    }
}