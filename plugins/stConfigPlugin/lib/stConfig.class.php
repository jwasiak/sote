<?php

/**
 * SOTESHOP/stConfigPlugin
 *
 * Ten plik należy do aplikacji stConfigPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE.
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stConfigPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stConfig.class.php 14537 2011-08-09 07:19:00Z marcin $
 * @author      Marcin Butlak <marcin.butlak@sote.pl>
 */

/**
 * Klasa konfiguracji
 *
 * @package     stConfigPlugin
 * @subpackage  libs
 */
class stConfig
{
   const BOOL = false;

   const INT = 0;

   const STRING = '';
   
   protected static $instance = null;
   
   protected $config = array();
   protected $id = null;
   protected $culture = null;

   /**
    *
    * Retrieve the singleton instance for given configuration
    * 
    * @param string $id Unique configuration name 
    * @param array $params Parameters
    * @param string $deprecated (this parameter is only for backward compatibility) 
    * @return type 
    */
   public static function getInstance($name = null, $params = array(), $deprecated = null)
   {
      if (is_string($params))
      {
         $name = $params;
      }
      elseif (null !== $deprecated)
      {
         $name = $deprecated;
      }
      elseif (!$name && sfContext::hasInstance() || is_object($name))
      {
         $name = sfContext::getInstance()->getModuleName();
      }
      
      if (!isset(self::$instance[$name]))
      {
         $class = __CLASS__;

         $instance = new $class();

         $instance->initialize($name, $params);

         self::$instance[$name] = $instance;
      }

      return self::$instance[$name];
   }

   /**
    *
    * Sets the culture for the current configuration instance
    * 
    * @param string $culture 
    */
   public function setCulture($culture)
   {
      $this->culture = $culture;
   }

   /**
    *
    * Gets the culture for the current configuration instance
    * 
    * @return string Current culture 
    */
   public function getCulture()
   {
      return $this->culture;
   }

   /**
    *
    * Saves the current configuration data
    * 
    * @param bool $force_cache_refresh Force cache clean 
    */
   public function save($force_cache_refresh = true)
   {
      file_put_contents($this->getUserConfigPath(), Yaml::dump(array('data' => $this->config)));

      if ($force_cache_refresh)
      {
         $this->clearCache();
      }
   }

   public function clearCache()
   {
      $file = $this->getCacheFile();

      if (is_file($file))
      {
         if (function_exists("apc_delete_file"))
         {
            apc_delete_file($file);
         }

         if (function_exists("opcache_invalidate"))
         {
            opcache_invalidate($file, true);            
         } 

         unlink($file);        
      }
   }
   
   /**
    * Returns the configuration as array of parameters
    * 
    * @return array of parameters
    */
   public function getArray()
   {
      return $this->config;
   }

   public function setArray($config)
   {
      $this->config = $config;
   }

   /**
    * Loads the current configuration file
    *s
    * @return   array
    */
   public function load()
   {
      $user_config = $this->getUserConfigPath();

      $system_config = $this->getSystemConfigPath();

      $cache_file = $this->getCacheFile();

      if (!is_readable($cache_file) || @filemtime($user_config) > filemtime($cache_file) || @filemtime($system_config) > filemtime($cache_file))
      {
         $config = $this->loadConfig();

         if ($config && !$this->writeCacheFile($cache_file, '<?php $this->config = '.var_export($config, true).' ?>'))
         {
            throw new sfConfigurationException(sprintf('Unable to write config cache for "%s".', $cache_file));
         }

         $this->config = $config;
      }
      else
      {
         include($cache_file);
      }

      return $this->config;
   }

   /**
    * Current configuration is empty
    *
    * @return   bool
    */
   public function isEmpty()
   {
      return empty($this->config);
   }

   /**
    *
    * Sets/adds a configuration variable
    * 
    * @param string $name Variable name
    * @param mixed $value Variable value
    * @param bool $i18n If true the variable will be saved in the current cuture 
    */
   public function set($name, $value, $i18n = false)
   {
      if ($i18n)
      {
         $this->config['_i18n'][$this->culture][$name] = $value;
      }
      else
      {
         $this->config[$name] = $value;
      }
   }

