<?php
/**
 * SOTESHOP/stGroupPriceBackend
 *
 *
 * @package     stGroupPricePlugin
 * @author      Bartosz Alejski <bartosz.alejski@sote.pl>
 */

class stGroupPriceBackendActions extends autoStGroupPriceBackendActions {
    
    public function executeShowProducts() {
        return $this -> redirect('stProduct/list?filters[group_price_id]=' . $this -> getRequestParameter('id'));
    }

    public function executeChangePrice() {
        sfLoader::loadHelpers('stCurrency', 'stPrice', 'stProduct');
        $i18n = sfI18N::getInstance();

        $this -> updateGroupPrice();

        if ($this -> getRequestParameter('group_price_id')) {

            return $this -> redirect('stGroupPriceBackend/setNewPrice?group_price_id=' . $this -> getRequestParameter('group_price_id') . '&currency_id=' . $this -> getRequestParameter('currency_id'). '&matrix_on='. $this -> getRequestParameter('matrix_on'));
        }

    }

    public function executeSaveChangePrice() {
        return $this -> forward('stGroupPriceBackend', 'changePrice');
    }


    public function validateChangePrice() {
        $ok = true;
        if ($this -> getRequest() -> getMethod() == sfRequest::POST) {

            $i18n = $this -> getContext() -> getI18N();

            $price = $this -> getRequestParameter('group[new_price]');

            if (!$price) {
                $this -> getRequest() -> setError('group{new_price}', $i18n -> __('Proszę podać cenę.'));
                $ok = false;
            }

            $reverse_price = strrev($price);

            if ($reverse_price{0} == "%") {

                if ($price{0} != "-" && $price{0} != "+") {
                    $this -> getRequest() -> setError('group{new_price}', $i18n -> __('Wartość procentowa musi zawierać znak + lub -'));
                    $ok = false;
                }

                $value = substr($price, 1, -1);

                $pattern = "/^[0-9]+$/";

                if (preg_match($pattern, $value) != 1) {
                    $this -> getRequest() -> setError('group{new_price}', $i18n -> __('Zła wartość procentowa'));
                    $ok = false;
                }

            }

        }
        return $ok;
    }

    public function handleErrorChangePrice() {
        $this -> updateGroupPrice();
        return sfView::SUCCESS;
    }

    protected function updateGroupPrice() {

        $c = new Criteria();
        $groupPrice = GroupPricePeer::doSelect($c);

        $c = new Criteria();
        $all_currency = CurrencyPeer::doSelect($c);

        foreach ($all_currency as $currency) {
            $array_currency[$currency -> getId()] = $currency -> getShortcut();
        }

        $this -> array_currency = $array_currency;
        $this -> groupPrice = $groupPrice;
        

        $group = $this -> getRequestParameter('group');

        if (isset($group['new_price'])) {
            $this -> new_price = $group['new_price'];
        } else {
            $this -> new_price = "00.00";
        }

        if (isset($group['group_type'])) {
            $this -> group_type = $group['group_type'];
        } else {
            $this -> group_type = "netto";
        }

        if (isset($group['group_currency'])) {
            $this -> group_currency = $group['group_currency'];
        } else {
            $this -> group_currency = "";
        }

    }

