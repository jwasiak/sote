<?php
/** 
 * SOTESHOP/stAccessoriesPlugin 
 * 
 * Ten plik należy do aplikacji stAccessoriesPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stAccessoriesPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: ProductHasAccessories.php 306 2009-09-04 14:03:28Z krzysiek $
 * @author      Krzysztof Bebło <krzysztof.beblo@sote.pl>
 */

/** 
 * Subclass for representing a row from the 'st_product_has_accessories' table.
 *
 * @package     stAccessoriesPlugin
 * @subpackage  libs
 */
class ProductHasAccessories extends BaseProductHasAccessories
{
    public function getCode()
    {
        if (is_object($this->getProductRelatedByAccessoriesId())) return $this->getProductRelatedByAccessoriesId()->getCode();
        return null;
    }
}
