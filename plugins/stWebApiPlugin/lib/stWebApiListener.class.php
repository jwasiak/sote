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
 * @version     $Id: stWebApiListener.class.php 10 2009-08-24 09:32:18Z michal $
 */

class stWebApiListener {

    public static function StProducerGenerate(sfEvent $event) {
        $event->getSubject()->attachAdminGeneratorFile('stWebApiPlugin', 'producerWebApi.yml');
    }

    public static function StCategoryGenerate(sfEvent $event) {
        $event->getSubject()->attachAdminGeneratorFile('stWebApiPlugin', 'categoryWebApi.yml');
    }
    
    public static function StProductGenerate(sfEvent $event) {
        $event->getSubject()->attachAdminGeneratorFile('stWebApiPlugin', 'productWebApi.yml');
    }

    public static function StUserGenerate(sfEvent $event) {
        $event->getSubject()->attachAdminGeneratorFile('stWebApiPlugin', 'userWebApi.yml');
    }
    
    public static function StOrderGenerate(sfEvent $event) {
        $event->getSubject()->attachAdminGeneratorFile('stWebApiPlugin', 'orderWebApi.yml');
    }

    public static function StCurrencyGenerate(sfEvent $event) {
        $event->getSubject()->attachAdminGeneratorFile('stWebApiPlugin', 'currencyWebApi.yml');
    }

    public static function StDiscountGenerate(sfEvent $event) {
        $event->getSubject()->attachAdminGeneratorFile('stWebApiPlugin', 'discountWebApi.yml');
    }
    
    public static function StGiftCardGenerate(sfEvent $event) {
        $event->getSubject()->attachAdminGeneratorFile('stWebApiPlugin', 'giftCardWebApi.yml');
    }

    public static function StPaymentTypeGenerate(sfEvent $event) {
        $event->getSubject()->attachAdminGeneratorFile('stWebApiPlugin', 'paymentTypeWebApi.yml');
    }
}