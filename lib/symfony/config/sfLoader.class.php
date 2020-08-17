<?php
/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
*/

/**
 * sfLoader is a class which contains the logic to look for files/classes in symfony.
 *
 * @package    stSymfonyUpdate
 * @subpackage libs
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @author     Marcin Butlak
 * @version    SVN: $Id: sfLoader.class.php 1666 2009-06-10 14:41:07Z marcin $
 */

if (!defined('ST_SYMFONY_OPTIMIZATION'))
{
    define('ST_SYMFONY_OPTIMIZATION', true);
}

class sfLoader
{
    protected static $helperPaths = null;

    protected static $pluginModulePaths = null;

    protected static $templateDirs = array();


    public static function getPluginModulePaths()
    {
        if (is_null(self::$pluginModulePaths))
        {
            include_once(sfConfigCache::getInstance()->checkConfig('config/module_finder.yml'));
        }

        return self::$pluginModulePaths;
    }
    
    /**
     * Gets directories where model classes are stored. The order of returned paths is lowest precedence
     * to highest precedence.
     *
     * @return array An array of directories
     */
    static public function getModelDirs()
    {
        $dirs = array(); // project

        if ($pluginDirs = glob(sfConfig::get('sf_plugins_dir').'/*/lib/model'))
        {
            $dirs = array_merge($dirs, $pluginDirs);                                                                // plugins
        }

        $dirs[] = sfConfig::get('sf_lib_dir') ? sfConfig::get('sf_lib_dir').'/model' : 'lib/model';

        return $dirs;
    }

    /**
     * Gets directories where controller classes are stored for a given module.
     *
     * @param string The module name
     *
     * @return array An array of directories
     */
    static public function getControllerDirs($moduleName)
    {
        if (is_null(self::$pluginModulePaths))
        {
            include_once(sfConfigCache::getInstance()->checkConfig('config/module_finder.yml'));
        }

        $suffix = $moduleName.'/'.sfConfig::get('sf_app_module_action_dir_name');

        $dirs = array();

        $dirs[sfConfig::get('sf_app_module_dir').'/'.$suffix] = false;                                     // application

        if (isset(self::$pluginModulePaths[$moduleName]))
        {
            $dirs[self::$pluginModulePaths[$moduleName] . DIRECTORY_SEPARATOR . sfConfig::get('sf_app_module_action_dir_name')] = true;
        }

        $dirs[sfConfig::get('sf_symfony_data_dir').'/modules/'.$suffix] = true;                            // core modules

        return $dirs;
    }

    /**
     * Gets directories where template files are stored for a given module.
     *
     * @param string The module name
     *
     * @return array An array of directories
     */
    static public function getTemplateDirs($moduleName)
    {
        if (is_null(self::$pluginModulePaths))
        {
            include_once(sfConfigCache::getInstance()->checkConfig('config/module_finder.yml'));
        }

        $suffix = $moduleName.'/'.sfConfig::get('sf_app_module_template_dir_name');

        $dirs = array();
        foreach (sfConfig::get('sf_module_dirs', array()) as $key => $value)
        {
            $dirs[] = $key.'/'.$suffix;
        }

        $dirs[] = sfConfig::get('sf_app_module_dir').'/'.$suffix;                        // application

        if (isset(self::$pluginModulePaths[$moduleName]))
        {
            $dirs[] = self::$pluginModulePaths[$moduleName] . DIRECTORY_SEPARATOR . sfConfig::get('sf_app_module_template_dir_name');                                  // plugins
        }

        $dirs[] = sfConfig::get('sf_symfony_data_dir').'/modules/'.$suffix;              // core modules
        $dirs[] = sfConfig::get('sf_module_cache_dir').'/auto'.ucfirst($suffix);         // generated templates in cache

        return $dirs;
    }

