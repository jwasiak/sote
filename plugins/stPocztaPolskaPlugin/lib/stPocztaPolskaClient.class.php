<?php

class stPocztaPolskaClient
{
    protected $client;

    protected static $instance = null;

    protected static $buforList = null;

    protected $urzedyNadania = null;

    protected static $services = array(
        'usluga_paczkowa_24' => array('class' => 'uslugaPaczkowaType', 'defaults' => array('termin' => 'PACZKA_24'), 'label' => "Usługa paczkowa - Paczka 24"),
        'usluga_paczkowa_48' => array('class' => 'uslugaPaczkowaType', 'defaults' => array('termin' => 'PACZKA_EXTRA_24'), 'label' => "Usługa paczkowa - Paczka Ekstra 24"),
        'usluga_paczkowa_e24' => array('class' => 'uslugaPaczkowaType', 'defaults' => array('termin' => 'PACZKA_48'), 'label' => "Usługa paczkowa - Paczka 48"),
        'pocztex_ekspres_24' => array('class' => 'uslugaKurierskaType', 'defaults' => array('termin' => 'EKSPRES24'), 'label' => "Pocztex - Kurier Ekspres 24"),
        'pocztex_krajowy' => array('class' => 'uslugaKurierskaType', 'defaults' => array('termin' => 'KRAJOWY'), 'label' => "Pocztex - Kurier Krajowy"),
        'przesylka_biznesowa' => array('class' => 'przesylkaBiznesowaType', 'label' => "Pocztex Kurier 48 (Przesyłka biznesowa)"),
        'paczka_zagraniczna' => array('class' => 'paczkaZagranicznaType', 'label' => "Paczka zagraniczna pozostałe kraje"),
        'paczka_zagraniczna_ue' => array('class' => 'paczkaZagranicznaType', 'label' => "Paczka zagraniczna do UE"),
        'paczka_pocztowa_ekonomiczna' => array('class' => 'paczkaPocztowaType', 'defaults' => array('kategoria' => 'EKONOMICZNA'), 'label' => "Paczka Pocztowa - Ekonomiczna"),   
        'paczka_pocztowa_priorytetowa' => array('class' => 'paczkaPocztowaType', 'defaults' => array('kategoria' => 'PRIORYTETOWA'), 'label' => "Paczka Pocztowa - Priorytetowa"), 
        'przesylka_polecona_ekonomiczna' => array('class' => 'przesylkaPoleconaKrajowaType', 'defaults' => array('kategoria' => 'EKONOMICZNA'), 'label' => "Przesyłka polecona krajowa - Ekonomiczna"),
        'przesylka_polecona_priorytetowa' => array('class' => 'przesylkaPoleconaKrajowaType', 'defaults' => array('kategoria' => 'PRIORYTETOWA'), 'label' => "Przesyłka polecona krajowa - Priorytetowa"),
        'przesylka_firmowa_polecona_ekonomiczna' => array('class' => 'przesylkaFirmowaPoleconaType', 'defaults' => array('kategoria' => 'EKONOMICZNA'), 'label' => "Przesyłka firmowa polecona - Ekonomiczna"),   
        'przesylka_firmowa_polecona_priorytetowa' => array('class' => 'przesylkaFirmowaPoleconaType', 'defaults' => array('kategoria' => 'PRIORYTETOWA'), 'label' => "Przesyłka firmowa polecona - Priorytetowa"),
        'zagraniczna_przesylka_zwykla_ekonomiczna' => array('class' => 'przesylkaZagranicznaType', 'defaults' => array('kategoria' => 'EKONOMICZNA'), 'label' => 'Zagraniczna przesyłka zwykła - Ekonomiczna'),
        'zagraniczna_przesylka_zwykla_priorytetowa' => array('class' => 'przesylkaZagranicznaType', 'defaults' => array('kategoria' => 'PRIORYTETOWA'), 'label' => 'Zagraniczna przesyłka zwykła - Priorytetowa'),
        'zagraniczna_przesylka_polecona' => array('class' => 'przesylkaPoleconaZagranicznaType', 'label' => 'Zagraniczna przesyłka polecona'),
    );

    public static function getCourierServiceList()
    {
        return array(
            "paczka_zagraniczna", 
            "paczka_zagraniczna_ue", 
            "przesylka_polecona_ekonomiczna", 
            "przesylka_polecona_priorytetowa", 
            "przesylka_firmowa_polecona_ekonomiczna",
            "przesylka_firmowa_polecona_priorytetowa",
            "paczka_pocztowa_ekonomiczna", 
            "paczka_pocztowa_priorytetowa", 
            "zagraniczna_przesylka_zwykla_ekonomiczna", 
            "zagraniczna_przesylka_zwykla_priorytetowa", 
            "zagraniczna_przesylka_polecona"
        );
    }

