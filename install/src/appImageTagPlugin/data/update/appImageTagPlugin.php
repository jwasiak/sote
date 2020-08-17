<?php
try {
    if (version_compare($version_old, '7.2.0.0', '<=')) {
        $files = array( 'appImageTagPlugin/css/backend.css',
                        'appImageTagPlugin/css/taggd.css',
                        'appImageTagPlugin/js/backend.js',
                        'appImageTagPlugin/js/jquery.taggd.js',
                        'appImageTagPlugin/css',
                        'appImageTagPlugin/js',
                        'appImageTagPlugin',
                        'slider-pro/css/images/blank.gif',
                        'slider-pro/css/images/closedhand.cur',
                        'slider-pro/css/images/openhand.cur',
                        'slider-pro/css/slider-pro.css',
                        'slider-pro/css/slider-pro.min.css',
                        'slider-pro/js/jquery.sliderPro.js',
                        'slider-pro/js/jquery.sliderPro.min.js',
                        'slider-pro/css',
                        'slider-pro/css/images',
                        'slider-pro/js',
                        'slider-pro',
        );
        foreach ($files as $file) {
            $file = sfConfig::get('sf_web_dir').'/'.$file;
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
