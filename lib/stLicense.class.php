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
 * @version     $Id: stLicense.class.php 613 2009-04-09 12:34:35Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stLicense
 * Sprawdzanie numeru i daty ważności licencji
 *
 * @package     stUpdate
 * @subpackage  libs
 */
class stLicense
{
    /**
     * Komercyjny klucz licencji
     * @var string
     */
    private $commercialLicenseKey = '071174180986080181986863209823MK';

    /**
     * Otwarty klucz licencji
     * @var string
     */
    private $openLicenseKey = null;

    /**
     * Numer licencji
     * @var string
     */
    private $license = null;

    /**
     * Typ licencji
     * @var int
     */
    static private $licenseType = null;

    /**
     * Niepoprawny typ licencji
     * @var int
     */
    const LICENSE_TYPE_INVALID = 0;

    /**
     * Otwarty typ licencji
     * @var int
     */
    const LICENSE_TYPE_OPEN = 1;

    /**
     * Komercyjny typ licencji
     * @var int
     */
    const LICENSE_TYPE_COMMERCIAL = 2;

    /**
     * Flaga, czy licencja była sprawdzana
     * @var bool
     */
    private $checked = false;

    /**
     * Adres serwera licencji
     * @var string
     */
    private $soteUrl = 'http://www.sote.pl/smLicenseFrontend/soap';

    /**
     * Konstruktor
     *
     * @param string $license numer licencji
     */
    public function __construct($license = null)
    {
        if (!is_null($license)) $this->license = str_replace(' ', '', trim($license));
        else $this->license = stConfig::getInstance('stRegister')->get('license');
    }

    /**
     * Ustawianie numeru licencji
     *
     * @param string $license
     */
    public function setLicense($license)
    {
        $this->license = str_replace(' ', '', trim($license));
    }

    /**
     * Pobieranie numeru licencji
     *
     * @return string
     */
    public function getLicense()
    {
        return $this->license;
    }

    /**
     * Pobieranie typu licencji
     *
     * @return bool
     */
    public function getType()
    {
        if (strlen($this->license) == 29)
        {
            $license = str_replace('-', '', $this->license);

            $licenseNoSing = substr($license, 0, strlen($license)-8);
            $licenseSing = substr($license, strlen($license)-8, 8);

            $code = md5($this->commercialLicenseKey.$licenseNoSing);
            $codeSing = substr($code, strlen($code)-8, 8);

            if ($codeSing == $licenseSing) return self::$licenseType = self::LICENSE_TYPE_COMMERCIAL;

            $code = md5($this->openLicenseKey.$licenseNoSing);
            $codeSing = substr($code, strlen($code)-8, 8);

            if ($codeSing == $licenseSing) {
                if (stSoteshopVersion::getVersion() == stSoteshopVersion::ST_SOTESHOP_VERSION_INTERNATIONAL) return self::$licenseType = self::LICENSE_TYPE_COMMERCIAL;
                return self::$licenseType = self::LICENSE_TYPE_OPEN;
            }
        }

        return self::$licenseType = self::LICENSE_TYPE_INVALID;
    }

    /**
     * Sprawdzanie czy licencja jest open
     */
    public static function isOpen() {
        if (is_null(self::$licenseType)) {
            $stLicense = new stLicense(stConfig::getInstance(sfContext::getInstance(), 'stRegister')->get('license'));
            $stLicense->getType();
        }

        if (self::$licenseType == self::LICENSE_TYPE_OPEN && !self::isOpenModulesUnlocked()) return true;
        return false;
    }

    /**
     * Sprawdzanie czy licencja jest komercyjna
     */
    public static function isCommercial()
    {
        if (is_null(self::$licenseType))
        {
            $stLicense = new stLicense(stConfig::getInstance(sfContext::getInstance(), 'stRegister')->get('license'));
            $stLicense->getType();
        }

        if (self::$licenseType == stLicense::LICENSE_TYPE_COMMERCIAL) return true;
        return false;
    }

    /**
     * Weryfikacja numeru licencji
     *
     * @param string $license
     * @return bool
     */
    public function check()
    {
        $this->checked = true;

        if (is_null(self::$licenseType)) $this->getType();

        if (self::$licenseType == self::LICENSE_TYPE_OPEN || self::$licenseType == self::LICENSE_TYPE_COMMERCIAL)
        {
            if($this->checkLicenseDate()) return true;
        }

        return false;
    }

    /**
     * Weryfikacja licencji w bazie sote.pl
     *
     * @return bool
     */
    public function checkInSote()
    {
        if ($this->checked !== true) $this->check();

        try {
            $soapClient = new SoapClient(null, array('location' => $this->soteUrl, 'uri' => $this->soteUrl));
            $response = $soapClient->checkInstallation($this->license);
        } catch (SoapFault $e) {
            $response = false;
        }

        return $response;
    }

    /**
     * Aktywacja licencji w bazie sote.pl
     *
     * @return bool
     */
    public function activateInSote()
    {
        $stWebRequest = new stWebRequest();
        $config = stConfig::getInstance(sfContext::getInstance(), 'stRegister');
        $register = array();
        $register['company'] = $config->get('company');
        $register['vatNumber'] = $config->get('vatNumber');
        $register['email'] = $config->get('email');
        $register['name'] = $config->get('name');
        $register['surname'] = $config->get('surname');
        $register['street'] = $config->get('street');
        $register['house'] = $config->get('house');
        $register['flat'] = $config->get('flat');
        $register['code'] = $config->get('code');
        $register['town'] = $config->get('town');
        $register['phone'] = $config->get('phone');
        $register['www'] = $config->get('www');
        $register['ip_server'] = $stWebRequest->getServerAddress();
        $register['ip_client'] = $stWebRequest->getRemoteAddress();
        $register['state'] = stDevelState::isBeta() ? 'beta' : 'stable';
        $register['lang'] = sfContext::getInstance()->getUser()->getCulture();
        $register['installer'] = stSoteshopVersion::getVersion();

        try {
            $soapClient = new SoapClient(null, array('location' => $this->soteUrl, 'uri' => $this->soteUrl));
            $response = $soapClient->updateInstallation($this->license, $register);
        } catch (SoapFault $e) {
            $response = false;
        }

        return $response;
    }