    public function executeSetNewPrice() {

        if ($this -> getRequestParameter('matrix_on') == "true") {
           

            $c = new Criteria();
            $c -> add(GroupPricePeer::ID, $this -> getRequestParameter('group_price_id'));
            $groupPrice = GroupPricePeer::doSelectOne($c);

            $this -> groupPriceName = $groupPrice -> getName();

            $c = new Criteria();
            $c -> add(CurrencyPeer::MAIN, 1);
            $currency_main = CurrencyPeer::doSelectOne($c);

            if ($this -> getRequestParameter('currency_id') != "" && $this -> getRequestParameter('currency_id') != $currency_main -> getId()) {
                $c = new Criteria();
                $c -> add(AddGroupPricePeer::ID, $this -> getRequestParameter('group_price_id'));
                $c -> add(AddGroupPricePeer::CURRENCY_ID, $this -> getRequestParameter('currency_id'));
                $groupPrice = AddGroupPricePeer::doSelectOne($c);
            }

            // print_r($groupPrice);
            // die();

            $group_price['id'] = $groupPrice -> getId();
            $group_price['set_one_price'] = "false";
            $group_price['currency_id'] = $groupPrice -> getCurrencyId();
            $group_price['tax_id'] = $groupPrice -> getTaxId();
            $group_price['opt_vat'] = $groupPrice -> getOptVat();
            $group_price['price_netto'] = $groupPrice -> getPriceNetto();
            $group_price['price_brutto'] = $groupPrice -> getPriceBrutto();
            $group_price['old_price_netto'] = $groupPrice -> getOldPriceNetto();
            $group_price['old_price_brutto'] = $groupPrice -> getOldPriceBrutto();
            $group_price['wholesale_a_price_netto'] = $groupPrice -> getWholesaleANetto();
            $group_price['wholesale_a_price_brutto'] = $groupPrice -> getWholesaleABrutto();
            $group_price['wholesale_b_price_netto'] = $groupPrice -> getWholesaleBNetto();
            $group_price['wholesale_b_price_brutto'] = $groupPrice -> getWholesaleBBrutto();
            $group_price['wholesale_c_price_netto'] = $groupPrice -> getWholesaleCNetto();
            $group_price['wholesale_c_price_brutto'] = $groupPrice -> getWholesaleCBrutto();

            $c = new Criteria();
            $c -> add(ProductPeer::GROUP_PRICE_ID, $this -> getRequestParameter('group_price_id'));
            $this -> count = ProductPeer::doCount($c);

            stChangePriceProgressBar::setParam('group_price', $group_price);
        }

        if ($this -> getRequestParameter('matrix_on') == "false" ) {

            $group = $this -> getRequestParameter('group');
            
            
            $price = $this -> getRequestParameter('new_price');

            $price = trim($price);

            if ($price{0} == "+") {
                $prefix = "+";
                $value = substr($price, 1);
            } elseif ($price{0} == "-") {
                $prefix = "-";
                $value = substr($price, 1);
            } else {
                $prefix = "false";
                $value = $price;
            }

            $reverse_price = strrev($price);

            if ($reverse_price{0} == "%") {

                $value = substr($price, 1, -1);

                $sufix = "true";
            } else {
                $sufix = "false";
            }

            $c = new Criteria();
            $c -> add(GroupPricePeer::ID, $this -> getRequestParameter('group_price_id'));
            $groupPrice = GroupPricePeer::doSelectOne($c);
            
            $this -> groupPriceName = $groupPrice -> getName();

            $c = new Criteria();
            $c -> add(CurrencyPeer::MAIN, 1);
            $currency_main = CurrencyPeer::doSelectOne($c);

            if ($this -> getRequestParameter('currency_id') != "" && $this -> getRequestParameter('currency_id') != $currency_main -> getId()) {
                $c = new Criteria();
                $c -> add(AddGroupPricePeer::ID, $this -> getRequestParameter('group_price_id'));
                $c -> add(AddGroupPricePeer::CURRENCY_ID, $this -> getRequestParameter('currency_id'));
                $groupPrice = AddGroupPricePeer::doSelectOne($c);
            }

            $group_price['id'] = $groupPrice -> getId();
            $group_price['currency_id'] = $groupPrice -> getCurrencyId();
            $group_price['tax_id'] = $groupPrice -> getTaxId();
            $group_price['opt_vat'] = $groupPrice -> getOptVat();
            $group_price['set_one_price'] = "true";
            $group_price['type'] = $this -> getRequestParameter('type');
            $group_price['value'] = $value;
            $group_price['prefix'] = $prefix;
            $group_price['sufix'] = $sufix;


            $c = new Criteria();
            $c -> add(ProductPeer::GROUP_PRICE_ID, $this -> getRequestParameter('group_price_id'));
            $this -> count = ProductPeer::doCount($c);

            stChangePriceProgressBar::setParam('group_price', $group_price);
        }

    }

