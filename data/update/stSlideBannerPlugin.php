<?php
try {
	if (version_compare($version_old, '1.2.0.2', '<='))
	{
		$databaseManager = new sfDatabaseManager();
		$databaseManager->initialize();

		if (!SlideBannerPeer::doCount(new Criteria()))
		{
			$c = new Criteria();
			$c->add(LanguagePeer::LANGUAGE, 'pl_PL');
			$stLanguage = LanguagePeer::doSelectOne($c);

			if (is_object($stLanguage))
			{
				$sb = new SlideBanner();
				$sb->setLanguageId($stLanguage->getId());
				$sb->setImage('/picture/pl_PL/banner1.jpg');
				$sb->setIsActive(true);
				$sb->save();

				$sb = new SlideBanner();
				$sb->setLanguageId($stLanguage->getId());
				$sb->setImage('/picture/pl_PL/banner2.jpg');
				$sb->setIsActive(true);
				$sb->save();

				$sb = new SlideBanner();
				$sb->setLanguageId($stLanguage->getId());
				$sb->setImage('/picture/pl_PL/banner3.jpg');
				$sb->setIsActive(true);
				$sb->save();
			}

			$c = new Criteria();
			$c->add(LanguagePeer::LANGUAGE, 'en_US');
			$stLanguage = LanguagePeer::doSelectOne($c);

			if (is_object($stLanguage))
			{
				$sb = new SlideBanner();
				$sb->setLanguageId($stLanguage->getId());
				$sb->setImage('/picture/en_US/banner1.jpg');
				$sb->setIsActive(true);
				$sb->save();

				$sb = new SlideBanner();
				$sb->setLanguageId($stLanguage->getId());
				$sb->setImage('/picture/en_US/banner2.jpg');
				$sb->setIsActive(true);
				$sb->save();

				$sb = new SlideBanner();
				$sb->setLanguageId($stLanguage->getId());
				$sb->setImage('/picture/en_US/banner3.jpg');
				$sb->setIsActive(true);
				$sb->save();
			}
		}

		$databaseManager->shutdown();
	}
    
    if (version_compare($version_old, '2.0.0.10', '<='))
    {
        $databaseManager = new sfDatabaseManager();
        $databaseManager->initialize();

        $c = new Criteria();
        $c->addDescendingOrderByColumn('CREATED_AT');
        $banners = SlideBannerPeer::doSelect($c);
       
        if($banners)
        {
           $i=1;
           foreach($banners as $banner){
               $banner->setRank($i);
               $banner->save();
               $i++;
           }
        }

        $databaseManager->shutdown();
    }
    
    if (version_compare($version_old, '7.1.2.2', '<='))
    {
        $config = stConfig::getInstance(sfContext::getInstance(), 'stSlideBannerBackend');
        $config->set('group_field_on',1);        
        $config->save(true);
    }

    if (version_compare($version_old, '7.2.0.10', '<='))
    {
        $config = stConfig::getInstance('stSlideBannerBackend');
        $config->set('banner_version' , 1);        
        $config->save(true);
    }

} catch (Exception $e) {}