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
 * @version     $Id: stLockUpdate.php 4319 2010-03-30 12:29:41Z marek $
 * @author      Marek Jakubowicz <marek.jakubowicz@sote.pl>
 */

define ("ST_LOCK_UPDATE",sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'db'.DIRECTORY_SEPARATOR.'.lockupdate');                                     
   
/** 
 * Locking system for upgrade process.
 *
 * @package     stUpdate
 * @subpackage  libs
 */
class stLockUpdate 
{       
    /** 
     * Upgrade started.
     */
    static public function lock()
    {                                            
        $data=date('Y/m/d H:i:s');
        file_put_contents(ST_LOCK_UPDATE,$data);
    }                             
    
    /** 
     * Upgrade finished.
     */
    static public function unlock()
    {
        if (file_exists(ST_LOCK_UPDATE)) unlink(ST_LOCK_UPDATE);
    }                                                           
        
    /** 
     * Check if upgrade system is locked.
     *
     * @return   bool
     */
    static public function isLocked()
    {
        if (file_exists(ST_LOCK_UPDATE)) return true;
        else return false;
    }
    
    /**
     * Check if provided key is locked
     * @param string $key
     * @return bool true - keyy is locked, false - not locked
     */
    static public function isLockedKey($key)
    {
        $lock_dir=sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'lock'.DIRECTORY_SEPARATOR;
        if (file_exists($lock_dir.$key)) return true;
        else return false;
    }
    
    /**
     * Add lock for provided key
     * @param string $key
     * @return true
     */
    static public function lockKey($key)
    {
        $lock_dir=sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'lock'.DIRECTORY_SEPARATOR;
        if (! is_dir($lock_dir)) mkdir ($lock_dir);
        $src=date('Y/m/d H:i:s');
        file_put_contents($lock_dir.$key,$src);
        return true;
    }
}
