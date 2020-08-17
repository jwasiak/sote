<?php 

class stInPostApi
{
    /**
     * Singleton
     *
     * @var stInPostApi
     */
    protected static $instance = null;

    /**
     * Konfiguracja inpost
     *
     * @var stConfig
     */
    protected $config = null;

    /**
     * Poprawność konfiguracji api
     *
     * @var bool
     */
    protected $isValid = null;

    /**
     * Ostatni błąd Api
     *
     * @var stdClass
     */
    protected $lastError = null;

    /**
     * Ostatnie komunikat błędu Api
     *
     * @var string
     * 
     */
    protected $lastErrorMessage = null;

    /**
     * Lista statusów paczki
     *
     * @var array
     */
    protected $statuses = null;

    /**
     * Lista metod wysyłki
     *
     * @var array
     */
    protected $sendingMethods = array();

    const SANDBOX_ENDPOINT = 'https://sandbox-api-shipx-pl.easypack24.net/v1';

    const PRODUCTION_ENDPOINT = 'https://api-shipx-pl.easypack24.net/v1';

    const VALIDATION_FAILED = 'validation_failed';

    const ACCESS_FORBIDDEN = 'access_forbidden';
    
    const INVALID_PARAMETER = 'invalid_parameter';
    
    const OFFER_EXPIRED = 'offer_expired';
    
    const TOKEN_INVALID = 'token_invalid';
    
    const ROUTING_NOT_FOUND = 'routing_not_found';

    /**
     * Zwraca instancję klasy stInPostApi
     *
     * @return stInPostApi
     */
    public static function getInstance()
    {
        if (null === self::$instance)
        {
            self::$instance = new self();
            self::$instance->initialize();
        }

        return self::$instance;
    }

    /**
     * Sprawdza poprawność konfiguracji api
     *
     * @return bool
     */
    public function isValid()
    {
        if ($this->config->get('token') && null === $this->isValid)
        {
            try
            {
                $this->getOrganizations();
    
                $this->isValid = true;
            }
            catch(stInPostApiException $e)
            {
                $this->isValid = false;
            }
        }

        return $this->isValid;
    }

    public function initialize()
    {
        $this->config = stConfig::getInstance('stPaczkomatyBackend');
    }

    public function getPoint($name)
    {
        return $this->callApi('get', '/points/' . $name);
    }

    public function getPoints(array $params = null)
    {
        return $this->callApi('get', '/points', $params);
    }

    /**
     * Pobiera listę statusów dla paczki
     *
     * @return array
     */
    public function getStatuses($lang = null)
    {
        $lang = sfContext::getInstance()->getUser()->getCulture();

        if ($lang == 'en_US')
        {
            $lang = 'en_GB';
        }

        if (!isset($this->statuses[$lang]))
        {
            $response = $this->callApi('get', '/statuses', array('lang' => $lang));

            $statuses = array();

            foreach ($response->items as $item)
            {
                $statuses[$item->name] = rtrim($item->title, '.');
            }

            $this->statuses[$lang] = $statuses;
        }

        return $this->statuses[$lang];
    }

    public function downloadLabel($id)
    {
        $params = array(
            'type' => $this->config->get('label_type'),
            'format' => 'pdf',
        );

        // throw new Exception('/shipments/' . $id . '/label');
        

        return $this->callApi('get', '/shipments/' . $id . '/label', $params);
    }

    /**
     * Pobiera tytuł statusu po jego nazwie
     *
     * @param string $name
     * @return string
     */
    public function getStatusTitleByName($name)
    {
        $statuses = $this->getStatuses();

        return isset($statuses[$name]) ? $statuses[$name] : null;
    }

    public function getOrganizations(array $params = array())
    {
        $params = array_merge(array(
            'sort_by' => 'name',
            'sort_order' => 'asc',
            ),
            $params
        );

        return $this->callApi('get', '/organizations', $params);
    }

    public function getOrganization($id)
    {
        return $this->callApi('get', '/organizations/' . $id);
    }

    public function getSendingMethods($service = null)
    {
        if (!isset($this->sendingMethods[$service]))
        {
            $response = $this->callApi('get', '/sending_methods', $service ? array('service' => $service) : null);

            $methods = array();

            $i18n = sfContext::getInstance()->getI18N();

            foreach ($response->items as $method)
            {
                $methods[$method->id] = $i18n->__($method->name, null, 'stPaczkomatyBackend');
            }

            $this->sendingMethods[$service] = $methods;
        }

        return $this->sendingMethods[$service];
    }

    public function createShipment(array $params)
    {        
        return $this->callApi('post', '/organizations/' . $this->config->get('organization') . '/shipments', $params);
    }

    public function getShipments(array $params)
    {
        return $this->callApi('get', '/organizations/' . $this->config->get('organization') . '/shipments', $params);
    }

    public function deleteShipment($id)
    {
        return $this->callApi('delete', '/shipments/' . $id);
    }

    public function getShipment($id)
    {
        $response = $this->getShipments(array('id' => $id));

        return $response->items ? $response->items[0] : null;
    }

    public function getShipmentByTrackingNumber($number)
    {
        $response = $this->getShipments(array('tracking_number' => $number));

        return $response->items ? $response->items[0] : null;
    }

