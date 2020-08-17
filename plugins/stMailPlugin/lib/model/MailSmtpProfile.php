<?php

/**
 * SOTESHOP/stMailPlugin
 *
 * Ten plik należy do aplikacji stMailPlugin opartej na licencji (Professional License SOTE).
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stMailPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: MailSmtpProfile.php 12178 2011-04-13 09:56:05Z marcin $
 * @author      Marcin Butlak <marcin.butlak@sote.pl>
 */

/**
 * Klasa MailSmtpProfile
 *
 * @package     stMailPlugin
 * @subpackage  libs
 */
class MailSmtpProfile extends BaseMailSmtpProfile
{

   /**
    * Zamienia id na nazwę
    *
    * @return       string      nazwa
    */
   public function __toString()
   {
      return $this->getName();
   }

   /**
    * Ustawia typ select'a
    *
    * @param        string      $v
    */
   public function setEncTypeSelect($v)
   {
      $this->setEncType($v);
   }

   /**
    * Pobiera typ select'a
    *
    * @return   string
    */
   public function getEncType()
   {
      $type = parent::getEncType();

      $backward_type = array(2 => 'tls', 4 => 'ssl', 8 => null);

      return array_key_exists($type, $backward_type) ? $backward_type[$type] : $type;
   }

}
