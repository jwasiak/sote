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
 * @version     $Id: stImporterXml2003.class.php 13384 2011-06-02 11:30:57Z piotr $
 * @author      Piotr Halas <piotr.halas@sote.pl>
 */

/**
 * Klasa Importera danych z formatu Microsoft Office 2003 xml
 *
 * @package     stImportExportPlugin
 * @subpackage  libs
 */
class stImporterXml2003 extends stPropelImporter
{
    /**
     * Nagłówek pliku xml
     * @var string
     */
    var $header = "<?xml version=\"1.0\" encoding=\"UTF-8\"?><?mso-application progid=\"Excel.Sheet\"?>
    <Workbook xmlns=\"urn:schemas-microsoft-com:office:spreadsheet\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:x=\"urn:schemas-microsoft-com:office:excel\" xmlns:x2=\"http://schemas.microsoft.com/office/excel/2003/xml\" xmlns:ss=\"urn:schemas-microsoft-com:office:spreadsheet\" xmlns:o=\"urn:schemas-microsoft-com:office:office\" xmlns:html=\"http://www.w3.org/TR/REC-html40\" xmlns:c=\"urn:schemas-microsoft-com:office:component:spreadsheet\"> 
    <OfficeDocumentSettings xmlns=\"urn:schemas-microsoft-com:office:office\"></OfficeDocumentSettings>
    <ExcelWorkbook xmlns=\"urn:schemas-microsoft-com:office:excel\"></ExcelWorkbook>
    <Styles></Styles>
    <ss:Worksheet ss:Name=\"%s\">
        <Table>";

    /**
     * Stopka pliku xml
     * @var string
     */
    var $footer = "</Table><x:WorksheetOptions /></ss:Worksheet></Workbook>";

    /**
     * Unikatowa nazwa Importera
     * @var string
     */
    var $converter = 'xml2003';

    /**
     * Rozszerzenie pliku eksportu
     * @var string
     */
    var $input_file_extension = 'xml';

    /**
     * uchwyt pliku z danymi
     * @var XmlReader
     */
    var $file_handle = null;

    /**
     * Zwraca liczbę rekordów w pliku
     *
     * @return   integer
     */
    public function getDataCount() {
        // otwiera plik i doczytaj jego naglowek;
        $this->loadFile();
        $this->readHeader();

        $count = 0;

        //odczytuje wszystkie rekordy bez czytania danych
        while ($this->_readRow()) {
            $count++;
        }

        //zwraca liczbe rekordow
        return ($count)?$count-1:0;
    }

    /**
     * Główna pętla importu przeładowana na potrzeby importu z xml2003
     *
     * @return   integer
     */
    public function doProcess($offset = 0) {
        // otwierza plik w wczytuje naglowki
        $this->loadFile();
        $this->readHeader();
        $this->readHeaderRow();

        // pomija wczesniej odczytane dane
        $this->skipToData($offset);

        // wczytuje dane i dodaje je do bazy danych
        // zwraca liczbe odczytanych rekordow
        $readed = $this->readData();

        //zamyka plik
        $this->closeFile();

        //zwraca nowe polozenie danych
        return $offset + $readed;
    }


    /**
     * Wczytuje plik z danymi w przypadku braku pliku wyrzuc wyjactek
     * @throws IMPORT_NO_FILE
     */
    protected function loadFile() {

        //sprawdza czy plik istnieje i mozna z niego czytac
        //jezeli nie to wstaw wyjatek braku pliku
        if (!is_readable($this->file)) {
            throw new Exception(IMPORT_NO_FILE);
        }

        // jezeli plik jest do odczytu to zostanie zalodowany
        $this->file_handle = new XMLReader();
        $this->file_handle->open($this->file);
    }

    /**
     * Zwraca informacje czy plik posiada poprawny naglowek
     *
     * @return   boolean
     */
    protected function readHeader() {
        while ($this->file_handle->read()) {
            // sprawdza czy w pliku xml jest Worksheet
            if ($this->file_handle->depth == 1 && $this->file_handle->nodeType == XMLReader::ELEMENT && ($this->file_handle->name == 'ss:Worksheet' || $this->file_handle->name == 'Worksheet')) {
                // sprawdza czy w pliku jest akrusz z poprawna nazwa modelu
                if ($this->file_handle->getAttribute('ss:Name')==$this->model){
                    while ($this->file_handle->read() && !($this->file_handle->nodeType == XMLReader::END_ELEMENT && ($this->file_handle->name == 'ss:Worksheet' || $this->file_handle->name == 'Worksheet'))) {
                        // sprawdza czy w pliku jest tabela
                        if ($this->file_handle->depth == 2 && $this->file_handle->nodeType == XMLReader::ELEMENT && $this->file_handle->name == 'Table') {
                            return true;
                        }
                    }
                }
            }
        }
        return false;
    }

