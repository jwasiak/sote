<?php
/**
 * SOTESHOP/stPaypalPlugin
 *
 * Ten plik należy do aplikacji stPaypalPlugin opartej na licencji (Professional License SOTE).
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stPaypalPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: $
 * @author      Marcin Butlak <marcin.butlak@sote.pl>
 */

/**
 *
 * Klasa obsługi wyjątków z stPaypalCallerService
 *
 * @package     stPaypalPlugin
 * @subpackage  libs
 */
class stPaypalCallerException extends sfException
{
}

/**
 *
 * Podstawowa klasa upraszczająca tworzenie i pobieranie parametrów Paypal NVP API
 *
 * @package     stPaypalPlugin
 * @subpackage  libs
 */
abstract class stPaypalCallerBase
{
    protected $parameters = array('_ITEMS' => array());

    public function __toString()
    {
        $tmp = array();

        foreach($this->parameters as $name => $value)
        {
            if (is_array($value))
            {
                $tmp = array_merge($tmp, $value);
            }
            else
            {
                $tmp[] = strtoupper($name) . '=' . urlencode($value);
            }
        }

        return implode('&', $tmp);
    }

    public function addItem(stPaypalCallerBase $item)
    {
        $this->parameters['_ITEMS'][] = $item;
    }

    public function getItems()
    {
        return $this->parameters['_ITEMS'];
    }
    
    public function setItems($items)
    {
       $this->parameters['_ITEMS'] = $items;
    }

    public function __set($name, $value)
    {
        $name = strtoupper($name);

        $this->parameters[$name] = is_bool($value) ? intval($value) : $value;
    }

    public function __get($name)
    {
        $name = strtoupper($name);

        return array_key_exists($name, $this->parameters) ? $this->parameters[$name] : null;
    }

    public function  __call($name,  $arguments)
    {
        if (strpos($name, 'set') === 0)
        {
            $name = substr($name, 3);

            $this->$name = current($arguments);

            return $this;
        }
        elseif (strpos($name, 'get') === 0)
        {
            $name = substr($name, 3);

            return $this->$name;
        }
    }
}

/**
 *
 * Klasa upraszczająca definiowanie parametrów Paypal NVP API typu "List"
 *
 * @package     stPaypalPlugin
 * @subpackage  libs
 */
class stPaypalCallerItem extends stPaypalCallerBase
{
    private $id = 0;

    public function __construct($id, $parameters = array())
    {
        $this->parameters = $parameters;

        $this->id = $id;
    }

    public function setItemId($id)
    {
        $this->id = $id;
    }

    public function __toString()
    {
        $tmp = array();

        foreach($this->parameters as $name => $value)
        {
            $tmp[] = 'L_' . strtoupper($name). $this->id . '=' . urlencode($value);
        }

        return implode('&', $tmp);
    }
}

/**
 *
 * Klasa upraszczająca odbieranie odpowiedzi od Paypal NVP API
 *
 * @package     stPaypalPlugin
 * @subpackage  libs
 */
class stPaypalCallerResponse extends stPaypalCallerBase
{
    public function __construct($nvp)
    {
        $this->deformatNVP($nvp);
    }

    public function isSuccessful()
    {
        return $this->getAck() == 'Success' || $this->getAck() == 'SuccessWithWarning';
    }

    public function hasFailed()
    {
        return !$this->isSuccessful();
    }

    public function hasError($error_code)
    {
        foreach ($this->getItems() as $error)
        {
            if ($error->getErrorCode() == $error_code)
            {
                return true;
            }
        }

        return false;
    }

    protected function deformatNVP($nvp)
    {
        $items = array();

        $item_index = 0;

        $parameters = explode('&', $nvp);

        foreach ($parameters as $parameter)
        {
            list($name, $value) = explode('=', $parameter);

            $tmp = array();

            if (preg_match('/L_([A-Z]+)([0-9]+)/i', $name, $tmp))
            {
                if (isset($items[$item_index][$tmp[2]][$tmp[1]]) &&$tmp[2] == 0)
                {
                    $item_index++;
                }

                $items[$item_index][$tmp[2]][$tmp[1]] = urldecode($value);
            }
            else
            {
                $this->parameters[$name] = urldecode($value);
            }
        }

        foreach ($items as $item)
        {
            foreach ($item as $id => $params)
            {
                $this->addItem(new stPaypalCallerItem($id, $params));
            }
        }

        unset($list_params);
    }
}

/**
 *
 * Klasa upraszczająca tworzenie żądań do Paypal NVP API
 *
 * @package     stPaypalPlugin
 * @subpackage  libs
 */
class stPaypalCallerRequest extends stPaypalCallerBase
{
    public function  __construct($parameters = array())
    {
        foreach($this->parameters as $name => $value)
        {
            if (is_array($value))
            {
                foreach ($value as $id => $params)
                {
                    $this->addItem(new stPaypalCallerItem($id, $params));
                }
            }
            else
            {
                $this->$name = $value;
            }
        }
    }
}

