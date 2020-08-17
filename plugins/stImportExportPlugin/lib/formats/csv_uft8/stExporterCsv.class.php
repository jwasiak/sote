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
 * @version     $Id: stExporterCsv.class.php 13384 2011-06-02 11:30:57Z piotr $
 */

class stExporterCsv extends stPropelExporter
{

	/**
	 * Uchwyt do pliu csv
	 * @var handle
	 */
	var $csv_file = null;

	/**
	 * Separator komorek w pliku csv
	 * @var string
	 */
	var $delimiter = ";";

	/**
	 * Znak ucieczki w pliku csv
	 * @var unknown_type
	 */
	var $enclosure = "\"";

	/**
	 * Unikatowa nazwa exportera
	 * @var string
	 */
	var $converter = 'csv';

	/**
	 * Rozszerzenie pliku eksportu
	 * @var string
	 */
	var $output_file_extension = 'csv';

	/**
	 * Zapisuje pnaglowek do pliku csv
	 */
	protected function writeHeader()
	{

		// tablica naglowkow
		$cols = array();

		// dla kazdego elementu obiektu
		foreach ($this->config['fields']  as $field => $func_name) {
			// przypisz nazwe
			$cols[] = $this->getUserName($field);
		}
		// otwrzo plik eksportu
		$this->csv_file = fopen($this->tmp_file, "w");

		// zapisz dane naglwoka
		$this->fputcsv2($this->csv_file, $cols, $this->delimiter, $this->enclosure);
	}

	/**
	 * Przeladowanie standardowej funkcji getConvertedData
	 *
	 * @param        object      $data
	 * @return   array
	 */
	protected function getConvertedData($data = null)
	{
		return $data;
	}

	/**
	 * Zapisuje dane do pliku csv
	 *
	 * @param        object      $data
	 */
	protected function writeConvertedData($data = null)
	{

		// jezeli plik nie zostal otwarty, otwiera go i ustawia wskaznik na koniec pliku
		if (!$this->csv_file) {
			$this->csv_file = fopen($this->tmp_file, "a");
		}

		// jezeli dane wejsciowe sa tablica wykonaj porcedure zapisu
		if (is_array($data)) {

			//dla kazdego elementu tablicy wykonaj zapis wiersza
			foreach ($data  as $object) {
				$overSize = false;

				//tworzy tablice do zapisania
				$row = array();
				foreach ($object as $key => $value) {
					if (strlen((string) $value) > 32000) {
						$this->logger->add($object[$this->config['primary_key']], sfContext::getInstance()->getI18n()->__(self::FIELD_EXCEEDS_32K_MSG, array('%field%' => $key), 'stImportExportBackend'));
						$row[] = '[N/A]';
					} else {
						$row[] = $value;
					}
				}

				// zapisuje tablice z danymi do pliku jezeli wielkosc komorek nie zostala przekroczona
				$this->fputcsv2($this->csv_file, $row, $this->delimiter, $this->enclosure);
			}
		}

		//zamyka plik
		fclose($this->csv_file);
	}

	public function sampleFile($data = array())
	{
		if (!$this->csv_file) {
			$this->csv_file = fopen($this->tmp_file, "a");
		}
		$this->writeHeader();
		$this->writeConvertedData($data);
		//fclose($this->csv_file);

		return file_get_contents($this->tmp_file);
	}

	public function fputcsv2($fh, array $fields, $delimiter = ',', $enclosure = '"')
	{
		$output = array();
		foreach ($fields as $field) {
			$output[] = $enclosure . str_replace($enclosure, $enclosure . $enclosure, $field) . $enclosure;
		}

		fwrite($fh, join($delimiter, $output) . "\n");
	}
}
