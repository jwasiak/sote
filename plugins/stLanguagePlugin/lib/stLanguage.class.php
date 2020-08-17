<?php
/**
 * SOTESHOP/stLanguagePlugin
 *
 * Ten plik należy do aplikacji stLanguagePlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stLanguagePlugin
 * @subpackage  configs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stLanguage.class.php 16206 2011-11-23 14:17:22Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stLanguage
 *
 * @package     stLanguagePlugin
 * @subpackage  libs
 */
class stLanguage
{
    /**
     * namespace stLanguage
     * @var string
     */
    const SESSION_NAMESPACE = 'soteshop/language';

    /**
     * Instanacja obiektu stLanguage
     * @var stLanguage
     */
    protected static $instance = null;
    /**
     * Obiekt sfContext
     * @var Context
     */
    private $context;
    /**
     * Pełny adres z parametrami
     * @var
     */
    private $path = '';
    /**
     * Flaga zmiany języka
     * @var bool
     */
    private $languageChangedFlag = false;

    protected static $disablePath = false;

    /**
     * Incjalizacja klasy stLanguage
     *
     * @param string $context
     */
    public function initialize($context)
    {
        $this->context = $context;
        $this->path = $context->getUser()->getAttribute('path', array(), self::SESSION_NAMESPACE);
        $this->languageChangedFlag = $context->getUser()->getAttribute('languageChangedFlag', false, self::SESSION_NAMESPACE);
    }

    /**
     * Zwraca instancje obiektu
     *
     * @param string $context
     * @return stLanguage
     */
    public static function getInstance($context)
    {
        if (!isset(self::$instance))
        {
            $class = __CLASS__;
            self::$instance = new $class();
            self::$instance->initialize($context);
        }
        return self::$instance;
    }

    public static function disablePath()
    {
        self::$disablePath = true;
    }

    /**
     * Ustawianie pełnego adresu z parametrami.
     *
     * @param $path string adres
     */
    public function setPath($path)
    {
        if (self::$disablePath)
        {
            return false;
        }
        
        if (strpos($path, 'basket/addReferer') !== false)
        {
            $path = 'basket/index';
        }
        elseif (strpos($path, 'basket/remove') !== false)
        {
            $path = 'basket/index';
        }
        elseif (strpos($path, 'basket/index') !== false)
        {
            $path = 'basket/index';
        }
        elseif (strpos($path, 'sfCaptchaGD/GetImage') !== false)
        {
            return false;
        }
        elseif (strpos($path, 'stProduct/showImage') !== false)
        {
            return false;
        }
        elseif (strpos($path, 'stProduct/downloadAttachment') !== false)
        {
            return false;
        }
        elseif (strpos($path, 'stProduct/downloadAttachment') !== false)
        {
            return false;
        }

      
        $this->path = $path;
        $this->context->getUser()->setAttribute('path', $this->path, self::SESSION_NAMESPACE);
        
    }

    /**
     * Pobieranie pełnego adresu z parametrami.
     *
     * @return string
     */
    public function getPath($shortcut = null)
    {
        $pathArray = $this->context->getController()->convertUrlStringToParameters($this->path);

        $pathArray = $pathArray[1];
        if (isset($pathArray['lang']))
        unset($pathArray['lang']);
        if ($shortcut !== null)
        $pathArray['lang'] = $shortcut;
        return $pathArray;
    }

    /**
     * Czyszczenie pełnego adresu z parametrami
     *
     * @return string
     */
    public function clearPath()
    {
        $this->path = '';
        $this->context->getUser()->setAttribute('path', $this->path, self::SESSION_NAMESPACE);
    }

    /**
     * Pobiera domyślne wartości językowe
     *
     * @author Marcin Butlak <marcin.butlak@sote.pl>
     * @param object $obj Obiekt modelu
     * @param string $method Nazwa metody (__METHOD__)
     * @return string Wartośc domyślna
     */
    public static function getDefaultValue($obj, $method)
    {
        list($class, $method) = explode("::", $method);

        $opt_method = substr_replace($method, "getOpt", 0, 3);

        $method_exists = method_exists($obj, $opt_method);

        if (!$method_exists)
        {
            if (!isset($obj->defaultI18n))
            {
                $obj->defaultI18n = call_user_func(array($class.'I18nPeer', 'retrieveByPK'), $obj->getPrimaryKey(), 'pl_PL');
            }

            $v = $obj->defaultI18n ? $obj->defaultI18n->$method() : null;
        }
        else
        {
            $v = $obj->$opt_method();
        }

        return $v;
    }

