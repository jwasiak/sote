<?php
/** 
 * SOTESHOP/stAddPricePlugin
 * 
 * 
 * @package     stAddPricePlugin
 * @author      Bartosz Alejski <bartosz.alejski@sote.pl>
 */

class appAddGroupPriceBackendActions extends autoStGroupPriceActions {

    public function executeAdd() {
        $this -> related_object = GroupPricePeer::retrieveByPk($this -> getRequestParameter('group_price_id'));
    }

}