    /**
     * Gets the template directory to use for a given module and template file.
     *
     * @param string The module name
     * @param string The template file
     *
     * @return string A template directory
     */
    static public function getTemplateDir($moduleName, $templateFile)
    {
        if (isset(self::$templateDirs[$moduleName.'/'.$templateFile]))
        {
            return self::$templateDirs[$moduleName.'/'.$templateFile];
        }

        if (self::$pluginModulePaths === null)
        {
            include_once(sfConfigCache::getInstance()->checkConfig('config/module_finder.yml'));
        }

        $suffix = $moduleName.DIRECTORY_SEPARATOR.sfConfig::get('sf_app_module_template_dir_name');

        if (is_readable(sfConfig::get('sf_app_module_dir').DIRECTORY_SEPARATOR.$suffix.DIRECTORY_SEPARATOR.$templateFile))
        {
            self::$templateDirs[$moduleName.'/'.$templateFile] = sfConfig::get('sf_app_module_dir').'/'.$suffix;
        }
        elseif (isset(self::$pluginModulePaths[$moduleName]) && is_readable(self::$pluginModulePaths[$moduleName].DIRECTORY_SEPARATOR.sfConfig::get('sf_app_module_template_dir_name').DIRECTORY_SEPARATOR.$templateFile))
        {
            self::$templateDirs[$moduleName.'/'.$templateFile] = self::$pluginModulePaths[$moduleName].DIRECTORY_SEPARATOR.sfConfig::get('sf_app_module_template_dir_name');                                  // plugins
        }
        elseif (is_readable(sfConfig::get('sf_module_cache_dir').DIRECTORY_SEPARATOR.'auto'.ucfirst($suffix).DIRECTORY_SEPARATOR.$templateFile))
        {
            self::$templateDirs[$moduleName.'/'.$templateFile] = sfConfig::get('sf_module_cache_dir').DIRECTORY_SEPARATOR.'auto'.ucfirst($suffix);
        }
        elseif (is_readable(sfConfig::get('sf_symfony_data_dir').'/modules/'.$suffix.DIRECTORY_SEPARATOR.$templateFile))
        {
            self::$templateDirs[$moduleName.'/'.$templateFile] = sfConfig::get('sf_symfony_data_dir').'/modules/'.$suffix;
        }
        else
        {
            self::$templateDirs[$moduleName.'/'.$templateFile] = null;
        }

        return self::$templateDirs[$moduleName.'/'.$templateFile];
    }

    /**
     * Gets the template to use for a given module and template file.
     *
     * @param string The module name
     * @param string The template file
     *
     * @return string A template path
     */
    static public function getTemplatePath($moduleName, $templateFile)
    {
        $dir = self::getTemplateDir($moduleName, $templateFile);

        return $dir ? $dir.'/'.$templateFile : null;
    }

    /**
     * Gets the i18n directory to use for a given module.
     *
     * @param string The module name
     *
     * @return string An i18n directory
     */
    static public function getI18NDir($moduleName)
    {
        if (is_null(self::$pluginModulePaths))
        {
            include_once(sfConfigCache::getInstance()->checkConfig('config/module_finder.yml'));
        }

        $suffix = $moduleName.'/'.sfConfig::get('sf_app_module_i18n_dir_name');

        // application
        $dir = sfConfig::get('sf_app_module_dir').'/'.$suffix;
        if (is_dir($dir))
        {
            return $dir;
        }

        if (isset(self::$pluginModulePaths[$moduleName]) && is_readable(self::$pluginModulePaths[$moduleName] . DIRECTORY_SEPARATOR . sfConfig::get('sf_app_module_i18n_dir_name')))
        {
            return self::$pluginModulePaths[$moduleName] . DIRECTORY_SEPARATOR . sfConfig::get('sf_app_module_i18n_dir_name');
        }

        return null;
    }

    /**
     * Gets directories where template files are stored for a generator class and a specific theme.
     *
     * @param string The generator class name
     * @param string The theme name
     *
     * @return array An array of directories
     */
    static public function getGeneratorTemplateDirs($class, $theme)
    {
        $dirs = array(sfConfig::get('sf_data_dir').'/generator/'.$class.'/'.$theme.'/template');                  // project

        if ($pluginDirs = glob(sfConfig::get('sf_plugins_dir').'/*/data/generator/'.$class.'/'.$theme.'/template'))
        {
            $dirs = array_merge($dirs, $pluginDirs);                                                                // plugin
        }

        $dirs[] = sfConfig::get('sf_symfony_data_dir').'/generator/'.$class.'/default/template';                  // default theme

        return $dirs;
    }

    /**
     * Gets directories where the skeleton is stored for a generator class and a specific theme.
     *
     * @param string The generator class name
     * @param string The theme name
     *
     * @return array An array of directories
     */
    static public function getGeneratorSkeletonDirs($class, $theme)
    {
        $dirs = array(sfConfig::get('sf_data_dir').'/generator/'.$class.'/'.$theme.'/skeleton');                  // project

        if ($pluginDirs = glob(sfConfig::get('sf_plugins_dir').'/*/data/generator/'.$class.'/'.$theme.'/skeleton'))
        {
            $dirs = array_merge($dirs, $pluginDirs);                                                                // plugin
        }

        $dirs[] = sfConfig::get('sf_symfony_data_dir').'/generator/'.$class.'/default/skeleton';                  // default theme

        return $dirs;
    }

