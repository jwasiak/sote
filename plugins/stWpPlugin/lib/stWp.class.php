<?php
/**
 * SOTESHOP/stWpPlugin
 *
 * Ten plik należy do aplikacji stWpPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stWpPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stWp.class.php 10 2009-08-24 09:32:18Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stWp
 *
 * @package     stWpPlugin
 * @subpackage  libs
 */
class stWp extends stPriceCompareGenerateFile implements stPriceCompareGenerateFileInterface
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
        $content.= xml_open_tag('wpoffers xmlns="http://zakupy.wp.pl/WPzakupySchema.xsd" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://zakupy.wp.pl/ http://zakupy.wp.pl/WPzakupySchema.xsd"');
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
                $productContent = xml_tag('src_id', $parsedProduct->getId());
                $productContent.= xml_cdata_tag('name', $parsedProduct->getName());
                $productContent.= xml_cdata_tag('description', $parsedProduct->getDescription());
                $productContent.= xml_cdata_tag('url', $parsedProduct->getUrl());
                $productContent.= xml_cdata_tag('category', $parsedProduct->getCategory());
                $productContent.= xml_tag('price', $parsedProduct->getPrice());
                $productContent.= xml_cdata_tag('pic_url', $parsedProduct->getPhoto());
                if ($parsedProduct->hasProducer()) $productContent.= xml_cdata_tag('producer', $parsedProduct->getProducer());
                
                $content.= xml_tag('offer', $productContent);
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
        return xml_close_tag('wpoffers');
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