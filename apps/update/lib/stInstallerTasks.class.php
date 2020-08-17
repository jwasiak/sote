<?php

/**
 * SOTESHOP/stUpdate
 *
 * This file is the part of stUpdate application. License: (Open License SOTE) Open License SOTE.
 * Do not modify this file, system will overwrite it during upgrade.
 *
 * @package     stUpdate
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Open License SOTE
 * @version     $Id: stInstallerTasks.class.php 16203 2011-11-23 14:13:24Z michal $
 * @author      Marek Jakubowicz <marek.jakubowicz@sote.pl>
 */
// temporary test function
// function convert_memory($size)
// {
//     $unit=array('b','kb','mb','gb','tb','pb');
//     return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
// }

/**
 * Token keys.
 */
require_once (sfConfig::get('sf_app_lib_dir').'/stToken.php');

/**
 * Update Backup class
 */
require_once (sfConfig::get('sf_root_dir').'/apps/update/modules/stInstallerWeb/lib/stUpdateBackup.class.php');


require_once sfConfig::get('sf_symfony_lib_dir').'/vendor/pake/pakeGetopt.class.php';

require_once sfConfig::get('sf_symfony_lib_dir').'/vendor/pake/pakeApp.class.php';

/**
 * Logs
 */
if (!defined('ST_INSTALLER_LOG_PAGE'))
    define("ST_INSTALLER_LOG_PAGE", sfConfig::get('sf_log_dir').'/webinstaller.log');

/**
 * Temporary list of synchronized applications.
 */
if (!defined('ST_APPSTOSYNC_FILE'))
    define("ST_APPSTOSYNC_FILE", sfConfig::get('sf_root_dir').'/install/db/.appstosync.reg');

/**
 * Temporary list of applications installed before synchonization.
 */
if (!defined('ST_REGSYNC_PRE_INSTALL_FILE'))
    define("ST_REGSYNC_PRE_INSTALL_FILE", sfConfig::get('sf_root_dir').'/install/db/.regsync.reg');

sfLoader::loadHelpers('Helper');
use_helper('I18N', 'Url', 'Tag');
use_helper('stProgressBar', 'Partial');

/**
 * Installer WWW. Progress bar steps.
 *
 * @package     stUpdate
 * @subpackage  libs
 */
class stInstallerTasks
{

    /**
     * Message (step)
     * @var string
     */
    public $msg = '';
    /**
     * Temporary fixture dir
     */
    private $temporary_fixture_dir = NULL;

