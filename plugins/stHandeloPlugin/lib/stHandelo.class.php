<?php
/**
 * SOTESHOP/stHandeloPlugin
 *
 * Ten plik należy do aplikacji stHandeloPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stHandeloPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stHandelo.class.php 10 2009-08-24 09:32:18Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stHandelo
 *
 * @package     stHandeloPlugin
 * @subpackage  libs
 */
class stHandelo extends stPriceCompareGenerateFile implements stPriceCompareGenerateFileInterface
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
        $content = xml_open_tag('?xml version="1.0" encoding="ISO-8859-2"?');
        $content.= xml_open_tag('handelo');
        $content.= xml_open_tag('products');
        return mb_convert_encoding($content, 'ISO-8859-2', 'UTF-8');
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
                $productContent = xml_cdata_tag('name', $parsedProduct->getName());
                $productContent.= xml_cdata_tag('id', $parsedProduct->getId());
                $productContent.= xml_cdata_tag('description', $parsedProduct->getDescription());
                $productContent.= xml_cdata_tag('price', $parsedProduct->getPrice());
                $productContent.= xml_cdata_tag('categoryId', $parsedProduct->getCategory());
                $productContent.= xml_cdata_tag('categories_id', $parsedProduct->getCategoryId());
                $productContent.= xml_cdata_tag('producer', $parsedProduct->getProducer());
                $productContent.= xml_cdata_tag('image', $parsedProduct->getPhoto());
                $productContent.= xml_cdata_tag('quantity', $parsedProduct->getStock());

                $content.= xml_tag('product', $productContent);
            }
            unset($parsedProduct);
        }
        return mb_convert_encoding($content, 'ISO-8859-2', 'UTF-8');
    }

    /**
     * Generowanie stopki pliku
     *
     * @return string
     */
    protected function getFileFoot()
    {
        $content = xml_close_tag('products');
        $content.= xml_close_tag('handelo');
        return mb_convert_encoding($content, 'ISO-8859-2', 'UTF-8');
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