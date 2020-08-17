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
 * @version     $Id: actions.class.php 617 2009-04-09 13:02:31Z michal $
 * @author      Marcin Butlak <marcin.butlak@sote.pl>
 */

/**
 * Klasa stUserActions
 *
 * @package     stUser
 * @subpackage  actions
 */
class stUserActions extends autostUserActions {
    public function executeUserDataDeliveryCreate() {
        $this -> getRequest() -> setParameter('create', true);

        return parent::executeUserDataDeliveryCreate();
    }

    public function executeUserDataBillingCreate() {
        $this -> getRequest() -> setParameter('create', true);

        return parent::executeUserDataBillingCreate();
    }

    public function executeUserDataBillingList() {
        parent::executeUserDataBillingList();
        $this -> pager -> getCriteria() -> add(UserDataPeer::IS_BILLING, true);
        $this -> pager -> getCriteria() -> add(UserDataPeer::SF_GUARD_USER_ID, $this -> forward_parameters['user_id']);
        $this -> pager -> init();
    }

    public function executeUserDataDeliveryList() {
        parent::executeUserDataDeliveryList();
        $this -> pager -> getCriteria() -> add(UserDataPeer::IS_BILLING, false);
        $this -> pager -> getCriteria() -> add(UserDataPeer::SF_GUARD_USER_ID, $this -> forward_parameters['user_id']);
        $this -> pager -> init();
    }

    protected function getUserDataBillingUserDataOrCreate($id = 'id') {
        $c = new Criteria();
        $c -> add(UserDataPeer::SF_GUARD_USER_ID, $this -> getRequestParameter('user_id'));
        $c -> add(UserDataPeer::IS_DEFAULT, 1);
        $c -> add(UserDataPeer::IS_BILLING, 1);

        if ($this -> hasRequestParameter('create')) {
            $this -> user_data = new UserData();

            $this -> user_data -> setSfGuardUserId($this -> getRequestParameter('user_id'));
            $this -> user_data -> setIsBilling(1);
            $this -> user_data -> setIsDefault(!UserDataPeer::doCount($c));
            $this -> user_data -> setCountriesId(36);
        } elseif ($this -> hasRequestParameter('user_id') && !$this -> hasRequestParameter($id)) {
            if ($userDataBillingDefault = UserDataPeer::doSelectOne($c)) {
                $this -> user_data = $userDataBillingDefault;
            } else {
                $this -> user_data = new UserData();

                $this -> user_data -> setSfGuardUserId($this -> getRequestParameter('user_id'));
                $this -> user_data -> setIsBilling(1);
                $this -> user_data -> setIsDefault(1);
                $this -> user_data -> setCountriesId(36);
            }
        } else {
            parent::getUserDataBillingUserDataOrCreate($id);
        }

        return $this -> user_data;
    }

    protected function getUserDataDeliveryUserDataOrCreate($id = 'id') {
        $c = new Criteria();
        $c -> add(UserDataPeer::SF_GUARD_USER_ID, $this -> getRequestParameter('user_id'));
        $c -> add(UserDataPeer::IS_DEFAULT, 1);
        $c -> add(UserDataPeer::IS_BILLING, 0);

        if ($this -> hasRequestParameter('create')) {
            $this -> user_data = new UserData();

            $this -> user_data -> setSfGuardUserId($this -> getRequestParameter('user_id'));
            $this -> user_data -> setIsBilling(0);
            $this -> user_data -> setIsDefault(!UserDataPeer::doCount($c));
            $this -> user_data -> setCountriesId(36);
        } elseif ($this -> hasRequestParameter('user_id') && !$this -> hasRequestParameter($id)) {
            if ($userDataDeliveryDefault = UserDataPeer::doSelectOne($c)) {
                $this -> user_data = $userDataDeliveryDefault;
            } else {
                $this -> user_data = new UserData();

                $this -> user_data -> setSfGuardUserId($this -> getRequestParameter('user_id'));
                $this -> user_data -> setIsBilling(0);
                $this -> user_data -> setIsDefault(1);
                $this -> user_data -> setCountriesId(36);
            }
        } else {
            parent::getUserDataDeliveryUserDataOrCreate($id);
        }

        return $this -> user_data;
    }

