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
 * @version     $Id: stCleanInstallerDownload.class.php 10048 2010-12-29 16:37:55Z michal $
 * @author      Marek Jakubowicz <marek.jakubowicz@sote.pl>
 */
 
sfLoader::loadHelpers('Helper');
use_helper('I18N','Url', 'Tag'); 
use_helper('stProgressBar','Partial');                 

define ("ST_CLEAN_INSTALLER_DB",sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'db'.DIRECTORY_SEPARATOR.'.cleaninstaller.reg'); 
                                                                                                                                                                
/** 
 * stPearDownload class (stInstallerPlugin)
 *
 * @package     stUpdate
 * @subpackage  libs
 */
require_once (sfConfig::get('sf_plugins_dir').DIRECTORY_SEPARATOR.'stInstallerPlugin'.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'stPearDownload.class.php');                             
 
/** 
 * Delete PEAR download packages.
 *
 * @package     stUpdate
 * @subpackage  libs
 */
class stCleanInstallerDownload 
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
            
            $pd = new stPearDownload();     
            $pd->deletePackage($pkg_name);        
            
            // $pd_src = new stPearDownload('src');     
            // $pd_src->deletePackage($pkg_name);              
        }
        
        return $step+1;
    }                  
    
    public function getMessage()
    {                
        return $this->msg;      
    }          
    
    public function getTitle()
    {
        return __('Czyszczenie poprzedniej aktualizacji', null, 'stInstallerWeb');
    }         
    
    static public function getSteps()
    {   
        $pd = new stPearDownload();
        $packages_download = $pd->getPackages();
        
        // $pd_src = new stPearDownload('src');
        // $packages_src = $pd_src->getPackages();
        
        // $packages = intval($packages_download)+intval($packages_src);
        $packages = $packages_download;
        
        if (sizeof($packages)>0) return sizeof($packages);
        else return 1;
              
    }
               
    public function close()
    {
        unlink(ST_CLEAN_INSTALLER_DB);
    }
               
    protected function getPackages()
    {
        if (! file_exists(ST_CLEAN_INSTALLER_DB))
        {
            $pd = new stPearDownload();
            $packages = $pd->getPackages();
            $data = serialize($packages);
            file_put_contents(ST_CLEAN_INSTALLER_DB,$data); 
            return $packages;
        } else {
            $datareg = file_get_contents(ST_CLEAN_INSTALLER_DB);
            return unserialize($datareg);
        }                                                        
    }               
}