    public static function isEUCountry($name)
    {
        $eu = array(
            'Austria',
            'Belgia',
            'Czechy',
            'Dania',
            'Estonia',
            'Finlandia',
            'Francja',
            'Grecja',
            'Hiszpania',
            'Holandia',
            'Islandia',
            'Liechtenstein',
            'Litwa',
            'Luksemburg',
            'Łotwa',
            'Malta',
            'Niemcy',
            'Norwegia',
            'Szwajcaria',
            'Szwecja',
            'Polska',
            'Portugalia',
            'Słowacja',
            'Słowenia',
            'Węgry',
            'Włochy',
            'Irlandia',
            'Wielka Brytania',
        );

        return in_array($name, $eu);
    }

    public static function getInstance()
    {
        if (null === self::$instance)
        {
            $config = stConfig::getInstance('stPocztaPolskaBackend');
            self::$instance = new stPocztaPolskaClient($config->get('login'), $config->get('password'), $config->get('test_mode'));
        }

        return self::$instance;
    }

    public function __construct($login, $password, $testMode = false)
    {
   

        $params = array(
            'login' => $login,
            'password' => $password,
            'trace' => SF_ENVIRONMENT == 'dev',
            'location' => $testMode ? 'https://en-testwebapi.poczta-polska.pl/websrv/en.php' : 'https://e-nadawca.poczta-polska.pl/websrv/en.php',
            'cache_wsdl' => WSDL_CACHE_MEMORY,
        );

        $this->client = new ElektronicznyNadawca(__DIR__ . '/../data/en.wsdl', $params);
    }

    public static function getInstrukcjaDeklaracjiCelnejUrl()
    {
        $config = stConfig::getInstance('stPocztaPolskaBackend');

        if ($config->get('test_mode'))
        {
            return "https://en-testwebapi.poczta-polska.pl/download/instrukcja-wypelniania-deklaracji-celnej.doc";
        } 
        else
        {
            return "https://e-nadawca.poczta-polska.pl/download/instrukcja-wypelniania-deklaracji-celnej.doc";
        }
    }

    public function getUrzedyNadania($cached = true)
    {
        if (null === $this->urzedyNadania)
        {
            $fc = stFunctionCache::getInstance('stPocztaPolska');
            $fc->setLifeTime(24*60*60*7);
            
            if ($cached) {
                $this->urzedyNadania = $fc->cacheCall(array($this, 'getUrzedyNadaniaRequest'), array(), array('id' => 'urzedyNadania'));
            } else {
                $this->urzedyNadania = $this->getUrzedyNadaniaRequest();
            }

            $fc->setLifeTime(time());
        }  

        return $this->urzedyNadania;
    }

    public function getBufor($id)
    {
        $results = $this->getBuforList();

        foreach ($results as $result) 
        {
            if ($result->idBufor == $id)
            {
                return $result;
            }
        }

        return null;
    }

    public function getBuforGuids($bufor_id)
    {
        $getEnvelopeBufor = new getEnvelopeBufor();
        $getEnvelopeBufor->idBufor = $bufor_id;

        $response = $this->getEnvelopeBufor($getEnvelopeBufor);

        $results = is_array($response->przesylka) ? $response->przesylka : array($response->przesylka);

        $guids = array();

        foreach ($results as $przesylka) {
            $guids[] = $przesylka->guid;
        }   

        return $guids;          
    }

    public function getBuforList()
    {
        $getEnvelopeBuforList = new getEnvelopeBuforList();
        $response = $this->getEnvelopeBuforList($getEnvelopeBuforList);

        return is_array($response->bufor) ? $response->bufor : array($response->bufor);        
    }

    public function deleteBufor($id)
    {
        $clearEnvelope = new clearEnvelope();
        $clearEnvelope->idBufor = $id;
        $response = $this->clearEnvelope($clearEnvelope);

        $c = new Criteria();
        $c->add(PocztaPolskaBuforPeer::BUFOR_ID, $id);
        PocztaPolskaBuforPeer::doDelete($c);

        $c = new Criteria();
        $c->add(PocztaPolskaPaczkaPeer::BUFOR_ID, $id);
        PocztaPolskaPaczkaPeer::doDelete($c);
    }
 
