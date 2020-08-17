<?php
try {
    if (version_compare($version_old, '7.0.0.1', '<')) 
    {
        $databaseManager = new sfDatabaseManager();
        $databaseManager->initialize();

        $theme = ThemePeer::doSelectByName('airsports');
        
        if (null === $theme) {
            $argentorwd = ThemePeer::doSelectByName('argentorwd');
            $theme = new Theme();
            $theme->setName('airsports');
            $theme->setVersion(7);              
            $theme->setBaseThemeId($argentorwd->getId());
        } 

        $theme->setIsSystemDefault(true);
        $theme->save();
        

        $databaseManager->shutdown();
    }
} catch (Exception $e) {}