    /**
     * Przeciążenie zapisu sfGuardUser
     *
     * @param   sfGuardUser $sf_guard_user
     */
    protected function savesfGuardUser($sf_guard_user) {
        $c = new Criteria();
        $c -> add(MailDescriptionPeer::SYSTEM_NAME, "admin_confirm_user");
        $mail_description = MailDescriptionPeer::doSelectOne($c);
        $mail_description_active = $mail_description -> getIsActive();

        $culture = $this -> getUser() -> getCulture();
        if ($sf_guard_user -> getLanguage()) {
            $this -> getUser() -> setCulture($sf_guard_user -> getLanguage());
        }

        if (!$sf_guard_user -> getId()) {
            $sf_guard_user -> addGroupByName('user');
            $sf_guard_user -> setHashCode(md5(microtime()));

            if ($sf_guard_user -> getIsAdminConfirm() == 1 && $mail_description_active == 1) {

                $this -> mailWithNewUserToUser($sf_guard_user);
            }
        }

        if ($sf_guard_user -> getId()) {
            $c = new Criteria();
            $c -> add(sfGuardUserPeer::ID, $sf_guard_user -> getId());
            $user = sfGuardUserPeer::doSelectOne($c);
            $isAdminConfirm = $user -> getIsAdminConfirm();
        }

        if ($sf_guard_user -> getIsAdminConfirm() == 1 && $isAdminConfirm == 0 && $mail_description_active == 1) {
            $this -> mailWithNewUserToUser($sf_guard_user);
        }

        $this -> getUser() -> setCulture($culture);                

        parent::savesfGuardUser($sf_guard_user);
                        
    }

    /**
     * Wysyła mail z zamówieniem do administratora
     */
    function mailWithNewUserToUser($user) {

        $mailHtmlHead = stMailer::getHtmlMailDescription("header");

        $mailHtmlFoot = stMailer::getHtmlMailDescription("footer");

        $mailHtmlContent = stMailer::getHtmlMailDescription("admin_confirm_user");

        $sendAdminConfirmHtmlMailMessage = stMailTemplate::render('sendAdminConfirmHtml', array('user' => $user, 'head' => $mailHtmlHead, 'foot' => $mailHtmlFoot, 'content' => $mailHtmlContent, ));

        $mailPlainHead = stMailer::getPlainMailDescription("header");

        $mailPlainFoot = stMailer::getPlainMailDescription("footer");

        $mailPlainContent = stMailer::getPlainMailDescription("admin_confirm_user");

        $sendAdminConfirmPlainMailMessage = stMailTemplate::render('sendAdminConfirmPlain', array('user' => $user, 'head' => $mailPlainHead, 'foot' => $mailPlainFoot, 'content' => $mailPlainContent, ));

        $mail = stMailer::getInstance();
        return $mail -> setSubject(__('Twoje konto w sklepie zostało zweryfikowane.')) -> setHtmlMessage($sendAdminConfirmHtmlMailMessage) -> setPlainMessage($sendAdminConfirmPlainMailMessage) -> setTo($user -> getUsername()) -> sendToClient();

    }

    protected function saveUserDataBillingUserData($user_data) {
        $user_data -> setSfGuardUserId($this -> forward_parameters['user_id']);
        $user_data -> setIsBilling(1);

        $this -> getDispatcher() -> notify(new sfEvent($this, 'autoStUserActions.preSaveUserDataBilling', array('modelInstance' => $user_data)));
        $user_data -> save();

        if ($user_data -> getIsDefault() == 1) {
            $this -> setDefaultUserData($user_data -> getId(), 1, $user_data -> getSfGuardUserId());
        }

        $this -> getDispatcher() -> notify(new sfEvent($this, 'autoStUserActions.preSaveUserDataBilling', array('modelInstance' => $user_data)));
    }

    protected function saveUserDataDeliveryUserData($user_data) {
        $user_data -> setSfGuardUserId($this -> forward_parameters['user_id']);
        $user_data -> setIsBilling(0);

        $this -> getDispatcher() -> notify(new sfEvent($this, 'autoStUserActions.preSaveUserDataDelivery', array('modelInstance' => $user_data)));
        $user_data -> save();

        if ($user_data -> getIsDefault() == 1) {
            $this -> setDefaultUserData($user_data -> getId(), 0, $user_data -> getSfGuardUserId());
        }

        $this -> getDispatcher() -> notify(new sfEvent($this, 'autoStUserActions.preSaveUserDataDelivery', array('modelInstance' => $user_data)));
    }

