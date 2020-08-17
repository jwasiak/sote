<?php
/** 
 * SOTESHOP/stAvailabilityPlugin 
 * 
 * Ten plik należy do aplikacji stAvailabilityPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stAvailabilityPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stPropelProduct.class.php 617 2009-04-09 13:02:31Z michal $
 */

/** 
 * stDepositoryFrontend
 *
 * @author Krzysztof Bebło <krzysztof.beblo@sote.pl> 
 *
 * @package     stAvailabilityPlugin
 * @subpackage  libs
 */
class stPropelProducts
{
    /** 
     * Pobiera stan magazynowy dla danego produktu
     *
     * @param   object      $product            obiekt produktu
     * @return  integer     stan magazynowy
     */
    public function getAvailability($product)
    {
        $c = new Criteria();
        return AvailabilityPeer::doSelect($c);
    }
}
?>