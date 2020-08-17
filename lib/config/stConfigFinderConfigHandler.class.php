<?php

/**
 * Klasa generujaca sciezki do wszystkich modulow znajdujacych sie w pluginach
 *
 * @package    stSymfonyUpdate
 * @subpackage libs
 * @author     Marcin Butlak
 * @version    SVN: $Id: stConfigFinderConfigHandler.class.php 1666 2009-06-10 14:41:07Z marcin $
 */
class stModuleFinderConfigHandler extends sfYamlConfigHandler
{
    public function execute($configFiles)
    {
        // parse the yaml
        $config = array();

        $content = '';

        foreach ($configFiles as $configFile)
        {
            $config = array_merge_recursive($config, $this->parseYaml($configFile));
        }

        foreach ($config['search_paths'] as $config_path)
        {
            $paths = glob($this->getPath($config_path));

            foreach ($paths as $path)
            {
                $content .= "'" . basename($path) . "' => '". $path  . "',\n";
            }
        }

        return '<?php self::$pluginModulePaths = array(' . $content . '); ?>';
    }

    protected function getPath($path)
    {
        return sfConfig::get('sf_root_dir') . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, trim($path, '/'));
    }
}

?>
