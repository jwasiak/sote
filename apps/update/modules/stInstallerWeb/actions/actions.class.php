<?php
/**
 * SOTESHOP/stUpdate
 *
 * This file is the part of stUpdate application. License: (Open License SOTE) Open License SOTE.
 * Do not modify this file, system will overwrite it during upgrade.
 *
 * @package     stUpdate
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Open License SOTE
 * @version     $Id: actions.class.php 17106 2012-02-14 15:49:20Z michal $
 * @author      Marek Jakubowicz <marek.jakubowicz@sote.pl>
 */

// define ("ST_MIN_EXECUTION_TIME",20);       // minimalny czas potrzebny do wykonania aktualizacji
// define ("ST_MIN_EXECUTION_TIME_APP",0.1);  // minimalny dodatkowy czas aktualizacji 1 pakietu

/**
 * stInstallerWeb actions.
 *
 * @author Marek Jakubowicz <marek.jakubowicz@sote.pl>
 *
 * @package     stUpdate
 * @subpackage  actions
 */
class stInstallerWebActions extends sfActions
{

    public function preExecute()
    {
        $action = $this->getModuleName().'/'.$this->getActionName();

        $checkRequirements = new stCheckRequirements();

        if (!in_array($action, array('stInstallerWeb/requirements', 'stInstallerWeb/tools', 'stInstallerWeb/history', 'stInstallerWeb/verifyall')) && !$this->getRequest()->isXmlHttpRequest() && !$checkRequirements->testAll())
        {
            return $this->redirect('stInstallerWeb/requirements');
        }   

        if (!$this->getRequest()->isXmlHttpRequest() && !in_array($action, array('stInstallerWeb/news', 'stInstallerWeb/tools', 'stInstallerWeb/history', 'stInstallerWeb/verifyall')) && (!stCommunication::getUpgradeExpirationDate() || time() > stCommunication::getUpgradeExpirationDate() || stLicense::isOpen())) {
            return $this->redirect('@installerweb?action=news');
        }
    }
    /**
     * Executes index action
     */
    public function executeIndex()
    {
        $server = new stNewServer();
        if ($server->newServer())
        {
            $this->redirect('installerweb/newServer');
        } else
        {
            $this->redirect('installerweb/news');
        }
    }

    /**
     * Execute newServer action
     */
    public function executeNewServer()
    {
        $pakeweb = new stPakeWeb();
        $pakeweb->run('cc');
        $server = new stNewServer();
        $server->update();
    }

    /**
     *  List of installed applications.
     */
    public function executeList() {
        $stRegisterSync = new stRegisterSync();
        $this->content = $stRegisterSync->getSynchronizedApps();
    }

    /**
     * List of PEAR installer applications.
     */
    public function executeListpear() {
        $this->content = stPear::getInstalledPackages();
    }

    public function executeRequirements() {
        $this->tests = new stCheckRequirements();
        $this->testsPassed = $this->tests->testAll();
        $this->testsStatus = $this->tests->getTest();
        $this->hasWarning = false;
    }

    public function executeSoteshop6() {
        $smFolders = glob(sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'packages'.DIRECTORY_SEPARATOR.'sm*');
        $tmp = $smFolders;
        foreach($tmp as $key => $smFolder) if (preg_match('/sm[A-Za-z0-9]{0,}Theme/', $smFolder)) unset($smFolders[$key]);
        
        $this->error = false;
        if ($smFolders) $this->error = true;
    }
    
