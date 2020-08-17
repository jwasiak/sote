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
 * @version     $Id: stFrontWebController.class.php 17389 2012-03-12 13:10:09Z marcin $
 * @author      Marcin Butlak <marcin.butlak@sote.pl>
 */

/**
 * Klasa rozszerzajaca istniejacy kontroler o event dispatcher
 *
 * @package     stBase
 * @subpackage  libs
 */
class stFrontWebController extends sfFrontWebController
{
    /**
     * Event dispatcher instance
     * @var sfEventDispatcher
     */
    protected $dispatcher = null;

    /**
     * Zwraca instancje do obiektu sfEventDispatcher
     *
     * @return   sfEventDispatcher
     */
    public function getDispatcher()
    {
        return $this->dispatcher;
    }

    /**
     * Zwraca instancje do obiektu stTheme
     *
     * @return   stTheme
     */
    public function getTheme()
    {
        return stTheme::getInstance($this->getContext());
    }

    /**
     * Incjalizacja obiektu sfEventDispatcher
     *
     * @param   string      $context            instancja obiektu sfContext
     */
    public function initialize($context)
    {
        $this->dispatcher = stEventDispatcher::getInstance();

        parent::initialize($context);
    }

    /**
     * Przeciazenie metody forward
     *
     * @param   string      $moduleName         Nazwa modulu
     * @param   string      $actionName         Nazwa akcji
     */
    public function forward($moduleName, $actionName)
    {
        // replace unwanted characters
        $moduleName = preg_replace('/[^a-z0-9\-_]+/i', '', $moduleName);
        $actionName = preg_replace('/[^a-z0-9\-_]+/i', '', $actionName);

        if ($this->getActionStack()->getSize() >= $this->maxForwards)
        {
            // let's kill this party before it turns into cpu cycle hell
            $error = 'Too many forwards have been detected for this request (> %d)';
            $error = sprintf($error, $this->maxForwards);

            throw new sfForwardException($error);
        }

        $rootDir = sfConfig::get('sf_root_dir');
        $app     = sfConfig::get('sf_app');
        $env     = sfConfig::get('sf_environment');

        if (!sfConfig::get('sf_available') || sfToolkit::hasLockFile($rootDir.'/'.$app.'_'.$env.'.lck'))
        {
            // application is unavailable
            $moduleName = sfConfig::get('sf_unavailable_module');
            $actionName = sfConfig::get('sf_unavailable_action');

            if (!$this->actionExists($moduleName, $actionName))
            {
                // cannot find unavailable module/action
                $error = 'Invalid configuration settings: [sf_unavailable_module] "%s", [sf_unavailable_action] "%s"';
                $error = sprintf($error, $moduleName, $actionName);

                throw new sfConfigurationException($error);
            }
        }

        // check for a module generator config file
        if ($app != 'frontend')
        {
            sfConfigCache::getInstance()->import(sfConfig::get('sf_app_module_dir_name').'/'.$moduleName.'/'.sfConfig::get('sf_app_module_config_dir_name').'/generator.yml', true, true);
        }

        if (!$this->actionExists($moduleName, $actionName))
        {
            $event = $this->dispatcher->notifyUntil(new sfEvent($this, $moduleName . '.' . $actionName .'NotFound'));

            if ($event->isProcessed())
            {
                return;
            }
            // the requested action doesn't exist
            if (sfConfig::get('sf_logging_enabled'))
            {
                $this->getContext()->getLogger()->info(sprintf('{sfController} action "%s/%s" does not exist', $moduleName, $actionName));
            }

            // track the requested module so we have access to the data in the error 404 page
            $this->context->getRequest()->setAttribute('requested_action', $actionName);
            $this->context->getRequest()->setAttribute('requested_module', $moduleName);

            // switch to error 404 action
            $moduleName = sfConfig::get('sf_error_404_module');
            $actionName = sfConfig::get('sf_error_404_action');

            if (!$this->actionExists($moduleName, $actionName))
            {
                // cannot find unavailable module/action
                $error = 'Invalid configuration settings: [sf_error_404_module] "%s", [sf_error_404_action] "%s"';
                $error = sprintf($error, $moduleName, $actionName);

                throw new sfConfigurationException($error);
            }
        }

        // create an instance of the action
        $actionInstance = $this->getAction($moduleName, $actionName);

        // add a new action stack entry
        $this->getActionStack()->addEntry($moduleName, $actionName, $actionInstance);

        // include module configuration

        require(sfConfigCache::getInstance()->checkConfig(sfConfig::get('sf_app_module_dir_name').'/'.$moduleName.'/'.sfConfig::get('sf_app_module_config_dir_name').'/module.yml'));

        // check if this module is internal
        if ($this->getActionStack()->getSize() == 1 && sfConfig::get('mod_'.strtolower($moduleName).'_is_internal') && !sfConfig::get('sf_test'))
        {
            $error = 'Action "%s" from module "%s" cannot be called directly';
            $error = sprintf($error, $actionName, $moduleName);

            throw new sfConfigurationException($error);
        }

        if (sfConfig::get('mod_'.strtolower($moduleName).'_enabled'))
        {
            // initialize the action
            if ($actionInstance->initialize($this->context))
            {
                // create a new filter chain

                $filterChain = new sfFilterChain();
                $this->loadFilters($filterChain, $actionInstance);

                if ($moduleName == sfConfig::get('sf_error_404_module') && $actionName == sfConfig::get('sf_error_404_action'))
                {
                    $this->getContext()->getResponse()->setStatusCode(404);
                    $this->getContext()->getResponse()->setHttpHeader('Status', '404 Not Found');

                    foreach (sfMixer::getCallables('sfController:forward:error404') as $callable)
                    {
                        call_user_func($callable, $this, $moduleName, $actionName);
                    }
                }

                // change i18n message source directory to our module
                if (sfConfig::get('sf_i18n'))
                {
                    $this->context->getI18N()->setMessageSourceDir(sfLoader::getI18NDir($moduleName), $this->context->getUser()->getCulture());
                }

                // process the filter chain
                $filterChain->execute();
            }
            else
            {
                // action failed to initialize
                $error = 'Action initialization failed for module "%s", action "%s"';
                $error = sprintf($error, $moduleName, $actionName);

                throw new sfInitializationException($error);
            }

        }
        else
        {
            // module is disabled
            $moduleName = sfConfig::get('sf_module_disabled_module');
            $actionName = sfConfig::get('sf_module_disabled_action');

            if (!$this->actionExists($moduleName, $actionName))
            {
                // cannot find mod disabled module/action
                $error = 'Invalid configuration settings: [sf_module_disabled_module] "%s", [sf_module_disabled_action] "%s"';
                $error = sprintf($error, $moduleName, $actionName);

                throw new sfConfigurationException($error);
            }

            $this->forward($moduleName, $actionName);
        }
    }