    /**
     */
    public function setDefaultUserData($userDataId, $isBilling, $user_id) {
        $con = Propel::getConnection();
        $c1 = new Criteria();
        $c1 -> add(UserDataPeer::SF_GUARD_USER_ID, $user_id);

        if ($isBilling == 1) {
            $c1 -> add(UserDataPeer::IS_BILLING, 1);
        } else {
            $c1 -> add(UserDataPeer::IS_BILLING, 0);
        }

        $c1 -> add(UserDataPeer::IS_DEFAULT, 1);

        $c2 = new Criteria();
        $c2 -> add(UserDataPeer::IS_DEFAULT, 0);

        BasePeer::doUpdate($c1, $c2, $con);

        $c = new Criteria();
        $c -> add(UserDataPeer::SF_GUARD_USER_ID, $user_id);
        $c -> add(UserDataPeer::ID, $userDataId);

        $userData = UserDataPeer::doSelectOne($c);
        $userData -> setIsDefault(1);
        $userData -> save();
    }

    public function executeUpdateConfirm() {
        $user_id = $this -> getRequestParameter('id');

        $c = new Criteria();
        $c -> add(sfGuardUserPeer::ID, $user_id);
        $user = sfGuardUserPeer::doSelectOne($c);

        $user -> setIsConfirm(1);
        $user -> save();

        return $this -> redirect('stUser/edit?id=' . $user -> getId());

    }

    public function executeUpdateAdminConfirm() {
        $user_id = $this -> getRequestParameter('id');

        $c = new Criteria();
        $c -> add(sfGuardUserPeer::ID, $user_id);
        $user = sfGuardUserPeer::doSelectOne($c);

        $user -> setIsAdminConfirm(1);
        $user -> save();

        return $this -> redirect('stUser/edit?id=' . $user -> getId());

    }

    protected function addJoinUserDataCriteria(Criteria $c)
    {
        if (!array_key_exists(sfGuardUserPeer::ID.UserDataPeer::SF_GUARD_USER_ID, $c->getJoins()))
        {
            $c -> addJoin(sfGuardUserPeer::ID, UserDataPeer::SF_GUARD_USER_ID, Criteria::LEFT_JOIN);

            if (!in_array(sfGuardUserPeer::ID, $c->getGroupByColumns()))
            {
                $c->addGroupByColumn(sfGuardUserPeer::ID);
            }
        }       
    }

    protected function addSortCriteria($c) {
        parent::addSortCriteria($c);

        $sort = $this->getUser()->getAttribute('sort', null, 'sf_admin/autoStUser/sort');

        if ($sort == 'full_name' || $sort == 'company') {
            $this->addJoinUserDataCriteria($c);
        }
    }

    protected function addFiltersCriteria($c) {
        parent::addFiltersCriteria($c);

        $group = sfGuardGroupPeer::retrieveByName('user');

        $c->addJoin(sfGuardUserPeer::ID, sfGuardUserGroupPeer::USER_ID);
        $c->add(sfGuardUserGroupPeer::GROUP_ID, $group->getId());

        if (isset($this -> filters['filter_full_name']) && !empty($this -> filters['filter_full_name'])) {

            $this->addJoinUserDataCriteria($c);
            $c -> add(UserDataPeer::IS_BILLING, 1); 
            $c -> add(UserDataPeer::FULL_NAME, '%'.$this -> filters['filter_full_name'].'%', Criteria::LIKE);

        }

        if (isset($this -> filters['filter_company']) && !empty($this -> filters['filter_company'])) {
            $this->addJoinUserDataCriteria($c);
            $c -> add(UserDataPeer::IS_BILLING, 1); 

            $c -> add(UserDataPeer::COMPANY, '%'.$this -> filters['filter_company'].'%', Criteria::LIKE);
        }

        if (isset($this->filters['is_admin_confirm']) && !empty($this->filters['is_admin_confirm']))
        {
            $c->add(sfGuardUserPeer::IS_ADMIN_CONFIRM, $this->filters['is_admin_confirm']);
        }

    }

