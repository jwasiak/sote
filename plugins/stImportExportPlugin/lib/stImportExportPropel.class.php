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
 * @version     $Id: stImportExportPropel.class.php 13384 2011-06-02 11:30:57Z piotr $
 * @author      Piotr Halas <piotr.halas@sote.pl>
 */

/**
 * Klasa modulu generator odpowiedzalna za eksport/import danych
 *
 * @package     stImportExportPlugin
 * @subpackage  libs
 */
class stImportExportPropel
{

    public $import;

    public $export;
    /**
     * Nazwa metody, przyjmuje wartosci exsport lub import
     * @protected string
     */
    public $method = '';

    /**
     * Glowny model importu/eksportu
     * @protected string
     */
    public $model = '';

    /**
     * Nazwa klasy eksportera
     * @protected string
     *
     * @package     stImportExportPlugin
     * @subpackage  libs
     */
    public $class_name = '';

    /**
     * Wskaznik do obiektu eksportera importera
     * @protected object
     *
     * @package     stImportExportPlugin
     * @subpackage  libs
     */
    public $class_handle = null;

    /**
     * Wskaznik do obiektu kontrolera
     * @protected object
     */
    public $controller = null;

    /**
     * Wskaznik do obiektu Context
     * @protected object
     */
    public $context = null;

    /**
     * Zmienna zawiera konfiguracje pol do eksportu
     * @protected string
     */
    public $fields = array();

    /**
     * Profile id
     * @protected integer
     */
    public $profile = 0;

    /**
     * nazwa pliku tymczasowego
     * @protected string
     */
    public $file = '';

    public $export_limit = 20;

    public $import_limit = 5;

    public $auto_detect_line_endings = '';

    /**
     * Konstruktor klasy, parametr method przyjmuje wartosc 'export' lub 'import'
     * class zawiera nazwe klasy eksportera
     * file - nazwe pliku tymczasowego w przypadku importu
     *
     * @param        string      $method
     * @param        string      $class
     * @param        string      $file
     *
     * @package     stImportExportPlugin
     * @subpackage  libs
     */
    public function __construct($method='', $class = '', $file='', $profile = 0)
    {
        $this->auto_detect_line_endings = ini_get('auto_detect_line_endings');
        ini_set('auto_detect_line_endings', true);

        // pobiera instancje clasy contekst oraz cotroller
        $this->context = sfContext::getInstance();
        $this->controller = $this->context->getController();

        // zapamietuje podane parametry
        $this->method =  $method;
        $this->class_name =  $class;
        $this->file = $file;
        $this->profile = $profile;

        // odczytuje i ustawia pola wykorzystywane w imporcie eksporcie
        $this->setFields();

        //tworzy klase importera lub eksportera
        $this->setImporterExporter();
    }

    public function __destruct()
    {
        ini_set('auto_detect_line_endings',$this->auto_detect_line_endings);
    }

    /**
     * Pobiera pola do eksportu z konfiguracji
     *
     * @return   array
     */
    public function getExportFields()
    {
        return $this->export['fields'];
    }

    /**
     * Pobiera pola do importu z konfiguracji
     *
     * @return   array
     */
    public function getImportFields()
    {
        return  $this->import['fields'];
    }

    /**
     * Ustawia odpowiednie pola do importu/eksportu
     */
    protected function setFields()
    {

        // w zaleznosci od metody ustaw odpowiednie pola
        switch ($this->method)
        {
            case "export":
                $this->fields['primary_key'] = $this->export['primary_key'];
                $this->fields['fields'] = $this->getExportFields();
                break;
            case "import":
                $this->fields['primary_key'] = $this->import['primary_key'];
                $this->fields['default_class'] = isset($this->import['default_class']) ? $this->import['default_class'] : null;
                $this->fields['fields'] = $this->getImportFields();
                break;
        }

        if ($this->profile != 0)
        {
            $profile = ExportProfilePeer::retrieveByPk($this->profile);
            if (is_object($profile))
            {
                $c = new Criteria();
                $c->add(ExportFieldPeer::FIELD, array_keys($this->fields['fields']), Criteria::IN);
                $c->addJoin(ExportFieldPeer::ID,ExportProfileHasExportFieldPeer::EXPORT_FIELD_ID);
                $c->add(ExportProfileHasExportFieldPeer::EXPORT_PROFILE_ID, $profile->getId());

                $tmp =array();
                $tmp[$this->import['primary_key']] = $this->fields['fields'][$this->import['primary_key']];
                foreach (ExportFieldPeer::doSelect($c) as $activeFields)
                {
                    $tmp[$activeFields->getField()] = $this->fields['fields'][$activeFields->getField()];
                }

                //add primary key
                $this->fields['fields'] = $tmp;
            }
        }

    }

    /**
     * Tworzy obiekt importera eksportera
     */
    protected function setImporterExporter()
    {
        if (!class_exists($this->class_name))
        {
            throw new Exception("");
        }
        $this->class_handle = new $this->class_name($this->model,$this->fields, $this->file);
        $this->setLimits();
    }

    public function getImporterExporter()
    {
        return $this->class_handle;
    }
    /**
     * Wykonuje methodye doProcess importera/eksportera, jako parametr przyjmyje
     * numer kroku do wykonan, zwraca numer kolejnego kroku
     *
     * @param       integer     $offset
     * @return   integer
     */
    public function doProcess($offset = 0)
    {
        $offset = $this->class_handle->doProcess($offset);
        return $offset;
    }

