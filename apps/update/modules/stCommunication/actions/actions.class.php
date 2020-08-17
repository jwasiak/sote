<?php

class stCommunicationActions extends sfActions {

    public function executeSoap() {
        $this->setLayout(false);
        $server = new stCommunicationShopSoapServer();

        $s = new SoapServer(null, array('uri' => ''));
        $s->setObject($server);
        $s->handle();
    }

    public function executeCheck() {
        if ($this->getRequestParameter('forced', false))
            stCommunicationCache::disableCache();

        if (stLicenseAbuse::checkLicenseAbuseStatus()) {
            stLicenseAbuse::checkLicenseAndDomain();
        }

        if ($this->getRequestParameter('forced', false))
            stCommunicationCache::enableCache();

        exit('done');
    }

    public function executeCheckVersion() {
        stCommunicationCache::disableCache();
        stCommunication::getIsSeven();
        stCommunication::getUpgradeExpirationDate();
        stCommunicationCache::enableCache();

        stPear::runPearCommand('clear-cache');

        sfLoader::loadHelpers('stUpdate');

        exit(get_shop_version());
    }
}
