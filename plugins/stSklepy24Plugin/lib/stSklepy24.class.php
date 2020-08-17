<?php
/**
 * SOTESHOP/stSklepy24Plugin
 *
 * Ten plik należy do aplikacji stSklepy24Plugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stSklepy24Plugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stSklepy24.class.php 4203 2010-03-25 11:04:24Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stSklepy24
 *
 * @package     stSklepy24Plugin
 * @subpackage  libs
 */
class stSklepy24 extends stPriceCompareGenerateFile implements stPriceCompareGenerateFileInterface
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
        $content.= xml_open_tag('products xmlns="http://www.sklepy24.pl" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sklepy24.pl http://www.sklepy24.pl/formats/products.xsd" date="'.date("Y-m-d").'"');
        return $content;
    }

    /**
     * Generowanie zawartości pliku
     *
     * @param integer $step numer kroku
     * @return string
     */
    protected function getFileBody($step)
    {
        $priceCompareProducts = $this->getProducts($step);

        $content = "";
        foreach ($priceCompareProducts as $priceCompareProduct)
        {
            $parsedProduct = new stPriceCompareProductParser($priceCompareProduct->getProduct());

            if ($parsedProduct->checkProduct() && $parsedProduct->hasProducer())
            {
                $content.= xml_open_tag('product id="'.$parsedProduct->getId().'"');
                $content.= xml_cdata_tag('name', $parsedProduct->getName());
                $content.= xml_cdata_tag('url', $parsedProduct->getUrl());
                $content.= xml_cdata_tag('brand', $parsedProduct->getProducer());
                $content.= xml_tag('categories', xml_tag('category', $parsedProduct->getCategory(" &gt; ", true)));
                $content.= xml_tag('price', $parsedProduct->getPrice(','));
                $content.= xml_tag('photo', $parsedProduct->getPhoto());
                $content.= xml_cdata_tag('description', $parsedProduct->getDescription(true, '<b><strong><i><em><ul><ol><li><u><br>', true));
                $content.= xml_close_tag('product');
            }
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
        return xml_close_tag('products');
    }

    /**
     * Pobieranie infromacji o porównywarce podczas eksportu
     *
     * @param object $object
     * @return integer
     */
    static public function getProduct($object = null)
    {
        return stPriceCompareGenerateFile::getProductForExport(__CLASS__, $object);
    }

    /**
     * Ustawianie infromacji o porównywarce podczas importu
     *
     * @param object $object
     * @param integer $value
     * @return boolean
     */
    static public function setProduct($object = null, $active = 0)
    {
        return stPriceCompareGenerateFile::setProductForImport(__CLASS__, $object, $active);
    }
}