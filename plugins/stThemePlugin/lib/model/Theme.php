<?php

/**
 * Subclass for representing a row from the 'st_theme' table.
 *
 * @package     stThemePlugin
 * @subpackage  libs
 */
class Theme extends BaseTheme
{
   protected $themeConfig = null;

   protected $themeConfigCached = null;
   
   protected $editorImages = null;

   protected $baseThemes = array();

   protected $themeContents = array();

   public function getBackendCulture()
   {
      return sfContext::getInstance()->getUser()->getCulture();
   }

   public function __toString()
   {
      return $this->theme;
   }
   
   public function getColorScheme()
   {
      return $this->getOptColorScheme();
   }

   public function isSystemDefault()
   {
      return parent::getIsSystemDefault();
   }

   public function getIsSystemDefault($check_active = true)
   {
      return parent::getIsSystemDefault() || $this->getTheme() == 'default' || $this->getTheme() == 'homeelectronics' || $check_active && $this->getActive();
   }

   /**
    *
    * alias for Theme::setBaseThemeId
    * 
    * @param int $v 
    */
   public function setBaseThemeList($v)
   {
      $this->setBaseThemeId($v ? $v : null);
   }

   /**
    * Przeciążenie zapisu
    */
   public function delete($con = null)
   {
      $ret = parent::delete($con);

      stTheme::clearCache();

      return $ret;
   }

   public function setName($v)
   {
      $this->setTheme($v);
   }

   public function getName()
   {
      return $this->getTheme();
   }

   public function hasBaseTheme()
   {
      return null !== $this->getBaseTheme();
   }

   public function getBaseTheme()
   {
      return ThemePeer::retrieveByPKCached($this->base_theme_id);
   }

   public function getBaseThemes($current = null)
   {
      if (null === $current)
      {
         if ($this->baseThemes)
         {
            return array_reverse($this->baseThemes);
         }
         $current = $this->getBaseTheme();

         if (null === $current) 
         {
            return array();
         }
      }
      else
      {
         $current = $current->getBaseTheme();
      }

      if (null !== $current)
      {
         $this->baseThemes[] = $current;
      }

      return $this->getBaseThemes($current);
   }

   public function hasThemeContent($content_id)
   {
      $content = $this->getThemeContent($content_id);
      return null !== $content && !empty($content);
   }

   public function getThemeContent($content_id, $default = null, $culture = null)
   {
      if (null === $culture) 
      {
         $culture = sfContext::getInstance()->getUser()->getCulture();
      }
      
      if (!isset($this->themeContents[$culture]))
      {
         $fc = stFunctionCache::getInstance('stThemePlugin');
         $this->themeContents[$culture] = $fc->cacheCall(array($this, 'loadThemeContents'), array($culture, $this->getId()));
      }

      return isset($this->themeContents[$culture][$content_id]) ? $this->themeContents[$culture][$content_id] : $default;
   }

   /**
    * Przeciążenie zapisu
    */
   public function save($con = null)
   {
      if ($this->isColumnModified(ThemePeer::ACTIVE) && $this->getActive())
      {
         $s = new Criteria();
         $s->add(ThemePeer::ACTIVE, true);
         $u = new Criteria();
         $u->add(ThemePeer::ACTIVE, false);
         BasePeer::doUpdate($s, $u, Propel::getConnection());
      }     

      if ($this->isNew() && !$this->isColumnModified(ThemePeer::VERSION))
      {
         $this->setVersion(4);

         $default = ThemePeer::doSelectByName('default2');

         $this->setBaseThemeId($default ? $default->getId() : null);
      }

      if (in_array($this->theme, array(
        'default2',
        'responsive',
        'argentorwd',
        'homeelectronics',
        'giallo',
        'moderno',
        'sportivo',
        'quattro',
        'coffeestore',
        'segno',
        'longboard',
        'bagging',
        'games',
        'surfing',
        'brassiere',
        'yewelry',
        'gifts',
        'fragrance',
        'furniture',
        'argento',
        'meble'))) 
      {
         $this->setIsSystemDefault(true);
      }

      $ret = parent::save($con);

      $config = stConfig::getInstance('stThemeBackend');

      if ($config->get('responsive'))
      {
         $c = new Criteria();
         $c->add(ThemePeer::ACTIVE, true);
         $c->add(ThemePeer::ID, $config->get('responsive'));
         $config->set('responsive_vary', ThemePeer::doCount($c) == 0);
      }
      else
      {
         $config->set('responsive_vary', false);
      }

      $config->save(true);

      stTheme::clearCache();

      return $ret;
   }
   
