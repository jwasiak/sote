<?php

class stTrustedShopsFrontendActions extends stActions {

    public function executeAjaxBasketUpdate() {

        $this->getUser()->setAttribute('ts_buyer_protection', $this->getRequestParameter('ts_checked', false) == "checked" ? true : false, 'soteshop/stTrustedShopsPlugin');

        $basket = stBasket::getInstance($this->getUser());

        $basket_params = array('basket' => $basket);

        if(stTheme::is_responsive()){
            $this->responseUpdateElement('shopping-cart-summary', array('module' => 'stDeliveryFrontend','component'=> 'basketSummary', 'params' => $basket_params));    
        }else{
            $this->responseUpdateElement('st_basket-summary', array('module' => 'stDeliveryFrontend','component'=> 'basketSummary', 'params' => $basket_params));    
        }
        
        
        
        

        return $this->renderResponse();
    }
}
