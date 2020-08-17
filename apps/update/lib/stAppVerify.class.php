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
 * @version     $Id: stAppVerify.class.php 13828 2011-06-29 08:03:01Z michal $
 * @author      Marek Jakubowicz <marek.jakubowicz@sote.pl>
 */
                
/** 
 * Database verification file.
 */
define ("ST_VERIFY_FILE",sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'db'.DIRECTORY_SEPARATOR.'.verify.reg');          

/** 
 * Configuration
 */
define ("ST_VERIFY_CONFIG",sfConfig::get('sf_app_dir').DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.'stInstallerWeb'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'verify.yml'); 

/** 
 * stInstallerIgnore class
 *
 * @package     stUpdate
 * @subpackage  libs
 */
require_once (sfConfig::get('sf_plugins_dir').DIRECTORY_SEPARATOR.'stInstallerPlugin'.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'stInstallerIgnore.class.php');
      
if (! defined("ST_INSTALLER_LOG_PAGE")) define("ST_INSTALLER_LOG_PAGE",sfConfig::get('sf_log_dir').DIRECTORY_SEPARATOR.'webinstaller.log');

sfLoader::loadHelpers('Helper');
use_helper('I18N','Url', 'Tag'); 
use_helper('stProgressBar','Partial');    
    
/** 
 * Code veryfication. Modification detector.
 *
 * @package     stUpdate
 * @subpackage  libs
 */
class stAppVerify
{

    
    /** 
     * Step in progress bar.
     *
     * @param       integer     $count
     * @return  integer     next count
     */
    function step($count)
    {           
        if ($count==0) 
        {                                                           
            // delete verification file
            if (file_exists(ST_VERIFY_FILE)) unlink(ST_VERIFY_FILE);
        }
       
        $apps=$this->getApps();        
        $this->owner = $this->getHttpOwner();
        
        $i=0; reset($apps);
        foreach ($apps as $app)
        {                              

            if ($count==$i)
            {               
                // verify sf_root_dir
                $result=$this->verify($app);                       
                $this->app=$app; 
                // check verification 
                if (! empty($result))
                {            
                    // add app modifications for report
                    $this->register($app,$result);    
                }                
                
                // verify install/src
                // this verification throw exception if something is wrong
                $result_install=$this->verifyPearInstall($app);                
            }
            $i++;
        }                 
        $this->count=$count;    

        $this->apps=$apps;
        
        sleep(1); // reduce cpu limit/time
        
        return $count+1;
    }       
    
    /**
     * Return http owner. 
     * @return string
     */
    private function getHttpOwner()
    {
        $file = sfConfig::get('sf_cache_dir').DIRECTORY_SEPARATOR.'php_http_owner_test.tmp';
        file_put_contents($file,'test');
        $owner=fileowner($file);
        unlink($file);
        return $owner;
    }
                      
    /** 
     * Get apps list to verification. Application which will be installed/upgraded.
     *
     * @return        array       array('stOrder','stCategory',...)
     */
    protected function getApps()
    {
         $regsync = new stRegisterSync();
         $apps_sync=$regsync->getAppsToSync();
         $apps=$apps_sync['all'];
         
         return $apps;
    }
     
     
    /** 
     * Get progress bar step message.
     *
     * @return   string
     */
    public function getMessage()
    {                          
          if (isset($this->count)) 
          {
              return __('Weryfikacja', null, 'stInstallerWeb').': '.$this->app;
          }
          else {       
              // last step               
              if ($this->checkModifications())
              {
                  // wykryto modyfikacje                                
                  return $this->modificationReport();
              } else 
              {                         
                  // wykonaj instalacje/synchronizacje                     
                  return $this->reboot();          
              }
          }
      }             

      /** 
       * Get progress bar title.
       *
       * @return   string
       */
      public function getTitle()
      {
          return __('Weryfikacja', null, 'stInstallerWeb').': ';
      }
      
      /** 
       * Reboot action
       *
       * @return   string
       */
      protected function reboot()
      {
          return progress_bar('Installer', 'stInstallerTasks', 'step', 15);
      }     
      
      /** 
       * Modification report.
       * Show files modified by user.
       *
       * @return   string
       */
      private function modificationReport()
      {                                              
          $data=unserialize(file_get_contents(ST_VERIFY_FILE));  
          return get_partial('stInstallerWeb/report',array("data"=>$data));
      }
         
