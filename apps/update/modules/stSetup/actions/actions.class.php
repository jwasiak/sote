<?php
/**
 * SOTESHOP/stUpdate
 *
 * Ten plik należy do aplikacji stUpdate opartej na licencji (Open License SOTE) Otwarta Licencja SOTE.
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stUpdate
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: actions.class.php 17203 2012-02-22 12:10:21Z michal $
 * @author      Piotr Halas <piotr.halas@sote.pl>
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stSetupActions
 *
 * @package     stUpdate
 * @subpackage  actions
 */
class stSetupActions extends sfActions
{
    /**
     * Wyświetlanie informacji ogólnych
     */
    public function executeIndex()
    {
        $request = $this->getRequest();
        if ($request->hasParameter('language') && $request->getParameter('language') == 'pl') $this->getUser()->setCulture('pl_PL');
        if ($request->hasParameter('language') && $request->getParameter('language') == 'en') $this->getUser()->setCulture('en_US');

        $pakeweb = new stPakeWeb();
        $pakeweb->run('pear-update-config');

        $this->error = true;

        $this->license = $request->getParameter('license', null);

        $licenseChecked = false;

        if ($request->getMethod() == sfRequest::POST) {
            if ($request->hasParameter('license') && !empty($this->license)) {
                $stLicense = new stLicense($this->license);
                if ($stLicense->check()) {
                    $licenseChecked = true;
                } else {
                    $this->errorMsg = 'Podana wartość jest nieprawidłowa. Proszę podać numer licencji.';
                    return sfView::SUCCESS;
                }
            } else {
                $this->errorMsg = 'Proszę podać numer licencji.';
                return sfView::SUCCESS;
            }

            if ($licenseChecked) {
                if (stInstallMethod::getWebInstall()) {
                    $upgradeServiceTime = stCommunication::getUpgradeExpirationDate(stLicenseExt::getShopIdByLicence($this->license));

                    $packages = stPear::getInstalledPackages();
                    if(isset($packages['soteshop_base'])) {
                        $time = stPear::getReleaseDate('soteshop_base', $packages['soteshop_base']);
                    }

                    if ($time === FALSE || $upgradeServiceTime === FALSE || $time > $upgradeServiceTime) {
                        $this->errorMsg = 'Nie można zainstalować sklepu. Błędna wersja instalatora.';
                        return sfView::SUCCESS;
                    }
                }

                $this->getUser()->setAttribute('licenseType', $stLicense->getType(), 'soteshop/stSetup');
                $this->getUser()->setAttribute('shopId', stLicenseExt::getShopIdByLicence($this->license), 'soteshop/stSetup');

                $file = sfConfig::get('sf_root_dir').'/install/db/.license.reg';
                if (file_exists($file)) 
                    unlink($file);
                file_put_contents($file, $this->license);

                $stLicense->startInSote();
                $this->redirect('stSetup/license');
            }
        }

        $this->error = false;
    }

