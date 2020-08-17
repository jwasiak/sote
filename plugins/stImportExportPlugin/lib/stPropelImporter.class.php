<?php
/**
 * SOTESHOP/stImportExportPlugin
 *
 * Ten plik należy do aplikacji stImportExportPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE.
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stImportExportPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stPropelImporter.class.php 13384 2011-06-02 11:30:57Z piotr $
 * @author      Piotr Halas <piotr.halas@sote.pl>
 */

/**
 * Definicje bledow importu
 */
define( "IMPORT_NO_CONFIG",  "Plik configuracyjny exportu nie istnieje." );
define( "IMPORT_NO_FILE",  "Plik z danymi nie istnieje lub nie można go doczytać." );

/**
 * Klasa obslugi import danych
 *
 * @package     stImportExportPlugin
 * @subpackage  libs
 */
class stPropelImporter
{

    /**
     * kolejnosc danych w pliku
     * @var array
     */
    var $header_order = array();

    /**
     * Sciezka do pliku z danymi
     * @var string
     */
    var $file = '';

    /**
     * Nazwa modelu podstawowego
     * @var string
     */
    var $model = '';

    /**
     * Konfiguracja modulu
     * @var array
     */
    var $config = array();

    /**
     * Limit danych ekportowanych/importowanych danych
     * @var integer
     */
    var $limit = 5;

    var $hard_limit = null;

    /**
     * uchwyt pliku z danymi
     * @var handle
     */
    var $file_handle = null;

    /**
     * Unikatowa nazwa konvertera
     * @var string
     */
    var $converter = '';

    var $culture = null;

    protected static $current_data = array();

    protected static $current_key = '';

    protected $logger = null;
    /**
     * Konstruktor klasy, jako paramtry nalezy podac model bazowy,
     * liste pol do eksportu/importu, w przypadku importu danych
     * nalezy podac dodatkowo nazwe pliku
     *
     * @param        string      $model
     * @param         array       $fields
     * @param        string      file
     */
    public function __construct($model = '', $fields = array(), $file = '')
    {
        $this->file = $file;
        $this->model = $model;
        $this->config = $fields;
        $this->culture = stLanguage::getOptLanguage();
        $this->logger = new stImportExportLog(sfConfig::get('sf_log_dir').DIRECTORY_SEPARATOR.'import_'.$model.'.log');
    }

    public function setCulture($culture)
    {
        $this->culture = $culture;
    }

    /**
     * glowna petla importu, dane przetwarzane sa od offsetu
     * zwraca kolejny offset
     *
     * @param       integer     $offset
     * @return   integer
     */
    public function doProcess($offset = 0)
    {
        // odczytaj plik
        $this->loadFile();

        // wczytaj plik
        $this->readHeader();

        //odczytaj wiersz naglowka
        $this->readHeaderRow();

        //pomin wczesniej odczytane dane
        $this->skipToData($offset);

        // odczytaj dane
        $this->readData();

        // zwroc aktualny offset
        return $this->getOffset();
    }

    /**
     * zwraca libcze krokow potrzebnych do odczytania calego pliku
     *
     * @return   integer
     */
    public function getDataCount()
    {
        return 0;
    }

    /**
     * Odczytuje naglowek pliu, zwraca true w przypadku powowdzeni,
     * false w przypadku bledu
     *
     * @return   boolean
     */
    protected function readHeader()
    {
        return true;
    }

    /**
     * Odczytuje wiersz naglowka , zwraca true w przypadku powowdzeni,
     * false w przypadku bledu
     *
     * @return   boolean
     */
    protected function readHeaderRow()
    {
        return true;
    }

    /**
     * odczytuje jeden wiersz/blok danych, zwraca true jezeli operacja
     * zakonczyla sie powodzeniem
     *
     * @return   boolean
     */
    protected function readRow()
    {
        return true;
    }

