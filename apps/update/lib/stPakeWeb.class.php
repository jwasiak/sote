<?php
/** 
 * SOTESHOP/stUpdate 
 * 
 * This file is the part of stUpdate application. License: (Open License SOTE) Open License SOTE. 
 * Do not modify this file, system will overwrite it during upgrade.
 * 
 * @package     stUpdate
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Open License SOTE
 * @version     $Id: stPakeWeb.class.php 9614 2010-11-29 11:31:27Z marek $
 * @author      Marek Jakubowicz <marek.jakubowicz@sote.pl>
 */

/** 
 * Web Symfony tasks.
 *
 * @author Marek Jakubowicz <marek.jakubowicz@sote.pl>
 *
 * @package     stUpdate
 * @subpackage  libs
 */
class stPakeWeb 
{   
    /** 
     * @var string $content task result STDUOT
     */
    var $content=''; 
    
    /** 
     * @var string $error error message
     */
    var $error='';  
    
    /** 
     * @var string path to symfony - has to be set but system doesn't use it
     */
    var $symfony='/usr/bin/symfony';
                         
    /** 
     *  Execute task
     *
     * @param   string      np.                 propel-build-model, cc
     * @return   bool
     */
    public function run($webtask)                 
    {                                   
        if (empty($webtask)) { 
            $this->error='Empty parameter task';           
            return false;
        }
        
        // clean Fast Cache
        if ($webtask=='cc') 
        {
            if (class_exists('stFastCacheManager'))
            {
                stFastCacheManager::clearCache();
            }
        }
        
        // symfony directories
        $sf_symfony_lib_dir  = sfConfig::get('sf_symfony_lib_dir');
        $sf_symfony_data_dir = sfConfig::get('sf_symfony_data_dir');
        
        $sf_root_dir=sfConfig::get('sf_root_dir');    
        chdir($sf_root_dir);

        // force populating $argc and $argv in the case PHP does not automatically create them (fixes #2943)
        $argc=array();
        $argv=array($this->symfony,$webtask);    

        $pakelib=$sf_root_dir.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.'update'.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'stPake.php';                                  
        require_once($pakelib);                                  

        $pake = pakeApp::get_instance();
        try 
        {       
            ob_start(); 
            $ret = $pake->run(null, $webtask, false);     // execute task
            $content = ob_get_clean();    
            $this->content = $content;   
            return true;
        }                                             
        catch (Exception $ret) 
        {
            $this->error = $ret->getMessage();          
            return false;
        }                          
    }
}