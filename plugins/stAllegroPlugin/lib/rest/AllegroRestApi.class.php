<?php

/**
 * Object PHP interface for Allegro REST API
 * 
 * This class allows you to call any resource 
 * with correct request
 * 
 * It also implements some features which
 * will save you a lot of time
 * 
 * Example:
 * <pre>
 * // Register your application here:
 * // https://apps.developer.allegro.pl
 * 
 * // Creating auth URL using client id and redirect_uri
 * var_dump(
 *     AllegroRestApi::getAuthLink($clientId, $redirectUri)
 * );
 * 
 * // After clicking the link and granting permission you 
 * // will be redirected to $redirectUri with "code"
 * //
 * // Use given code to finally generate access token
 * $tokens = AllegroRestApi::generateToken(
 *     $_GET['code'], 
 *     $clientId, 
 *     $clientSecret, 
 *     $redirectUri
 * );
 * 
 * // Above token will be active for 12 hours and you can
 * // refresh it indefinitely (in example using cron)
 * AllegroRestApi::refreshToken(
 *     $tokens->refresh_token, 
 *     $clientId, 
 *     $clientSecret, 
 *     $redirectUri
 * );
 * 
 * // Creating an instance of RestApi
 * $restApi = new AllegroRestApi($tokens->access_token);
 * 
 * // Getting our comments
 * $response = $restApi->get('/sale/user-ratings?user.id=' . $yourUserId)
 * </pre>
 * 
 * @see        https://developer.allegro.pl/about/
 * @author     Maciej Strączkowski <m.straczkowski@gmail.com>
 * @copyright  ZOONDO.EU Maciej Strączkowski
 * @version    2.0.0
 */
class AllegroRestApi
{
    /**
     * An url address for production API
     */
    const URL = 'https://api.allegro.pl';
    
    /**
     * An url address for sandbox API
     */
    const SANDBOX_URL = 'https://api.allegro.pl.allegrosandbox.pl';

    const AUTH_URL = 'https://allegro.pl/auth/oauth';

    const SANDBOX_AUTH_URL = 'https://allegro.pl.allegrosandbox.pl/auth/oauth';

    const UPLOAD_URL = 'https://upload.allegro.pl';

    const SANDBOX_UPLOAD_URL = 'https://upload.allegro.pl.allegrosandbox.pl';
        
    /**
     * Allegro REST API access token
     * 
     * @var string
     */
    protected $token = null;
    
    /**
     * Should we use sandbox mode?
     * 
     * @var boolean
     */
    protected $sandbox = false;

    /**
     * Last error response from Allegro REST API
     *
     * @var stdClass
     */
    protected static $lastErrors = null;

    protected static $lastHttpCode = null;

    protected static $lastRequestInfo = null;

    protected static $lastHeaders = array();
        
    /**
     * Saves given token and sandbox boolean
     * value into class properties
     * 
     * @param   string   $token
     * @param   boolean  $sandbox
     */
    public function __construct($token, $sandbox = false)
    {
        $this->setToken($token);
        $this->setSandbox($sandbox);
    }
    
    /**
     * Returns an authorization link which user 
     * should click to give access
     * 
     * @param   string  $clientId
     * @param   string  $redirectUri
     * @return  string
     */
    public static function getAuthLink($clientId, $redirectUri, $sandbox = false)
    {
        $api = new AllegroRestApi(null, $sandbox);

        return  $api->getAuthUrl() . "/authorize"
            . "?response_type=code"
            . "&client_id=$clientId"
            . "&redirect_uri=$redirectUri";
    }
    
    /**
     * Generates access token using given 
     * credentials and code
     * 
     * @param   string  $code        Code from allegro
     * @param   string  $clientId    Client ID
     * @param   string  $redirectUri Client secret
     * @return  object
     */
    public static function generateToken($code, $clientId, $clientSecret, $redirectUri, $sandbox = false)
    {
        // Creating an instance of class
        $api = new AllegroRestApi(null, $sandbox);
        
        // Returning response
        $response = $api->sendRequest($api->getAuthUrl() . "/token"
            . "?grant_type=authorization_code"
            . "&code=$code"
            . "&redirect_uri=$redirectUri",
            'POST', 
            array(), 
            array(
                'Authorization' => 'Basic ' . base64_encode("$clientId:$clientSecret")
            )
        );

        if (is_object($response) && isset($response->access_token)) {
            $api = new AllegroRestApi($response->access_token, $sandbox);
            $me = $api->get('/me');
            $response->seller_id = $me->id;
        }

        return $response;
    }
    
