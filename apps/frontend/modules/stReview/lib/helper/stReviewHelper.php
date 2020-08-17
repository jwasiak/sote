<?php
/** 
 * SOTESHOP/stReview 
 * 
 * Ten plik należy do aplikacji stReview opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stReview
 * @subpackage  helpers
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stReviewHelper.php 1153 2009-10-07 08:24:35Z pawel $
 */

/** 
 * stReview actions.
 *
 * @author Paweł Byszewski <pawel.byszewski@sote.pl>, Krzysztof Beblo <krzysztof.beblo@sote.pl>  
 * @package stReview
 * @subpackage actions
 */

/** 
 * Wyświetla zdjęcie produktu w recenzjach
 *
 * @param       integer     $product_id
 * @return   $product
 */
function getOrderProductImage($product_id)
{
    $product = ProductPeer::retrieveByPK($product_id);
    return $product->getImage();
}
/** 
 * Wyświetla ocenzę transakcji
 *
 * @param       integer     $mark
 * @return   string
 */
function getMarkName($mark)
{
    if ($mark == 1)
    {
        return __('pozytywna');
    }
    if ($mark == 2)
    {
        return __('neutralna');
    }
    if ($mark == 3)
    {
        return __('negatywna');
    }
}