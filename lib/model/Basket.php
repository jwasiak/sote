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
 * @version     $Id: Basket.php 14825 2011-08-26 09:40:29Z marcin $
 */

/** 
 * Klasa reprezentujaca wiersz dla tabeli 'st_basket'
 *
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 *
 * @package     stBasket
 * @subpackage  libs
 */
class Basket extends BaseBasket
{
    /** 
     * Usuwa produkt o danym id z koszyka
     *
     * @param       integer     $product_id
     */
    public function removeBasketProductByProductId($product_id)
    {
        foreach ($this->collBasketProducts as $index => $basket_product)
        {
            if ($basket_product->getProductId() == $product_id)
            {
                unset($this->collBasketProducts[$index]);
            }
        }
    }

    public function clearCollBasketProducts()
    {
        $this->collBasketProducts = null;
    }
    
    public function addBasketProduct(BasketProduct $l, $criteria_update = false)
    {
       parent::addBasketProduct($l);
       
       if ($criteria_update)
       {
          $c = new Criteria();
          
          $c->addAscendingOrderByColumn(BasketProductPeer::ID);
          
          $c->add(BasketProductPeer::BASKET_ID, $this->getId());
          
          $this->lastBasketProductCriteria = $c;
       }
    }    
}
