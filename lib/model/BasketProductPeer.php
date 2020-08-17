<?php
/** 
 * SOTESHOP/stBasket 
 * 
 * Ten plik należy do aplikacji stBasket opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stBasket
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: BasketProductPeer.php 34 2009-08-24 14:00:47Z marcin $
 */

/** 
 * Klasa odpowiedzialna za operacje bazodanowe na tabeli 'st_basket_product'
 *
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 *
 * @package     stBasket
 * @subpackage  libs
 */
class BasketProductPeer extends BaseBasketProductPeer
{
    public static function doSelectProductIds(Basket $basket)
    {
        $c = new Criteria();
        $c->addSelectColumn(self::PRODUCT_ID);
        $c->add(self::BASKET_ID, $basket->getId());
        $rs = self::doSelectRS($c);
        
        $ids = array();

        while($rs->next())
        {
            $ids[] = $rs->getInt(1);
        }

        return $ids;
    }

    public static function doSelectJoinProduct(\Criteria $c, $con = null)
    {
        if (SF_APP == 'frontend')
        {
            self::setPostHydrateMethod(function(BasketProduct $basketProduct) {
                $product = $basketProduct->getProduct();

                if ($product && $product->getOptHasOptions() > 1)
                {
                    ProductOptionsValue::setProductPool($product);
            
                    $options = $basketProduct->getProductOptions();
            
                    if ($options)
                    {
                        stNewProductOptions::updateProductBySelectedOptions($product, $options);
                    }
                }

                return $basketProduct;
            });
        }

        $results = parent::doSelectJoinProduct($c, $con);

        self::setPostHydrateMethod(null);

        return $results;
    }
}