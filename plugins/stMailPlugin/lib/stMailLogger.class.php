<?php

/**
 * SOTESHOP/stSwiftPlugin
 *
 * Ten plik należy do aplikacji stSwiftPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE.
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stSwiftPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: actions.class.php 617 2009-04-09 13:02:31Z michal $
 * @author      Marcin Butlak <marcin.butlak@sote.pl>
 */

/**
 *  actions.
 *
 * @package     stSwiftPlugin
 * @subpackage  libs
 */
class stMailLogger implements Swift_Plugins_Logger
{

   protected $logger = null;

   /**
    * Create a new logger.
    *
    * @param boolean $isHtml
    */
   public function __construct($isHtml = true)
   {
      $this->logger = sfLogger::getInstance();
   }

   /**
    * Add a log entry.
    * @param string $entry
    */
   public function add($entry)
   {
      $this->logger->log('{stMail} '.$entry, strpos($entry, '!! ') === 0 ? SF_LOG_ERR : SF_LOG_INFO);
   }

   /**
    * Not implemented.
    */
   public function clear()
   {

   }

   /**
    * Not implemented.
    */
   public function dump()
   {

   }

}