    protected function controllerExists($moduleName, $controllerName, $extension, $throwExceptions)
    {
        $classFile   = strtolower($extension);

        $classSuffix = ucfirst($classFile);

        $controller_class = $moduleName.'_'.$controllerName.'_'.$classSuffix;

        if (!isset($this->controllerClasses[$controller_class]))
        {
            $dirs = sfLoader::getControllerDirs($moduleName);

            foreach ($dirs as $dir => $checkEnabled)
            {
                // plugin module enabled?
                if ($checkEnabled && !in_array($moduleName, sfConfig::get('sf_enabled_modules')) && is_readable($dir))
                {
                    $error = 'The module "%s" is not enabled.';
                    $error = sprintf($error, $moduleName);

                    throw new sfConfigurationException($error);
                }

                $file        = $dir.'/'.$controllerName.$classSuffix.'.class.php';
                if (is_readable($file))
                {
                    // action class exists
                    require_once($file);

                    $this->controllerClasses[$moduleName.'_'.$controllerName.'_'.$classSuffix] = $controllerName.$classSuffix;

                    return true;
                }

                $module_file = $dir.'/'.$classFile.'s.class.php';
                if (is_readable($module_file))
                {
                    // module class exists
                    require_once($module_file);

                    if (!class_exists($moduleName.$classSuffix.'s', false))
                    {
                        if ($throwExceptions)
                        {
                            throw new sfControllerException(sprintf('There is no "%s" class in your action file "%s".', $moduleName.$classSuffix.'s', $module_file));
                        }

                        return false;
                    }

                    // action is defined in this class?
                    if (!in_array('execute'.ucfirst($controllerName), get_class_methods($moduleName.$classSuffix.'s')))
                    {
                        if ($throwExceptions)
                        {
                            throw new sfControllerException(sprintf('There is no "%s" method in your action class "%s"', 'execute'.ucfirst($controllerName), $moduleName.$classSuffix.'s'));
                        }

                        return false;
                    }

                    $this->controllerClasses[$moduleName.'_'.$controllerName.'_'.$classSuffix] = $moduleName.$classSuffix.'s';
                    return true;
                }
            }
        }
        elseif ($this->controllerClasses[$controller_class])
        {
            return true;
        }
        else
        {
            return false;
        }

        // send an exception if debug
        if ($throwExceptions && sfConfig::get('sf_debug'))
        {
            $dirs = array_keys($dirs);

            // remove sf_root_dir from dirs
            foreach ($dirs as &$dir)
            {
                $dir = str_replace(sfConfig::get('sf_root_dir'), '%SF_ROOT_DIR%', $dir);
            }

            $this->controllerClasses[$controller_class] = false;

            throw new sfControllerException(sprintf('{sfController} controller "%s/%s" does not exist in: %s', $moduleName, $controllerName, implode(', ', $dirs)));
        }

        return false;
    }

    public function convertUrlStringToParameters($internal_url)
    {
        $internal_url = ltrim($internal_url, '/');

        if (!$internal_url) 
        {
            $internal_url = '/';
        }

        $pos = strpos($internal_url, '?');

        $route_name = '';

        $params = array();


        if (false !== $pos)
        {
            $query_string = substr($internal_url, $pos + 1);

            $internal_url = substr($internal_url, 0, $pos);
       
            $tmp = explode("&", $query_string);

            foreach ($tmp as $t)
            {
              list($name, $value) = explode('=', $t);

              $params[$name] = $value;
            }
        }

        if ($internal_url[0] == '@')
        {
            $route_name = substr($internal_url, 1);

            $route_params = sfRouting::getInstance()->getRouteByName($route_name);

            $params = array_merge($route_params[4], $params);
        }
        else
        {
            $tmp = explode('/', $internal_url);

            $params['module'] = $tmp[0];

            $params['action'] = isset($tmp[1]) ? $tmp[1] : sfConfig::get('sf_default_action');
        }

        return array($route_name, $params);
    }
}