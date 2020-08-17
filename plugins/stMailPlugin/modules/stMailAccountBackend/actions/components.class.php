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
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: components.class.php 9844 2010-12-16 13:49:57Z marcin $
 * @author      Krzysztof Beblo <krzysztof.beblo@sote.pl>
 */

/**
 * Komponent stMailAccountBackend
 *
 * @package     stMailPlugin
 * @subpackage  actions
 */
class stMailAccountBackendComponents extends autoStMailAccountBackendComponents
{
   /**
    * @deprecated
    * @return <type>
    */
   public function executeCheckSetAccount()
   {
      return sfView::NONE;   
   }

}