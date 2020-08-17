<?php
/**
 * SOTESHOP/stBackend
 *
 * Ten plik należy do aplikacji stBackend opartej na licencji (Open License SOTE) Otwarta Licencja SOTE.
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stBackend
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: actions.class.php 7165 2010-08-02 12:15:47Z marek $
 * @author      Marcin Butlak <marcin.butlak@sote.pl>
 */

/**
 *
 * Provides an interface to backend desktop
 *
 * @package     stBackend
 * @subpackage  libs
 */
class stBackendDesktop
{
   protected static $instance = null;

   protected
      $modules = array(),
      $routing = null;

   /**
    *
    * Singleton
    *
    * @param stBackendDesktop $base_class
    * @return stBackendDesktop
    */
   public static function getInstance($base_class = null)
   {
      if (null === self::$instance)
      {
         if (null === $base_class)
         {
            $base_class = __CLASS__;
         }

         self::$instance = new $base_class();

         self::$instance->initialize();
      }

      return self::$instance;
   }

   /**
    * Intializes this desktop
    */
   public function initialize()
   {
      $this->routing = sfRouting::getInstance();

      $modules = sfConfig::get('app_stBackend_desktop');

      foreach ($modules as $module)
      {
         $this->addModule($module);
      }
   }

   /**
    *
    * Adds antother module
    *
    * @param mixed $params package name or custom custom array('label' => 'Module label', 'route' => '@myExampleRoute', 'icon' => 'myExample.png')
    */
   public function addModule($params = array())
   {
      $this->modules[] = new stBackendDesktopModule($this->routing, $params);
   }

   /**
    *
    * Retrieves modules
    *
    * @return array
    */
   public function getModules()
   {
      return $this->modules;
   }
}
