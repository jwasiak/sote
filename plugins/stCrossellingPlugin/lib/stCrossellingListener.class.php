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
 * @version     $Id: stCrossellingListener.class.php 10 2009-08-24 09:32:18Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stCrossellingListener
 *
 * @package     stCrossellingPlugin
 * @subpackage  libs
 */
class stCrossellingListener
{
    /**
     * Dodanie zakładki do karty produktu
     *
     * @param       sfEvent     $event
     */
    public static function addTabProduct(sfEvent $event)
    {
        $action = $event->getSubject();

        $stCrosselling = new stCrosselling();
        $products = $stCrosselling->getProducts(array($action->getRequestParameter('product_id')));

        if ($products)
        {
            $action->productList->addTab('Klienci, którzy kupili ten produkt, kupili również', 'stCrossellingFrontend', 'showInProductTab', array('product_id' => $action->product->getId()));
        }
    }
}