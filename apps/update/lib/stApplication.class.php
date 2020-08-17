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
 * @version     $Id: stApplication.class.php 3160 2010-01-26 13:30:27Z marek $
 * @author      Marek Jakubowicz <marek.jakubowicz@sote.pl>
 */
                             
/** 
 * Application manager.
 *
 * @see stPearInfo
 *
 * @package     stUpdate
 * @subpackage  libs
 */
class stApplication
{
    /** 
     * Installed applications.
     */
    private static $pearApps = array();
   
    /** 
     * Get PEAR installed applications.
     *
     * @return   array
     */
    static public function getApps()
    {
        if (empty(self::$pearApps))
        {
            $peari = stPearInfo::getInstance();
            self::$pearApps = $peari->getPackages();      
        }
        return self::$pearApps;
    }

    /** 
     * Get installed applications displayed on backend desktop.
     *
     * @return   array
     */
    static public function getDefaultDesktopApps()
    {
        $apps = stApplication::getApps();
        $appsDefault = sfConfig::get("app_default_desktop");
        $ret=array();
        foreach ($appsDefault as $app) {
            if (! empty($apps[$app]))
            {
                $ret[$app]=$apps[$app];
            }
        }
        return $ret;
    }

    /** 
     * Get application full name.
     *
     * @param   string      $app                application name (short).
     * @return  string      full application name
     */
    static public function getAppName($app)
    {
        $a = stApplication::getApps();
        if (isset($a[$app]))
        return $a[$app];
        else
        return $app;
    }

    /** 
     * Get list modules from apps/backend/config/app.yml
     *
     * @return   array
     */
    static public function getModules()
    {
        $modules = sfConfig::get("app_module");
        if (is_array($modules))
        return $modules;
        else
        return array();
    }

    /** 
     * Get module name.
     *
     * @param               string      $module             module
     * @return  string      full module name
     */
    static public function getModuleName($module)
    {
        $m = stApplication::getModules();
        if (isset($m[$module]))
        return $m[$module];
        else
        return $module;
    }

    /** 
     * Get menu name: module or application.
     *
     * @param   string      $element            application name, or module
     * @return  string      full name
     */
    static public function getMenuElementName($element)
    {
        $a = stApplication::getAppName($element);
        $m = stApplication::getModuleName($element);
        if ($a != $element)
        return $a;
        if ($m != $element)
        return $m;
        return $element;
    }

    /** 
     * Get application name by module name.
     *
     * @param   string      $moduleName         module name
     * @return       string      appName
     */
    static public function getAppNameByModule($moduleName='')
    {
        $pearInfo = stPearInfo::getInstance();
        return $pearInfo->getPackageByFile("/modules/$moduleName/");
    }    
}