<?php
/**
 * @author      Marek Jakubowicz <marek.jakubowicz@sote.pl>
 */
 
/**
 * stfastCache progress bar
 */
class stFastCacheSEO extends stFastCache
{
	protected static $methods = array();
	
	protected static $steps = 0;

    protected static $max_skip = 100;
	
	public static function registerFastCacheLink($name, $class, $method, $steps)
	{
		if ($steps > 0 )
		{
			self::$methods[] = array('class'=>$class,
												'method'=>$method,
												'steps'=>$steps,
											    'name'=>$name,
												'limit'=>self::$steps+$steps,
												'start'=>self::$steps
												);
			self::$steps += $steps;
		}
	} 
	
	public static function getMethod($step)
	{
		foreach (self::$methods as $method)
		{
			if ($step < $method['limit']){
				return $method;
			} 
		}
		return '';
	}
	
    public static function getSteps()
    {
    	self::Init();
		return self::$steps;
    }
    
    public static function Init()
    {
        self::registerFastCacheLink('main_page', 'stFastCacheSEO', 'mainPageLink', 1);

        //$config = stConfig::getInstance(sfContext::getInstance(), array( 'show_without_price' => stConfig::BOOL),'stProduct' );
        //$c = new Criteria();
        //$c->add(ProductPeer::ACTIVE,1);
        //if ($config->get('show_without_price')) $c->add(ProductPeer::PRICE,0,Criteria::GREATER_THAN);

        //self::registerFastCacheLink('group', 'stFastCacheSEO', 'productLink', ProductPeer::doCount($c));    
    	
        // rejestracja linkow webpage
        $c = new Criteria();
        $c->add(WebpagePeer::ACTIVE, 1);
        self::registerFastCacheLink('webpage', 'stFastCacheSEO', 'webPageLink', WebpagePeer::doCount($c));
        self::registerFastCacheLink('category', 'stFastCacheSEO', 'categoryLink', CategoryPeer::doCount(new Criteria()));
        self::registerFastCacheLink('group', 'stFastCacheSEO', 'productGroupLink', ProductGroupPeer::doCount(new Criteria()));
        
    }

    public function generateCache($step)
    {
		$method = stFastCacheSEO::getMethod($step);
		if (is_callable($method['class'].'::'.$method['method'])) {
            
			return call_user_func($method['class'].'::'.$method['method'], $step-$method['start'],$this->getHash());
		}
    }
      
    public function step($step)
    {
    	// usuwanie plikow cache
        if ($step == 0 && sfContext::getInstance()->getRequest()->hasParameter('del'))
        {
			stFastCacheManager::clearCache(); 
        }
        
        sfLoader::loadHelpers('Helper');
        sfLoader::loadHelpers('Tag');
        sfLoader::loadHelpers('stUrl');
    	
    	stFastCacheSEO::Init();
        $old_conf = sfConfig::get('sf_no_script_name');
        sfConfig::set('sf_no_script_name',1);
        $this->addRouting();
        $skipped = $processed = 0;

        while ($processed==0 && $skipped < self::$max_skip && $step<=self::$steps) 
        {
            if ($this->generateCache($step)!=0) $processed++;
            else $skipped++;
            $step++;
        }
        if ($step>self::$steps) $step = self::$steps;

        sfConfig::set('sf_no_script_name',$old_conf);

        $resume_file = sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'fastcache'.DIRECTORY_SEPARATOR.'db'.DIRECTORY_SEPARATOR.'fast_cache_running';
        $data = array('step'=>$step+1);
        file_put_contents($resume_file, sfYaml::dump($data));

        return $step;
    }

    protected function addRouting() {
        stPluginHelper::addRouting('stBackendProductUrlLang', '/:lang/:url.html', 'stProduct', 'show', 'backend', array(), array('lang' => '[a-z]{2,4}'));
        stPluginHelper::addRouting('stBackendProductUrl', '/:url.html', 'stProduct', 'show', 'backend');
        stPluginHelper::addRouting('stBackendProductCategoryUrlLang3', '/category/:lang/:url', 'stProduct', 'list', 'backend', array(), array('lang' => '[a-z]{2,4}'));
        stPluginHelper::addRouting('stBackendProductCategoryUrl3', '/category/:url', 'stProduct', 'list', 'backend');
        stPluginHelper::addRouting('stBackendWebpageUrlLang', '/webpage/:lang/:url.html', 'stWebpageFrontend', 'index', 'backend');
        stPluginHelper::addRouting('stBackendWebpageUrl', '/webpage/:url.html', 'stWebpageFrontend', 'index', 'backend');
        stPluginHelper::addRouting('stBackendProductGroupUrlLang4', '/group/:lang/:url', 'stProduct', 'groupList', 'backend', array(), array('lang' => '[a-z]{2,4}'));
        stPluginHelper::addRouting('stBackendProductGroupUrl4', '/group/:url', 'stProduct', 'groupList', 'backend');
        stPluginHelper::addRouting('stFrontendMain', '/', 'stFrontendMain', 'index', 'backend');
        stPluginHelper::addRouting('stFrontendMainLang', '/lang/:lang', 'stFrontendMain', 'index', 'backend');
    }
    
 	public static function webPageLink($offset, $hash)
 	{
 		$c = new Criteria();
 		$c->add(WebpagePeer::ACTIVE, 1);
 		$c->setLimit(1);
 		$c->setOffset($offset);
 		$webpage = WebPagePeer::doSelectOne($c);
        $processed = 0;
 		if (is_object($webpage))
 		{
            $language = stLanguage::getInstance(sfContext::getInstance());                
    		foreach (LanguagePeer::doSelect(new Criteria()) as $lang)
 			{
 			    $host = $language->hasLangParameterInUrl($lang->getShortcut())?sfContext::getInstance()->getRequest()->getHost():$language->hasLangParameterInUrl($lang->getShortcut(),true);
 				$webpage->setCulture($lang->getOriginalLanguage());
 				if (stFastCacheSEO::writeCache(st_url_for(
 					"stWebpageFrontend/index?url=".$webpage->getFriendlyUrl(),
 					true, 
 					'frontend', 
 					$host, 
 					$lang->getShortcut()),
 					$hash, $host)) $processed=1;
 			}
 		}
        return $processed;
 	}
 	
