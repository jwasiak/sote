<?php

class stAllegroApi 
{
    protected static $instance = null;

    /**
     * AllegroRestApi instance
     *
     * @var AllegroRestApi
     */
    protected $api = null;

    /**
     * stConfig instance
     *
     * @var stConfig
     */
    protected $config = null;

    CONST ALLEGRO_URL = 'https://allegro.pl';
    CONST ALLEGRO_SANDBOX_URL = 'https://allegro.pl.allegrosandbox.pl';

    public function __construct()
    {
        
    }

    /**
     * Get stAllegroApi instance
     *
     * @return self
     */
    public static function getInstance()
    {
        if (null === self::$instance)
        {
            self::$instance = new static();
            self::$instance->initialize();
        }

        return self::$instance;
    }

    public static function redirectAuthUri()
    {
        return sfContext::getInstance()->getController()->genUrl('@stAllegroPlugin?action=config', true);
    }

    public function initialize()
    {
        $this->config = stConfig::getInstance('stAllegroBackend');

        try
        {
            $this->refreshToken();
        }
        catch(stAllegroException $e)
        {
            $this->api = new AllegroRestApi($this->config->get('access_token'), $this->config->get('sandbox'));
            throw $e;
        }

        $this->api = new AllegroRestApi($this->config->get('access_token'), $this->config->get('sandbox'));
    }

    public function refreshToken()
    {
        if (time() >= $this->config->get('expires'))
        {
            $response = AllegroRestApi::refreshToken($this->config->get('refresh_token'), $this->config->get('client_id'), $this->config->get('client_secret'), self::redirectAuthUri(), $this->config->get('sandbox'));

            if ($response)
            {
                if (isset($response->error))
                {
                    throw new stAllegroException($response->error);
                }

                $this->config->set('access_token', $response->access_token);  
                $this->config->set('refresh_token', $response->refresh_token);
                $this->config->set('expires', $response->expires_in + time());
                $this->config->set('seller_id', $response->seller_id);
                $this->config->save(true);
            }
        }
    }

    public function getDeliveryMethods()
    {
        $response = $this->api->get('/sale/delivery-methods');

        if ($response)
        {
            return $response->deliveryMethods;
        }

        return null;
    }

    public function getShippingRates()
    {
        $response = $this->api->get('/sale/shipping-rates?seller.id=' . $this->config->get('seller_id'));

        if (isset($response->shippingRates))
        {
            return $response->shippingRates;
        }

        return null;
    }

    public function getShippingRate($id)
    {
        $response = $this->api->get('/sale/shipping-rates/'.$id);

        if ($response) 
        {
            $rates = array();

            foreach ($response->rates as $rate)
            {
                $rates[$rate->deliveryMethod->id] = $rate;
            }

            $response->rates = $rates;
        }

        return $response;
    }

    public function updateShippingRate($id, $data)
    {
        $rates = array();

        foreach ($data['rates'] as $methodId => $rate)
        {
            $rates[] = array(
                'deliveryMethod' => array('id' => $methodId),
                'maxQuantityPerPackage' => $rate['max_quantity_per_package'],
                'firstItemRate' => $rate['first_item_rate'],
                'nextItemRate' => $rate['next_item_rate'],
            );
        }

        $request = array(
            'id' => $id,
            'name' => $data['name'],
            'rates' => $rates,
        );

        return $this->api->put('/sale/shipping-rates/'.$id, $request);
    }

    public function createShippingRate($data)
    {
        $rates = array();

        foreach ($data['rates'] as $methodId => $rate)
        {
            $rates[] = array(
                'deliveryMethod' => array('id' => $methodId),
                'maxQuantityPerPackage' => $rate['max_quantity_per_package'],
                'firstItemRate' => $rate['first_item_rate'],
                'nextItemRate' => $rate['next_item_rate'],
            );
        }

        $request = array(
            'name' => $data['name'],
            'rates' => $rates,
        );

        return $this->api->post('/sale/shipping-rates', $request);
    }

    public function getOffers($params = array())
    {
        $querystring = array();

        if (isset($params['external.id']) && is_array($params['external.id'])) {
            foreach ($params['external.id'] as $id) 
            {
                $querystring[] = 'external.id='.$id;
            }

            unset($params['external.id']);
        }
        $query = $params ? '?' . http_build_query($params, '', '&') : '';

        return $this->api->get('/sale/offers'.$query.($query ? '&'.implode("&", $querystring) : '?'.implode("&", $querystring)));
    }

    public function getOffer($id)
    {
        $response = $this->api->get('/sale/offers/'.$id);

        if ($response->parameters)
        {
            $parameters = array();

            foreach ($response->parameters as $parameter)
            {
                $parameters[$parameter->id] = $parameter;
            }

            $response->parameters = $parameters;
        }

        return $response;
    }

