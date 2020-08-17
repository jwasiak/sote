<?php
/**
 * SOTESHOP/stUser
 *
 * Ten plik należy do aplikacji stUser opartej na licencji (Professional License SOTE).
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stUser
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: components.class.php 617 2009-04-09 13:02:31Z michal $
 * @author      Marcin Butlak <marcin.butlak@sote.pl>
 */

/**
 * Klasa stUserComponents
 *
 * @package     stUser
 * @subpackage  actions
 */
class stUserComponents extends autostUserComponents {
    public function executeClientUsername() {
        $c = new Criteria();
        $c -> add(sfGuardUserPeer::ID, $this -> forward_parameters['user_id']);
        $sf_guard_user = sfGuardUserPeer::doSelectOne($c);

        $this -> username = $sf_guard_user -> getUsername();
    }
    
    public function executeUsername() {
        $this -> username = $this -> sf_guard_user -> getUsername();
        $this -> id = $this -> sf_guard_user -> getId();
    }

    public function executeFullName() {
        $c = new Criteria();
        $c -> add(UserDataPeer::SF_GUARD_USER_ID, $this -> sf_guard_user -> getId());
        $c -> add(UserDataPeer::IS_DEFAULT, 1);
        $c -> add(UserDataPeer::IS_BILLING, 1);
        if ($userDataBillingDefault = UserDataPeer::doSelectOne($c)) {
            $this -> full_name = $userDataBillingDefault -> getFullName();
        } else {
            $this -> full_name = "-";
        }
        $this -> id = $this -> sf_guard_user -> getId();
    }

    public function executeCompany() {
        $c = new Criteria();
        $c -> add(UserDataPeer::SF_GUARD_USER_ID, $this -> sf_guard_user -> getId());
        $c -> add(UserDataPeer::IS_DEFAULT, 1);
        $c -> add(UserDataPeer::IS_BILLING, 1);
        if ($userDataBillingDefault = UserDataPeer::doSelectOne($c)) {
            $this -> company = $userDataBillingDefault -> getCompany();
        } else {
            $this -> company = "-";
        }
        $this -> id = $this -> sf_guard_user -> getId();
    }

    public function executePassword() {

    }

    public function executePasswordBis() {

    }

    public function executeIsDefault() {

    }

    public function executeUserInfo() {
        $this -> user_data_billing = $this -> getUserDataBillingDefault($this -> getRequestParameter('id'));
        $this -> user_data_delivery = $this -> getUserDataDeliveryDefault($this -> getRequestParameter('id'));
        $this -> id = $this -> getRequestParameter('id');
    }

    public function getUserDataBillingDefault($user_id) {
        $c = new Criteria();
        $c -> add(UserDataPeer::SF_GUARD_USER_ID, $user_id);
        $c -> add(UserDataPeer::IS_DEFAULT, 1);
        $c -> add(UserDataPeer::IS_BILLING, 1);
        if ($userDataBillingDefault = UserDataPeer::doSelectOne($c)) {
            $this -> user_data = $userDataBillingDefault;
        } else {
            $this -> user_data = new UserData();

            $this -> user_data -> setSfGuardUserId($user_id);
            $this -> user_data -> setIsBilling(1);
            $this -> user_data -> setIsDefault(1);
            $this -> user_data -> setCountriesId(36);
        }

        $userDataBillingDefault = $this -> user_data;
        return $userDataBillingDefault;
    }

    public function getUserDataDeliveryDefault($user_id) {
        $c = new Criteria();
        $c -> add(UserDataPeer::SF_GUARD_USER_ID, $user_id);
        $c -> add(UserDataPeer::IS_DEFAULT, 1);
        $c -> add(UserDataPeer::IS_BILLING, 0);
        if ($userDataDeliveryDefault = UserDataPeer::doSelectOne($c)) {
            $this -> user_data = $userDataDeliveryDefault;
        } else {
            $this -> user_data = new UserData();

            $this -> user_data -> setSfGuardUserId($user_id);
            $this -> user_data -> setIsBilling(0);
            $this -> user_data -> setIsDefault(1);
            $this -> user_data -> setCountriesId(36);
        }

        $userDataDeliveryDefault = $this -> user_data;
        return $userDataDeliveryDefault;
    }

