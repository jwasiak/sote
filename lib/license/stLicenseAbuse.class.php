<?php

class stLicenseAbuse {

    protected static function getVerificationCodePath($key) {
        return sfConfig::get('sf_root_dir').'/install/db/keys/'.$key.'.key';
    }

    public static function saveVerificationCode($verificationCode) {
        list($key, $code) = explode('-', $verificationCode);
        return file_put_contents(self::getVerificationCodePath($key), $code);
    }

    public static function getVerificationCode($key) {
        if (file_exists(self::getVerificationCodePath($key)))
            return file_get_contents(self::getVerificationCodePath($key));
        return false;
    }

    protected static function getLocksFilePath() {
        return SF_ROOT_DIR.'/install/db/locks.cache';
    }

    protected static function getLockStatus() {
        if (file_exists(self::getLocksFilePath())) {
            $content = file_get_contents(self::getLocksFilePath());
            if (!empty($content))
                return ($content);
        }
        return '';
    }

    public static function isOff() {
        $status = self::getLockStatus();
        
        if ($status == 'OFF') 
            return true;

        if (preg_match('/^BLOCK-/', $status)) {
            list($status, $time) = explode('-', $status);
            if (time() > $time + 604800)
                return true;
        }
        return false;
    }

    public static function isBlocked() {
        if (preg_match('/^BLOCK-/', self::getLockStatus()))
            return true;
        return false;
    }

    public static function getBlockedTime() {
        if(self::isBlocked()) {
            return preg_replace('/^BLOCK-/', '', self::getLockStatus());
        }
    }

    protected static function changeLockStatus($status) {
        switch ($status) {
            case 'NONE':
            case 'SUSPICION':
            case 'ABUSE':
                @unlink(self::getLocksFilePath());
                break;
            case 'OFF':
                stFastCacheManager::clearCache();
            default:
                file_put_contents(self::getLocksFilePath(), ($status));
                break;
        }
    }

    public static function checkLicenseAbuseStatus() {
        $status = stCommunication::getLicenseAbuseStatus();

        if ($status === 'BLOCK') {
            $time = stCommunication::getLicenseBlockedTime();            
            $status = $status.'-'.$time;
        }

        if (is_string($status))
            self::changeLockStatus($status);
        
        return true;
    }

    public static function checkLicenseAndDomain() {
        $response = stCommunication::checkLicenseAndDomain();

        if (is_string($response))
            self::saveVerificationCode($response);

        return true;
    }
} 
