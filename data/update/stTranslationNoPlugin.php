<?php
if (version_compare($version_old, '2.0.0.0', '<')) {
    try {
		$databaseManager = new sfDatabaseManager();
		$databaseManager->initialize();
		
		/**
		 * Loading countries  
		 */
		$fixturesPath = sfConfig::get('sf_data_dir').DIRECTORY_SEPARATOR.'fixtures'.DIRECTORY_SEPARATOR;
		
		$ymlContent = sfYaml::load($fixturesPath.'stCountriesDefine.yml');
		$countries = $ymlContent['Countries'];
		unset($ymlContent);
		
		$ymlContent = sfYaml::load($fixturesPath.'stTranslationNoPlugin.data.yml');
		$noCountries = $ymlContent['CountriesI18n'];
		unset($ymlContent);
		
		foreach ($noCountries as $k => $v) {
		    $c = new Criteria();
		    $c->add(CountriesPeer::ISO_A2, $countries[$v['id']]['iso_a2']);
		    if ($country = CountriesPeer::doSelectOne($c)) {
		        $name = $country->getName();
		        $country->setCulture('no');
		        if ($country->getName() == $name) {
		            $country->setName($v['name']);
		            $country->save();
		        }
		    }
		}
    } catch (Exception $e) {}
}