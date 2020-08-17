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
 * @subpackage  helpers
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stPartialHelper.php 7461 2010-08-10 14:41:38Z marcin $
 * @author      Marek Jakubowicz <marek.jakubowicz@sote.pl>
 */

/**
 * Zwraca komponent, jeśli istnieje.
 *
 * @param   string      $module             nazwa modułu
 * @param        string      $component
 * @param         array       $data
 * @return   string
 */
function st_get_component($module, $component, $params = array())
{
    if (SF_APP == 'backend')
    {
        $user = sfContext::getInstance()->getUser();

        if (!$user->hasParameter($module, 'stAdminGeneratPlugin/generate'))
        {
            $user->setParameter($module, true,'stAdminGeneratPlugin/generate');

            $x = sfConfigCache::getInstance()->checkConfig(sfConfig::get('sf_app_module_dir_name').'/'.$module.'/'.sfConfig::get('sf_app_module_config_dir_name').'/generator.yml', true);
            if (!empty($x))
            {
                require($x);
            }
        }
    }

    try
    {
        return st_get_fast_component($module, $component, $params);
    }
    catch(sfConfigurationException $e)
    {
        return null;
    }
}

/**
 * Zwraca partial, jeśli istnieje.
 *
 * @param        string      $partial
 * @param   array       $params             Dodatkowe parametry jakie maja zostac przekazane do partial'a
 * @return   string
 * @todo zweryfikowac dzialanie
 */
function st_get_partial($partial, $params = array())
{
    if (SF_APP == 'backend')
    {
        if (($pos = strpos($partial, '/')) !== false)
        {
            $module = substr($partial, 0, $pos);
        }
        else
        {
            $module = sfContext::getInstance()->getActionStack()->getLastEntry()->getModuleName();
        }

        $user = sfContext::getInstance()->getUser();

        if (!$user->hasParameter($module, 'stAdminGeneratPlugin/generate'))
        {
            $user->setParameter($module, true,'stAdminGeneratPlugin/generate');

            $x = sfConfigCache::getInstance()->checkConfig(sfConfig::get('sf_app_module_dir_name').'/'.$module.'/'.sfConfig::get('sf_app_module_config_dir_name').'/generator.yml', true);

            if (!empty($x))
            {
                require($x);
            }
        }
    }

    try
    {
        return st_get_fast_partial($partial, $params);
    }
    catch (sfConfigurationException $e)
    {
        return null;
    }
}

/**
 * Załącza komponent, jeśli istnieje
 *
 * @param        string      $module
 * @param        string      $component
 * @param         array       $params
 */
function st_include_component($module, $component, $params = array())
{
    echo st_get_component($module, $component, $params);
}

/**
 * Załącza partial (szablon), jeśli istnieje
 *
 * @param        string      $partial
 * @param         array       $params
 */
function st_include_partial($partial, $params = array())
{
    echo st_get_partial($partial, $params);
}

/**
 *
 * Optimized version of symfony's get_partial helper
 *
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 * @param string $template_file Partial name
 * @param array $vars Variables accessible in the partial template
 * @param bool $disable_cache_manager Disable cache manager
 * @return string Result of the partial execution
 */
function st_get_fast_partial($template_file, $vars = array(), $disable_cache_manager = false)
{
    static $sf_flash = null;

    static $load_helpers = true;

    static $i18n = null;

    $context = sfContext::getInstance();

    if (null === $i18n)
    {
        $i18n = $context->getI18N();
    }

    $sf_logging = sfConfig::get('sf_logging_enabled');

    $sf_debug = sfConfig::get('sf_debug');

    if (($pos = strpos($template_file, '/')) !== false)
    {
        $_module_name = substr($template_file, 0, $pos);

        $template_file = substr($template_file, $pos + 1);
    }
    else
    {
        $_module_name = $context->getActionStack()->getLastEntry()->getModuleName();
    }

    $_action_name = '_' . $template_file;

    if ($sf_logging && $sf_debug)
    {
        $timer_all = sfTimerManager::getTimer('All Partials');

        $timer = sfTimerManager::getTimer(sprintf('Partial "%s/%s"', $_module_name, $_action_name));
    } 

    if ($disable_cache_manager == false)
    {
        $cache = stPartialCache::getInstance($context);

        $_is_cacheable = isset($vars['_is_cacheable']) && !$vars['_is_cacheable'] ? false : $cache->isCacheable($_module_name, $_action_name);

        if ($_is_cacheable)
        {
            $_cache_id = stPartialCache::generateIdFromArray($vars, $_module_name, $_action_name);

            $retval = $cache->get($_module_name, $_action_name, $_cache_id, $context->getUser()->getCulture());

            if ($retval !== false)
            {
                return $retval;
            }
        }
    }

    $template_file = $_action_name . '.php';

    $template_dir = sfLoader::getTemplateDir($_module_name, $template_file);

    if (!$template_dir)
    {
        throw new sfRenderException(sprintf('The template "%s" does not exist in: %s', $template_file, $template_dir));
    }

    if ($load_helpers)
    {
        $load_helpers = false;

        $core_helpers = array('Helper', 'stUrl', 'Asset', 'Tag', 'Escaping');

        $standard_helpers = sfConfig::get('sf_standard_helpers');

        sfLoader::loadHelpers($core_helpers);

        sfLoader::loadHelpers($standard_helpers);
    }

    $sf_context = $context;

    $sf_params = $context->getRequest()->getParameterHolder();

    $sf_request = $context->getRequest();

    $sf_user = $context->getUser();

    if ($sf_flash === null)
    {
        $sf_flash = new sfFlashEmulation($sf_user);
    }

    if (!empty($vars))
    {
        extract($vars);
    }

    if (sfConfig::get('sf_escaping_strategy') !== false)
    {
        $sf_data = sfOutputEscaper::escape(sfConfig::get('sf_escaping_method'), $vars);
    }

    ob_start();

    ob_implicit_flush(0);

    $i18n->setCurrentCatalogue($_module_name);

    require($template_dir . DIRECTORY_SEPARATOR . $template_file);

    $i18n->revertToPreviousCatalogue();

    $retval = ob_get_clean();

    if ($sf_logging && $sf_debug)
    {
        $timer->addTime();

        $timer_all->addTime();
    }

    if ($disable_cache_manager == false && $_is_cacheable)
    {
        $cache->set($_module_name, $_action_name, $_cache_id, $retval, $context->getUser()->getCulture());
    }

    return $retval;
}

