<?php
/**
 * SOTESHOP/stUpdate
 *
 * Ten plik należy do aplikacji stUpdate opartej na licencji (Professional License SOTE).
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stUpdate
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id:  $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stWebStore
 * Zarządzanie instalacją pakietów z WebStore
 *
 * @package     stUpdate
 * @subpackage  libs
 */
class stWebStore
{
    private static $soteUrl = 'http://www.sote.pl/smWebStoreFrontend/soap';

    public static function getPackages($commercial = false) {
        try {
            $soapClient = new SoapClient(null, array('location' => self::$soteUrl, 'uri' => self::$soteUrl));
            $response = $soapClient->getPackagesList(sfContext::getInstance()->getUser()->getCulture(), $commercial);
        } catch (SoapFault $e) {
            $response = false;
        }

        return $response;
    }

    public static function getThemes() {
        try {
            $soapClient = new SoapClient(null, array('location' => self::$soteUrl, 'uri' => self::$soteUrl));
            $register = stConfig::getInstance(sfContext::getInstance(), 'stRegister');
            $response = $soapClient->getThemesListByLicense($register->get('license'), sfContext::getInstance()->getUser()->getCulture());
        } catch (SoapFault $e) {
            $response = false;
        }

        return $response;
    }

    public static function checkPackage($name, $code = null) {
        try {
            $soapClient = new SoapClient(null, array('location' => self::$soteUrl, 'uri' => self::$soteUrl));
            $register = stConfig::getInstance(sfContext::getInstance(), 'stRegister');
            $response = $soapClient->checkPackage($name, $code, $register->get('license'));
        } catch (SoapFault $e) {
            $response = false;
        }

        return $response;
    }

    public static function activatePackage($name, $code = null) {
        try {
            $soapClient = new SoapClient(null, array('location' => self::$soteUrl, 'uri' => self::$soteUrl));
            $register = stConfig::getInstance(sfContext::getInstance(), 'stRegister');
            $response = $soapClient->activatePackage($register->get('license'), $name, $code);

            $reg = array('active' => false, 'date' => time(), 'code' => $code);

            if ($code != null) $reg['active'] = true;

            try {
                $reg['type'] = $soapClient->getPackageType($name);
            } catch (SoapFault $e) {
                $reg['type'] = 1;
            }

            if ($reg['active'] == false) {
                $trialFile = sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'packages'.DIRECTORY_SEPARATOR.$name.DIRECTORY_SEPARATOR.'trial.yml';
                if (file_exists($trialFile)) {
                    $trialData = sfYaml::load($trialFile);
                    if (isset($trialData['days'])) {
                        $reg['trial'] = $trialData['days'];
                        $reg['time_expire'] = time() + $trialData['days'] * 24 * 60 * 60;
                    }
                }
            }

            $reg['md5sum'] = md5($reg['active'].$reg['date']);

            if (!file_exists(self::getApplicationRegPath($name))) file_put_contents(self::getApplicationRegPath($name), serialize($reg));
            else {
                if ($code != null) {
                    $data = unserialize(file_get_contents(self::getApplicationRegPath($name)));
                    $data['active'] = 1;
                    $data['code'] = $code;
                    $data['time_activated'] = time();
                    $data['md5sum'] = md5($data['active'].$data['date']);
                    file_put_contents(self::getApplicationRegPath($name), serialize($data));
                }
            }
        } catch (SoapFault $e) {
            $response = false;
        }
        return $response;
    }

    public static function getApplicationRegPath($name) {
        if (!file_exists(sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'db'.DIRECTORY_SEPARATOR.'.apps')) mkdir(sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'db'.DIRECTORY_SEPARATOR.'.apps');
        return sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'db'.DIRECTORY_SEPARATOR.'.apps'.DIRECTORY_SEPARATOR.$name.'.reg';
    }

