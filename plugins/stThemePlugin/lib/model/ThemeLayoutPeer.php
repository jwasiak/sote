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
 * Klasa ThemeLayoutPeer
 *
 * @package     stThemePlugin
 * @subpackage  lib
 */
class ThemeLayoutPeer extends BaseThemeLayoutPeer
{

   /**
    * Tablica z układami tematów graficznych
    * @var array
    */
   protected static $layouts = array();

   /**
    * Pobieranie dostępnych układów dla tematu graficznego
    *
    * @param int $id Numer id tematu graficznego
    * @return array
    */
   public static function doSelectByThemeId($id)
   {
      if (!isset(self::$layouts[$id]))
      {
         $c = new Criteria();
         
         $c->add(ThemeLayoutPeer::THEME_ID, $id);

         $fc = new stFunctionCache('stThemePlugin');
         
         self::$layouts[$id] = $fc->cacheCall(array('ThemeLayoutPeer', 'doSelect'), array($c), array('namespace' => 'model'));
      }
      
      return self::$layouts[$id];
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