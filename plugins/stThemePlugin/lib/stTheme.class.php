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
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stTheme.class.php 653 2009-04-16 06:18:48Z michal $
 * @author      Marcin Butlak <marcin.butlak@sote.pl>
 */

/**
 * Klasa obsługująca tematy w aplikacji frontend
 *
 * @package     stThemePlugin
 * @subpackage  libs
 */
class stTheme
{

   protected
   $context,
   $response,
   $theme = null,
   $baseTheme = null,
   $layoutName,
   $cssDir = null,
   $stylesheetPath = array(),
   $layoutConfig = array();
   protected static $pluginModulePaths = null;
   protected static $instance = null;
   protected static $hideOldConfiguration = null;

   /**
    * Zwraca instancje obiektu
    *
    * @param sfContext $context
    *
    * @return      stTheme     object
    */
   public static function getInstance(sfContext $context)
   {
      if (!isset(self::$instance))
      {
         $class = __CLASS__;
         self::$instance = new $class();
         self::$instance->initialize($context);
      }

      return self::$instance;
   }

   /**
    * Inicjalizuje podstawową konfigurację tematu
    *
    * @param        string      $context
    */
   public function initialize(sfContext $context)
   {
      $this->layoutConfig = array();

      $this->cssDir = sfConfig::get('sf_web_dir') . '/' . 'css';

      $this->context = $context;

      $this->response = $context->getResponse();

      if (SF_ENVIRONMENT == 'theme')
      {
         if ($this->context->getRequest()->hasParameter('theme'))
         {
            $this->context->getUser()->setAttribute('name', $this->context->getRequest()->getParameter('theme'), 'soteshop/stTheme');
         }

         $theme_name = $this->context->getUser()->getAttribute('name', null, 'soteshop/stTheme');

         if ($theme_name)
         {
            $this->setThemeName($theme_name);
         }
      }

      stEventDispatcher::getInstance()->notify(new sfEvent($this, 'stTheme.setDefaulTheme'));
   }

   public function getActionName()
   {
      return $this->context->getActionName();
   }

   public function getModuleName()
   {
      return $this->context->getModuleName();
   }

   public function getVersion()
   {
      return $this->getTheme()->getVersion();
   }

   public function hasThemeContent($id)
   {
      return $this->getTheme()->hasThemeContent($id);
   }

   public function getThemeContent($id, $default = null)
   {
      return $this->getTheme()->getThemeContent($id, $default);
   }

   /**
    * Pobiera aktywny obiekt tematu
    *
    * @return   Theme
    */
   public function getTheme()
   {
      if (null === $this->theme)
      {
         $this->theme = self::getActiveTheme();
      }

      return $this->theme;
   }

   public function setTheme(Theme $theme)
   {
      $this->theme = $theme;
   }

   /**
    * Pobiera aktywny obiekt tematu
    *
    * @return   Theme
    */
   public static function getActiveTheme()
   {
      $theme = null;

      $request = sfContext::getInstance()->getRequest();

      if (MobileDetect::getInstance()->isMobile() || $request->getParameter('mobile') && defined('ST_FAST_CACHE_SAVE_MODE') && ST_FAST_CACHE_SAVE_MODE)
      {
         $id = stConfig::getInstance('stThemeBackend')->get('responsive');
         
         if ($id)
         {
            $theme = ThemePeer::retrieveByPKCached($id);  
         }
      }

      if (null === $theme)
      {
         $theme = ThemePeer::doSelectActive();
      }

      return $theme;
   }

   /**
    * Zwraca aktualnie ustawiony tematu
    *
    * @return   string
    */
   public function getThemeName()
   {
      return $this->getTheme()->getTheme();
   }

   /**
    * Ustawia temat
    *
    * @param   string      $name              Nazwa tematu
    */
   public function setThemeName($name)
   {
      $theme = ThemePeer::doSelectByName($name);

      if (null === $theme)
      {
         $theme = new Theme();

         $theme->setName($name);
      }

      $this->setTheme($theme);
   }

