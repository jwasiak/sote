<?php

class stPocztaPolskaPackage
{
    protected $order = null;

    protected $service = null;

    protected $amount = null;

    protected $bufor = null;

    protected $serviceName = null;

    protected $deliveryPoint = null;

    protected static $instance = array();

    public static function getInstance(Order $order, $serviceName = null)
    {
        if (!isset(self::$instance[$order->getId()]))
        {
            $instance = new static($order, $serviceName);
            $instance->initialize();
            self::$instance[$order->getId()] = $instance;
        }

        return self::$instance[$order->getId()];
    }

    public function __construct(Order $order, $serviceName)
    {
        $this->order = $order;
        $this->serviceName = $serviceName;
    }

    public function initialize()
    {
        $orderPayment = $this->order->getOrderPayment();

        if (null === $orderPayment)
        {
            throw new Exception("Order payment with does not exist");
        }   

        $pobranie = PocztaPolskaPunktOdbioruPeer::isPobranie($orderPayment->getPaymentType());

        $delivery = $this->order->getOrderDelivery()->getDelivery();

        if (null === $this->serviceName)
        {
            $this->serviceName = $delivery->getParam('usluga');
        }

        $service = stPocztaPolskaClient::createService($this->serviceName);

        $i18n = sfContext::getInstance()->getI18N();

        $config = stConfig::getInstance('stPocztaPolskaBackend');

        $service->masa = $this->order->getTotalWeight() * 1000;

        if (property_exists($service, 'opis'))
        {
            $service->opis = $i18n->__("Zamówienie numer %number%", array('%number%' => $this->order->getNumber()));
        }

        if (property_exists($service, 'pobranie'))
        {
            $service->pobranie = new pobranieType();

            if ($pobranie)
            {
                $service->pobranie->sposobPobrania = "RACHUNEK_BANKOWY";
                $service->pobranie->kwotaPobrania = $this->order->getUnpaidAmount() * 100;
                $service->pobranie->tytulem = $i18n->__("Zamówienie numer %number%", array('%number%' => $this->order->getNumber()));
            }
        }

        if ($this->serviceName == 'przesylka_biznesowa') 
        {
            $service->gabaryt = $config->get('przesylka_biznesowa_gabaryt', 'M');
        }

        if ($delivery->isType('ppo'))
        {
            $user = $this->order->getOrderUserDataBilling();
            $this->deliveryPoint = PocztaPolskaPunktOdbioruPeer::retrieveByPK($this->order->getId());

            if (null === $this->deliveryPoint)
            {
                $this->deliveryPoint = new PocztaPolskaPunktOdbioru();
                $this->deliveryPoint->setOrder($this->order);
            }
            else
            {
                $urzadWydaniaEPrzesylkiType = new urzadWydaniaEPrzesylkiType();
                $urzadWydaniaEPrzesylkiType->id = intval($this->deliveryPoint->getPni());
                $urzadWydaniaEPrzesylkiType->wojewodztwo = $this->deliveryPoint->getProvince();
                $service->urzadWydaniaEPrzesylki = $urzadWydaniaEPrzesylkiType;
            } 
        }     
        else
        {
            $user = $this->order->getOrderUserDataDelivery();
        }

        if ($this->serviceName == 'paczka_zagraniczna' || $this->serviceName == 'paczka_zagraniczna_ue')
        {
            $service->zwrot = new zwrotType();
            $service->zwrot->zwrotPoLiczbieDni = 15;
            $service->zwrot->sposobZwrotu = 'LADOWO_MORSKA';
        }

        $service->adres = new adresType();

        if ($user->getCompany())
        {
            $service->adres->nazwa = $user->getCompany();
            $service->adres->nazwa2 = $user->getFullname();
        }
        else
        {
            $service->adres->nazwa = $user->getFullname();
        }

        $service->adres->ulica = $user->getAddress();

        if ($user->getAddressMore())
        {
           $service->adres->ulica .= ' '.$user->getAddressMore(); 
        }
        
        $service->adres->miejscowosc = $user->getTown();
        $service->adres->kodPocztowy = $user->getCode();
        $service->adres->telefon = $user->getPhone();
        $service->adres->mobile = $user->getPhone();
        $service->adres->email = $this->order->getOptClientEmail();
        $service->adres->kraj = $user->getCountry()->getOptName();

        $service->nadawca = new adresType();

        if ($config->get('is_company'))
        {
            $service->nadawca->nazwa = $config->get('company');

            if ($config->get('name'))
            {
                $name = $config->get('name').' '.$config->get('surname');
                $service->nadawca->nazwa2 = trim($name);
            }      
        }
        else
        {
            $service->nadawca->nazwa = $config->get('name').' '.$config->get('surname');
        }

        $service->nadawca->ulica = $config->get('street');
        $service->nadawca->numerDomu = $config->get('house');
        $service->nadawca->numerLokalu = $config->get('flat');
        $service->nadawca->miejscowosc = $config->get('town');
        $service->nadawca->kodPocztowy = $config->get('zip_code');
        $service->nadawca->telefon = $config->get('phone');
        $service->nadawca->email = $config->get('email');
        $service->nadawca->kraj = "Polska";

        $this->service = $service;

        $this->setCountry($service->adres->kraj);

        $bufor = new buforType();
        $bufor->dataNadania = date("Y-m-d");
        $bufor->urzadNadania = $config->get('urzad_nadania');

        $this->bufor = $bufor;
    }

    public function setCountry($name)
    {
        $this->service->adres->kraj = $name;

        if (property_exists($this->service, 'deklaracjaCelna2') && !stPocztaPolskaClient::isEUCountry($this->service->adres->kraj))
        {
            $this->service->deklaracjaCelna2 = new deklaracjaCelna2Type();
            $this->service->deklaracjaCelna2->zawartoscPrzesylki = 'SPRZEDAZ_TOWARU';
            $this->service->deklaracjaCelna2->dokumentyTowarzyszace = array();
            $this->service->deklaracjaCelna2->szczegolyZawartosciPrzesylki = array();
            $this->service->deklaracjaCelna2->walutaKodISO = $this->order->getOrderCurrency()->getShortcut();  
        }
    }

    public function getServiceName()
    {
        return $this->serviceName;
    }

    public function getService()
    {
        return $this->service;
    }

    public function getOrder()
    {
        return $this->order;
    }

    public function getBufor()
    {
        return $this->bufor;
    }

    public function getOrderAmount()
    {
        return $this->order->getTotalAmount(true, true) * 100;
    }

    public function getDeliveryPoint()
    {
        return $this->deliveryPoint;
    }
}