   /**
    *
    * Gets a configuration variable
    * 
    * @param string $name Variable name
    * @param mixed $default Default value 
    * @param bool $i18n If true the variable will be returned in the current culture 
    * @return type 
    */
   public function get($name, $default = false, $i18n = false)
   {
      if ($i18n && isset($this->config['_i18n'][$this->culture][$name]))
      {
         return $this->config['_i18n'][$this->culture][$name];
      }
      
      if ($i18n && isset($this->config['_i18n'][stLanguage::getOptLanguage()][$name]))
      {
         return $this->config['_i18n'][stLanguage::getOptLanguage()][$name];
      }      

      if (isset($this->config[$name]))
      {
         return $this->config[$name];
      }

      if ($default === false && isset($this->config[$name]) && is_numeric($this->config[$name]))
      {
         $default = self::INT;
      }
      elseif ($default === false)
      {
         $default = self::STRING;
      }

      return $default;
   }

   public function setFromRequest($parameter, $ignore = array())
   {
      $data = sfContext::getInstance()->getRequest()->getParameter($parameter, array());

      $vars = array_merge($this->config, $data);

      foreach ($vars as $key => $value)
      {
         if ($ignore && in_array($key, $ignore))
         { 
            continue;
         }

         $this->set($key, isset($data[$key]) ? $this->trim($data[$key]) : '');
      }
   }

   protected function trim($data)
   {
      if (is_array($data))
      {
         foreach ($data as $key => $value)
         {
            $data[$key] = $this->trim($value);
         }
      }
      else
      {
         $data = trim($data);
      }

      return $data;
   }
   
   protected function initialize($id, $params = array())
   {
      $debug = sfConfig::get('sf_debug');
      
      if ($debug)
      {
         $timer = sfTimerManager::getTimer('Soteshop module configuration');
      }
      
      $culture = null;

      if (class_exists('sfContext', true) && sfContext::hasInstance())
      {
         $culture = sfContext::getInstance()->getUser()->getCulture();
      }

      if (is_array($params) && isset($params['culture']))
      {
         $culture = $params['culture'];
      }

      $this->id = $id;

      $this->setCulture($culture);

      $this->load();
      
      if ($debug)
      {
         $timer->addTime();
      }
   }   

   protected function writeCacheFile($cache, $data)
   {
      $fileCache = new sfFileCache(dirname($cache));

      $fileCache->initialize(array('lifeTime' => 86400 * 7));

      $fileCache->setWriteControl(false);

      $fileCache->setSuffix('');

      return $fileCache->set(basename($cache), '', $data);
   }

   protected function getSystemConfigPath()
   {
      return $this->getSfConfigDir().DIRECTORY_SEPARATOR.$this->id.'.yml';
   }

   protected function getUserConfigPath()
   {
      return $this->getSfConfigDir().DIRECTORY_SEPARATOR.'__'.$this->id.'.yml';
   }

   protected function getSfConfigDir()
   {
      return sfConfig::get('sf_data_dir').DIRECTORY_SEPARATOR.'config';
   }

   protected function getCacheFile()
   {
      return sfConfig::get('sf_root_cache_dir').DIRECTORY_SEPARATOR.'st_config'.DIRECTORY_SEPARATOR.$this->id.'.php';
   }

   protected function loadConfig()
   {
      $config = array();

      require_once (sfConfig::get('sf_plugins_dir').DIRECTORY_SEPARATOR.'stInstallerPlugin'.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'helper'.DIRECTORY_SEPARATOR.'stArrayHelper.php');

      $system_config = $this->getSystemConfigPath();

      $user_config = $this->getUserConfigPath();

      if (is_file($system_config))
      {
         $config = $this->loadFromFile($system_config);
      }

      if (is_file($user_config))
      {
         $config = st_array_merge_recursive3($config, $this->loadFromFile($user_config));
      }

      return $config;
   }

   protected function loadFromFile($file)
   {
      ini_set('pcre.backtrack_limit', 1000000);
      
      try 
      {
        $tmp = Yaml::parse($file);
      } 
      catch (Exception $e)
      {
        $yaml = new sfYamlParser();
        $tmp = $yaml->parse(file_get_contents($file));
      } 

      if (isset($tmp['all']['.auto_generated']['config']['fields']))
      {
         $config = $tmp['all']['.auto_generated']['config']['fields'];
      }
      else
      {
         $config = $tmp['data'];
      }

      unset($tmp);

      return $config;
   }

}