    public function getCategoryParameters($categoryId)
    {
        $response = $this->api->get('/sale/categories/' . $categoryId . '/parameters');

        return $response->parameters;
    }

    public function getCategories($parentId = null)
    {
        if ($parentId)
        {
            $response = $this->api->get('/sale/categories?parent.id=' . $parentId);
        }
        else
        {
            $response = $this->api->get('/sale/categories');
        }

        if ($response)
        {
            return $response->categories;
        }

        return array();
    }

    public function getCategory($categoryId)
    {
        return $this->api->get('/sale/categories/'.$categoryId);
    }

    public function getCategoryPath($parentId)
    {
        $path = array();

        $response = $this->getCategory($parentId);

        $path[$response->id] = $response;

        while($response && null !== $response->parent)
        {
            $response = $this->getCategory($response->parent->id);

            $path[$response->id] = $response;
        }

        return $path ? array_reverse($path, true) : array();
    }

    public function deleteDraftOffer($id)
    {
        return $this->api->delete('/sale/offers/'.$id);
    }

    public static function getOfferUrl($offerNumber)
    {
        return self::getAllegroUrl() . '/oferta/' . $offerNumber;
    }

    public static function getOrderUrl($checkoutFormId)
    {
        return self::getAllegroUrl() . '/moje-allegro/sprzedaz/zamowienia/' . $checkoutFormId;
    }

    public static function getAllegroUrl()
    {
        $config = stConfig::getInstance('stAllegroBackend');
        return $config->get('sandbox') ? self::ALLEGRO_SANDBOX_URL : self::ALLEGRO_URL;
    }

    public function updateOffer($id, stdClass $offer)
    {
        if ($offer->ean)
        {
            unset($offer->ean);
        }

        $data = self::objectToArray($offer);

        $data['parameters'] = array_values($data['parameters']);

        return $this->api->put('/sale/offers/'.$id, $data);
    }

    public function createOffer(stdClass $offer)
    {
        $data = self::objectToArray($offer);

        $data['parameters'] = array_values($data['parameters']);

        return $this->api->post('/sale/offers', $data);        
    }

    public function getAccountAdditionalEmails()
    {
        return $this->api->get('/account/additional-emails/');
    }

    public function getImpliedWarranties()
    {
        $response = $this->api->get('/after-sales-service-conditions/implied-warranties?seller.id=' . $this->config->get('seller_id'));

        return $response && $response->impliedWarranties ? $response->impliedWarranties : array();
    }

    public function getWarranties()
    {
        $response = $this->api->get('/after-sales-service-conditions/warranties?seller.id=' . $this->config->get('seller_id'));

        return $response && $response->warranties ? $response->warranties : array();
    }

    public function getReturnPolicies()
    {
        $response = $this->api->get('/after-sales-service-conditions/return-policies?seller.id=' . $this->config->get('seller_id'));

        return $response && $response->returnPolicies ? $response->returnPolicies : array();
    }

    public function uploadImage($url)
    {
        return $this->api->post($this->api->getUploadUrl() . '/sale/images', array('url' => $url));
    }

    public function getPricingFeePreview(array $params)
    {
        return $this->api->post('/pricing/fee-preview', $params);
    }

    public function getOfferQuotes($id)
    {
        return $this->api->get('/pricing/offer-quotes?offer.id=' . $id);
    }

    public function publishOffers(array $offers, $activate = true)
    {
        $params = array('offerCriteria' => array(array(
            'offers' => array_map(function($id) {
                return array('id' => intval($id));
            }, $offers),
            'type' => 'CONTAINS_OFFERS',
        )),
        'publication' => array(
            'action' => $activate ? 'ACTIVATE' : 'END',
        ));

        $response = $this->api->put('/sale/offer-publication-commands/' . $this->api->getUuid(), $params);

        return $response;
    }

    public function getPublishOffersReport($commandId)
    {
        $response = $this->api->get("/sale/offer-publication-commands/$commandId/tasks");

        if ($response)
        {
            return $response->tasks;
        }

        return null;
    }

    public function getPaymentMapping($paymentId)
    {
        $response = $this->api->get('/payments/payment-id-mappings?paymentId=' . $paymentId);

        if ($response)
        {
            return $response->transactionId;
        }

        return null;
    }

    public function getOrderCheckoutForms($from = 0, $type = "READY_FOR_PROCESSING", $limit = 10)
    {
        $fromDate = gmdate('Y-m-d\TH:i:s\Z', time() - 60*60*24 * $this->config->get('import_offset'));

        $params = array(
            'status' => $type,
            'limit' => $limit,
            'updatedAt.gte' => $fromDate,
        );

        if (null !== $from)
        {
            $params['offset'] = $from;
        }

        $query = http_build_query($params, null, '&');

        return $this->api->get("/order/checkout-forms?" . $query);      
    }