 	public static function categoryLink($offset, $hash)
 	{
 		$c = new Criteria();
 		$c->setLimit(1);
 		$c->setOffset($offset);
 		$category = CategoryPeer::doSelectOne($c);
        $processed = 0;
 		if (is_object($category))
 		{
            $language = stLanguage::getInstance(sfContext::getInstance());                
   			foreach (LanguagePeer::doSelect(new Criteria()) as $lang)
 			{
 			    $host = $language->hasLangParameterInUrl($lang->getShortcut())?sfContext::getInstance()->getRequest()->getHost():$language->hasLangParameterInUrl($lang->getShortcut(),true);
 				$category->setCulture($lang->getOriginalLanguage());
 				if (stFastCacheSEO::writeCache(st_url_for(
 					"stProduct/list?url=".$category->getFriendlyUrl(),
 					true, 
 					'frontend', 
 					$host, 
 					$lang->getShortcut()),
 					$hash, $host)) $processed=1;
 			}
 		}
        return $processed;
 	}
 	 	
 	public static function productGroupLink($offset, $hash)
 	{
 		$c = new Criteria();
 		$c->setLimit(1);
 		$c->setOffset($offset);
 		$productGroup = ProductGroupPeer::doSelectOne($c);
        $processed = 0;
 		if (is_object($productGroup))
 		{
            $language = stLanguage::getInstance(sfContext::getInstance());                
  			foreach (LanguagePeer::doSelect(new Criteria()) as $lang)
 			{
 			    $host = $language->hasLangParameterInUrl($lang->getShortcut())?sfContext::getInstance()->getRequest()->getHost():$language->hasLangParameterInUrl($lang->getShortcut(),true);
 				$productGroup->setCulture($lang->getOriginalLanguage());
 				if (stFastCacheSEO::writeCache(st_url_for(
 					"stProduct/groupList?url=".$productGroup->getFriendlyUrl(),
 					true, 
 					'frontend', 
 					$host, 
 					$lang->getShortcut()),
 					$hash, $host)) $processed=1; 			
 			}
 		}
        return $processed;
 	}  	
 	
 	public static function productLink($offset, $hash)
 	{
        $config = stConfig::getInstance(sfContext::getInstance(), array( 'show_without_price' => stConfig::BOOL),'stProduct' );
        $c = new Criteria();
        $c->add(ProductPeer::ACTIVE,1);
        if ($config->get('show_without_price')) $c->add(ProductPeer::PRICE,0,Criteria::GREATER_THAN);
 		$c->setLimit(1);
 		$c->setOffset($offset);
 		$product = ProductPeer::doSelectOne($c);
        $processed = 0;
 		if (is_object($product))
 		{

            $language = stLanguage::getInstance(sfContext::getInstance());                
    		foreach (LanguagePeer::doSelect(new Criteria()) as $lang)
 			{
 				$product->setCulture($lang->getOriginalLanguage());
 			    $host = $language->hasLangParameterInUrl($lang->getShortcut())?sfContext::getInstance()->getRequest()->getHost():$language->hasLangParameterInUrl($lang->getShortcut(),true);
 				if (stFastCacheSEO::writeCache(st_url_for(
 					"stProduct/show?url=".$product->getFriendlyUrl(),
 					true, 
 					'frontend', 
                    $host,
 					$lang->getShortcut()),
 					$hash, $host)) $processed=1;
 			}
 		}
        return $processed;
 	}  	
 	
    public static function mainPageLink($offset, $hash)
    {
        $language = stLanguage::getInstance(sfContext::getInstance()); 
        $processed = 0;
		foreach (LanguagePeer::doSelect(new Criteria()) as $lang)
 		{
		    $host = $language->hasLangParameterInUrl($lang->getShortcut())?sfContext::getInstance()->getRequest()->getHost():$language->hasLangParameterInUrl($lang->getShortcut(),true);

            if (stFastCacheSEO::writeCache(st_url_for(
 					"stFrontendMain/index",
 					true, 
 					'frontend', 
                    $host,
 					$lang->getShortcut()),
 					$hash, $host, array('default'=>1))) $processed=1;
            
 				if (stFastCacheSEO::writeCache(st_url_for(
 					"stFrontendMain/index",
 					true, 
 					'frontend', 
                    $host,
 					$lang->getShortcut()),
 					$hash, $host)) $processed=1;
 					
        }
        return $processed;
    }


    public function close()
    {
        $resume_file = sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'fastcache'.DIRECTORY_SEPARATOR.'db'.DIRECTORY_SEPARATOR.'fast_cache_running';
        $enabled_file = sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'fastcache'.DIRECTORY_SEPARATOR.'db'.DIRECTORY_SEPARATOR.'fast_cache_enabled';
        unlink($resume_file);
        unlink($enabled_file);
        touch($enabled_file);
    }

 	public static function writeCache($link, $hash, $host, $params = array())
 	{
        $file = str_replace('http://'.$host, '',$link);
 		$params = array_merge($params, array('hash'=>md5($file)));
        if (!sfSuperCacheFilter::hasEntry($host,$file,null))
        {
            $b = new sfWebBrowser();
        	$b->get($link,$params);
        	return true;
        }
		return false;
	} 
}