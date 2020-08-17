<?php
class stSetupDefaultData
{
    protected $message;

    public function getTitle()
    {
        return sfContext::getInstance()->getI18N()->__('Zapisywanie domyślnych ustawień:', null, 'stSetup');
    }

    public static function getSteps()
    {
        return 11;
    }

    public function step($step)
    {
        $task = null;

        $settingsFile = sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'db'.DIRECTORY_SEPARATOR.'.settings.reg';
        $settings = sfYaml::load($settingsFile);
        if ($settings['language'] === false) $settings['language'] = 'no';

        switch($step) {
            case 2:
                sfLoader::loadPluginConfig();
                if (stInstallMethod::getWebInstall()) {
                    if (!$this->loadSqlFixtures($settings['fixtures_name'])) 
                        $task = 'installer-load-data '.SF_ENVIRONMENT;
                } else { 
                    if ($settings['load_fixtures']) $task = 'st-propel-load-default-data '.$settings['fixtures_name'];
                    else $task = 'installer-load-data '.SF_ENVIRONMENT;
                }
                break;
            case 3:
                $task = 'theme-set-active '.$settings['theme'];
                break;
            case 4:
                $this->changeCurrency($settings['currency']);
                break;
            case 5:
                $this->changeCountry($settings['country']);
                break;
            case 6:
                $this->changePanelLanguage($settings['language_panel']);
                break;
            case 7:
                $this->changeLanguage($settings['language']);
                break;
            case 8:
                $this->changeTax($settings['country']);
                break;
            case 9:
                $this->postInstall();
                break;
            case 10:
                $task = 'cc';
                break;
            default:
                sleep(1);
                break;
        }

        if (!is_null($task))
        {
            $pakeweb = new stPakeWeb();
            if (!$pakeweb->run($task)) throw new Exception($pakeweb->error);
        }

        return $step+1;
    }

    public function close()
    {
        sfLoader::loadHelpers('stProgressBar');

        $this->message = progress_bar('stCleanInstallerDownload', 'stCleanInstallerDownload', 'step', stCleanInstallerDownload::getSteps());
        $this->message .= progress_bar('stCleanInstallerSrc', 'stCleanInstallerSrc', 'step', stCleanInstallerSrc::getSteps());
    }

    public function getMessage()
    {
        return $this->message;
    }

    protected function changeCurrency($currency)
    {
        $databaseManager = new sfDatabaseManager();
        $databaseManager->initialize();

        $c = new Criteria();
        $c->add(CurrencyPeer::SHORTCUT, $currency);
        $currency = CurrencyPeer::doSelectOne($c);

        if (is_object($currency))
        {
            $config = stConfig::getInstance(sfContext::getInstance(), 'stCurrencyPlugin');
            $config->set('default_currency', $currency->getShortcut());
            $config->save(true);

            $exchange = $currency->getExchange();

            $currency->setActive(1);
            $currency->setMain(1);
            $currency->setExchange(1);
            $currency->save();
        }

        $c = new Criteria();
        $criterion = $c->getNewCriterion(CurrencyPeer::MAIN, 0);
        $criterion1 = $c->getNewCriterion(CurrencyPeer::MAIN, null, Criteria::ISNULL);
        $criterion->addOr($criterion1); 
        $c->add($criterion); 
        $currencies = CurrencyPeer::doSelect($c);

        foreach ($currencies as $currency) {
            $currency->setExchange($currency->getExchange()/$exchange);
            $currency->save();
        }

        $databaseManager->shutdown();
    }

