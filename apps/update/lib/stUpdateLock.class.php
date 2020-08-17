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
 * @version     $Id: stUpdateLock.class.php 3160 2010-01-26 13:30:27Z marek $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/** 
 * Locking system for shop.
 *
 * @package     stUpdate
 * @subpackage  libs
 */
class stUpdateLock
{
    /** 
     * Check configuration.
     *
     * @return   bool
     */
    public static function check($app = SF_APP)
    {
        $file = SF_ROOT_DIR.DIRECTORY_SEPARATOR.'web'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'stLock'.ucfirst($app).'.lck';
        if(file_exists($file)) return false;
        return true; 
    }

    /** 
     * Lock shop.
     *
     * @param        string      $app
     */
    public static function lock($app = SF_APP)
    {
        $file = SF_ROOT_DIR.DIRECTORY_SEPARATOR.'web'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'stLock'.ucfirst($app).'.lck';
        file_put_contents($file, '');
    }
    
    /** 
     * Unlock shop.
     *
     * @param        string      $app
     */
    public static function unlock($app = SF_APP)
    {
        $file = SF_ROOT_DIR.DIRECTORY_SEPARATOR.'web'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'stLock'.ucfirst($app).'.lck';
        @unlink($file);
    }
}