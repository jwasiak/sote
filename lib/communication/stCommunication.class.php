<?php 

class stCommunication {

    protected static $socketConnectionTime = null;

    protected static $hasValidLicense = null;

    protected static $getLicenseInfo = null;

    public static function getLicenseServer() {
        return 'http://www.sote.pl/smLicenseFrontend/soap';
    }

    protected static function getSoapClient($uri) {
        return new SoapClient(null, array('location' => $uri, 'uri' => $uri, 'connection_timeout' => 10));
    }

    public static function getLicenseAbuseStatus() {

        if (($cache = stCommunicationCache::processCache('getLicenseAbuseStatus', 43200)) !== stCommunicationCache::CACHE_NOT_FOUND)
            return $cache;
        self::forceSocketConnectionTime();
        try {
            $client = self::getSoapClient(self::getLicenseServer());
            $response = $client->getLicenseAbuseStatus(stLicenseExt::getShopId());
            stCommunicationCache::saveCache('getLicenseAbuseStatus', $response);
        } catch (SoapFault $e) {
            $response = 'CONNECTION_FAIL';
        }

        self::restoreSocketConnectionTime();

        return $response;
    }

    public static function getLicenseBlockedTime() {
        if (($cache = stCommunicationCache::processCache('getLicenseBlockedTime', 43200)) !== stCommunicationCache::CACHE_NOT_FOUND)
            return $cache;
        self::forceSocketConnectionTime();
        try {
            $client = self::getSoapClient(self::getLicenseServer());
            $response = $client->getLicenseBlockedTime(stLicenseExt::getShopId());
            stCommunicationCache::saveCache('getLicenseBlockedTime', $response);
        } catch (SoapFault $e) {
            $response = time();
        }

        self::restoreSocketConnectionTime();

        return $response;
    }

    public static function hasValidLicense($refresh = null)
    {
        if (null === self::$hasValidLicense || null !== $refresh)
        {
            $communication = stCommunication::getLicenseInfo($refresh);
        
            $iwt_till = $communication['support'];
        
            $upgrade_exp_date = $communication['guarantee'];
        
            $current_date = date("Y-m-d");

            self::$hasValidLicense = !($current_date > $iwt_till && $current_date > $upgrade_exp_date) || null === $upgrade_exp_date;  
        }

        return self::$hasValidLicense;
    }

    public static function blockSite($refresh = null)
    {
        $valid = self::hasValidLicense($refresh);

        $info = self::getLicenseInfo($refresh);

        $current = time();

        $guarantee = strtotime($info['guarantee'] .  ' 23:59:59');

        $elapsed = ($current - $guarantee) / 86400;
        
        return ($info['type'] == 'ROK' || $info['type'] == 'MIESIĄC') && !$valid && $elapsed >= 14;
    }

    public static function getLicenseInfo($refresh = null)
    {        
        if (null === self::$getLicenseInfo || null !== $refresh)
        {
            if (($cache = stCommunicationCache::processCache('getLicenseInfo', $refresh ? $refresh : 43200)) !== stCommunicationCache::CACHE_NOT_FOUND)
            {
                self::$getLicenseInfo = $cache;
            }
            else
            {
                self::forceSocketConnectionTime();
                
                try {
                    $client = self::getSoapClient(self::getLicenseServer());
                    $response = $client->getLicenseInfoByShopId(stLicenseExt::getShopId());
                    stCommunicationCache::saveCache('getLicenseInfo', $response);
                } catch (SoapFault $e) {
                    $response = 'CONNECTION_FAIL';
                }

                self::restoreSocketConnectionTime();

                self::$getLicenseInfo = $response;    
            }    
        }

        return self::$getLicenseInfo;
    }

    public static function checkLicenseAndDomain() {
        if (($cache = stCommunicationCache::processCache('checkLicenseAndDomain', 86400*3, $_SERVER["HTTP_HOST"])) !== stCommunicationCache::CACHE_NOT_FOUND)
            return $cache;

        try {
            $client = self::getSoapClient(self::getLicenseServer());
            $response = $client->checkLicenseAndDomain(stLicenseExt::getShopId(), $_SERVER["HTTP_HOST"]);
            stCommunicationCache::saveCache('checkLicenseAndDomain', $response, $_SERVER["HTTP_HOST"]);
        } catch (SoapFault $e) {
            $response = 'CONNECTION_FAIL';
        }

        self::restoreSocketConnectionTime();

        return $response;
    }

    public static function getSupportExpirationDate() {
        return  self::getLicenseInfo();
    }

    public static function getUpgradeExpirationDate($shopId = NULL, $refresh = null) {
        if (($cache = stCommunicationCache::processCache('getUpgradeExpirationDate', $refresh ? $refresh : 86400)) !== stCommunicationCache::CACHE_NOT_FOUND)
            return $cache;
        self::forceSocketConnectionTime();
        try {
            $client = self::getSoapClient(self::getLicenseServer());
            $response = $client->getUpgradeDateByShopId(($shopId ? $shopId : stLicenseExt::getShopId()));
            stCommunicationCache::saveCache('getUpgradeExpirationDate', $response);
        } catch (SoapFault $e) {
            $response = false;
        }

        self::restoreSocketConnectionTime();

        return $response;
    }

    public static function getIsSeven($shopId = NULL) {        
        if (SF_APP == 'frontend')
        {
            return true;
        }
        
        self::forceSocketConnectionTime();

        if (($cache = stCommunicationCache::processCache('isSeven', 86400)) !== stCommunicationCache::CACHE_NOT_FOUND)
            return $cache;

        try {
            $client = self::getSoapClient(self::getLicenseServer());
            $response = $client->isSeven(($shopId ? $shopId : stLicenseExt::getShopId()));
            stCommunicationCache::saveCache('isSeven', $response);
        } catch (SoapFault $e) {
            $response = false;
        }

        self::restoreSocketConnectionTime();

        return $response;
    }

    public static function forceSocketConnectionTime()
    {
        self::$socketConnectionTime = ini_get('default_socket_timeout');

        ini_set('default_socket_timeout', 10);
    }

    public static function restoreSocketConnectionTime()
    {
        if (null !== self::$socketConnectionTime)
        {
            ini_set('default_socket_timeout', self::$socketConnectionTime );
        }
    }
}
