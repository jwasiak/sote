<?php
try {
	if (version_compare($version_old, '1.1.0.0', '<')) {
		$databaseManager = new sfDatabaseManager();
		$databaseManager->initialize();

		$stTranslation = new stTranslation('pt');
		$stTranslation->translate();
	}

	if (version_compare($version_old, '1.1.0.7', '<')) {
		$databaseManager = new sfDatabaseManager();
		$databaseManager->initialize();

		$c = new Criteria();
		$c->add(LanguagePeer::LANGUAGE, 'pt');
		$c->add(LanguagePeer::SYSTEM, 1);
		$l = LanguagePeer::doSelectOne($c);

		if (is_object($l))
		{
			$l->setCulture('pl_PL');
			$l->setName('Portugalska');
			$l->save();

			$l->setCulture('en_US');
			$l->setName('Portuguese');
			$l->save();
		}
	}
} catch (Exception $e) {}