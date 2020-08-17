<?php
/**
 * SOTESHOP/stPromoteProductsInBasketPlugin
 *
 * Ten plik należy do aplikacji stPromoteProductsInBasketPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stPromoteProductsInBasket
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: components.class.php 800 2009-09-28 13:27:10Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stPromoteProductsInBasketComponents
 *
 * @package     stPromoteProductsInBasket
 * @subpackage  actions
 */
class stPromoteProductsInBasketComponents extends sfComponents
{
    /**
     * Wyświetlanie produtków w koszyku
     */
    public function executeShowProducts()
    {
        $this->smarty = new stSmarty('stPromoteProductsInBasket');

        $basketConfig = stConfig::getInstance('stBasket');

        if(class_exists('stCrosselling') && stCrosselling::hasProductsInBasket() && $basketConfig->get('show_crosseling'))
        {
            $this->moduleName = 'stCrossellingFrontend';
            $this->componentName = 'showProductsInBasket';
        } else {
            $this->moduleName = 'stProduct';
            $this->componentName = 'productInBasketGroup';
        }
    }
}