    public function executeRegisterUserWidget() {
        $this -> setLayout('layout_gadget');

        $backendMainConfig = stConfig::getInstance($this -> getContext(), 'stBackendMain');

        if ($this -> getRequestParameter('date_type')) {
            $date_type = $this -> getRequestParameter('date_type');
            $backendMainConfig -> set('date_type', $date_type);
            $backendMainConfig -> save();
        } else {
            $date_type = $backendMainConfig -> get('date_type');
        }

        if ($date_type == "day") {
            $from_date = date('Y-m-d H:i:s', time() - 86400);
        } elseif ($date_type == "week") {
            $from_date = date('Y-m-d H:i:s', time() - 604800);

        } elseif ($date_type == "month") {
            $from_date = date('Y-m-d H:i:s', time() - 2419200);

        } elseif ($date_type == "lastlog") {
            $c = new Criteria();
            $c -> add(sfGuardUserPeer::ID, $this -> getUser() -> getAttribute('user_id', null, 'sfGuardSecurityUser'));
            $user = sfGuardUserPeer::doSelectOne($c);

            $from_date = $this -> getUser() -> getLastLogin();
        }
        $to_date = date('Y-m-d H:i:s');

        $this -> date_type = $date_type;
        $this -> from_date = $from_date;
        $this -> to_date = $to_date;

        //klienci

        $c = new Criteria();
        $criterion = $c -> getNewCriterion(sfGuardUserPeer::CREATED_AT, $from_date, Criteria::GREATER_EQUAL);
        $criterion -> addAnd($c -> getNewCriterion(sfGuardUserPeer::CREATED_AT, $to_date, Criteria::LESS_EQUAL));
        $c -> add($criterion);
        $c -> addDescendingOrderByColumn(SfGuardUserPeer::CREATED_AT);
        $c -> addJoin(sfGuardUserPeer::ID, sfGuardUserGroupPeer::USER_ID);
        $c -> addJoin(sfGuardUserGroupPeer::GROUP_ID, sfGuardGroupPermissionPeer::GROUP_ID);
        $c -> addJoin(sfGuardPermissionPeer::ID, sfGuardGroupPermissionPeer::PERMISSION_ID);
        $c -> add(sfGuardPermissionPeer::NAME, 'user');
        $c -> setLimit(100);

        $users = SfGuardUserPeer::doSelect($c);

        if (SfGuardUserPeer::doSelect($c)) {

            $i = 0;
            foreach ($users as $user) {
                $c = new Criteria();
                $c -> add(UserDataPeer::SF_GUARD_USER_ID, $user -> getId());
                $c -> add(UserDataPeer::IS_DEFAULT, 1);
                $c -> add(UserDataPeer::IS_BILLING, 1);
                $userDataBilling = UserDataPeer::doSelectOne($c);

                $userInfo[$i]['username'] = $user -> getUsername();
                $userInfo[$i]['id'] = $user -> getId();

                if ($userDataBilling) {
                    $userInfo[$i]['fullname'] = $userDataBilling -> getFullName();
                    $userInfo[$i]['company'] = $userDataBilling -> getCompany();
                }

                $userInfo[$i]['created_at'] = $user -> getCreatedAt();

                $i++;
            }

            $this -> userInfo = $userInfo;
            $this -> userQuantity = count($users);
        } else {
            $this -> userInfo = "";
            $this -> userQuantity = 0;
        }
    }

