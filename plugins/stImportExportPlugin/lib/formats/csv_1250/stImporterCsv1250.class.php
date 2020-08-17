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
 * @version     $Id: stImporterCsv1250.class.php 13384 2011-06-02 11:30:57Z piotr $
 */

class stImporterCsv1250 extends stPropelImporter
{

    var $converter = 'csv';

    /**
     * Separator komorek w pliku csv
     * @var string
     */
    var $delimiter = ";";

    /**
     * Rozszerzenie pliku eksportu
     * @var string
     */
    var $input_file_extension = 'csv';

    public function getDataCount()
    {
        if (is_readable($this->file)) {
            return filesize($this->file);
        }

        return 0;
    }

    public function loadFile()
    {
        if (is_readable($this->file)) {
            $this->file_handle = fopen($this->file, "r");
        }
    }

    public function readHeaderRow()
    {
        if ($this->file_handle) {
            $this->header_order = $this->removeUserName(fgetcsv($this->file_handle, null, ";", "\""));
        }
    }

    public function skipToData($offset = 0)
    {
        if ($offset) {
            fseek($this->file_handle, $offset);
        }
    }

    protected function readRow()
    {
        if ($this->file_handle) {
            $tmp = fgetcsv($this->file_handle, null, ";", "\"");
            if ($tmp) {
                $data = array();
                foreach ($this->header_order as $key => $name) {
                    if (isset($tmp[$key]) && trim($tmp[$key]) != "[N/A]") {

                        if (strcmp(iconv("CP1250", "CP1250//IGNORE", $tmp[$key]), $tmp[$key]) != 0) {
                            $this->logger->add(
                                $tmp[array_search($this->config['primary_key'], $this->header_order)],
                                sfContext::getInstance()->getI18n()->__('Niepoprawne kodowanie dla pola %field%', array('%field%' => $name))
                            );
                        } else {
                            $data[$name] = iconv('CP1250', 'UTF-8', $tmp[$key]);
                        }
                    }
                }
                $this->processData($data);
            }
            return true;
        }
    }

    public function getOffset()
    {
        return ftell($this->file_handle);
    }

    public function validateFile()
    {

        if (is_readable($this->file)) {
            $this->file_handle = fopen($this->file, "r");
            if ($this->file_handle) {
                $this->header_order = $this->removeUserName(fgetcsv($this->file_handle, null, ";", "\""));
                if (array_search($this->config['primary_key'], $this->header_order) !== false) {
                    return true;
                }
                fclose($this->file_handle);
            }
        }
        return false;
    }



    public function sampleFile($data = array())
    {

        $exporter = new stExporterCsv($this->model, $this->config);

        return $exporter->sampleFile($data);;
    }
}
