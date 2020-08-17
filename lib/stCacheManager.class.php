<?php
/**
 * SOTESHOP/stBase
 *
 * Ten plik należy do aplikacji stBase opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stBase
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stCacheManager.class.php 7 2009-08-24 08:59:30Z michal $
 */

/**
 * Przeciążenie sfViewCacheManager - obsługa cache pomiędzy aplikacjami
 * 
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 * 
 * @package     stBase
 * @subpackage  libs
 */
class stViewCacheManager extends sfViewCacheManager
{
    protected $appName = null;
    
    protected $enviroment = null;
    
    /**
     * Konstruktora klasy 
     *
     * @param sfContext $context Instancja obiektu sfContext
     * @param string $app_name Nazwa aplikacji (domyślnie przyjmuje nazwę aplikacji w której wywołaliśmy metodę ::getViewCache)
     * @param string $enviroment Nazwa środowiska (domyślnie przyjmuje nazwę środowiska w którym wywołaliśmy metodę ::getViewCache)
     */
    public function __construct($context, $app_name = null, $enviroment = null)
    {
        $this->appName = is_null($app_name) ? SF_APP : $app_name;
        
        $this->enviroment = is_null($enviroment) ? SF_ENVIRONMENT : $enviroment;        
   
        $this->initialize($context, sfConfig::get('sf_factory_view_cache', 'sfFileCache'), sfConfig::get('sf_factory_view_cache_parameters', array('automaticCleaningFactor' => 0, 'cacheDir' => sfConfig::get('sf_root_cache_dir') . DIRECTORY_SEPARATOR . $this->appName . DIRECTORY_SEPARATOR . $this->enviroment . DIRECTORY_SEPARATOR . 'template')));
  
    }
    
    public function generateNamespace($internal_uri)
    {
         
        $this->context->getRequest()->setScriptNameByApp($this->appName);
        
        $ret = parent::generateNamespace($internal_uri);
        
        $this->context->getRequest()->setScriptNameByApp(SF_APP);
        
      
        
        return $ret;
    }
    
    public function start($name, $lifeTime, $clientLifeTime = null, $vary = array())
    {
        $this->context->getRequest()->setScriptNameByApp($this->appName);
        
        $ret = parent::start($name, $lifeTime, $clientLifeTime, $vary);

        $this->context->getRequest()->setScriptNameByApp(SF_APP);
        
        return $ret;        
    }
    
    public function stop($name)
    {
        $this->context->getRequest()->setScriptNameByApp($this->appName);
        
        $ret = parent::stop($name);

        $this->context->getRequest()->setScriptNameByApp(SF_APP);
        
        return $ret;      
    }
}

/**
 * Klasa stCacheManager
 * 
 * @package     stBase
 * @subpackage  libs
 */
class stCacheManager
{
    
    protected static $instance = array();
    
    /**
     * Zwraca instancję obiektu stViewCacheManager dla danej aplikacji pracującej w danym środowisku
     *
     * @author Marcin Butlak <marcin.butlak@sote.pl>
     * 
     * @param sfContext $context Instancja obiektu sfContext
     * @param string $app_name Nazwa aplikacji (domyślnie przyjmuje nazwę aplikacji w której wywołaliśmy metodę ::getViewCache)
     * @param string $enviroment Nazwa środowiska (domyślnie przyjmuje nazwę środowiska w którym wywołaliśmy metodę ::getViewCache)
     * @return stViewCacheManager
     */
    public static function getViewCache($context, $app_name = null, $enviroment = null)
    {
        $app_name = is_null($app_name) ? SF_APP : $app_name;
        
        $enviroment = is_null($enviroment) ? SF_ENVIRONMENT : $app_name;
        
       
        if (!isset(self::$instance[$app_name]))
        {
            self::$instance[$app_name] = new stViewCacheManager($context, $app_name, $enviroment);
        }
        
        return self::$instance[$app_name];
    }
    
    /**
     * Usuwanie cachy 
     *
     * @param string $cache
     */
    public static function remove($cache = '')
    {
        $sf_root_cache_dir = sfConfig::get('sf_root_cache_dir');
        $cache_dir = $sf_root_cache_dir . '/*/*/template/*/all/*/';
        sfToolkit::clearGlob($cache_dir . $cache);
    }
}