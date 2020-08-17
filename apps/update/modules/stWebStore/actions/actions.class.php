<?php

class stWebStoreActions extends sfActions {
    
    public function preExecute()
    {
        $action = $this->getModuleName().'/'.$this->getActionName();

        if (!$this->getRequest()->isXmlHttpRequest() && !in_array($action, array('stInstallerWeb/news', 'stInstallerWeb/tools', 'stInstallerWeb/history', 'stInstallerWeb/verifyall')) && (!stCommunication::getUpgradeExpirationDate() || time() > stCommunication::getUpgradeExpirationDate() || stLicense::isOpen())) {
            return $this->redirect('@installerweb?action=news');
        }
    }

    public function executeIndex() {
        $this->applications = array();

        if ($this->hasFlash('notice')) $this->notice = $this->getFlash('notice');
        else $this->notice = '';

        $stRegisterSync = new stRegisterSync();
        $packages = stPearInfo::getOptPackages();
        foreach ($packages as $name => $description) {
            if (preg_match('/^app/', $name)) {
                stWebStore::updateType($name);
                $params = array('description' => $description, 'isActive' => !stWebStore::isBlocked($name), 'version' => $stRegisterSync->getPackageVersion($name));
                if (!$params['isActive']) $params['info'] = stWebStore::getPackageInfo($name);
                if (preg_match('/Theme(Plugin)?$/', $name)) $params['isActive'] = true;
                $this->applications[$name] = $params;
            }
        }
        ksort($this->applications);

        unset($this->applications['appAddPricePlugin']);
        unset($this->applications['appAdditionalDescPlugin']);
        unset($this->applications['appCategoryHorizontalPlugin']);
        unset($this->applications['appImageTagPlugin']);
        unset($this->applications['appOnlineCodesPlugin']);
        unset($this->applications['appProductAttributesPlugin']);

        $this->packages = stWebStore::getPackages();
        $tmp = $this->packages;
        foreach($tmp as $package => $params) {
            if (file_exists(sfConfig::get('sf_root_dir').'/install/src/.registry/.channel.pear.sote.pl/'.strtolower($package).'.reg')) unset($this->packages[$package]);
        }

        $this->themes = stWebStore::getThemes();
        $tmp = $this->themes;
        foreach($tmp as $theme => $params) {
            if (file_exists(sfConfig::get('sf_root_dir').'/install/src/.registry/.channel.pear.sote.pl/'.strtolower($theme).'.reg')) unset($this->themes[$theme]);
        }
    }

    public function executeInfo() {
        if ($this->getRequest()->hasParameter('package')) {
            $this->name = $this->getRequest()->getParameter('package');

            if (file_exists(sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'.registry'.DIRECTORY_SEPARATOR.'.channel.pear.sote.pl'.DIRECTORY_SEPARATOR.strtolower($this->name).'.reg')) $this->installed = true;
            else $this->installed = false;

            $this->blocked = preg_match('/Theme(Plugin)?$/', $this->name) ? false : stWebStore::isBlocked($this->name);

            $this->info = stWebStore::getPackageInfo($this->name);

        } else {
            $this->redirect('@homepage');
        }
    }

    public function executeActivate() {
        if ($this->getRequest()->hasParameter('package')) {
            $this->package = $this->getRequest()->getParameter('package');
            if ($this->getRequest()->hasParameter('code') && $this->getRequest()->getParameter('code') != '') {
                switch(stWebStore::checkPackage($this->package, $this->getRequest()->getParameter('code'))) {
                    case 0:
                        $this->error = 'Brak połączenia z serwerem sote.pl.';
                        return sfView::SUCCESS;
                    case 1:
                        break;
                    case 2:
                        $this->error = 'Nieprawidłowy kod aktywacji.';
                        return sfView::SUCCESS;
                    case 3:
                        $this->error = 'Kod aktywacji został już wykorzystany.';
                        return sfView::SUCCESS;
                }

                stWebStore::activatePackage($this->package, $this->getRequest()->getParameter('code'));
                $this->setFlash('notice', 'Pakiet został aktywowany.');
                return $this->redirect('stWebStore/index');

            } elseif($this->getRequest()->hasParameter('activate')) {
                $this->error = 'Nieprawidłowy kod aktywacji.';
                return sfView::SUCCESS;
            }
        } else {
            return $this->redirect('@homepage');
        }
    }
}
