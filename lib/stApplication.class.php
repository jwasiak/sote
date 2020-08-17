<?php
/** 
 * SOTESHOP/stBase 
 * 
 * Ten plik należy do aplikacji stBase opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stBase
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stApplication.class.php 12899 2011-05-19 09:49:39Z michal $
 * @author      Marek Jakubowicz <marek.jakubowicz@sote.pl>
 */
                             
/** 
 * Budowanie pakietów SOTESHOP, na podstawie modułów.
 * Aktualizacja i zarządzanie plikami package.xml.
 *
 * @see stPearInfo
 *
 * @package     stBase
 * @subpackage  libs
 */
class stApplication
{
    private static $pearApps = array();
   
    /** 
     * Zwraca listę zainstalowanych aplikacji.
     * Lista jest odczytywana z .registry PEAR.
     *
     * @return   array
     */
    static public function getApps()
    {
        if (empty(self::$pearApps))
        {
            self::$pearApps = stPearInfo::getOptPackages();
        }
        return self::$pearApps;
    }

    /** 
     * Zwraca listę zainstalowanych aplikacji, ktore maja sie pojawić na głównej stronie backend'u.
     * Lista jest odczytywana z .registry PEAR.
     *
     * @return   array
     */
    static public function getDefaultDesktopApps($name = 'app_default_desktop')
    {
        $apps = stApplication::getApps();
        $appsDefault = sfConfig::get($name);
        $ret=array();
        foreach ($appsDefault as $app) {
            if (isset($apps[$app]))
            {
                $ret[$app]=$apps[$app];
            }
        }
        return $ret;
    }

    /** 
     * Odczytuje nazwę aplikacji SOTESHOP.
     *
     * @param        string      aplikacja
     * @return  string      nazwa aplikacji
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
     * Zwraca listę modułów odczytana z apps/backend/config/app.yml
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
     * Odczytuje nazwę modułu.
     *
     * @param        string      moduł 
     * @return  string      nazwa modułu 
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
     * Odczytuje nazwę elementu menu: aplikacji, modułu.
     *
     * @param   string      $element            nazwa elementu: aplikacji, modułu. 
     * @return  string      nazwa elementu
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
     * Odczytuje nazwę aplikacji wg nazwy modułu.
     *
     * @param        string      $moduleName
     * @return       string      appName
     * @deprecated since 2009/07/07 m@sote.pl
     */
    static public function getAppNameByModule($moduleName='')
    {
        // $pearInfo = stPearInfo::getInstance();
        // return $pearInfo->getPackageByFile("/modules/$moduleName/");      
    }    
}