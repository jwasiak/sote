<?php
if (version_compare($version_old, '2.1.0.0', '<'))
{
    $dir = sfConfig::get('sf_plugins_dir').'/sfExtjs2Plugin';

    if (is_dir($dir))
    {
        sfToolkit::clearDirectory($dir);
        rmdir($dir);
    }
}

try {
    if (version_compare($version_old, '7.2.0.0', '<')) {
        $dir = sfConfig::get('sf_web_dir').'/sfExtjs2Plugin';
        if (is_dir($dir)) {
            sfToolkit::clearDirectory($dir);
            rmdir($dir);
        }
    }
} catch (Exception $e) {
    // @todo: log $e->getMessage();
}
