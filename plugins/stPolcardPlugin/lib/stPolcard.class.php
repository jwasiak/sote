<?php
/**
 * SOTESHOP/stPolcardPlugin
 *
 * Ten plik należy do aplikacji stPolcardPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stPolcardPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stPolcard.class.php 12831 2011-05-17 14:14:04Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Adres Polcard
 */
define('POLCARD_URL', 'https://post.polcard.com.pl/cgi-bin/autoryzacja.cgi');
define('POLCARD_URL_E_KARTA', 'https://vpos.polcard.com.pl/vpos/ecom/service.htm');

/**
 * Klasa stPolcard
 *
 * @package     stPolcardPlugin
 * @subpackage  libs
 */
class stPolcard
{
    /**
     * Tablica z konfiguracją
     * @var array
     */
    private $config = array();

    /**
     * Konstruktor - ładownianie konfiguracji
     */
    public function __construct()
    {
        $this->config = stPaymentType::getConfiguration(__CLASS__);
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

    /**
     * Zwracanie adresu Url
     *
     * @return   string
     */
    public function getUrl()
    {
   	    return "https://vpos.polcard.com.pl/vpos/ecom/service.htm";
    }

    public function getFormParams(Order $order)
    {
        $lang = strtolower(stPaymentType::getLanguage(array('PL', 'EN', 'DE', 'RU', 'FR', 'IT', 'ES', 'PT')));

        $params = array(
            'pos_id' => $this->getPosId(),
            'order_id' => $order->getNumber(),
            'session_id' => hash("sha256", $this->getSharedKey().uniqid()),
            'amount' => $order->getUnpaidAmount() * 100,
            'currency' => $order->getOrderCurrency()->getShortcut(),
            'test' => $this->getTest() ? "Y" : "N",
            'language' => $lang,
            'client_ip' => $_SERVER['REMOTE_ADDR'],
            'country' => $order->getOrderUserDataBilling()->getCountry()->getIsoA2(),
            'email' => $order->getOptClientEmail(),
        );

        $params['controlData'] = $this->getRequestControlData($params);

        return $params;
    }

    public function isValid($params)
    {
        return isset($params['controlData']) && $this->getResponseControlData($params) == $params['controlData'];
    }

    /**
     * Sprawdzenie czy płatność została skonfiguraowana
     *
     * @return   bool
     */
    public function checkPaymentConfiguration()
    {
        if (!$this->hasPosID()) return false;
        if (SF_APP == 'frontend') 
        {
            $context = sfContext::getInstance();
            return stCurrency::getInstance($context)->get()->getShortcut() == 'PLN' && in_array($context->getUser()->getCulture(), array('pl_PL', 'en_US', 'de', 'ru', 'fr', 'it', 'es', 'pt'));
        }
        
        return true;
    }

    public function getRequestControlData($params)
    {
        $accept = array("pos_id", "payment_method", "channel_code", "order_id", "session_id", "amount", "currency", "test", "language", "client_ip", "street", "street_n1", "street_n2", "addr2", "addr3", "city", "postcode", "country", "email", "ba_firstname", "ba_lastname", "merchant_label");

        return $this->getControlData($params, $accept);
    }

    public function getResponseControlData($params)
    {
        $accept = array("pos_id", "order_id", "session_id", "amount", "response_code", "transaction_id", "cc_number_hash", "bin", "card_type", "auth_code");

        return $this->getControlData($params, $accept);
    }
    
    public function getControlData($params, $accept) 
    {
        $salt = $this->getSharedKey();
        $hexLenght = strlen($salt);
        $saltBin = "";
        for ($x = 1; $x <= $hexLenght/2; $x++)
            $saltBin .= (pack("H*", substr($salt,2 * $x - 2,2)));
     
        $paramsChain = array();

        foreach ($accept as $param) 
        {
            if (isset($params[$param]) && $params[$param])
            {
                $paramsChain[] = $param."=".$params[$param];
            }
        }        

        return hash("sha256", implode("&", $paramsChain).$saltBin);
    }
}