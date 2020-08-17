<?php
/** 
 * SOTESHOP/stInstallerPlugin
 * 
 * Ten plik należy do aplikacji stInstallerPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stInstallerPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stLicenseInfo.class.php 3782 2010-03-05 13:39:42Z marek $
 * @author      Marek Jakubowicz <marek.jakubowicz@sote.pl>
 */  
                                         
/**
 * Komunikat dla skryptów serwera, że demo jest do usunięcia. Nie można go zmieniać!
 */
define("ST_LICENSE_EXPIRED",'[EXPIRED]');    

/**
 * Komunikat, że demo jest niaktywne ale nie do usunięcia.
 */                                                       
define ("ST_LICENSE_DISABLED",'[DISABLED]');

/**
 * Komunikat, że demo jest aktywne
 */                               
define ("ST_LICENSE_ACTIVE",'[ACTIVE]');  

/**
 * Komunikat o błędnej licencji
 */            
define ("ST_LICENSE_INVALID",'[INVALID]');

/**
 * Ilość dni od wygaśnięcia licencji, po których zmienia status na EXPIRED (do usunięcia).
 */
define ("ST_LICENSE_EXPIRE_LIMIT",7);                       

/**
 * stLicensenIstaller class
 */   
require_once ('install'.DIRECTORY_SEPARATOR.'installer'.DIRECTORY_SEPARATOR.'cli'.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'stLicenseInstaller.php');  

/**
 * Weryfikacja licencji.
 * @package stInstallerPlugin
 */                          
class stLicenseInfo extends stLicenseInstaller {
    
    /**
     * Klucz licencji
     *
     * @var string
     */
    protected $licenseKey = '071174180986080181986863209823MK';
     
    public function checkLicenseSign($license)
    {
        $license = $this->clearLicense($license);
        $licenseLenght = strlen($license);
        
        if ($licenseLenght != 24) return false;

        $licenseNoSign = substr($license, 0, $licenseLenght-8);
        $licenseSign = substr($license, $licenseLenght-8, 8);

        $code = md5($this->licenseKey.$licenseNoSign);
        $codeSign = substr($code, strlen($code)-8, 8);
        
        if ($codeSign == $licenseSign) return true;
        else return false;
    }
         
    protected function clearLicense($license)
    {
        return str_replace(array(" ", "-"), "", $license);
    }    
    
    protected function getLicenseCreateDate($license)
    {
        $license = $this->clearLicense($license);

        $year = substr($license, 0, 4);
        $month = substr($license, 4, 2);
        $day = substr($license, 6, 2);

        return mktime(0, 0, 0, $month, $day, $year);
    }
    
    protected function getLicenseDayLimit($license)
    {
        $license = $this->clearLicense($license);
        return substr($license, 8, 2);
    }
    
    /**
     * Sprawdzanie czy można usunąć demo.
     *
     * @param string $license                 
     * @param int    $limit ilość dni po przeterminowaniu licencji, po których sklep jest usuwany automatycznie
     * @return string  ST_LICENSE_EXPIRED ST_LICENSE_DISABLED ST_LICENSE_ACTIVE
     */
    public function getLicenseStatus($license,$limit=ST_LICENSE_EXPIRE_LIMIT)
    {    
        if (! $this->checkLicenseSign($license))
        {
            pake_echo ("License status: ".ST_LICENSE_INVALID);  
            return ST_LICENSE_INVALID;
        } 
                                                        
        $license = $this->clearLicense($license);

        $licenseCreateDate = $this->getLicenseCreateDate($license);
        $licenseDayLimit = $this->getLicenseDayLimit($license);

        if ($licenseDayLimit == 0) 
        {               
            pake_echo ("License status: ".ST_LICENSE_ACTIVE);  
            return ST_LICENSE_ACTIVE;            
        }

        $currentDate = mktime(0, 0, 0, date('n'), date('j'), date('Y'));
        $licenseLimitDateExp = $licenseCreateDate + (($licenseDayLimit+$limit)*24*60*60);
        $licenseLimitDate = $licenseCreateDate + (($licenseDayLimit)*24*60*60);

        if($currentDate > $licenseLimitDateExp) {  
            pake_echo ("License status: ".ST_LICENSE_EXPIRED);
            return ST_LICENSE_EXPIRED;
        }  elseif($currentDate > $licenseLimitDate)
        {                
            pake_echo ("License status: ".ST_LICENSE_DISABLED);   
            return ST_LICENSE_DISABLED;
        } else 
        {   
                                 
          pake_echo ("License status: ".ST_LICENSE_ACTIVE);
          return ST_LICENSE_ACTIVE;
          
        }
    }
}