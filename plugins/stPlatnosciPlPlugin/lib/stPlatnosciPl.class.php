<?php
/**
 * SOTESHOP/stPlatnosciPlPlugin
 *
 * Ten plik należy do aplikacji stPlatnosciPlPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stPlatnosciPlPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stPlatnosciPl.class.php 12825 2011-05-17 13:27:06Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Adres Płatności.pl
 */
define('PLATNOSCIPL_URL', 'https://www.platnosci.pl/paygw/UTF/');

/**
 * Klasa stPlatnosciPl
 *
 * @package     stPlatnosciPlPlugin
 * @subpackage  libs
 */
class stPlatnosciPl implements stPaymentInterface
{
    /**
     * Tablica z konfiguracją
     * @var array
     */
    private $config = array();

    private $valid = false;

    /**
     * Konstruktor - ładownianie konfiguracji
     */
    public function __construct()
    {
        $this->initialize();
    }

    public function getLogoPath()
    {
        return '/plugins/stPlatnosciPlPlugin/images/payu.png';
    }

    public function isAutoRedirectEnabled()
    {
        return stConfig::getInstance('stPlatnosciPlBackend')->get('autoredirect');
    }

    public function initialize($currency = null)
    {
        $config = stPaymentType::getConfiguration(__CLASS__);
        $this->currency = $currency ? $currency : stCurrency::getInstance(sfContext::getInstance())->get()->getShortcut();
        $this->valid = isset($config['configuration_check']) && $config['configuration_check'];

        if ($this->valid)
        {
            $this->config = isset($config[$this->currency]['enabled']) ? $config[$this->currency] : array();

            if ($this->config)
            {
                OpenPayU_Configuration::setEnvironment('secure');
                OpenPayU_Configuration::setMerchantPosId($this->config['pos_id']); // POS ID (Checkout)
                OpenPayU_Configuration::setSignatureKey($this->config['md5_secound_key']); //Second MD5 key. You will find it in admin panel. 
            }
        }       
    }

    /**
     * Obsługa funkcji call 
     *
     * @param $method
     * @param $arguments
     * @return mixed string/bool
     */
    public function __call($method, $arguments)
    {
        return stPaymentType::call($method, $this->config);
    }

    public function getOrderFormurl(Order $order)
    {
        $sf_context = sfContext::getInstance();
        $controller = $sf_context->getController();
        $i18n = $sf_context->getI18N();
        $lang = strtolower(stPaymentType::getLanguage());
        $request = $sf_context->getRequest();

        sfLoader::loadHelpers(array('Helper', 'stUrl'));


        $data['notifyUrl'] = $controller->genUrl('@stPlatnosciPlPlugin?action=statusReport&id='.$order->getId().'&hash='.$order->getHashCode(), true);
        $data['continueUrl'] = $controller->genUrl('@stPlatnosciPlPlugin?action=returnSuccess', true);

        $data['customerIp'] = $_SERVER['REMOTE_ADDR'];
        $data['merchantPosId'] = OpenPayU_Configuration::getMerchantPosId();
        $data['description'] = $i18n->__("Zamówienie nr", null, 'stOrder').' '.$order->getNumber();
        $data['additionalDescription'] = "SOTE";
        $data['currencyCode'] = $this->currency;
        $data['totalAmount'] = intval(stPrice::round($order->getUnpaidAmount() * 100, 0));
        $data['extOrderId'] = $order->getNumber() . ' - ' . time();

        $data['products'] = array(
            array(
                'name' => $data['description'],
                'unitPrice' => $data['totalAmount'],
                'quantity' => 1,
            )
        );

        $data['buyer']['email'] = $order->getOptClientEmail();
        list($first, $last) = explode(' ', $order->getOptClientName(), 2);
        $data['buyer']['firstName'] = $first;
        $data['buyer']['lastName'] = $last;
        $data['buyer']['language'] = $lang;

        $result = OpenPayU_Order::create($data);  

        if ($result->getStatus() == 'SUCCESS')
        {
            $redirect = $result->getResponse()->redirectUri.'&lang='.$lang;
            
            self::log("stPlatnosciPL::getOrderFromUrl() - Redirect: ".$redirect);

            return $redirect; 
        }

        self::log("stPlatnosciPL::getOrderFromUrl():\n".var_export($result, true));
        
        return null;
    }

    public function getOrderNotify($data)
    {
        if (!empty($data)) 
        {
            $result = OpenPayU_Order::verifyResponse(array('response' => $data, 'code' => 200), 'OrderNotifyRequest');

            if ($result && $result->getResponse()->order)
            {
                $this->initialize($result->getResponse()->order->currencyCode);
            }

            $result = OpenPayU_Order::consumeNotification($data);

            if ($result->getResponse()->order->orderId) 
            {
                /* Check if OrderId exists in Merchant Service, update Order data by OrderRetrieveRequest */
                $order = OpenPayU_Order::retrieve($result->getResponse()->order->orderId);               

                if($order->getStatus() == 'SUCCESS')
                {
                    return $result->getResponse()->order;
                }
            } 
        } 

        return null;  
    }

    /**
     * Sprawdzenie czy płatność została skonfiguraowana
     *
     * @return   bool
     */
    public function checkPaymentConfiguration()
    {
        if (SF_APP == 'frontend' && !$this->config)
        {
            return false;
        }

        return $this->valid;
    }

    public static function log($message)
    {
        stPayment::log("payu", $message);
    }
}