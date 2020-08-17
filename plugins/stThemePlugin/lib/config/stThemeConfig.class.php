<?php
class stThemeConfig
{      
   protected $themeConfig = null;

   protected $config = array();

   protected $categories = array();
   
   public function load(ThemeConfig $theme_config)
   {
      $this->themeConfig = $theme_config;
      
      $files = $this->findYamls($theme_config->getTheme());
      
      $this->config = $this->parseYamls($files);  

      return $this->config;    
   }
   
   public function getThemeConfig()
   {
      return $this->themeConfig;
   }

   public function get($name, $default = null)
   {
      return isset($this->config[$name]) ? $this->config[$name] : $default;
   }

   public function getCategories($name)
   {
      if (!isset($this->categories[$name]))
      {
         $scope = $this->get($name);

         if ($scope) 
         {
            $results = array();

            foreach (array_keys($scope) as $category)
            {
               if ($category[0] != '_')
               {
                  $results[] = $category;
               }
            }

            $this->categories[$name] = $results;
         } 
      }

      return $this->categories[$name];
   }
   
   public function validate()
   {
      $theme = $this->themeConfig->getTheme();
      
      return is_file($this->themeConfig->getTheme()->getConfigurationPath(true)) || !$theme->isSystemDefault() && $theme->hasBaseTheme() && $this->findYamls($theme);     
   }

   protected function findYamls(Theme $theme)
   {
      $files = array();
      
      if ($theme->hasBaseTheme())
      {
         $current = $theme;

         while ($current = $current->getBaseTheme()) {
            $path = $current->getConfigurationPath(true);

            if (is_file($path)) 
            {
               $files[] = $path;
            }
         }
      }

      $files = array_reverse($files);

      $current = $theme->getConfigurationPath(true);

      if (is_file($current))
      {
         $files[] = $current; 
      }

      return $files;
   }

   protected function parseYamls($files)
   {
      $config = array();
      
      foreach ($files as $file)
      {
         $config = self::merge($config, Yaml::parse($file));
      }

      return $config;
   }   
   
   protected static function merge($array1, $array2)
   {
      $arrays = func_get_args();
      $narrays = count($arrays);

      // check arguments
      // comment out if more performance is necessary (in this case the foreach loop will trigger a warning if the argument is not an array)
      for ($i = 0; $i < $narrays; $i++)
      {
         if (!is_array($arrays[$i]))
         {
            // also array_merge_recursive returns nothing in this case
            throw new sfException('Argument #' . ($i + 1) . ' is not an array - trying to merge array with scalar!');
         }
      }

      // the first array is in the output set in every case
      $ret = $arrays[0];

      // merege $ret with the remaining arrays
      for ($i = 1; $i < $narrays; $i++)
      {
         foreach ($arrays[$i] as $key => $value)
         {
            if ($key == 'display')
            {
               $ret[$key] = $value;
            }
            elseif (((string) $key) === ((string) intval($key)))
            { // integer or string as integer key - append
               $ret[] = $value;
            }
            else
            { // string key - megre
               if ($value && is_array($value) && !isset($value[0]) && isset($ret[$key]))
               {
                  // if $ret[$key] is not an array you try to merge an scalar value with an array - the result is not defined (incompatible arrays)
                  // in this case the call will trigger an E_USER_WARNING and the $ret[$key] will be null.
                  $ret[$key] = self::merge($ret[$key], $value);
               }
               else
               {
                  $ret[$key] = $value;
               }
            }
         }
      }

      return $ret;
   }   
}