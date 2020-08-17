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
 * Klasa ThemeCssPeer
 *
 * @package     stThemePlugin
 * @subpackage  lib
 */
class ThemeCssPeer extends BaseThemeCssPeer
{

   /**
    * Tablica z css'ami tematów graficznych
    * @var array
    */
   protected static $css = array();
		
   /**
    * Pobieranie dostępnych css'ów dla tematu graficznego
    *
    * @param int $id Numer id tematu graficznego
    * @return array
    */
   public static function doSelectByThemeId($id)
   {
      if (!isset(self::$css[$id]))
      {
         $c = new Criteria();
         
         $c->add(ThemeCssPeer::THEME_ID, $id);

         $fc = new stFunctionCache('stThemePlugin');
         
         self::$css[$id] = $fc->cacheCall(array('ThemeCssPeer', 'doSelect'), array($c), array('namespace' => 'model'));
      }
      
      return self::$css[$id];
   }



	/**
	 * Przeciążanie funkcji onDelete
	 *
	 * @param mixed $values
	 * @param PropelConnection $con
	 */
	public static function doDelete($values, $con = null)
	{
		$stCache = new stFunctionCache('stThemePlugin');
		$stCache->removeAll();

		parent::doDelete($values, $con);
	}
}