    /**
     * Gets the template to use for a generator class.
     *
     * @param string The generator class name
     * @param string The theme name
     * @param string The template path
     *
     * @return string A template path
     *
     * @throws sfException
     */
    static public function getGeneratorTemplate($class, $theme, $path)
    {
        $dirs = self::getGeneratorTemplateDirs($class, $theme);
        foreach ($dirs as $dir)
        {
            if (is_readable($dir.'/'.$path))
            {
                return $dir.'/'.$path;
            }
        }

        throw new sfException(sprintf('Unable to load "%s" generator template in: %s', $path, implode(', ', $dirs)));
    }

    /**
     * Gets the configuration file paths for a given relative configuration path.
     *
     * @param string The configuration path
     *
     * @return array An array of paths
     */
    static public function getConfigPaths($configPath)
    {
        $globalConfigPath = basename(dirname($configPath)).'/'.basename($configPath);

        $files = array(
                sfConfig::get('sf_symfony_data_dir').'/'.$globalConfigPath,                    // symfony
                sfConfig::get('sf_symfony_data_dir').'/'.$configPath,                          // core modules
        );

        $files = array_merge($files, array(
                sfConfig::get('sf_root_dir').'/'.$globalConfigPath,                            // project
                sfConfig::get('sf_root_dir').'/'.$configPath,                                  // project
                sfConfig::get('sf_app_dir').'/'.$globalConfigPath,                             // application
                sfConfig::get('sf_cache_dir').'/'.$configPath,                                 // generated modules
        ));

        if ($pluginDirs = glob(sfConfig::get('sf_plugins_dir').'/*/'.$globalConfigPath))
        {
            $files = array_merge($files, $pluginDirs);                                     // plugins
        }

        if ($pluginDirs = glob(sfConfig::get('sf_plugins_dir').'/*/'.$configPath))
        {
            $files = array_merge($files, $pluginDirs);                                     // plugins
        }

        $files[] = sfConfig::get('sf_app_dir').'/'.$configPath;                          // module

        $configs = array();
        foreach (array_unique($files) as $file)
        {
            if (is_readable($file))
            {
                $configs[] = $file;
            }
        }

        return $configs;
    }

    /**
     * Gets the helper directories for a given module name.
     *
     * @param string The module name
     *
     * @return array An array of directories
     */
    static public function getHelperPath($helperName, $moduleName = '')
    {
        if (self::$helperPaths === null)
        {
            include_once(sfConfigCache::getInstance()->checkConfig('config/helper_finder.yml'));
        }

        $fileName = $helperName.'Helper.php';

        if ($moduleName)
        {
            $path = sfConfig::get('sf_app_module_dir'). DIRECTORY_SEPARATOR .$moduleName.DIRECTORY_SEPARATOR.sfConfig::get('sf_app_module_lib_dir_name').DIRECTORY_SEPARATOR.'helper'.DIRECTORY_SEPARATOR.$fileName;

            if (is_readable($path))
            {
                return $path;
            }

            if (isset(self::$helperPaths[$helperName]) && is_readable(self::$helperPaths[$helperName]))
            {
                return self::$helperPaths[$helperName];
            }
        }

        $path = sfConfig::get('sf_app_lib_dir'). DIRECTORY_SEPARATOR . 'helper' . DIRECTORY_SEPARATOR . $fileName;

        if (is_readable($path))
        {
            return $path;
        }

        $path = sfConfig::get('sf_lib_dir'). DIRECTORY_SEPARATOR . 'helper' . DIRECTORY_SEPARATOR . $fileName;

        if (is_readable($path))
        {
            return $path;
        }

        if (isset(self::$helperPaths[$helperName]) && is_readable(self::$helperPaths[$helperName]))
        {
            return self::$helperPaths[$helperName];
        }

        $path = sfConfig::get('sf_symfony_lib_dir'). DIRECTORY_SEPARATOR . 'helper' . DIRECTORY_SEPARATOR . $fileName;

        if (is_readable($path))
        {
            return $path;
        }

        return null;
    }

    /**
     * Loads helpers.
     *
     * @param array  An array of helpers to load
     * @param string A module name (optional)
     *
     * @throws sfViewException
     */
    static public function loadHelpers($helpers, $moduleName = '')
    {
        static $loaded = array();

        foreach ((array) $helpers as $helperName)
        {
            if (isset($loaded[$helperName]))
            {
                continue;
            }

            $fileName = $helperName.'Helper.php';

            if ($helperPath = self::getHelperPath($helperName, $moduleName))
            {
                if (@include($helperPath))
                {
                    $loaded[$helperName] = true;
                }
            }

            if (!isset($loaded[$helperName]))
            {
                // search in the include path
                if ((@include('helper/'.$fileName)) != 1)
                {
                    throw new sfViewException(sprintf('Unable to load "%sHelper.php" helper', $helperName));
                }
            }


        }
    }

    static public function loadPluginConfig()
    {
        include_once(sfConfigCache::getInstance()->checkConfig('config/config_compile.yml'));
    }
}
