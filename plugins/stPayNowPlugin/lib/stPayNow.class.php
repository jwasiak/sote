<?php 

require __DIR__ . '/../vendor/autoload.php';

class stPayNow implements stPaymentInterface
{
    /**
     * Konfiguracja płatności
     *
     * @var stConfig
     */
    protected $config;

    /**
     * Ostatni błąd płatności
     *
     * @var string
     */
    protected $lastError = null;

    public function __construct()
    {
        $this->config = stConfig::getInstance('stPayNow');
    }

    /**
     * Zwraca scieżke do loga płatności
     *
     * @return string
     */
    public function getLogoPath()
    {
        return '/plugins/stPayNowPlugin/images/logo.png';
    }

    /**
     * Utwórz nową płatność
     *
     * @param Order $order Instancja modelu Order
     * @return string|false
     */
    public function createPayment(Order $order)
    {        
        $context = sfContext::getInstance();
        $i18n = $context->getI18N();

        $paymentData = array(
            "amount" => stPrice::round($order->getUnpaidAmount() * 100, 0),
            "currency" => $order->getOrderCurrency()->getShortcut(),
            "externalId" => $order->getNumber(),
            "description" => $i18n->__("Zamówienie nr", null, 'stOrder').' '.$order->getNumber(),
            'continueUrl' => $context->getController()->genUrl('@stPayNowReturn?id='.$order->getId().'&hash_code='.$order->getHashCode(), true),
            "buyer" => array(
                "email" => $order->getOptClientEmail(),
            ),
        );  

        stPayment::log('paynow', "Creating Payment Request: ". var_export($paymentData, true));
        
        return $this->paymentRequest($paymentData);
    }

    /**
     * Sprawdza poprawność konfiguracja płatności
     *
     * @return bool
     */
    public function validateConfiguration()
    {
        return false !== $this->paymentRequest(array(
            "amount" => 100,
            "currency" => 'PLN',
            "externalId" => "test-".uniqid(),
            "description" => "Configuration Test",
            "buyer" => array(
                "email" => 'email@example.com',
            )            
        )); 
    }

    /**
     * Tworzy nowe żądanie utworzenia płatności
     *
     * @param array $paymentData
     * @return string|false Link do utworzonej płatności
     */
    public function paymentRequest(array $paymentData)
    {
        $client = new \Paynow\Client($this->config->get('api_key'), $this->config->get('api_signature_key'), $this->isSandbox() ? \Paynow\Environment::SANDBOX : \Paynow\Environment::PRODUCTION);

        $idempotencyKey = uniqid($paymentData['externalId'] . '_');
                
        try 
        {
            $payment = new \Paynow\Service\Payment($client);
            $result = $payment->authorize($paymentData, $idempotencyKey);
        } 
        catch (\PayNow\Exception\PaynowException $exception)
        {
            $this->lastError = $exception->getMessage();
            return false;
        }  

        if ($result->status == 'ERROR')
        {
            $this->lastError = 'Payment initialization failed';
            return false;
        }

        $this->lastError = null;

        return $result->redirectUrl;
    }

    /**
     * Zwraca informacje o statusie płatności
     *
     * @param string $data
     * @param array $headers
     * @return array
     */
    public function parseStatusNotification($data, array $headers)
    {
        $notificationData = json_decode($data, true);
        
        try 
        {
            new \Paynow\Notification($this->config->get('api_signature_key'), $data, $headers);
        } 
        catch (\Exception $exception) 
        {
            return false;
        }
        
        return $notificationData;      
    }

    /**
     * Zwraca ostatni błąd
     *
     * @return string
     */
    public function getLastError()
    {
        return $this->lastError;
    }

    /**
     * Sprawdza czy płatność jest w trybie testowym/sandbox
     *
     * @return bool
     */
    public function isSandbox()
    {
        return $this->config->get('sandbox');
    }

    /**
     * Sprawdza czy płatność ma włączone autoprzekierowanie
     *
     * @return bool
     */
    public function isAutoRedirectEnabled()
    {
        return $this->config->get('autoredirect');
    }

    /**
     * Sprawdza czy płatnośc jest poprawnie skonfigurowana
     *
     * @return bool
     */
    public function checkPaymentConfiguration()
    {
        return $this->config->get('enabled');
    }

    /**
     * Zwraca token bezpieczeństwa
     *
     * @return string
     */
    public static function getSecurityToken()
    {
        return stSecureToken::generate(array('123456789')); 
    }
    
    /**
     * Zwraca adres powiadomienia o statusie płatności
     *
     * @return string
     */
    public static function getNotifyUrl()
    {
        return st_url_for('@stPayNowNotify?token=' . self::getSecurityToken(), true, 'frontend', null, null, true, stConfig::getInstance('stSecurityBackend')->get('ssl'));
    }
}