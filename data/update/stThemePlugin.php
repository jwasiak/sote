<?php
try {
	if (version_compare($version_old, '1.0.7.10', '<'))
	{
		$databaseManager = new sfDatabaseManager();
		$databaseManager->initialize();

		$c = new Criteria();
		$c->add(ThemePeer::THEME, "Default");
		$theme = ThemePeer::doSelectOne($c);

		if ($theme)
		{
			$theme->setTheme("default");
			$theme->save();
		}

		$databaseManager->shutdown();
	}

	if (version_compare($version_old, '1.0.7.14', '<'))
	{
		$databaseManager = new sfDatabaseManager();
		$databaseManager->initialize();

		$c = new Criteria();
		$c->add(ThemePeer::THEME, "default");
		$theme = ThemePeer::doSelectOne($c);

		if (!$theme)
		{
			$theme = new Theme();
			$theme->setTheme("default");
			$theme->setActive(0);
			$theme->save();
		}

		$themeColorScheme = new ThemeColorScheme();
		$themeColorScheme->setThemeId($theme->getId());
		$themeColorScheme->setName("blue");
		$themeColorScheme->save();

		$themeColorScheme = new ThemeColorScheme();
		$themeColorScheme->setThemeId($theme->getId());
		$themeColorScheme->setName("brown");
		$themeColorScheme->save();

		$themeColorScheme = new ThemeColorScheme();
		$themeColorScheme->setThemeId($theme->getId());
		$themeColorScheme->setName("green");
		$themeColorScheme->save();

		$themeColorScheme = new ThemeColorScheme();
		$themeColorScheme->setThemeId($theme->getId());
		$themeColorScheme->setName("pink");
		$themeColorScheme->save();

		$themeColorScheme = new ThemeColorScheme();
		$themeColorScheme->setThemeId($theme->getId());
		$themeColorScheme->setName("red");
		$themeColorScheme->save();

		$theme = new Theme();
		$theme->setTheme("homeelectronics");
		$theme->setActive(0);
		$theme->save();

		$themeColorScheme = new ThemeColorScheme();
		$themeColorScheme->setThemeId($theme->getId());
		$themeColorScheme->setName("blue");
		$themeColorScheme->save();

		$themeColorScheme = new ThemeColorScheme();
		$themeColorScheme->setThemeId($theme->getId());
		$themeColorScheme->setName("brown");
		$themeColorScheme->save();

		$themeColorScheme = new ThemeColorScheme();
		$themeColorScheme->setThemeId($theme->getId());
		$themeColorScheme->setName("grey");
		$themeColorScheme->save();

		$themeColorScheme = new ThemeColorScheme();
		$themeColorScheme->setThemeId($theme->getId());
		$themeColorScheme->setName("green");
		$themeColorScheme->save();

		$databaseManager->shutdown();
	}

	if (version_compare($version_old, '1.0.8.1', '<'))
	{
		$template_dir = sfConfig::get('sf_plugins_dir').DIRECTORY_SEPARATOR.'stThemePlugin'.DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.'stThemeBackend'.DIRECTORY_SEPARATOR.'templates';

		if (is_file($template_dir.DIRECTORY_SEPARATOR.'_edit_form.php'))
		{
			unlink($template_dir.DIRECTORY_SEPARATOR.'_edit_form.php');
		}

		if (is_file($template_dir.DIRECTORY_SEPARATOR.'_list.php'))
		{
			unlink($template_dir.DIRECTORY_SEPARATOR.'_list.php');
		}

		if (is_file($template_dir.DIRECTORY_SEPARATOR.'_list_td_action_select.php'))
		{
			unlink($template_dir.DIRECTORY_SEPARATOR.'_list_td_action_select.php');
		}

		if (is_file($template_dir.DIRECTORY_SEPARATOR.'_list_td_actions.php'))
		{
			unlink($template_dir.DIRECTORY_SEPARATOR.'_list_td_actions.php');
		}
	}

	if (version_compare($version_old, '1.2.0.1', '<'))
	{
		$databaseManager = new sfDatabaseManager();
		$databaseManager->initialize();
			
		if (!ThemePeer::doSelectByName('default2'))
		{
			$theme = new Theme();

			$theme->setName('default2');

			$theme->setIsSystemDefault(true);

			$theme->save();
		}
			
		$databaseManager->shutdown();
	}

	if (version_compare($version_old, '1.2.0.10', '<'))
	{
		$databaseManager = new sfDatabaseManager();
		$databaseManager->initialize();
			
		$default2 = ThemePeer::doSelectByName('default2');
		if (is_object($default2))
		{
			$themes = array('black', 'black2', 'default2blue', 'default2purple', 'default2red', 'simple', 'simple2', 'nature');
			foreach ($themes as $themeToAdd)
			{
				if (!ThemePeer::doSelectByName($themeToAdd))
				{
					$theme = new Theme();
					$theme->setName($themeToAdd);
					$theme->setBaseThemeId($default2->getId());
					$theme->save();
				}
			}
		}

		$databaseManager->shutdown();
	}

    if (version_compare($version_old, '7.0.1.5', '<'))
    {
        $databaseManager = new sfDatabaseManager();
        $databaseManager->initialize();
            
        
         $themes = array(
        'black', 
        'black2', 
        'default2blue', 
        'default2purple', 
        'default2red', 
        'simple', 
        'simple2', 
        'nature',
        'default',
        'default2',
        'responsive',
        'homeelectronics',
        'giallo',
        'moderno',
        'sportivo',
        'quattro',
        'coffeestore',
        'segno',
        'longboard',
        'bagging',
        'games',
        'surfing',
        'brassiere',
        'yewelry',
        'gifts',
        'fragrance',
        'furniture',
        'argento');
        
        foreach ($themes as $themeToAdd)
        {
            $theme = ThemePeer::doSelectByName($themeToAdd);
            
            if ($theme)
            {
                $theme->setName($themeToAdd);
                $theme->setIsSystemDefault(1);
                $theme->save();
            }
        }
        

        $databaseManager->shutdown();
    }

    if (version_compare($version_old, '7.0.1.12', '<'))
    {
        $databaseManager = new sfDatabaseManager();
        $databaseManager->initialize();  
        
        $config = stConfig::getInstance('stThemeBackend');

        if ($config->get('responsive'))
        {
            $c = new Criteria();
            $c->add(ThemePeer::ACTIVE, true);
            $c->add(ThemePeer::ID, $config->get('responsive'));
            $config->set('responsive_vary', ThemePeer::doCount($c) == 0);
        }
        else
        {
            $config->set('responsive_vary', false);
        }

        $config->save(true);

        $databaseManager->shutdown();      
    }

} catch (Exception $e) {}

