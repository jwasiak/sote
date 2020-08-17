<?php

/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 * (c) 2004-2006 Sean Kerr <sean@code-box.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfCompileConfigHandler gathers multiple files and puts them into a single file.
 * Upon creation of the new file, all comments and blank lines are removed.
 *
 * @package    symfony
 * @subpackage config
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @author     Sean Kerr <sean@code-box.org>
 * @version    SVN: $Id: sfCompileConfigHandler.class.php 7791 2008-03-09 21:57:09Z fabien $
 */
class stCompileConfigHandler extends sfCompileConfigHandler
{
  /**
   * Executes this configuration handler.
   *
   * @param array An array of absolute filesystem path to a configuration file
   *
   * @return string Data to be written to a cache file
   *
   * @throws sfConfigurationException If a requested configuration file does not exist or is not readable
   * @throws sfParseException If a requested configuration file is improperly formatted
   */
    public function execute($configFiles)
    {
        $ret = parent::execute($configFiles);

        $loader_path = sfConfig::get('sf_lib_dir') . DIRECTORY_SEPARATOR . 'symfony' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'sfLoader.class.php';

        $ret = str_replace("require_once(\$sf_symfony_lib_dir.'/config/sfLoader.class.php');", "require_once('$loader_path');", $ret);

        return str_replace("<?php", "<?php\n", $ret);
    }
}