    /**
     * Zwraca liczbe krokow do wykonania
     *
     * @return   integer
     */
    public function getDataCount()
    {
        return $this->class_handle->getDataCount();
    }

    public function validateFile()
    {
        return $this->class_handle->validateFile();
    }

    public function sampleFile()
    {
        return $this->class_handle->sampleFile($this->getSampleRow());
    }

    public function setLimits()
    {
        // w zaleznosci od metody ustaw odpowiednie pola

        if ($this->class_handle)
        {
            switch ($this->method)
            {
                case "export":
                    $this->class_handle->setLimit($this->export_limit);
                    break;
                case "import":
                    $this->class_handle->setLimit($this->import_limit);
                    break;
            }
        }
    }

    private function getSampleRow()
    {

        $tmp =array();
        foreach ($this->fields['fields'] as $key => $field)
        {
            if (isset($field['sample']))
            {
                $tmp[$key] = $field['sample'];
            } else
            {
                $tmp[$key] = '';
            }
        }
        return array($tmp);
    }

    public static function getProfiles($model = '')
    {
        $profiles = array(sfContext::getInstance()->getI18n()->__('Profil domyślny', array(), 'stImportExportBackend'));

        $c = new Criteria();
        $c->add(ExportProfilePeer::MODEL, $model);
        $c->addAscendingOrderByColumn(ExportProfilePeer::NAME);

        foreach (ExportProfilePeer::doSelect($c) as $profile)
        {
            $profiles[$profile->getId()] = sfContext::getInstance()->getI18n()->__($profile->getName(), array(), 'stImportExportBackend');
        }

        return $profiles;
    }

    public static function updateExportProfiles($model = '', $fields = array(), $primary_key = '')
    {
        if (is_array($fields) && count($fields))
        {
            //inserting new
            $c = new Criteria();
            $c->add(ExportFieldPeer::MODEL, $model);
            $dbFields = ExportFieldPeer::doSelect($c);

            foreach ($dbFields as $dbField)
            {
                $field = $dbField->getField();
                if (!isset($fields[$field]))
                {
                    $dbField->delete();
                }
                else
                {
                    $dbField->setName($fields[$field]['name']);
                    if (isset($fields[$field]['i18n_file']))
                    {
                        $dbField->setI18nFile($fields[$field]['i18n_file']);
                    }
                    $dbField->save();
                    unset($fields[$field]);
                }
            }

            // throw new Exception("Error Processing Request", 1);
            

            foreach ($fields as $field => $value)
            {
                $tmp = new ExportField();
                $tmp->setModel($model);
                $tmp->setField($field);
                $tmp->setIsKey(strcmp($field, $primary_key)==0?1:0);
                $tmp->setName($value['name']);
                if (isset($fields[$field]['i18n_file']))
                {
                    $tmp->setI18nFile($fields[$field]['i18n_file']);
                }
                $tmp->save();
            }
        }
    }

    public static function getFileContents($url, $filename = null)
    {
        if (null === $filename)
        {
            $filename = basename(rawurldecode($url));
            $filename = sfConfig::get('sf_upload_dir') . '/assets/' .uniqid() . '-' . sfAssetsLibraryTools::sanitizeName($filename);
        }

        $fp = fopen($filename, 'w+');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        $result = curl_exec($ch);
        $error = curl_error($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        fclose($fp);

        if (!$result || $httpCode != 200)
        {
            $statuslist = array(
                '100' => 'Continue',
                '101' => 'Switching Protocols',
                '200' => 'OK',
                '201' => 'Created',
                '202' => 'Accepted',
                '203' => 'Non-Authoritative Information',
                '204' => 'No Content',
                '205' => 'Reset Content',
                '206' => 'Partial Content',
                '300' => 'Multiple Choices',
                '302' => 'Found',
                '303' => 'See Other',
                '304' => 'Not Modified',
                '305' => 'Use Proxy',
                '400' => 'Bad Request',
                '401' => 'Unauthorized',
                '402' => 'Payment Required',
                '403' => 'Forbidden',
                '404' => 'Not Found',
                '405' => 'Method Not Allowed',
                '406' => 'Not Acceptable',
                '407' => 'Proxy Authentication Required',
                '408' => 'Request Timeout',
                '409' => 'Conflict',
                '410' => 'Gone',
                '411' => 'Length Required',
                '412' => 'Precondition Failed',
                '413' => 'Request Entity Too Large',
                '414' => 'Request-URI Too Long',
                '415' => 'Unsupported Media Type',
                '416' => 'Requested Range Not Satisfiable',
                '417' => 'Expectation Failed',
                '500' => 'Internal Server Error',
                '501' => 'Not Implemented',
                '502' => 'Bad Gateway',
                '503' => 'Service Unavailable',
                '504' => 'Gateway Timeout',
                '505' => 'HTTP Version Not Supported'
            );

            if ($httpCode != 200)
            {
                $error = isset($statuslist[$httpCode]) ? $httpCode . ' ' . $statuslist[$httpCode] : $httpCode;
            }

            if (is_file($filename))
            {
                unlink($filename);
            }

            throw new Exception($error);
        }

        return $filename;
    }
}