    /**
     * Executes updatelist action
     * If list contain stUpdate, show only stUpdate.
     */
    public function executeUpgradeList() {
        if ($this->getRequestParameter('ajax'))
            $ajax = TRUE;
        else
            $ajax = FALSE;

        if($ajax == FALSE && !$this->getRequest()->hasParameter('confirm')) {
            $packageFile = sfConfig::get('sf_root_dir').'/packages/soteshop_base/package.yml';
            if (file_exists($packageFile)) {
                $package = sfYaml::load($packageFile);
                if(version_compare($package['package']['version'], '6.0.0', '<')) 
                    return $this->forward('stInstallerWeb', 'soteshop6');
            } else
                return $this->forward('stInstallerWeb', 'soteshop6');
        }

        if ($ajax == FALSE) {
            $this->tests = new stCheckRequirements();

            if (!$this->tests->testAll())
                $this->redirect('stInstallerWeb/requirements');

            if (!stCheckBrowser::check())
                $this->redirect('stInstallerWeb/checkBrowser');

            if (!stCheckTheme::check())
                $this->redirect('stInstallerWeb/checkTheme');
        }

        $this->packages = stPear::getPackagesToUpgrade();

        if (is_array($this->packages) && !empty($this->packages)) {
            $this->hasPackages = TRUE;
            if (array_key_exists('stUpdate', $this->packages)) {
                $this->hasInstaller = TRUE;
                $this->installerVersion = $this->packages['stUpdate'];
                $this->packages = array('stUpdate' => $this->installerVersion);
            } else
                $this->hasInstaller = FALSE;
        } else
            $this->hasPackages = FALSE;

        $this->packagesCount = count($this->packages);

        if($ajax) {
            $this->setLayout(FALSE);
            $this->setTemplate('upgradeListAjax');
        }
        
        sfLoader::loadHelpers('stArray', 'stInstallerPlugin');
        $sync = st_array_diff(stRegisterSync::getSynchronizedApps(), stPear::getInstalledPackages());

        if(in_array('stUpdate', $sync['all'])) {
            $this->hasPackages = FALSE;
            $this->packagesCount = 0;
        }
    }

    /**
     * Application list for synchronization.
     */
    public function executeSyncList()
    {
        // check if this action is embeded
        $ajax=$this->getRequestParameter('ajax');
        if (! empty($ajax))
        {
            $this->setLayout(false);
            $this->setTemplate('syncListAjax');
        }

        if (!$this->getRequest()->hasParameter('ajax')) {
            $this->tests = new stCheckRequirements();
            if (!$this->tests->testAll()) {$this->redirect('stInstallerWeb/requirements');}
            if (!stCheckBrowser::check()) $this->redirect('stInstallerWeb/checkBrowser');
            if (!stCheckTheme::check()) $this->redirect('stInstallerWeb/checkTheme');
        }

        sfLoader::loadHelpers('stArray', 'stInstallerPlugin');
        $apps_sync = st_array_diff(stRegisterSync::getSynchronizedApps(), stPear::getInstalledPackages());

        $this->apps=$apps_sync;
        $this->ajax_num=sizeof($this->apps['all']); // menu info


        $this->linkToDownloadPackage = false;
        if (!$this->checkPackageRegFile())
        {
            $this->linkToDownloadPackage = true;
            $this->ajax_num=0; // menu info
        }
    }

    /**
     * Reboot.
     *
     * @param   bool        $check              true - verify number packahes for upgrade, false - do not verify
     */
    public function executeReboot($check=true)
    {
        $this->tests = new stCheckRequirements();
        if (!$this->tests->testAll()) {$this->redirect('stInstallerWeb/requirements');}
        if (!stCheckBrowser::check()) $this->redirect('stInstallerWeb/checkBrowser');
        if (!stCheckTheme::check()) $this->redirect('stInstallerWeb/checkTheme');
                    
        // Zweryfikuj czas potrezbny do wykonania akcji
        // Pobierz ilosc aplikacji do instalacji
        $regsync = new stRegisterSync();
        $apps_sync=$regsync->getAppsToSync();
        $npkg=sizeof($apps_sync['all']);
        if ((! $npkg>0) && ($check)) $this->redirect('installerweb');

        // deprecated
        // $time = new stServerExecutionTime();
        // $time->setMax(($npkg*ST_MIN_EXECUTION_TIME_APP)+ST_MIN_EXECUTION_TIME);
        // if ($time->check())
        // {
        //     $this->time=true;
        // } else {
        //     $this->time=false;
        //     $this->time_server=$time->getServerTime();
        //     $this->time_min=$time->getMax();
        // }
        $this->time=true;  // added for previous versions of template

        $this->linkToDownloadPackage = false;
        if (!$this->checkPackageRegFile()) $this->linkToDownloadPackage = true;
    }

