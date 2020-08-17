<?php
class stPoints {

    static public function updateUserPoints($sf_guard_user, $points_assign = 0) {

        if (is_object($sf_guard_user)) {

            $points_value = substr($points_assign, 1);

            if ($points_assign{0} == "-") {
                $new_user_points = $sf_guard_user -> getPoints() - $points_value;
            }

            if ($points_assign{0} == "+") {
                $new_user_points = $sf_guard_user -> getPoints() + $points_value;
            }

            if ($points_assign{0} != "+" && $points_assign{0} != "-") {
                $new_user_points = $sf_guard_user -> getPoints() + $points_assign;
            }

            $sf_guard_user -> setPoints($new_user_points);
            $sf_guard_user -> save();

        }

    }

    static public function registerUpdatePoints($sf_guard_user, $order = false, $description = "") {

        $i18n = sfContext::getInstance() -> getI18n();

        $c = new Criteria();
        $c -> add(UserPointsPeer::SF_GUARD_USER_ID, $sf_guard_user -> getId());
        $c -> addDescendingOrderByColumn(UserPointsPeer::CREATED_AT);
        $lastPoints = UserPointsPeer::doSelectOne($c);

        if ($lastPoints) {
            if ($sf_guard_user -> getPoints() != $lastPoints -> getPoints()) {

                if ($lastPoints -> getPoints() > $sf_guard_user -> getPoints()) {
                    $points = $lastPoints -> getPoints() - $sf_guard_user -> getPoints();
                    $change_points = "-" . $points;
                } else {
                    $points = $sf_guard_user -> getPoints() - $lastPoints -> getPoints();
                    $change_points = "+" . $points;
                }

                $userPoints = new UserPoints();
                $userPoints -> setSfGuardUserId($sf_guard_user -> getId());

                if (SF_APP == 'backend') {
                    $userPoints -> setAdminId(sfContext::getInstance() -> getUser() -> getGuardUser() -> getId());
                }

                if ($order) {
                    $userPoints -> setOrderId($order -> getId());
                    $userPoints -> setOrderNumber($order -> getNumber());
                    $userPoints -> setOrderHash($order -> getHashCode());
                }

                $userPoints -> setPoints($sf_guard_user -> getPoints());
                $userPoints -> setChangePoints($sf_guard_user -> getPoints() - $lastPoints -> getPoints());
                $userPoints -> setChangePointsVarchar($change_points);
                $userPoints -> setDescription($description);
                $userPoints -> save();
            }

        } else {
            $change_points = "+" . $sf_guard_user -> getPoints();

            $userPoints = new UserPoints();
            $userPoints -> setSfGuardUserId($sf_guard_user -> getId());

            if (SF_APP == 'backend') {
                $userPoints -> setAdminId(sfContext::getInstance() -> getUser() -> getGuardUser() -> getId());
            }

            if ($order) {
                $userPoints -> setOrderId($order -> getId());
                $userPoints -> setOrderNumber($order -> getNumber());
                $userPoints -> setOrderHash($order -> getHashCode());
            }

            $userPoints -> setPoints($sf_guard_user -> getPoints());
            $userPoints -> setChangePoints($sf_guard_user -> getPoints());
            $userPoints -> setChangePointsVarchar($change_points);
            $userPoints -> setDescription($description);
            $userPoints -> save();
        }

    }

    static public function setLoginStatusPoints($value) {
        sfContext::getInstance() -> getUser() -> setAttribute('user_points', $value, 'soteshop/stPointsFrontend');
    }

    static public function getLoginStatusPoints() {

        if (sfContext::getInstance() -> getUser() -> isAuthenticated() == 1) {
            sfContext::getInstance() -> getUser() -> setAttribute('user_points', stPoints::getUnusedUserPoints(), 'soteshop/stPointsFrontend');
        } else {
            sfContext::getInstance() -> getUser() -> setAttribute('user_points', 0, 'soteshop/stPointsFrontend');
        }
        return sfContext::getInstance() -> getUser() -> getAttribute('user_points', '', 'soteshop/stPointsFrontend');
    }

    static public function getUserPoints() {

        if (sfContext::getInstance() -> getUser() -> isAuthenticated() == 1) {
            return sfContext::getInstance() -> getUser() -> getGuardUser() -> getPoints();
        }

    }

    static public function getUnusedUserPoints() {

        if (sfContext::getInstance() -> getUser() -> isAuthenticated() == 1) {
            
            if((stPoints::getUserPoints() - stPoints::getBasketPointsValue()) < 0){
                return 0;
            }else{
                return stPoints::getUserPoints() - stPoints::getBasketPointsValue();    
            }
            
        }
    }

