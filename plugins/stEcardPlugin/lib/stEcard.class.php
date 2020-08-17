<?php
/**
 * SOTESHOP/stEcardPlugin
 *
 * Ten plik należy do aplikacji stEcardPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stEcardPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stEcard.class.php 10 2009-08-24 09:32:18Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Adresy url płatności eCard
 */
define("ECARD_HASH_URL","https://pay.ecard.pl:443/servlet/HS");
define("ECARD_POST_URL","https://pay.ecard.pl/payment/PS");
define("ECARD_POST_URL_TEST","https://pay.ecard.pl/servlet/PSTEST");

/**
 * Klasa stEcard
 *
 * @package     stEcardPlugin
 * @subpackage  libs
 */
class stEcard
{
    protected $params = null; 
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

    public static function getPostSecureHash()
    {
        return stSecureToken::generate(array('123456789'));
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
    public function getOrderAmount($orderAmountBrutto)
    {
        return number_format($orderAmountBrutto,2, '.', '')*100;
    }

    /**
     * Zwracanie adresu url serwisu dotpay.pl
     *
     * @return   string
     */
    public function getUrl()
    {
        return ECARD_POST_URL;
    }

    /**
     * Zwracanie adresu url serwisu dotpay.pl
     *
     * @return   string
     */
    public function getTestUrl()
    {
        return ECARD_POST_URL_TEST;
    }

    /**
     * Zwracanie adresu url serwisu dotpay.pl
     *
     * @return   string
     */
    public function getHashUrl()
    {
        return ECARD_HASH_URL;
    }

    public function getPaymentParams(Order $order)
    {
        if (null === $this->params)
        {
            sfLoader::loadHelpers(array('Helper', 'stUrl'));
            $user = $order->getOrderUserDataBilling();
            $i18n = sfContext::getInstance()->getI18N();

            $params = array(
                "MERCHANTID" => $this->getEcardId(),
                "ORDERNUMBER" => $this->getTransactionId($order),
                "AMOUNT" => $order->getUnpaidAmount() * 100,
                "CURRENCY" => stPaymentType::getCurrency($order)->getCode(),
                "ORDERDESCRIPTION" => $i18n->__("Zamówienie nr", null, 'stOrder').' '.$order->getNumber(),
                "NAME" => $user->getName(),
                "SURNAME" => $user->getSurname(),
                "AUTODEPOSIT" => "1",
                "PAYMENTTYPE" => "ALL",
                "RETURNLINK" => st_url_for('@homepage', true),            
            );

            $hash_params = array_values($params);
            $hash_params[] = $this->getEcardPassword();

            $params["HASH"] = md5(implode('', $hash_params));
            $params["HASHALGORITHM"] = "MD5";
            $params["COUNTRY"] = "616";
            $params["LANGUAGE"] = stPaymentType::getLanguage(array('PL', 'EN', 'DE', 'FR', 'RU', 'CZ', 'IT', 'ES'));
            $params["CHARSET"] = "UTF-8";
            $this->params = $params;
        }

        return $this->params;
    } 

    /**
     * Sprawdzenie czy płatność została skonfiguraowana
     *
     * @return   bool
     */
    public function checkPaymentConfiguration()
    {
        if (!$this->hasEcardId()) return false;
        if (!$this->hasEcardPassword()) return false;
        return true;
    }

    public static function getServiceTransactionId(Payment $payment)
    {
        $order = $payment->getOrder();

        $c = new Criteria();
        $c->addSelectColumn(EcardTransactionPeer::ID);
        $c->addDescendingOrderByColumn(EcardTransactionPeer::ID);
        $c->add(EcardTransactionPeer::ORDER_ID, $order->getId());
        
        $results = array();

        $rs = EcardTransactionPeer::doSelectRS($c);

        while($rs->next())
        {
            $row = $rs->getRow();
            $results[] = $row[0];
        }

        return implode(", ", $results);
    }

    protected function getTransactionId(Order $order)
    {
        $transaction = new EcardTransaction();

        $config = stConfig::getInstance('stEcardBackend');

        if (!$config->get('transaction_fix') && !EcardTransactionPeer::doCount(new Criteria()))
        {
            $c = new Criteria();
            $c->addSelectColumn('MAX('.OrderPeer::ID.')');
            $rs = OrderPeer::doSelectRS($c);

            $row = $rs->next() ? $rs->getRow() : null;

            $transaction->setId($row ? $row[0] + 1 : 1);

            $config->set('transaction_fix', true);

            $config->save();
        }

        $transaction->setOrderId($order->getId());

        $transaction->save();

        return $transaction->getId();
    }
}