    /**
     * Weryfikacja licencji w bazie sote.pl
     *
     * @return bool
     */
    public function startInSote()
    {
        if ($this->checked !== true) $this->check();

        try {
            $soapClient = new SoapClient(null, array('location' => $this->soteUrl, 'uri' => $this->soteUrl));
            $response = $soapClient->startInstallation($this->license, array('lang' => sfContext::getInstance()->getUser()->getCulture(), 'installer' => stSoteshopVersion::getVersion()));
        } catch (SoapFault $e) {
            $response = false;
        }

        return $response;
    }

    /**
     * Pobieranie ilości dni do wygaśnięcia licencji
     *
     * @param string $license
     * @return integer liczba dni, w przypadku gdy licencja nieograniczona zwraca -1
     */
    public function getLicenseExpirationDays()
    {
        $licenseCreateDate = $this->getLicenseCreateDate();
        $licenseDayLimit = $this->getLicenseDayLimit();

        if ($licenseDayLimit == 0) return -1;

        $currentDate = mktime(0, 0, 0, date('n'), date('j'), date('Y'));
        $licenseLimitDate = $licenseCreateDate + ($licenseDayLimit*24*60*60);

        return ceil(($licenseLimitDate - $currentDate)/(24*60*60));
    }

    /**
     * Pobieranie daty wygenerowania licencji w timestamp
     *
     * @param string $license
     * @return integer
     */
    public function getLicenseCreateDate()
    {
        return mktime(0, 0, 0, substr($this->license, 5, 2), substr($this->license, 7, 2), substr($this->license, 0, 4));
    }

    /**
     * Sprawdzanie ważności licencji
     *
     * @param string $license
     * @return bool
     */
    public function checkLicenseDate()
    {
        $licenseCreateDate = $this->getLicenseCreateDate();
        $licenseDayLimit = $this->getLicenseDayLimit();

        if ($licenseDayLimit == 0) return true;

        $currentDate = mktime(0, 0, 0, date('n'), date('j'), date('Y'));
        $licenseLimitDate = $licenseCreateDate + ($licenseDayLimit*24*60*60);

        if($currentDate < $licenseLimitDate) return true;
        return false;
    }

    /**
     * Pobieranie ważności licencji w dniach
     *
     * @param string $license
     * @return integer
     */
    public function getLicenseDayLimit()
    {
        return substr($this->license, 10, 2);
    }

    /**
     * Alias do getLicenseCreateDate
     *
     * @deprecated 5.1.0
     *
     * @return int
     */
    public function checkLicenseCreateDate()
    {
        return $this->getLicenseCreateDate();
    }

    /**
     * Alias do checkLicenseDateUse
     *
     * @deprecated 5.1.0
     *
     * @return bool
     */
    public function checkLicenseDateUse()
    {
        return $this->checkLicenseDate();
    }

    /**
     * Alias do check
     *
     * @deprecated 5.1.0
     *
     * @param $license numer licencji sklepu
     * @return bool
     */
    public function checkLicense($license)
    {
        $this->setLicense($license);
        return $this->check();
    }

    public function getLicenseByEmail($email) {

        return false;
    }

    public function getLicenseInfo($force = false) {
        $cacheFile = sfConfig::get('sf_root_dir').'/install/db/.license_info';

        if ($force && file_exists($cacheFile)) unlink($cacheFile);

        if (file_exists($cacheFile) && filemtime($cacheFile) + 86400 > time()) {
            return unserialize(base64_decode(file_get_contents($cacheFile)));
        }

        if ($this->checked !== true) $this->check();

        try {
        	if (empty($this->license)) return false;
        	
            $soapClient = new SoapClient(null, array('location' => $this->soteUrl, 'uri' => $this->soteUrl));
            $response = $soapClient->getLicenseInfo($this->license);
            file_put_contents($cacheFile, base64_encode(serialize($response)));
        } catch (SoapFault $e) {
            $response = false;
        }

        if(file_exists($cacheFile))
            return unserialize(base64_decode(file_get_contents($cacheFile)));

        return $response;
    }

    public static function isOpenModulesUnlocked() {
        $c = stConfig::getInstance('stOpenUnlock');
        foreach ($c->get('unlock', array()) as $k => $v) {
            $cr = stConfig::getInstance('stRegister');
            if ($cr->get('open_'.$k, null) == sha1($cr->get('license').$v)) {
                if (in_array(sfContext::getInstance()->getModuleName(), unserialize(base64_decode($v)))) return true;
            }
        }
        return false;
    }
    
    /**
     * @deprecated 7.0.0
     */
    public static function hasSupport() {
        if (SF_APP == 'frontend')
        {
            return true;
        }


        if(self::isOpen())
            return false;

    	if (SF_APP == 'frontend' && 
    		stCommunicationCache::processCache('getSupportExpirationDate') == stCommunicationCache::CACHE_NOT_FOUND &&
    		stCommunicationCache::processCache('isSeven') == stCommunicationCache::CACHE_NOT_FOUND
    		)
    		return true;
    	
    	if (stCommunication::getIsSeven())
    		return true;
    	
    	$support = stCommunication::getSupportExpirationDate();
    	if (strtotime($support['support'].' 23:59:59') >= date('U'))
    		return true;
    	
    	return false;
    }
}
