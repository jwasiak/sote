<?php
try {
    if (version_compare($version_old, '7.0.0.0', '<')) 
    {
        $databaseManager = new sfDatabaseManager();
        $databaseManager->initialize();

        $theme = ThemePeer::doSelectByName('argentorwd');
        
        if (!$theme) {
            $responsive = ThemePeer::doSelectByName('responsive');
            
            if (!$responsive) 
            {
                $responsive = new Theme();
                $responsive->setName('responsive');
                $responsive->setVersion(7);              
                $responsive->setIsSystemDefault(true);
                $responsive->save();
            }
            if (is_object($responsive)) {
                $theme = new Theme();
                $theme->setName('argentorwd');
                $theme->setVersion(7);              
                $theme->setIsSystemDefault(true);
                $theme->setBaseThemeId($responsive->getId());
                $theme->save();
            }
        }

        $databaseManager->shutdown();
    }
} catch (Exception $e) {}
