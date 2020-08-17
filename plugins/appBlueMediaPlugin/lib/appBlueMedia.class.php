<?php

class appBlueMedia implements stPaymentInterface
{
    protected $gatewayList = null;

    protected static $instance = null;

    protected static $payments = null;

    protected static $blueMediaPayment = null;

    protected $lastResponse = null;

    protected $config;

    const BLIK_GATEWAY = 509;

    /**
     * Returns object instance
     *
     * @return static
     */
    public static function getInstance()
    {
        if (null === self::$instance)
        {
            self::$instance = new static();
        }

        return self::$instance;
    }

    public static function getPostSecureHash()
    {
        return stSecureToken::generate(array('123456789'));
    }

    public static function getHost()
    {
        $request = sfContext::getInstance()->getRequest();
        $tmp = $request->isSecure();

        $host = $request->getUriPrefix();
        $request->setIsSecure($tmp);  
        
        return $host;
    }

    public static function getSecureItnUrl()
    {
        return self::getHost() . '/bm/itn/' . self::getPostSecureHash();
    }

    public static function getSecureReturnUrl()
    {
        return self::getHost() . '/bm/return';
    }

    public static function getPayments($activeOnly = true)
    {
        if (null === self::$payments)
        {
            $payments = array();

            foreach (PaymentTypePeer::doSelectByModuleName('appBlueMedia') as $paymentType)
            {
                if (!$activeOnly || $paymentType->getActive())
                {
                    $payments[$paymentType->getConfigurationParameter('gateway_id')] = $paymentType;
                }

                if (!$paymentType->getConfigurationParameter('gateway_id'))
                {
                    self::$blueMediaPayment = $paymentType;
                }
            }

            self::$payments = $payments;
        }

        return self::$payments;
    }

    public static function getBlueMediaPayment()
    {
        self::getPayments();

        return self::$blueMediaPayment;
    }

    public function __construct() 
    {
        $this->config = stConfig::getInstance('appBlueMedia');
    }

    public function isBlik(Order $order)
    {
        $payment = $order->getOrderPayment();

        if ($payment)
        {
            $paymentType = $payment->getPaymentType();     

            return $paymentType && $paymentType->getConfigurationParameter('gateway_id') == self::BLIK_GATEWAY || $payment->getConfigurationParameter('gateway_id') == self::BLIK_GATEWAY;
        }

        return false;     
    }

    public function getServiceId()
    {
        return $this->config->get('id');
    }

    public function getGatewayList($refresh = false)
    {
        if (null === $this->gatewayList) 
        {
            $fc = stFunctionCache::getInstance('appBlueMediaPlugin');

            if ($refresh)
            {
                $fc->removeAll();
            }

            $fc->setLifeTime(86400);
            $this->gatewayList = $fc->cacheCall(array($this, 'getPaywayList'), array(), array('id' => 'paywaylist'));
            $fc->setLifeTime(time());
        }

        return $this->gatewayList;
    }

    public function getGatewayInfo($gatewayId)
    {   
        $gateways = $this->getGatewayList();

        return isset($gateways[$gatewayId]) ? $gateways[$gatewayId] : null;
    }

    public function getPaywayList()
    {
        $params = array(
            'ServiceID' => $this->config->get('id'),
            'MessageID' => $this->randomString(32),
        );

        $results = $this->gatewayCall('/paywayList', $params);

        $paywayList = array();            

        foreach ($results['gateway'] as $gateway)
        {   
            $paywayList[$gateway['gatewayID']] = array(
                'id' => $gateway['gatewayID'],
                'name' => $gateway['gatewayName'], 
                'type' => $gateway['gatewayType'],
                'bank' => $gateway['bankName'],
                'icon' => $gateway['iconURL'],
            );
        }   
        
        return $paywayList;
    }

    public function createPayment(Order $order, array $params = array())
    {
        $sf_context = sfContext::getInstance();
        $controller = $sf_context->getController();
        $i18n = $sf_context->getI18N();

        $payment = $order->getOrderPayment();

        if (!$payment)
        {
            stPayment::log('bluemedia', '[appBlueMedia::createPayment] ', "Missing instance of Payment");
            throw new appBlueMediaException("Missing instance of Payment");
        }

        $paymentType = $payment->getPaymentType();

        if (!$paymentType) 
        {
            stPayment::log('bluemedia', '[appBlueMedia::createPayment] ', "Missing instance of PaymentType");
            throw new appBlueMediaException("Missing instance of PaymentType");
        }

        $gateway_id = !$this->config->get('gateways_popup') ? $paymentType->getConfigurationParameter('gateway_id') : $payment->getConfigurationParameter('gateway_id');

        mb_internal_encoding('UTF-8');

        mb_regex_encoding("UTF-8");

        $params = array_merge(array(
            'ServiceID' => $this->getServiceId(),
            'OrderID' => $order->getId(), 
            'Amount' => $order->getUnpaidAmount(),
            'Description' => $sf_context->getRequest()->getUriPrefix() . '/ - ' . stTextAnalyzer::unaccent($i18n->__("Zamówienie nr", null, 'stOrder').' '.$order->getNumber()),
            'GatewayID' => $gateway_id,
            'Currency' => $order->getOrderCurrency()->getShortcut(),
            'CustomerEmail' => $order->getOptClientEmail(), 
            'CustomerIP' => $order->getRemoteAddress(),            
        ), $params);

        $response = $this->gatewayCall('/payment', $params, array('BmHeader: pay-bm-continue-transaction-url'));

        $this->lastResponse = $response;

        return $response;
    }

