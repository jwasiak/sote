<?php
/** 
 * SOTESHOP/stUpdate 
 * 
 * This file is the part of stUpdate application. License: (Open License SOTE) Open License SOTE. 
 * Do not modify this file, system will overwrite it during upgrade.
 * 
 * @package     stUpdate
 * @subpackage  configs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Open License SOTE
 * @version     $Id: config.php 3160 2010-01-26 13:30:27Z marek $
 * @author      Marek Jakubowiucz <marek.jakubowicz@sote.pl>
 */

#stPluginHelper::addEnableModule('stInstallerWeb', 'update');              
//stPluginHelper::addRouting('stInstallerWebPlugin', '/installerweb/:action/*','stInstallerWeb', null, 'update');      // routing przekierowujący każdą akcje
//stPluginHelper::addRouting('stInstallerWebPluginDefault', '/installerweb', 'stInstallerWeb', 'upgradelist', 'update');     // domyślny routing                  