    /**
     * Refreshes access token using given 
     * credentials
     * 
     * @param   string  $code        Code from allegro
     * @param   string  $clientId    Client ID
     * @param   string  $redirectUri Client secret
     * @return  object
     */
    public static function refreshToken($refreshToken, $clientId, $clientSecret, $redirectUri, $sandbox = false)
    {
        // Creating an instance of class
        $api = new AllegroRestApi(null, $sandbox);
        
        // Returning response
        $response = $api->sendRequest($api->getAuthUrl() . "/token"
            . "?grant_type=refresh_token"
            . "&refresh_token=$refreshToken"
            . "&redirect_uri=$redirectUri",
            'POST', 
            array(), 
            array(
                'Authorization' => 'Basic ' . base64_encode("$clientId:$clientSecret")
            )
        );

        if (is_object($response) && isset($response->access_token)) {
            $api = new AllegroRestApi($response->access_token, $sandbox);
            $me = $api->get('/me');
            $response->seller_id = $me->id;
        }

        return $response;
    }

    /**
     * Stores token in class property to
     * use it in requests
     * 
     * @param   string  $value  Access token
     * @return  AllegroRestApi
     */
    public function setToken($value)
    {
        $this->token = $value;
        
        return $this;
    }

    /**
     * Returns api access token from property
     * 
     * @return  string  Access token
     */
    public function getToken()
    {
        return $this->token;
    }
    
    /**
     * Stores boolean in class property to
     * determine which environment should we use
     * 
     * @param   boolean  $value  True or false
     * @return  AllegroRestApi
     */
    public function setSandbox($value)
    {
        $this->sandbox = (boolean)$value;
        
        return $this;
    }

    /**
     * Returns boolean value which determines
     * which environment should we use
     * 
     * @return  boolean  True or false
     */
    public function getSandbox()
    {
        return $this->sandbox;
    }
    
    /**
     * Returns REST API basic URL depending
     * on current sandbox setting
     * 
     * @return  string  An URL address
     */
    public function getUrl()
    {
        // Returning correct URL depending on sandbox setting
        return $this->getSandbox() 
            ? AllegroRestApi::SANDBOX_URL 
            : AllegroRestApi::URL;
    }

    /**
     * Returns REST API AUTH URL depending
     * on current sandbox setting
     * 
     * @return  string  An URL address
     */
    public function getAuthUrl()
    {
        // Returning correct URL depending on sandbox setting
        return $this->getSandbox() 
            ? AllegroRestApi::SANDBOX_AUTH_URL 
            : AllegroRestApi::AUTH_URL;
    }

    /**
     * Returns REST API UPLOAD URL depending
     * on current sandbox setting
     * 
     * @return  string  An URL address
     */
    public function getUploadUrl()
    {
        // Returning correct URL depending on sandbox setting
        return $this->getSandbox() 
            ? AllegroRestApi::SANDBOX_UPLOAD_URL 
            : AllegroRestApi::UPLOAD_URL;
    }
    
