<?php
/**
 * SOTESHOP/stPayment
 *
 * Ten plik należy do aplikacji stPayment opartej na licencji (Professional License SOTE).
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stPayment
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stPaymentType.class.php 14541 2011-08-09 07:54:32Z piotr $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stPaymentType
 *
 * @package     stPayment
 * @subpackage  libs
 */
class stPaymentType
{
    /**
     * Pobieranie dostępnych metod płatności
     *
     * @return array tablica z dostępnymi metodami płatności
     */
    public static function getPaymentMethod($forCrud = false)
    {
        $paymentMethod = array();
        $paymentMethod = stPluginHelper::getConfigValue('stPaymentType');

        $context = sfContext::getInstance();

        if ($forCrud == true)
        {
            foreach ($paymentMethod as $method)
            {
                $i18nCatalogue = $method['name'].'Backend';
                if ($method['name'] == 'stStandardPayment') $i18nCatalogue = 'stPaymentType';
                $paymentMethodForCrud[$method['name']] = $context->getI18N()->__($method['description'], '', $i18nCatalogue);
            }
            return $paymentMethodForCrud;
        }

        return $paymentMethod;
    }

    /**
     * Pobieranie konfiguracji modułu
     *
     * @param string nazwa modułu np. stMoneybookers, stMoneybookersPlugin, stMoneybookersBackend
     * @return array tablica z konfiguracją
     */
    public static function getConfiguration($name)
    {
        $name = str_replace(array('Plugin', 'Backend', 'Frontend'), '', $name);
        $tmpConfig = stConfig::getInstance($name.'Backend', array('culture' => sfContext::getInstance()->getRequest()->getParameter('culture', stLanguage::getOptLanguage())));
        return $tmpConfig->getArray();
    }

    /**
     * Obsługa funckji __call w klasach pomocniczych typów płatności
     *
     * @param $method nazwa wywoływanej metody
     * @param $config array tablica z konfiguracją
     * @return mixed string/bool
     */
    public static function call($method, $config)
    {

        /**
         * Pobierania informacji z konfiguracji
         */
        if (strpos($method, 'get') === 0)
        {
            $method = str_replace('get', '', $method);
            $method = sfInflector::underscore($method);
            return trim($config[$method]);
        }

        /**
         * Sprawdzanie czy istnieje pole w konfiguracji i czy nie jest puste
         */
        if (strpos($method, 'has') === 0)
        {
            $method = str_replace('has', '', $method);
            $method = sfInflector::underscore($method);
            $configValue = trim($config[$method]);
            if (!empty($configValue)) return true;
            return false;
        }
    }

    /**
     * Sprawdzanie czy jest informacja o zamówieniu w akcji podsumowującej dane zamówienia
     *
     * @return bool
     */
    public static function hasOrderInSummary()
    {
        $context = sfContext::getInstance();
        return $context->getRequest()->hasParameter('id');
    }

    /**
     * Pobieranie zmaówienia w akcji podsumowującej dane zamówienia
     *
     * @return Order
     */
    public static function getOrderInSummary()
    {
        $context = sfContext::getInstance();
        $orderId = $context->getRequest()->getParameter('id');
        return OrderPeer::retrieveByPK($orderId);
    }

    /**
     * Pobieranie hash'a
     *
     * @param $orderId numer zamówienia
     * @return string hash
     */
    public static function getPaymentHash($orderId)
    {
        $c = new Criteria();
        $c->add(OrderHasPaymentPeer::ORDER_ID, $orderId);
        $c->addJoin(OrderHasPaymentPeer::PAYMENT_ID, PaymentPeer::ID);
        $c->add(PaymentPeer::STATUS, 0);
        $orderHasPayment = OrderHasPaymentPeer::doSelectOne($c);
        if (!is_object($orderHasPayment)) return null;
        return $orderHasPayment->getPayment()->getHash();
    }

    /**
     * Pobieranie języka na podstwawie culture.
     *
     * @param $available array tablica z dostępnymi językami dla płatności
     * @return string kod języka
     */
    public static function getLanguage($available = array(), $upper = true)
    {
        $culture = sfContext::getInstance()->getUser()->getCulture();
        $cultures = array( 'pl_PL' => 'PL', 'en_US' => 'EN', 'de' => 'DE', 'es' => 'ES', 'fr' => 'FR',
                           'it' => 'IT', 'ru' => 'RU', 'tr' => 'TR', 'cs' => 'CS','nl' => 'NL',
                           'da' => 'DA', 'sw' => 'SV', 'fi' => 'FI', 'bg' => 'BG');

        if (count($available)) $cultures = array_intersect($cultures, $available);

        if (isset($cultures[$culture])) $returnCulture = $cultures[$culture];
        elseif (isset($cultures[$defaultculture])) $returnCulture = $cultures[$defaultCulture];
        else $returnCulture = $cultures['en_US'];

        if (!$upper) return strtolower($returnCulture);
        else return strtoupper($returnCulture);
    }

    /**
     * Pobieranie kraju
     *
     * @return Countries
     */
    public static function getCountry($user)
    {
        $country = $user->getCountry();
        $c = new Criteria();
        $c->add(CountriesI18nPeer::NAME, $country);
        $countryI18n = CountriesI18nPeer::doSelectOne($c);
        return CountriesPeer::retrieveByPK($countryI18n->getId());
    }

    /**
     * Pobieranie waluty
     *
     * @return CurrencyStandard
     */
    public static function getCurrency($orderId = null) {
        if (is_null($orderId)) {
            $context = sfContext::getInstance();
            $currency = stCurrency::getInstance($context)->get();
        } else {
            $order = is_object($orderId) ? $orderId : OrderPeer::retrieveByPk($orderId);
            if (is_object($order)) $currency = $order->getOrderCurrency();
            else return self::getCurrency();
        }

        $c = new Criteria();
        $c->add(CurrencyStandardPeer::SHORTCUT, $currency->getShortcut());
        return CurrencyStandardPeer::doSelectOne($c);
    }


    public static function getSummaryDescriptionByOrderIdAndHash($orderId, $hashCode = null) {
        if ($hashCode === null) $order = OrderPeer::retrieveByPk($orderId);
        else $order = OrderPeer::retrieveByIdAndHashCode($orderId, $hashCode);
        if (is_object($order)) {
            $shopConfig = stConfig::getInstance('stShopInfoBackend');

            $variables = array('company', 'nip' => 'vatnumber', 'street', 'house', 'flat', 'code', 'town', 'phone', 'fax', 'bank', 'email');
            $s = array('{NUMBER}');
            $r = array($order->getNumber());
             
            foreach ($variables as $k => $v) {
                $s[] = '{'.strtoupper($v).'}';
                if (!is_int($k)) $r[] = $shopConfig->get($k);
                else $r[] = $shopConfig->get($v);
            }
             
            $c = new Criteria();
            $c->add(OrderHasPaymentPeer::ORDER_ID, $order->getId());
            $c->addJoin(OrderHasPaymentPeer::PAYMENT_ID, PaymentPeer::ID);
            $c->add(PaymentPeer::GIFT_CARD_ID, null, Criteria::ISNULL);
             
            $orderHasPayment = OrderHasPaymentPeer::doSelectOne($c);
            if (is_object($orderHasPayment)) {
                return str_replace($s, $r, $orderHasPayment->getPayment()->getPaymentType()->getSummaryDescription());
            }
        }
        return false;
    }
}