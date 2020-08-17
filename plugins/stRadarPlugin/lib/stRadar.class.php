<?php
/**
 * SOTESHOP/stRadarPlugin
 *
 * Ten plik należy do aplikacji stRadarPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stRadarPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stRadar.class.php 10 2009-08-24 09:32:18Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stRadar
 *
 * @package     stRadarPlugin
 * @subpackage  libs
 */
class stRadar extends stPriceCompareGenerateFile implements stPriceCompareGenerateFileInterface
{
    /**
     * Konstruktor
     */
    public function __construct()
    {
        parent::__construct(__CLASS__);
    }

    /**
     * Generowanie nagłówka pliku
     *
     * @return string
     */
    protected function getFileHead()
    {
        $content = xml_open_tag('?xml version="1.0" encoding="UTF-8"?');
        $content.= xml_open_tag('radar wersja="1.0"');
        $content.= xml_open_tag('oferta');
        return $content;
    }

    /**
     * Generowanie zawartości pliku
     *
     * @param $step integer numer kroku
     * @return string
     */
    protected function getFileBody($step)
    {
        $priceCompareProducts = $this->getProducts($step);

        $content = "";
        foreach ($priceCompareProducts as $priceCompareProduct)
        {
            $parsedProduct = new stPriceCompareProductParser($priceCompareProduct->getProduct());

            if ($parsedProduct->checkProduct())
            {
                $productContent = xml_cdata_tag('nazwa', $parsedProduct->getName());
                if ($parsedProduct->hasProducer()) $productContent.= xml_cdata_tag('producent', $parsedProduct->getProducer());
                $productContent.= xml_cdata_tag('opis', $parsedProduct->getDescription());
                $productContent.= xml_tag('id', $parsedProduct->getId());
                $productContent.= xml_tag('url', $parsedProduct->getUrl());
                $productContent.= xml_tag('foto', $parsedProduct->getPhoto());
                $productContent.= xml_cdata_tag('kategoria', $parsedProduct->getCategory());
                $productContent.= xml_tag('cena', $parsedProduct->getPrice());
                 
                $content.= xml_tag('produkt', xml_tag('grupa1', $productContent));
            }
            unset($parsedProduct);
        }
        return $content;
    }

    /**
     * Generowanie stopki pliku
     *
     * @return string
     */
    protected function getFileFoot()
    {
        $content = xml_close_tag('oferta');
        $content.= xml_close_tag('radar');
        return $content;
    }

    /**
     * Pobieranie infromacji o porównywarce podczas eksportu
     *
     * @param $object object
     * @return integer
     */
    static public function getProduct($object = null)
    {
        return stPriceCompareGenerateFile::getProductForExport(__CLASS__, $object);
    }

    /**
     * Ustawianie infromacji o porównywarce podczas importu
     *
     * @param $object object
     * @param $value integer
     * @return boolean
     */
    static public function setProduct($object = null, $active = 0)
    {
        return stPriceCompareGenerateFile::setProductForImport(__CLASS__, $object, $active);
    }
}