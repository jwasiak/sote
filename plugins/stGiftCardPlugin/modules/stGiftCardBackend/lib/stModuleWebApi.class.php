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


/**
 * Klasa StGiftCardBackendWebApi
 *
 * @package     stWebApiPlugin
 * @subpackage  libs
 **/
class StGiftCardBackendWebApi extends autoStGiftCardBackendWebApi {

    public function TestAndValidateAddGiftCardFields($object) 
    {
        parent::TestAndValidateAddGiftCardFields($object);

        $this->validateCurrencyId($object->currency_id);
        $this->validateCode($object);
    }

    public function TestAndValidateUpdateGiftCardFields( $object ) {
        parent::TestAndValidateUpdateGiftCardFields($object);

        if (isset($object->currency_id))
        {
            $this->validateCurrencyId($object->currency_id);
        }

        $this->validateCode($object);
    }

    protected function validateCode($object)
    {
        $c = new Criteria();
        $c->add(GiftCardPeer::CODE, $object->code);

        if (isset($object->id)) {
            $c->add(GiftCardPeer::ID, $object->id, Criteria::NOT_EQUAL);
        }

        if (GiftCardPeer::doCount($c) > 0)
        {
            throw new SoapFault("2", sprintf($this->__(WEBAPI_VALIDATE_UNIQUE_ERROR), 'code'));
        }
    }   

    protected function validateCurrencyId($currency_id)
    {
        $c = new Criteria();
        $c->add(CurrencyPeer::ID, $currency_id);

        if (!CurrencyPeer::doCount($c)) 
        {
            throw new SoapFault( "2", sprintf($this->__(WEBAPI_ADD_ERROR), $this->__("waluta o id").' '.$currency_id.' '.$this->__("nie istnieje")) );
        }        
    }
}