    /**
     * Rescue.
     */
    public function executeRescue()
    {
        $this->tests = new stCheckRequirements();
        if (!$this->tests->testAll()) {$this->redirect('stInstallerWeb/requirements');}
        if (!stCheckBrowser::check()) $this->redirect('stInstallerWeb/checkBrowser');
        if (!stCheckTheme::check()) $this->redirect('stInstallerWeb/checkTheme');

        // force unlock downloads
        stPackageDownloader::unlockPackagesList();

        if (stLockUpdate::isLocked())
        {
            $this->executeReboot(false);
            $this->setTemplate('reboot');
        } else
        {
            $this->redirect('stInstallerWeb/news');
        }
        // $this->executeReboot(false);
        // $this->setTemplate('reboot');
    }

    /**
     * Rescure Reboot.
     */
    public function executeRescueReboot()
    {
        $this->tests = new stCheckRequirements();
        if (!$this->tests->testAll()) {$this->redirect('stInstallerWeb/requirements');}
        if (!stCheckBrowser::check()) $this->redirect('stInstallerWeb/checkBrowser');
        if (!stCheckTheme::check()) $this->redirect('stInstallerWeb/checkTheme');

        // if (stLockUpdate::isLocked())
        //      {
        $this->executeReboot(false);
        $this->setTemplate('reboot');
        // } else
        // {
        // $this->redirect('stInstallerWeb/news');
        // }
    }

    /**
     * Synchronize downloaded applications.
     */
    public function executeSync()
    {
        $regsync = new stRegisterSync();
        $apps_sync=$regsync->getAppsToSync();

        // application list for synchronization
        $this->apps=$apps_sync;

        $installer = new stInstaller('web');
        $ui = new stInstallerOutputWeb();
        $installer->setOutputObject($ui);


        if (! empty($apps_sync['all']))
        {

            // synchornize
            $installer->sync($apps_sync['all'],'Synchronization ('.sizeof($apps_sync['all']).')');
        }
        else {
            // nothing to do
        }
    }

    /**
     * Code verification.
     * Find user unautorized modifications.
     */
    public function executeVerify()
    {
        $this->tests = new stCheckRequirements();
        if (!$this->tests->testAll()) {$this->redirect('stInstallerWeb/requirements');}
        if (!stCheckBrowser::check()) $this->redirect('stInstallerWeb/checkBrowser');
        if (!stCheckTheme::check()) $this->redirect('stInstallerWeb/checkTheme');

        $regsync = new stRegisterSync();
        $apps_sync=$regsync->getAppsToSync();

        $this->apps=array_merge($apps_sync['changed'],$apps_sync['added']);

        $npkg_all=sizeof($apps_sync['all']);
        $npkg_changed=sizeof($this->apps);
        $npkg_del=sizeof($apps_sync['deleted']);

        $this->npkg=$npkg_changed;

        if (! $npkg_all>0) {
            $this->redirect('installerweb');
        }

        $this->linkToDownloadPackage = false;
        if (!$this->checkPackageRegFile()) $this->linkToDownloadPackage = true;
    }

    /**
     * Symfony Web task execution.
     */
    public function executeTask()
    {
        $this->task=$this->getRequestParameter('task');
        $this->content='';
        $this->error='';

        if (! empty($this->task))
        {
            $pakeweb = new stPakeWeb();
            $pakeweb->run($this->task);
            $this->content=$pakeweb->content;
            $this->error=$pakeweb->error;

            if($this->task == 'pear cc')
                stPearCache::removeCache();
        }

    }

    /**
     * Symfony cc
     */
    public function executeCc()
    {
        $pakeweb = new stPakeWeb();
        $pakeweb->run('cc');
        $this->content=$pakeweb->content;
        $this->error=$pakeweb->error;
    }

