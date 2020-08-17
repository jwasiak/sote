<?php

class stExporterCsvAttributes extends stExporterCsv {

    public function doProcess($offset = 0) {

        // jezeli jest to pierwszy krok zapisuje naglowek i naglowek tabeli
        if ($offset==0)
        {
            $this->writeHeader();
            $this->writeHeaderRow();
        }

        // pobiera dane z tabeli
        $data = $this->getData($offset);

        // oblicza liczbe pobranych danych oraz liczbe calkowita danych w bazie
        $data_items_count = $this->limit;
        $data_all_count = $this->getDataCount();

        // zapisuje dane do pliku
        $this->writeConvertedData($data);

        // sprawdza czy zakonczono eksport, jezeli tak to zapisuje stopke
        if ( $data_items_count > 0 && $data_all_count<=( $data_items_count + $offset))
        {
            $this->writeFooterRow();
            $this->writeFooter();
            $this->moveOutputFile();
        }

        return $offset+$data_items_count;
    }
}