      /** 
       * Check verification result.
       *
       * @return  bool        true - code was modified, false - code is ok
       */
      private function checkModifications()
      {                
          if (file_exists(ST_VERIFY_FILE)) 
          { 
              $data=unserialize(file_get_contents(ST_VERIFY_FILE));  
              if (is_array($data))
              {                                      
                  foreach ($data as $app=>$files)
                  {
                      if (! empty($files)) return true;
                  }
              } 
          } 
          
          return false;          
      }             
                    
         
    /** 
     * Verify application.
     *
     * @param           $app        application         name
     * @return   array
     */
    public function verify($app)
    {   
         $result=array(); 
         $peari = stPearInfo::getInstance('verify');       
         
         $files=$peari->getFiles($app);
         if (! empty($files))
         {
             
             foreach ($files as $file)
             {        
                 if (! empty($file['attribs']))
                 {
                     $name   = $file['attribs']['name'];
                     $md5sum = $file['attribs']['md5sum'];      

                     $md5sum_current = $this->md5Sum($this->getPath($name)); 
                     if (is_readable($this->getPath($name)))
                        $owner_current  = fileowner($this->getPath($name));
                     else 
                        $owner_current = null;

                     // moved to $this->isFileModified()
                     // old code
                     //
                     // if ((($md5sum!=$md5sum_current) && (! empty($md5sum_current))) || ($owner_current != $this->owner))                    
                     // {    
                     //     // if file exists verify it
                     //     if ((file_exists($this->getPath($name))) && (! empty($name)))
                     //     {   
                     //         if (! $this->ignore($this->getPath($name,true),$app))
                     //         {                         
                     //             $result[$this->getPath($name,true)]=array('md5sum'=>$md5sum,'current'=>$md5sum_current,'modified'=>$this->getModTime($this->getPath($name)),'owner'=>$owner_current);
                     //         }
                     //     }
                     // }
                     //
                     // end
                     
                     // new code
                     if ($this->isFileModified($app,$name,$md5sum,$md5sum_current,$owner_current))
                     {
                         $result[$this->getPath($name,true)]=array('md5sum'=>$md5sum,'current'=>$md5sum_current,'modified'=>$this->getModTime($this->getPath($name)),'owner'=>$owner_current);
                     }
                     // end
                 }
                
            }
            unset($peari);
            
            return $result;
        }         
    }       
    
    /**
     * File verification.
     *
     * @param string $app application (PEAR package name)
     * @param string $name relative file name
     * @param string $md5sum md5 in PEAR database
     * @param string $md5sum_current md5 in filesystem
     * @param string $owner_current owner of the verified file
     * @return bool true - file is modified, false - file is not modified, is OK
     */
    protected function isFileModified($app, $name,$md5sum,$md5sum_current,$owner_current)
    {
        if ((($md5sum!=$md5sum_current) && (! empty($md5sum_current))) || ($owner_current != $this->owner))
        {
            // if file exists verify it
            if ((file_exists($this->getPath($name))) && (! empty($name)))
            {   
                if (! $this->ignore($this->getPath($name,true),$app))
                {                         
                    return true;
                }
            }
        } 

        return false;         
    }
    
    /** 
     * Verify pear installer application. (Downloaded in install/src/stAppName)
     *
     * @param    $app        application         name
     * @return   NULL|Exception
     */
    public function verifyPearInstall($app)
    {   
         $result=array(); 
         $peari = stPearInfo::getInstance();       
         $install_src_dir=sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'src';
         
         $files=$peari->getFiles($app);
         if (! empty($files))
         {             
             foreach ($files as $file)
             {             
                 if (! empty($file['attribs']))
                 {
                     $name   = $file['attribs']['name'];
                     $md5sum = $file['attribs']['md5sum'];      

                     $install_file_1=$install_src_dir.DIRECTORY_SEPARATOR.$app.DIRECTORY_SEPARATOR.$this->getPath($name,true,false);
                     $install_file_2=$install_src_dir.DIRECTORY_SEPARATOR.$app.DIRECTORY_SEPARATOR.$app.DIRECTORY_SEPARATOR.$this->getPath($name,true,false);
                     if (file_exists($install_file_1))
                     {
                         $md5sum_current = $this->md5Sum($install_file_1);  
                         $install_file=$install_file_1;
                     } 
                     elseif (file_exists($install_file_2))
                     {
                         $md5sum_current = $this->md5Sum($install_file_2);  
                         $install_file=$install_file_2;
                     } 
                     else 
                     {
                         throw new Exception("PEAR installation error. File $install_file_1 or $install_file_2 not found in $install_src_dir.");
                     }   

                     if ((file_exists($install_file)) && (is_file($install_file)))
                     {
                         if (($md5sum!=$md5sum_current))
                         {    
                             throw new Exception("PEAR installation error. File $install_file has wrong md5 sum.");
                         }                
                     }
                 }
                                                                                      
            }            
        } else 
        {
            throw new Exception ("PEAR installation error. Empty pear package xml database for app $app");
        }         
        
        unset($peari);
    }    
        