    /**
     * Upgrade provided Applications.
     */
    public function executeUpgradeBySteps()
    {
        if (!$this->getRequestParameter('package') || !$this->getRequestParameter('version'))
        {
            $this->redirect('stInstallerWeb/upgradeList');
        } else {
            $package = $this->getRequestParameter('package');
            $version = $this->getRequestParameter('version');
            stPackageDownloader::setUpgradeType('package', $package, $version);
        }
    }

    /**
     * Upgrade all applications.
     */
    public function executeUpgradeAllBySteps()
    {
        stPackageDownloader::setUpgradeType('all');
    }

    public function executeListUpgrade() {
        $this->packages = stPear::getPackagesToUpgrade(TRUE);
    }

    public function executeUploadDev()
    {

    }

    /**
     * Package upload.
     */
    public function executeUpload() {
        stRegisterSync::fixmd5sum();

        $this->error = '';
        $this->notice = '';
        $this->content = '';
        if ($this->getRequest()->getMethod() == sfRequest::POST && $this->hasRequestParameter('upload')) {

            $upload = $this->getRequestParameter('upload');
            $upload['file'] = $this->getRequest()->getFileName('upload[file]');

            if (!isset($upload['file']) || (isset($upload['file']) && empty($upload['file']))) {
                $this->error = 'Brak pakietu do instalacji.';
                return sfView::SUCCESS;
            }

            $fileDir = sfConfig::get('sf_root_dir').'/install/cache';
            $filePath = $fileDir.'/'.$upload['file'];

            $this->getRequest()->moveFile('upload[file]', $filePath);

            if (isset($upload['forced']) && $upload['forced'] == 1) $forced = true; else $forced = false;
            if (isset($upload['nodeps']) && $upload['nodeps'] == 1) $nodeps = true; else $nodeps = false;

            if(!class_exists('Archive_Tar')) {
                $pearlib = SF_ROOT_DIR.DIRECTORY_SEPARATOR.'pear'.DIRECTORY_SEPARATOR.'php'; 
                if (is_dir($pearlib)) ini_set('include_path', '.:'.$pearlib.':'.ini_get('include_path')); 
                include('Archive'.DIRECTORY_SEPARATOR.'Tar.php');
            }

            if(file_exists($fileDir.'/package.xml'))
                unlink($fileDir.'/package.xml');

            $tar = new Archive_Tar($filePath, true);
            $extract = $tar->extractList(array('package.xml'), $fileDir);

            if (!$extract || ($extract && !file_exists($fileDir.'/package.xml'))) {
                $this->error = 'Niepoprawny format pliku.'; 
                return sfView::SUCCESS;
            }

            $xml = simplexml_load_file($fileDir.'/package.xml');

            $installed = stPear::getInstalledPackages();

            foreach ($xml->dependencies->required->package as $package) {
                $packageName = (string)$package->name;
                $packageVersion = (string)$package->min;
                if (isset($installed[$packageName])) {
                    if (!version_compare($installed[$packageName], $packageVersion, '>=')) {
                        $this->error = 'Brak zainstalowanego pakietu '.$packageName.' w wersji '.$packageVersion.'.';
                        return sfView::SUCCESS;
                    }
                } else {
                    $this->error = 'Brak zainstalowanego pakietu '.$packageName.'.';
                    return sfView::SUCCESS;
                }
            }

            $name = (string)$xml->name;
            list($name, $versionWithExt) = explode('-', $upload['file']);

            switch(stWebStore::checkPackage($name, (isset($upload['code']) ? $upload['code'] : ''))) {
                case 0:
                    if (!preg_match('/^st|sm/', $name)) {
                        $this->error = 'Brak połączenia z serwerem sote.pl.';
                        return sfView::SUCCESS;
                    }
                case 1:
                    break;
                case 2:
                    $this->error = 'Nieprawidłowy kod aktywacji.';
                    return sfView::SUCCESS;
                case 3:
                    $this->error = 'Kod aktywacji został już wykorzystany.';
                    return sfView::SUCCESS;
            }

            if ($forced) 
                $command = 'force-install'; 
            else
                $command = 'upgrade';

            $this->content = stPear::runPearCommand(array('command' => $command, 'parameters' => array($filePath), 'options' => array('forced' => $forced, 'nodeps' => $nodeps)), 'raw', true);

            if (preg_match('/Invalid tgz file/', $this->content)) {
                $this->error = 'Niepoprawny format pliku.';
                return sfView::SUCCESS;
            }

            if (preg_match('/install ok/', $this->content) || preg_match('/upgrade ok/', $this->content)) {
                $this->notice = 'Plik został wgrany.';
                stWebStore::activatePackage($name, (isset($upload['code']) ? $upload['code'] : ''));
            } else 
                $this->error = 'Błąd podczas wgrywania pliku.'; 
            return sfView::SUCCESS;
        }
    }

