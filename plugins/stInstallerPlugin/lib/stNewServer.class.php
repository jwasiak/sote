<?php
/**
 * @author      Marek Jakubowicz <marek.jakubowicz@sote.pl>
 */
 
/**
 * Setup software for new server
 */
class stNewServer 
{
    /**
     * @var stPearInfo
     */
     var $peari;
     
     /**
      * @var string Old path
      */
     var $oldpath;
     
     /**
      * @var string New path
      */
     var $newpath;
     
     /**
      * @var string Old DIRECTORY_SEPARATOR
      */
     var $oldds;
    
    /**
     * Constructor
     */
    public function __construct() 
    {
        $this->peari   = stPearInfo::getInstance();    
        
        $oldpath = $this->getOldPath();
        $newpath = sfConfig::get('sf_root_dir');        

        // delete last DIRECTORY_SEPARATOR Unix or Windows (system doesn't know which)
        $oldpath=preg_replace("/\/$/",'',$oldpath);
        $oldpath=preg_replace("/"."\\\\"."$/",'',$oldpath);
        $newpath=preg_replace("/\/$/",'',$newpath);
        $newpath=preg_replace("/"."\\\\"."$/",'',$newpath);
        
        $this->oldpath=$oldpath;
        $this->newpath=$newpath;
    }
    
    /**
     * Detecting new server
     * @return bool true - new server, false - the same
     */
    public function newServer()
    {
        if ($this->oldpath!=$this->newpath) return true;
        else return false;
    }
    
    /**
     * Update 
     * @return bool
     */
    public function update()
    {
        // this update should be executed 2x
        if (!(($this->peari->updateConfig()))) return false;
        if (! $this->updateMd5())        return false;
        if (! $this->updateRegistry())   return false;
        if (! $this->updateSync())       return false;
        if (! $this->cleanSmartyCache()) return false;
        return true;
    }
    
    /**
     * Clear smarty cache files from cache/smarty_c
     * @return bool
     */
    public function cleanSmartyCache()
    {
        $files=sfFinder::type('file')->name("*.html.php")->in(sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'cache'.DIRECTORY_SEPARATOR.'smarty_c');
        foreach ($files as $cache_file) 
        {
            if (! unlink($cache_file)) return false;
        }
        return true;
    }
    
    /**
     * Get old path for prevoius localization.
     * @return string
     */
    protected function getOldPath()
    {
        $pearrc=$this->peari->getPearrc();
        $php_dir=$pearrc['php_dir'];         //  [php_dir]      => /Users/marek/Web/soteshop.502//install/src
        if (preg_match('/\\\\/',$php_dir))
        {
            $this->oldds='\\'; // DIRECTORY_SEPARATOR Windows
        } else {
            $this->oldds='/'; // DIRECTORY_SEPARATOR Unix
        }
        $data=preg_split('/install\\'.$this->oldds.'src/',$php_dir);
        if (isset($data[1])) 
        {
            $oldpath=$data[0];
            if (preg_match('/\\'.$this->oldds.'$/',$oldpath)) $oldpath=substr($oldpath,0,strlen($oldpath)-1);
            return $oldpath;
        }
    }
    
    /**
     * Fix path. Update path for new localization.
     * 
     * @param string $path previous path
     * @return string new path
     */
    protected function fixpath($path)
    {                      
       $path=str_replace($this->oldpath,$this->newpath,      $path);  // change SF_ROOT_DIR
       $path=str_replace($this->oldds,  DIRECTORY_SEPARATOR, $path);  // change DIRECTORY_SEPARATOR
       
       return $path;
    }
    
