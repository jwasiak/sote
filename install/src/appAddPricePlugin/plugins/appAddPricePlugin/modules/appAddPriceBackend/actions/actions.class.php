<?php
/** 
 * SOTESHOP/stAddPricePlugin
 * 
 * 
 * @package     stAddPricePlugin
 * @author      Bartosz Alejski <bartosz.alejski@sote.pl>
 */

class appAddPriceBackendActions extends autoStProductActions {

    public function executeAdd() {
        $this -> related_object = ProductPeer::retrieveByPk($this -> getRequestParameter('product_id'));
    }

}
