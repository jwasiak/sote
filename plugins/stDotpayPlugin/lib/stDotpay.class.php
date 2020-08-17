<?php
/**
 * SOTESHOP/stDotpayPlugin
 *
 * Ten plik należy do aplikacji stDotpayPlugin opartej na licencji (Professional License SOTE).
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stDotpayPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stDotpay.class.php 12828 2011-05-17 14:03:05Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */
/**
 * Adres url płatności Dotpay
 */
define('DOTPAY_URL', 'https://ssl.dotpay.pl/t2');

/**
 * Klasa stDotpay
 *
 * @package     stDotpayPlugin
 * @subpackage  libs
 */
class stDotpay
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
     * Przeliczanie kwoty zamówień i zwracanie jej w ustalonym formacie
     *
     * @param         float       $orderAmountBrutto
     * @return   integer
     */
    public function getOrderAmount( $orderAmountBrutto )
    {
        return number_format($orderAmountBrutto,2, '.', '');
    }

    /**
     * Zwracanie adresu url serwisu dotpay.pl
     *
     * @return   string
     */
    public function getUrl()
    {
        return !$this->getTest() ? 'https://ssl.dotpay.pl/t2/' : 'https://ssl.dotpay.pl/test_payment/';
    }

    /**
     * Zwracanie adresów ip serwisu dotpay.pl
     *
     * @return   mixed
     */
    public function getIpAddresses()
    {
        return $this->ipAddresses;
    }

    /**
     * Zwracanie kanałów płatności
     *
     * @return   array
     */
    public function getChannels()
    {
        $i18n = sfContext::getInstance()->getI18N();
        $channels = array();
        foreach($this->channels as $channel)
        {
            $channels[] = $i18n->__($channel);
        }
        return $channels;
    }

    public function getParams(Order $order)
    {
        $controller = sfContext::getInstance()->getController();
        $lang = strtolower(stPaymentType::getLanguage());
        $user = $order->getOrderUserDataBilling();
        $params = array(
            'api_version' => 'dev',
            'id' => $this->getDotpayId(),
            'amount' => $this->getOrderAmount(stPayment::getUnpayedAmountByOrder($order)),
            'currency' => $order->getOrderCurrency()->getShortcut(),
            'description'=> __('Zamówienie nr', null, 'stDotpayFrontend').' '.$order->getNumber(),
            'lang' => $lang,
            // 'channel' => $this->getDefaultChannel(),
            // 'ch_lock' => $this->getLockChannel(),
            // 'onlinetransfer' => $this->getCheckChannel(),
            'URL' => $controller->genUrl('@stDotpayPlugin?action=return', true),
            'type' => '3',
            'buttontext' => $this->getButtonBackText(),
            'URLC' => $controller->genUrl('@stDotpayPlugin?action=statusReport&order_id='.$order->getId().'&hash='.$order->getHashCode(), true),
            'firstname' => $user->getName(),
            'lastname' => $user->getSurname(),
            'email' => $order->getGuardUser()->getUsername(),
            'street' => $user->getStreet(),
            'street_n1' => $user->getHouse(),
            'street_n2' => $user->getFlat(),
            'city' => $user->getTown(),
            'postcode' => $user->getCode(),
            'country' => $user->getCountry()->getIsoA3(),
            'p_info' => htmlspecialchars($this->getShopName()),
        );

        $params['chk'] = $this->generateChk($this->getPin(), $params);        

        return $params;
    }

    public function verifySignature(sfRequest $request)
    {
     
        $sign=
            $this->getPin().
            $request->getParameter('id', '').
            $request->getParameter('operation_number', '').
            $request->getParameter('operation_type', '').
            $request->getParameter('operation_status', '').
            $request->getParameter('operation_amount', '').
            $request->getParameter('operation_currency', '').
            $request->getParameter('operation_withdrawal_amount', '').
            $request->getParameter('operation_commission_amount', '').
            $request->getParameter('operation_original_amount', '').
            $request->getParameter('operation_original_currency', '').
            $request->getParameter('operation_datetime', '').
            $request->getParameter('operation_related_number', '').
            $request->getParameter('control', '').
            $request->getParameter('description', '').
            $request->getParameter('email', '').
            $request->getParameter('p_info', '').
            $request->getParameter('p_email', '').
            $request->getParameter('credit_card_issuer_identification_
            number', '').
            $request->getParameter('credit_card_masked_number', '').
            $request->getParameter('credit_card_brand_codename', '').
            $request->getParameter('credit_card_brand_code', '').
            $request->getParameter('credit_card_id', '').
            $request->getParameter('channel', '').
            $request->getParameter('channel_country', '').
            $request->getParameter('geoip_country', '');
        return $request->getParameter('signature') == hash('sha256', $sign);        
    }

    public function generateChk($DotpayPin, $ParametersArray) 
    {
        $ChkParametersChain =
        $DotpayPin.
        (isset($ParametersArray['api_version']) ?
        $ParametersArray['api_version'] : null).
        (isset($ParametersArray['charset']) ?
        $ParametersArray['charset'] : null).
        (isset($ParametersArray['lang']) ?
        $ParametersArray['lang'] : null).
        (isset($ParametersArray['id']) ?
        $ParametersArray['id'] : null).
        (isset($ParametersArray['amount']) ?
        $ParametersArray['amount'] : null).
        (isset($ParametersArray['currency']) ?
        $ParametersArray['currency'] : null).
        (isset($ParametersArray['description']) ?
        $ParametersArray['description'] : null).
        (isset($ParametersArray['control']) ?
        $ParametersArray['control'] : null).
        (isset($ParametersArray['channel']) ?
        $ParametersArray['channel'] : null).
        (isset($ParametersArray['credit_card_brand']) ?
        $ParametersArray['credit_card_brand'] : null).
        (isset($ParametersArray['ch_lock']) ?
        $ParametersArray['ch_lock'] : null).
        (isset($ParametersArray['channel_groups']) ?
        $ParametersArray['channel_groups'] : null).
        (isset($ParametersArray['onlinetransfer']) ?
        $ParametersArray['onlinetransfer'] : null).
        (isset($ParametersArray['URL']) ?
        $ParametersArray['URL'] : null).
        (isset($ParametersArray['type']) ?
        $ParametersArray['type'] : null).
        (isset($ParametersArray['buttontext']) ?
        $ParametersArray['buttontext'] : null).
        (isset($ParametersArray['URLC']) ?
        $ParametersArray['URLC'] : null).
        (isset($ParametersArray['firstname']) ?
        $ParametersArray['firstname'] : null).
        (isset($ParametersArray['lastname']) ?
        $ParametersArray['lastname'] : null).
        (isset($ParametersArray['email']) ?
        $ParametersArray['email'] : null).
        (isset($ParametersArray['street']) ?
        $ParametersArray['street'] : null).
        (isset($ParametersArray['street_n1']) ?
        $ParametersArray['street_n1'] : null).
        (isset($ParametersArray['street_n2']) ?
        $ParametersArray['street_n2'] : null).
        (isset($ParametersArray['state']) ?
        $ParametersArray['state'] : null).
        (isset($ParametersArray['addr3']) ?
        $ParametersArray['addr3'] : null).
        (isset($ParametersArray['city']) ?
        $ParametersArray['city'] : null).
        (isset($ParametersArray['postcode']) ?
        $ParametersArray['postcode'] : null).
        (isset($ParametersArray['phone']) ?
        $ParametersArray['phone'] : null).
        (isset($ParametersArray['country']) ?
        $ParametersArray['country'] : null).
        (isset($ParametersArray['code']) ?
        $ParametersArray['code'] : null).
        (isset($ParametersArray['p_info']) ?
        htmlspecialchars_decode($ParametersArray['p_info']) : null).
        (isset($ParametersArray['p_email']) ?
        $ParametersArray['p_email'] : null).
        (isset($ParametersArray['n_email']) ?
        $ParametersArray['n_email'] : null).
        (isset($ParametersArray['expiration_date']) ?
        $ParametersArray['expiration_date'] : null).
        (isset($ParametersArray['recipient_account_number']) ?
        $ParametersArray['recipient_account_number'] : null).
        (isset($ParametersArray['recipient_company']) ?
        $ParametersArray['recipient_company'] : null).
        (isset($ParametersArray['recipient_first_name']) ?
        $ParametersArray['recipient_first_name'] : null).
        (isset($ParametersArray['recipient_last_name']) ?
        $ParametersArray['recipient_last_name'] : null).
        (isset($ParametersArray['recipient_address_street']) ?
        $ParametersArray['recipient_address_street'] : null).
        (isset($ParametersArray['recipient_address_building']) ?
        $ParametersArray['recipient_address_building'] : null).
        (isset($ParametersArray['recipient_address_apartment']) ?
        $ParametersArray['recipient_address_apartment'] : null).
        (isset($ParametersArray['recipient_address_postcode']) ?
        $ParametersArray['recipient_address_postcode'] : null).
        (isset($ParametersArray['recipient_address_city']) ?
        $ParametersArray['recipient_address_city'] : null).
        (isset($ParametersArray['warranty']) ?
        $ParametersArray['warranty'] : null).
        (isset($ParametersArray['bylaw']) ?
        $ParametersArray['bylaw'] : null).
        (isset($ParametersArray['personal_data']) ?
        $ParametersArray['personal_data'] : null).
        (isset($ParametersArray['credit_card_number']) ?
        $ParametersArray['credit_card_number'] : null).
        (isset($ParametersArray['credit_card_expiration_date_year']) ?
        $ParametersArray['credit_card_expiration_date_year'] : null).
        (isset($ParametersArray['credit_card_expiration_date_month']) ?
        $ParametersArray['credit_card_expiration_date_month'] : null).
        (isset($ParametersArray['credit_card_security_code']) ?
        $ParametersArray['credit_card_security_code'] : null).
        (isset($ParametersArray['credit_card_store']) ?
        $ParametersArray['credit_card_store'] : null).
        (isset($ParametersArray['credit_card_store_security_code']) ?
        $ParametersArray['credit_card_store_security_code'] : null).
        (isset($ParametersArray['credit_card_customer_id']) ?
        $ParametersArray['credit_card_customer_id'] : null).
        (isset($ParametersArray['credit_card_id']) ?
        $ParametersArray['credit_card_id'] : null).
        (isset($ParametersArray['blik_code']) ?
        $ParametersArray['blik_code'] : null).
        (isset($ParametersArray['credit_card_registration']) ?
        $ParametersArray['credit_card_registration'] : null).
        (isset($ParametersArray['recurring_frequency']) ?
        $ParametersArray['recurring_frequency'] : null).
        (isset($ParametersArray['recurring_interval']) ?
        $ParametersArray['recurring_interval'] : null).
        (isset($ParametersArray['recurring_start']) ?
        $ParametersArray['recurring_start'] : null).
        (isset($ParametersArray['recurring_count']) ?
        $ParametersArray['recurring_count'] : null);

        // throw new Exception($ChkParametersChain);
        

        return hash('sha256', $ChkParametersChain);
    }

    /**
     * Sprawdzenie czy płatność została skonfiguraowana
     *
     * @return   bool
     */
    public function checkPaymentConfiguration()
    {
        if (!$this->hasDotpayId()) return false;
        if (!$this->hasPin()) return false;
        if (SF_APP == 'frontend')
        {
            $currencies = array('PLN', 'EUR', 'USD', 'GBP', 'JPY', 'CZK', 'SEK');
            if (!in_array(stCurrency::getInstance(sfContext::getInstance())->get()->getShortcut(), $currencies)) return false;
        }
        return true;
    }
    
    public function getButtonBackText() {
        $config = stConfig::getInstance('stDotpayBackend');
        $config->setCulture(sfContext::getInstance()->getUser()->getCulture());
        return $config->get('button_back_text', null, true);
    }

    public function getShopName() {
        $config = stConfig::getInstance('stDotpayBackend');
        $config->setCulture(sfContext::getInstance()->getUser()->getCulture());
        return $config->get('shop_name', null, true);
    }
}
