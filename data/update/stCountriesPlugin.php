<?php

if (version_compare($version_old, '1.0.2.12', '<'))
{
    /**
     * Inicjalizacja bazy danych
     */
    $databaseManager = new sfDatabaseManager();
    $databaseManager->initialize();
        
    /*
     * Poprawa kodu Austrii
     */
    $c = new Criteria();
    $c->add(CountriesPeer::OPT_NAME, "Austria");
    $fix_country = CountriesPeer::doSelectOne($c);
    if ($fix_country)
    {
        $fix_country->setIsoA2('AT');
        $fix_country->setIsoA3('AUT');
        $fix_country->save();
    }

    /**
     * Załaduj kraje
     */
    $fileymlRoot = sfConfig::get('sf_data_dir'). DIRECTORY_SEPARATOR. 'fixtures' . DIRECTORY_SEPARATOR .'stCountriesDefine.yml';
    $yml = sfYaml::load($fileymlRoot);
    $countries = $yml['Countries'];
    $countriesI18n = $yml['CountriesI18n'];

    foreach ($countries as $id=>$country)
     {
        $iso_a2 = $country['iso_a2'];
        $iso_a3 = $country['iso_a3'];
        $number = $country['number'];
        $continent = $country['continent'];
        $name = $country['name'];

        $c = new Criteria();
        $c->add(CountriesPeer::ISO_A2, $iso_a2);
        if (CountriesPeer::doCount($c) == 0)
        {
            $country = new Countries();
            $country->setCulture('pl_PL');
            $country->setIsoA2($iso_a2);
            $country->setIsoA3($iso_a3);
            $country->setNumber($number);
            $country->setContinent($continent);
            $country->setName($name);
            $country->setIsActive(1);
            $country->save();

            foreach ($countriesI18n as $idI18n=>$countryI18n)
            {
                $nameI18n = $countryI18n['name'];
                if ($id == $countryI18n['id'])
                {
                    $country->setCulture('en_US');
                    $country->setName($nameI18n);
                    $country->save();
                }
             }
         }
      }

}
