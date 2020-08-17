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
 * @version     $Id: stCompileConfigHandler.php 3160 2010-01-26 13:30:27Z marek $
 * @author      Marcin Butlak <marcin.butlak@sote.pl>
 */

/** 
 * Overload config file generator.
 * Skip config.php files loading from plugins.
 *
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 *
 * @package     stUpdate
 * @subpackage  libs
 */
class stCompileConfigHandler extends sfCompileConfigHandler
{
  /** 
   * Overload config generator.
   *
   * @param   array       An                  array of absolute filesystem path to a configuration file
   * @return  string      Data to be written to a cache file
   * @throws sfConfigurationException If a requested configuration file does not exist or is not readable
   * @throws sfParseException If a requested configuration file is improperly formatted
   */
  public function execute($configFiles)
  {
    $retval = parent::execute($configFiles);
                      
    $retval = str_replace("sfLoader::loadPluginConfig();", "", $retval);

    return $retval;
  }

}
