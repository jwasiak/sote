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
 * @version     $Id: actions.class.php 34 2009-08-24 14:00:47Z marcin $
 */

/** 
 * Akcja aplikacji stBasket
 *
 * @package     stBasket
 * @subpackage  actions
 */
class stBasketActions extends autostBasketActions
{
    public function executeBasketProductList()
    {
        
        parent::executeBasketProductList();
        
        $this->pager->getCriteria()->add(BasketProductPeer::BASKET_ID, $this->forward_parameters['basket_id']);
        $this->pager->init();
        
    }
}
