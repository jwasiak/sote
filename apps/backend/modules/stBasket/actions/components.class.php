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
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: components.class.php 5372 2010-06-01 08:24:52Z marcin $
 */

/** 
 * Komponenty aplikacji stBasket
 *
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 *
 * @package     stBasket
 * @subpackage  actions
 */
class stBasketComponents extends autostBasketComponents
{
    protected static $basket = null;
    /** 
     * Wyświetla łączną kwotę koszyka
     *
     * @return   
     */
    public function executeItemsTotalAmount()
    {
        $this->amount = 0;
        
        $items = $this->basket->getBasketProducts();
        
        foreach ($items as $item)
        {
            $this->amount += $item->getTotalAmount(true);
        }
    }
    
    /** 
     * Wyświetla łączną ilość produktów w koszyku
     *
     * @return   
     */
    public function executeItemsTotalQuantity()
    {
        $this->quantity = 0;
        
        $items = $this->basket->getBasketProducts();
        
        foreach ($items as $item)
        {
            $this->quantity += $item->getQuantity();
        }
    }    
    
    public function executeBasketClient()
    {
        if (is_null(self::$basket))
        {
            $c = new Criteria();
            $c->add(BasketPeer::ID, $this->forward_parameters['basket_id']);
            $basket = BasketPeer::doSelectJoinAll($c);
            self::$basket = $basket[0];
        }
        
        $this->basket = self::$basket;
    }
    
    public function executeBasketDate()
    {
        if (is_null(self::$basket))
        {
            $c = new Criteria();
            $c->add(BasketPeer::ID, $this->forward_parameters['basket_id']);
            $basket = BasketPeer::doSelectJoinAll($c);
            self::$basket = $basket[0];
        }
        
        $this->basket = self::$basket;
    }
}