   public function getBaseTheme()
   {
      if (null === $this->baseTheme)
      {
         $this->baseTheme = $this->getTheme()->getBaseTheme();
      }

      return $this->baseTheme;
   }

   public function setBaseTheme(Theme $theme)
   {
      $this->baseTheme = $theme;
   }

   /**
    * Ustawia podstawy temat
    *
    * @param        string      $theme
    */
   public function setDefaultThemeName($name)
   {
      $theme = ThemePeer::doSelectByName($name);

      if (null === $theme)
      {
         $theme = new Theme();

         $theme->setName($name);
      }

      $this->setBaseTheme($theme);
   }

   public function getThemeColorScheme()
   {
      return $this->getTheme()->getColorScheme();
   }

   /**
    * Zwraca nazwe podstawowego tematu
    *
    * @return   string
    */
   public function getDefaultThemeName()
   {
      return $this->getBaseTheme() ? $this->getBaseTheme()->getName() : null;
   }

   /**
    * Ustawia układ strony
    *
    * @param   string      $layout             Nazwa układu strony (bez rozszerzenia .html)
    */
   public function setLayoutName($layout)
   {
      $this->layoutName = $layout;
   }

   /**
    * Zwraca aktualnie ustawiony układ strony
    *
    * @return   string
    */
   public function getLayoutName()
   {
      return $this->layoutName;
   }

   public function getThemeDir()
   {

      return 'frontend/theme/' . $this->getThemeName();
   }

   public function getThemeColorSchemeDir()
   {
      return $this->getThemeDir() . '/' . $this->getThemeColorScheme();
   }

   public function getDefaultThemeDir()
   {
      return 'frontend/theme/' . $this->getDefaultThemeName();
   }

   public function getTemplateDir($module = null)
   {
      return sfLoader::getTemplateDir($module ? $module : $this->context->getModuleName(), null) . '/' . 'theme';
   }

   public function getStylesheetPaths($stylesheet)
   {
      if (!isset($this->stylesheetPath[$stylesheet]))
      {
         $stylesheet_path = $this->getStylesheetPath($stylesheet);

         if ($stylesheet_path)
         {
            $this->stylesheetPath[$stylesheet]['default'] = $stylesheet_path;

            $stylesheet_path = $this->getStylesheetPath('my_' . $stylesheet);

            if ($stylesheet_path)
            {
               $this->stylesheetPath[$stylesheet]['my'] = $stylesheet_path;
            }
         }
         else
         {
            $this->stylesheetPath[$stylesheet] = null;
         }
      }

      return $this->stylesheetPath[$stylesheet];
   }

   public function addStylesheet($stylesheet, $position = '', $options = array())
   {
      $stylesheet_path = $this->getStylesheetPaths($stylesheet);

      if ($stylesheet_path)
      {
         $this->response->addStylesheet($stylesheet_path['default'], $position, $options);

         if (isset($stylesheet_path['my']))
         {
            $this->response->addStylesheet($stylesheet_path['my'], $position, $options);
         }
      }
   }

   public function addLess($less, $position = '')
   {
      $less_path = $this->getStylesheetPaths($less);

      if ($less_path)
      {
         $this->response->setParameter($less_path['default'], array(), 'helper/asset/auto/less' . ($position ? '/' . $position : ''));

         if (isset($less_path['my']))
         {
            $this->response->setParameter($less_path['my'], array(), 'helper/asset/auto/less' . ($position ? '/' . $position : ''));
         }
      }
   }

   /**
    * Get stylesheet path
    * @param string $stylesheet
    * @return string stylesheet path
    */
   protected function getStylesheetPath($stylesheet)
   {
      return $this->findStylesheetPath($this->getTheme(), $stylesheet);
   }