    /**
     * Step
     *
     * @param   integer     $step               count step
     * @return  integer     new step number (default should be $step+1)
     */
    public function step($step)
    {
        $pakeweb = new stPakeWeb();

        $task = '';

        $offset = 1;

        $i18n = sfContext::getInstance()->getI18N();

        pakeApp::get_instance()->handle_options(SF_ENVIRONMENT == 'prod' ? '--quiet' : '--verbose');

        switch ($step)
        {
            case 0:
                $this->msg = $i18n->__('Blokowanie sklepu', null, 'stInstallerWeb');  // opis krok do przodu
                if (stLockUpdate::isLocked())
                {
                    $locked_before_run = true;
                }
                else
                {
                    $locked_before_run = false;
                }

                stLockUpdate::lock();

                $this->_secureStSetup();
                // save apps if instalation wasn't stoped wrongly
                if (!$locked_before_run)
                {
                    $this->_saveAppsToSync();
                    $this->_saveRegSync();
                }

                $this->_preExecute($this->_loadAppsToSync('all'));           // pre execute scripts

                break;
            case 1:
                $this->msg = $i18n->__('Odświeżenie pamięci podręcznej aplikacji', null, 'stInstallerWeb');  // opis krok do przodu

                $this->clearFastCache();

                if (class_exists('stLock'))
                {
                    // lock shop
                    stLock::lock('frontend');
                    stLock::lock('backend');
                }

                $task = 'cc --lock=false';

                break;
            case 2:
                $this->msg = $i18n->__('Kopiowanie plików', null, 'stInstallerWeb');  // opis krok do przodu
                break;
            case 3:
                $this->msg = $i18n->__('Konfiguracja instalacji', null, 'stInstallerWeb');  // opis krok do przodu
                $task = 'installer-sync';
                break;
            case 4:
                $this->msg = $i18n->__('Tworzenie modelu bazy danych - Weryfikacja', null, 'stInstallerWeb');  // opis krok do przodu
                $task = 'setup-update';
                break;                                        // database update
            case 5:
                $this->msg = $i18n->__('Tworzenie modelu bazy danych - Usuwanie starych plików', null, 'stInstallerWeb');  // opis krok do przodu
                $task = 'installer-schema-diff';
                $user = sfContext::getInstance()->getUser();
                $data = $user->getAttribute('Installer', array(), 'soteshop/stProgressBarPlugin');
                $data['steps'] = 15;
                $user->setAttribute('Installer', $data, 'soteshop/stProgressBarPlugin');
                break;
            case 6:
                $this->msg = $i18n->__('Tworzenie modelu bazy danych - Generowanie schematów XML', null, 'stInstallerWeb');  // opis krok do przodu
                $task = 'installer-clean-model forced';
                break;
            case 7:
                $this->msg = $i18n->__('Tworzenie modelu bazy danych - Generowanie klas modeli', null, 'stInstallerWeb');  // opis krok do przodu
                $task = 'installer-convert-schema forced';
                break;
            case 8:
                $this->msg = $i18n->__('Tworzenie modelu bazy danych - Generowanie zapytań SQL', null, 'stInstallerWeb');  // opis krok do przodu
                $task = 'installer-build-model forced';
                break;
            case 9:
                $this->msg = $i18n->__('Tworzenie modelu bazy danych - Aktualizacja struktury bazy danych', null, 'stInstallerWeb');  // opis krok do przodu
                $task = 'installer-build-sql forced';
                break;
            case 10:
                $this->msg = $i18n->__('Czyszczenie plików tymczasowych', null, 'stInstallerWeb');  // opis krok do przodu
                $task = 'installer-insert-sql forced';
                break;
            case 11:
                $this->msg = $i18n->__('Odświeżenie pamięci podręcznej aplikacji', null, 'stInstallerWeb');  // opis krok do przodu
                $task = 'cc --lock=false';
                break;
            case 12:
                $this->msg = $i18n->__('Wczytywanie danych', null, 'stInstallerWeb');
                break;
            case 13: 
                $this->msg = $i18n->__('Tworzenie plików pamięci podręcznej', null, 'stInstallerWeb');
                $this->_propelLoadData($this->_loadAppsToSync('added'));
                break;     // load fixtures only for new applications
            case 14:
                $this->generateCache();
                break;
        }

        if (!empty($task))
        {
            if ($pakeweb->run($task))
            {
                if (!empty($pakeweb->content))
                {
                    $this->log("\n".date('Y-m-d G:i:s')."\n".'symfony '.$task."\n".$pakeweb->content);
                }
            }
            else
            {
                throw new Exception($pakeweb->error);
            }
        }

        if ($task == 'installer-sync')
        {
            $this->_htaccess();
        }
        elseif ($task == 'setup-update')
        {
            $this->fixSync();
        }
        elseif ($task == 'installer-schema-diff' && !stPropelGeneratorController::isDatabaseRebuildNeeded())
        {
            $offset = 6;

            $this->msg = $i18n->__('Czyszczenie plików tymczasowych', null, 'stInstallerWeb');
        }

        $this->delay($step == 0 ? 0 : 10);

        return $step + $offset;
    }

    /**
     * Get message.
     *
     * @return   string
     */
    public function getMessage()
    {
        return $this->msg;
    }

