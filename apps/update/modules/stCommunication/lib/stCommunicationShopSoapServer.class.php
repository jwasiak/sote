<?php

class stCommunicationShopSoapServer {

    public function getLicenseVerificationCode($shopId, $key) {
        if (stLicenseExt::getShopId() != $shopId) return -100;

        $code = stLicenseAbuse::getVerificationCode($key);
        if ($code)
            return $code;
        else
            return -50;
    }
    
    public function checkLicenseAbuseStatus($shopId) {
        if (stLicenseExt::getShopId() != $shopId) return -100;
        stCommunicationCache::disableCache();
        $ret = stLicenseAbuse::checkLicenseAbuseStatus();
        stCommunicationCache::enableCache();
        return $ret;
    }
}
