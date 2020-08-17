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
 * @version     $Id: Review.php 13699 2011-06-20 10:05:44Z bartek $
 */

/** 
 * stReview actions.
 *
 * @author Paweł Byszewski <pawel.byszewski@sote.pl>, Krzysztof Beblo <krzysztof.beblo@sote.pl>  
 *
 * @package     stReview
 * @subpackage  libs
 */
class Review extends BaseReview
{
    /** 
     * Jeśli nie ma klienta przy dodanej recenzji to ustawia administratora
     *
     * @param          bool        $con
     */
    public function save($con = null) {
        if (!$this->getSfGuardUserId()){
        $this->setAdminActive(1);
        }
        parent::save();
    }
    
    public function getDescription()
    {

        $action = sfContext::getInstance()->getActionName();

        if (SF_APP == 'backend') {
            if ($action == 'list' || $action == 'reviewList') {
                return strip_tags($this->description);
            } else {
            return $this->description;
        }}

        if (SF_APP == 'frontend' && $action == 'listReviews') {
            return $this->description;
        } else {
            return strip_tags($this->description);
        }
    }
}