    protected function changeCountry($country)
    {
        $databaseManager = new sfDatabaseManager();
        $databaseManager->initialize();

        $c = new Criteria();
        $c->add(CountriesPeer::ISO_A3, $country);
        $country = CountriesPeer::doSelectOne($c);

        if (is_object($country))
        {
            $country->setIsDefault(1);
            $country->save();
        }

        $connection = Propel::getConnection();
        $statementTable = $connection->prepareStatement('TRUNCATE `st_countries_area`');
        $resultsetTable = $statementTable->executeQuery(ResultSet::FETCHMODE_NUM);
        $statementTable = $connection->prepareStatement('TRUNCATE `st_countries_area_has_countries`');
        $resultsetTable = $statementTable->executeQuery(ResultSet::FETCHMODE_NUM);

        $area = new CountriesArea();
        $area->setName($country->getName());
        $area->setIsActive(1);
        $area->save();

        $areaHasCountry = new CountriesAreaHasCountries();
        $areaHasCountry->setCountriesId($country->getId());
        $areaHasCountry->setCountriesAreaId($area->getId());
        $areaHasCountry->save();

        $databaseManager->shutdown();
    }

    protected function changePanelLanguage($panelLanguage)
    {
        $databaseManager = new sfDatabaseManager();
        $databaseManager->initialize();

        $c = new Criteria();
        $c->add(LanguagePeer::LANGUAGE, $panelLanguage);
        $language = LanguagePeer::doSelectOne($c);

        if (is_object($language))
        {
            $language->setIsDefaultPanel(true);
            $language->save();

            $config = stConfig::getInstance(sfContext::getInstance(), 'stLanguagePlugin');
            $config->set('admin_language', $language->getOriginalLanguage());
            $config->save(true);
        }

        if (stSoteshopVersion::getVersion() == stSoteshopVersion::ST_SOTESHOP_VERSION_INTERNATIONAL) {
            $c = new Criteria();
            $c->add(LanguagePeer::LANGUAGE, 'pl_PL');
            $language = LanguagePeer::doSelectOne($c);
            
            if(is_object($language)) {
                $language->setIsTranslatePanel(false);
                $language->save();
            }
        }

        $databaseManager->shutdown();
    }

    protected function changeLanguage($language)
    {
        $databaseManager = new sfDatabaseManager();
        $databaseManager->initialize();

        $c = new Criteria();
        $c->add(LanguagePeer::LANGUAGE, $language);
        $language = LanguagePeer::doSelectOne($c);
        
        if (is_object($language))
        {
            $connection = Propel::getConnection();
                
            $statementTable = $connection->prepareStatement('UPDATE st_language SET `active` = 0');
            $resultsetTable = $statementTable->executeQuery(ResultSet::FETCHMODE_NUM);
                
            $language->setIsDefault(true);
            $language->setActive(true);
            $language->save();

            $culture = $language->getOriginalLanguage();
            
            $config = stConfig::getInstance(sfContext::getInstance(), 'stLanguagePlugin');
            $config->set('default_opt_language', $culture);
            $config->save(true);
            
            $statement = $connection->prepareStatement('SHOW TABLES LIKE "%_i18n"');
            $resultset = $statement->executeQuery(ResultSet::FETCHMODE_NUM);
            while ($resultset->next())
            {
                $tableNameI18n = $resultset->getString(1);

                $statementTable = $connection->prepareStatement('SHOW COLUMNS FROM '.$tableNameI18n.' WHERE Field <> "id" AND Field <> "culture"');
                $resultsetTable = $statementTable->executeQuery(ResultSet::FETCHMODE_NUM);
                $fields = array();

                while ($resultsetTable->next()) { $fields[] = $resultsetTable->getString(1); }

                $fieldList = implode(', ', $fields);
                $statementInsert = $connection->prepareStatement('Insert into '.$tableNameI18n.' (id, culture, '.$fieldList.') (Select id, "'.$culture.'", '.$fieldList.' from '.$tableNameI18n.' as s where culture = "en_US") ON DUPLICATE KEY UPDATE '.$tableNameI18n.'.id = '.$tableNameI18n.'.id');
                $statementInsert->executeQuery(ResultSet::FETCHMODE_NUM);

                $tableName = substr($tableNameI18n, 0, -5);

                $query = 'UPDATE '.$tableName.', '.$tableNameI18n.' SET ';
                
                $sT = $connection->prepareStatement('SHOW COLUMNS FROM '.$tableName.' WHERE Field <> "id"');
                $rT = $sT->executeQuery(ResultSet::FETCHMODE_NUM);
                $f = array();
                while ($rT->next()) $f[] = $rT->getString(1);

                $updateFields = array();
                foreach($fields as $field)
                    if (in_array('opt_'.$field, $f))
                        $updateFields[] = $tableName.'.opt_'.$field.' = '.$tableNameI18n.'.'.$field;

                $updateFieldsList = implode(', ', $updateFields);

                if ($updateFieldsList)
                {
                    $query.= $updateFieldsList.' WHERE '.$tableName.'.id = '.$tableNameI18n.'.id AND '.$tableNameI18n.'.culture = "'.$culture.'"';

                    $statementUpdate = $connection->prepareStatement($query);
                    $statementUpdate->executeQuery(ResultSet::FETCHMODE_NUM);
                }
            }
        }

        $databaseManager->shutdown();
    }