    /**
     * Ustawia domyślne wartości językowe
     *
     * @author Marcin Butlak <marcin.butlak@sote.pl>
     * @param object $obj Model
     * @param string $method Nazwa metody (__METHOD__)
     * @param string $value Wartość 
     */
    public static function setDefaultValue($obj, $method, $value)
    {
        list(, $method) = explode("::", $method);

        $method = substr_replace($method, "setOpt", 0, 3);

        if (method_exists($obj, $method))
        {
            $obj->$method($value);
        }
    }

    /**
     * Pobieranie Culture
     *
     * @return string
     */
    public static function getHydrateCulture()
    {
        if (preg_match("/symfony/", $_SERVER["SCRIPT_NAME"])) return 'pl_PL';
        return (SF_APP == 'backend') ? self::getOptLanguage() : sfContext::getInstance()->getUser()->getCulture();
    }

    /**
     * Sprawdzanie czy wersja językowa jest aktywane przy ustawianiu domyślnej wersji językowej
     *
     * @param $is_default mixed wartość pola is_default
     * @return bool
     */
    public static function checkDefaultLanguage($is_default)
    {
        $active = sfContext::getInstance()->getRequest()->getParameter('language[active]');
        if ($active == true && $is_default == true)
        return true;
        return false;
    }

    /**
     * Zmiana języka w sklepie
     *
     * @param $shortcut string skrót języka
     * @return bool true - w przypadku powodzenia / false - w przypadku niepowodzenia
     */
    public static function changeLanguageByShortcut($shortcut)
    {
        $context = sfContext::getInstance();

        $defaultLanguage = LanguagePeer::doSelectDefault();
        $languages = LanguagePeer::doSelectActive();

        foreach ($languages as $language)
        {
            if ($language->getShortcut() == $shortcut)
            {
                $context->getUser()->setCulture($language->getOriginalLanguage());
                stLanguage::getInstance($context)->setLanguageChangedFlag(true);
                $_SESSION['fastcache_lang'] = $language->getOriginalLanguage();
                return true;
            }
        }
        return false;
    }

    /**
     * Ustawianie flagi zmiany języka
     *
     * @param bool $flag
     */
    public function setLanguageChangedFlag($flag)
    {
        $this->languageChangedFlag = $flag;
        $this->context->getUser()->setAttribute('languageChangedFlag', $this->languageChangedFlag, self::SESSION_NAMESPACE);
    }

    /**
     * Pobieranie flagi zmiany języka
     *
     * @return bool
     */
    public function getLanguageChangedFlag()
    {
        return $this->languageChangedFlag;
    }

    public function hasLangParameterInUrl($shortcut, $returnDomain = false)
    {
        $languagesHasDomain = LanguageHasDomainPeer::doSelectByLanguageShortcut($shortcut);

        if ($returnDomain)
        {
            if ($languagesHasDomain)
            {
                foreach ($languagesHasDomain as $languageHasDomain)
                {
                    if ($languageHasDomain->getIsDefault())
                    {
                        return $languageHasDomain->getDomain();
                    }
                }
                return $languagesHasDomain[0]->getDomain();
            }
            else
            {
                return null;
            }            
        }
        
        return empty($languagesHasDomain);
    }

    public function hasDomain()
    {
        $culture = $this->context->getUser()->getCulture();
        if ($culture == "pl_PL")
        $culture = 'pl';
        if ($culture == "en_US")
        $culture = 'en';

        return !$this->hasLangParameterInUrl($culture);
    }

    public function getDomain()
    {
        $culture = $this->context->getUser()->getCulture();
        if ($culture == "pl_PL")
        $culture = 'pl';
        if ($culture == "en_US")
        $culture = 'en';

        return $this->hasLangParameterInUrl($culture, true);
    }

    protected static $layoutLanguage = null;

    public static function getLayoutLanguage()
    {
        if (self::$layoutLanguage !== null)
        return self::$layoutLanguage;

        $culture = sfContext::getInstance()->getUser()->getCulture();
        $array = explode('_', $culture, 2);
        self::$layoutLanguage = $array[0];

        return self::$layoutLanguage;
    }

    protected static $optLanguage = null;
     
    public static function getOptLanguage()
    {
        if (self::$optLanguage !== null) return self::$optLanguage;

        $config = stConfig::getInstance(sfContext::getInstance(), 'stLanguagePlugin');
        self::$optLanguage = $config->get('default_opt_language');

        if (empty(self::$optLanguage)) self::$optLanguage = 'pl_PL';

        return self::$optLanguage;
    }

    public static function addModuleToRemoveLangParameter($module, $action = null) {
        $modules = sfConfig::get('st_language_modules_to_remove_lang_parameter');
        $modules[] = array('module' => $module, 'action' => $action);
        sfConfig::set('st_language_modules_to_remove_lang_parameter', $modules);
        return true;
    }
    
    public static function getModulesToRemoveLangParameter() {
        return sfConfig::get('st_language_modules_to_remove_lang_parameter');
    }
}