    /**
     * Odczytuje rekord danych
     *
     * @return   boolean
     */
    protected function readRow() {

        // tablica z danymi
        $data = array();

        // index aktualnej komorki
        $index = 0;

        // szuka kolejnego wiersza w pliku
        if ($this->file_handle->depth == 3 && $this->file_handle->nodeType == XMLReader::ELEMENT && $this->file_handle->name == 'Row') {

            foreach ($this->header_order as $key=>$name) {
                $data[$name] = '';
            }
            // przeksztalca dane z xmlReader na SimpleXml
            $cell = $this->ExpandNode($this->file_handle);

            // dla kazdej komorki w wierszu
            foreach ($cell->Cell as $name) {

                // pobiera atrybuty komorki
                $attrs = $name->attributes();

                // sprawdza czy dane sa po kolei, jezeli nie ustawia nowy index danych
                if (isset($attrs['Index'])) {$index = (integer)$attrs['Index']-1;}

                // jezeli komorka zawiera dane zapamietuje je w zmiennej data
                if (isset($name->Data)) {
                    if (isset($this->header_order[$index])) {
                        if (strcmp(iconv("UTF-8", "UTF-8//IGNORE", (string)$name->Data),(string)$name->Data)!=0)
                        {
                            $this->logger->add($data[array_search($this->config['primary_key'],$this->header_order)],
                                sfContext::getInstance()->getI18n()->__('Niepoprawne kodowanie dla pola %field%', array('%field%'=>$name)));
                        } else {
                            $data[$this->header_order[$index]] = (string)$name->Data;
                        }
                    }
                }
                //zwieksza index o jeden
                $index++;
            }
            // zapisuje pobrane dane do bazy
            $this->processData($data);
            // zmienia polozenie na kolejny element w pliku
            while ($this->file_handle->read() && !($this->file_handle->depth == 3 && $this->file_handle->nodeType == XMLReader::ELEMENT && $this->file_handle->name == 'Row'));

            return true;
        }
        return false;
    }


    /**
     * Odczytuje wiersz naglowka z tabeli
     *
     * @return   boolean
     */
    protected function readHeaderRow() {

        // index aktualnej komorki
        $index = 0;

        // odczytaj az do konca wpisu tabeli
        while ($this->file_handle->read() && !($this->file_handle->nodeType == XMLReader::END_ELEMENT && $this->file_handle->name == 'Table')) {

            // jezeli zostanie znaleziony wiersz zamien go na nagolowek
            if ($this->file_handle->depth == 3 && $this->file_handle->nodeType == XMLReader::ELEMENT && $this->file_handle->name == 'Row') {

                // przeksztalca dane z xmlReader na SimpleXml
                $cell = $this->ExpandNode($this->file_handle);

                // dla kazdej komroki w wierszu
                foreach ($cell->Cell as $name) {

                    // pobiera atrybuty
                    $attrs = $name->attributes();

                    // sprawdza czy dane sa po kolei, jezeli nie ustawia nowy index danych
                    if (isset($attrs['Index'])) {$index = (integer)$attrs['Index'];}
                    if (isset($name->Data)) {
                        $this->header_order[$index] = (string)$name->Data;
                    }
                    //zwieksza index o jeden
                    $index++;
                }
                // zmienia polozenie na kolejny element w pliku
                //                $this->file_handle->next();
                $this->header_order = $this->removeUserName($this->header_order);
                return true;
            }
        }
        return false;
    }


    /**
     * Przeskakuje dane ktore zostaly odczytane w poprzednich krokach importu
     * @var ingeter $offset
     */
    protected function skipToData($offset = 0) {

        // wyzeruj liczbe pominietych elementow
        $skiped = 0;

        // wykonuje czytanie wiersza az zostanie pominietych offset wierszy lub
        // w pliu nie bedzie wiecej wierszy
        while ($skiped<=$offset && $this->_readRow()) {
            $skiped++;
        }

    }

    /**
     * Odczytuje wiersz bez przetwarzania danych
     *
     * @return   boolean
     */
    protected function _readRow() {
        // odczytaj az do konca wpisu tabeli
        while ($this->file_handle->read() && !($this->file_handle->nodeType == XMLReader::END_ELEMENT && $this->file_handle->name == 'Table')) {
            // jezeli zostanie znaleziony wiersz zamien
            if ($this->file_handle->depth == 3 && $this->file_handle->nodeType == XMLReader::ELEMENT && $this->file_handle->name == 'Row') {

                // przejdz do nastepnego
                return true;
            }
        }
        return false;
    }


    /**
     * Zamienia dane z XmlReader na SimpleXml
     *
     * @param     XMLReader   $reader
     * @return   object
     */
    function ExpandNode(XMLReader $reader) {
        $node = $reader->expand();
        $dom = new DomDocument('1.0','utf-8');
        $n = $dom->importNode($node,true);
        $dom->appendChild($n);
        return simplexml_import_dom($n);

    }

    /**
     * Sprawdza poprawnosc plik
     *
     * @return integer
     */
    public function validateFile() {
        return $this->getDataCount();
    }

    /**
     * Zwraca zawartosc naglowka tabeli eksportu
     *
     * @return   string
     */
    protected function getHeaderRow() {
        $header = "<Row>";
        foreach ($this->config['fields']  as $field=>$func_name) {
            $header .= "<Cell><Data ss:Type=\"String\">".$field."</Data></Cell>";
        }
        $header .= "</Row>";
        return $header;
    }

    /**
     * Zwraca nagłowek pliku z nazwą modelu jako nazwa arkusza
     *
     * @return   string
     */
    protected function getHeader() {
        return sprintf($this->header,$this->model);
    }


    /**
     * Generuje plik z przykładowymi danymi
     * @param array $data
     * @return string
     */
    public function sampleFile($data = array()) {
        return $this->getHeader().$this->getHeaderRow().$this->footer;
    }

}

