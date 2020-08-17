<?php
class stTranslateCountries
{
	public function __construct() {}

	public static function postInstall(sfEvent $event)
	{
		$databaseManager = new sfDatabaseManager();
		$databaseManager->initialize();

		sfLoader::loadHelpers('stProgressBar');
		sfLoader::loadHelpers('Partial');
		$event->getSubject()->msg .= progress_bar('stCountries_optimize', 'stTranslateCountries', 'updateI18n', CountriesPeer::doCount(new Criteria()));
	}

	public function updateI18n($step)
	{
		$databaseManager = new sfDatabaseManager();
		$databaseManager->initialize();
		
		sfLoader::loadPluginConfig();

		$langs = sfYaml::load(sfConfig::get('sf_data_dir').DIRECTORY_SEPARATOR.'update'.DIRECTORY_SEPARATOR.'countries_i18n_update.yml');
		$c = new Criteria();
		$c->setOffset($step);
		$c->setLimit(10);
		$countries = CountriesPeer::doSelect($c);
		$availLangs = stTranslateCountries::getLangsArray();
		foreach ($countries as $country)
		{
			$country->setCulture('pl_PL');
			$orig = $country->getName();

			foreach ($langs[$country->getName()] as $key=>$name)
			{
				if (!isset($availLangs[$key])) continue;

				$country->setCulture($key);
				if ($orig == $country->getName()) $country->setName($name);
			}
			$country->save();
		}
		return ($step+count($countries));
	}

	public function getTitle()
	{
		return sfContext::getInstance()->getI18n()->__('Aktualizacja nazw krajów', array(), 'stLanguagePlugin');
	}

	public static function getLangsArray()
	{
		$tmp = array();
		foreach (LanguagePeer::doSelect(new Criteria()) as $lang) $tmp[$lang->getLanguage()] = 1;
		return $tmp;
	}
}