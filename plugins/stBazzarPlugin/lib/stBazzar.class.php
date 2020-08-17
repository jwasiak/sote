<?php
/**
 * SOTESHOP/stBazzarPlugin
 *
 * Ten plik należy do aplikacji stBazzarPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stBazzarPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stBazzar.class.php 165 2009-08-31 11:34:45Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stBazzar
 *
 * @package     stBazzarPlugin
 * @subpackage  libs
 */
class stBazzar extends stPriceCompareGenerateFile implements stPriceCompareGenerateFileInterface
{
    /**
     * Konstruktor
     */
    public function __construct()
    {
        parent::__construct(__CLASS__);
    }

    /**
     * Generowanie stopki pliku
     *
     * @return string
     */
    protected function getFileHead()
    {
        $content = xml_open_tag('?xml version="1.0" encoding="ISO-8859-2"?');
        $content.= xml_open_tag('xmldata');
        $content.= xml_tag('version', '10');

        $headerContent = xml_tag('name', $this->getConfig('shop_name'));
        $headerContent.= xml_tag('shopid', $this->getConfig('shop_id'));
        $headerContent.= xml_tag('www', $this->getShopUrl());
        $headerContent.= xml_tag('time', date('Y-m-d'));

        $content.= xml_tag('header', $headerContent);
        $content.= $this->getCategory();
        $content.= xml_open_tag('data');

        return mb_convert_encoding($content, 'ISO-8859-2', 'UTF-8');
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

            if ($parsedProduct->checkProduct())
            {
                $productContent = xml_tag('compid', $parsedProduct->getId());
                if ($parsedProduct->hasProducer()) $productContent.= xml_tag('vendor', $parsedProduct->getProducer());
                $productContent.= xml_tag('desc', htmlspecialchars($parsedProduct->getName()));
                $productContent.= xml_tag('price', $parsedProduct->getPrice());
                $productContent.= xml_tag('catid', $parsedProduct->getCategoryId());
                $productContent.= xml_tag('foto', $parsedProduct->getPhoto());
                 
                $content.= xml_tag('item', $productContent);
            }
            unset($parsedProduct);
        }
        return mb_convert_encoding($content, 'ISO-8859-2', 'UTF-8');
    }

    /**
     * Generowanie nagłówka pliku
     *
     * @return string
     */
    protected function getFileFoot()
    {
        $content = xml_close_tag('data');
        $content.= xml_close_tag('xmldata');
        return mb_convert_encoding($content, 'ISO-8859-2', 'UTF-8');
    }

    /**
     * Generowanie kategorii
     *
     * @return string
     */
    private function getCategory()
    {
        $content = '';

        $c = new Criteria();
        $c->addJoin(ProductPeer::ID, BazzarPeer::PRODUCT_ID, Criteria::JOIN);
        $c->addJoin(ProductPeer::ID, ProductHasCategoryPeer::PRODUCT_ID, Criteria::JOIN);
        $c->add(BazzarPeer::ACTIVE, 1);
        $c->add(ProductHasCategoryPeer::IS_DEFAULT, 1);
        $c->addGroupByColumn(ProductHasCategoryPeer::CATEGORY_ID);
        $products = ProductPeer::doSelect($c);

        foreach ($products as $product)
        {
            if (is_object($product->getDefaultCategory()))
            {
                $categoriesPath = '';

                foreach ($product->getDefaultCategory()->getPath() as $category)
                {
                    if (is_object($category))
                    {
                        $categoryName = $category->getName();
                        if (!empty($categoryName)) $categoriesPath .= $categoryName.'/';
                    }
                }

                $catItemContent = xml_tag('catid', $product->getDefaultCategory()->getId());
                $catItemContent.= xml_tag('catname', $categoriesPath.$product->getDefaultCategory()->getName());
                $catItemContent.= xml_tag('dprice', '');

                $content.= xml_tag('catitem', $catItemContent);
            }
        }
        return mb_convert_encoding(xml_tag('category', $content), 'ISO-8859-2', 'UTF-8');
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