    /**
     * Last progress bar step.
     *
     * @param    int $opt 0 - means don't execute optimization after installation
     * @return   string
     */
    public function close($opt = true, $update = true)
    {
        $i18n = sfContext::getInstance()->getI18N();
        
        if ($update)
        {
            stAppStats::activate('Update');
        }

        if ($this->_installVerification())
        {
            stUpdateBackup::cleanBackup(); // clean last backup (eg. deprecated smarty files in user theme etc).
            sfLoader::loadPluginConfig();
            $this->_postExecute($this->_loadAppsToSync('all'));
            
            if (class_exists('stLock'))
            {
                stLock::unlock('frontend');
                stLock::unlock('backend');
            }
            // unlock shop
        }

        stLockUpdate::unlock();

        $this->msg = $i18n->__('Instalacja aktualizacji zakończona.', null, 'stInstallerWeb');

        // cancel optimization (in stSetup for example)
        if ($opt == 1)
        {
            $this->addOptimization();
        }

        stEventDispatcher::getInstance()->notify(new sfEvent($this, 'stInstallerTaks.onClose', array()));

        $this->_cleanAppsToSync();
        $this->_cleanRegSync();
    }

    /**
     * Optimization and caching pages.
     * Delete download PEAR files. Optimize & cache actions.
     */
    private function addOptimization()
    {
        $this->msg = progress_bar('stCleanInstallerDownload', 'stCleanInstallerDownload', 'step', stCleanInstallerDownload::getSteps());
        $this->msg .= progress_bar('stCleanInstallerSrc', 'stCleanInstallerSrc', 'step', stCleanInstallerSrc::getSteps());
    }

    /**
     * Set progress bar title.
     *
     * @return   string
     */
    public function getTitle()
    {
        $i18n = sfContext::getInstance()->getI18N();
        return $i18n->__('Instalacja aktualizacji (Uwaga! Nie zamykaj okna przeglądarki, aż instalacja się nie skończy):', null, 'stInstallerWeb');
    }

    /**
     * Verify instllation.
     * @todo
     *
     * @return   bool
     */
    protected function _installVerification()
    {
        return true;
    }

    /**
     * Get host.
     *
     * @return   string
     */
    protected function _getHost()
    {
        $context = sfContext::getInstance();
        $request = $context->getRequest();
        return $request->getHost();
    }

    /**
     * Get application list for synchronization.
     *
     * @param                 string      $mode               (added|changed|deleted|all|apps)
     * @return   array
     */
    protected function _appsToSync($mode='all')
    {
        $regsync = new stRegisterSync();
        $apps = $regsync->getAppsToSync();
        if ($mode == 'apps')
        {
            return $apps;
        } else
        return $apps[$mode];
    }

    /**
     * Save log.
     *
     * @param        string      $message
     */
    protected function log($message)
    {
        if (sfConfig::get('sf_logging_enabled'))
        {
            $fd = fopen(ST_INSTALLER_LOG_PAGE, "a+");
            fwrite($fd, $message);
            fclose($fd);
        }
    }

    /**
     * Remember application list for synchronization.
     * Needed for steps after synchronization.
     *
     * @see ST_APPSTOSYNC_FILE
     * @return   bool
     */
    private function _saveAppsToSync()
    {
        $apps = $this->_appsToSync('apps');
        $data = serialize($apps);
        if (file_put_contents(ST_APPSTOSYNC_FILE, $data))
        return true;
        else
        {
            throw new Exception('Unable to save data to file '.ST_APPSTOSYNC_FILE);
        }
        return false;
    }

    /**
     * Remember application list before upgrade.
     * Needed for steps afte upgrade.
     *
     * @return   bool
     */
    private function _saveRegSync()
    {
        $reg = new stRegisterSync();
        $apps = $reg->getSynchronizedApps();
        $data = serialize($apps);
        if (file_put_contents(ST_REGSYNC_PRE_INSTALL_FILE, $data))
        return true;
        else
        {
            throw new Exception('Unable to save data to file '.ST_REGSYNC_PRE_INSTALL_FILE);
        }
        return false;
    }