    static public function addItemByPoints($item) {

        if (sfContext::getInstance() -> getUser() -> getAttribute('product_for_points', '', 'soteshop/stPointsFrontend') == "") {
            $product_for_points[] = $item;
            sfContext::getInstance() -> getUser() -> setAttribute('product_for_points', $product_for_points, 'soteshop/stPointsFrontend');
        } else {
            $product_for_points = sfContext::getInstance() -> getUser() -> getAttribute('product_for_points', '', 'soteshop/stPointsFrontend');
            $product_for_points[] = $item;
            sfContext::getInstance() -> getUser() -> setAttribute('product_for_points', $product_for_points, 'soteshop/stPointsFrontend');
        }
    }

    static public function removeItemByPoints($item) {

        $product_for_points = sfContext::getInstance() -> getUser() -> getAttribute('product_for_points', '', 'soteshop/stPointsFrontend');

        foreach ($product_for_points as $key => $value) {
            if ($value == $item) {
                unset($product_for_points[$key]);
            }
        }

        sfContext::getInstance() -> getUser() -> setAttribute('product_for_points', $product_for_points, 'soteshop/stPointsFrontend');

    }

    static public function isItemByPoints($item) {

        $return = false;

        if (sfContext::getInstance() -> getUser() -> getAttribute('product_for_points', '', 'soteshop/stPointsFrontend') != "") {

            $product_for_points = sfContext::getInstance() -> getUser() -> getAttribute('product_for_points', '', 'soteshop/stPointsFrontend');

            foreach ($product_for_points as $key => $value) {
                if ($value == $item) {
                    $return = true;
                }
            }

        }
        return $return;
    }

    static public function refreshLoginStatusPoints() {

        $themeVersion = sfContext::getInstance()->getController()->getTheme()->getVersion();
        
        if($themeVersion < 7){


        stPoints::checkReleasePointsSystem();

        if (sfContext::getInstance() -> getUser() -> isAuthenticated() == 1) {
            
            if(sfContext::getInstance() -> getUser() -> getBasket() -> getItems())
            {
                foreach (sfContext::getInstance() -> getUser() -> getBasket() -> getItems() as $item) {
                                              
                       if($item -> getProduct() -> getPointsOnly() == 1 && $item -> getProductForPoints()==false){ 
                            stPoints::addItemByPoints($item->getItemId());
                            $item -> setProductForPoints(true);
                            sfContext::getInstance() -> getUser() -> getBasket() -> save();
                            sfContext::getInstance() -> getUser() -> getBasket() -> refresh($item -> getItemId());
                       }
                       
                       if($item -> getProductForPoints() && stPoints::isPointsSystemActive()!=1){
                        sfContext::getInstance() -> getUser() -> getBasket()->removeItem($item -> getProduct() -> getId());
                        sfContext::getInstance() -> getUser() -> getBasket() -> save();   
                       }
                }
            }

            if (sfContext::getInstance() -> getUser() -> getAttribute('product_for_points', '', 'soteshop/stPointsFrontend') != "") {

                $points_value = 0;
                $user_points = sfContext::getInstance() -> getUser() -> getGuardUser() -> getPoints();

                $product_for_points = sfContext::getInstance() -> getUser() -> getAttribute('product_for_points', '', 'soteshop/stPointsFrontend');

                foreach ($product_for_points as $key => $value) {

                    $item = sfContext::getInstance() -> getUser() -> getBasket() -> getItem($value);

                    if($item){
                        $points_value += $item -> getProduct() -> getPointsValue() * $item -> getQuantity();
                    }else{
                        unset($product_for_points[$key]);
                    }
                    
                    if ($user_points < $points_value) {

                        $points_value = $points_value - $item -> getProduct() -> getPointsValue() * $item -> getQuantity();

                        if ($item -> getProduct() -> getPointsOnly() != 1) {
                            stPoints::removeItemByPoints($item -> getItemId());
                            $item -> setProductForPoints(false);
                        } else {
                            //dodać blokade na zadrogi je
                            $item -> setQuantity(1);
                            $points_value = $points_value + $item -> getProduct() -> getPointsValue();
                        }
                        sfContext::getInstance() -> getUser() -> getBasket() -> save();
                        sfContext::getInstance() -> getUser() -> getBasket() -> refresh($item -> getItemId());

                    }
                }

            } else {

                foreach (sfContext::getInstance() -> getUser() -> getBasket() -> getItems() as $item) {

                    $item -> setProductForPoints(false);    
                    sfContext::getInstance() -> getUser() -> getBasket() -> save();
                    sfContext::getInstance() -> getUser() -> getBasket() -> refresh($item -> getItemId());
                }
            }

        } else {
            
            sfContext::getInstance() -> getUser() -> setAttribute('user_points', 0, 'soteshop/stPointsFrontend');
            sfContext::getInstance() -> getUser() -> setAttribute('product_for_points', '', 'soteshop/stPointsFrontend');
        }
    }

    }

