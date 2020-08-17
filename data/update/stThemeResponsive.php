<?php
try {
    if (version_compare($version_old, '7.0.0.0', '<')) 
    {
        $databaseManager = new sfDatabaseManager();
        $databaseManager->initialize();

        $theme = ThemePeer::doSelectByName('responsive');

        if (!$theme) 
        {
            $theme = new Theme();
            $theme->setName('responsive');
            $theme->setVersion(7);              
            $theme->setIsSystemDefault(true);
            $theme->save();
        }

        $databaseManager->shutdown();
    }
} catch (Exception $e) {}

try {
    if (version_compare($version_old, '7.0.2.29', '<')) {
        $srcPath = sfConfig::get('sf_root_dir').'/install/src/stThemeResponsive/stThemeResponsive/';
        $path = '/plugins/stGoogleAnalyticsPlugin/modules/stGoogleAnalyticsFrontend/templates/theme/responsive/';
        foreach (array($path.'google_ecommerce.html', $path.'google_standard.html') as $file) {
            if (file_exists($srcPath.$file))
                copy($srcPath.$file, sfConfig::get('sf_root_dir').$file);
        }
    }
} catch (Exception $e) {}

try {
    if (version_compare($version_old, '7.2.0.1', '<')) {
        $files = array( 'css/swiper.min.css',
                        'js/swiper.jquery.min.js',
                        'css',
                        'js',
                        '',
        );
        foreach ($files as $file) {
            $file = sfConfig::get('sf_web_dir').'/plugins/swiper-slider/'.$file;
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
