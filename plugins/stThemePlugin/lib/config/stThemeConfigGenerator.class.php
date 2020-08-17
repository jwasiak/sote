<?php

class stThemeConfigGenerator
{

   /**
    *
    * @var stThemeEditorConfig
    */
   protected $editorConfig;

   /**
    *
    * @var ThemeConfig
    */
   protected $themeConfig;

   public function __construct(stThemeEditorConfig $editor_config)
   {
      $this->themeConfig = $editor_config->getThemeConfig();

      $this->editorConfig = $editor_config;
   }

   public static function loadImageConfig(Theme $theme, $preview = false)
   {
      $filename = sfConfig::get('sf_data_dir').'/config/_editor/'.($preview ? 'preview_'.$theme->getName() : $theme->getName()).'.conf';

      if (is_file($filename))
      {
         return unserialize(file_get_contents($filename));
      }

      return array();
   }
   
   public function generateGraphic($preview = false)
   {
      if (!$preview)
      {
         stWebFileManager::getInstance()->remove($this->themeConfig->getTheme()->getImageDir(true).'/_editor/prod');
      }
      
      $this->generateImage($preview);
      
      $this->generateCss($preview);
   }

   public function generateImage($preview = false)
   {
      $theme = $this->themeConfig->getTheme();

      $images = array();

      if ($this->themeConfig->hasType('image'))
      {
         foreach ($this->themeConfig->getType('image') as $category => $fields)
         {
            foreach ($fields as $name => $value)
            {
               $target = $this->editorConfig->getGraphicFieldParameter($category, $name, 'default');

               $images[$target] = $preview ? $value : $this->applyImage($value);
            }
         }
      }

      if ($preview)
      {
         $theme_name = 'preview_'.$theme->getName();
      }
      else
      {
         $theme_name = $theme->getName();
      }

      $filename = sfConfig::get('sf_data_dir').'/config/_editor/'.$theme_name.'.conf';

      $dir = dirname($filename);

      if (!is_dir($dir))
      {
         mkdir($dir, 0755, true);
      }

      file_put_contents($filename, serialize($images));
   }

   public function compileCss($category = null)
   {
      $css = array();

      $theme = $this->themeConfig->getTheme();

      $categories = $category ? array($category) : $this->editorConfig->getGraphicCategories();

      foreach ($categories as $category)
      {
         if ($category == '_less') 
         {
            continue;
         }
         
         foreach ($this->editorConfig->getGraphicFields($category) as $field)
         {
            $default = $this->editorConfig->getGraphicFieldParameter($category, $field, 'default');

            if ($this->editorConfig->hasGraphicFieldType($category, $field, 'css'))
            {
               $selector = $this->editorConfig->getGraphicFieldParameter($category, $field, 'selector');

               $media = $this->editorConfig->getGraphicFieldParameter($category, $field, 'media', 'xs');

               $properties = $this->editorConfig->getGraphicFieldParameter($category, $field, 'property');

               $value = $this->themeConfig->getCss($category, $field);

               if ($value)
               {
                  foreach ((array) $properties as $property)
                  {
                     $css_value = $this->getValue($value, $property);

                     if ($css_value)
                     {
                        $css[$media][$selector][$property] = $css_value;
                     }
                  }

                  foreach ($this->editorConfig->getGraphicGenerated($category, $field) as $generated)
                  {
                     $css[isset($generated['media']) ? $generated['media'] : 'xs'][$generated['selector']][$generated['property']] = $this->getValue($value, $generated['property']);
                  }                  
               }
            }
         }
      } 

      $content = array();

      foreach ($this->editorConfig->getMedia() as $media => $setting)
      {
         if (isset($css[$media]))
         {
            if ($media != 'xs')
            {               
               $content[] = "@media (".$setting.") {\n";
            }

            $intend = $media != 'xs' ? "\t" : "";

            foreach ($css[$media] as $selector => $properties) 
            {
               $content[] = $intend.$selector." {\n";

               foreach ($properties as $property => $value)
               {
                  if ($theme->getVersion() < 7)
                  {
                      $content[] = $intend."\t".$property.': '.$value." !important;\n";
                  }
                  else
                  {
                      $content[] = $intend."\t".$property.': '.$value.";\n";
                  }
               }

               $content[] = $intend."}\n";
            }

            if ($media != 'xs')
            {
               $content[] = "}\n";
            }
         }
      }

      return implode("\n", $content);
   }

   public function generateCss($preview = false)
   {
      $theme = $this->themeConfig->getTheme();

      $filename = $preview ? $theme->getEditorCssPath('preview_style.css', true) : $theme->getEditorCssPath('style.css', true);

      $dir = dirname($filename);

      if (!is_dir($dir))
      {
         mkdir($dir, 0755, true);
      }

      file_put_contents($filename, $this->compileCss());
   }

   public function generateLess($preview = false)
   {
      $less = array();

      $fields = array_merge($this->editorConfig->getGraphicFields(array('_less', 'palette')), $this->editorConfig->getGraphicFields(array('_less', 'colors')));
      
      foreach ($fields as $field)
      {
         $default = $this->editorConfig->getGraphicFieldParameter('_less', $field, 'default');

         $value = $this->themeConfig->getLess($field, $default);

         if (!$value || $value == 'transparent')
         {
            $less[$field] = 'transparent';
         }
         else
         {
             $less[$field] = strpos($value, 'rgb') === false ? '#'.$value : $value;
         }
      }

      $theme = $this->themeConfig->getTheme();

      $filename = $preview ? $theme->getEditorCssPath('preview_config.less', true) : $theme->getEditorCssPath('config.less', true);

      $dir = dirname($filename);

      if (!is_dir($dir))
      {
         mkdir($dir, 0755, true);
      }

      $content = array();

      foreach ($less as $var => $value)
      {
         $content[] = "@".$var.': '.$value.";\n";
      }

      file_put_contents($filename, $content);

      if ($preview && is_file($theme->getEditorCssPath('preview_style.css', true)))
      {
         $this->generateCss(true);
      }
   }

   protected function applyImage($image)
   {
      $theme = $this->themeConfig->getTheme();
      
      $target = str_replace('_editor/preview', '_editor/prod', $image);

      $target_filename = $theme->getEditorImagePath($target, true);
      
      $target_dir = dirname($target_filename);
      
      if (!is_dir($target_dir))
      {
         mkdir($target_dir, 0755, true);
      }
      
      $source_filename = $theme->getEditorImagePath($image, true);
      
      copy($source_filename, $target_filename);

      return $target;
   }

   protected function getValue($value, $property)
   {
      $theme = $this->themeConfig->getTheme();
      
      $css_value = null;

      switch ($property)
      {
         case 'background-image':
            if ($value)
            {
               $css_value = sprintf('url(\'%s\')', $theme->getEditorImagePath($this->applyImage($value)));
            }
            break;
         case 'background-repeat':
            $css_value = $value;
            break;
         default:
            if (!$value || $value == 'transparent')
            {
               $css_value = 'transparent';
            }
            else
            {
                $css_value = strpos($value, 'rgb') === false ? '#'.$value : $value;
            }
      }

      return $css_value;      
   }

}
