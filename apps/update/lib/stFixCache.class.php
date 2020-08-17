<?php
/**
 * @author      Marek Jakubowicz <marek.jakubowicz@sote.pl>
 */

/**
 * Fix cache. Repair cache structure.
 */
class stFixCache 
{
    /**
     * Run all repair method for cache.
     * @return true
     */
    public function fixAll()
    {
        $this->fixSyncLocationPath();
        $this->deleteUneccessaryCacheFiles();
        return true;
    }
    
    /**
     * Move sync file from cache/*.sync to install/sync/*.sync
     * @return true
     */
    function fixSyncLocationPath()
    {
        $cache_files=sfFinder::type('file')->name("*.sync")->in(sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'cache');    
        $new_sync_dir=sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'sync';    

        if (! is_dir($new_sync_dir)) 
        {
            if (! mkdir($new_sync_dir)) throw new Exception('Unable mkdir $new_sync_dir');
        }
        foreach ($cache_files as $cfile)
        {
            if (copy($cfile,$new_sync_dir.DIRECTORY_SEPARATOR.basename($cfile))) 
            {
                unlink ($cfile);
            }
            else 
            {
                throw new Exception ("Unable copy sync file $cfile");
            }
        }        
        return true;
    }

    /**
     * Delete unnecesary files from cache.
     * List of deleted files and dirs:
     * drwxrwxrwx    3 marek  staff   102 Mar  9 13:01 backend
     * -rw-r--r--@   1 marek  staff   612 Feb 16 13:56 channel.xml                   ->delete
     * drwxrwxrwx    3 marek  staff   102 Mar 19 10:38 config
     * drwxr-xr-x    3 marek  staff   102 Mar 18 11:23 fastcache
     * drwxrwxrwx    5 marek  staff   170 Mar 18 11:47 frontend
     * -rw-r--r--@   1 marek  staff  4073 Feb 16 13:56 package.xml                   ->delete
     * -rw-r--r--@   1 marek  staff  5611 Feb 16 13:56 package2.xml                  ->delete
     * drwxr-xr-x@ 101 marek  staff  3434 Mar 19 10:29 smarty_c
     * drwxr-xr-x@   2 marek  staff    68 Feb 16 13:56 src                           ->delete
     * drwxrwxrwx    3 marek  staff   102 Mar  9 12:59 stFunctionCache
     * drwxr-xr-x@   3 marek  staff   102 Mar 10 16:49 stInstallerPlugin-1.0.7.1     ->delete
     * drwxr-xr-x@   3 marek  staff   102 Mar 10 16:49 stInstallerPlugin-1.0.7.1.tgz ->delete 
     * drwxrwxrwx   28 marek  staff   952 Mar 18 11:47 st_config
     * drwxrwxrwx    4 marek  staff   136 Mar  9 13:19 update    
     *
     * @return true
     */
    function deleteUneccessaryCacheFiles()
    {
        $stfile = new stFile();
        $cache_dir=sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'cache';
        if (file_exists($cache_dir.DIRECTORY_SEPARATOR.'channel.xml'))  unlink($cache_dir.DIRECTORY_SEPARATOR.'channel.xml');
        if (file_exists($cache_dir.DIRECTORY_SEPARATOR.'package.xml'))  unlink($cache_dir.DIRECTORY_SEPARATOR.'package.xml');
        if (file_exists($cache_dir.DIRECTORY_SEPARATOR.'package2.xml')) unlink($cache_dir.DIRECTORY_SEPARATOR.'package2.xml');
        $stfile->rmdir($cache_dir.DIRECTORY_SEPARATOR.'src');
        $dirs_installers=sfFinder::type('dir')->name("stInstallerPlugin*")->in($cache_dir);
        foreach ($dirs_installers as $installer)
        {
            if (file_exists($installer.'.tgz')) unlink($installer.'.tgz');
            $stfile->rmdir($installer);
        }     
        if (is_dir($cache_dir.DIRECTORY_SEPARATOR.'stFunctionCache'))   
        {
            $stfile->copy($cache_dir.DIRECTORY_SEPARATOR.'stFunctionCache',$cache_dir.DIRECTORY_SEPARATOR.'functions');
            $stfile->rm($cache_dir.DIRECTORY_SEPARATOR.'stFunctionCache');
        }
        return true;        
    }
    
}