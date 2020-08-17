<?php
/** 
 * SOTESHOP/stAddPricePlugin
 * 
 * 
 * @package     stAddPricePlugin
 * @author      Bartosz Alejski <bartosz.alejski@sote.pl>
 */

class appAddPriceBackendComponents extends sfComponents {

    public function executeCurrencySelect() {

        if (!$this -> getRequestParameter('id') && !$this -> getRequestParameter('currency_id')) {

            $c = new Criteria();
            $c -> add(AddPricePeer::ID, $this -> getRequestParameter('product_id'));
            $active_currency = AddPricePeer::doSelect($c);
            
            $array2 = array();
            foreach ($active_currency as $active) {
                $array2[$active->getCurrencyId()]=$active->getCurrency() -> getShortcut();
            }

            $product_currency_id = $this->related_object->getCurrency()->getId();

            $c = new Criteria();
            $c->add(CurrencyPeer::ID, $product_currency_id, Criteria::NOT_EQUAL);
            $all_currency = CurrencyPeer::doSelect($c);

            foreach ($all_currency as $currency) {
                $array1[$currency -> getId()] = $currency -> getShortcut(); 
            }

            $this->result = array_diff($array1, $array2);

            $this -> lock_select_currency = 0;
        } else {
            $this -> lock_select_currency = 1;
        }

    }

}
