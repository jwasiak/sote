<?php
/**
 * SOTESHOP/stUpdate
 *
 * Ten plik należy do aplikacji stUpdate opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stUpdate
 * @subpackage  lib
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stSetupRequirements.class.php 9100 2010-11-05 11:43:30Z piotr $
 * @author      Piotr Halas <piotr.halas@sote.pl>
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stSetupRequirements do weryfikacji serwera i jego ustawień.
 *
 * @package     stUpdate
 * @subpackage  lib
 */
class stSetupRequirements
{ 
    /**
     * Lista testów do wykonania
     *
     * @var array
     */
    protected $tests = array(
        'testPHP' => 'Wersja PHP (5.6.x - 7.1.x)',
        'testSuPHP' => 'Skrypty uruchamiane z uprawnieniami użytkownika',
        'testSafeMode' => 'Tryb safe_mode wyłączony',
        'testCurl' => 'Biblioteka cURL',
        'testJsonEncode' => 'Biblioteka JSON',
        'testXsl' => 'Biblioteka XSL',
        'testGd' => 'Biblioteka GD2',
        'testSoap' => 'Obsługa Soap',
        'testMbstring' => 'Obsługa Mutlibyte String',
        'testMysql' => 'Obsługa MySQL',
        'testPdo' => 'Obsługa baz danych PDO (MySQL, SQLite)',
        'testSimpleXml' => 'Obsługa simpleXML',
        'testMemory' => 'Limit pamięci dla skryptu (128MB)',
        'testTime' => 'Czas wykonywania skryptu (30s)',
        'testMcrypt' => 'Biblioteka Mcrypt',
        'testTransSid' => 'Wyłączony session.use_trans_sid',
        'testZlib' => 'Biblioteka Zlib');

    /**
     * Statusy wykonanych testów
     *
     * @var array
     */
    protected $testStatus = array();

    protected $testWarnings = array();
    
    /**
     * Wykonanie wszyskich testów
     *
     * @return boolean
     */
    public function testAll($class = __CLASS__)
    {
        $this->testStatus = array();
        $allPass = true;

        foreach ($this->tests as $test => $name)
        {
            if (is_callable(array($class,$test)))
            {
                $value = call_user_func($class.'::'.$test);
                if (!$value) $allPass = false;
            } else {
                $value = false;
                $allPass = false;
            }
            $this->testStatus[$test] = $value;
            
            if (is_callable(array('stSetupRequirements',$test."Warning")))  $this->testWarnings[$test] = call_user_func('stSetupRequirements::'.$test."Warning");
            
        }
        return $allPass;
    }

    /**
     * Pobieranie statusów testów
     *
     * @return array
     */
    public function getTest()
    {
        if (count($this->testStatus) == 0) $this->testAll();
        return $this->testStatus;
    }

    /**
     * Pobieranie nazw testów
     *
     * @param string $name
     * @return boolean
     */
    public function getTestName($name = '') {
        if (isset($this->tests[$name])) return $this->tests[$name];
        return '';
    }

    /**
     * Sprawdzianie wersji PHP, dozwolne wersje to min 5.2.3 z wyłączeniem 5.2.4
     *
     * @return boolean
     */
    public static function testPHP()
    {
        $version = floatval(phpversion());
        return $version >= 5.6 && $version < 7.2;
    }

    /**
     * Sprawdzianie czy jest obsługiwane SuPHP, czyli PHP z prawami użytkownika
     *
     * @return boolean
     */
    public static function testSuPHP()
    {
        $filename = sfConfig::get('sf_cache_dir').DIRECTORY_SEPARATOR.'file.test';
        touch($filename);
        $apache_uid = fileowner($filename);
        $index_uid = fileowner(sfConfig::get('sf_web_dir').DIRECTORY_SEPARATOR.'update.php');
        unlink($filename);

        if ($apache_uid != $index_uid) return false;
        return true;
    }

    /**
     * Sprawdzanie biblioteki cURL
     *
     * @return boolean
     */
    public static function testCurl()
    {
        return function_exists('curl_init');
    }

    /**
     * Sprawdzanie czy jest wyłączony safe_mode
     *
     * @return boolean
     */
    public static function testSafeMode()
    {
        return !ini_get('safe_mode');
    }

