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
 * @version     $Id: stSoteshop.class.php 15706 2011-10-19 14:03:06Z michal $
 * @author      Marcin Olejnczak <marcin.olejniczak@sote.pl>
 */
 
/** 
 * Dane związane z ogólną instalacją SOTESHOP.
 *
 *
 * @package     stBase
 * @subpackage  libs
 */
class stSoteshop
{       
    /** 
     * Odczytuje URL
     *
     * @param     string
     */
    public static function getURL()
    {
        $webRequest = new sfWebRequest();
        return $webRequest->getHost().$webRequest->getScriptName();
    }
    
    /** 
     * Odczytuje nazwę serwera
     *
     * @return   string
     */
    public static function getServerName()
    {
        $webRequest = new sfWebRequest();
        return $webRequest->getHost();
    }
    
    /** 
     * Sprawdza czy dany routing istnieje.
     *
     * @param   string      $route              np. @nazwa
     * @return   bool
     */
    public static function isRouting($route)
    {
        $nroute=ereg_replace("^@",'',$route);
        $routing = sfRouting::getInstance();
        $routes=$routing->getRoutes();

        if (! empty($routes[$nroute]))
        {        
            return true;
        } else return false; 
    }
    
    public static function getInstallVersion() {
        $path = sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'packages'.DIRECTORY_SEPARATOR;
        if (file_exists($path.'soteshop_uk')) return 'uk';
        if (file_exists($path.'soteshop_pl')) return 'pl';
        return 'pl';    
    }

    public static function checkInstallVersion($version, $operator = '>=')
    {   
        $install_version = stConfig::getInstance('stRegister')->get('install_version');
        return $install_version && version_compare($install_version, $version, $operator);
    }
}