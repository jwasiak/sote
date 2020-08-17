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
 * @version     $Id: stCore.class.php 3160 2010-01-26 13:30:27Z marek $
 * @author      Marcin Butlak <marcin.butlak@sote.pl>
 */

require_once ($sf_symfony_lib_dir . DIRECTORY_SEPARATOR . 'util' . DIRECTORY_SEPARATOR . 'sfCore.class.php');

/** 
 * Extended symfony kernel.
 *
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 *
 * @package     stUpdate
 * @subpackage  libs
 */
class stCore extends sfCore
{
    /** 
     * Overload bootstrap.
     * New config loader. Skip config.php files loading from plugins.
     *
     * @param   string      $sf_symfony_lib_dir symfony lub dir
     * @param   string      $sf_symfony_data_dir symfony data dir
     */
    static public function bootstrap($sf_symfony_lib_dir, $sf_symfony_data_dir)
    {
        require_once ($sf_symfony_lib_dir . '/util/sfToolkit.class.php');
        require_once ($sf_symfony_lib_dir . '/config/sfConfig.class.php');
        
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
    /** 
     * Overload callBootstrap.
     * New config loader. Skip config.php files loading from plugins.
     */
    static public function callBootstrap()
    {
        $bootstrap = sfConfig::get('sf_config_cache_dir') . DIRECTORY_SEPARATOR . 'config_bootstrap_compile.yml.php';
        if (is_readable($bootstrap))
        {
            sfConfig::set('sf_in_bootstrap', true);
            require ($bootstrap);
        }
        else
        {
            require (sfConfig::get('sf_app_dir') . DIRECTORY_SEPARATOR . 'symfony.php');
        }
    }
}
?>