    /**
     * Zwraca aktualne polozenie w pliku, potrzebne do wykonania
     * kolejnego kroku importu
     *
     * @return   integer
     */
    protected function getOffset()
    {
        return 1;
    }

    /**
     * Pobiera aktualnie dodawany obiekt z wykorzytaniem klucza
     *
     * @param        string      $key_value
     * @return   object
     */
    protected function getObject($key_value = '', $culture = '')
    {
        if (empty($culture)) $culter = $this->culture;
        
        // wyszukaj obiekt spełniający podane kryteria
        $c = new Criteria();
        $c->add(constant("{$this->model}Peer::".strtoupper($this->config['primary_key'])),$key_value);
        $object = call_user_func($this->model.'Peer::doSelectOne',$c);

        // jezeli nie znaleziono takiego obiektu to go stwórz
        if (!$object)
        {
            $object = new $this->model;
        }

        if (method_exists($object,'setCulture'))
        {
            $object->setCulture($culture);
        }

        return $object;
    }

    /**$root
     * Wykonuje import danych do bazy
     *
     * @param     array
     */
    protected function processData($data = array())
    {

        // set logger current key;
        $this->logger->setCurrentKey(@$data[$this->config['primary_key']]);

        try
        {
            stPropelImporter::$current_data = $data = $this->validateData($data);
        } catch (Exception $e)
        {
            $this->logger->add($data[$this->config['primary_key']], $e->getMessage(), stImportExportLog::$FATAL);
        }
        // sprawdza czy podano klucz po ktorym zosanie wyszukany rekord do aktualizacji
        if (isset($data[$this->config['primary_key']]))
        {

            // znajduje lub tworzy odpowiedni wpis
            try
            {
                $object = $this->getObject($data[$this->config['primary_key']],$this->culture);
                if ($object->isNew() && !$this->testRequirements($data))
                {
                    $this->logger->add($data[$this->config['primary_key']], sfContext::getInstance()->getI18n()->__('Nie można dodać produktu, brak wymaganych pól',array(),'stImportExportBackend'), stImportExportLog::$WARNING);
                    return false;
                }
            } catch (Exception $e)
            {
                $this->logger->add($data[$this->config['primary_key']], $e->getMessage(), stImportExportLog::$FATAL);
            }
            // jezeli ustawiono status usuniecia nie aktualizuj i usun objekt
            if (isset($data['import_status']) && mb_strtolower($data['import_status'],'utf-8') == 'd')
            {
                if (!$object->isNew())
                {
                    $object->delete();
                }
            } 
            else
            {
                $changed  = array();
                $md5hash = ExportMd5HashPeer::retrieveByModelId($object->getId(), $this->model);
                // Uzupelnia dane dla obiektu na podstawie modelu
                foreach ($this->config['fields'] as $func_name => $Peer)
                {
                    // jezeli dane nie sa ustawione, przypisz domyslne
                    if (!isset($data[$func_name]) && isset($this->config['fields'][$func_name]['default']))
                    {
                        $data[$func_name] = $this->config['fields'][$func_name]['default'];
                    }
                    // jezeli informacja wystepuje w danych zapisuje ja w obiekcie
                    if (isset($data[$func_name]))
                    {   
                        $changed[$func_name] = isset($Peer['md5hash']) && $Peer['md5hash'] ? !$md5hash->runDataHashCheck($func_name, $data[$func_name], true) : true;

                        if ($changed[$func_name])
                        {
                            // pobiera rzeczywista nazwe funkcji odpowiedzialnej ustawienie danych
                            $real_func_name = 'set'. sfInflector::camelize($func_name);
                            if (isset($Peer['method'])) $real_func_name = $Peer['method'];

                            // jezeli metoda istnieje zostanie ona wykonana
                            if (!isset($Peer['class']))
                            {
                                try
                                {
                                    $object->$real_func_name($data[$func_name], $this->logger);

                                } catch (Exception $e)
                                {
                                    $this->logger->add($data[$this->config['primary_key']], $e->getMessage(), stImportExportLog::$FATAL);
                                    $md5hash->restoreMd5Hash($func_name);
                                }
                            }
                        }
                    }
                }
                // zapisuje wartosci
                try
                {
                    $object->save();
                } catch (Exception $e)
                {
                    $this->logger->add($data[$this->config['primary_key']], $e->getMessage(), stImportExportLog::$FATAL);
                    return false;
                }

                // Uzupelnia dane z zewnetrznych modeli
                foreach ($this->config['fields'] as $func_name => $Peer)
                {

                    // jezeli informacja wystepuje w danych wykonuje odpowiednia funkcje
                    if (isset($data[$func_name]) && $changed[$func_name])
                    {

                        // pobiera rzeczywista nazwe funkcji odpowiedzialnej ustawienie danych
                        $real_func_name = 'set'. sfInflector::camelize($func_name);
                        if (isset($Peer['method'])) $real_func_name = $Peer['method'];



                        // jezeli metoda istnieje zostanie ona wykonana
                        if (isset($Peer['class']))
                        {
                            $Peer = $Peer['class'];
                        }
                        else
                        {
                            $Peer = $this->config['default_class'];
                        }

                        if (is_callable($Peer.'::'.$real_func_name))
                        {
                            try
                            {
                                call_user_func($Peer.'::'.$real_func_name, $object, $data[$func_name],$this->logger, $data);
                            } catch (Exception $e)
                            {
                                $this->logger->add($data[$this->config['primary_key']], $e->getMessage(), stImportExportLog::$FATAL);
                                $md5hash->restoreMd5Hash($func_name);
                            }
                        }
                    }
                }

                try
                {
                    stEventDispatcher::getInstance()->notify(new sfEvent($this, 'stImportExport.Import_'.$this->model, array('modelInstance'=>$object)));

                    if (isset($this->config['default_class']) && is_callable($this->config['default_class'].'::preSave'))
                    {
                        call_user_func($this->config['default_class'].'::preSave', $object, $this->logger);
                    }

                    $object->save();
                    if ($md5hash->isNew())
                    {
                        $md5hash->setId($object->getId());
                    }
                    if ($md5hash->isColumnModified(ExportMd5HashPeer::MD5HASH))
                    {
                        $md5hash->save();
                    }
                } catch (Exception $e)
                {
                    $this->logger->add($data[$this->config['primary_key']], $e->getMessage(), stImportExportLog::$FATAL);
                }
            }
        } else
        {
            $this->logger->add($this->config['primary_key'], sfContext::getInstance()->getI18n()->__('Brak wymaganego pola %s% lub jego wartość jest niepoprawna.',array('%s%'=>$this->getUserName($this->config['primary_key'])), 'stImportExportBackend'), stImportExportLog::$WARNING);
        }
    }

