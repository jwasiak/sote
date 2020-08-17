<?php

/**
 * SOTESHOP/stTabNavigatorPlugin
 *
 * Ten plik należy do aplikacji stTabNavigatorPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stTabNavigatorPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stTabNavigator.class.php 5034 2010-05-17 12:46:36Z michal $
 */

/**
 * Klasa generująca zakładkę
 *
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 *
 * @package     stTabNavigatorPlugin
 * @subpackage  libs
 */
class stTab
{
    protected $index = 1, $label = '', $moduleName = '', $actionName = '', $params = array();

    /**
     * Konstruktor inicjalizujący zakładkę
     *
     * @param   string      $index              index/numer zakładki 
     * @param   string      $label              Etykieta zakładki 
     * @param   string      $moduleName         Nazwa modułu 
     * @param   string      $actionName         Nazwa akcji
     * @param   array       $params             Parametry przekazywane do akcji
     */
    public function __construct($index, $label, $moduleName, $actionName, $params = null)
    {
        $this->index = $index;
        $this->label = $label;
        $this->moduleName = $moduleName;
        $this->actionName = $actionName;
        if ($params)
        {
            $this->params = $params;
        }
    }

    /**
     * Zwraca index/numer zakładki
     *
     * @return   integer
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * Zwraca nazwę modułu
     *
     * @return   string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Zwraca nazwę modułu
     *
     * @return   string
     */
    public function getModuleName()
    {
        return $this->moduleName;
    }

    /**
     * Zwraca nazwę akcji
     *
     * @return   string
     */
    public function getActionName()
    {
        return $this->actionName;
    }

    /**
     * Zwraca tablicę parametrów
     *
     * @return   array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * Zwraca parametry URL
     * Przydatne jezeli chcecie je przekazać do zbudowania linku np. przez helper url_for 
     *
     * @return  array       of URL parameters
     */
    public function getParamsForUrl()
    {
        $params = $this->getParams();

        $params['module'] = $this->getModuleName();

        $params['action'] = $this->getActionName();

        return $params;
    }

}

/**
 * Klasa generująca nawiagtor zakładek
 *
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 *
 * @package     stTabNavigatorPlugin
 * @subpackage  libs
 */
class stTabNavigator
{

    protected static $instance = array();

    protected $name = '', $targetUrl = '', $context = null, $tabs = array(), $tab = 0, $validateTabs = true;

    /**
     * Zwraca instancje obiektu
     *
     * @param   string      $context            instancja obiektu sfContext::getInstance()
     * @param   string      unikalna            nazwa nawigatora
     * @param   string      uri                 strony na ktorej znajduje sie nawigator
     * @param   bool        $validateTabs       weryfikuj czy podana akcja dla danej zakładki istnieje 
     * @return   stTabNavigator
     */
    public static function getInstance($context, $name, $targetUrl, $validateTabs = true)
    {
        if (!isset(self::$instance[$name]))
        {
            $class = __CLASS__;
            self::$instance[$name] = new $class();
            self::$instance[$name]->initialize($context, $name, $targetUrl, $validateTabs);
        }

        return self::$instance[$name];
    }

    /**
     * Inicjalizacja stTabNavigator
     *
     * @param   string      $context            instancja obiektu sfContext::getInstance()
     */
    public function initialize($context, $name, $targetUrl, $validateTabs)
    {
        $this->context = $context;
        $this->name = $name;
        $this->targetUrl = $targetUrl;
        $this->validateTabs = $validateTabs;
    }

    /**
     * Dodaje zakładkę
     *
     * @param   string      $label              Etykieta zakładki 
     * @param   string      $moduleName         Nazwa modułu 
     * @param   string      $actionName         Nazwa akcji
     * @param   array       $params             Lista parametrów przekazywanych do akcji 
     * @param   string      $alias              Alias dla zakladki. Jezeli pozostawione puste alias nadawany jest automatycznie.
     */
    public function addTab($label, $moduleName, $actionName, $params = null, $alias = '')
    {
        if ($params)
        {
            $request = $this->context->getRequest()->getParameterHolder()->add($params);
        }

        $tabIndex = !empty($alias) ? $alias : count($this->tabs) + 1;
        $this->tabs[$tabIndex] = new stTab($tabIndex, $label, $moduleName, $actionName, $params);
    }

    /**
     * Ustawia numer aktywnej zakładki
     *
     * @param   integer     $tab                Numer lub alias zakładki 
     */
    public function setTab($tab = 0)
    {
        $this->tab = $tab ? $tab : 1;
    }

    /**
     * Zwraca numer aktywnej zakładki
     *
     * @return   integer
     */
    public function getTab()
    {
        return $this->tab;
    }

    public function setTabs($tabs)
    {
        $this->tabs = $tabs;
    }

    /**
     * Pobiera aktywną zakładkę
     *
     * @return   stTab
     */
    public function getCurrentTab()
    {
        $tabs = $this->getTabs();

        $index = $this->getTab();

        if (!isset($tabs[$index]))
        {
            if ($tab = $this->getFirstTab())
            {
                return $tab;
            }
        }

        return $tabs[$index];
    }

    /**
     * Zwraca ostatnią zakładkę
     *
     * @return   stTab
     */
    public function getLastTab()
    {
        $tabs = $this->getTabs();

        return end($tabs);
    }

    /**
     * Zwraca pierwszą zakładkę
     *
     * @return   stTab
     */
    public function getFirstTab()
    {
        $tabs = $this->getTabs();

        reset($tabs);

        return current($tabs);
    }

    /**
     * Zwraca tablicę zakładek
     *
     * @return  array       of stTab
     */
    public function getTabs()
    {
        return $this->tabs;
    }

    /**
     * Zwraca unikalną nazwę nawigatora
     *
     * @return   string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Zwraca docelowy adres URL na jakim znajduje się nawigator
     */
    public function getTargetUrl()
    {
        return $this->targetUrl;
    }

    /**
     * Zwraca zawartość aktywnej zakładki
     *
     * @return   string
     */
    public function getTabContent()
    {
        /**
         */
        $controller = $this->context->getController();

        /**
         */
        $request = $this->context->getRequest();

        if ($tab = $this->getCurrentTab())
        {
            $params = $tab->getParams();

            $params[$this->name] = $tab->getIndex();

            $request->getParameterHolder()->add($params);

            $view = $controller->getPresentationFor($tab->getModuleName(), $tab->getActionName(), 'sfPHP');
            
            $this->context->getI18N()->revertToPreviousCatalogue();
            
            return $view;
        }
    }

    /**
     * Sprawdza czy podana zakładka jest pierwsza
     *
     * @param   stTab       $tab                zakładka 
     * @return   bool
     */
    public function isFirst($tab)
    {
        return $this->getFirstTab()->getIndex() == $tab->getIndex();
    }

    /**
     * Sprawdza czy podana zakładka jest ostatnia
     *
     * @param   stTab       $tab                zakładka 
     * @return   bool
     */
    public function isLast($tab)
    {
        return $this->getLastTab()->getIndex() == $tab->getIndex();
    }

    /**
     * Sprawdza czy podana zakładka jest aktywna (wybrana)
     *
     * @param   stTab       $tab                zakładka 
     * @return   bool
     */
    public function isSelected($tab)
    {
        return $this->getCurrentTab()->getIndex() == $tab->getIndex();
    }

}