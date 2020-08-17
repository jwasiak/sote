<?php
class stUpdateGadgetActions extends stGadgetActions {

    public function executeUpdate() {

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

        if ($upgradeServiceTime !== FALSE) {
            if(time() > $upgradeServiceTime) {
                $this->status = 'UPGRADE_SERVICE_NOT_ACTIVE';
                $this->upgradeServiceTime = date('d.m.Y', $upgradeServiceTime);
            }
        } else
            $this->status = 'SOTE_CONNECTION_ERROR';
    }

    protected function checkPackageRegFile() {
        $file = sfConfig::get('sf_root_dir').'install/db/.packages.reg';
        if(file_exists($file)) {
            $packages = unserialize(file_get_contents($file));

            if (empty($packages))
                $unlink = true;
            else {
                $unlink = true;
                foreach ($packages as $package => $status)
                    if ($status != 'installed')
                        $unlink = false;
            }

            if ($unlink)
                unlink($file);

            return $unlink;
        }
        return true;
    }
}
