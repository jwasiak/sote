<?php
/**
 * SOTESHOP/stZakupomatPlugin
 *
 * Ten plik należy do aplikacji stZakupomatPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stZakupomatPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stZakupomat.class.php 10 2009-08-24 09:32:18Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stZakupomat
 *
 * @package     stZakupomatPlugin
 * @subpackage  libs
 */
class stZakupomat extends stPriceCompareGenerateFile implements stPriceCompareGenerateFileInterface
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
        $content.= xml_open_tag('!DOCTYPE zakupomat SYSTEM "http://zakupomat.pl/zakupomat.dtd"');
        $content.= xml_open_tag('zakupomat version="1"');
        $content.= xml_open_tag('meta');
        $content.= xml_open_tag('generator version="1.0"');
        $content.= xml_cdata('SOTESHOP version 5.0');
        $content.= xml_close_tag('generator');
        $content.= xml_close_tag('meta');
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
                $productContent = xml_open_tag('offer id="'.$parsedProduct->getId().'" available="yes"');
                $productContent.= xml_tag('name', $parsedProduct->getName());
                $productContent.= xml_tag('url', $parsedProduct->getUrl());
                $productContent.= xml_tag('price', $parsedProduct->getPrice());
                $productContent.= xml_tag('category', $parsedProduct->getCategory('|'));
                $productContent.= xml_close_tag('offer');
                 
                $content.= $productContent;
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
        return xml_close_tag('zakupomat');
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