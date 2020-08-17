<?php
/**
 * @author      Marek Jakubowicz <marek.jakubowicz@sote.pl>
 */
 
/**
 * stfastCache progress bar
 */
class stFastCache 
{
	protected $msg = '';
	
    public static $pages=array(
                        
        "STANDARD" => array(
            "/stMixerFrontend/index",
        ),
        
        "DEFAULT" => array(
            "/",
            "/lang/en",
            "/lang/pl",            
        ),
        
    );    
    
    /**
     * Number of steps. Number of cached pages.
     */
    public static function getSteps()
    {        
        return sizeof(stFastCache::$pages['STANDARD']);
    }

    public function step($step)
    {
        $hostname=sfContext::getInstance()->getRequest()->getHost();
        $page="http://".$hostname.'/'.stFastCache::$pages['STANDARD'][$step].'/hash/'.$this->getHash();        
        $b = new sfWebBrowser(array(), null, array('ssl_verify' => false, 'ssl_verify_host' => false));
        $b->get($page,array());               
        // $res = $b->getResponseText();
        
        return $step+1;
    }
    
    /**
     * Get hash for fast cache saving URI
     */
    public function getHash()
    {
        return '123456';
    }
    
    public function getMessage()
    {
    	return $this->msg;
    }
}