    public static function isBlocked($name) {
        $file = self::getApplicationRegPath($name);
        if (!file_exists($file)) self::makeRegFile($name);
        $data = unserialize(file_get_contents($file));
        if (is_array($data) && $data['md5sum'] == md5($data['active'].$data['date'])) {
            if ($data['active'] == true) return false;
            elseif ($data['active'] == false && isset($data['time_expire']) && $data['time_expire'] > time()) return false;
            elseif ($data['active'] == false && $data['type'] == false) return false;
        }
        return true;
    }

    public static function getPackageInfo($name, $culture = null) {
        if (!file_exists(sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'db'.DIRECTORY_SEPARATOR.'.apps')) mkdir(sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'db'.DIRECTORY_SEPARATOR.'.apps');

        if ($culture == null) $culture = sfContext::getInstance()->getUser()->getCulture();
        $cacheFile = sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'db'.DIRECTORY_SEPARATOR.'.apps'.DIRECTORY_SEPARATOR.'package_'.$name.'_'.$culture.'.reg';
        if (file_exists($cacheFile) && filemtime($cacheFile) + 7*24*60*60 > time()) {
            return unserialize(file_get_contents($cacheFile));
        } else {
            if(file_exists($cacheFile)) unlink($cacheFile);
            try {
                $soapClient = new SoapClient(null, array('location' => self::$soteUrl, 'uri' => self::$soteUrl));
                $response = $soapClient->getPackageInfo($name, $culture);
                if (is_array($response)) {

                    if (file_exists($cacheFile)) unlink($cacheFile);
                    file_put_contents($cacheFile, serialize($response));
                    return $response;
                }
            } catch (SoapFault $e) {
                return false;
            }
        }
    }

    public static function increaseDownloadCount($package) {
        try {
            $soapClient = new SoapClient(null, array('location' => self::$soteUrl, 'uri' => self::$soteUrl));
            $response = $soapClient->increaseDownloadCount($package);
        } catch (SoapFault $e) {
        }
    }

    public static function makeRegFile($package) {
        $file = self::getApplicationRegPath($package);
        if (file_exists($file)) return true;

        $data = array('active' => false, 'date' => time(), 'code' => null, 'type' => false, 'md5sum' => null);

        try {
            $soapClient = new SoapClient(null, array('location' => self::$soteUrl, 'uri' => self::$soteUrl));
            $data['type'] = $soapClient->getPackageType($package);
        } catch (SoapFault $e) {
            $data['type'] = 1;
        }

        if ($data['type']) {
            $data['active'] = self::verifyPackage($package);
        }
        $data['md5sum'] = md5($data['active'].$data['date']);

        file_put_contents($file, serialize($data));
    }

    public static function updateType($name) {
        $filename = self::getApplicationRegPath($name);

        if(file_exists($filename)) {
            try {
                $soapClient = new SoapClient(null, array('location' => self::$soteUrl, 'uri' => self::$soteUrl));
                $soteType = $soapClient->getPackageType($name);
            } catch (SoapFault $e) {
                $soteType = 1;
            }

            $data = unserialize(file_get_contents($filename));
            if (is_array($data) && isset($data['type']) && $data['type'] != $soteType) {
                $data['type'] = $soteType;
                file_put_contents($filename, serialize($data));
            }
        } else {
            self::makeRegFile($name);
        }
    }

    public static function verifyPackage($package) {
        $register = stConfig::getInstance(sfContext::getInstance(), 'stRegister');
        try {
            $soapClient = new SoapClient(null, array('location' => self::$soteUrl, 'uri' => self::$soteUrl));
            $actived = $soapClient->verifyPackage($package, $register->get('license'));
        } catch (SoapFault $e) {
            $actived = 0;
        }
        return $actived;
    }
    
    public static function updateActive($package) {
        $filename = self::getApplicationRegPath($package);

        if(file_exists($filename)) {
            $actived = self::verifyPackage($package);
        
            $data = unserialize(file_get_contents($filename));
            if (is_array($data) && isset($data['active']) && $data['active'] != $actived) {
                $data['active'] = $actived;
                $data['md5sum'] = md5($data['active'].$data['date']);
                file_put_contents($filename, serialize($data));
            }
        } else {
            self::makeRegFile($package);
        }
        
    }
}