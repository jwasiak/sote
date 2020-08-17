<?php

/**
 * SOTESHOP/stPaypalPlugin
 *
 * Ten plik należy do aplikacji stPaypalPlugin opartej na licencji (Professional License SOTE).
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stPaypalPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stPaypal.class.php 5933 2010-07-01 11:11:44Z marcin $
 * @author      Marcin Butlak <marcin.butlak@sote.pl>
 */
class stPaypal
{
   public static function getButtonLocaleByCulture($culture)
   {
      $culture_to_locale = sfConfig::get('app_stPaypal_button_culture_locale');
      
      return isset($culture_to_locale[$culture]) ? $culture_to_locale[$culture] : $culture_to_locale['default'];
   }
   
   
   public function checkPaymentConfiguration()
   {
      $config = stConfig::getInstance(null, 'stPaypal');

      return $config->get('configuration_verified');
   }

}
