<?php
/** 
 * SOTESHOP/stBase 
 * 
 * Ten plik należy do aplikacji stBase opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stBase
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stLimits.class.php 7 2009-08-24 08:59:30Z michal $
 * @author      Piotr Halas <piotr.halas@sote.pl>
 */
 
/** 
 * Definiecje błedów
 */
if (!defined('LIMITS_ERROR')) {
    define('LIMITS_ERROR',"Przekroczono dopuszczalną liczbę wpisów");
}

/** 
 * Klasa odpowiedzialana z limity w sklepie
 *
 * @package     stBase
 * @subpackage  libs
 */
class stLimits {

    /** 
     * Limity w sklepie
     * @var array
     */
    var $limits = array();

    /** 
     * Konstruktor klasy
     */
    public function __construct() {
        $this->limits = stLimits::loadConfig();
        $this->setLimits();
    }

    /** 
     * Ustawia limity w sklepie
     */
    private function setLimits() {
        foreach ($this->limits as $key =>$limit) {
            sfMixer::register('Base'.$key.':save:pre', array('stLimits', 'checkLimits'));
        }
    }

    /** 
     * Wczytuje konfiguracje limitow i zwraca ja w postaci tablicy
     *
     * @return   array
     */
    public static function loadConfig() {
        $configFilename = sfConfig::get('sf_config_dir').DIRECTORY_SEPARATOR.'limits.yml';
        if (is_readable($configFilename ))
        {
            $limits = Spyc::YAMLLoad($configFilename);
            if (isset($limits['limits'])) {
                $limits = $limits['limits'];
                return $limits;
            }
        }
        return array();
    }

    /** 
     * Zwraca limit dla danego modulu
     *
     * @param        string      $moduleName
     * @return   integer
     */
    public static function getLimit($moduleName = 'Product') {
        $limits = stLimits::loadConfig();
        if (isset($limits[$moduleName])) {
            
            $jsonLimit = stLimits::realLimit($limits[$moduleName]);
            $limitArray = json_decode($jsonLimit, true);

            if (!is_array($limitArray) || !isset($limitArray['limit']))
                return self::getStandardLimits();

            if (stLicenseExt::getShopId() != $limitArray['hash'])
                return self::getStandardLimits();

            return (is_numeric($limitArray['limit'])) ? $limitArray['limit'] : self::getStandardLimits();
        } else {
            return -1;
        }
    }

    public static function getStandardLimits() {
        if (stLicense::isOpen())
            return stLimits::realLimit('7741544d');
        else
            return stLimits::realLimit('3d41444d7741544d');
    }

    /** 
     * Sprawdza czy limit nie zostal przekroczony
     *
     * @param        object      $modelInstance
     * @param        object      $con
     */
    public static function checkLimits($modelInstance = null, $con = null) {
        if($modelInstance->isNew()) {
            $className = get_class($modelInstance);
            if (class_exists($className."Peer")) {
                $count = call_user_func_array($className."Peer::doCount",array(new Criteria()));
                $limit = stLimits::getLimit($className);
                if ($limit>0 && $count>=$limit) {
                    throw new Exception(LIMITS_ERROR);
                }
            }
        }
    }
    
    public static function realLimit($data = '') {
        $real = '';
        for ($i = 0; $i<mb_strlen($data); $i+=2) {
            $real=chr(hexdec(substr($data,$i,2))).$real;
        }
        
        return base64_decode($real); 
    }


    
}