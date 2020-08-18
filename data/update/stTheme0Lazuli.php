<?php
try {
    if (version_compare($version_old, '7.0.0.0', '<')) 
    {
        $databaseManager = new sfDatabaseManager();
        $databaseManager->initialize();

        $theme = ThemePeer::doSelectByName('lazuli');
        
        if (!$theme) {
            $responsive = ThemePeer::doSelectByName('responsive');
            $bianco = ThemePeer::doSelectByName('bianco');
            $elegante = ThemePeer::doSelectByName('elegante');
            

            if (null === $responsive) {
                $responsive = new Theme();
                $responsive->setName('responsive');
                $responsive->setVersion(7);              
                $responsive->setIsSystemDefault(true);
                $responsive->save();
            }

            if (!$bianco) 
            {
                $bianco = new Theme();
                $bianco->setName('bianco');
                $bianco->setVersion(8);              
                $bianco->setIsSystemDefault(true);
                $bianco->setBaseThemeId($responsive->getId());
                $bianco->save();
            }
            if (!$elegante) 
            {
                $elegante = new Theme();
                $elegante->setName('elegante');
                $elegante->setVersion(8);              
                $elegante->setIsSystemDefault(true);
                $elegante->setBaseThemeId($bianco->getId());
                $elegante->save();
            }
            if (is_object($elegante)) {
                $theme = new Theme();
                $theme->setName('lazuli');
                $theme->setVersion(8);              
                $theme->setIsSystemDefault(true);
                $theme->setBaseThemeId($elegante->getId());
                $theme->save();
            }
        }

        if($theme){
            $theme_id = $theme->getId();

            $theme_content = new ThemeContent();
            $theme_content->setThemeId($theme_id);
            $theme_content->setContentId('h1-homepage-part1');
            $theme_content->setCulture('pl_PL');
            $theme_content->setName('Nagłówek h1 strony głównej pogrubiony');
            $theme_content->setContent('Twój sklep internetowy.');
            $theme_content->setCulture('en_US');
            $theme_content->setName('Main page h1 bolded');
            $theme_content->setContent('Your online store.');
            $theme_content->save();

            $theme_content2 = new ThemeContent();
            $theme_content2->setThemeId($theme_id);
            $theme_content2->setContentId('h1-homepage-part2');
            $theme_content2->setCulture('pl_PL');
            $theme_content2->setName('Nagłówek h1 strony głównej');
            $theme_content2->setContent('Krótka informacja o sklepie lub ofercie');
            $theme_content2->setCulture('en_US');
            $theme_content2->setName('Main page h1');
            $theme_content2->setContent('Short information about the store or offer');
            $theme_content2->save();

            $theme_content3 = new ThemeContent();
            $theme_content3->setThemeId($theme_id);
            $theme_content3->setContentId('h2-homepage-1');
            $theme_content3->setCulture('pl_PL');
            $theme_content3->setName('Nagłówek h2 strony głównej pierwszy');
            $theme_content3->setContent('');
            $theme_content3->setCulture('en_US');
            $theme_content3->setName('Main page h2 first');
            $theme_content3->setContent('');
            $theme_content3->save();

            $theme_content4 = new ThemeContent();
            $theme_content4->setThemeId($theme_id);
            $theme_content4->setContentId('h2-homepage-1-text');
            $theme_content4->setCulture('pl_PL');
            $theme_content4->setName('Tekst przy pierwszym nagłówku h2');
            $theme_content4->setContent('');
            $theme_content4->setCulture('en_US');
            $theme_content4->setName('The text at the first h2 header');
            $theme_content4->setContent('');
            $theme_content4->save();

            $theme_content5 = new ThemeContent();
            $theme_content5->setThemeId($theme_id);
            $theme_content5->setContentId('h2-homepage-2');
            $theme_content5->setCulture('pl_PL');
            $theme_content5->setName('Nagłówek h2 strony głównej drugi');
            $theme_content5->setContent('');
            $theme_content5->setCulture('en_US');
            $theme_content5->setName('Main page h2 second');
            $theme_content5->setContent('');
            $theme_content5->save();

            $theme_content6 = new ThemeContent();
            $theme_content6->setThemeId($theme_id);
            $theme_content6->setContentId('h2-homepage-2-text');
            $theme_content6->setCulture('pl_PL');
            $theme_content6->setName('Tekst przy drugim nagłówku h2');
            $theme_content6->setContent('');
            $theme_content6->setCulture('en_US');
            $theme_content6->setName('The text at the second h2 header');
            $theme_content6->setContent('');
            $theme_content6->save();
        }

        $databaseManager->shutdown();
    }
} catch (Exception $e) {}