    public function executeUserConfirm() {
        $this -> confirm = $this -> sf_guard_user -> getIsConfirm();
        $this -> id = $this -> sf_guard_user -> getId();
    }

    public function executeUserAdminConfirm() {
        $this -> admin_confirm = $this -> sf_guard_user -> getIsAdminConfirm();
        $this -> id = $this -> sf_guard_user -> getId();
    }

    public function executeUserOrder() {
        $this -> username = $this -> sf_guard_user -> getUsername();
    }

    public function executeHeaderUserPointsAvaible() {
        $this -> id = $this -> getRequestParameter('id');

        $config_points = stConfig::getInstance('stPointsBackend');
        $config_points->setCulture(sfContext::getInstance()->getUser()->getCulture());
                                
        $this->points_shortcut = $config_points->get('points_shortcut', null, true);

        $c = new Criteria();
        $c -> add(sfGuardUserPeer::ID, $this -> getRequestParameter('id'));
        $user = sfGuardUserPeer::doSelectOne($c);

        $this -> user = $user;
    }
    
    public function executeHeaderUserPointsRelease() {
        $this -> id = $this -> getRequestParameter('id');

        $config_points = stConfig::getInstance('stPointsBackend');
        $config_points->setCulture(sfContext::getInstance()->getUser()->getCulture());
                                
        $this->points_shortcut = $config_points->get('points_shortcut', null, true);

        $c = new Criteria();
        $c -> add(sfGuardUserPeer::ID, $this -> getRequestParameter('id'));
        $user = sfGuardUserPeer::doSelectOne($c);
        
        if($user -> getPointsRelease()!=1 && $user->getPoints() >= $config_points -> get('points_release_value')){                
        
                $user -> setPointsRelease(1);
                $user -> save();
        }

        $this -> user = $user;
    }

    public function executeHeaderUserInfo() {
        $this -> id = $this -> getRequestParameter('id');

        $c = new Criteria();
        $c -> add(sfGuardUserPeer::ID, $this -> getRequestParameter('id'));
        $user = sfGuardUserPeer::doSelectOne($c);

        $this -> user = $user;
    }

    public function executeHeaderUserPoints() {
        $this -> id = $this -> getRequestParameter('id');

        $c = new Criteria();
        $c -> add(sfGuardUserPeer::ID, $this -> getRequestParameter('id'));
        $user = sfGuardUserPeer::doSelectOne($c);

        $this -> user = $user;
        
        $config_points = stConfig::getInstance('stPointsBackend');
        $config_points->setCulture(sfContext::getInstance()->getUser()->getCulture());
                                
        $this->points_shortcut = $config_points->get('points_shortcut', null, true);
    }

    public function executeUserPoints() {
        $this -> id = $this -> getRequestParameter('id');

        // $c = new Criteria();
        // $c -> add(UserPointsPeer::SF_GUARD_USER_ID, $this -> getRequestParameter('id'));
        // $c -> addDescendingOrderByColumn(UserPointsPeer::CREATED_AT);
        // $transactions = UserPointsPeer::doSelect($c);
        
        $c = new Criteria();
        $c -> add(UserPointsPeer::SF_GUARD_USER_ID, $this -> getRequestParameter('id'));
        //$c->addJoin(UserPointsPeer::ADMIN_ID, SfGuardUserPeer::ID);
        $c -> addDescendingOrderByColumn(UserPointsPeer::CREATED_AT);
        $transactions = UserPointsPeer::doSelectJoinSfGuardUserRelatedByAdminId($c);
        
        // echo "<pre>";
        // print_r($transactions);
        
        $this -> transactions = $transactions;

        $c = new Criteria();
        $c -> add(sfGuardUserPeer::ID, $this -> getRequestParameter('id'));
        $user = sfGuardUserPeer::doSelectOne($c);

        $this -> user = $user;

    }

    public function executeOperationDescription() {
        $this -> description = $this -> getRequestParameter('sf_guard_user[operation_description]');
    }

     public function executeUserPointsInputOperation()
    {          
       $this->points = $this -> getRequestParameter('sf_guard_user[user_points]');
    } 
    
    public function executeUserPointsDescriptionOperation()
    {          
       $this->description = $this -> getRequestParameter('sf_guard_user[operation_description]');
    }

}