    static public function getBasketPointsValue() {

        $points_value = 0;
        if (sfContext::getInstance() -> getUser() -> isAuthenticated() == 1) {
            if (sfContext::getInstance() -> getUser() -> getAttribute('product_for_points', '', 'soteshop/stPointsFrontend') != "") {

                $product_for_points = sfContext::getInstance() -> getUser() -> getAttribute('product_for_points', '', 'soteshop/stPointsFrontend');

                foreach ($product_for_points as $key => $value) {

                    $item = sfContext::getInstance() -> getUser() -> getBasket() -> getItem($value);

                    if($item){
                        $points_value += $item -> getProduct() -> getPointsValue() * $item -> getQuantity();
                    }else{
                        unset($product_for_points[$key]);
                    }

                }
            }
        }
        
        return $points_value;

    }

    static public function getOrderTotalPointsValue($order) {

        $total_points = 0;
        foreach ($order->getOrderProducts() as $order_product) {

            if ($order_product -> getProductForPoints() == true) {
                $total_points += $order_product -> getPointsValue() * $order_product -> getQuantity();
            }
        }
        return $total_points;
    }

    static public function getOrderTotalPointsEarn($order) {

        $total_points = 0;
        foreach ($order->getOrderProducts() as $order_product) {

            if ($order_product -> getProductForPoints() == false) {
                $total_points += $order_product -> getPointsEarn() * $order_product -> getQuantity();
            }

        }
        return $total_points;
    }

    static public function addPointForOrder($order, $force_status = false) {

        $configPoints = stConfig::getInstance('stPointsBackend');

        if ($configPoints -> get("order_status_on") || $force_status == true) {

            if ($configPoints -> get("order_status_type") == $order -> getOrderStatusId() || $force_status == true) {
                $earn_points_value = 0;

                $products = $order -> getOrderProducts();

                foreach ($products as $product) {
                    //zlicza punkty do dodania
                    if ($product -> getPointsEarn() != 0 && $product -> getProductForPoints() == false) {
                        $earn_points_value += $product -> getPointsEarn() * $product -> getQuantity();
                    }
                }

                $c = new Criteria();
                $c -> add(sfGuardUserPeer::ID, $order -> getSfGuardUserId());
                $sf_guard_user = sfGuardUserPeer::doSelectOne($c);

                //$i18n = sfContext::getInstance() -> getI18n();

                stPoints::updateUserPoints($sf_guard_user, "+" . $earn_points_value);
                //stPoints::registerUpdatePoints($sf_guard_user, $order, $i18n -> __("Aktualizowane przez zamówienie"));
                stPoints::registerUpdatePoints($sf_guard_user, $order, "Aktualizowane przez zamówienie");
                
            }

        }

    }

    static public function isPointsAssigned($order) {

        $c = new Criteria();
        $c -> add(UserPointsPeer::ORDER_ID, $order -> getId());
        $registerTransaction = UserPointsPeer::doSelect($c);

        if ($registerTransaction) {

            foreach ($registerTransaction as $transaction) {
                $points_value = $transaction -> getChangePointsVarchar();

                if ($points_value{0} == "+") {
                    return true;
                }

            }

        }

        return false;
    }
    
    static public function isPointsSystemActive() {
        $run_points = 1;
        
        $configPoints = stConfig::getInstance('stPointsBackend');
        if($configPoints -> get('points_system_is_active') != 1){
            $run_points = 0;
        }
        
        if($configPoints -> get('points_system_only_authenticated') == 1 && sfContext::getInstance() -> getUser() -> isAuthenticated() != 1){
            $run_points = 0;
        }
        
        if(sfContext::getInstance() -> getUser() -> isAuthenticated() == 1 && sfContext::getInstance() -> getUser()->getGuardUser()->getPointsAvailable() == 0){
             $run_points = 0;
        }
        
        // if($configPoints -> get('points_release_on') == 1 && sfContext::getInstance() -> getUser() -> isAuthenticated() == 1 && sfContext::getInstance() -> getUser()->getGuardUser()->getPointsRelease() == 0){
            // $run_points = 0;
        // }
                
        return $run_points;
        
    }
    
    static public function checkReleasePointsSystem() {

        $configPoints = stConfig::getInstance('stPointsBackend');
        if($configPoints -> get('points_system_is_active') == 1 && $configPoints -> get('points_release_on') == 1){
         
         if(sfContext::getInstance() -> getUser() -> isAuthenticated() == 1)
         {      
             if(sfContext::getInstance() -> getUser() -> getGuardUser() -> getPointsRelease()!=1 && stPoints::getUserPoints() >= $configPoints -> get('points_release_value')){
                    
                $c = new Criteria();
                $c -> add(sfGuardUserPeer::ID, sfContext::getInstance() -> getUser() -> getGuardUser()->getId());
                $user = sfGuardUserPeer::doSelectOne($c);
        
                $user -> setPointsRelease(1);
                $user -> save();
                   
             }
         }
            
        }
    }
    