    /**
     * Sprawdzanie biblioteki JSON
     *
     * @return boolean
     */
    public static function testJsonEncode()
    {
        return function_exists('json_encode');
    }
    /**
     * Sprawdzanie biblioteki SOAP
     *
     * @return boolean
     */
    public static function testSoap()
    {
        return class_exists('SoapClient');
    }

    /**
     * Sprawdzanie biblioteki GD
     *
     * @return boolean
     */
    public static function testGd()
    {
        if (!function_exists('gd_info')) return false;

        $support = gd_info();

        if (version_compare(PHP_VERSION, '5.3', '>='))
        {
            if (!$support['JPEG Support']) return false;
        } else {
            if (!$support['JPG Support']) return false;
        }
        if (!$support['PNG Support']) return false;
        if (!$support['FreeType Support']) return false;

        return true;
    }

    /**
     * Sprawdzanie biblioteki Mbstring - Mutlibyte String
     *
     * @return boolean
     */
    public static function testMbstring()
    {
        return function_exists('mb_check_encoding');
    }

    /**
     * Sprawdzanie biblioteki XSL
     *
     * @return boolean
     */
    public static function testXsl()
    {
        return class_exists('XSLTProcessor');
    }

    /**
     * Sprawdzanie biblioteki MySQL
     *
     * @return boolean
     */
    public static function testMysql() {
        return function_exists('mysqli_connect');
    }

    public static function testPdo() {
        if (class_exists('PDO')) {
            $drivers = PDO::getAvailableDrivers();
            if (in_array('mysql', $drivers) && in_array('sqlite', $drivers))
                return true;
        }
        return false;
    }

    /**
     * Sprawdzanie biblioteki SimpleXml
     *
     * @return boolean
     */
    public static function testSimpleXml() {
        return function_exists('simplexml_load_file');
    }

    /**
     * Sprawdzanie dostępnej pamięci, minimum 64MB
     *
     * @return boolean
     */
    public static function testMemory()
    {
        $memory = trim(ini_get('memory_limit'));
        $last = strtolower($memory[strlen($memory)-1]);
        $memory = intval($memory);

        switch ($last) {
            case 'g': $memory *= 1024;
            case 'm': $memory *= 1024;
            case 'k': $memory *= 1024;
        }

        return ($memory<pow(2,27))?false:true;
    }
    
//     public static function testMemoryWarning()
//     {
//         $memory = trim(ini_get('memory_limit'));
//         $last = strtolower($memory[strlen($memory)-1]);
//         switch ($last) {
//             case 'g': $memory *= 1024;
//             case 'm': $memory *= 1024;
//             case 'k': $memory *= 1024;
//         }
//         if ($memory>= pow(2,27) && $memory < pow(2,27)) return ini_get('memory_limit').'B'.sfContext::getInstance()->getI18n()->__(', zalecane <strong>128MB</strong>');
//         return false;  
//     }    
    
    /**
     * Sprawdzanie czasu wykonywania skryptu, minimum 30 sekund
     *
     * @return boolean
     */
    public static function testTime()
    {
        return (ini_get('max_execution_time')<30)?false:true;
    }
    
    public static function testTimeWarning()
    {
        if(ini_get('max_execution_time')>=30 && ini_get('max_execution_time')<60)return ini_get('max_execution_time').sfContext::getInstance()->getI18n()->__('s, zalecane <strong>60s</strong>');
        return false;
    }      
    
    /**
     * Sprawdzanie biblioteki Mcyprt
     *
     * @return boolean
     */
    public static function testMcrypt()
    {
        return function_exists('mcrypt_module_open');
    }

    /**
     * Sprawdzania session.use_trans_sid
     */
    public static function testTransSid()
    {
        return (ini_get('session.use_trans_sid')==0 || ini_get('session.use_trans_sid')=='Off')?true:false;
    }
    
    public static function testZlib()
    {
        return function_exists('gzopen');
    }
    
    public function getWarning($name)
    {
        if (!isset($this->testWarnings[$name])) return false;
        return $this->testWarnings[$name];      
    }   
}