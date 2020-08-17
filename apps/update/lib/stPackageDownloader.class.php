<?php

class stPackageDownloader {

    protected $message = "";

    public function __construct() {
        $this->i18n = sfContext::getInstance()->getI18N();
    }

    public function getMessage() {
        return $this->message;
    }

    public function close() {
        $this->removePackages();

        $button = '<div style="float: right">
                        <ul style="float:right" class="st_admin-actions">
                            <li class="st_admin-action-add">
                                <div>
                                <div>
                                    <form method="post" class="button_to" action="/update'.((SF_ENVIRONMENT == 'dev') ? '_dev': '').'.php/installerweb/syncList">
                                        <div>
                                            <input style="background-image: url(/images/update/icons/add.png)" value="'.$this->i18n->__('Instaluj pobrane aktualizacje', null, 'stInstallerWeb').'" type="submit" />
                                        </div>
                                    </form>
                                </div>
                                </div>
                            </li>           
                        </ul>
                        <br class="st_clear_all" />                    
                    </div>';

        $this->message = $this->i18n->__('Aktualizaje zostały pobrane', null, 'stInstallerWeb').$button;
    }
    
    public static function getPackages() {
        $file = sfConfig::get('sf_root_dir').'/install/db/.download-packages.reg';

        if (file_exists($file)) {
            return json_decode(file_get_contents($file), true);
        } else
            return null;
    }

    public static function setPackages($packages) {
        file_put_contents(sfConfig::get('sf_root_dir').'/install/db/.download-packages.reg', json_encode($packages));
    }

    public static function removePackages() {
        $file = sfConfig::get('sf_root_dir').'/install/db/.download-packages.reg';
        if (file_exists($file))
            unlink($file);
    }

    public function initialize() {
        if ($this->getPackages() === null) {
            $upgradeType = $this->getUpgradeType();

            if (isset($upgradeType['type']) && $upgradeType['type'] == 'package')
                $dependencies = stPear::getDependencies(array($upgradeType['package'] => $upgradeType['version']));
            else
                $dependencies = stPear::getDependencies(stPear::getPackagesToUpgrade());

            if (!empty($dependencies))
                $this->setPackages($dependencies);
        }
    }

    public static function getSteps() {
        if (self::getPackages() === null) {
            $instance = new stPackageDownloader();
            $instance->initialize();
        }

        $packages = self::getPackages();
        if (is_array($packages))
            return count($packages)+1;

        return 0;
    }

    public function step($step = 0) {                   
        $package = $this->getPackageForStep();

        if ($package !== null) {
            list($package, $version) = $package;

            if ($step == 0) {
                $this->message = $this->i18n->__('Pobieranie', null, 'stInstallerWeb').': '.$package.' '.$version;
                return $step+1;
            }

            stPear::runPearCommand(array('command' => 'upgrade', 'parameters' => array(stPearInfo::getInstance()->getDefaultChannel().'/'.$package.'-'.$version), 'options' => array('nodeps' => true)), 'raw', true);
            
            if ($this->getNextPackage() !== null) {
                list($nextPackage, $nextVersion) = $this->getNextPackage();
                $this->message = $this->i18n->__('Pobieranie', null, 'stInstallerWeb').': '.$nextPackage.' '.$nextVersion;
            } else
                $this->message = $this->i18n->__('Kończenie pobierania plików', null, 'stInstallerWeb');

            $this->setInstalled($package);
        
            return $step+1;
        } else {
            return $this->getSteps();
        }
    }

    private function getPackageForStep() {
        foreach ($this->getPackages() as $package => $version)
            if ($version != "installed")
                return array($package, $version);
        return null;
    }

    private function getNextPackage() {
        $packageList = $this->getPackages();

        $next = false;
        foreach ($packageList as $package => $version) {
            if ($version != 'installed') {
                if ($next == true)
                    return array($package, $version);
                $next = true;
            }
        }
        return null;
    }

    public function setInstalled($package) {
        $packages = $this->getPackages();
        $packages[$package] = 'installed';
        $this->setPackages($packages);
    }

    public static function getUpgradeTypeFilePath() {
        return sfConfig::get('sf_root_dir').'/install/db/.upgrade-type.reg';
    }

    public static function setUpgradeType($type, $package = null, $version = null) {
        $file = self::getUpgradeTypeFilePath();

        if ($type == 'package' && ($package == null || $version == null))
            throw new Exception('Package and version must be set.');

        file_put_contents($file, json_encode(array('type' => $type, 'package' => $package, 'version' => $version)));
    }

    public static function getUpgradeType() {
        $file = self::getUpgradeTypeFilePath();
        if (file_exists($file)) {
            $content = json_decode(file_get_contents($file), true);
            unlink($file);
            return $content;
        }

        return null;
    }

    static public function unlockPackagesList() {
        $remove = true;
        $packages = self::getPackages();
        if (is_array($packages)) {
            foreach ($packages as $package => $version) {
                if ($version != 'installed')
                    $remove = false;
            }
            
            if ($remove)
                self::removePackages();
        }

        return null;
    }
}


class stSetupPackageDownloader extends stPackageDownloader {
    
    public function close() {
        $this->removePackages();
        $this->message = $this->i18n->__('Aplikacje zostały pobrane', null, 'stInstallerWeb')."<script type=\"text/javascript\">document.getElementById('stSetup-download_actions').style.visibility=\"visible\";</script>";
    }

    public function getTitle() {
        return $this->i18n->__('Pobieranie aplikacji', null, 'stInstallerWeb').': ';
    }

    public function getFatalMessage() {

        sfLoader::loadHelpers(array('Tag', 'Url', 'stUpdate'));
        
        return $this->i18n->__('Wystąpił błąd podczas pobierania oprogramowania', null, 'stSetup').' '.
               st_program_name().', '.
               $this->i18n->__('większość problemów można rozwiązać korzystając z', null, 'stSetup').
               ' <strong>'.
               link_to($this->i18n->__('podręcznika instalacji', null, 'stSetup'), $this->i18n->__('http://www.sote.pl/trac/wiki/doc/soteshop_installation', null, 'stSetup'), array('target' => '_blank')).
               '</strong>';
    }
}