    /**
     * Update  registry
     * @return bool
     */
    protected function _updateRegistry($dir)
    {        
        $files=sfFinder::type('file')->name('*.reg')->in($dir);
        foreach ($files as $file)
        {
            $raw=file_get_contents($file);
            $data=unserialize($raw);
            if (is_array($data))
            {
                // filelist: Array
                //                 (
                //                     [soteshop/packages/soteshop/package.yml] => Array
                //                         (
                //                             [baseinstalldir] => /
                //                             [md5sum] => 6719d9728de9a3fa5a761900c0e638b6
                //                             [name] => soteshop/packages/soteshop/package.yml
                //                             [role] => php
                //                             [installed_as] => /Users/marek/Web/soteshop.test/install/src/soteshop/packages/soteshop/package.yml
                //                         )
                // 
                //                 )                
                $filelist=$data['filelist'];
                foreach ($filelist as $key=>$file_data)
                {
                    $data['filelist'][$key]['installed_as']=$this->fixpath($data['filelist'][$key]['installed_as']);
                }
                
                // dirtree: Array
                // (
                //     [/Users/marek/Web/soteshop.test/install/src/soteshop/packages/soteshop] => 1
                //     [/Users/marek/Web/soteshop.test/install/src/soteshop/packages] => 1
                //     [/Users/marek/Web/soteshop.test/install/src/soteshop] => 1
                // )                
                $dirtree=$data['dirtree'];$dirtree_updated=array();
                foreach ($dirtree as $dir=>$set)
                {
                    $dirtree_updated[$this->fixpath($dir)]=$set;
                }
                $data['dirtree']=$dirtree_updated;
                
                file_put_contents($file,serialize($data));
            } else return false;            
            
        }
        return true;
    }

    /**
     * Update install/src/.registry/.channel.pear.sote.pl
     */
    protected function updateRegistry()
    {
        $dir=$this->newpath.DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'.registry'.DIRECTORY_SEPARATOR;
        $channels_dirs=sfFinder::type('dir')->relative()->in($dir);
        foreach ($channels_dirs as $id=>$channel_dir)
        {
            if (! $this->_updateRegistry($dir.DIRECTORY_SEPARATOR.$channel_dir)) return false;
        }
        return true;
    }
    
    /**
     * Update install/db/.md5
     */
    protected function updateMd5()
    {
        $dir=$this->newpath.DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'db'.DIRECTORY_SEPARATOR.'.md5sum';
        return $this->_updateRegistry($dir);
    }
    
    /**
     * Update cache/*.sync
     * Update files in old localisation cache/*.sync and new install/sync/*.sync
     */
    protected function updateSync()
    {
        $files_sync_old = sfFinder::type('file')->name('*.sync')->in($this->newpath.DIRECTORY_SEPARATOR.'cache'); // old cache
        $files_sync_new = sfFinder::type('file')->name('*.sync')->in($this->newpath.DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'sync'); // new cache
        $files_sync = array_merge($files_sync_old,$files_sync_new);
        foreach ($files_sync as $file_pkg)
        {
            // Source:
            // /Users/marek/Web/soteshop.test/apps
            // /Users/marek/Web/soteshop.test/apps/backend
            // /Users/marek/Web/soteshop.test/apps/backend/i18n
            // /Users/marek/Web/soteshop.test/apps/backend/i18n/stAllegroBackend.pl.xml            
            // ...
            $source=file_get_contents($file_pkg);                        
            
            $lines=explode("\n", $source);$new_source='';
            foreach ($lines as $line)
            {
                $new_source.=$this->fixpath($line)."\n";
            }
            $file_pkg_new = $this->renameSyncFile($file_pkg);
            if ($file_pkg_new != $file_pkg)
            {
                if (file_put_contents($file_pkg_new,$new_source)) 
                {
                    // delete old file name
                    unlink($file_pkg);             
                } else
                {
                    return false;
                }
            }            
        }        
        return true;
    }
    
    /**
     * Rename sync files. Update path.
     * @param string $file eg. %2FUsers%2Fmarek%2FWeb%2Fsoteshop.test%2Finstall%2Fsrc%2FstUser.sync
     * @return string the same as $file but with new path
     */
    public function renameSyncFile($file)
    {
        $file_name = basename($file);
        $file_name = str_replace('%2F',$this->oldds,$file_name);
        $file_name = $this->fixpath($file_name);
        $file_name = str_replace(DIRECTORY_SEPARATOR,'%2F',$file_name);
        $file=dirname($file).DIRECTORY_SEPARATOR.$file_name;
        return $file;
    }
}