    private function _cleanRegSync()
    {
        if (file_exists(ST_REGSYNC_PRE_INSTALL_FILE))
        unlink(ST_REGSYNC_PRE_INSTALL_FILE);
    }

    /**
     * Odczytuje zapamiętane aplikacje przed synchronizacją
     * Get applications before upgrade.
     *
     * @see $this->_saveRegSync()
     * @return   array
     */
    private function _loadRegSync()
    {
        if (file_exists(ST_REGSYNC_PRE_INSTALL_FILE))
        {
            $data = file_get_contents(ST_REGSYNC_PRE_INSTALL_FILE);
            $apps = unserialize($data);
        } else
        $apps=array();

        return $apps;
    }

    /**
     * Create and get temporary update directory with unique key
     * $this->temporary_fixture_dir - unique key for object request
     * @return string
     */
    private function _getUpdateFixtureDirKey()
    {
        if (!empty($this->temporary_fixture_dir))
        return $this->temporary_fixture_dir;

        // build dir structure
        $cdir = sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'install';
        $dir_fixtures = array('data', 'fixtures', time());
        foreach ($dir_fixtures as $dir)
        {
            $cdir = $cdir.DIRECTORY_SEPARATOR.$dir;
            if (!is_dir($cdir))
            {
                if (!mkdir($cdir))
                throw new Exception("Unable mkdir $cdir");
            }
        }

        // set value for object
        $this->temporary_fixture_dir = $cdir;

        return $this->temporary_fixture_dir;
    }

    /**
     * Load fixtures for provided applications.
     *
     * @param   array       $apps               application list
     */
    private function _propelLoadData($apps)
    {

        $locks = array(); // list of locked files
        foreach ($apps as $app)
        {
            $fixtures = $this->_getFixturePath($app);
            foreach ($fixtures as $fixture)
            {
                if (file_exists($fixture))
                {
                    $update_fixture_dir = $this->_getUpdateFixtureDirKey();
                    $task = "propel-load-data ../update $fixture append";                  // this is required for lock comaptibility for previous versions
                    $md5_task_lock_file_name = md5($task).'_'.basename($fixture).'.lck';   // this file lock duplicate data loading
                    if (!stLockUpdate::isLockedKey($md5_task_lock_file_name))
                    {
                        stLockUpdate::lockKey($md5_task_lock_file_name);                 // lock data loading for the same app
                        $locks[] = $md5_task_lock_file_name;
                        if (!copy($fixture, $update_fixture_dir.DIRECTORY_SEPARATOR.basename($fixture)))
                        {
                            throw new Exception("Unable copy $fixture ->".$update_fixture_dir.DIRECTORY_SEPARATOR.basename($fixture));
                        }
                    }
                    else
                    {
                        // data for this app was loaded
                    }
                }
            }
        }

        // Only 1 task can be executed during 1 request (because of symfony pakeApp).
        // That's way fixtures are copied to 1 directory and executed in 1 task.
        if (!empty($update_fixture_dir))
        {
            $pakeweb = new stPakeWeb();
            $task = "propel-load-data ../update $update_fixture_dir append";
            if ($pakeweb->run($task))
            {
                $pakeweb->content = $this->_fixcontent($pakeweb->content);
                if (!empty($pakeweb->content))
                $this->log("\n".date('Y-m-d G:i:s')."\n".'symfony '.$task."\n".$pakeweb->content);
            } else
            {
                $this->log($pakeweb->error);
                // unlock app fixtures because fixtures are rollbacked
                foreach ($locks as $lock)
                unlink($lock);
            }

            unset($pakeweb); // memory optimization
        }
        return NULL;
    }

