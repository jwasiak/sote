<?php
/**
 * Changelog class 
 * Checking system befora installation
 *
 * @author      Marek Jakubowicz <marek.jakubowicz@sote.pl>
 */

/**
 * Changlog
 */
class stChangelog
{
    /**
     * @var bool List of changelog.yml files in install/src
     */
    var $changelog_files=NULL;
    
    /**
     * @var bool true if templates smarty are changed 
     * Method smartyTemplatesChanged is defined in changelog.yml
     */
    var $smarty_changed=false;
    
    /**
     * Constructor
     */
    function __construct()
    {
        $this->apps_new   = $this->readSyncUpgrades();
        $this->apps_pear  = $this->readPearUpgrades();
        $this->files      = $this->readAllFiles();        
        $this->active_contents  = $this->readActiveContents();
    }
    
    /**
     * get all changelog files
     */
    protected function readAllFiles()
    {
        $install_dir=sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'src';
        $apps=$this->getSyncUpgrades();
        $files=array();

        foreach ($apps as $app)
        {
           $file = $install_dir.DIRECTORY_SEPARATOR.$app.DIRECTORY_SEPARATOR.'packages'.DIRECTORY_SEPARATOR.$app.DIRECTORY_SEPARATOR.'changelog.yml';
           if (file_exists($file))
           {
               $files[$app]=$file;
           }
        }
        if (! empty($files)) return $files;        
        else return NULL;
    }
    
    /**
     * Return all changelog.yml files
     */
    public function getAllFiles()
    {        
        return $this->files;
    }
    
    /**
     * Read sync list
     * @return arra return 
     */
    protected function readPearUpgrades() {
        $result = array();
        $newPackages = $this->getSyncUpgrades();

        foreach (stPear::getInstalledPackages() as $package => $version)
            if (in_array($package, $newPackages))
                $result[$package] = $version;

        return $result;
    }
    
    /**
     * Get pear list
     * @return array
     */
    public function getPearUpgrades()
    {
        return $this->apps_pear;
    }   
    
    /**
     * Get PEAR version for the app
     *
     * @param string $app Application
     * @return string Version
     */
    protected function getPearVersion($app)
    {
        if (! empty($this->apps_pear[$app])) return $this->apps_pear[$app];
        else return NULL;
    }
    
       
    /**
     * Read sync list
     * @return arra return 
     */
    protected function readSyncUpgrades()
    {
         $regsync = new stRegisterSync();
         $apps_sync=$regsync->getAppsToSync();     

         if (! empty($apps_sync['all'])) 
         {
             return $apps_sync['all'];
         } else return NULL;
    }
    
    /**
     * Get sync list
     * @return array
     */
    public function getSyncUpgrades()
    {
        return $this->apps_new;
    }    
    
    /**
     * Check if there ary any changelog information in install/src, active
     * @return bool
     */
    public function isAnyActive()
    {
        if (! empty($this->active_contents)) return true;
        else return false;
    }
    
    /**
     * Return information if smarty templates were changed
     * @return bool true - changed, false - not
     */
    public function isSmartyChanged()
    {
        if ($this->smarty_changed) return true;
        else return false;
    }
    
    /**
     * Get smarty theme
     * @return string Theme name
     */
    public function getSmartyTheme()
    {
        if (! empty($this->smarty_theme)) return $this->smarty_theme;
        else return NULL;
    }
    
