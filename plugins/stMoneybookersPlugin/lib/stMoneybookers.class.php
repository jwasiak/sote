<?php
/**
 * SOTESHOP/stMoneybookersPlugin
 *
 * Ten plik należy do aplikacji stMoneybookersPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stMoneybookersPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stMoneybookers.class.php 6634 2010-07-20 11:02:34Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Adres url płatności Moneybookers
 */
define('MONEYBOOKERS_URL', 'https://www.moneybookers.com/app/payment.pl');

/**
 * Klasa pomocnicza do obsługi płatności Moneybookers
 *
 * @package stMoneybookersPlugin
 * @subpackage libs
 */
class stMoneybookers
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
     * @param float $orderAmountBrutto
     * @return integer
     */
    public function getOrderAmount($orderAmountBrutto)
    {
        return number_format($orderAmountBrutto, 2, '.', '');
    }

    /**
     * Zwracanie adresu url serwisu moneybookers
     *
     * @return string
     */
    public function getUrl()
    {
        return MONEYBOOKERS_URL;
    }

    /**
     * Sprawdzenie czy płatność została skonfiguraowana
     *
     * @return bool
     */
    public function checkPaymentConfiguration()
    {
        if (!$this->hasPayToEmail()) return false;
        return true;
    }
    
    public function getShopDescription()
    {
    	$description = trim($this->config['shop_description']);
    	if (!empty($description)) return $description;
    	
    	$stWebRequest = new stWebRequest();
    	return sfContext::getInstance()->getI18n()->__('sklepu').' '.$stWebRequest->getHost();
    }
}