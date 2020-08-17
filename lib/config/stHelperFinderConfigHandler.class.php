<?php
class stHelperFinderConfigHandler extends sfYamlConfigHandler
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
                $content .= "'" . $this->getHelperNameFromPath($path) . "' => '". $path  . "',\n";
            }
        }

        return '<?php self::$helperPaths = array(' . $content . '); ?>';
    }

    protected function getPath($path)
    {
        return sfConfig::get('sf_root_dir') . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, trim($path, '/'));
    }

    protected function getHelperNameFromPath($path)
    {
        $helper = basename($path);

        $helper = str_replace('Helper.class.php', '', $helper);

        return str_replace('Helper.php', '', $helper);
    }
}

?>
