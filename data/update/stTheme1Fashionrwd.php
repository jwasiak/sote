<?php
try {
    if (version_compare($version_old, '7.0.0.0', '<')) 
    {
        $databaseManager = new sfDatabaseManager();
        $databaseManager->initialize();

        $theme = ThemePeer::doSelectByName('fashionrwd');
        
        if (!$theme) {
            $responsive = ThemePeer::doSelectByName('responsive');
            $argentorwd = ThemePeer::doSelectByName('argentorwd');
            
            if (!$responsive) 
            {
                $responsive = new Theme();
                $responsive->setName('responsive');
                $responsive->setVersion(7);              
                $responsive->setIsSystemDefault(true);
                $responsive->save();
            }
            if (!$argentorwd) 
            {
                $argentorwd = new Theme();
                $argentorwd->setName('argentorwd');
                $argentorwd->setVersion(7);   
                $argentorwd->setIsSystemDefault(true);
                $argentorwd->setBaseThemeId($responsive->getId());        
                $argentorwd->save();
            }
            if (is_object($responsive)) {
                $theme = new Theme();
                $theme->setName('fashionrwd');
                $theme->setVersion(7);    
                $theme->setIsSystemDefault(true);     
                $theme->setBaseThemeId($argentorwd->getId());
                $theme->save();
            }
        }

        $databaseManager->shutdown();
    }
} catch (Exception $e) {}
