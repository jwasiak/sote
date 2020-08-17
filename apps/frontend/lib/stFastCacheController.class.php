<?php
/**
 * @author      Marek Jakubowicz <marek.jakubowicz@sote.pl>
 */

/**
 * stFastCache controller
 */
class stFastCacheController
{
    /**
     * Disable Fast cache for current session
     */
    static public function disable()
    {
        sfContext::getInstance()->getResponse()->setCookie('fastcache', 'disabled');
    }
    
    /**
     * Enable Fast cache for current session
     */
    static public function enable()
    {
        sfContext::getInstance()->getResponse()->setCookie('fastcache', 'enabled');
    }
}