    public function testRequirements($data)
    {
        $ret = true;
        foreach ($this->config['fields'] as $func_name => $Peer)
        {
            if (isset($Peer['require']) && (!isset($data[$func_name]) || !strlen(trim($data[$func_name]))))
            {
                $this->logger->add($data[$this->config['primary_key']], sfContext::getInstance()->getI18n()->__('Brak wymaganego pola: %s%', array('%s%'=>$this->getUserName($func_name)), 'stImportExportBackend'), stImportExportLog::$WARNING);
                $ret = false;
            }
        }
        return $ret;
    }

    public function validateData($inData)
    {
        $data = $inData;
        foreach ($this->config['fields'] as $func_name => $Peer)
        {
            if (isset($inData[$func_name]))
            {
                $type = isset($Peer['type'])?$Peer['type']:'string';
                switch ($type)
                {
                    case "string":
                        if (!is_string($data[$func_name]))
                        {
                            $this->logger->add($inData[$this->config['primary_key']], sfContext::getInstance()->getI18n()->__('Niepoprawna wartość pola ', array(), 'stImportExportBackend').$this->getUserName($func_name).', "'.$inData[$func_name].'" '.sfContext::getInstance()->getI18n()->__('nie jest ciągiem znaków', array(), 'stImportExportBackend'), stImportExportLog::$NOTICE);
                            unset($data[$func_name]);
                        }
                        break;
                    case "double":
                        if (((!preg_match('/^-?\d+(\.\d+)?$/', $data[$func_name])) || substr_count($data[$func_name], '.') != 1) &&((!preg_match('/^-?\d+(\.\d+)?$/', $data[$func_name])) || ((float) $data[$func_name] != (int) $data[$func_name])))
                        {
                            $this->logger->add($inData[$this->config['primary_key']], sfContext::getInstance()->getI18n()->__('Niepoprawna wartość pola ', array(), 'stImportExportBackend').$this->getUserName($func_name).', "'.$inData[$func_name].'" '.sfContext::getInstance()->getI18n()->__('nie jest liczbą', array(), 'stImportExportBackend'), stImportExportLog::$NOTICE);
                            unset($data[$func_name]);
                        }
                        break;
                    case "bool":
                        if (!is_numeric($data[$func_name]) && !$data[$func_name] != 0 && !$data[$func_name] != 1)
                        {
                            $this->logger->add($inData[$this->config['primary_key']], sfContext::getInstance()->getI18n()->__('Niepoprawna wartość pola ', array(), 'stImportExportBackend').$this->getUserName($func_name).', "'.$inData[$func_name].'" '.sfContext::getInstance()->getI18n()->__('nie jest 1 lub 0', array(), 'stImportExportBackend'), stImportExportLog::$NOTICE);
                            unset($data[$func_name]);
                        }
                        break;
                    case "boolean":
                        if (!is_numeric($data[$func_name]) && !$data[$func_name] != 0 && !$data[$func_name] != 1)
                        {
                            $this->logger->add($inData[$this->config['primary_key']], sfContext::getInstance()->getI18n()->__('Niepoprawna wartość pola ', array(), 'stImportExportBackend').$this->getUserName($func_name).', "'.$inData[$func_name].'" '.sfContext::getInstance()->getI18n()->__('nie jest 1 lub 0', array(), 'stImportExportBackend'), stImportExportLog::$NOTICE);
                            unset($data[$func_name]);
                        }
                        break;
                    case "int":
                        if ((!preg_match('/^-?\d+(\.\d+)?$/', $data[$func_name])) || ((float) $data[$func_name] != (int) $data[$func_name]))
                        {
                            $this->logger->add($inData[$this->config['primary_key']], sfContext::getInstance()->getI18n()->__('Niepoprawna wartość pola ', array(), 'stImportExportBackend').$this->getUserName($func_name).', "'.$inData[$func_name].'" '.sfContext::getInstance()->getI18n()->__('nie jest liczbą całkowitą', array(), 'stImportExportBackend'), stImportExportLog::$NOTICE);
                            unset($data[$func_name]);
                        }
                        break;
                    case "integer":
                        if ((!preg_match('/^-?\d+(\.\d+)?$/', $data[$func_name])) || ((float) $data[$func_name] != (int) $data[$func_name]))
                        {
                            $this->logger->add($inData[$this->config['primary_key']], sfContext::getInstance()->getI18n()->__('Niepoprawna wartość pola ', array(), 'stImportExportBackend').$this->getUserName($func_name).', "'.$inData[$func_name].'" '.sfContext::getInstance()->getI18n()->__('nie jest liczbą całkowitą', array(), 'stImportExportBackend') ,stImportExportLog::$NOTICE);
                            unset($data[$func_name]);
                        }
                        break;
                    case "custom":
                        $call = $this->config['default_class'] ? $this->config['default_class'] : $this->model."Peer";

                        if (isset($Peer['class']))
                        {
                            $call = $Peer['class'];
                        }

                        if (is_callable($call."::".sfInflector::camelize("import_validate_".$func_name)))
                        {
                            if(!call_user_func($call."::".sfInflector::camelize("import_validate_".$func_name), $data[$func_name], $inData[$this->config['primary_key']], $inData))
                            {
                                unset($data[$func_name]);
                            }

                        }

                        break;
                    default:
                        if (!is_string($data[$func_name])) unset($data[$func_name]);
                        break;
                }
            }
        }
        return $data;
    }