if (version_compare($version_old, '7.0.9.12', '<'))
{
    $config = stConfig::getInstance('stAsset');

    try {
        $databaseManager = new sfDatabaseManager();
        $databaseManager->initialize();
        $theme = ThemePeer::doSelectActive();

        if ($theme->getName() == 'responsive' || $theme->getName() == 'argentorwd')
        {
            ThemePeer::updateThemeImageConfiguration($theme);
        }
        else
        {
            $paths = array();
                  
            if ($theme->hasBaseTheme())
            {
               $paths[] = $theme->getBaseTheme()->getConfigurationPath(true);
            }

            $paths[] = $theme->getConfigurationPath(true);

            foreach ($paths as $path)
            {
                if (is_file($path))
                {
                    $params = Yaml::parse($path);

                    if (isset($params['thumbs']))
                    {
                        foreach (array('slide', 'slide_mobile') as $for)
                        {
                            if (!isset($params['thumbs'][$for])) continue;

                            $current = $config->get($for);

                            foreach ($params['thumbs'][$for] as $name => $value)
                            {
                                $current[$name] = array_merge($current[$name], $value);   
                            }

                            $config->set($for, $current);
                        }
                    }
                } 
            }
        }

        if ($theme->getVersion() < 7 && stConfig::getInstance('stSlideBannerBackend')->get('size'))
        {
            $current = $config->get('slide');

            $c = new Criteria();
            $c->add(SlideBannerPeer::BANNER_TYPE, 2, Criteria::LESS_THAN);
            $c->add(SlideBannerPeer::IS_ACTIVE, true);
           
            $width = 0;
            $height = 0;

            foreach (SlideBannerPeer::doSelect($c) as $slide)
            {
                $image = $slide->getImagePath(true);

                $size = getimagesize($image);

                if ($width < $size[0])
                {
                    $width = $size[0];
                }

                if ($height < $size[1])
                {
                    $height = $size[1];
                }
            }

            if ($width > 0)
            {
                $current['thumb']['width'] = $width;
                $current['thumb']['height'] = $height;
                $config->set('slide', $current);
            }
        }

        $config->save(true);

        $theme->getThemeConfig()->setConfigParameter('thumbs', $config->getArray());
        $theme->save();
    }   
    catch (Exception $e)
    {

    }
}

if (version_compare($version_old, '7.0.9.15', '<'))
{
    $config = stConfig::getInstance('stAsset');
    $config->save(true);
}

if (version_compare($version_old, '7.0.9.26', '<'))
{
    $themes = array(
        'default2',
        'responsive',
        'argentorwd',
        'homeelectronics',
        'giallo',
        'moderno',
        'sportivo',
        'quattro',
        'coffeestore',
        'segno',
        'longboard',
        'bagging',
        'games',
        'surfing',
        'brassiere',
        'yewelry',
        'gifts',
        'fragrance',
        'furniture',
        'argento',
        'meble');

    try 
    {
        $databaseManager = new sfDatabaseManager();
        $databaseManager->initialize();
        Propel::getConnection()->executeQuery(sprintf('UPDATE %s SET %s = 1 WHERE %s IN (\'%s\')', ThemePeer::TABLE_NAME, ThemePeer::IS_SYSTEM_DEFAULT, ThemePeer::THEME, implode('\',\'', $themes)));
    }
    catch (Exception $e)
    {

    }  
}

if (version_compare($version_old, '7.1.0.18', '<'))
{
    try 
    {
        $databaseManager = new sfDatabaseManager();
        $databaseManager->initialize();
        Propel::getConnection()->executeQuery(sprintf("ALTER TABLE `%s` DROP INDEX `%s`", ThemeContentPeer::TABLE_NAME, 'st_theme_content_content_id_unique'));
    }
    catch (Exception $e)
    {

    }  
}