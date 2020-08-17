<?php

/** 
 * SOTESHOP/stOrder 
 * 
 * Ten plik należy do aplikacji stOrder opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stOrder
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: OrderCurrency.php 10276 2011-01-14 13:33:48Z marcin $
 */

/** 
 * SOTESHOP/stOrder
 * Ten plik należy do aplikacji stOrder opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stOrder
 * @subpackage  libs
 */
class OrderCurrency extends BaseOrderCurrency
{
    public function __toString()
    {
        return $this->getName();
    }
    
    /** 
     * Zwraca cenę uwzględniajac walutę w jakiej zostało złożone zamówienie
     *
     * @param                float       $price              Cena
     * @return   float
     */
    public function getPrice($price)
    {
        return stCurrency::calculateCurrencyPrice($price, $this->getExchange());
    }

    public function exchange($amount, $reversed = false)
    {
        return stCurrency::calculateCurrencyPrice($amount, $this->getExchange(), $reversed);
    }
}