   public function getConfigurationPath($system = false)
   {
      return $system ? sfConfig::get('sf_root_dir').'/config/theme/'.$this->theme.'.yml' : 'config/theme/'.$this->theme.'.yml';
   }
   
   public function getCssDir($system_path = false)
   {
      if ($system_path)
      {
         $root_dir = realpath(sfConfig::get('sf_web_dir'));

         if ($root_dir == '/')
         {
            $root_dir = '';
         }

         return $root_dir.'/css/frontend/theme/'.$this->theme;
      }

      return '/css/frontend/theme/'.$this->theme;
   }
   
   public function getImageDir($system_path = false)
   {
      if ($system_path)
      {
         $root_dir = realpath(sfConfig::get('sf_web_dir'));

         if ($root_dir == '/')
         {
            $root_dir = '';
         }

         return $root_dir.'/images/frontend/theme/'.$this->theme;
      }
      
      return '/images/frontend/theme/'.$this->theme;
   }
     
   public function getEditorCssPath($css, $system_path = false)
   {
      return $this->getCssDir($system_path).'/_editor/'.$css;
   }
   
   public function getEditorImageDir($system_path = false)
   {
      return $this->getImageDir($system_path).'/_editor';
   }

   public function getThemeConfigCached()
   {
      if (null === $this->themeConfigCached)
      {
         $fc = new stFunctionCache('stThemePlugin');

         $this->themeConfigCached = $fc->cacheCall(array($this, 'getThemeConfig')); 
      }

      return $this->themeConfigCached;
   }

   public function getThemeConfig()
   {
      if (null === $this->themeConfig)
      {
         $c = new Criteria();

         $c->setLimit(1);

         $configs = $this->getThemeConfigs($c);

         $this->themeConfig = $configs ? $configs[0] : null;

         if (null === $this->themeConfig)
         {
            $this->themeConfig = new ThemeConfig();
            $this->addThemeConfig($this->themeConfig);
         }
      }

      return $this->themeConfig;
   }

   public function getThemeDir()
   {
      return 'frontend/theme/' . $this->theme;
   }

   public function getThemeColorSchemeDir()
   {
      return $this->getThemeDir() . '/' . $this->getColorScheme();
   }

   public function getDefaultThemeDir()
   {
      return $this->getBaseTheme() ? 'frontend/theme/' . $this->getBaseTheme()->getName() : null;
   }

   public function getTemplateDir($module = null)
   {
      return $module ? sfLoader::getTemplateDir($module, null) . '/theme/' . $this->theme : sfConfig::get('sf_root_dir') . '/apps/frontend/templates/theme/'. $this->theme;
   }
   
   public function getEditorImagePath($image, $system_path = false)
   {
      return $this->getImageDir($system_path).'/'.$image;
   }

   public function findEditorImagePath($image, Theme $theme = null)
   {
      if (null === $theme)
      {
        $theme = $this;
      }

      if (is_readable($theme->getEditorImagePath($image, true)))
      {
         return $theme->getEditorImagePath($image);
      }
      elseif ($theme->hasBaseTheme())
      {            
         return $this->findEditorImagePath($image, $theme->getBaseTheme());
      }

      return null;
   }
      
   public function getImagePath($image, $system_path = false, $default = false)
   {           
      return $this->getImageDir($system_path).'/'.($default ? $image : $this->getImage($image));
   } 

   public function getImage($image)
   {
      return $this->hasImage($image) ? $this->editorImages[$image] : $image;     
   }

   public function hasImage($image)
   {
      if (null === $this->editorImages)
      {
         $this->editorImages = stThemeConfigGenerator::loadImageConfig($this, SF_ENVIRONMENT == 'theme');         
      }

      return isset($this->editorImages[$image]);
   }

   public function getIsResponsive()
   {
      return stConfig::getInstance('stThemeBackend')->get('responsive') === $this->id;
   } 
   
   public function loadThemeContents()
   {
      $themeContents = array();

      foreach ($this->getThemeContents() as $content)
      {
         $themeContents[$content->getContentId()] = $content->getContent();  
      }

      return $themeContents;
   }
}
