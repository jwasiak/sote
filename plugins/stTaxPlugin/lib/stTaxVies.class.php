<?php

class stTaxVies
{
    protected $client;

    protected $soapFault = null;

    protected $logger = null;

    protected static $instance = null;

    public static function hasValidCountryCode($client_vat_number, $merchant_vat_number)
    {
        $client = self::parseVatNumber($client_vat_number);

        $merchant = self::parseVatNumber($merchant_vat_number);

        return $client[0] != $merchant[0];
    }

    public static function parseVatNumber($vat_number)
    {
        $vat_number = str_replace(array(' ', '.', '-', ',', ', '), '', trim($vat_number));

        $cc = substr($vat_number, 0, 2);
        
        $vn = substr($vat_number, 2);

        return array(strtoupper($cc), $vn);        
    }

    public static function checkVatUrl($vat_number)
    {
        list($cc, $vn) = self::parseVatNumber($vat_number);

        return 'http://ec.europa.eu/taxation_customs/vies/vatResponse.html?action=check&check=Verify&memberStateCode='.$cc.'&number='.$vn;        
    }

    public static function getInstance()
    {
        if (null === self::$instance)
        {
            self::$instance = new stTaxVies();

            self::$instance->initialize();
        }

        return self::$instance;
    }

    public function getSoapFault()
    {
        return $this->soapFault;
    }

    public function checkVat($vat_number)
    {
        $info = $this->getVatInfo($vat_number);

        return $info !== false && $info->isValid();
    }

    public function getVatInfo($vat_number)
    {
        if (!$this->client)
        {
            return false;
        }

        list($cc, $vn) = self::parseVatNumber($vat_number);

        try
        {
            $result = $this->client->checkVat(array('countryCode' => $cc, 'vatNumber' => $vn));

            $response = new stTaxViesResponse($result);
        }
        catch(SoapFault $e)
        {
            return $this->handleException($e);
        }

        if ($this->logger)
        {
            $this->logMessage($response);
        }

        return $response;        
    }

    protected function handleException(SoapFault $e)
    {       
        if ($this->logger)
        {
            $this->logMessage($e->getMessage(), SF_LOG_ERR);
        }

        $this->soapFault = $e;

        return false;       
    }   

    protected function initialize()
    {
        if (sfConfig::get('sf_debug') && sfConfig::get('sf_logging_enabled'))
        {
            $this->logger = sfLogger::getInstance();
        }

        try
        {
            $this->client = new SoapClient(dirname(__FILE__).'/../data/checkVatService.wsdl');
        }
        catch(SoapFault $e)
        {
            $this->handleException($e);
        }

        return $this;
    }    

    protected function logMessage($message, $level = SF_LOG_INFO)
    {
        $this->logger->log('{stTaxVies} ' . $message, $level);
    }
}

class stTaxViesResponse 
{
    protected $result;

    public function __toString()
    {
        return json_encode($this->result);
    }

    public function __construct(stdClass $result)
    {
        $this->result = $result;
    }

    public function getCountryCode()
    {
        return $this->result->countryCode;
    }

    public function getVatNumber()
    {
        return $this->result->vatNumber;
    }

    public function isValid()
    {
        return $this->result->valid;
    }

    public function getName()
    {
        return $this->result->name;
    }

    public function getAddress()
    {
        return $this->result->address;
    }
}