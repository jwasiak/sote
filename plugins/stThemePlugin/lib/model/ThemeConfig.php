<?php

/**
 * Subclass for representing a row from the 'st_theme_config' table.
 *
 * 
 *
 * @package plugins.stThemePlugin.lib.model
 */
class ThemeConfig extends BaseThemeConfig
{   
   protected $images = array();

   protected $configCache = null;
      
   public function getCss($category, $name, $default = null)
   {
      return $this->getParameter('css', $category, $name, $default);
   }

   public function setCss($category, $name, $value)
   {
      $this->setParameter('css', $category, $name, $value);
   }
   
   public function removeCss($category, $name)
   {
      $this->removeParameter('css', $category, $name);
   }

   public function getTheme($con = null)
   {
      if ($this->aTheme === null && ($this->id !== null)) 
      {
         $this->aTheme = ThemePeer::retrieveByPKCached($this->id); 
      }

      return $this->aTheme;
   }
   
   public function removeCssImage($category, $name)
   {
      if ($image = $this->getCss($category, $name))
      {
         unlink($this->getTheme()->getImageDir(true).'/'.$image);
      }
      
      $this->removeCss($category, $name);
   }
   
   public function getImage($category, $name, $default = null)
   {
      return $this->getParameter('image', $category, $name, $default);
   }

   public function setImage($category, $name, $value)
   {
      $this->setParameter('image', $category, $name, $value);
   }
   
   public function removeImage($category, $name)
   {
      if ($image = $this->getImage($category, $name))
      {
         unlink($this->getTheme()->getImageDir(true).'/'.$image);
      }
      
      $this->removeParameter('image', $category, $name);  
   }
   
   public function getLess($name, $default = null)
   {
      return $this->getParameter('less', 'none', $name, $default);
   }

   public function setLess($name, $value)
   {
      $this->setParameter('less', 'none', $name, $value);
   }
   
   public function removeLess($name)
   {
      $this->removeParameter('less', 'none', $name);
   }

   public function setConfigParameter($name, $value)
   {
      $this->setParameter('config', null, $name, $value);
   }

   public function getConfigParameter($name, $default = null)
   {
      $value = $this->getParameter('config', null, $name, $default);

      return $value;
   }
   
   public function setParameter($type, $category, $name, $value)
   {
      $parameters = $this->parameters;

      if (null === $category)
      {
         $parameters[$type][$name] = $value;
      }
      else
      {
         $parameters[$type][$category][$name] = $value;
      }

      $this->setParameters($parameters);
   }

   public function getParameter($type, $category, $name, $default = null)
   {
      if (null === $category)
      {
         return isset($this->parameters[$type][$name]) ? $this->parameters[$type][$name] : $default;
      }

      return isset($this->parameters[$type][$category][$name]) ? $this->parameters[$type][$category][$name] : $default;
   }
   
   public function removeType($type)
   {
      $parameters = $this->parameters;

      if (isset($parameters[$type]))
      {
         unset($parameters[$type]);
      }

      $this->setParameters($parameters);      
   }
   
   public function getImagePath($image, $system_path = false)
   {
      return $this->getTheme()->getImageDir($system_path).'/'.$image;
   }
   
   public function getType($type)
   {
      return $this->hasType($type) ? $this->parameters[$type] : null;
   }
   
   public function hasType($type)
   {
      if ($type == 'graphic') 
      {
         return isset($this->parameters['css']) || isset($this->parameters['image']);
      }
      elseif ($type == 'color')
      {
         $type = 'less';
      }

      return isset($this->parameters[$type]);
   }

   public function removeParameter($type, $category, $name)
   {
      $parameters = $this->parameters;

      if (isset($parameters[$type][$category][$name]))
      {
         unset($parameters[$type][$category][$name]);
      }

      $this->setParameters($parameters);
   }
   
   public function getImageByName($name)
   {
      if (null === $this->images)
      {
         $this->images = isset($this->parameters['image']) ? array_flip(array_values($this->parameters['image'])) : array();
      }
            
      return isset($this->images[$name]) ? $this->images[$name] : $name;
   }
   
   public function restoreImages()
   {
      $this->removeType('image');
      
      $theme = $this->getTheme();
      
      if (is_file(sfConfig::get('sf_data_dir').'/config/_editor/preview_'.$theme->getName().'.conf'))
      {
         unlink(sfConfig::get('sf_data_dir').'/config/_editor/preview_'.$theme->getName().'.conf');
      }
      
      stWebFileManager::getInstance()->remove($theme->getEditorImageDir(true).'/preview');
   }
   
   public function restoreCss()
   {
      $this->removeType('css');
      
      $theme = $this->getTheme();
      
      if (is_file($theme->getEditorCssPath('preview_style.css', true)))
      {
         unlink($theme->getEditorCssPath('preview_style.css', true));
      }
   }
   
   public function restoreLess()
   {
      $this->removeType('less');
      
      $theme = $this->getTheme();
      
      if (is_file($theme->getEditorCssPath('preview_config.less', true)))
      {
         unlink($theme->getEditorCssPath('preview_config.less', true));
      }
   }      
   
   public function delete($con = null)
   {
      $image_dir = $this->getTheme()->getImageDir(true);
      
      $css_dir = $this->getTheme()->getCssDir(true);
      
      parent::delete($con);
      
      stWebFileManager::getInstance()->remove($image_dir.'/_editor');
      
      stWebFileManager::getInstance()->remove($css_dir.'/_editor');
      
      if (is_file(sfConfig::get('sf_data_dir').'/config/_editor/preview_'.$theme->getName().'.conf'))
      {
         unlink(sfConfig::get('sf_data_dir').'/config/_editor/preview_'.$theme->getName().'.conf');
      }   
      
      if (is_file(sfConfig::get('sf_data_dir').'/config/_editor/'.$theme->getName().'.conf'))
      {
         unlink(sfConfig::get('sf_data_dir').'/config/_editor/'.$theme->getName().'.conf');
      }        
   }

   public function getDefaultConfig()
   {
      if (null === $this->configCache)
      {
         $theme_config = new stThemeConfig();
         $current = $theme_config->load($this);

         $config = array();
         $layout_config = array();

         if (isset($current['layout_config']) && $current['layout_config'])
         {
            foreach ($current['layout_config'] as $name => $value) 
            {
               if (!$value || $name[0] == '_') continue;
               

               foreach ($value['actions'] as $action) {
                  $layout_config[$action] = isset($value['default']) ? $value['default'] : null;
               }  
            }
         }

         $config['layouts'] = $layout_config;

         $this->configCache = $config;         
      }

      return $this->configCache;
   }

   public function hydrate(ResultSet $rs, $startcol = 1)
   {
      $ret = parent::hydrate($rs, $startcol);

      if (SF_APP == 'frontend')
      {
         $this->getDefaultConfig();
      }

      return $ret;
   }
}
