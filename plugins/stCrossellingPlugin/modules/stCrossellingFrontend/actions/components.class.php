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
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: components.class.php 2904 2010-01-07 13:40:03Z bartek $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Komponent stCrossellingFrontendComponents
 *
 * @package     stCrossellingPlugin
 * @subpackage  actions
 */
class stCrossellingFrontendComponents extends sfComponents
{
    /**
     * Wyświetlanie produktów w koszyku
     */
    public function executeShowProductsInBasket()
    {
        $this->smarty = new stSmarty('stCrossellingFrontend');
        $this->productSmarty = new stSmarty('stProduct');

        $context = sfContext::getInstance();
        $products = stBasket::getInstance($context->getUser())->getItems();
        $stCrosselling = new stCrosselling();
        $this->productConfig = stConfig::getInstance($context, 'stProduct');

        $productsIdArray = array();
        foreach ($products as $product) $productsIdArray[] = $product->getProductId();

        $c = new Criteria();
        $c->add(ProductGroupPeer::PRODUCT_GROUP, 'BASKET');
        $basketGroup = ProductGroupPeer::doSelectOneCached($c);

        if (is_object($basketGroup) && ($basketGroup->getProductLimit())) $limit = $basketGroup->getProductLimit();
        else $limit = 6;

        $c = new Criteria();
        $c->add(ProductPeer::ID, $stCrosselling->getProductsId($productsIdArray), Criteria::IN);
        $c->addAscendingOrderByColumn('RAND()');
        $this->pager = new sfPropelPager('Product', $limit);
        $this->pager->setCriteria($c);
        $this->pager->init();
        
        $this->productSmarty->register_function('st_product_image_tag', 'st_product_smarty_image_tag');
    }
}