    /**
     * Check if there is any active change log for sync apps and current PEAR apps versions
     * @return array() list of active files
     */
    protected function readActiveContents()
    {
        $contents = $this->getContents();
        $contents_active=array();
        
        $this->smarty_changed=false;
        
        // echo "<pre>app_content:";print_r($contents);echo "</pre>";
        
        if (! empty($contents))
        {
            foreach ($contents as $app=>$contents_app)
            {
                foreach ($contents_app['changelog'] as $keyname=>$content)
                {
                    $add_version=0; $add_method=0;
                    if (! empty($content['version']))
                    {
                         // echo "<pre>version: ";print_r($content['changelog']['version']);echo "</pre>";
                         if ($this->checkVersion($app,$content['version']))
                         {                            
                             $add_version=1;
                         } else 
                         {
                             return $contents_active;
                         }
                    }

                    // echo "<pre>";print_r($contents_app);echo "</pre>";

                    if ((! empty($content['method']['name'])) && ($add_version==1))
                    {
                        
                         // echo "<pre>method: ";print_r($content['changelog']['method']['name']);echo "</pre>";
                         // $myobject = new stChangelogFunctions();
                         $method=$content['method']['name'];                         

                         if (! empty($content['method']['params']))
                         {
                             $params=$content['method']['params'];                            
                         } else $params=array();

                         if (! empty($content['priority']))
                         {
                             $priority=$content['priority'];
                         } else $priority=5; // 1 - important , 5 - minor changes

                         // $result=call_user_func(array($myobject, $method), $params);

                         $this->call_ret=call_user_func_array (array('stChangelogFunctions', $method), array($app,$params,'condition')); 
                         if (! empty($this->call_ret['result']))
                         {                             
                             $this->result['P'.$priority][$app][$keyname]['data']   = $this->call_ret['result'];
                             $this->result['P'.$priority][$app][$keyname]['method'] = $method;
                             
                             // there yopu can add more information from changelog.yml for template             
                             // $this->result['P'.$priority][$app][$keyname]['keyname_params']['yourkey']    = value
                             $this->result['P'.$priority][$app][$keyname]['keyname_params']['url']    = $content['url'];
                             
                         }
                         // echo "<pre>app=$app :";print_r($result);echo "</pre>";
                         if ($this->call_ret['return'])
                         {       
                             // addidtional info for smarty method                      
                             if ($method=='smartyTemplatesChanged')
                             {
                                 $this->smarty_changed=true;
                                 $this->smarty_theme=$this->call_ret['theme'];
                             }                          
                             $add_method=1;                           
                         } 
                    }
                }

                if (($add_version==1) && ($add_method==1)) $contents_active[$app]=$content;
            }
      }
      
      return $contents_active;
    }
    
    /**
     * Get changelog function result
     * @see stChangelogFunctions class
     * @return mixed
     */
    public function getResult()
    {
        
        if (! empty($this->result)) 
        {
            ksort($this->result,SORT_STRING);
            return $this->result;
        }
        else return NULL;
    }
    
    /**
     * Get changelog content
     * @param string $app Applikaction
     * @param array $content Content data
     * @param string $priority (P1|P2|P3|P4|P5)
     * @return string HTML
     */
    public function getUpdateContent($app,$app_content,$priority)
    {           
    
        $culture=sfContext::getInstance()->getUser()->getCulture();

        $result=array();
        foreach ($app_content as $keyname=>$data_array)
        {            
            
            $params=$data_array['data'];
            $method=$data_array['method'];
            $keyname_params = $data_array['keyname_params'];
            if (! empty($keyname_params['url'])) $url=$keyname_params['url']; else $url=NULL;
            
            $file=sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.$app.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'changelog'.DIRECTORY_SEPARATOR.$culture.DIRECTORY_SEPARATOR.$keyname.'.html';
            if (file_exists($file))
            {                  
                // execute method for keyname                      
                $file=file_get_contents($file);     
            } else $file='';
            $ret_keyname=call_user_func_array (array('stChangelogFunctions', $method), array($app,$params,'runkeyname',$keyname_params)); 
            
            $result['keyname'][$keyname]['content']=$file.$ret_keyname;
            $result['keyname'][$keyname]['url']=$url;
        }

        // execute method for app
        $ret_app=call_user_func_array (array('stChangelogFunctions', $method), array($app,$params,'runapp'));    
        $result['resume']=$ret_app;
            
        return $result;
    }
    
    /**
     * Get active changelog content arrays
     * @return array 
     */
    public function getActiveContents()
    {
        return $this->active_contents;
    }
    

    /**
     * Check if version is active. Compare versions.
     * @param string $app Application
     * @param array $version Version
     * @return bool
     */
    protected function checkVersion($app,$version)
    {
        $min  = NULL;
        $max  = NULL;        
        if (! empty($version['min'])) $min=$version['min'];
        if (! empty($version['max'])) $max=$version['max'];
        
        /**
         * Fixed: Package version is from package.yml not from pear.
         * @author Michal Prochowski <michal.prochowski@sote.pl>
         */
//         $pearv = $this->getPearVersion($app);// app PEAR version
        $packageFile = sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'packages'.DIRECTORY_SEPARATOR.$app.DIRECTORY_SEPARATOR.'package.yml';
        if (file_exists($packageFile)) {
            $package = sfYaml::load($packageFile);
            $pearv = $package['package']['version'];
        } else {
            $pearv = 0;
        }
        // echo "pearv=$pearv min=$min max=$max <br>";
        
        if (! empty($pearv)) 
        {        
            if ((version_compare($pearv,$min,'>=')) && (version_compare($pearv,$max,'<=')))
            {
                return true;
            }
        }
        
        return false;        
    } 
            
    protected function getContents()
    {
        $content=array();
        $files=$this->getAllFiles();
        if (! empty($files))
        {
            foreach ($files as $app=>$file)
            {            
                $content[$app]=sfYaml::load($file);
            }
        }
        return $content;
    }
}