/**
 *
 * Optimized version of symfony's get_component helper
 *
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 * @param string $_module_name Module name
 * @param string $componentName Component name
 * @param array $vars Variables accessible in the component template
 * @return string Result of the component execution
 */
function st_get_fast_component($_module_name, $componentName, $vars = array())
{
    static $i18n = null;

    $context = sfContext::getInstance();

    if (null === $i18n)
    {
        $i18n = $context->getI18N();
    }

    $sf_logging = sfConfig::get('sf_logging_enabled');

    $sf_debug = sfConfig::get('sf_debug');

    $cache = stPartialCache::getInstance($context);

    $_action_name = '_'.$componentName;

    $_is_cacheable = isset($vars['_is_cacheable']) && !$vars['_is_cacheable'] ? false : $cache->isCacheable($_module_name, $_action_name);

    if ($_is_cacheable)
    {
        $_cache_id = stPartialCache::generateIdFromArray($vars, $_module_name, $_action_name);

        $retval = $cache->get($_module_name, $_action_name, $_cache_id, $context->getUser()->getCulture());

        if ($retval !== false)
        {
            return $retval;
        }
    }

    $controller = $context->getController();

    if (!$controller->componentExists($_module_name, $componentName))
    {
        $error = 'The component does not exist: "%s", "%s"';
        $error = sprintf($error, $_module_name, $componentName);

        throw new sfConfigurationException($error);
    }

    $componentInstance = $controller->getComponent($_module_name, $componentName);

    if (!$componentInstance->initialize($context))
    {
        $error = 'Component initialization failed for module "%s", component "%s"';
        $error = sprintf($error, $_module_name, $componentName);

        throw new sfInitializationException($error);
    }

    if (!empty($vars))
    {
        $componentInstance->getVarHolder()->add($vars);
    }

    $componentToRun = 'execute'.ucfirst($componentName);

    if ($sf_logging)
    {
        $context->getLogger()->info('{PartialHelper} call "'.$_module_name.'->'.$componentToRun.'()'.'"');

        if ($sf_debug)
        {
            $timer_all = sfTimerManager::getTimer('All Components');

            $timer = sfTimerManager::getTimer(sprintf('Component "%s/%s"', $_module_name, $componentName));
        }
    }

    $i18n->setCurrentCatalogue($_module_name);

    $retval = $componentInstance->$componentToRun();

    $i18n->revertToPreviousCatalogue();

    if ($sf_logging && $sf_debug)
    {
        $timer->addTime();

        $timer_all->addTime();
    }

    if ($retval != sfView::NONE)
    {
        if ($retval instanceof stSmarty)
        {
            $i18n->setCurrentCatalogue($_module_name);

            $retval = $retval->fetch(sfInflector::underscore($componentName).'.html');

            $i18n->revertToPreviousCatalogue();
        }
        else
        {
            $retval = st_get_fast_partial($_module_name . '/' . $componentName, $componentInstance->getVarHolder()->getAll(), $_is_cacheable);
        }
    }
    else
    {
        $retval = '';
    }

    if ($_is_cacheable)
    {
        $cache->set($_module_name, $_action_name, $_cache_id, $retval, $context->getUser()->getCulture());
    }

    return $retval;
}

function _st_get_fast_cache($cacheManager, $uri)
{
    $retval = $cacheManager->get($uri);

    if (sfConfig::get('sf_web_debug'))
    {
        $retval = sfWebDebug::getInstance()->decorateContentWithDebug(url_for($uri), $retval, false);
    }

    return $retval;
}

function _st_set_fast_cache($cacheManager, $uri, $retval)
{
    $saved = $cacheManager->set($retval, $uri);

    if ($saved && sfConfig::get('sf_web_debug'))
    {
        $retval = sfWebDebug::getInstance()->decorateContentWithDebug(url_for($uri), $retval, true);
    }

    return $retval;
}

/**
 *
 * A faster implementation of the $sf_flash variable accessible in the templates
 *
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 * @package     stBase
 * @subpackage  helpers
 */
class sfFlashEmulation
{
    protected $user = null;

    public function __construct(sfUser $user)
    {
        $this->user = $user;
    }

    public function get($name)
    {
        return $this->user->getAttribute($name, null, 'symfony/flash');
    }

    public function set($name, $value)
    {
        return $this->user->setAttribute($name, $value, 'symfony/flash');
    }

    public function has($name)
    {
        return $this->user->hasAttribute($name, 'symfony/flash');
    }
}