    protected function getErrorMessage(stdClass $response)
    {
        $errors = array(
            'resource_not_found' => 'Szukany zasób nie został odnaleziony.',
            'access_forbidden' => 'Dostęp do określonego zasobu jest zabroniony.',
            'invalid_parameter' => 'Przekazano niepoprawną wartość dla określonego parametru w URI. Szczegóły dostępne pod kluczem description odpowiedzi błędu.',
            'validation_failed' => 'Błąd walidacji. Dane przesłane metodą POST są niepoprawne',
            'offer_expired' => 'Zakupienie oferty jest niemożliwe, ponieważ upłynął termin jej ważności.',
            'token_invalid' => 'Podany token jest nieprawidłowy', 
            'routing_not_found' => 'Szukany zasób nie został odnaleziony.',  
            'invalid_end_of_week_collection' => 'Opcja "Paczka w weekend" jest dostępna tylko w określonym przedziale czasowym opisanym w informacjach ogólnych usługi',  
            'invalid_target_point_for_end_of_week_collection' => 'Opcja "Paczka w weekend" jest dostępna tylko dla Paczkomatów',
            'invalid_allegro_for_end_of_week_collection' => 'Opcja "Paczka w weekend" nie jest dostępna dla przesyłek Allegro',
        );

        $message = null;

        if (isset($errors[$response->error]))
        {
            $message = $errors[$response->error];
        }
        elseif (isset($response->message))
        {
            $message = $response->message;
        }
        elseif (isset($response->description))
        {
            $message = $response->description;
        }

        return $message;
    }

    /**
     * Zwraca ostatni błąd api
     *
     * @return stdClass
     */
    public function getLastError()
    {
        return $this->lastError;
    }

    /**
     * Zwraca ostatni komunikat błędu api
     *
     * @return string
     */
    public function getLastErrorMessage()
    {
        return $this->lastError;
    }

    public function isSandbox()
    {
        return $this->config->get('sandbox');
    }

    public function callApi($method, $resource, array $data = null)
    {
        $this->lastError = null;
        $this->lastErrorMessage = null;

        $ch = curl_init();

        curl_setopt($ch, CURLINFO_HEADER_OUT, true);

        $url = $this->getEndpoint() . $resource;

        if ($method == 'post')
        {
            curl_setopt($ch, CURLOPT_POST, 1);
        }
        else
        {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($method));
        }

        if (($method == 'post' || $method == 'put') && $data)
        {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }
        elseif ($data)
        {
            $url = $url . '?' . http_build_query($data, '', '&');
        }

        // OPTIONS:
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt ($ch, CURLOPT_SSLVERSION, 6);
        // curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
           'Content-Type: application/json',
           'Authorization: Bearer ' . $this->config->get('token'),
        ));

        $headers = array();

        curl_setopt($ch, CURLOPT_HEADERFUNCTION,
            function($curl, $header) use (&$headers)
            {
                $len = strlen($header);
                $header = explode(':', $header, 2);
                if (count($header) < 2) // ignore invalid headers
                    return $len;
            
                $headers[strtolower(trim($header[0]))] = trim($header[1]);
            
                return $len;
            }
        );        

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   
        $result = curl_exec($ch);
        $error = curl_error($ch);

        curl_close($ch);

        if ($error)
        {
            $this->lastErrorMessage = $error;
            throw new stInPostApiException($error);
        }

        if (false !== strpos($headers['content-type'], 'application/json'))
        {
            $response = json_decode($result);        

            if (isset($response->error))
            {
                $this->lastError = $response;
                $this->lastErrorMessage = $this->getErrorMessage($response);

                if (sfConfig::get('sf_debug'))
                {
                    sfLogger::getInstance()->err("{stInPostApi} Calling: " . $url);

                    sfLogger::getInstance()->err("{stInPostApi} With HEADERS: " . json_encode(array(
                       'Content-Type: application/json',
                       'Authorization: Bearer ' . $this->config->get('token'),
                    )));

                    if ($method == 'post')
                    {
                        sfLogger::getInstance()->err("{stInPostApi} With POST: " . json_encode($data));
                    }

                    sfLogger::getInstance()->err("{stInPostApi} Response: " . json_encode($response));
                }

                throw new stInPostApiException($this->lastErrorMessage);
            }
        }
        else
        {
            $response = $result;
        }

        return $response;
    }

    public function getEndpoint()
    {
        return $this->isSandbox() ? self::SANDBOX_ENDPOINT : self::PRODUCTION_ENDPOINT;
    }

    public static function formatDetailError(array $errors)
    {
        $i18n = sfContext::getInstance()->getI18N();

        $detailErrors = array(
            'required' => 'Wartość dla określonego parametru jest wymagana.',
            'too_short' => 'Za mała ilość znaków',
            'too_small' => 'Za mała wartość',
            'too_long' => 'Za duża ilość znaków',
            'not_a_number' => 'Wartość nie jest liczbą',
            'not_an_integer' => 'Wartość nie jest liczbą całkowitą',
            'invalid' => 'Wprowadzona wartość jest niepoprawna.',
        );

        $message = array();

        foreach ($errors as $error)
        {
            $message[] = isset($detailErrors[$error]) ? $i18n->__($detailErrors[$error], null, 'stPaczkomatyBackend') : $error;
        }

        return implode("<br>", $message);
    }
}