    public function getOrCreateBufor($dataNadania, $urzadNadania)
    {
        $buforDesc = self::getBuforDescription($dataNadania, $urzadNadania);
        $results = $this->getBuforList();

        $getEnvelopeBuforListResponse = new getEnvelopeBuforListResponse();

        foreach ($results as $result) 
        {
            if ($result->opis == $buforDesc && $result->dataNadania == $dataNadania && $result->urzadNadania == $urzadNadania)
            {
                $bufor = PocztaPolskaBuforPeer::retrieveByBuforId($result->idBufor);
                
                if ($bufor && $bufor->getCountPaczka() < 50) {
                    $getEnvelopeBuforListResponse->bufor = $result;
                    break;
                }
            }
        }  
                    
        if (null === $getEnvelopeBuforListResponse->bufor)
        {
            $createEnvelopeBufor = new createEnvelopeBufor();
            $createEnvelopeBufor->bufor = new buforType();
            $createEnvelopeBufor->bufor->dataNadania = $dataNadania;
            $createEnvelopeBufor->bufor->urzadNadania = $urzadNadania;
            $createEnvelopeBufor->bufor->opis = $buforDesc;

            $response = $this->createEnvelopeBufor($createEnvelopeBufor);

            $getEnvelopeBuforListResponse->bufor = $response->createdBufor;
            $getEnvelopeBuforListResponse->error = $response->error;

            if (!$response->error)
            {
                $ppb = new PocztaPolskaBufor();
                $ppb->setBuforId($response->createdBufor->idBufor);
                $ppb->setDataNadania($dataNadania);
                $ppb->setUrzadNadania($urzadNadania);
                $ppb->save();
            }
        }

        return $getEnvelopeBuforListResponse;
    }

    public static function getBuforDescription($dataNadania, $urzadNadania)
    {
        $postfix = stConfig::getInstance('stRegister')->get('www');

        $postfix = str_replace(array('http://', 'https://'), "", $postfix);
        $postfix = rtrim($postfix, '/');
        return "SOTESHOP ".$postfix;
    }

    public function getClient()
    {
        return $this->client;
    }

    public function getUrzedyNadaniaRequest()
    {
        $response = $this->client->getUrzedyNadania(new getUrzedyNadania());   

        $options = array();

        $urzedy = array();

        $results = is_array($response->urzedyNadania) ? $response->urzedyNadania : array($response->urzedyNadania);

        foreach ($results as $urzadNadania)
        {
            $urzedy[$urzadNadania->urzadNadania] = $urzadNadania->nazwaWydruk;
        }

        $regions = array("02","04","06","08","10","12","14","16","18","20","22","24","26","28","30","32");
        
        foreach ($regions as $id)
        {
            $getPlacowkiPocztowe = new getPlacowkiPocztowe();
            $getPlacowkiPocztowe->idWojewodztwo = $id;

            $results = stPocztaPolskaClient::getInstance()->getPlacowkiPocztowe($getPlacowkiPocztowe);

            $placowki = is_array($results->placowka) ? $results->placowka : array($results->placowka);

            foreach ($placowki as $placowka)
            {
                if (isset($urzedy[$placowka->id]))
                {
                    $urzedy[$placowka->id] = $placowka->miejscowosc.' '.$placowka->ulica.' '.$placowka->numerDomu.($placowka->numerLokalu ? '/'.$placowka->numerLokalu : '').' ('.$placowka->nazwaWydruk.')';
                }
            }
        }

        natsort($urzedy);

        return $urzedy;        
    }

    public function __call($name, $arguments)
    {        
        if (!is_callable(array($this->client, $name)))
        {
            throw new Exception(sprintf("Method %s does not exist", $name));
        }
        
        return call_user_func_array(array($this->client, $name), $arguments);
    }

    public static function getGabarytyBiznesowa()
    {
        return array(
            "XS" => "XS (25x20x10)",
            "S" => "S (30x25x15)",
            "M" => "M (35x30x20)",
            "L" => "L (45x35x25)",
            "XL" => "XL (60x50x40)",
            "XXL" => "XXL (100x60x40)",
        );
    }

    public static function getGabaryty()
    {
        return array(
            "GABARYT_A" => "Gabaryt A (60 x 50 x 30)",
            "GABARYT_B" => "Gabaryt B (Suma długości i największego obwodu mierzonego w innym kierunku niż<br>długość - 300 cm, przy czym największy wymiar nie może przekroczyć 150 cm)",
        );
    }

    public static function getGabarytyFirmowa()
    {
        return array(
            "GABARYT_A" => "Gabaryt A (Maksymalne wymiary przesyłki - suma długości, szerokości i wysokości nie może przekroczyć 700 mm, przy czym najdłuższy z tych wymiarów (długość) nie może przekroczyć 500 mm)",
            "GABARYT_B" => "Gabaryt B (Maksymalne wymiary przesyłki – suma długości, szerokość i wysokość 900<br>mm, największy z wymiarów nie może przekroczyć 600 mm)",
        );
    }