    /** 
     * Check if file needs verification.
     * System does not check md5 sum for files listed in ignore group.
     *
     * @param        string      $file
     * @param   string      $app                application name
     * @return  bool        true - do not verify this file, file is ignored, false - file has to be verified
     */
    protected function ignore($file,$app)
    {                                          
        $config = $this->getConfig();
        $peari  = stPearInfo::getInstance('verify');  
        if (! empty($config['ignore'])) 
        {
            foreach ($config['ignore'] as $ereg)
            {          
                if (strpos($file, $ereg) !== false) {
                    $this->log('md5sum verification '.$file.': false'."\n");
                    return true;
                }
            }
        }

        if (! empty($config['fix'])) 
        {
            foreach ($config['fix'] as $application=>$data)
            {             
                
                foreach ($data as $version=>$files)
                {                                                                 
                    $version_installed=$peari->getPackageVersion($application);    

                    if ($version==$version_installed)
                    {                                        
                        foreach ($files as $ereg)
                        {                                                
                            if (strpos($file, $ereg) !== false) {
                                $this->log('md5sum verification '.$file.': false'."\n");  
                                return true;
                            }
                        }
                    }
                }
            }
        }
        
        unset($peari);    
            
        // Get filed from install/config/ignore/stAppName.yml
        $ignore=$this->getIgnore($app);             
        $this->log("ignore: ".print_r($ignore,true)."\n");
        if (! empty($ignore))
        {
            foreach ($ignore as $disereg)
            {                                 
                $this->log("ereg($disereg,$file);\n");
                if (strpos($file, $disereg) !== false)
                        return true;
            }
        }             

        $ignoreReplace = stInstallerIgnore::getIgnoreReplace($app);
        if (! empty($ignoreReplace)) 
        {
            foreach ($ignoreReplace as $pattern)
            {       
                $this->log("preg_match($pattern,$file);\n");   
                if (preg_match($pattern, $file)) return true;
            }
        }  
        
        return false;
    } 
     /** 
      * Get file modification date.
      *
      * @param        string      $file
      * @return   string
      */
     private function getModTime($file)
     {
         if (file_exists($file)) {
            return date ("Y-m-d H:i:s", filemtime($file));
         }
     }
      
     
    /** 
     * Get full path to file.
     *
     * @param   string      $path               stProduct/apps/backend/modules/stProduct/config/config.php
     * @param   bool        $relative           relative path (true) or full path (false)
     * @param   string      $sf_root_dir        true - add sf_root_dir , false without sf_root_dir (for $relative=true)
     * @return       string      /path/soteshop/apps/backend/modules/stProduct/config/config.php
     */
    protected function getPath($file,$relative=false,$sf_root_dir=true)
    {
        // $dat=preg_split(DIRECTORY_SEPARATOR,$file);
        $dat=preg_split("/\\".DIRECTORY_SEPARATOR."/",$file);
        if (! $relative) $path=sfConfig::get('sf_root_dir');
        else 
        {
            if ($sf_root_dir)
            {
                $path=basename(sfConfig::get('sf_root_dir'));
            } else
            {
                $path='';
            }
        }

        $i=0;
        foreach ($dat as $item) 
        {
            if ($i>0) $path.=DIRECTORY_SEPARATOR.$item;
            $i++;
        }                                    

        return $path;
    }
     
    /** 
     * Get file md5 sum.
     *
     * @param   string      $file               full path to file
     * @return       string      md5
     */
    private function md5Sum($file)
    {    
        if (file_exists($file))
        {
            $data=file_get_contents($file);
            return md5($data);
        }
    }        

    /** 
     * Save verification result in file.
     *
     * @param                  string      $app                application
     * @param   array       $result             modified files
     */
    private function register($app,$result)
    {
        if (file_exists(ST_VERIFY_FILE))
        {
            $data=unserialize(file_get_contents(ST_VERIFY_FILE));
        } else $data=array();

            $data[$app]=$result;
            $data2=serialize($data);
            file_put_contents(ST_VERIFY_FILE,$data2);            
    }    
    
    /** 
     * Get configuration.
     *
     * @see config/verify.yml
     */
    private function getConfig()
    {                                         
        $verify=sfYaml::load(ST_VERIFY_CONFIG);
        return $verify['verify'];
    }            
    
    /** 
     * Get file ignored files with ereg expression.
     *
     * @param   string      $app                application name
     * @return   array
     */
    private function getIgnore($app)
    {                                 
       return stInstallerIgnore::getIgnore($app);   
    }       
    
    /** 
     * Write to logs.
     *
     * @param        string      $message
     */
    protected function log($message)
    {                       
        if (sfConfig::get('sf_logging_enabled'))
        {
             $fd=fopen(ST_INSTALLER_LOG_PAGE,"a+");
             fwrite($fd,$message);
             fclose($fd);
        }                
    }
}