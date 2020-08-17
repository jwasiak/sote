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
 * Klasa ThemePeer
 *
 * @package     stThemePlugin
 * @subpackage  lib
 */
class ThemePeer extends BaseThemePeer
{
   protected static $cached = array();

   /**
    * Aktywny temat graficzny
    * @var Theme
    */
   protected static $activeTheme = null;

   protected static $responsive = null;

   /**
    * Pobieranie aktywnego tematu graficznego
    *
    * @return Theme
    */
   public static function doSelectActive()
   {
      if (null === self::$activeTheme)
      {
         $c = new Criteria();

         $c->add(self::ACTIVE, true);

         $fc = stFunctionCache::getInstance('stThemePlugin');

         self::$activeTheme = $fc->cacheCall(array('ThemePeer', 'doSelectOne'), array($c));
      }

      return self::$activeTheme;
   }

   public static function retrieveByPKCached($id)
   {
      if (!$id)
      {
         return null;
      }
      
      if (!isset(self::$cached[$id]))
      {
         $fc = stFunctionCache::getInstance('stThemePlugin');

         self::$cached[$id] = $fc->cacheCall(array('ThemePeer', 'retrieveByPK'), array($id)); 
      }

      return self::$cached[$id];     
   } 
   
   public static function doSelectBaseTheme(Criteria $c)
   {
      $c = clone $c;
      
      $c->add(self::BASE_THEME_ID, null, Criteria::ISNULL);
      
      $c->add(self::VERSION, 2, Criteria::GREATER_EQUAL);
      
      return self::doSelect($c);
   }
      
   public static function doSelectByName($name)
   {
      $c = new Criteria();
      
      $c->add(self::THEME, $name);
      
      return self::doSelectOne($c);
   }

   public static function updateThemeImageConfiguration(Theme $current_theme, $for = null)
   {
      $asset_config = stConfig::getInstance('stAsset');  

      if (null === $for && $current_theme->getThemeConfig()->getConfigParameter('thumbs'))
      {
         $asset_config->setArray($current_theme->getThemeConfig()->getConfigParameter('thumbs'));
         $asset_config->save();
      }
      else
      {
         $paths = self::getThemeConfigurationPaths($current_theme, true);

         foreach ($paths as $path)
         {
            if (is_file($path))
            {
               $params = Yaml::parse($path);

               if (isset($params['thumbs']))
               {
                  if ($for && isset($params['thumbs'][$for]))
                  {
                     $values = $params['thumbs'][$for];

                     $current = $asset_config->get($for);

                     foreach ($values as $name => $value)
                     {
                        $current[$name] = array_merge($current[$name], $value);   
                     }

                     $asset_config->set($for, $current); 
                     
                     $asset_config->save();
                  }
                  else
                  {                  
                     foreach ($params['thumbs'] as $section => $values)
                     {
                        $current = $asset_config->get($section);

                        foreach ($values as $name => $value)
                        {
                           $current[$name] = array_merge($current[$name], $value);   
                        }

                        $asset_config->set($section, $current);
                     }

                     $asset_config->save();
                  }
               }
            } 
         }
      }
   } 
   
   public static function getThemeConfigurationPaths(Theme $theme, $system = false, array &$paths = array())
   {
      if ($theme->hasBaseTheme())
      {
         self::getThemeConfigurationPaths($theme->getBaseTheme(), $system, $paths);
      }

      $paths[] = $theme->getConfigurationPath($system);

      return $paths;    
   }
   
}