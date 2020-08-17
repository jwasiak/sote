<?php

/**
 * SOTESHOP/stThemePlugin
 *
 * Ten plik należy do aplikacji stThemePlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stThemePlugin
 * @subpackage  lib
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id:  $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa ThemeColorSchemePeer
 *
 * @package     stThemePlugin
 * @subpackage  lib
 */
class ThemeColorSchemePeer extends BaseThemeColorSchemePeer
{

   /**
    * Tablica z kolorami tematów graficznych
    * @var array
    */
   protected static $colorScheme = array();

   /**
    * Pobieranie dostępnych kolorów dla tematu graficznego
    *
    * @param int $id Numer id tematu graficznego
    * @return array
    */
   public static function doSelectByThemeId($id)
   {
      if (!isset(self::$colorScheme[$id]))
      {
         $c = new Criteria();
         
         $c->add(ThemeColorSchemePeer::THEME_ID, $id);

         $fc = new stFunctionCache('stThemePlugin');
         
         self::$colorScheme[$id] = $fc->cacheCall(array('ThemeColorSchemePeer', 'doSelect'), array($c), array('namespace' => 'model'));
      }
      
      return self::$colorScheme[$id];
   }

}