    public function getOrderEvents($from = null, $type = "READY_FOR_PROCESSING", $limit = 10)
    {
        $params = array(
            'status' => $type,
            'limit' => $limit,
        );

        if (null !== $from)
        {
            $params['offset'] = $from;
        }

        $query = http_build_query($params, null, '&');
        $response = $this->api->get("/order/events?" . $query);

        if ($response && isset($response->events))
        {
            return $response->events;
        }

        return null;
    }

    public function getOrderEventStats()
    {
        $response = $this->api->get("/order/event-stats");

        if ($response && isset($response->latestEvent))
        {
            return $response->latestEvent;
        }

        return null;
    }

    public static function objectToArray($data) {
        if (is_object($data)) {
            // Gets the properties of the given object
            // with get_object_vars function
            $data = get_object_vars($data);
        }
        
        if (is_array($data)) {
            /*
            * Return array converted to object
            * Using __FUNCTION__ (Magic constant)
            * for recursive call
            */
            return array_map(array('stAllegroApi', 'objectToArray'), $data);
        }
        else {
            // Return array
            return $data;
        }
    }  

    public static function arrayToObject($data) {
        if (is_array($data)) {
            /*
            * Return array converted to object
            * Using __FUNCTION__ (Magic constant)
            * for recursive call
            */
            if (!isset($data[0]) && !empty($data)) {
                return (object)array_map(array('stAllegroApi', 'arrayToObject'), $data);
            } else {
                return array_map(array('stAllegroApi', 'arrayToObject'), $data);
            }
        }
        else {
            // Return object
            return $data;
        }
    }
    
    public static function getErrorByHttpCode($code)
    {
        $errors = array(
            400 => 'Wysłano niepoprawne dane JSON.',
            401 => 'Użytkownik nie jest uwierzytelniony - Proszę ponownie zalogować się w Allegro.',
            403 => 'Nie masz praw dostępu do danego zasobu.',
            404 => 'Odpytywany zasób nie istnieje w API.',
            406 => 'W nagłówku Accept przekazany został nieobsługiwany przez zasób typ danych.',
            415 => 'W nagłówku Accept przekazany został nieobsługiwany przez zasób typ danych.',
            422 => 'Wysłano niepoprawne wartości pól, np. walidacja obiektu zwróciła błąd, albo któreś z pól nie spełnia kryteriów nałożonych na nie przez zasób.',
            429 => 'Klient przekroczył limit liczby żądań.',
            503 => 'Połączenie z serwisem nie jest możliwe.',
        );

        return isset($errors[$code]) ? $errors[$code] : null;
    }

    public static function getDeliveryTimes()
    {
        return array(
            'PT0S' => 'natychmiast',
            'PT24H' => '24 godziny',
            'PT48H' => '2 dni',
            'PT72H' => '3 dni',
            'PT96H' => '4 dni',
            'PT120H' => '5 dni',
            'PT168H' => '7 dni',
            'PT240H' => '10 dni',
            'PT336H' => '14 dni',
            'PT504H' => '21 dni',
            'PT720H' => '30 dni',
            'PT1440H' => '60 dni',
        );
    }

    public static function getDurationTimes()
    {        
        return array(
            '' => 'Do wyczerpania przedmiotów',
            'PT72H' => '3 dni',
            'PT120H' => '5 dni',
            'PT168H' => '7 dni',
            'PT240H' => '10 dni',
            'PT480H' => '20 dni',
            'PT720H' => '30 dni',
        );
    }

    public static function getStatusList()
    {
        return array(
            "INACTIVE" => "Szkic",
            "ACTIVE" => "Aktywna", 
            "ACTIVATING" => "W trakcie aktywacji", 
            "ENDED" => "Zakończona",
        );
    }

    public static function getPaymentInvoiceList()
    {
        return array(
            "NO_INVOICE" => "Nie wystawiam faktury", 
            "VAT" => "Faktura VAT", 
            "VAT_MARGIN" => "Faktura VAT-marża", 
            "WITHOUT_VAT" => "Faktura bez VAT",
        );
    }

    public static function getIntervalToDays($interval)
    {
        $interval = new DateInterval($interval);

        $seconds = ($interval->d * 24 * 60 * 60) +
		($interval->h * 60 * 60) +
		($interval->i * 60) +
        $interval->s;
        
        return $seconds / (60 * 60 * 24);
    }

    public static function formatDate($date, $format = "d-m-Y")
    {
        $time = strtotime($date);

        return date($format, $time);
    }

    public static function getLastErrors()
    {
        return AllegroRestApi::getLastErrors();
    }

    public static function getLastHttpCode()
    {
        return AllegroRestApi::getLastHttpCode();
    }
}
