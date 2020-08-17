<?php
/**
 * SOTESHOP/stLukasPlugin
 *
 * Ten plik należy do aplikacji stLukasPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stLukasPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stLukas.class.php 10 2009-08-24 09:32:18Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa LukasProductPeer
 *
 * @package stLukasPlugin
 * @subpackage libs
 */
class LukasProductPeer extends BaseLukasProductPeer
{
	/**
	 * Pobieranie LukasProduct na podstawie obiektu Produkt lub id produktu
	 * 
	 * @param mixed $product Product, id 
	 * @return LukasProduct
	 */
	public static function doSelectByProduct($product)
	{
		if ($product instanceof Product) $id = $product->getId();
		else $id = $product;
		
		$c = new Criteria();
        $c->add(LukasProductPeer::PRODUCT_ID, $id);
        return LukasProductPeer::doSelectOne($c);
	}
}