    public static function getFormaty()
    {
        return array(
            'S' => 'S (Maksymalne wymiary koperty [mm]: 160 x 230 x 20, maksymalna waga [g]: 500)',
            'M' => 'M (Maksymalne wymiary koperty [mm]: 230 x 325 x 20, maksymalna waga [g]: 1000)',
            'L' => 'L (Maksymalna suma wymiarów koperty [mm]: 900, maksymalna długość najdłuższego boku [mm]: 600, rulony, maksymalna waga [g]: 2000)',
        );
    }

    public static function getRodzajZagraniczna()
    {
        return array(
            'CN22' => 'CN22',
            'CN23' => 'CN23',
        );
    }

    public static function getZawartoscPrzesylkiZagranicznej()
    {
        return array(
            "SPRZEDAZ_TOWARU" => "Sprzedaż towaru",
			"ZWROT_TOWARU" => "Zwrot towaru",
			"PREZENT" => "Prezent",
			"PROBKA_HANDLOWA" => "Próbka handlowa",
            "DOKUMENT" => "Dokument",
			"INNE" => "Inne",
        );
    }

    public static function getDokumentTowarzyszacyRodzaje()
    {
        return array(
			"LICENCJA" => "Licencja",
			"CERTYFIKAT" => "Certyfikat",
			"FAKTURA" => "Faktura",
        );
    }


    public static function getFormatedErrors($errors)
    {
        if (is_array($errors))
        {
            $results = array();

            foreach ($errors as $error) 
            {
                $results[] = ($error->guid ? $error->guid. ': ' : '') . $error->errorDesc;    
            }

            return "<br>- ".implode("<br>- ", $results);
        }
        else
        {
            return ($errors->guid ? $errors->guid. ': ' : '') . $errors->errorDesc;
        }
    }

    public static function getOpakowania($serviceName)
    {
        if ($serviceName == 'usluga_paczkowa_24' || $serviceName == 'usluga_paczkowa_e24')
        {
            return array(
                "" => "---",
                "PACZKA_DO_POL_KILO" => "Paczka do 0,5kg (max. 32x22x10 cm)",
                "FIRMOWA_DO_1KG" => "Koperta firmowa do 1kg",
            );
        }
        else
        {
            return array(
                "" => "---",
                "FIRMOWA_DO_1KG" => "Koperta firmowa do 1kg",
            );            
        }
    }

    public static function getKategorie()
    {
        return array(
            'EKONOMICZNA' => "Ekonomiczna",
            'PRIORYTETOWA' => "Priorytetowa",
        );   
    }

    public static function getSposobZwrotu()
    {
        return array(
            "LADOWO_MORSKA" => "Lądowo morska (S.A.L)",
            "LOTNICZA" => "Lotnicza",
        );   
    }

    public static function createService($name)
    {
        $instance = null;

        if (!isset(self::$services[$name]))
        {
            throw new Exception("Service $name does not exist");
        }

        $class = self::$services[$name]['class'];

        $instance = new $class();

        if (isset(self::$services[$name]['defaults']))
        {
            foreach (self::$services[$name]['defaults'] as $property => $value) 
            {
                $instance->$property = $value;
            }
        }

        if ($instance && property_exists($instance, 'uiszczaOplate'))
        {
            $instance->uiszczaOplate = 'NADAWCA';
        }

        return $instance;
    }

    public static function getServices()
    {
        return self::$services;
    }

    public static function updateService($service, $data)
    {
        foreach ($data as $name => $value)
        {
            $name = lcfirst(sfInflector::camelize($name));

            if (!is_object($service) || !property_exists($service, $name))
            {
                continue;
            }

            switch($name)
            {
                case 'ubezpieczenie':
                    $service->$name = new ubezpieczenieType();
                    $service->$name->rodzaj = 'STANDARD';
                break;

                case 'epo':
                    $value = $value ? new EPOSimpleType() : null;
                break;

                case 'kwotaPobrania':
                case 'kwota':
                case 'wartosc':
                    $value = stPrice::round($value * 100, 0);                                                          
                break;

                case 'masaNetto':
                case 'masa':
                    $value = "" === $value ? null : stPrice::round($value * 1000, 0);
                break;
            }

            if (is_array($value))
            {
                self::updateService($service->$name, $value);    
            }
            else
            {
                $service->$name = $value;
            }
        }
    }
}