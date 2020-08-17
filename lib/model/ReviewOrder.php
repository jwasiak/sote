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
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: ReviewOrder.php 9950 2010-12-22 10:19:03Z piotr $
 */

/**
 * stReview actions.
 *
 * @author Paweł Byszewski <pawel.byszewski@sote.pl>, Krzysztof Beblo <krzysztof.beblo@sote.pl>  
 *
 * @package     stReview
 * @subpackage  libs
 */
class ReviewOrder extends BaseReviewOrder
{
    public function getDescription()
    {
    	return stXssSafe::clean($this->description);
    }
}
