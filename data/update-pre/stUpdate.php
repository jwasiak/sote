<?php

if (version_compare($version_old, '1.0.11.19', '<')) {
    try {
        $path = sfConfig::get('sf_plugins_dir').'/stProgressBarPlugin/modules/stProgressBar/config';
        if (!file_exists($path)) mkdir($path);
        file_put_contents($path.'/security.yml', sfYaml::dump(array('all' => array('is_secure' => 'on'))));
    } catch (Exception $e) {
    }
}