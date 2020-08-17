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
 * @version     $Id: stInstallerFrontendWeb.class.php 4621 2010-04-19 17:06:15Z marek $
 */
  
/** 
 * PEAR base classes
 * @todo add PEAR.php verification (eg. for Windows installation), check include_path
 */
error_reporting(($errorsCode = error_reporting()) & ~E_STRICT);

require_once 'PEAR.php';
require_once 'PEAR/Frontend.php';
require_once 'PEAR/Command.php';        
require_once 'PEAR/Config.php';  
require_once 'PEAR/Registry.php'; 
require_once 'PEAR/Frontend/CLI.php';   

error_reporting($errorsCode);

/**
 * PEAR Frontend Web class
 */
require_once (sfConfig::get('sf_app_module_dir').DIRECTORY_SEPARATOR.'stInstallerWeb'.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'stPearFrontendWeb.class.php'); 

 
/** 
 * Installer Frontend Web
 *
 * @package     stUpdate
 * @subpackage  libs
 */
class stInstallerFrontendWeb 
{   
     /** 
      * @var string Error messages.
      */
     var $error='';
    
     /** 
      * @var stPearFrontendWeb PEAR Frontend.
      */
     var $ui;
     
    /** 
     * Construct.
     *
     * @param   string      $pear_user_config   path to .pearrc file (install/src/.pearrc)
     * @return   bool
     */
    function __construct($pear_user_config='')
    {          
        
        // PEAR Config file          
        if (empty($pear_user_config)) $pear_user_config=sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'.pearrc';               
        
        // Init PEAR configuration
        // @see PEAR_Frontend_Web PEAR/Frontend/Web.php
        $GLOBALS['_PEAR_Frontend_Web_config'] = PEAR_Config::singleton($pear_user_config, $pear_user_config); 
        $this->config = $GLOBALS['_PEAR_Frontend_Web_config'];
        if (PEAR::isError($this->config)) {
            throw new Exception('<b>Error:</b> '.$this->config->getMessage());
        }                                                             
        // end        

        // Init PEAR Frontend class
        // PEAR_Frontend::setFrontendClass('PEAR_Frontend_CLI');  
        PEAR_Frontend::setFrontendClass('stPearFrontendWeb');      
        PEAR_Frontend::setFrontendObject($this->ui); 
                                                      
        return true;      
    }         
    
     /** 
      * Execute PEAR command.
      *
      * @param   string      $command            PEAR command eg. 'install'
      * @param   array       $params             parameters np. array('pear.dev.quad.sote.pl/stApplicationTest')
      * @param   array       $opts               options np. array('force'=>false,...)
      * @return   bool
      */
     public function command($command,$params=array(),$opts=array())
     {   
         if (sfConfig::get('sf_debug') && sfConfig::get('sf_logging_enabled')) $timer = sfTimerManager::getTimer('__SOTE executeUpgradeList stInstallerFrontendWeb::command('.$command.')'); 
         if (($command=='install') && (! sizeof($opts)))
         {
             $opts['onlyreqdeps'] = true;
             $opts['force'] = false;
         }   
         
         // install force (eg. upload action)
         if ($command=='force-install')
         {
             $command='install';
             $opts['force'] = true;
         }
         
         $cmd = PEAR_Command::factory($command, $this->config);    
          
         if (PEAR::isError($cmd))
         {
             $this->error=$cmd->getMessage();
         } else
         {
             // execute PEAR command   
             $ok = $cmd->run($command, $opts, $params); 

             if (PEAR::isError($ok)) {          
                 $this->error=$ok->getMessage();
             }                                  
         }               
              
         if (sfConfig::get('sf_debug') && sfConfig::get('sf_logging_enabled')) $timer->addTime(); 
         return true;
     }                  
     
      /** 
       * Get Errors.
       *
       * @return   string
       */
      public function getErrors()
      {
          return $this->error;
      }
}            

     