    public function validateEdit() {
        $ok = true;

        if ($this -> getRequest() -> getMethod() == sfRequest::POST) {
            if (!$this -> getRequest() -> getParameter('id')) {
                $i18n = $this -> getContext() -> getI18N();

                if ($this -> getRequestParameter('sf_guard_user[password]') !=$this -> getRequestParameter('sf_guard_user[password_bis]')) {
                    $this -> getRequest() -> setError('sf_guard_user{password}', $i18n -> __('Hasła nie są takie same.'));
                    $this -> getRequest() -> setError('sf_guard_user{password_bis}', $i18n -> __('Hasła nie są takie same.'));
                    $ok = false;
                }
                
                if (strlen($this -> getRequestParameter('sf_guard_user[password]'))<6) {
                    $this -> getRequest() -> setError('sf_guard_user{password}', $i18n -> __('Za krótkie hasło min. 6 znaków.'));
                    $ok = false;
                }

                if (strlen($this -> getRequestParameter('sf_guard_user[password_bis]'))<6) {
                    $this -> getRequest() -> setError('sf_guard_user{password_bis}', $i18n -> __('Za krótkie hasło min. 6 znaków.'));
                    $ok = false;
                }

                if (!$this -> getRequestParameter('sf_guard_user[password]')) {
                    $this -> getRequest() -> setError('sf_guard_user{password}', $i18n -> __('Proszę podać hasło.'));
                    $ok = false;
                }

                if (!$this -> getRequestParameter('sf_guard_user[password_bis]')) {
                    $this -> getRequest() -> setError('sf_guard_user{password_bis}', $i18n -> __('Proszę podać hasło.'));
                    $ok = false;
                }

                
            }
            
            if ($this -> getRequest() -> getParameter('id')) {
                $i18n = $this -> getContext() -> getI18N();

                if ($this -> getRequestParameter('sf_guard_user[password]') || $this -> getRequestParameter('sf_guard_user[password_bis]')) {



                    if ($this -> getRequestParameter('sf_guard_user[password]') !=$this -> getRequestParameter('sf_guard_user[password_bis]')) {
                        $this -> getRequest() -> setError('sf_guard_user{password}', $i18n -> __('Hasła nie są takie same.'));
                        $this -> getRequest() -> setError('sf_guard_user{password_bis}', $i18n -> __('Hasła nie są takie same.'));
                        $ok = false;
                    }
                    
                    if (strlen($this -> getRequestParameter('sf_guard_user[password]'))<6) {
                        $this -> getRequest() -> setError('sf_guard_user{password}', $i18n -> __('Za krótkie hasło min. 6 znaków.'));
                        $ok = false;
                    }
    
                    if (strlen($this -> getRequestParameter('sf_guard_user[password_bis]'))<6) {
                        $this -> getRequest() -> setError('sf_guard_user{password_bis}', $i18n -> __('Za krótkie hasło min. 6 znaków.'));
                        $ok = false;
                    }

                    if (!$this -> getRequestParameter('sf_guard_user[password]')) {
                        $this -> getRequest() -> setError('sf_guard_user{password}', $i18n -> __('Proszę podać hasło.'));
                        $ok = false;
                    }
    
                    if (!$this -> getRequestParameter('sf_guard_user[password_bis]')) {
                        $this -> getRequest() -> setError('sf_guard_user{password_bis}', $i18n -> __('Proszę podać hasło.'));
                        $ok = false;
                    }                    
                                                            
                
                }
            }
            
            
        }

        return $ok;
    }

    public function validatePointsEdit() {
        $ok = true;
        if ($this -> getRequest() -> getMethod() == sfRequest::POST) {

            $i18n = $this -> getContext() -> getI18N();

            $points = $this -> getRequestParameter('sf_guard_user[points]');

            if ($points=="" || $points < 0 ) {
                $this -> getRequest() -> setError('sf_guard_user{points}', $i18n -> __('Proszę podać punkty.'));
                $ok = false;
            } else {

                $pattern = "/^[0-9]+$/";

                if (preg_match($pattern, $points) != 1) {
                    $this -> getRequest() -> setError('sf_guard_user{points}', $i18n -> __('Niepoprawna wartość'));
                    $ok = false;
                }
            }

        }
        return $ok;
    }

