<?php
require_once($sf_symfony_lib_dir.'/util/sfCore.class.php');

class stCore extends sfCore
{
    static public function bootstrap($sf_symfony_lib_dir, $sf_symfony_data_dir)
    {
        require_once($sf_symfony_lib_dir.'/util/sfToolkit.class.php');
        require_once($sf_symfony_lib_dir.'/config/sfConfig.class.php');

        sfCore::initConfiguration($sf_symfony_lib_dir, $sf_symfony_data_dir);

        sfCore::initIncludePath();

        stCore::callBootstrap();

        if (sfConfig::get('sf_check_lock'))
        {
            sfCore::checkLock();
        }
        if (sfConfig::get('sf_check_symfony_version'))
        {
            sfCore::checkSymfonyVersion();
        }
    }

    static public function callBootstrap()
    {

        $bootstrap = sfConfig::get('sf_config_cache_dir').'/config_bootstrap_compile.yml.php';
        if (is_readable($bootstrap))
        {
            sfConfig::set('sf_in_bootstrap', true);
            require($bootstrap);
        }
        else
        {
            stLock::lock();
            require(sfConfig::get('sf_lib_dir') . DIRECTORY_SEPARATOR . 'symfony' . DIRECTORY_SEPARATOR . 'symfony.php');
            stLock::unlock();
        }
    }
}
?>
