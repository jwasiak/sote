<?php
/**
 * SOTESHOP/stLukasPlugin
 *
 * Ten plik należy do aplikacji stLukasPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stLukasPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stLukas.class.php 10 2009-08-24 09:32:18Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa pomocnicza do obsługi płatności Lukas
 *
 * @package stLukasPlugin
 * @subpackage libs
 */
class stLukas
{
    /**
     * Adres serwisu Lukas
     *
     * @var string
     */
    const LUKAS_URL = "https://ewniosek.credit-agricole.pl/eWniosek/";

    /**
     * Adres pliku wsdl serwisu Lukas
     *
     * @var string
     */
    const LUKAS_WSDL_URL = "https://ewniosek.credit-agricole.pl/eWniosek/services/FormSetup?wsdl";

    /**
     * Typ generowania linku ORDER
     *
     * @var int
     */
    const TYPE_ORDER = 0;

    /**
     * Typ generowania linku PRODUCT
     *
     * @var int
     */
    const TYPE_PRODUCT = 1;

    /**
     * Tablica z konfiguracją
     *
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
     * Pobieranie nazwy sklepu
     *
     * @return string
     */
    public function getShopName()
    {
        $name = trim($this->config['shop_name']);
        if (!empty($name)) return $name;

        $stWebRequest = new stWebRequest();
        return $stWebRequest->getHost();
    }

    /**
     * Sprawdzenie czy płatność została skonfiguraowana
     *
     * @return bool
     */
    public function checkPaymentConfiguration()
    {
        if (!$this->hasParamProfile()) return false;

        if (SF_APP == 'frontend')
        {
            $ids = array();
            foreach (stBasket::getInstance(sfContext::getInstance()->getUser())->getItems() as $p) $ids[] = $p->getProductId();
            
            $c = new Criteria();
            $c->add(LukasProductPeer::PRODUCT_ID, $ids, Criteria::IN);
            $c->add(LukasProductPeer::DISABLE, 1);
            $count = LukasProductPeer::doCount($c);
            
            if ($count) return false;

            if (stCurrency::getInstance(sfContext::getInstance())->get()->getShortcut() != "PLN") return false;
            
            // remove discount 
            //if (stBasket::getInstance(sfContext::getInstance()->getUser())->hasDiscount()) return false;
        }

        return true;
    }

    /**
     * Gerenowanie linku na podstawie parametów
     *
     * @param array $parameters
     * @return string
     */
    public function generateUrl($parameters = array())
    {
        $url = stLukas::LUKAS_URL;
        if (isset($parameters['simulate'])) $url.= 'simulator.jsp';
        if (isset($parameters['procedure'])) $url.= 'procedure.jsp';
        $url.= '?PARAM_TYPE=RAT';
        $url.= '&PARAM_PROFILE='.$this->getParamProfile();
        if (isset($parameters['amount'])) $url.= '&PARAM_CREDIT_AMOUNT='.$parameters['amount'];
        if (isset($parameters['param_setup'])) $url.= '&PARAM_SETUP='.$parameters['param_setup'];
        return $url;
    }

    /**
     * Sprawdzanie czy płatność jest aktywna i skonfigurowana
     *
     * @return bool
     */
    public static function isActive()
    {
        if (!PaymentTypePeer::isActive('stLukas')) return false; 

        $stLukas = new stLukas();
        if (!$stLukas->checkPaymentConfiguration()) return false;
        return true;
    }

    /**
     * Sprawdzanie czy można zakupić produkt za pośrednictwem systemu Lukas  
     *
     * @param $product
     * @return bool
     */
    public static function showInProduct($product) {
        if (stCurrency::getInstance(sfContext::getInstance())->get()->getShortcut() != "PLN") return false;

        $lukasProduct = LukasProductPeer::doSelectByProduct($product);
        if (is_object($lukasProduct) && $lukasProduct->getDisable())
            return false;

        if ($product->getPriceBrutto() < 500.0)
            return false;
        
        if($product->getHidePrice())
            return false;

        return true;
    }
}