    protected function savePointssfGuardUser($sf_guard_user) {
        $this -> getDispatcher() -> notify(new sfEvent($this, 'autoStUserActions.preSavePoints', array('modelInstance' => $sf_guard_user)));
        $sf_guard_user -> save();

        $i18n = $this->getContext()->getI18n();

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
                $userPoints -> setAdminId(sfContext::getInstance() -> getUser() -> getGuardUser() -> getId());
                $userPoints -> setPoints($sf_guard_user -> getPoints());
                $userPoints -> setChangePoints($sf_guard_user -> getPoints() - $lastPoints -> getPoints());
                $userPoints -> setChangePointsVarchar($change_points);
                if ($this -> getRequestParameter('sf_guard_user[operation_description]') == "") {
                    $userPoints -> setDescription("Aktualizacja stanu konta");
                } else {
                    $userPoints -> setDescription($this -> getRequestParameter('sf_guard_user[operation_description]'));
                }
                $userPoints -> save();
            }

        } else {
            $change_points = "+" . $sf_guard_user -> getPoints();

            $userPoints = new UserPoints();
            $userPoints -> setSfGuardUserId($sf_guard_user -> getId());
            $userPoints -> setAdminId(sfContext::getInstance() -> getUser() -> getGuardUser() -> getId());
            $userPoints -> setPoints($sf_guard_user -> getPoints());
            $userPoints -> setChangePoints($sf_guard_user -> getPoints());
            $userPoints -> setChangePointsVarchar($change_points);
            if ($this -> getRequestParameter('sf_guard_user[operation_description]') == "") {
                $userPoints -> setDescription("Aktualizacja stanu konta");
            } else {
                $userPoints -> setDescription($this -> getRequestParameter('sf_guard_user[operation_description]'));
            }
            $userPoints -> save();
        }

        $this -> getDispatcher() -> notify(new sfEvent($this, 'autoStUserActions.postSavePoints', array('modelInstance' => $sf_guard_user)));

    }

    public function executeUserPointsList() {
        parent::executeUserPointsList();

        $this -> pager -> getCriteria() -> add(UserPointsPeer::SF_GUARD_USER_ID, $this -> forward_parameters['user_id']);
        $this -> pager -> init();
    }
    
    

    public function validatePointsInfoEdit() {

        $ok = true;
        if ($this -> getRequest() -> getMethod() == sfRequest::POST) {         

            $i18n = $this -> getContext() -> getI18N();

            $amount = $this -> getRequestParameter('sf_guard_user[user_points]');

            if (!$amount) {
                $this -> getRequest() -> setError('sf_guard_user{user_points_input_operation}', $i18n -> __('Proszę podać punkty.'));
                $ok = false;
            } else {
                
                
                if($amount{0}=="+" || $amount{0}=="-"){
                  $amount_value = substr($amount, 1);  
                } else{
                    $amount_value = $amount;
                }
                
                // echo $amount_value;
                // die();
//                                 
                $pattern = "/^[0-9]+$/";

                if (preg_match($pattern, $amount_value) != 1) {
                    $this -> getRequest() -> setError('sf_guard_user{user_points_input_operation}', $i18n -> __('Niepoprawna wartość'));
                    $ok = false;
                }
            
                $c = new Criteria();
                $c -> add(sfGuardUserPeer::ID, $this -> getRequestParameter('id'));
                $user = sfGuardUserPeer::doSelectOne($c);
                
                $value = $user->getPoints()+$amount; 
                
                if($value<0){
                    $this -> getRequest() -> setError('sf_guard_user{user_points_input_operation}', $i18n -> __('Odejmowana wartość nie może być większa od aktualnej liczby punktów'));
                    $ok = false;
                }
                
            }

        }
        return $ok;
    }

    protected function updatePointsInfosfGuardUserFromRequest() {
        $sf_guard_user = $this -> getRequestParameter('sf_guard_user');

        if (isset($sf_guard_user['header_user_info'])) {
            if (method_exists($this -> sf_guard_user, 'setHeaderUserInfo')) {
                $this -> sf_guard_user -> setHeaderUserInfo($sf_guard_user['header_user_info']);
            }
        }
        if (isset($sf_guard_user['header_user_points'])) {
            if (method_exists($this -> sf_guard_user, 'setHeaderUserPoints')) {
                $this -> sf_guard_user -> setHeaderUserPoints($sf_guard_user['header_user_points']);
            }
        }
        if (isset($sf_guard_user['user_points'])) {
            if (method_exists($this -> sf_guard_user, 'setPoints')) {

                $new_points = $this -> getRequestParameter('sf_guard_user[user_points]');
                $points_value = substr($new_points, 1);

                if ($new_points{0} == "-") {
                    $new_user_points = $this -> sf_guard_user -> getPoints() - $points_value;
                }

                if ($new_points{0} == "+") {
                    $new_user_points = $this -> sf_guard_user -> getPoints() + $points_value;
                }

                if ($new_points{0} != "+" && $new_points{0} != "-") {
                    $new_user_points = $this -> sf_guard_user -> getPoints() + $new_points;
                }

                $this -> sf_guard_user -> setPoints($new_user_points);
            }
        }
        if (isset($sf_guard_user['user_points_input_operation'])) {
            if (method_exists($this -> sf_guard_user, 'setUserPointsInputOperation')) {
                $this -> sf_guard_user -> setUserPointsInputOperation($sf_guard_user['user_points_input_operation']);
            }
        }
        if (isset($sf_guard_user['user_points_description_operation'])) {
            if (method_exists($this -> sf_guard_user, 'setUserPointsDescriptionOperation')) {
                $this -> sf_guard_user -> setUserPointsDescriptionOperation($sf_guard_user['user_points_description_operation']);
            }
        }
        $this -> getDispatcher() -> notify(new sfEvent($this, 'autoStUserActions.postUpdatePointsInfoFromRequest', array('modelInstance' => $this -> sf_guard_user, 'requestParameters' => $sf_guard_user)));
    }

    protected function savePointsInfosfGuardUser($sf_guard_user) {
        $this -> getDispatcher() -> notify(new sfEvent($this, 'autoStUserActions.preSavePointsInfo', array('modelInstance' => $sf_guard_user)));
        $sf_guard_user -> save();
        
        $i18n = $this->getContext()->getI18n();
        
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
                $userPoints -> setAdminId(sfContext::getInstance() -> getUser() -> getGuardUser() -> getId());
                $userPoints -> setPoints($sf_guard_user -> getPoints());
                $userPoints -> setChangePoints($sf_guard_user -> getPoints() - $lastPoints -> getPoints());
                $userPoints -> setChangePointsVarchar($change_points);
                if ($this -> getRequestParameter('sf_guard_user[operation_description]') == "") {
                    $userPoints -> setDescription("Aktualizacja stanu konta");
                } else {
                    $userPoints -> setDescription($this -> getRequestParameter('sf_guard_user[operation_description]'));
                }
                $userPoints -> save();
            }

        } else {
            $change_points = "+" . $sf_guard_user -> getPoints();

            $userPoints = new UserPoints();
            $userPoints -> setSfGuardUserId($sf_guard_user -> getId());
            $userPoints -> setAdminId(sfContext::getInstance() -> getUser() -> getGuardUser() -> getId());
            $userPoints -> setPoints($sf_guard_user -> getPoints());
            $userPoints -> setChangePoints($sf_guard_user -> getPoints());
            $userPoints -> setChangePointsVarchar($change_points);
            if ($this -> getRequestParameter('sf_guard_user[operation_description]') == "") {
                $userPoints -> setDescription("Aktualizacja stanu konta");
            } else {
                $userPoints -> setDescription($this -> getRequestParameter('sf_guard_user[operation_description]'));
            }
            $userPoints -> save();
        }

        $this -> getDispatcher() -> notify(new sfEvent($this, 'autoStUserActions.postSavePointsInfo', array('modelInstance' => $sf_guard_user)));

    }
    
     public function executePointsAvailable() {
            
        $user_id = $this -> getRequestParameter('user_id');
        $on = $this -> getRequestParameter('on');

        $c = new Criteria();
        $c -> add(sfGuardUserPeer::ID, $user_id);
        $user = sfGuardUserPeer::doSelectOne($c);

        $user -> setPointsAvailable($on);
        $user -> save();

        return $this -> redirect('stUser/pointsInfoEdit?id='.$user->getId());

    }
     
    public function executePointsRelease() {
            
        $user_id = $this -> getRequestParameter('user_id');
        $on = $this -> getRequestParameter('on');

        $c = new Criteria();
        $c -> add(sfGuardUserPeer::ID, $user_id);
        $user = sfGuardUserPeer::doSelectOne($c);

        $user -> setPointsRelease($on);
        $user -> save();

        return $this -> redirect('stUser/pointsInfoEdit?id='.$user->getId());

    }

}
