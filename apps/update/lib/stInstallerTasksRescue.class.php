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
 * @version     $Id: stInstallerTasksRescue.class.php 11221 2011-02-22 13:05:58Z marcin $
 * @author      Marek Jakubowicz <marek.jakubowicz@sote.pl>
 */
/**
 * Token keys.
 */
require_once (sfConfig::get('sf_app_lib_dir').DIRECTORY_SEPARATOR.'stToken.php');

/**
 * Logs
 */
if (!defined('ST_INSTALLER_LOG_PAGE'))
   define("ST_INSTALLER_LOG_PAGE", sfConfig::get('sf_log_dir').DIRECTORY_SEPARATOR.'webinstaller.log');

/**
 * Temporary list of synchronized applications.
 */
define("ST_APPSTOSYNC_FILE", sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'db'.DIRECTORY_SEPARATOR.'.appstosync.reg');

/**
 * Temporary list of applications installed before synchonization.
 */
define("ST_REGSYNC_PRE_INSTALL_FILE", sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'db'.DIRECTORY_SEPARATOR.'.regsync.reg');

sfLoader::loadHelpers('Helper');
use_helper('I18N', 'Url', 'Tag');
use_helper('stProgressBar', 'Partial');

/**
 * Installer WWW. Progress bar steps.
 *
 * @package     stUpdate
 * @subpackage  libs
 */
class stInstallerTasksRescue extends stInstallerTasks
{

   public function step($step)
   {
      stPropelGeneratorController::forceRebuild();

      return parent::step($step);
   }

}