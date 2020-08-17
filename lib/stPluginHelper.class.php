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
 * @version     $Id: stPluginHelper.class.php 17389 2012-03-12 13:10:09Z marcin $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/** 
 * Klasa stPluginHelper
 *
 * @package     stBase
 * @subpackage  libs
 */
class stPluginHelper
{
    /** 
     * Włączanie modułów z pluginów
     *
     * @param   string      $moduleName         Nazwa modułu który ma zostać włączony 
     * @param   string      $appName            Nazwa aplikacji frontend/backend
     * @param   string      $environmentName    Tryb pracy sklepu prod/test domyślnie dla obu 
     */
    static public function addEnableModule($moduleName, $appName = null, $environmentName = null)
    {
        if ((null === $appName || SF_APP == $appName) && (null == $environmentName || SF_ENVIRONMENT == $environmentName))
        {
            $array = array_merge(sfConfig::get('sf_enabled_modules'), array($moduleName));
            sfConfig::add(array('sf_enabled_modules' => $array));
        }
    }

    /** 
     * Pobieranie listy włączonych modułów
     *
     * @return  array       Lista włączonych modułów 
     */
    static public function getEnableModule()
    {
        return sfConfig::get('sf_enabled_modules');
    }

    /** 
     * Dodawanie routingu
     *
     * @param   string      $name               Nazwa routingu
     * @param   string      $url                Adres url, dla którego ma zostać dodany routing 
     * @param   string      $module             Moduł który ma zostać wywołany 
     * @param   string      $action             Akcja która ma być wykonywana 
     * @param   string      $appName            Nazwa aplikacji frontend/backend
     * @param   array       $defaults           Dodatkowe parametry @see http://www.symfony-project.org/book/1_0/09-Links-and-the-Routing-System#Setting%20Default%20Values
     */
    static public function addRouting($name, $url, $module, $action, $appName = null, $defaults = array(), $requirements = array())
    {
        if (null === $appName || SF_APP == $appName)
        {            
            $defaults['module'] = $module;

            $defaults['action'] = $action;
            
            sfRouting::getInstance()->prependRoute($name, $url, $defaults, $requirements);
        }
    }

    /** 
     * Dodawanie do zmiennych do konfiguracji
     *
     * @param   string      $moduleName         nazwa modułu 
     * @param   string      $parameterName      nazwa parametru
     * @param   array       $parameterOptions   dodatkowe opcje dla parametru
     */
    static public function addConfigValue($moduleName, $parameterName, $parameterOptions = array())
    {
        $sfConfigValues = sfConfig::get('st_plugin_config_loader_config_value_'.$moduleName);
        if (!empty($parameterOptions)) $sfConfigValues[$parameterName] = $parameterOptions;
        else $sfConfigValues[] = $parameterName;
        sfConfig::add(array('st_plugin_config_loader_config_value_'.$moduleName => $sfConfigValues));
    }

    /** 
     * Zwraca zmiennie ustawione w pluginach dla danego modułu
     *
     * @param   string      $moduleName         nazwa modułu 
     * @return   array
     */
    static public function getConfigValue($moduleName)
    {
        return sfConfig::get('st_plugin_config_loader_config_value_'.$moduleName);
    }

    /** 
     * Dodanie do listy aplikacji pokazywanej na stronie głównej panelu sklepu
     *
     * @param   string      $moduleName         nazwa modułu który ma zostać pokazany 
     */
    static public function addToBackendDesktop($moduleName)
    {
        if (SF_APP == 'backend')
        {
            $array = array_merge(sfConfig::get('app_default_desktop'), array($moduleName));
            sfConfig::add(array('app_default_desktop' => $array));
        }
    }

    /** 
     * Dodawanie do konfiguracji sklepu
     *
     * @param   string      $name               Nazwa parametru
     * @param   mixed       $value              Wartość parametru 
     * @param   string      $appName            Nazwa aplikacji
     */
    static public function addSetting($name, $value, $appName)
    {
        if (SF_APP == $appName)
        {
            sfConfig::add(array($name => $value));
        }
    }
}