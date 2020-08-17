<?php
/**
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 */

/**
 * stFastCache Manager.
 * Manage fast cache files.
 */
class stFastCacheManager {

    const CLEAR_DELAY = 300;

    protected static $instance = null;

    protected $adapter;

    protected static $disableClearCache = false;
    
    public static function disableClearCache()
    {
        self::$disableClearCache = true;
    }

    public static function enableClearCache()
    {
        self::$disableClearCache = false;
    }

    public static function clearCache($delay = false) 
    {
        if (!self::$disableClearCache)
        {
            if ($delay)
            {
                $filename = sfConfig::get('sf_data_dir').'/.fastcache_delay';
                
                if (!is_file($filename)) 
                {
                    touch($filename);
                    self::clearCache();
                }
                elseif (time() - filemtime($filename) >= self::CLEAR_DELAY)
                {
                    self::clearCache();
                    touch($filename);
                }
            } 
            else
            {
                $path = sfConfig::get('sf_root_cache_dir').'/frontend/*/fastcache/*';

                $lock = sfConfig::get('sf_data_dir').'/.fastcache_lock';

                if (!is_file($lock) || time() - filemtime($lock) >= self::CLEAR_DELAY)
                {
                    touch($lock);
                    sfToolkit::clearGlob($path);
                    unlink($lock);
                }
            }
        }
    }

    public static function productConfigClearCache($event) 
    {
        if (sfContext::getInstance()->getRequest()->getMethod() == sfRequest::POST)
        {
            self::clearCache();
        }
    }

    public static function getInstance()
    {
        if (null === self::$instance)
        {
            if (!self::helper())
            {
                return null;
            }

            $path = sfConfig::get('sf_cache_dir').'/fastcache';

            if (MobileDetect::getInstance()->isMobile())
            {
                $path .= '/mobile';
            }

            if (!is_dir($path))
            {
                mkdir($path, 0755, true);
            }

            $adapter = new stPhpFastCacheSQLite($path);

            self::$instance = new stFastCacheManager($adapter);
        }

        return self::$instance;
    }

    public static function simpleAutoload($class)
    {
        $sf_plugins_dir = SF_ROOT_DIR.'/plugins';
        $sf_symfony_lib_dir = SF_ROOT_DIR.'/lib/symfony';

        $classes = array(
            'sfCache' => $sf_symfony_lib_dir.'/cache/sfCache.class.php',
            'sfException' => $sf_symfony_lib_dir.'/exception/sfException.class.php',        
            'sfFileCache' => $sf_symfony_lib_dir.'/cache/sfFileCache.class.php',
            'stConfig' => $sf_plugins_dir.'/stConfigPlugin/lib/stConfig.class.php', 
            'sfConfig' => $sf_symfony_lib_dir.'/config/sfConfig.class.php',      
            'Dumper' =>  $sf_plugins_dir.'/stConfigPlugin/lib/sfYaml/Dumper.php',
            'Escaper' =>  $sf_plugins_dir.'/stConfigPlugin/lib/sfYaml/Escaper.php',
            'Inline' =>  $sf_plugins_dir.'/stConfigPlugin/lib/sfYaml/Inline.php',
            'Parser' =>  $sf_plugins_dir.'/stConfigPlugin/lib/sfYaml/Parser.php',
            'Unescaper' =>  $sf_plugins_dir.'/stConfigPlugin/lib/sfYaml/Unescaper.php',
            'Yaml' =>  $sf_plugins_dir.'/stConfigPlugin/lib/sfYaml/Yaml.php',
            'DumpException' =>  $sf_plugins_dir.'/stConfigPlugin/lib/sfYaml/Exception/DumpException.php',
            'ParseException' =>  $sf_plugins_dir.'/stConfigPlugin/lib/sfYaml/Exception/ParseException.php',
            'stPhpFastCacheSQLite' => SF_ROOT_DIR.'/lib/stPhpFastCacheSQLite.class.php',
            'MobileDetect' => SF_ROOT_DIR.'/lib/MobileDetect.class.php',
            'stSecurity' => SF_ROOT_DIR.'/lib/stSecurity.class.php'
        );  

        if (isset($classes[$class]))
        {
            include $classes[$class];   
        }      
    }

    public static function helper()
    {
        if (isset($_COOKIE['fastcache']) && $_COOKIE['fastcache'] == 'disabled' || isset($_COOKIE['basket']) && $_COOKIE['basket'])
        {
            return false;
        }

        spl_autoload_register(array('stFastCacheManager', 'simpleAutoload'));

        $sf_plugins_dir = SF_ROOT_DIR.'/plugins';

        sfConfig::set('sf_plugins_dir', $sf_plugins_dir);
        sfConfig::set('sf_root_dir', SF_ROOT_DIR);
        sfConfig::set('sf_root_cache_dir', SF_ROOT_DIR.'/cache');
        sfConfig::set('sf_cache_dir', sfConfig::get('sf_root_cache_dir').'/'.SF_APP.'/'.SF_ENVIRONMENT);
        sfConfig::set('sf_data_dir', SF_ROOT_DIR.'/data');

        $config = stConfig::getInstance('stFastCache');

        if (!$config->get('fast_cache_enabled'))
        {
            return false;
        }

        if (!$config->get('available')) 
        {
            $available = class_exists('PDO') && in_array('sqlite', PDO::getAvailableDrivers());

            $config->set('available', $available);
            
            if ($available) 
            {
                $config->set('fast_cache_enabled', false);
            }

            $config->save();

            if (!$available)
            {
                return false;
            }
        }

        if (stSecurity::getSSL() == 'shop' && (!isset($_SERVER['HTTPS']) || empty($_SERVER['HTTPS'])) && (!isset($_SERVER['HTTP_X_FORWARDED_PROTO']) || $_SERVER['HTTP_X_FORWARDED_PROTO'] != 'https'))
        {
            header('Location: https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], true, 301);
            exit();
        }

        return true;
    }

    public static function getUrlPath()
    {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' ? 'https' : 'http';

        return $protocol.'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    }

    public function __construct($adapter)
    {
        $this->adapter = $adapter;
    }

    public function get($keyword, $expired = null)
    {
        return $this->adapter->get($keyword, $expired);
    }

    public function set($keyword, $value)
    {
        $this->adapter->set($keyword, $value);
    }

    public function has($keyword)
    {
        return $this->adapter->has($keyword);
    }

    public function delete($keyword)
    {
        $this->adapter->delete($keyword);
    }

    public function clean()
    {
        $this->adapter->clean();
    }

    public function dispatch()
    {
        $path = self::getUrlPath();

        $content = $this->get($path);
        
        if ($content)
        {
            echo $content;
            exit;
        }
    }
}
