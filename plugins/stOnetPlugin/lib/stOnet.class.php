<?php
/**
 * SOTESHOP/stOnetPlugin
 *
 * Ten plik należy do aplikacji stOnetPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stOnetPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stOnet.class.php 1706 2009-10-22 15:03:29Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stOnet
 *
 * @package     stOnetPlugin
 * @subpackage  libs
 */
class stOnet extends stPriceCompareGenerateFile implements stPriceCompareGenerateFileInterface
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
        $content.= xml_open_tag('oferty aktualizacja="N" xmlns="http://www.zakupy.onet.pl/walidacja/oferty-partnerzy.xsd"');
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
                if ($parsedProduct->getPrice() > 0)
                {
                    $productContent = xml_tag('identyfikator', $parsedProduct->getId());
                    $productContent.= xml_cdata_tag('nazwa', $parsedProduct->getName());
                    $productContent.= xml_tag('url', $parsedProduct->getUrl());
                    $productContent.= xml_tag('cena', $parsedProduct->getPrice());
                    $productContent.= xml_tag('sciezka_kategorii', $parsedProduct->getCategory());
                    $productContent.= xml_tag('id_kategorii_sklepu', $parsedProduct->getCategoryId());
                    $productContent.= xml_tag('marka_producent', $parsedProduct->getProducer());
                    if (strlen($parsedProduct->getDescription(true)) >= 5) $productContent.= xml_cdata_tag('opis', $parsedProduct->getDescription(true));
                    if ($parsedProduct->getPhoto(false)) $productContent.= xml_tag('zdjecie', $parsedProduct->getPhoto(false));

                    $content.= xml_tag('oferta', $productContent);
                }
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
        return xml_close_tag('oferty');
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