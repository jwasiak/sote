<?php
/**
 * @author      Marek Jakubowicz <marek.jakubowicz@sote.pl>
 */
 
/**
 * stfastCache progress bar
 */
class stFastCacheDefault extends stFastCache
{

    public static function getSteps()
    {        
        return sizeof(stFastCache::$pages['DEFAULT']);
    }

    public function step($step)
    {
        $hostname=sfContext::getInstance()->getRequest()->getHost();
        $page="http://".$hostname.'/'.stFastCache::$pages['DEFAULT'][$step];
        
        // Caching pages in default mode
        $b = new sfWebBrowser();
        $b->get($page,array('hash'=>$this->getHash(),'default'=>1));
        
        // Caching the same pages without default mode
        $c = new sfWebBrowser();
        $c->get($page,array('hash'=>$this->getHash()));
        
        // $res = $b->getResponseText();
        
        return $step+1;
    }
    
}