    /**
     * Generates UUID which can be used in
     * some actions
     * 
     * @return  string  UUID
     */
    public function getUuid()
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );
    }
    
    /**
     * Sends GET request to Allegro REST API
     * and returns response
     * 
     * @param   string  $resource   Resource path
     * @param   array   $headers    Request headers
     * @return  object
     */
    public function get($resource)
    {
        return $this->sendRequest($resource, 'GET', array());
    }

    /**
     * Sends POST request to Allegro REST API
     * and returns response
     * 
     * @param   string  $resource   Resource path
     * @param   array   $data       Request body
     * @param   array   $headers    Request headers
     * @return  object
     */
    public function post($resource, array $data)
    {
        return $this->sendRequest($resource, 'POST', $data);
    }
    
    /**
     * Sends PUT request to Allegro REST API
     * and returns response
     * 
     * @param   string  $resource   Resource path
     * @param   array   $data       Request body
     * @param   array   $headers    Request headers
     * @return  object
     */
    public function put($resource, array $data)
    {
        return $this->sendRequest($resource, 'PUT', $data);
    }
    
    /**
     * Sends DELETE request to Allegro REST API
     * and returns response
     * 
     * @param   string  $resource   Resource path
     * @param   array   $headers    Request headers
     * @return  object
     */
    public function delete($resource)
    {
        return $this->sendRequest($resource, 'DELETE', array());
    }
    
    /**
     * Sends request to Allegro REST API
     * using given arguments
     * 
     * Returns API response as JSON object
     * 
     * @param   string  $resource   Resource path
     * @param   string  $method     Request method
     * @param   array   $data       Request body
     * @return  object
     */
    public function sendRequest($resource, $method, array $data = array(), array $headers = array())
    {
        self::$lastErrors = array();
        
        $headers = array_merge(array(
            'Authorization' => 'Bearer ' . $this->getToken(),
            'Content-Type' => 'application/vnd.allegro.public.v1+json',
            'Accept'          => 'application/vnd.allegro.public.v1+json',
            'Accept-Language' => 'pl-PL',
        ), $headers);

        stCommunication::forceSocketConnectionTime();

        self::$lastHeaders = array();

        $ch = curl_init(stristr($resource, 'http') !== false ? $resource : $this->getUrl() . '/' . ltrim($resource, '/'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, self::parseHeaders($headers));
        curl_setopt($ch, CURLOPT_HEADERFUNCTION, array('AllegroRestApi', 'setCurlHeaders'));
        curl_setopt($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($method));

        if ($data)
        {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }
        
        $response = curl_exec($ch);

        if (false === $response)
        {
            $error = curl_error($ch);

            self::$lastErrors = array(new stdClass());
            self::$lastErrors[0]->code = curl_errno($ch);
            self::$lastErrors[0]->message = $error;
            self::$lastErrors[0]->path = null;
            self::$lastErrors[0]->details = null;
            self::$lastErrors[0]->userMessage = $error;

            $e = new stAllegroException($error);

            if ($data)
            {
                $requestData = json_encode($data, JSON_PRETTY_PRINT);
            }

            stPayment::log('allegro', $resource . ":\nREQUEST DATA: ". $requestData . "\nRESPONSE:\n" . var_export(self::$lastHeaders, true) . "\n" . $e->getMessage() . "\n" . $e->getTraceAsString());

            throw $e;
        }

        if ($response)
        {
            $response = json_decode($response);
        }

        $info = curl_getinfo($ch);

        self::$lastHttpCode = $info['http_code'];
        self::$lastRequestInfo = $info;

        if (self::$lastHttpCode >= 400)
        {
            if (isset($response->errors))
            {
                self::$lastErrors = $response->errors;
            }

            if (isset($response->error))
            {
                self::$lastErrors = array(new stdClass());
                self::$lastErrors[0]->code = $response->error;
                self::$lastErrors[0]->message = $response->error_description;
                self::$lastErrors[0]->path = null;
                self::$lastErrors[0]->details = null;
                self::$lastErrors[0]->userMessage = $response->error_description;
            }

            if ($data)
            {
                $requestData = json_encode($data, JSON_PRETTY_PRINT);
            }

            $traceId = self::$lastHeaders['trace-id'];

            $e = new stAllegroException(self::$lastErrors ? self::$lastErrors[0]->message : $response . " (trace-id: $traceId)", self::$lastHttpCode);

            stPayment::log('allegro', $resource . ":\nREQUEST DATA: ". $requestData . "\nRESPONSE:\n" . var_export(self::$lastHeaders, true) . "\n" . $e->getMessage() . "\n" . $e->getTraceAsString());

            throw $e;
        }

        stCommunication::restoreSocketConnectionTime();
        
        return $response;
    }

    /**
     * Last Error response from Allegro REST API
     *
     * @return stdClass
     */
    public static function getLastErrors()
    {
        return self::$lastErrors;
    }

    public static function getLastRequestInfo()
    {
        return self::$lastRequestInfo;
    }

    public static function getLastHttpCode()
    {
        return self::$lastHttpCode;
    }

    protected static function setCurlHeaders($handle, $header)
    {
        $details = explode(':', $header, 2);

        if (count($details) == 2)
        {
            $key   = trim($details[0]);
            $value = trim($details[1]);

            self::$lastHeaders[$key] = $value;
        }

        return strlen($header);
    }
        
    protected static function parseHeaders(array $headers)
    {
        $result = array();

        foreach ($headers as $header => $value) 
        {    
            $result[] = "$header: $value";
        }

        return $result;
    }

    protected static function parseSellerID($access_token)
    {
        $ex = base64_decode($access_token);
        $start = strpos($ex, "{", 2);
        $end = strpos($ex, "]}", $start);
        $json = substr($ex, $start, $end - $start + 2);
        $data = json_decode($json, false);

        return $data->user_name;
    }
}
