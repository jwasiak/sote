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
 * @version     $Id: stPropelExporter.class.php 13384 2011-06-02 11:30:57Z piotr $
 * @author      Piotr Halas <piotr.halas@sote.pl>
 */

/**
 * Definicje bledow
 */
define( "EXPORT_NO_CONFIG",  "Plik konfiguracyjny exportu nie istnieje." );

/**
 * Klasa obslugi eksportu danych
 *
 * @package     stImportExportPlugin
 * @subpackage  libs
 */
class stPropelExporter
{

    const FIELD_EXCEEDS_32K_MSG = 'Pole <b>%field%</b> posiada więcej niż 32 000 znaków.';
    const FIELD_INCORRECT_ENCODING = 'Pole <b>%field%</b> zawiera znaki z poza zakresu kodowania <b>%encoding%</b>.';
    const FIELD_NA_REPLAGE_MSG = 'Eksport pola zostaje pominięty i jego wartość zostaje zastąpiona w pliku eksportu przez <b>[N/A]</b>. Proszę nie edytować zawartości kolumn z wartością <b>[N/A]</b>, w innym wypadku (przy ponownym imporcie) wartość tego pola zostanie nadpisana.';
    
    /**
     * Naglowe pliku
     * @var string
     */
    var $header = '';

    /**
     * stopka pliku
     * @var string
     */
    var $footer = '';

    /**
     * nazwa modelu
     * @var string
     */
    var $model = '';

    /**
     * Unikatowa
     * @var string
     */
    var $converter = '';

    /**
     * Konfiguracja modulu
     * @var array()
     */
    var $config = array();

    /**
     * nazwa pliku eksprotu
     * @var string
     */
    var $output_file_extension = '';

    /**
     * Limit jednoczesnie eksportowanych elementow
     * @var integer
     */
    var $limit = 20;

    var $hard_limit = null;

    /**
     * Nazwa pliku tymczasowego
     * @var string
     */
    var $tmp_file = '';

    protected $md5hash = array();

    protected $logger = null;

    /**
     * konstruktor klasy, nalezy podac nazwe modelu oraz tablice
     * eksportowanych pol
     *
     * @param        string      $model
     * @param         array       $fields
     */
    public function __construct($model = '', $fields = array())
    {
        $this->model = $model;
        $this->config = $fields;
        $this->tmp_file = sfConfig::get('sf_cache_dir').DIRECTORY_SEPARATOR.'export_'.$this->model.'.tmp';
        $this->logger = new stImportExportLog(sfConfig::get('sf_log_dir').DIRECTORY_SEPARATOR.'export_'.$model.'.log');

        $this->criteria = $this->getCriteria();
        
        stEventDispatcher::getInstance()->notify(new sfEvent($this->criteria, 'st'.sfContext::getInstance()->getModuleName().'Export.'.$this->model.'Criteria'));
    }

    /**
     * Zwraca liczbe rekordow do eksportu
     *
     * @return   integer
     */
    public function getDataCount()
    {
        return call_user_func($this->model.'Peer::doCount', $this->criteria);
    }

    /**
     * Glowna petla eksportu, pobiera offset danych do eksportu.
     * Zwraca offset koljego kroku
     *
     * @param       integer     $offset
     * @return   integer
     */
    public function doProcess($offset=0)
    {

        // jezeli jest to pierwszy krok zapisuje naglowek i naglowek tabeli
        if ($offset==0)
        {
            $this->writeHeader();
            $this->writeHeaderRow();
            $this->clearMd5Hash();
        }

        // pobiera dane z tabeli
        $data = $this->getData($offset);

        // oblicza liczbe pobranych danych oraz liczbe calkowita danych w bazie
        $data_items_count = count($data);
        $data_all_count = $this->getDataCount();

        // zapisuje dane do pliku
        $this->writeConvertedData($data);
        $this->writeMd5Hash();

        // sprawdza czy zakonczono eksport, jezeli tak to zapisuje stopke
        if ( $data_items_count > 0 && $data_all_count<=( $data_items_count + $offset))
        {
            $this->writeFooterRow();
            $this->writeFooter();
            $this->moveOutputFile();
        }

        return $offset+$data_items_count;
    }

    protected function doSelect(Criteria $c)
    {
        return call_user_func($this->model.'Peer::doSelect',$c);
    }

