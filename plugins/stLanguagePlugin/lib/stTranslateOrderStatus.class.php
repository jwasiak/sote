<?php
class stTranslateOrderStatus
{
	public static function getLangsArray()
	{
		$tmp = array();
		foreach (LanguagePeer::doSelect(new Criteria()) as $lang) $tmp[$lang->getLanguage()] = 1;
		return $tmp;
	}

	public function updateStatusI18n($step)
	{
		$databaseManager = new sfDatabaseManager();
		$databaseManager->initialize();

		$langs = sfYaml::load(sfConfig::get('sf_data_dir').DIRECTORY_SEPARATOR.'update'.DIRECTORY_SEPARATOR.'status_i18n_update.yml');

		$c = new Criteria();
		$statuses = OrderStatusPeer::doSelect($c);
		$availLangs = stTranslateOrderStatus::getLangsArray();
		foreach ($statuses as $status)
		{
			$status->setCulture('pl_PL');
			$orig = $status->getName();

			foreach ($langs[$status->getName()] as $key=>$name)
			{
				if (!isset($availLangs[$key])) continue;

				$status->setCulture($key);
				if ($orig == $status->getName()) $status->setName($name);
			}
			$status->save();
		}
	}
}