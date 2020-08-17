<?php
try {
    if (version_compare($version_old, '7.2.0.0', '<')) {
        $files = array( 'images/ajax-loader.gif',
                        'js/stTabNavigator.js',
                        'images',
                        'js',
                        '',
        );
        foreach ($files as $file) {
            $file = sfConfig::get('sf_web_dir').'/stTabNavigatorPlugin/'.$file;
            if (file_exists($file))
                if (is_dir($file))
                    rmdir($file);
                else
                    unlink($file);
        }
    }
} catch (Exception $e) {
    // @todo: log $e->getMessage();
}