    /**
     * Page not found message.
     */
    public function executePageNotFound()
    {

    }

    /**
     * Upgrade history.
     */
    public function executeHistory()
    {
        $history = new stInstallerHistory();
        $this->history_apps = array_reverse($history->getHistory());
    }

    /**
     * RSS upgrade.
     */
    public function executeRss()
    {

    }

    /**
     * Expert tools.
     */
    public function executeTools()
    {
        // Check if optimization can be executed
        $regsync = new stRegisterSync();
        $apps_sync=$regsync->getAppsToSync();
        $this->optimization=true;
        if (! empty($apps_sync['all'])) $this->optimization=false; // there are apps in install/src
        if (stLockUpdate::isLocked()) $this->optimization=false;   // install process is executed
    }

    /**
     * Verify all code.
     */
    public function executeVerifyall()
    {
        $peari = new stPearInfo();
        $packages = $peari->getPackages();
        $this->count=sizeof($packages);
    }


    public function executeOptimization()
    {
        $this->executeCc();
    }

    /**
     * Symfony pear clear-cache
     */
    public function executePearcc() {
        stPear::runPearCommand('clear-cache');
    }

    /**
     * Symfony pear config-set preferred_state
     */
    public function executePearstate() {
        $this->isStable = true;

        if ($this->getRequest()->getMethod() == sfRequest::POST) {
            if (in_array($state = $this->getRequest()->getParameter('pear[state]'), array('stable', 'beta'))) {
                if ($state == 'beta')
                    $this->isStable = false;
                stPear::runPearCommand(array('command' => 'config-set', 'parameters' => array('preferred_state', $state, 'user')), null, true);
            }
        } else {
            $state = stPear::runPearCommand(array('command' => 'config-get', 'parameters' => array('preferred_state'))  );
            if (!preg_match('/stable/', $state))
                $this->isStable = false;
        }
    }

    public function executeNews()
    {
        // News Action
        $this->showNews = true;
        if ($this->getUser()->getCulture() == 'en_US') $this->showNews = false;
    }

    /**
     * Show information about changelog.
     * If any application has important message or required confirmation this action show it.
     */
    public function executeChangelog()
    {
        $changelog = new stChangelog();
        if (! $changelog->isAnyActive())
        {
            $this->redirect('installerweb/verify');
            $this->active="NOT ACTIVE"; // debug value
            return;
        } else
        {
            $this->active="ACTIVE";      // debug value
        }

        $this->files   = $changelog->getAllFiles();
        $this->apps    = $changelog->getPearUpgrades();
        $this->new     = $changelog->getSyncUpgrades();
        $this->active_contents = $changelog->getActiveContents();

        if (empty($this->active_contents))
        {
            $this->redirect('installerweb/verify');
            return;
        }

        $this->result    = $changelog->getResult();

        $this->smarty_changed = $changelog->isSmartyChanged();
        $this->smarty_theme   = $changelog->getSmartyTheme();

        $this->confirmation=false;
        foreach ($this->result as $priority=>$content)
        {
            if ($priority=="P1") $this->confirmation=true;
            foreach ($content as $app=>$content2)
            {
                $ret[$priority][$app]=$changelog->getUpdateContent($app,$content2,$priority);
            }
        }
        $this->output=$ret;

        if ($this->smarty_changed)
        {
            $smarty_changelog   = stChangelogSmarty::getInstance();
            $this->backup_token = $smarty_changelog->doBackup();
            $this->smarty_files = $smarty_changelog->getAllFiles();
        }
    }

