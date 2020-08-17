<?php

/**
 * SOTESHOP/stPointsPlugin
 *
 * Ten plik należy do aplikacji stWholesalePlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE.
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stPointsPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stPointsPluginListener.class.php 1142 2009-05-13 08:48:03Z krzysiek $
 */

/**
 *
 * @package     stPointsPlugin
 * @subpackage  libs
 */
class stPointsPluginListener {

   public static function preExecute(sfEvent $event)
   {
      
     if(!stLicense::hasSupport() && !stLicense::isOpen() && !stTheme::hideOldConfiguration()){
         $configPoints = stConfig::getInstance('stPointsBackend');
         if($configPoints -> get("points_system_is_active")){
             $configPoints -> set("points_system_is_active",false);
             $configPoints->save();
       }
     } 
   }

    public static function updateWebApiPointsAssigned(sfEvent $event) {
        
        if(!stTheme::hideOldConfiguration()){
            $order = $event -> getSubject() -> order;

             if(stPoints::isPointsAssigned($order)==false){
                stPoints::addPointForOrder($order);    
             }
        }
    }

    public static function postExecuteOrderSave(sfEvent $event) {

        if(!stTheme::hideOldConfiguration()){

            $i18n = sfContext::getInstance() -> getI18n();

            $configPoints = stConfig::getInstance('stPointsBackend');

            $order = $event -> getSubject() -> order;
            
            $c = new Criteria();
            $c -> add(SfGuardUserPeer::ID, $order -> getSfGuardUserId());
            $sf_guard_user = SfGuardUserPeer::doSelectOne($c);

            $products = $order -> getOrderProducts();

            $spend_points_value = stPoints::getOrderTotalPointsValue($order);
        
            if($spend_points_value!=0){
                stPoints::updateUserPoints($sf_guard_user, "-" . $spend_points_value);
                stPoints::registerUpdatePoints($sf_guard_user, $order, "Aktualizowane przez zamówienie");
            }

            if($configPoints -> get("order_status_on")){

                if ($configPoints -> get("order_status_type") == $order -> getOrderStatusId()) {
                    $earn_points_value = 0;
                    foreach ($products as $product) {
                        //zlicza punkty do dodania
                        if ($product -> getProduct() -> getPointsEarn() != 0) {
                            $earn_points_value += $product -> getProduct() -> getPointsEarn() * $product -> getQuantity();
                        }
                    }
                    
                    stPoints::updateUserPoints($sf_guard_user, "+" . $earn_points_value);
                    stPoints::registerUpdatePoints($sf_guard_user, $order, "Aktualizowane przez zamówienie");
                }
            }
        }
    }

}