    /**
     * Delete unimportant warning from logs.
     * Task propel-load-data return some warning which are ok, and should be savd in logs.
     * (warning about duplicated constat definitions)
     *
     * @param        string      $content
     * @return   string
     */
    private function _fixcontent($content)
    {
        $lines = split("\n", $content);
        $o = '';
        foreach ($lines as $line)
        {
            if (ereg('already defined', $line))
            continue;
            if (ereg('\<br \/\>', $line))
            continue;
            $o.=$line."\n";
        }

        return $o;
    }

    /**
     * Get fixture path in install/src/$app
     *
     * @param   string      $app
     * @param   array       array(/path/to/soteshop/data/fixtrures/stAppName.yml lub /path/to/soteshop/plugins/stAppNamePlugin/data/fixtures/stAppNamePlugin.yml)
     */
    private function _getFixturePath($app)
    {
        $dir = sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.$app;
        $fixture_dirs = sfFinder::type('dir')->name('fixtures')->in($dir);

        $data = array();
        foreach ($fixture_dirs as $fd)
        {
            $files = sfFinder::type('file')->name($app.'.yml')->in($fd);
            foreach ($files as $file)
            {
                $d = split('install'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.$app.DIRECTORY_SEPARATOR, $file, 2);
                if (!empty($d[1]))
                $data[] = sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.$d[1];
            }
        }

        return $data;
    }

    /**
     * Get applications before synchronization.
     *
     * @see $this->_saveAppsToSync
     * @see ST_APPSTOSYNC_FILE
     * @param   string      $mode               type (added|changed|deleted)
     * @return  array       lista aplikacji
     */
    private function _loadAppsToSync($mode) {
        if (file_exists(ST_APPSTOSYNC_FILE)) {
            $data = file_get_contents(ST_APPSTOSYNC_FILE);
            $apps = unserialize($data);
            return $apps[$mode];
        } else {
            return array();
        }
    }

    private function _cleanAppsToSync() {
        if (file_exists(ST_APPSTOSYNC_FILE)) unlink(ST_APPSTOSYNC_FILE);
    }

    /**
     * Execute pre install script.
     *
     * @param string $apps array()
     */
    private function _preExecute($apps)
    {
        $peari = stPearInfo::getInstance();
        $regsync = $this->_loadRegSync();

        foreach ($apps as $app)
        {
            $script = sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.$app.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'update-pre'.DIRECTORY_SEPARATOR.$app.'.php';
            if (file_exists($script))
            {
                $version_new = $peari->getPackageVersion($app);
                ;
                if (!empty($regsync[$app]))
                $version_old = $regsync[$app];
                else
                $version_old=NULL;

                file_put_contents(sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'log'.DIRECTORY_SEPARATOR.'version.tmp', "$version_old -> $version_new");

                // lock another executing for the same app and version
                $md5_script_lock_file = md5($script).'_'.$app.'-'.$version_new.'-pre.lck';
                if (!stLockUpdate::isLockedKey($md5_script_lock_file))
                {
                    include_once($script);
                    stLockUpdate::lockKey($md5_script_lock_file); // lock execution for app and version
                }
            }
        }
    }

    /**
     * Execute post install scripts.
     *
     * @param array $apps array('stAppName1','stAppName2',...)
     */
    private function _postExecute($apps)
    {
        $peari = stPearInfo::getInstance();
        $regsync = $this->_loadRegSync();

        foreach ($apps as $app)
        {
            $script = sfConfig::get('sf_data_dir').DIRECTORY_SEPARATOR.'update'.DIRECTORY_SEPARATOR.$app.'.php';
            if (file_exists($script))
            {
                $version_new = $peari->getPackageVersion($app);
                if (!empty($regsync[$app]))
                $version_old = $regsync[$app];
                else
                $version_old=NULL;

                // lock another executing for the same app and version
                $md5_script_lock_file = md5($script).'_'.$app.'-'.$version_new.'.lck';
                if (!stLockUpdate::isLockedKey($md5_script_lock_file))
                {
                    include_once($script);
                    stLockUpdate::lockKey($md5_script_lock_file); // lock execution for app and version
                }
            }
        }
    }