    /**
     * Wyświetlanie licencji
     */
    public function executeLicense()
    {
        switch($this->getUser()->getAttribute('licenseType', null, 'soteshop/stSetup'))
        {
            case stLicense::LICENSE_TYPE_COMMERCIAL:
                $this->partial = 'license_commercial';
                break;
            case stLicense::LICENSE_TYPE_OPEN:
                $this->partial = 'license_open';
                break;
            default:
                $this->partial = 'license_commercial';
            break;
        }

        if ($this->getUser()->getCulture() == 'en_US') $this->partial.= '_en';

        $installCustomPath = sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'install_custom.yml';
        if (file_exists($installCustomPath)){
            $installCustom = sfYaml::load($installCustomPath);
            if (isset($installCustom['package']) && $installCustom['package'] == 'soteshop_international') $this->partial = 'license_osl';
        }

        $this->notAccepted = false;

        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            if ($this->getRequestParameter('accept')) $this->redirect('stSetup/require');
            $this->notAccepted = true;
        }
    }

    /**
     * Wyświetlanie wymagań
     */
    public function executeRequire()
    {
        $this->tests = new stSetupRequirements();
        $this->testsPassed = $this->tests->testAll();
        $this->testsStatus = $this->tests->getTest();
        $this->hasWarning = false;
    }

    /**
     * Wyświetlanie konfiguracji bazy danych
     */
    public function executeDatabase()
    {
        $this->dbUsername = $this->getRequestParameter('username');
        $this->dbPassword = $this->getRequestParameter('password');
        $this->dbHost = $this->getRequestParameter('host');
        $this->dbDatabase = $this->getRequestParameter('database');

        $this->dbError = true;
        $this->dbErrorMsg = '';

        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $this->dbHost = preg_replace(array('/^[A-Za-z]{3,5}:\/\//', '/\/[A-Za-z0-9\-:\/]{1,}$/', '/\/$/'), '', $this->dbHost);
            
            if (preg_match('/[@#\/]/', $this->dbPassword)) {
                $this->dbErrorMsg = 'Hasło nie może zawierać znaków #, @, /.';
                return sfView::SUCCESS;
            }

            if (preg_match('/:[0-9]{2,6}$/', $this->dbHost)) {
                list($host, $port) = explode(':', $this->dbHost);
            }

            try {
                if(isset($host) && isset($port))
                    $pdo = new PDO('mysql:dbname='.$this->dbDatabase.';host='.$host.';port='.$port, $this->dbUsername, $this->dbPassword);
                else 
                    $pdo = new PDO('mysql:dbname='.$this->dbDatabase.';host='.$this->dbHost, $this->dbUsername, $this->dbPassword);

                $result = $pdo->query('SHOW VARIABLES LIKE "collation_database";', PDO::FETCH_BOTH)->fetch();
                if (!isset($result['Value']) || $result['Value'] != 'utf8_unicode_ci') {
                    $this->dbErrorMsg = 'Złe kodowanie bazy danych, proszę zmienić na utf8_unicode_ci.';
                    return sfView::SUCCESS;
                }

                $result = $pdo->query('SHOW TABLES;')->rowCount();
                if ($result) {
                    $this->dbErrorMsg = 'Baza danych nie jest pusta.';
                    return sfView::SUCCESS;
                }
            } catch (Exception $e) {
                $this->dbErrorMsg = 'Nie można połączyć się z bazą danych, sprawdz dane i spróbuj ponownie.';
                return sfView::SUCCESS;
            }

            $setupFile = sfConfig::get('sf_config_dir').DIRECTORY_SEPARATOR.'__st_setup.yml';

            $database = array('database' => array(
                                                'username' => $this->dbUsername,
                                                'password' => $this->dbPassword,
                                                'host' => $this->dbHost,
                                                'database' => $this->dbDatabase
                        ));
            if (!file_put_contents($setupFile, sfYaml::dump($database))) {
                $this->dbErrorMsg = 'Nie mogę zapisać pliku konfiguracyjnego.';
                return sfView::SUCCESS;
            }

            $this->redirect('stSetup/download');
        }
        $this->dbError = false;
    }

    /**
     * Wyświetlanie ściągania pakietów
     */
    public function executeDownload() {

        if (stInstallMethod::getWebInstall())
            return $this->forward('stSetup','dbdata');
        else {
            $dir = sfConfig::get('sf_root_dir').'/install/config/';
            
            $install = sfYaml::load($dir.'install.yml');

            if (file_exists($dir.'install_custom.yml'))
                $install = sfYaml::load($dir.'install_custom.yml');

            stPackageDownloader::setPackages(stPear::getDependencies(array($install['package'] => stPear::getLatestVersion($install['package']))));
        }
    }

    public function executeDbdata()
    {
        // new server update config
        $pakeweb = new stPakeWeb();
        $pakeweb->run('cc');
        $server = new stNewServer();
        $server->update();

        // copy index.php from backup
        $from=sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'tmp'.DIRECTORY_SEPARATOR.'index_frontend.php';
        $to=sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'web'.DIRECTORY_SEPARATOR.'index.php';
        if (! copy($from,$to))
        {
            throw new Exception ("Unable copy $from->$to");
        }
    }

    /**
     * Wyświetlanie instalacji
    */
    public function executeInstall() {
    }

    /**
     * Wyświetlanie konfiguracji i optymalizacji
     */
    public function executeConfigure() {
        if (!file_exists(sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'db'.DIRECTORY_SEPARATOR.'.settings.reg')) return $this->forward('stSetup', 'settings');

        // włącz fastcache dla nowych instalacji
        $fastCacheEnabled = SF_ROOT_DIR.DIRECTORY_SEPARATOR.'fastcache'.DIRECTORY_SEPARATOR.'db'.DIRECTORY_SEPARATOR.'fast_cache_enabled';
        if (!file_exists($fastCacheEnabled)) touch($fastCacheEnabled);
    }

    /**
     * Wyświetlenie informacji końcowych
     */
    public function executeFinish() {
        $host = $this->getRequest()->getHost();

        $this->frontend = 'http://'.$host;
        $this->backend = 'http://'.$host.'/backend.php';
        $this->update = 'http://'.$host.'/update.php';

        $this->images = array('frontend' => 'finish_shop.png', 'backend' => 'finish_backend.png');

        $settingsRegFile = sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'db'.DIRECTORY_SEPARATOR.'.settings.reg';

        if (file_exists($settingsRegFile)) {
            $settingsReg = sfYaml::load($settingsRegFile);
            foreach ($this->images as $app => $filename) {
                if (file_exists(sfConfig::get('sf_web_dir').'/images/update/layout/'.preg_replace('/finish/', $settingsReg['theme'], $filename))) {
                    $this->images[$app] = preg_replace('/finish/', $settingsReg['theme'], $filename);
                }
            }
        }
        
        $progressPath = sfConfig::get('sf_plugins_dir').'/stProgressBarPlugin/modules/stProgressBar/config';
        if (!file_exists($progressPath)) mkdir($progressPath);
        
        $data = array();
        $data['all']['is_secure'] = 'on';
        foreach (array(sfConfig::get('sf_app_dir').'/modules/stSetup/config/security.yml', 
                       $progressPath.'/security.yml') 
                 as $file) {
            file_put_contents($file, sfYaml::dump($data));
        }

        $yaml = new sfYamlParser();
        $packageInfo = $yaml->parse(file_get_contents(sfConfig::get('sf_root_dir').'/packages/soteshop/package.yml'));
        
        $config = stConfig::getInstance('stRegister');
        $config->set('install_version', $packageInfo['package']['version']);
        $config->save();

        $pakeweb = new stPakeWeb();
        if (!$pakeweb->run('cc')) throw new Exception($pakeweb->error);
    }

    /**
     * Wyświetlenie rekonfiguracji bazy danych
     */
    public function executeReconfigure()
    {
        $checkRequirements = new stCheckRequirements();
        
        if (!$checkRequirements->testAll())
        {
            return $this->redirect('stInstallerWeb/requirements');
        }  

        $pakeweb = new stPakeWeb();
        $pakeweb->run('pear-update-config');

        $this->dbUsername = $this->getRequestParameter('username');
        $this->dbPassword = $this->getRequestParameter('password');
        $this->dbHost = $this->getRequestParameter('host');
        $this->dbDatabase = $this->getRequestParameter('database');

        $this->newServer = $this->getRequestParameter('newServer', false);

        $stRegisterConfig = stConfig::getInstance($this->getContext(), 'stRegister');
        $this->license = $stRegisterConfig->get('license');
        $i18n = $this->getContext()->getI18N();

        $this->dbError = true;
        $this->dbErrorMsg = '';

        if ($this->getRequest()->getMethod() == sfRequest::POST) {
            
            $this->dbHost = preg_replace(array('/^[A-Za-z]{3,5}:\/\//', '/\/[A-Za-z0-9\-:\/]{1,}$/', '/\/$/'), '', $this->dbHost);
            
            if (preg_match('/[@#\/]/', $this->dbPassword)) {
                $this->dbErrorMsg = 'Hasło nie może zawierać znaków #, @, /.';
                return sfView::SUCCESS;
            }

            $con = mysql_connect($this->dbHost,$this->dbUsername, $this->dbPassword);
            if ($con && mysql_select_db($this->dbDatabase,$con)) {
                
                $res = mysql_query('SHOW VARIABLES LIKE "collation_database"', $con);
                $data = mysql_fetch_array($res);
                
                if ($data[1]!="utf8_unicode_ci") {
                    mysql_free_result($res);
                    $this->dbErrorMsg = 'Złe kodowanie bazy danych, proszę zmienić na utf8_unicode_ci.';
                    return sfView::SUCCESS;
                }

                $setupFile = sfConfig::get('sf_config_dir').DIRECTORY_SEPARATOR.'__st_setup.yml';

                $database = array('database'=>array(
                       'username'=>$this->dbUsername,
                       'password'=>$this->dbPassword,
                       'host'=>$this->dbHost,
                       'database'=>$this->dbDatabase
                ));
                if (!file_put_contents($setupFile,sfYaml::dump($database))) {
                    $this->dbErrorMsg = 'Nie mogę zapisać pliku konfiguracyjnego.';
                    return sfView::SUCCESS;
                }

                if ($this->newServer)
                {
                    $this->license = $this->getRequest()->getParameter('license');

                    if(!$this->license)
                    {
                        $this->dbErrorMsg = $i18n->__('Proszę uzupełnić pole "Numer licencji".');
                        return sfView::SUCCESS;
                    }

                    if (strlen($this->license) != 29)
                    {
                        $this->dbErrorMsg = $i18n->__('Proszę sprawdzić czy numer licencji oraz jego format są poprawne.<br/>Numer licencji powinien zawierać 29 znaków w formacie xxxx-xxxx-xxxx-xxxx-xxxx-xxxx.');
                        return sfView::SUCCESS;
                    }

                    $stLicense = new stLicense($this->license);

                    if (!$stLicense->checkInSote())
                    {
                        $this->dbErrorMsg = $i18n->__('Wystąpił problem z weryfikacją licencji. Skontaktuj się z office@sote.pl');
                        return sfView::SUCCESS;
                    }

                    $stRegisterConfig->set('license', trim($this->license));
                    $stRegisterConfig->save();

                    $stLicense->activateInSote();
                }

                $pakeweb->run('setup-update');
                $pakeweb->run('cc');
                return $this->forward('stSetup', 'reconfigureFinish');

            } else {
                $this->dbErrorMsg = 'Nie można połączyć się z bazą danych, sprawdz dane i spróbuj ponownie.';
                return sfView::SUCCESS;
            }
        }
        $this->dbError = false;
    }

    /**
     * Wyświetlenie podsumowania rekonfiguracji bazy danych
     */
    public function executeReconfigureFinish()
    {
        $this->dbUsername = $this->getRequestParameter('username');
        $this->dbPassword = $this->getRequestParameter('password');
        $this->dbHost = $this->getRequestParameter('host');
        $this->dbDatabase = $this->getRequestParameter('database');
    }

    public function executeSettings()
    {
        /**
         * Themes
         */
        $themeFiles = glob(sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'packages'.DIRECTORY_SEPARATOR.'*'.DIRECTORY_SEPARATOR.'theme.yml');

        $licenseType = $this->getUser()->getAttribute('licenseType', stLicense::LICENSE_TYPE_COMMERCIAL, 'soteshop/stSetup');

        $shopId = $this->getUser()->getAttribute('shopId', null, 'soteshop/stSetup');
        if (!$shopId)
            $shopId = stLicenseExt::getShopIdByLicence(file_get_contents(sfConfig::get('sf_root_dir').'/install/db/.license.reg'));

        $this->themes = array();
        $this->defaultTheme = 'argento';

        foreach($themeFiles as $themeFile)
        {
            $themeYaml = sfYaml::load($themeFile);

            if (($licenseType == stLicense::LICENSE_TYPE_COMMERCIAL || ($licenseType == stLicense::LICENSE_TYPE_OPEN && $themeYaml['theme']['type'] == 'open')) && isset($themeYaml['theme']['install']) && $themeYaml['theme']['install'] == true) {
                $this->themes[$themeYaml['theme']['package']] = array('name' => $themeYaml['theme']['name'], 'fixtures' => $themeYaml['theme']['fixtures'], 'priority' => isset($themeYaml['theme']['priority']) ? $themeYaml['theme']['priority'] : 1000);
                if (isset($themeYaml['theme']['version']) && $themeYaml['theme']['version'] == 7 && !stCommunication::getIsSeven($shopId)) {
                    unset($this->themes[$themeYaml['theme']['package']]);
                    continue;
                }

                // if (isset($themeYaml['theme']['default']) && $themeYaml['theme']['default'] == true) $this->defaultTheme = $themeYaml['theme']['name'];
            }
            unset($themeYaml);
        }

        $this->themes;

        uasort($this->themes, function($t1, $t2) {
            if ($t1['priority'] == $t2['priority'])
            {
                return 0;
            }

            return $t1['priority'] < $t2['priority'] ? -1 : 1;
        });

        $currentTheme = current($this->themes);

        $this->defaultTheme = $currentTheme['name'];

        /**
         * Currency
         */
        $currencies = sfYaml::load(sfConfig::get('sf_plugins_dir').DIRECTORY_SEPARATOR.'stCurrencyPlugin'.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'fixtures'.DIRECTORY_SEPARATOR.'stCurrencyPlugin.yml');
        unset($currencies['CurrencyStandard']);

        if ($this->getUser()->getCulture() == 'pl_PL') $this->defaultCurrency = 'PLN';
        else $this->defaultCurrency = 'USD';

        $this->currency = array();
        foreach ($currencies['Currency'] as $id => $c)
        {
            $this->currency[$c['shortcut']] = $c['name'];
            if ($this->getUser()->getCulture() != 'pl_PL')
            {
                foreach($currencies['CurrencyI18n'] as $cI18n)
                {
                    if ($id == $cI18n['id'])
                    {
                        $this->currency[$c['shortcut']] = $cI18n['name'];
                        break;
                    }

                }
            }
        }
        unset($currencies);
        asort($this->currency);

        /**
         * Country
         */
        $countries = sfYaml::load(sfConfig::get('sf_data_dir').DIRECTORY_SEPARATOR.'fixtures'.DIRECTORY_SEPARATOR.'stCountriesDefine.yml');

        if ($this->getUser()->getCulture() == 'pl_PL') $this->defaultCountry = 'POL';
        else $this->defaultCountry = 'USA';

        $this->countries = array();
        foreach ($countries['Countries'] as $id => $c)
        {
            $this->countries[$c['iso_a3']] = $c['name'];
            if ($this->getUser()->getCulture() != 'pl_PL')
            {
                foreach($countries['CountriesI18n'] as $cI18n)
                {
                    if ($id == $cI18n['id'])
                    {
                        $this->countries[$c['iso_a3']] = $cI18n['name'];
                        break;
                    }

                }
            }
        }
        unset($countries);
        asort($this->countries);

        /**
         * Languages
         */
        $languages = sfYaml::load(sfConfig::get('sf_data_dir').DIRECTORY_SEPARATOR.'fixtures'.DIRECTORY_SEPARATOR.'stLanguagePlugin.yml');
        $translationFiles = glob(sfConfig::get('sf_data_dir').DIRECTORY_SEPARATOR.'fixtures'.DIRECTORY_SEPARATOR.'stTranslation*Plugin.yml');

        foreach($translationFiles as $translationFile)
        {
            $tmp = sfYaml::load($translationFile);
            $languages = array_merge_recursive($languages, $tmp);
            unset($tmp);
        }

        $this->languagePanel = array();
        $this->language = array();
        foreach ($languages['Language'] as $id => $l)
        {
            if ($this->getUser()->getCulture() != 'pl_PL')
            {
                foreach($languages['LanguageI18n'] as $lI18n)
                {
                    if ($id == $lI18n['id'])
                    {
                        $l['name'] = $lI18n['name'];
                        break;
                    }
                }
            }

            $this->language[$l['language']] = $l['name'];
            if (isset($l['is_translate_panel']) && $l['is_translate_panel']) $this->languagePanel[$l['language']] = $l['name'];
            if ($l['language'] == $this->getUser()->getCulture()) $this->defaultLanguage = $l['language'];
        }

        if (stSoteshopVersion::getVersion() == stSoteshopVersion::ST_SOTESHOP_VERSION_INTERNATIONAL) unset($this->languagePanel['pl_PL']);
        unset($languages);
        asort($this->language);
        asort($this->languagePanel);

        /**
         * Save POST
         */
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $settings = $this->getRequest()->getParameter('settings');
            $themePackage = $settings['theme'];
            $settings['theme'] = $this->themes[$themePackage]['name'];
            $settings['fixtures_name'] = $this->themes[$themePackage]['fixtures'];

            file_put_contents(sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'db'.DIRECTORY_SEPARATOR.'.settings.reg', sfYaml::dump($settings));

            return $this->forward('stSetup', 'configure');
        }
    }
}