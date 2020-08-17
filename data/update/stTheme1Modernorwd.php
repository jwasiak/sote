<?php
try {
    if (version_compare($version_old, '7.0.0.2', '<')) 
    {
        $databaseManager = new sfDatabaseManager();
        $databaseManager->initialize();

        $theme = ThemePeer::doSelectByName('modernorwd');
        
        if (null === $modernorwd) {
            $argentorwd = ThemePeer::doSelectByName('argentorwd');
            $theme = new Theme();
            $theme->setName('modernorwd');
            $theme->setVersion(7);              
            $theme->setBaseThemeId($argentorwd->getId());
        } 

        $theme->setIsSystemDefault(true);
        $theme->save();
        

        $databaseManager->shutdown();
    }
} catch (Exception $e) {}
