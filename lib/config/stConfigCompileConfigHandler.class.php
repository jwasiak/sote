<?php

/**
 * Klasa scalajaca wszystkie pliki config/config.php
 *
 * @package    stSymfonyUpdate
 * @subpackage libs
 * @author     Marcin Butlak
 * @version    SVN: $Id: stConfigCompileConfigHandler.class.php 1666 2009-06-10 14:41:07Z marcin $
 */
class stConfigCompileConfigHandler extends sfYamlConfigHandler
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
                $content .= $this->compilePhp($path) . "\n";
            }
        }
        
        eval('$dispatcher = stEventDispatcher::getInstance();'.$content);

        $compiled_content = '';
        
        if (sfConfig::get('sf_debug'))
        {
            $compiled_content .= "\$timer = sfTimerManager::getTimer('Plugin configuration');\n";
        }

        $sf_config = sfConfig::getAll();
        unset($sf_config['sf_timer_start']);
                
        $compiled_content .= sprintf("sfConfig::add(%s);\n", var_export($sf_config, true));
        $compiled_content .= sprintf("if(method_exists(stEventDispatcher::getInstance(), 'setListeners')){\n\tstEventDispatcher::getInstance()->setListeners(%s);\n}\n", var_export(stEventDispatcher::getInstance()->getListeners(), true));
        $compiled_content .= sprintf("sfPropelBehavior::setBehaviors(%s);\n", var_export(sfPropelBehavior::getBehaviors(), true));
        $compiled_content .= sprintf("sfMixer::setMixins(%s);\n", var_export(sfMixer::getMixins(), true));
        $compiled_content .= sprintf("sfMixer::setMixinParameters(%s);\n", var_export(sfMixer::getMixinParameters(), true));
        $compiled_content .= sprintf("sfRouting::getInstance()->setRoutes(%s);\n", var_export(sfRouting::getInstance()->getRoutes(), true));
        
        if (sfConfig::get('sf_debug'))
        {
            $compiled_content .= "\$timer->addTime();";
        }

        return "<?php\n".$compiled_content."\n?>";
    }
    /**
     *
     * Zamienia sciezke relatywna na absolutna
     *
     * @param string $path Sciezka relatywna
     * @return string Sciezka absolutna
     */
    protected function getPath($path)
    {
        return sfConfig::get('sf_root_dir') . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, trim($path, '/'));
    }

    /**
     *
     * Minimalizuje skrypt php
     *
     * @param string $filename Sciezka do skryptu php
     * @return string Zminimalizowany skrypt php
     */
    protected function compilePhp($filename)
    {
        $content = file_get_contents($filename);

        return substr(rtrim($content, "?>\n\r"), 5);
    }
}

?>