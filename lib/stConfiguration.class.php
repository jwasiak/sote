<?php

/**
 * SOTESHOP/stConfigurationPlugin
 *
 * Ten plik należy do aplikacji stConfigurationPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stConfigurationPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stConfiguration.class.php 7321 2010-08-06 09:04:30Z marcin $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Provides an interface to configuration desktop
 *
 * @author      Marcin Butlak <marcin.butlak@sote.pl>
 * @package     stConfigurationPlugin
 * @subpackage  libs
 */
class stConfiguration
{
   protected static
      $instance = null;

   protected
      $routing = null,
      $desktopModules = null;

   /**
    *
    * @deprecated the group is added automatically by stConfiguration::addModule
    */
   public static function addGroup($groupName, $groupTitle)
   {
      //stPluginHelper::addConfigValue('stConfigurationPlugin_groups', $groupName, array('group' => $groupName, 'title' => $groupTitle));
   }

   /**
    *
    * Adds another module to desktop configuration
    * 
    * @author Marcin Butlak <marcin.butlak@sote.pl>
    * @param mixed $module package name or custom array('label' => 'Module label', 'route' => '@myExampleRoute', 'icon' => 'myExample.png')
    * @param string $group Group name
    */
   public static function addModule($module, $group)
   {
      /**
       * backward compatibility fix
       */
      if ($group == 'group_1')
      {
         $group = 'Administracja sklepem';
      }
      elseif ($group == 'group_2')
      {
         $group = 'Konfiguracja modułów';
      }
      elseif ($group == 'group_3')
      {
         $group = 'Płatności';
      }

      $modules = sfConfig::get('app_stConfigurationPlugin_desktop');

      if (!isset($modules[$group]))
      {
         $modules[$group] = array();
      }

      $modules[$group][] = $module;

      sfConfig::set('app_stConfigurationPlugin_desktop', $modules);
   }

   /**
    *
    * Singleton
    *
    * @param stConfiguration $base_class
    * @return stConfiguration
    */
   public static function getInstance(stConfiguration $base_class = null)
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

   public function __toString() 
   {
      return 'stConfiguration';
   }

   public function initialize()
   {
      $this->routing = sfRouting::getInstance();

      $fc = new stFunctionCache('stConfiguration');
      $this->desktopModules = $fc->cacheCall(array($this, 'initializeModules'), array('culture' => sfContext::getInstance()->getUser()->getCulture()));
   }

   public function getDesktopModule($name)
   {
      foreach ($this->desktopModules as $group => $modules)
      {
         foreach ($modules as $module)
         {
            if ($module->getName() == $name)
            {
               return $module;
            }
         }
      }

      return null;
   }

   /**
    * Retrieves desktop modules
    * 
    * @author Marcin Butlak <marcin.butlak@sote.pl>
    * @return array
    */
   public function getDesktopModules()
   {
      return $this->desktopModules;
   }

   public function addDesktopModule($group, $params = array())
   {
      if (!isset($this->desktopModules[$group]))
      {
         $this->desktopModules[$group] = array();
      }

      $this->desktopModules[$group][] = new stBackendDesktopModule($this->routing, $params);
   }

   public function initializeModules()
   {
      $desktop_modules = sfConfig::get('app_stConfigurationPlugin_desktop');
      
      foreach ($desktop_modules as $group => $modules)
      { 
         /**
          * Hack for array_unique with arrays
          * @author michal.prochowski@sote.pl
          **/
         $modules = array_map("unserialize", array_unique(array_map("serialize", $modules)));

         foreach ($modules as $module)
         {
            $this->addDesktopModule($group, $module);
         }
      }

      foreach ($this->desktopModules as $group => $modules)
      {
         $modules = self::sort($modules);

         $this->desktopModules[$group] = $modules;
      }   

      return $this->desktopModules;   
   }

   public static function sort($modules)
   {
      usort($modules, array('stConfiguration', '_sort'));

      return $modules;
   }

   protected static function _sort($a, $b) 
   {
      return strcasecmp($a->getLabel(), $b->getLabel());
   }
}