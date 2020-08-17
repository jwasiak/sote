<?php
/** 
 * SOTESHOP/stDiscountPlugin 
 * 
 * Ten plik należy do aplikacji stDiscountPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stDiscountPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: DiscountHasProduct.php 10 2009-08-24 09:32:18Z michal $
 */

class DiscountHasProduct extends BaseDiscountHasProduct
{
    public function save($con = null)
    {
        $ret = parent::save($con);
        stFastCacheManager::clearCache();
        return $ret;
    }

    public function delete($con = null)
    {
        $ret = parent::delete($con);
        stFastCacheManager::clearCache();
        return $ret;
    }
}
