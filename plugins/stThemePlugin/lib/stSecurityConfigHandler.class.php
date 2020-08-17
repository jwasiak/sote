<?php

/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
/** 
 * SOTESHOP/stThemePlugin 
 * 
 * Ten plik należy do aplikacji stThemePlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stThemePlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stSecurityConfigHandler.class.php 256 2009-03-30 11:49:45Z marek $
 */

/** 
 * sfSecurityConfigHandler allows you to configure action security.
 *
 * @author Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * @package     stThemePlugin
 * @subpackage  libs
 */
class stSecurityConfigHandler extends sfYamlConfigHandler
{
  /** 
   * Executes this configuration handler.
   *
   * @param   array       An                  array of absolute filesystem path to a configuration file
   * @return  string      Data to be written to a cache file
   * @throws <b>sfConfigurationException</b> If a requested configuration file does not exist or is not readable
   * @throws <b>sfParseException</b> If a requested configuration file is improperly formatted
   * @throws <b>sfInitializationException</b> If a view.yml key check fails
   */
  public function execute($configFiles)
  {
      
    // parse the yaml
    $myConfig = $this->parseYamls($configFiles);

    if (SF_APP == 'backend')
    {
        $myConfig['all'] = sfToolkit::arrayDeepMerge(
          isset($myConfig['default']) && is_array($myConfig['default']) ? $myConfig['default'] : array(),
          isset($myConfig['all']) && is_array($myConfig['all']) ? $myConfig['all'] : array()
        );
    } 
    elseif (SF_APP == 'frontend')
    {
        $myConfig['all'] = sfToolkit::arrayDeepMerge(
          isset($myConfig[SF_ENVIRONMENT]['default']) && is_array($myConfig[SF_ENVIRONMENT]['default']) ? $myConfig[SF_ENVIRONMENT]['default'] : array(),
          isset($myConfig[SF_ENVIRONMENT]['all']) && is_array($myConfig[SF_ENVIRONMENT]['all']) ? $myConfig[SF_ENVIRONMENT]['all'] : array()
        );
        
        unset($myConfig[SF_ENVIRONMENT]['default']);
        unset($myConfig[SF_ENVIRONMENT]['all']);
    }

  
    unset($myConfig['default']);

    // change all of the keys to lowercase
    $myConfig = array_change_key_case($myConfig);

    // compile data
    $retval = sprintf("<?php\n".
                      "// auto-generated by sfSecurityConfigHandler\n".
                      "// date: %s\n\$this->security = %s;\n",
                      date('Y/m/d H:i:s'), var_export($myConfig, true));

    return $retval;
  }
}