    static public function isReleasePointsSystemForUser($user_id = false) {
        
        $configPoints = stConfig::getInstance('stPointsBackend');
             
        if($configPoints -> get('points_release_on') == 0){
            return "release_off";
        }     
             
        if($user_id == false && sfContext::getInstance() -> getUser() -> isAuthenticated() == 1)
        {
            if(sfContext::getInstance() -> getUser() -> getGuardUser() -> getPointsRelease()==1){
                return "release_on";
            }else{
                return $configPoints -> get('points_release_value') - stPoints::getUserPoints();
            }
            
        }else{
            $c = new Criteria();
            $c -> add(sfGuardUserPeer::ID, $user_id);
            $user = sfGuardUserPeer::doSelectOne($c);
            
            if($user){
                if($user -> getPointsRelease()==1){
                    return "release_on";
                }else{
                    return $configPoints -> get('points_release_value') - $user->getPoints();        
                }
            }
        }
     }
    
    static public function isReleasePoints() {
        
        $configPoints = stConfig::getInstance('stPointsBackend');
             
        if($configPoints -> get('points_release_on') == 1 && sfContext::getInstance() -> getUser() -> getGuardUser() -> getPointsRelease()==1){
            return true;
        }         
        
     }
    
    static public function isBasketOnlyForPoints() {
    
        $basket_total = sfContext::getInstance() -> getUser() -> getBasket()->getTotalAmount();
        
        if($basket_total>0){
            return false;
        }else{
            return true;
        }
        
     }
    
     static public function isOrderOnlyForPoints() {
    
        $basket_total = sfContext::getInstance() -> getUser() -> getBasket()->getTotalAmount();
    
        $delivery = stDeliveryFrontend::getInstance(sfContext::getInstance() -> getUser() -> getBasket());

        if($delivery->getDefaultDelivery()){
            $delivery_total = $delivery->getDefaultDelivery()->getTotalCost(true, true);
        } else {
            $delivery_total = 0;
        }
        
        if(($basket_total+$delivery_total)==0 && stPoints::getBasketPointsValue()!=0){
            return true;
        }else{    
            return false;
        }
        
     }
    
    static public function verifyThemeTemplates() {
    
        $files_mod = array();
    
        $active_theme = stTheme::getActiveTheme();
        
    
        //stProduct
    
        $dir = sfConfig::get('sf_root_dir').'/apps/frontend/modules/stProduct/templates/theme/'.$active_theme;

        $files = array(
            'product_list_long.html',
            'product_main.html',
            'product_recommend_products.html',
            'product_show_default.html',
        );

        foreach ($files as $file) 
        {
            if (is_file($dir.'/'.$file))
            {
                $files_mod[] = $dir.'/'.$file;
                $file_exist = true;
            }
        }   
        
        //stFrontend
        
        $dir = sfConfig::get('sf_root_dir').'/apps/frontend/templates/theme/'.$active_theme;

        $files = array(
            'container_head.html',
        );

        foreach ($files as $file) 
        {
            if (is_file($dir.'/'.$file))
            {
                $files_mod[] = $dir.'/'.$file;
                $file_exist = true;
            }
        }
        
        //stAccessories
        
        $dir = sfConfig::get('sf_root_dir').'/plugins/stAccessoriesPlugin/modules/stAccessoriesFrontend/templates/theme/'.$active_theme;

        $files = array(
            'accessories_list.html',
        );

        foreach ($files as $file) 
        {
            if (is_file($dir.'/'.$file))
            {
                $files_mod[] = $dir.'/'.$file;
                $file_exist = true;
            }
        }
        
        return $files_mod;
        
    
    }
    
     static public function isIndividualTheme() {
    
        $themes = array(
            'default2',
            'argento',
            'giallo',
            'moderno',
            'sportivo',
            'quattro',
            'segno',
            'coffeestore',
            'bagging',
            'surfing', 
            'longboard',
            'toys',
            'brassiere',
            'jewelry',
            'blackart',
            'classic',
            'nature',
            'perfume',
            'simple',

        );
    
         $config_points = stConfig::getInstance(sfContext::getInstance(), 'stPointsBackend');
         $config_points->get('points_system_install_update');     
         $active_theme = stTheme::getActiveTheme();  
         
         $individual_theme = 1;
        
        if($config_points->get('points_system_install_update')==1){
             foreach ($themes as $theme) 
             {
                if ($theme==$active_theme)
                {
                    $individual_theme = 0;
                }
            }   
        }else{
            return false;
        }
         
         if($individual_theme==1 && $active_theme->getVersion()<4){
            return true;    
         }else{
            return false;
         }
         
     }
}