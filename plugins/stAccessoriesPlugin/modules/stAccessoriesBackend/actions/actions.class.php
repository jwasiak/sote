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
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: actions.class.php 305 2009-09-04 12:49:07Z michal $
 * @author      Krzysztof Bebło <krzysztof.beblo@sote.pl>
 */

/** 
 * Akcje modułu akcesoria
 *
 * @author Krzysztof Bebło <krzysztof.beblo@sote.pl>  
 *
 * @package     stAccessoriesPlugin
 * @subpackage  actions
 */
class stAccessoriesBackendActions extends stActions 
{
    /** 
     * Dodaje akcesoria do produktu
     *
     * @return  przekierowuje na strone akcesorii dodanych produktów  
     */
    public function executeAddAccessories()
    {
        
        $product_id = $this->getRequestParameter('forward_parameters[product_id]');
        
        $accessories = $this->getRequestParameter('product[selected]', array());
        

        if (empty($accessories))
        {
            $this->redirect($this->getRequest()->getReferer());
        }
        
        foreach ($accessories as $id)
        {
            $product_accessories = new ProductHasAccessories();
            $product_accessories->setProductId($product_id);
            $product_accessories->setAccessoriesId($id);
            $product_accessories->save();
        }
        
        return $this->redirect('stProduct/productInAccessoriesList?product_id=' . $product_id);
        
    }
}