    public function redirect($url, $statusCode = 302) {
        if ($this -> getRequestParameter('save_and_add')) {
           
           
           
           if($this -> getRequestParameter('add_group_price[currency_id]'))
           {
               $currency_id = $this -> getRequestParameter('add_group_price[currency_id]');
           }else{
               $currency_id = $this -> getRequestParameter('currency_id');
           }
           
           if($this -> getRequestParameter('group[matrix_on]')=="true"){
                $url = 'stGroupPriceBackend/setNewPrice?group_price_id=' . $this -> getRequestParameter('id'). '&matrix_on='.$this -> getRequestParameter('group[matrix_on]') . '&currency_id=' . $currency_id;
           }else{
                $url = 'stGroupPriceBackend/setNewPrice?group_price_id=' . $this -> getRequestParameter('id'). '&matrix_on='.$this -> getRequestParameter('group[matrix_on]') . '&type=' . $this -> getRequestParameter('group[type]') . '&new_price=' . urlencode($this -> getRequestParameter('group[new_price]')) . '&currency_id=' . $currency_id;
           }
           
        }
        

        return parent::redirect($url, $statusCode);

    }

    protected function updateGroupPriceFromRequest() {
        $group_price = $this -> getRequestParameter('group_price');
        $group = $this -> getRequestParameter('group');
       

        if (isset($group_price['name'])) {
            $this -> group_price -> setName($group_price['name']);
        }

        if (isset($group_price['price_netto'])) {
            if (method_exists($this -> group_price, 'setPriceNetto')) {
                $this -> group_price -> setPriceNetto($group_price['price_netto']);
            }
        }

        if (isset($group_price['price_brutto'])) {
            if (method_exists($this -> group_price, 'setPriceBrutto')) {
                $this -> group_price -> setPriceBrutto($group_price['price_brutto']);
            }
        }

        if (isset($group_price['old_price_netto'])) {
            if (method_exists($this -> group_price, 'setOldPriceNetto')) {
                $this -> group_price -> setOldPriceNetto($group_price['old_price_netto']);
            }
        }

        if (isset($group_price['old_price_brutto'])) {
            if (method_exists($this -> group_price, 'setOldPriceBrutto')) {
                $this -> group_price -> setOldPriceBrutto($group_price['old_price_brutto']);
            }
        }

        if (isset($group_price['wholesale']['a']['netto'])) {
            if (method_exists($this -> group_price, 'setWholesaleANetto')) {
                $this -> group_price -> setWholesaleANetto($group_price['wholesale']['a']['netto']);
            }
        }

        if (isset($group_price['wholesale']['a']['brutto'])) {
            if (method_exists($this -> group_price, 'setWholesaleABrutto')) {
                $this -> group_price -> setWholesaleABrutto($group_price['wholesale']['a']['brutto']);
            }
        }

        if (isset($group_price['wholesale']['b']['netto'])) {
            if (method_exists($this -> group_price, 'setWholesaleBNetto')) {
                $this -> group_price -> setWholesaleBNetto($group_price['wholesale']['b']['netto']);
            }
        }

        if (isset($group_price['wholesale']['b']['brutto'])) {
            if (method_exists($this -> group_price, 'setWholesaleBBrutto')) {
                $this -> group_price -> setWholesaleBBrutto($group_price['wholesale']['b']['brutto']);
            }
        }

        if (isset($group_price['wholesale']['c']['netto'])) {
            if (method_exists($this -> group_price, 'setWholesaleCNetto')) {
                $this -> group_price -> setWholesaleCNetto($group_price['wholesale']['c']['netto']);
            }
        }

        if (isset($group_price['wholesale']['c']['brutto'])) {
            if (method_exists($this -> group_price, 'setWholesaleCBrutto')) {
                $this -> group_price -> setWholesaleCBrutto($group_price['wholesale']['c']['brutto']);
            }
        }

        if (isset($group_price['description'])) {
            $this -> group_price -> setDescription($group_price['description']);
        }

        if (isset($group_price['tax_id'])) {
            $this -> group_price -> setTaxId($group_price['tax_id']);
            
            $c = new Criteria();
            $c -> add(TaxPeer::ID, $group_price['tax_id']);
            $vat = TaxPeer::doSelectOne($c);

            $this -> group_price -> setOptVat($vat -> getVat());
        }

        $c = new Criteria();
        $c -> add(CurrencyPeer::MAIN, 1);
        $currency_main = CurrencyPeer::doSelectOne($c);

        $this -> group_price -> setCurrencyId($currency_main -> getId());

        $this -> getDispatcher() -> notify(new sfEvent($this, 'autoStGroupPriceBackendActions.postUpdateFromRequest', array('modelInstance' => $this -> group_price, 'requestParameters' => $group_price)));
    }