    /**
     * Pobiera dane z bazy danych poczawszy od offsetu, zwraca pobrane
     * dane w postaci tablicy
     *
     * @param       integer     $offset
     * @return   array
     */
    protected function getData($offset = 0)
    {

        //tworzy nowe zapytanie uwzgledniajac offset i limit
        $c = clone $this->criteria;
        $c->setOffset($offset);
        $c->setLimit($this->limit);
        
        // wykonuje zaputanie do bazy danych
        $data = $this->doSelect($c);

        $this->md5hash = array();

        $return_data = array();

        // dla kazdego zwrocengo wyniku zapisuje dane do tablicy
        foreach($data as $row)
        {
            $return_row = array();

            // eksport jest wykonywany tylko do pol zapisanych w konfiguracji
            foreach ($this->config['fields'] as $func_name=>$args)
            {
                $type = $args['type'];

                $primary_column = 'get'.sfInflector::camelize($this->config['primary_key']);

                // ustala rzeczywista nazwe funkcji do pobrania danych
                $real_func_name = 'get'. sfInflector::camelize($func_name);

                if (isset($args['method'])) $real_func_name = $args['method'];

                // pobiera dane z modelu glownego lub zaleznych, jezeli podana funkcja nie wystepuje wstawia watosc null
                if (!isset($args['class']))
                {
                    try
                    {
                        $v = $row->$real_func_name($this->logger);

                        $return_row[$func_name] = $this->formatValue($v, $type);

                    }
                    catch (Exception $e)
                    {
                        $this->logger->add($row->$primary_column(), $e->getMessage(), stImportExportLog::$FATAL);
                        $return_row[$func_name] = null;
                    }
                }
                elseif (isset($args['class']) && is_callable($args['class'].'::'.$real_func_name))
                {
                    try
                    {
                        $v = call_user_func($args['class'].'::'.$real_func_name,$row,$this->logger);

                        $return_row[$func_name] = $this->formatValue($v, $type);
                    }
                    catch (Exception $e)
                    {
                        $this->logger->add($row->$primary_column(), $e->getMessage(), stImportExportLog::$FATAL);
                        $return_row[$func_name] = null;
                    }
                }
                else
                {
                    $return_row[$func_name] = null;
                }

                if (isset($args['md5hash']) && $args['md5hash'] && $return_row[$func_name] !== null)
                {
                    $this->md5hash[$row->getId()][$func_name] = md5($return_row[$func_name]);
                }
            }
            // dodaje dane to glownej tablicy danych
            $return_data[] = $return_row;
        }

        return $return_data;
    }

    public function formatValue($v, $type = null)
    {
        switch($type)
        {
            case "double":
            case "float":
                return stPrice::round($v, 2);
            case "int":
            case "integer":
            case "bool":
            case "boolean":
                return intval($v);
            default:
                return strval($v);
        }
    }

    /**
     * Zwraca nowa instancje obiektu Criteria
     */
    protected function getCriteria(Criteria $criteria = null)
    {
        if (null === $criteria)
        {
            $criteria = new Criteria();
        }

        return $criteria;
    }

    /**
     * Funkcja zamienia dane w postaci tablicy na okreslony format,
     * funkcja ta definiowana jest w eksporterze okreslonego formatu
     *
     * @param         array       $data
     * @return   mixed
     */
    protected function getConvertedData($data = null)
    {
        return '';
    }

    /**
     * Zapisuje dane do pliku
     *
     * @param        string      $data
     */
    protected function writeConvertedData($data = null)
    {
        file_put_contents($this->tmp_file,$this->getConvertedData($data),FILE_APPEND);
    }

    protected function writeMd5Hash()
    {        
        foreach ($this->md5hash as $id => $values)
        {
            $md5hash = ExportMd5HashPeer::retrieveByModelId($id, $this->model);

            if (null === $md5hash)
            {
                $md5hash = new ExportMd5Hash();
                $md5hash->setId($id);
                $md5hash->setModel($this->model);
            }
            
            $md5hash->setMd5Hash($values);
            $md5hash->save();
        }        
    }

    protected function clearMd5Hash()
    {
        $con = Propel::getConnection();
        $con->executeQuery(sprintf('TRUNCATE %s', ExportMd5HashPeer::TABLE_NAME));
    }

    /**
     * Zwraca tresc naglowka, w funkcji tej moga zostac wykonane dodatkowe opercj na naglowku
     *
     * @return   string
     */
    protected function getHeader()
    {
        return $this->header;
    }

    /**
     *  Zapisuje naglowek do pliku
     */
    protected function writeHeader()
    {
        file_put_contents($this->tmp_file,$this->getHeader());
    }

    /**
     * Zwraca wiersz naglowka, funkcja defioniowana w pliku eksportera
     *
     * @return   string
     */
    protected function getHeaderRow()
    {
        return '';
    }

    /**
     *  Zapisuje wiersz naglowkowy do pliku
     */
    protected function writeHeaderRow()
    {
        file_put_contents($this->tmp_file,$this->getHeaderRow(),FILE_APPEND);
    }

    /**
     * Zwraca zawartosc stopki
     *
     * @return   string
     */
    protected function getFooter()
    {
        return $this->footer;
    }

    /**
     * Zapisuje zawartosc stopki do pliku
     */
    protected function writeFooter()
    {
        file_put_contents($this->tmp_file,$this->getFooter(),FILE_APPEND);
    }

    /**
     * Zwraca wiersz stopki
     *
     * @return   string
     */
    protected function getFooterRow()
    {
        return '';
    }

    /**
     * Zapisuje wiersz stopki do pliku
     */
    protected function writeFooterRow()
    {
        file_put_contents($this->tmp_file,$this->getFooterRow(),FILE_APPEND);
    }

    /**
     * Umozliwia przeniesienie piku wynikowego po wykonaniu eksportu
     * Zwraca nazwe pliku.
     *
     * @return   string
     */
    protected function moveOutputFile()
    {
        return '';
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

    public function getUserName($name = '')
    {
        if (isset($this->config['fields'][$name]['name']))
        {
        	$i18n_file = $this->model.'_import_export';
        	if (!empty($this->config['fields'][$name]['i18n_file'])) $i18n_file = $this->config['fields'][$name]['i18n_file'];
            return sfContext::getInstance()->getI18N()->__($this->config['fields'][$name]['name'],array(),$i18n_file).'::'.$name;
        }
        return $name;
    }

    public function getLogger()
    {
        return $this->logger;
    }
}