    /**
     * Download backup
     */
    public function executeBackup()
    {
        $token  = $this->getRequestParameter('token');
        $this->token=$token;
        $this->raw_content=NULL;
        if (! empty($token))
        {
            $backup = stUpdateBackup::getInstance();
            $backup_file = $backup->getBackupFile($token);
            if (! empty($backup_file))
            {
                $raw_content=file_get_contents(sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.$backup_file);

                $this->setLayout(false);
                $response = $this->getContext()->getResponse();
                $response->setContentType("application/octet-stream");
                $response->setHttpHeader('Content-Disposition', 'attachment; filename="'.basename($backup_file).'"');
                return $this->renderText($raw_content);

            }
        }
    }

    /**
     * Check .packages.reg file
     */
    protected function checkPackageRegFile()
    {
        $file = sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR."install".DIRECTORY_SEPARATOR."db".DIRECTORY_SEPARATOR.".packages.reg";

        if(file_exists($file))
        {
            $packages = unserialize(file_get_contents($file));

            if (empty($packages)) $unlink = true;
            else {
                $unlink = true;
                foreach ($packages as $package => $status) if ($status != 'installed') $unlink = false;
            }

            if ($unlink) unlink($file);

            return $unlink;
        }
        return true;
    }
    
    public function executeInstallPackage() {
        if ($this->getRequest()->hasParameter('package')) {
    
            $package = $this->getRequest()->getParameter('package');
            if (stWebStore::checkPackage($package) == 1) {
                
                stPear::runPearCommand(array('command' => 'upgrade', 'parameters' => array(stPearCurl::getChannel().'/'.$package), 'options' => array('nodeps' => true)), 'raw', true);

                stWebStore::activatePackage($package);
                stWebStore::increaseDownloadCount($package);
            
                $this->setFlash('notice', 'Pakiet został pobrany.');
                return $this->redirect('stWebStore/index');
            } else {
                return $this->redirect('@homepage');
            }
        } else {
            return $this->redirect('@homepage');
        }
    }
    
    public function executeCheckTheme() {
        $this->check = stCheckTheme::check();
    }
    
    public function executeCheckBrowser() {
        $this->check = stCheckBrowser::check();
    }
    
    public function executeAjaxHomepageStatus() {
        $this->setLayout(FALSE);

        $toDownloadApps = count(stPear::getPackagesToUpgrade());
        
        sfLoader::loadHelpers('stArray', 'stInstallerPlugin');
        $appsToSync = st_array_diff(stRegisterSync::getSynchronizedApps(), stPear::getInstalledPackages());

        $toInstallApps = 0;
        foreach ($appsToSync as $value)
            $toInstallApps =+ count($value);

        if (!$this->checkPackageRegFile()) $toInstallApps = 0;
        
        $this->status = 'PACKAGES_FOUND';
        if ($toDownloadApps == 0 && $toInstallApps == 0) $this->status = 'NOTHING_TO_UPGRADE';

        $upgradeServiceTime = stCommunication::getUpgradeExpirationDate();
        $this->isSeven = stCommunication::getIsSeven();

        if ($upgradeServiceTime !== FALSE) {
            if(time() > $upgradeServiceTime) {
                $upgradeServiceTime = stCommunication::getUpgradeExpirationDate(null, 30);

                if(time() > $upgradeServiceTime) {
                    $this->status = 'UPGRADE_SERVICE_NOT_ACTIVE';
                    $this->days = 14 - round((time() - $upgradeServiceTime) / 86400);
                    $this->upgradeServiceTime = date('d.m.Y', $upgradeServiceTime);
                }
            }
        } else
            $this->status = 'SOTE_CONNECTION_ERROR';
    }
}