    public function validateEdit() {
        $ok = true;
        if ($this -> getRequest() -> getMethod() == sfRequest::POST && $this -> getRequest() ->getParameter('group[matrix_on]') == "false") {


            $i18n = $this -> getContext() -> getI18N();

            $price = $this -> getRequestParameter('group[new_price]');

            $pattern = "/^[-+]{0,1}[0-9.]{1,}\%{0,1}$/";
            
            if (preg_match($pattern, $price) != 1) {
                    $this -> getRequest() -> setError('group{new_price}', $i18n -> __('Zła wartość'));
                   $ok = false;
            }


            if (!$price) {
                $this -> getRequest() -> setError('group{new_price}', $i18n -> __('Proszę podać cenę.'));
                $ok = false;
            }

            $reverse_price = strrev($price);

            if ($reverse_price{0} == "%") {

                if ($price{0} != "-" && $price{0} != "+") {
                    $this -> getRequest() -> setError('group{new_price}', $i18n -> __('Wartość procentowa musi zawierać znak + lub -'));
                    $ok = false;
                }

                $value = substr($price, 1, -1);

                $pattern = "/^[0-9]+$/";

                if (preg_match($pattern, $value) != 1) {
                    $this -> getRequest() -> setError('group{new_price}', $i18n -> __('Zła wartość procentowa'));
                    $ok = false;
                }
                
                if ($price{0} == "-" && $value > 100 ) {
                    $this -> getRequest() -> setError('group{new_price}', $i18n -> __('Zła wartość procentowa'));
                    $ok = false;
                }

            }

        }
        return $ok;
    }


     public function validateAddGroupPriceEdit() {
        $ok = true;
        if ($this -> getRequest() -> getMethod() == sfRequest::POST && $this -> getRequest() ->getParameter('group[matrix_on]') == "false") {


            $i18n = $this -> getContext() -> getI18N();

            $price = $this -> getRequestParameter('group[new_price]');

            $pattern = "/^[-+]{0,1}[0-9.]{1,}\%{0,1}$/";
            
            if (preg_match($pattern, $price) != 1) {
                    $this -> getRequest() -> setError('group{new_price}', $i18n -> __('Zła wartość'));
                   $ok = false;
            }


            if (!$price) {
                $this -> getRequest() -> setError('group{new_price}', $i18n -> __('Proszę podać cenę.'));
                $ok = false;
            }

            $reverse_price = strrev($price);

            if ($reverse_price{0} == "%") {

                if ($price{0} != "-" && $price{0} != "+") {
                    $this -> getRequest() -> setError('group{new_price}', $i18n -> __('Wartość procentowa musi zawierać znak + lub -'));
                    $ok = false;
                }

                $value = substr($price, 1, -1);

                $pattern = "/^[0-9]+$/";

                if (preg_match($pattern, $value) != 1) {
                    $this -> getRequest() -> setError('group{new_price}', $i18n -> __('Zła wartość procentowa'));
                    $ok = false;
                }
                
                if ($price{0} == "-" && $value > 100 ) {
                    $this -> getRequest() -> setError('group{new_price}', $i18n -> __('Zła wartość procentowa'));
                    $ok = false;
                }

            }

        }
        return $ok;
    }

}