/**
 *
 * Klasa upraszczająca kominukację z Paypal NVP API
 *
 * Przykład zapytania o aktualny bilans konta Paypal we wszystkich dostępnych walutach (zgodnie z specyfikacją ):
 * $paypal = stPaypalCallerService::getInstance();
 * $paypal->initialize('uzytkownik_api', 'haslo_api', 'podpis_api', 'sandbox|live');
 * $request = new stPaypalCallerRequest();
 * $request->setReturnAllCurrencies(1);
 * $response = $paypal->getBalance($request);
 * foreach ($response->getItems() as $item)
 * {
 *    echo $item->getAmt() . " " . $item->getCurrencyCode() . "<br />";
 * }
 *
 * @package     stPaypalPlugin
 * @subpackage  libs
 */
class stPaypalCallerService
{
    private $apiUsername = null;

    private $apiPassword = null;

    private $apiSignature = null;

    private $apiEnvironment = self::ENV_LIVE;

    private $apiVersion = null;

    private $baseResponseClass = self::BASE_RESPONSE_CLASS;

    protected static $instance = null;

    const ENV_LIVE = 'live';

    const ENV_SANDBOX = 'sandbox';

    const BASE_RESPONSE_CLASS = 'stPaypalCallerResponse';

    /**
     *
     * Pobiera instancję stPaypalCallerService
     *
     * @param string $base_caller_class Nazwy klasy rozszerzającej stPaypalCallerService (wymagane wyłącznie podczas rozszerzania stPaypalCallerService)
     * @return stPaypalCallerService
     */
    public static function getInstance($base_caller_class = null)
    {
        if (is_null(self::$instance))
        {
            $class = $base_caller_class ? $base_caller_class : __CLASS__;

            self::$instance = new $class();
        }

        return self::$instance;
    }

    public function  __construct()
    {
        $this->apiVersion = sfConfig::get('app_stPaypal_api_version');
    }

    public function initialize($username, $password, $signature, $params = array())
    {
        $this->apiUsername = $username;

        $this->apiPassword = $password;

        $this->apiSignature = $signature;

        if (isset($params['environment']))
        {
            $this->apiEnvironment = $params['environment'];
        }

        if (isset($params['base_response_class']))
        {
            $this->baseResponseClass = $params['base_response_class'];
        }
    }

    public function setApiUsername($username)
    {
        $this->apiUsername = $username;
    }

    public function setApiPassword($password)
    {
        $this->apiPassword = $password;
    }

    public function setApiSignature($signature)
    {
        $this->apiSignature = $signature;
    }

    public function setApiEnvironment($environment)
    {
        $this->apiEnvironment = $environment;
    }

    public function setApiVersion($apiVersion) {
        $this->apiVersion = $apiVersion;
    }

    public function getExpressCheckoutUrl($token)
    {
        $urls = sfConfig::get('app_stPaypal_urls');

        return $urls[$this->apiEnvironment] . '?cmd=_express-checkout&useraction=commit&token=' . $token;
    }

    /**
     *
     * Zmienia klase pełniącą rolę odpowiedzi od Paypal NVP API
     *
     * @param string $class_name Nazwa klasy
     */
    public function setBaseResponseClass($class_name)
    {
        $this->baseResponseClass = $class_name;
    }

    /**
     *
     * Wykonuje żądanie za pośrednictwem Paypal NVP API
     *
     * @param string $method Nazwa metody Paypal API
     * @param stPaypalCallerRequest $request Parametry żądania
     * @return stPaypalCallerResponse
     */
    public function __call($name, $arguments)
    {
        if (is_array($arguments[0]))
        {
            $request = new stPaypalCallerRequest($arguments[0]);
        }
        elseif (is_object($arguments[0]) && $arguments[0] instanceof stPaypalCallerRequest)
        {
            $request = clone $arguments[0];
        }
        else
        {
            throw new stPaypalCallerException('You must pass a stPaypalCallerRequest object or an array of Paypal parameters');
        }

        $request->setMethod($name);

        $request->setUser($this->apiUsername);

        $request->setPwd($this->apiPassword);

        $request->setSignature($this->apiSignature);

        $request->setVersion($this->apiVersion);

        $endpoints = sfConfig::get('app_stPaypal_api_endpoints');

        if (!isset($endpoints[$this->apiEnvironment]))
        {
            throw new stPaypalCallerException(sprintf('There is no "%s" environment, available enviroments: "%s"', $this->apiEnvironment, implode(", ",array_flip($endpoints))));
        }

        $response = self::curlCall($endpoints[$this->apiEnvironment], strval($request));

        $responseObject = new $this->baseResponseClass($response);


        if (sfConfig::get('sf_debug') && $responseObject->hasFailed())
        {
            sfLogger::getInstance()->err('{Paypal} '.var_export($responseObject->getItems(), true));
        }

        return $responseObject;
    }

    /**
     *
     * Metoda pomocnicza do obsługi żądań metodą POST
     *
     * @param string $url Adres żądania
     * @param string $postfields Parametry POST żądania
     * @return string Odpowiedź
     */
    public static function curlCall($url, $postfields)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_VERBOSE, false);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        // curl_setopt($ch, CURLOPT_SSLVERSION, 3);        

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_POST, 1);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);

        $response = curl_exec($ch);

        if (curl_errno($ch))
        {
            throw new stPaypalCallerException(curl_error($ch), curl_errno($ch));
        }

        curl_close($ch);

        return $response;
    }
}
