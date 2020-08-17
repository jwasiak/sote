<?php
try {
	if (version_compare($version_old, '1.1.0.0', '<')) {
		$databaseManager = new sfDatabaseManager();
		$databaseManager->initialize();

		$stTranslation = new stTranslation('it');
		$stTranslation->translate();
	}

	if (version_compare($version_old, '1.1.0.8', '<')) {
		$databaseManager = new sfDatabaseManager();
		$databaseManager->initialize();

		$c = new Criteria();
		$c->add(LanguagePeer::LANGUAGE, 'it');
		$c->add(LanguagePeer::SYSTEM, 1);
		$l = LanguagePeer::doSelectOne($c);

		if (is_object($l))
		{
			$l->setCulture('pl_PL');
			$l->setName('Włoska');
			$l->save();

			$l->setCulture('en_US');
			$l->setName('Italian');
			$l->save();
		}
	}
} catch (Exception $e) {}