   protected function findStylesheetPath(Theme $theme, $stylesheet)
   {
      if ($theme->getVersion() < 2 && $theme->getColorScheme() && is_readable($this->cssDir . '/' . $theme->getThemeColorSchemeDir() . '/' . $stylesheet))
      {
         return $theme->getThemeColorSchemeDir() . '/' . $stylesheet;
      }
      elseif (is_readable($this->cssDir . '/' . $theme->getThemeDir() . '/' . $stylesheet))
      {
         return $theme->getThemeDir() . '/' . $stylesheet;
      }
      elseif ($theme->hasBaseTheme())
      {
         return $this->findStylesheetPath($theme->getBaseTheme(), $stylesheet);
      }

      return false;      
   }

   /**
    * Dodaje plik CSS ktory zostanie zalaczony podczas wyświetlania strony
    *
    * @param   string      $stylesheet         Nazwa pliku css umieszczonego w katalogu 'frontend/theme/nazwa_tematu'
    */
   public static function useStylesheet($stylesheet, $position = '', $options = array())
   {
      $context = sfContext::getInstance();

      $theme = stTheme::getInstance($context);

      $theme->addStylesheet($stylesheet, $position, $options);
   }

   public static function getImagePath($image, $current = null)
   {
      static $processed = array();

      static $theme = null;
      
      if (!isset($processed[$image]))
      {
         if (null === $theme)
         {
            $context = sfContext::getInstance();

            $theme = stTheme::getInstance($context);
         }

         $instance = $current ? $current : $theme->getTheme();

         $processed[$image] = $theme->findImagePath($instance, $image, !$instance->hasImage($image));
      }

      return $processed[$image];
   }

   public function findImagePath(Theme $theme, $image, $default = false)
   {
      if ($theme->getVersion() < 2 && $theme->getColorScheme() && is_readable(sfConfig::get('sf_web_dir') . '/images/' . $theme->getThemeColorSchemeDir() . '/' . $image))
      {
         return $theme->getThemeColorSchemeDir() . '/' . $image;
      }
      elseif (is_readable($theme->getImagePath($image, true, $default)))
      {
         return $theme->getImagePath($image, false, $default);
      }
      elseif ($theme->hasBaseTheme())
      {            
         return $this->findImagePath($theme->getBaseTheme(), $image, $default);
      }

      return null;
   }

   public static function clearCache($clear_fast_cache = true)
   {
      $fc = new stFunctionCache('stThemePlugin');

      $fc->removeAll();

      if ($clear_fast_cache)
      {
         stFastCacheManager::clearCache();
      }
   }
   
   public static function clearAssetsCache()
   {
      stWebFileManager::getInstance()->remove(sfConfig::get('sf_web_dir').'/cache/css');
      
      stWebFileManager::getInstance()->remove(sfConfig::get('sf_web_dir').'/cache/less');       
   }
   
   public static function clearEditorCache()
   {
      self::clearCache(false);
      
      stWebFileManager::getInstance()->remove(sfConfig::get('sf_web_dir').'/cache/css/_editor');
      
      stWebFileManager::getInstance()->remove(sfConfig::get('sf_web_dir').'/cache/less/_editor');       
   }

   public static function clearSmartyCache($all = false)
   {
      if ($all)
      {
         $name = '*';
      }
      else
      {
         $name = stTheme::getInstance(sfContext::getInstance())->getThemeName();
      }

      foreach (glob(sfConfig::get('sf_root_dir').'/cache/smarty_c/'.$name.'/*') as $file)
      {
         unlink($file);
      }
   }
   
   public static function is_responsive()
   {
      $themeVersion = stTheme::getInstance(sfContext::getInstance())->getTheme()->getVersion();
              
      if($themeVersion >= 7){
          return true;
      }else{
          return false;
      }
      
   }

   public static function hideOldConfiguration()
   {
      if (null === self::$hideOldConfiguration)
      {
         $theme = ThemePeer::doSelectActive();

         $mobile = null;

         $id = stConfig::getInstance('stThemeBackend')->get('responsive');
         
         if ($id)
         {
            $mobile = ThemePeer::retrieveByPKCached($id);  
         }

         self::$hideOldConfiguration = $theme->getVersion() >= 7 && (!$mobile || $mobile->getVersion() >= 7);
      }

      return self::$hideOldConfiguration;
   }
}
