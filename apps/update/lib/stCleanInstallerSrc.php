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
 * @version     $Id: stCleanInstallerSrc.php 10048 2010-12-29 16:37:55Z michal $
 * @author      Marek Jakubowicz <marek.jakubowicz@sote.pl>
 */
 
sfLoader::loadHelpers('Helper');
use_helper('I18N','Url', 'Tag'); 
use_helper('stProgressBar','Partial');                 

define ("ST_CLEAN_INSTALLER_DB_SRC",sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'db'.DIRECTORY_SEPARATOR.'.cleaninstaller_src.reg'); 
                                                                                                                                                                
/** 
 * stPearDownload class (stInstallerPlugin)
 *
 * @package     stUpdate
 * @subpackage  libs
 */
require_once (sfConfig::get('sf_plugins_dir').DIRECTORY_SEPARATOR.'stInstallerPlugin'.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'stPearDownload.class.php');                             
 
/** 
 * Delete install/src files.
 *
 * @package     stUpdate
 * @subpackage  libs
 */
class stCleanInstallerSrc
{                             
    public $count = null;
    
    public $msg = '';
    
    public function step($step)
    {              
        $this->packages = $this->getPackages();
        $this->max = sizeof($this->packages);      
        if (! empty($this->packages[$step])) 
        {
            $pkg_name = $this->packages[$step];
            $this->msg=__('Czyszczę', null, 'stInstallerWeb').': '.$pkg_name;
            
            $pd = new stPearDownload('src');     
            $pd->deletePackage($pkg_name);                 
        }
        
        return $step+1;
    }                  
    
    
    public function getMessage()
    {                
        return $this->msg;      
    }          
    
    public function getTitle()
    {
        return __('Optymalizacja ilości plików', null, 'stInstallerWeb');
    }         
    
    static public function getSteps()
    {   
        $pd = new stPearDownload('src');
        $packages_src = $pd->getPackages();
        $packages = $packages_src;    
        
        if (sizeof($packages)>0) return sizeof($packages);
        else return 1;
              
    }
    
    public function close()
    {
        unlink(ST_CLEAN_INSTALLER_DB_SRC);

        sfLoader::loadHelpers('Tag');
        sfLoader::loadHelpers('Javascript');

        $this->msg.="<script type=\"text/javascript\">document.getElementById('stSetup-install_actions').style.visibility=\"visible\";</script>";
    }
               
    protected function getPackages()
    {
        if (! file_exists(ST_CLEAN_INSTALLER_DB_SRC))
        {
            $pd = new stPearDownload('src');
            $packages = $pd->getPackages();
            $data = serialize($packages);
            file_put_contents(ST_CLEAN_INSTALLER_DB_SRC,$data);         
        } else {
            $datareg = file_get_contents(ST_CLEAN_INSTALLER_DB_SRC);
            $packages=unserialize($datareg); 
        }     
        return $packages;                                                   
    }               
}