    public function getLastResponse()
    {
        return $this->lastResponse;
    }

    public function getGatewayUrl()
    {
        return $this->config->get('sandbox') ? 'https://pay-accept.bm.pl' : 'https://pay.bm.pl';
    }

    final public function appendHash(array &$data)
    {
        $data['Hash'] = $this->createHash($data);
        
        return $data;
    }

    final public function createHash(array $data)
    {
        $result = '';

        foreach ($data as $name => $value) {
            if (mb_strtolower($name) == 'hash' || empty($value)) {
                continue;
            }
            $result .= $value.'|';
        }

        return hash('sha256', $result.$this->config->get('key'));        
    }

    final public function verifyHash($hash, array $data)
    {
        return $hash == $this->createHash($data);
    }

    final public function randomString($length)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randstring = '';
        for ($i = 0; $i < $length; $i++) {
            $randstring .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randstring;
    }

    final public function readNotifyRequest($transactionXml)
    {
        $data = array();
        $xmlReader = new XMLReader();
        $xmlReader->XML($transactionXml, 'UTF-8', (LIBXML_NOERROR | LIBXML_NOWARNING));
        while ($xmlReader->read()) {
            switch ($xmlReader->nodeType) {
                case XMLREADER::ELEMENT:
                    $nodeName = ucfirst($xmlReader->name);
                    $xmlReader->read();
                    $nodeValue = trim($xmlReader->value);
                    if (!empty($nodeName) && !empty($nodeValue)) {
                        $data[$nodeName] = $nodeValue;
                    }
                    break;
            }
        }
        $xmlReader->close();
        return $data;
    }

    final public function returnNotifyStatus(array $data)
    {
        $this->appendHash($data);

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->startDocument('1.0', 'UTF-8');
        $xml->startElement('confirmationList');
        $xml->writeElement('serviceID', $data['ServiceID']);
        $xml->startElement('transactionsConfirmations');
        $xml->startElement('transactionConfirmed');
        $xml->writeElement('orderID', $data['OrderID']);
        $xml->writeElement('confirmation', $data['Status']);
        $xml->endElement();
        $xml->endElement();
        $xml->writeElement('hash', $data['Hash']);
        $xml->endElement();
        
        return $xml->outputMemory();
    }

    final public function parseXml($xml)
    {
        $data = $xml instanceof SimpleXMLElement ? $xml : simplexml_load_string($xml);
    
        return $data ? json_decode(json_encode($data), true) : null;
    }

    public function gatewayCall($url, array $params, array $headers = null)
    {
        $url = $this->getGatewayUrl() . $url;

        $curl = curl_init($url);

        if ($headers) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        }

        $this->appendHash($params);

        stPayment::log("bluemedia", 'callGateway: '.var_export($params, true));

        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params, '', '&'));
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        $result = curl_exec($curl);
        
        if ($result && $result != 'ERROR') {
            $result = simplexml_load_string($result);

            if ($result->getName() == 'error') {
                stPayment::log('bluemedia', '[' . $url . '] '.$result->description, FILE_APPEND);
                throw new appBlueMediaException($result->description, $result->statusCode);
            }
        } else {
            stPayment::log('bluemedia', '[' . $url . ']\nPARAMS:\n'.var_export($params, true)."\nRESPONSE:\n".$result, FILE_APPEND);
            throw new Exception("<pre>GATEWAY: '".$url."'\nPOST:\n".var_export($params, true)."\nRESPONSE:\n".$result."</pre>");
        }

        curl_close($curl);

        return $this->parseXml($result);
    }

    public function getLogoPath()
    {
        return '/plugins/appBlueMediaPlugin/images/logo.png';
    }

    public function isAutoRedirectEnabled()
    {
        return $this->config->get('autoredirect');
    }

    public function checkPaymentConfiguration()
    {
        $ok = $this->config->get('configuration_check', false);

        if (SF_APP == 'frontend')
        {
            $currencies = array('PLN');

            $ok = $ok && in_array(stCurrency::getInstance(sfContext::getInstance())->get()->getShortcut(), $currencies);

            $ok = $ok && stTheme::getInstance(sfContext::getInstance())->getVersion() >= 7;
        }

        return $ok;
    }
}