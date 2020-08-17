<?php
/** 
 * SOTESHOP/stAddPricePlugin
 * 
 * 
 * @package     stAddPricePlugin
 * @author      Bartosz Alejski <bartosz.alejski@sote.pl>
 */

class appAddGroupPriceBackendComponents extends sfComponents {

    public function executeCurrencySelect() {

        if (!$this -> getRequestParameter('id') && !$this -> getRequestParameter('currency_id')) {

            $c = new Criteria();
            $c -> add(AddGroupPricePeer::ID, $this -> getRequestParameter('group_price_id'));
            $active_currency = AddGroupPricePeer::doSelect($c);

            $array2 = array();
            foreach ($active_currency as $active) {
                $array2[$active -> getCurrencyId()] = $active -> getCurrency() -> getShortcut();
            }

            $c = new Criteria();
            $all_currency = CurrencyPeer::doSelect($c);

            foreach ($all_currency as $currency) {
                if ($currency -> getMain() != 1) {
                    $array1[$currency -> getId()] = $currency -> getShortcut();
                }
            }

            $this -> result = array_diff($array1, $array2);

            $this -> lock_select_currency = 0;
        } else {
            $this -> lock_select_currency = 1;
        }

    }

    public function executeGroupSelect() {

        if (!$this -> getRequestParameter('id')) {

            $c = new Criteria();
            $c -> add(GroupPricePeer::ID, $this -> getRequestParameter('group_price_id'));
            $groupPrice = GroupPricePeer::doSelectOne($c);
            $this->groupPrice = $groupPrice;
        }else{
                    

            $c = new Criteria();
            $c -> add(GroupPricePeer::ID, $this -> getRequestParameter('id'));
            $groupPrice = GroupPricePeer::doSelectOne($c);
            $this->groupPrice = $groupPrice;
        
        }
        
    }

}
