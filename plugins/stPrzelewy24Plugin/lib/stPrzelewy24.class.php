<?php

/**
 * SOTESHOP/stPrzelewy24Plugin
 *
 * Ten plik należy do aplikacji stPrzelewy24Plugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stPrzelewy24Plugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id$
 * @author      Marcin Butlak <marcin.butlak@sote.pl>
 */

/**
 * Adres Przelewy24
 */
define('PRZELEWY24_URL', 'https://secure.przelewy24.pl/index.php');

define('PRZELEWY24_URL_TEST', 'https://sandbox.przelewy24.pl/index.php');

/**
 * Klasa stPrzelewy24
 *
 * @package     stPrzelewy24Plugin§
 * @subpackage  libs
 */
class stPrzelewy24 implements stPaymentInterface
{
    /**
     * Tablica z konfiguracją
     * @var array
     */
    private $config = array();

    private $context = null;

    private $currency = null;

    /**
     * Konstruktor - ładownianie konfiguracji
     */
    public function __construct()
    {
        $this->config = stPaymentType::getConfiguration(__CLASS__);
        $this->api = new Przelewy24($this->getPrzelewy24Id(), $this->getPrzelewy24Id(), $this->getSalt(), $this->getTest());
        $this->context = sfContext::getInstance();
        $this->currency = stCurrency::getInstance($this->context)->get();
    }

    public function getLogoPath()
    {
        return '/plugins/stPrzelewy24Plugin/images/logo.png';
    }

    public function isAutoRedirectEnabled()
    {
        return $this->getAutoredirect();
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

    public function getPaymentUrl(Order $order)
    {
        $i18n = $this->context->getI18N();
        $controller = $this->context->getController();
        $client = $order->getOrderUserDataBilling();
        $country = $client->getCountry();
        $currency = $order->getOrderCurrency();
        $p24_description = $i18n->__("Zamówienie nr", null, 'stOrder').' '.$order->getNumber();
        $this->api->addValue("p24_amount", $order->getUnpaidAmount() * 100);
        $this->api->addValue("p24_currency", $currency->getShortcut());
        $this->api->addValue("p24_description", $p24_description);
        $this->api->addValue("p24_email", $order->getOptClientEmail());
        $this->api->addValue("p24_session_id", $order->getId().':'.uniqid());


        $this->api->addValue("p24_client", $order->getOptClientName());
        $this->api->addValue("p24_address", $client->getAddress());
        $this->api->addValue("p24_zip", $client->getCode());
        $this->api->addValue("p24_city", $client->getTown());
        $this->api->addValue("p24_country", $country ? $country->getIsoA2() : null);
        $this->api->addValue("p24_language", strtolower(stPaymentType::getLanguage()));

        $this->api->addValue("p24_encoding", "UTF-8");

        $this->api->addValue("p24_url_return", $controller->genUrl('@stPrzelewy24Plugin?action=returnSuccess', true));
        $this->api->addValue("p24_url_status", $controller->genUrl('@stPrzelewy24Plugin?action=status&id='.$order->getId().'&hash='.$order->getHashCode(), true)); 

        $res = $this->api->trnRegister(false);

        if ($res['error'])
        {
            if (sfConfig::get('sf_debug'))
            {
                throw new Exception($res['error'] . ' - '. $res['errorMessage']);
            }
        }
        else
        {
            return $this->api->trnRequest($res['token'], false);
        }

        return null;
    }

    public function verify(Order $order, sfRequest $request)
    {        
        $this->api->addValue('p24_session_id', $request->getParameter('p24_session_id'));
        $this->api->addValue('p24_order_id', $request->getParameter('p24_order_id'));
        $this->api->addValue('p24_currency', $order->getOrderCurrency()->getShortcut());
        $this->api->addValue('p24_amount', $order->getUnpaidAmount() * 100);

        $res = $this->api->trnVerify();

        if (isset($res['error']) && !$res['error'])
        {
            return true;
        }
        else
        {
            throw new Exception($res['error'] . ' - '. $res['errorMessage']);
        }
        
        return false;
    }

    /**
     * Sprawdzenie czy płatność została skonfiguraowana
     *
     * @return   bool
     */
    public function checkPaymentConfiguration()
    {
        return $this->hasPrzelewy24Id() && $this->hasSalt() || SF_APP == 'frontend' && in_array($this->currency->getShortcut(), array("PLN", "EUR", "GBP", "CZK"));
    }
}