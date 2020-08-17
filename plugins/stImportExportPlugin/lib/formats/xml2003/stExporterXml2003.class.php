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
 * @version     $Id: stExporterXml2003.class.php 13384 2011-06-02 11:30:57Z piotr $
 * @author      Piotr Halas <piotr.halas@sote.pl>
 */
            
/** 
 * Klasa eksportera do formtu Microsoft Office 2003 xml
 *
 * @package     stImportExportPlugin
 * @subpackage  libs
 */
class stExporterXml2003 extends stPropelExporter {

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
     * Unikatowa nazwa exportera
     * @var string
     */
    var $converter = 'xml2003';
    
    /** 
     * Rozszerzenie pliku eksportu
     * @var string
     */
    var $output_file_extension = 'xml';

    /** 
     * Zwraca nagłowek pliku z nazwą modelu jako nazwa arkusza
     *
     * @return   string
     */
    protected function getHeader() {
        return sprintf($this->header,$this->model);
    }
    
    /** 
     * Zwraca zawartosc jednego wiersza eksportu do pliku
     *
     * @return   string
     */
    protected function getConvertedData($data = array()) {
        $text = '';
        if (is_array($data)) {
            foreach ($data  as $object) {
                $row = "<Row>";
                $writable = true;

                foreach ($object as $key=>$value) {
                    $tmp = str_replace("\n","&#10;",htmlspecialchars(html_entity_decode($value,null,'utf-8'),ENT_QUOTES,'utf-8'));
                    if (strlen($tmp)>32000)
                    {
                        $this->logger->add($object[$this->config['primary_key']],sfContext::getInstance()->getI18n()->__('Ciąg znaków w polu %field% jest za długi, pomijam rekord',array('%field%'=>$key)));
                        $writable = false;
                        break;
                    }
                    $row .= "<Cell><Data ss:Type=\"".$this->getFieldType($key)."\">".$tmp."</Data></Cell>";
                }

                if ($writable) {
                    $text .= $row."</Row>";
                }
            }
        }

        return $text;
    }

    /** 
     * Zwraca zawartosc naglowka tabeli eksportu
     *
     * @return   string
     */
    protected function getHeaderRow() {
        $header = "<Row>";
        foreach ($this->config['fields']  as $field=>$func_name) {
            $header .= "<Cell><Data ss:Type=\"String\">".$this->getUserName($field)."</Data></Cell>";
        }
        $header .= "</Row>";
        return $header;
    }
    
    public function sampleFile($data = array()) {
        return $this->getHeader().$this->getHeaderRow().$this->footer;
    }
    
    protected function getFieldType($field = '') {
    	if (isset($this->config['fields'][$field]['type'])) {
    	   	switch($this->config['fields'][$field]['type']) {
    	   		case "string": return "String"; break; 
                case "integer": return "Number"; break;
                case "double": return "Number"; break;
                default: return "String"; break;
    	   	}
    	}
    	return "String";    	
    }
}
