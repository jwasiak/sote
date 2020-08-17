<?php
/** 
 * SOTESHOP/stCrossellingPlugin 
 * 
 * Ten plik należy do aplikacji stCrossellingPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stCrossellingPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stCrosselling.class.php 799 2009-09-28 13:26:35Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/** 
 * Klasa stCrosselling
 *
 * @package     stCrossellingPlugin
 * @subpackage  libs
 */
class stCrosselling
{
    /** 
     * Zapisywanie produktów z zamówienia
     *
     * @param   array       $products           tablica z numerami id produktów 
     */
    static public function saveProducts($products = array())
    {
    }

    /** 
     * Pobieranie pojedyńczego produktu, który pasuje do wybranej grupy produktów
     *
     * @param   array       $products           - tablica z numerami id produktów 
     * @return  object      obiekt z danymi produktu
     */
    public function getProduct( $products = array() )
    {
        $c = new Criteria();

        $c->add(CrossellingPeer::FIRST_PRODUCT_ID, $products, Criteria::IN);
        $c->add(CrossellingPeer::SECOUND_PRODUCT_ID, $products, Criteria::NOT_IN);
        $c->addGroupByColumn(CrossellingPeer::SECOUND_PRODUCT_ID);
        $c->addAsColumn("MAX","MAX(".CrossellingPeer::SUM.")");
        $c->addDescendingOrderByColumn('MAX');

        $product = CrossellingPeer::doSelect($c);

        if (!is_array($product) || count($product) == 0)
        {
            return false;
        }

        $c = new Criteria();
        $c->add(ProductPeer::ID, $product[rand(0, count($product)-1)]->getSecoundProductId());
        $c->add(ProductPeer::ACTIVE, 1);
        return ProductPeer::doSelectOne($c);
    }

    /** 
     * Pobieranie kilku produktów, które pasują do wybranej grupy produktów
     *
     * @param   array       $products           - tablica z numerami id produktów 
     * @param   integer     $limit              liczba produków, które mają zostać zwrócone 
     * @return  object      obiekt z danymi produktów 
     */
    static public function getProducts($products = array(), $limit = 6)
    {
        $c = new Criteria();
        $c->add(CrossellingPeer::FIRST_PRODUCT_ID, $products, Criteria::IN);
        $c->add(CrossellingPeer::SECOUND_PRODUCT_ID, $products, Criteria::NOT_IN);
        $c->addGroupByColumn(CrossellingPeer::SECOUND_PRODUCT_ID);
        $c->addAsColumn("MAX","MAX(".CrossellingPeer::SUM.")");
        $c->addDescendingOrderByColumn('MAX');
        $c->setLimit($limit);

        $products = CrossellingPeer::doSelect($c);

        if (!is_array($products) || count($products) == 0)
        {
            return array();
        }

        $c = new Criteria();
        foreach ($products as $product)
        {
            $c->addOr(ProductPeer::ID, $product->getSecoundProductId());
        }
        $c->addAnd(ProductPeer::ACTIVE, 1);
        return ProductPeer::doSelect($c);
    }
    
    /** 
     * Pobieranie numerów id produktów, które pasują do wybranej grupy produktów
     *
     * @param   array       $products           - tablica z numerami id produktów 
     * @param   integer     $limit              liczba produków, które mają zostać zwrócone 
     * @return  object      obiekt z danymi produktów 
     */
    public function getProductsId($products = array(), $limit = 6)
    {
        $c = new Criteria();
        $c->add(CrossellingPeer::FIRST_PRODUCT_ID, $products, Criteria::IN);
        $c->add(CrossellingPeer::SECOUND_PRODUCT_ID, $products, Criteria::NOT_IN);
        $c->addGroupByColumn(CrossellingPeer::SECOUND_PRODUCT_ID);
        $c->addAsColumn("MAX","MAX(".CrossellingPeer::SUM.")");
        $c->addDescendingOrderByColumn('MAX');
        $c->setLimit($limit);

        $products = CrossellingPeer::doSelect($c);

        if (!is_array($products) || count($products) == 0) return array();

        $productsId = array();
        foreach ($products as $product) $productsId[] = $product->getSecoundProductId();
        
        return $productsId;
    }

    /** 
     * Pobieranie informacji o istnieniu produktów
     *
     * @return   bool
     */
    static public function hasProductsInBasket()
    {
        $context = sfContext::getInstance();
        $stBasket = stBasket::getInstance($context->getUser());
        
        if (count($stBasket->getItems()) > 0)
        {
            $products = $stBasket->getItems();

            $productsIdArray = array();

            foreach ($products as $productId => $product) {
                $productsIdArray[] = $product->getProductId();
            }

            $stCrosselling = new stCrosselling();
            
            if (count($stCrosselling->getProducts($productsIdArray,1))>0)
            {
                return true;
            }
        }
        return false;
    }
}