    /**
     * odczytuje dane z pliku, zwraca liczbe odczytanych danych
     *
     * @return   integer
     */
    protected function readData()
    {
        $readed = 0;

        // czytaj az do przekroczenia limitu lub gdy plik sie skonczy
        while ($this->readRow() && $readed<$this->limit)
        {
            $readed++;
        }
        return $readed;
    }

    /**
     * Przeskakuje do odpowiedniego miejsca w czytanym pliku
     *
     * @param       integer     $offset
     * @return   boolean
     */
    protected function skipToData($offset = 0)
    {
        return true;
    }

    /**
     * Funkcja otwiera plik, kod otwierania musi znalezc sie w eksporterze
     * do konkretnego formatu, w przypadku powodzenia zwraca true
     *
     * @return   boolean
     */
    protected function loadFile()
    {
        return true;
    }

    /**
     * Funkcja zamyka plik, kod zamykania musi znalezc sie w eksporterze
     * do konkretnego formatu, w przypadku powodzenia zwraca true
     *
     * @return   boolean
     */
    protected function closeFile()
    {
        return true;
    }

    public function validateFile()
    {
        return false;
    }

    public function setLimit($limit = 20)
    {
        if (is_integer($limit) && $limit>0)
        {
            $this->limit = $limit;
            if ($this->hard_limit && $this->limit > $this->hard_limit)
            {
                $this->limit = $this->hard_limit;
            }
        }
    }