    public function changeTax($country) {
        if ($country == 'POL') return true;

        $taxFile = sfConfig::get('sf_plugins_dir').DIRECTORY_SEPARATOR.'stTaxPlugin'.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'countries_tax_list.yml';
        if(file_exists($taxFile)) {

            $databaseManager = new sfDatabaseManager();
            $databaseManager->initialize();

            $connection = Propel::getConnection();
            $statementTable = $connection->prepareStatement('TRUNCATE `st_tax`');
            $resultsetTable = $statementTable->executeQuery(ResultSet::FETCHMODE_NUM);

            $taxes = sfYaml::load($taxFile);

            if(!isset($taxes[$country])) $country = 'default';

            foreach($taxes[$country] as $name => $params) {
                $tax = new Tax();
                $tax->setVat($params['vat']);
                $tax->setVatName($params['vat_name']);
                if ($name == 'Tax_1') $tax->setIsDefault(true);
                $tax->save();
            }

            $statementTable = $connection->prepareStatement('UPDATE st_product SET `tax_id` = 1, `opt_vat` = '.$taxes[$country]['Tax_1']['vat'].', `price` = (`opt_price_brutto`/(1+('.$taxes[$country]['Tax_1']['vat'].'/100)))');
            $resultsetTable = $statementTable->executeQuery(ResultSet::FETCHMODE_NUM);

            $statementTable = $connection->prepareStatement('UPDATE st_delivery SET `tax_id` = 1');
            $resultsetTable = $statementTable->executeQuery(ResultSet::FETCHMODE_NUM);

            unset($taxes);

            $databaseManager->shutdown();
        }
    }
    
    public function postInstall() {
        $files = glob(sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'install-post'.DIRECTORY_SEPARATOR.'*');
        foreach($files as $file) {
            file_put_contents(sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'log'.DIRECTORY_SEPARATOR.'post-install.log', 'Load script file: '.basename($file)."\n", FILE_APPEND);
            include_once($file);
        }
    }

    public function loadSqlFixtures($fixturesName) {

        $sqlFile = sfConfig::get('sf_root_dir').'/install/sql/'.$fixturesName.'.sql';

        if (file_exists($sqlFile)) {

            $databaseManager = new sfDatabaseManager();
            $databaseManager->initialize();
            $con = Propel::getConnection();

            $queries = preg_split('/\n/', file_get_contents($sqlFile));
            $queriesList = array();

            foreach ($queries as $query) {
                if (empty($query)) continue;

                if (preg_match('/^\/\*\!/', $query)) {
                    preg_match('/^\/\*\![0-9]+\s{1}(.*)\*\/\;$/', $query, $matches);
                    if (isset($matches[1]) && !empty($matches[1])) {
                        $query = trim($matches[1]).';';
                    }
                }

                $con->executeQuery($query);
            }

            return true;
        }

        return false;
    }
}
