<?php
/**
 * SOTESHOP/stWebApiPlugin
 *
 * Ten plik należy do aplikacji stWebApiPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE.
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stWebApiPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stModuleWebApi.class.php 16567 2011-12-21 13:38:08Z piotr $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 **/

define('WEBAPI_CURRENCY_INCORRECT_SHORTCUT', 'Błędny parametr SHORTCUT.');

/**
 * Klasa StCurrencyBackendWebApi
 *
 * @package     stWebApiPlugin
 * @subpackage  libs
 **/
class StCurrencyBackendWebApi extends autoStCurrencyBackendWebApi {

    /** 
     * Aktualizacja danych
     *
     * @param   object      $object             obiekt z parametrami
     * @return  object      obiekt z true
     * @throws WEBAPI_INCORRECT_ID WEBAPI_UPDATE_ERROR WEBAPI_REQUIRE_ERROR
     * @todo dodać walidacje danych
     **/
    public function UpdateCurrencyExchangeByShortcut($object) {
        stWebApi::getLogin($object->_session_hash, 'webapi_write');
        $this->TestAndValidateUpdateCurrencyExchangeByShortcutFields($object);

        $c = new Criteria();
        $c->add(CurrencyPeer::SHORTCUT, $object->shortcut);
        $item = CurrencyPeer::doSelectOne($c);

        if ($item) {

            $this->setFieldsForUpdateCurrencyExchangeByShortcut($object, $item);
            //Zapisywanie danych do bazy
            try {
                $item->save();
            } catch (Exception $e) {
                throw new SoapFault('2', sprintf($this->__(WEBAPI_UPDATE_ERROR), $e->getMessage()));
            }
            
            // Zwracanie danych
            $object = new StdClass();
            $object->_update = 1;
            return $object;
        } else {
            throw new SoapFault('1', $this->__(WEBAPI_CURRENCY_INCORRECT_SHORTCUT));
        }
    }

    /** 
     * Pobieranie danych
     *
     * @param   object      $object             obiekt z parametrami
     * @return  object      okiekt z danymi
     * @throws WEBAPI_INCORRECT_ID WEBAPI_REQUIRE_ERROR
     **/
    public function GetCurrencyByShortcut($object) {
        if (isset($object->_culture)) $this->__setCulture($object->_culture);
        
        stWebApi::getLogin($object->_session_hash, 'webapi_read');
        $this->TestAndValidateGetCurrencyByShortcutFields($object);

        $c = new Criteria();
        $c->add(CurrencyPeer::SHORTCUT, $object->shortcut);
        $item = CurrencyPeer::doSelectOne($c);

        if ($item) {
            $object = new StdClass();
            $this->getFieldsForGetCurrencyByShortcut($object, $item);
            return $object;
        } else {
            throw new SoapFault('1', $this->__(WEBAPI_CURRENCY_INCORRECT_SHORTCUT));
        }
    }
}