    public function removeUserName($data = array())
    {

        $tmp = array();
        foreach ($data as $value)
        {
            $new_value_array = explode('::',$value);

            if (isset($new_value_array[1])) $new_value = $new_value_array[1]; else $new_value = $value;
            $tmp[] = $new_value;
        }

        return $tmp;
    }

    public function getUserName($name = '')
    {
        if (isset($this->config['fields'][$name]['name']))
        {
            return sfContext::getInstance()->getI18N()->__($this->config['fields'][$name]['name'],array(),$this->model.'_import_export').'::'.$name;
        }
        return $name;
    }

    public static function getCurrentData()
    {
        return stPropelImporter::$current_data;
    }

    public function getLogger()
    {
        return $this->logger;
    }
    
    /**
    /* Fixed function fgetcsv, parameter compatible with fgetcsv
    /* 
    /* handle - handle to the file
    /* len - unsued
    /* delimeter - delimeter
    /* enclosure - enclosure
    */
    public static function fixed_fgetcsv($handle, $len = null, $delimeter = ',', $enclosure = '"')
    {
        //read lines until even numbers of enclosures or EOF
        $line = fgets($handle);
        while (!feof($handle) && substr_count($line,'"')%2) $line .= fgets($handle);
        
        // return array
        $ret = array();
        // cell value 
        $cell = "";

        //split line into cells
        foreach (explode($delimeter,$line) as $value)
        {
            //assign value to cell
            $cell .= $value;

            // if cell has even numbers of enclosure
            if (substr_count($cell,$enclosure)%2 == 0) 
            {
                //remove delimeters from begining and end
                if (substr($cell,0,1) == $enclosure && substr($cell,0,2) != $enclosure.$enclosure) $cell = ltrim($cell, $enclosure);
                if (substr($cell,-1) == $enclosure && substr($cell,-2) != $enclosure.$enclosure) $cell = rtrim($cell, $enclosure);
                //replace escape enclosures
                $cell = str_replace($enclosure.$enclosure,$enclosure, $cell);
                $ret[] = $cell;
                $cell = '';
            }
            // cell not endend append deliteter and continue
            else {$cell .= $delimeter;}
        }
        return $ret;
    } 
}
