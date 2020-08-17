<?php
try {
    if (version_compare($version_old, '1.0.6.63', '<')) {
        $template_lib = sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.'update'.DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.'stSetup'.DIRECTORY_SEPARATOR.'lib';

        if(is_file($template_lib.DIRECTORY_SEPARATOR.'stSetupRequirements.class.php')) {
            unlink($template_lib.DIRECTORY_SEPARATOR.'stSetupRequirements.class.php');
        }
    }

    if (version_compare($version_old, '1.0.10.5', '<')) {
        $files = glob(sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'db'.DIRECTORY_SEPARATOR.'.apps'.DIRECTORY_SEPARATOR.'app*.reg');
        foreach ($files as $file) stWebStore::updateActive(preg_replace('/\.reg$/', '', basename($file)));
    }
} catch (Exception $e) { }