    /**
     * Lock stSetup
     */
    private function _secureStSetup()
    {
        $file = sfConfig::get('sf_app_dir').DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.'stSetup'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'security.yml';
        // all:
        //  is_secure: on
        $data = array();
        $data['all']['is_secure'] = 'on';
        file_put_contents($file, sfYaml::dump($data));
    }

    /**
     * Rebuild .htaccess file.
     *
     * @param bool $force true - always overwrite, false - only when stBase is upgraded
     * @author Michal Prochowski <michal.prochowski@sote.pl>
     */
    protected function _htaccess($force = false) {
        $apps = $this->_loadAppsToSync('changed');
        if (in_array('stBase', $apps) || $force) {
            $htaccessInstallPath = sfConfig::get('sf_root_dir').'/install/src/stBase/stBase/web/.htaccess';
            if(file_exists($htaccessInstallPath)) {
                copy($htaccessInstallPath, stHtaccess::getBaseFilePath());
                stHtaccess::rebuild($htaccessInstallPath);
            }
        }
    }

    /**
     * Fix upgrade previou known error.
     * 1. Error stNewsPlugin - delete old files stNewsPlugin/config/*
     */
    protected function fixSync()
    {
        // fix cache structore
        $fixcache = new stFixCache();
        $fixcache->fixAll();

        $src = sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR.'src';
        $src_stNewsPlugin = $src.DIRECTORY_SEPARATOR.'stNewsPlugin'.DIRECTORY_SEPARATOR.'plugins'.DIRECTORY_SEPARATOR.'stNewsPlugin';
        $st_stNewsPlugin = sfConfig::get('sf_plugins_dir').DIRECTORY_SEPARATOR.'stNewsPlugin';
        // pliki do usuniecia
        $delete = array(
        $src_stNewsPlugin.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'stNewsPlugin_stNewsPlugin-schema.custom.yml',
        $src_stNewsPlugin.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'stNewsPlugin-schema.yml',
        $src_stNewsPlugin.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'stNewsPlugin-schema.dbd.xml',
        $st_stNewsPlugin.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'stNewsPlugin_stNewsPlugin-schema.custom.yml',
        $st_stNewsPlugin.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'stNewsPlugin-schema.yml',
        $st_stNewsPlugin.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'stNewsPlugin-schema.dbd.xml',
        );
        foreach ($delete as $file)
        {
            if (file_exists($file))
            unlink($file);
        }
    }

    /**
     * Clear FastCache if needed
     */
    protected function clearFastCache()
    {
        if (class_exists('stFastCacheManager'))
        {
            stFastCacheManager::clearCache();
        }
    }

    protected function delay($sec = 10)
    {
        if ($sec > 0 && ($_SERVER['REMOTE_ADDR'] != '127.0.0.1' || sfconfig::get('sf_update_delay')))
        {
            sleep($sec);
        }
    }

    public function getFatalMessage()
    {
        sfLoader::loadHelpers('I18N');
        sfLoader::loadHelpers('Url');
        sfLoader::loadHelpers('stUpdate');

        $refresh_link = url_for('stInstallerWeb/rescueReboot', true);
        return __('Wystąpił błąd podczas aktualizacji oprogramowania', null, 'stSetup').' '.', '.__('ponowna próba aktualizacji nastąpi za 30 sekund', null, 'stSetup').'.';
    }

    public function generateCache() {
        $path = array('/', '/backend.php');
        $openKey = md5_file(SF_ROOT_DIR.'/config/databases.yml');

        foreach($path as $v) {
            $cUrl = curl_init();
            curl_setopt($cUrl, CURLOPT_URL, 'http://'.sfContext::getInstance()->getRequest()->getHost().$v.'?open-key='.$openKey);
            curl_setopt($cUrl, CURLOPT_RETURNTRANSFER, TRUE);
            $response = curl_exec($cUrl);
            curl_close($cUrl);
        }
        return true;
    }
}
