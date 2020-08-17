<?php
try {
    if (version_compare($version_old, '7.0.0.0', '<')) 
    {
        $databaseManager = new sfDatabaseManager();
        $databaseManager->initialize();

        $theme = ThemePeer::doSelectByName('cutlery');
        
        if (null === $theme) {

            $responsive = ThemePeer::doSelectByName('responsive');
            $argentorwd = ThemePeer::doSelectByName('argentorwd');

            if (null === $responsive) {
                $responsive = new Theme();
                $responsive->setName('responsive');
                $responsive->setVersion(7);              
                $responsive->setIsSystemDefault(true);
                $responsive->save();
            }

            if (null === $argentorwd) {
                $argentorwd = new Theme();
                $argentorwd->setName('argentorwd');
                $argentorwd->setVersion(7);              
                $argentorwd->setBaseThemeId($responsive->getId());
                $argentorwd->setIsSystemDefault(true);
                $argentorwd->save();
            }

            $theme = new Theme();
            $theme->setName('cutlery');
            $theme->setVersion(7);              
            $theme->setBaseThemeId($argentorwd->getId());
        } 

        $theme->setIsSystemDefault(true);
        $theme->save();
        

        $databaseManager->shutdown();
    }
} catch (Exception $e) {}
