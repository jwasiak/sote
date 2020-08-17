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
 * @version     $Id: actions.class.php 2671 2009-08-19 14:33:54Z bartek $
 */

/**
 * Akcje profili użytkownika 
 *
 * @author Bartosz Alejski <bartosz.alejski@sote.pl>
 *
 * @package     stUser
 * @subpackage  actions
 */
class stUserDataActions extends stActions
{

    public function executeCreateFirstUserData()
    {
        if($this->getUser()->isAuthenticated())
        {
            $this->smarty = new stSmarty($this->getModuleName());

            $user_config = stConfig::getInstance(sfContext::getInstance(), 'stUser');
            $this->show_region = $user_config->get('show_region');
            $this->show_pesel = $user_config->get('show_pesel');
            $this->show_address_more = $user_config->get('show_address_more');

            $change_default_user = $user_config->get('change_default_user');
            
            if ($this->getRequest()->getMethod() == sfRequest::POST)
            {
                $userDataBilling = $this->getRequestParameter('user_data_billing');
                $userDataDelivery = $this->getRequestParameter('user_data_delivery');

                stUser::updateUserData($userDataBilling['id'],$this->getUser()->getGuardUser()->getId(),1,1,$userDataBilling);

                if($this->getRequestParameter('different_delivery'))
                {
                    stUser::updateUserData($userDataDelivery['id'],$this->getUser()->getGuardUser()->getId(),0,1,$userDataDelivery);
                }
                else
                {
                    stUser::updateUserData($userDataDelivery['id'],$this->getUser()->getGuardUser()->getId(),0,1,$userDataBilling);
                }

                if(!stTheme::is_responsive()){
                    $this->redirect('stUser/editAccount');    
                }else{
                    $this->redirect('stUserData/userPanel');
                }
                
            }

            $userDataBilling = $this->getUserDataBillingDefault($this->getUser()->getGuardUser()->getId());
            $this->userDataBilling = $userDataBilling;

            $userDataDelivery = $this->getUserDataDeliveryDefault($this->getUser()->getGuardUser()->getId());
            $this->userDataDelivery = $userDataDelivery;
                    
            $this->type1_delivery_checker = 1;
            $this->type2_delivery_checker = 0;
            
            if($change_default_user!=1)
            {
                $this->type1_billing_checker = 1;
                $this->type2_billing_checker = 0;
            }
            else
            {
                $this->type1_billing_checker = 0;
                $this->type2_billing_checker = 1;    
            }
            
            $this->different_billing = 0;
            
        }
        else
        {
            stUser::processAuthentication();
        }
    }

    public function executeCreateFirstUserDataBilling()
    {
        if($this->getUser()->isAuthenticated())
        {
            $userDataBilling = stUser::updateUserData(null,$this->getUser()->getGuardUser()->getId(),1,1);                                    
            $this->redirect('stUserData/editProfile?userDataType=billing&userDataId='.$userDataBilling->getId().'&showEditProfileForm=true');                       
        }
        else
        {
            stUser::processAuthentication();
        }
    }
    
    public function executeCreateFirstUserDataDelivery()
    {
        if($this->getUser()->isAuthenticated())
        {            
            $userDataDelivery = stUser::updateUserData(null,$this->getUser()->getGuardUser()->getId(),0,1);
            $this->redirect('stUserData/editProfile?userDataType=delivery&userDataId='.$userDataDelivery->getId().'&showEditProfileForm=true');
            
        }
        else
        {
            stUser::processAuthentication();
        }
    }


    public function getUserDataBillingDefault($user_id)
    {
        $c = new Criteria();
        $c->add(UserDataPeer::SF_GUARD_USER_ID, $user_id);
        $c->add(UserDataPeer::IS_DEFAULT , 1);
        $c->add(UserDataPeer::IS_BILLING , 1);
        if ($userDataBillingDefault = UserDataPeer::doSelectOne($c))
        {
            $this->user_data = $userDataBillingDefault;
        }
        else
        {
            $this->user_data = new UserData();

            $this->user_data->setSfGuardUserId($user_id);
            $this->user_data->setIsBilling(1);
            $this->user_data->setIsDefault(1);
            $this->user_data->setCountriesId(CountriesPeer::doSelectDefault(new Criteria())->getId());
        }

        $userDataBillingDefault = $this->user_data;
        return $userDataBillingDefault;
    }

    public function getUserDataDeliveryDefault($user_id)
    {
        $c = new Criteria();
        $c->add(UserDataPeer::SF_GUARD_USER_ID, $user_id);
        $c->add(UserDataPeer::IS_DEFAULT , 1);
        $c->add(UserDataPeer::IS_BILLING , 0);
        if ($userDataDeliveryDefault = UserDataPeer::doSelectOne($c))
        {
            $this->user_data = $userDataDeliveryDefault;
        }
        else
        {
            $this->user_data = new UserData();

            $this->user_data->setSfGuardUserId($user_id);
            $this->user_data->setIsBilling(1);
            $this->user_data->setIsDefault(1);
            $this->user_data->setCountriesId(CountriesPeer::doSelectDefault(new Criteria())->getId());
        }

        $userDataDeliveryDefault = $this->user_data;
        return $userDataDeliveryDefault;
    }

    public function getUserDataBillingAll($user_id)
    {
        $c = new Criteria();
        $c->add(UserDataPeer::SF_GUARD_USER_ID, $user_id);
        $c->add(UserDataPeer::IS_BILLING , 1);
        $userDataBillingAll = UserDataPeer::doSelect($c);

        return $userDataBillingAll;
    }

    public function getUserDataDeliveryAll($user_id)
    {
        $c = new Criteria();
        $c->add(UserDataPeer::SF_GUARD_USER_ID, $user_id);
        $c->add(UserDataPeer::IS_BILLING , 0);
        $userDataDeliveryAll = UserDataPeer::doSelect($c);

        return $userDataDeliveryAll;
    }

    public function executeUserPanel()
    {
        $this->smarty = new stSmarty($this->getModuleName());

        if($this->getUser()->isAuthenticated())
        {
            
            $userDataBilling = $this->getUserDataBillingDefault($this->getUser()->getAttribute('user_id', null, 'sfGuardSecurityUser'));
            $this->userDataBilling = $userDataBilling;

            $userDataDelivery = $this->getUserDataDeliveryDefault($this->getUser()->getAttribute('user_id', null, 'sfGuardSecurityUser'));
            $this->userDataDelivery = $userDataDelivery;
            
            if(!stTheme::is_responsive()){
            
                if($userDataBilling->getAddress()=="" || $userDataDelivery->getAddress()=="")
                {
                    $this->redirect('stUserData/createFirstUserData');
                }
            
            }
            
            $c = new Criteria();
            $c->add(OrderPeer::SF_GUARD_USER_ID, $this->getUser()->getAttribute('user_id', null, 'sfGuardSecurityUser'));
            $c->setLimit(10);
            $orders = OrderPeer::doSelect($c);
          
            if($orders)
            {
                $this->user_order = 1;
                $this->orders = $orders;      
            }
            
            $c = new Criteria();
            $c->add(OrderPeer::SF_GUARD_USER_ID, $this->getUser()->getAttribute('user_id', null, 'sfGuardSecurityUser'));
            $c->addDescendingOrderByColumn('CREATED_AT');
            $lastOrder = OrderPeer::doSelectOne($c);
          
            if($lastOrder)
            {
                $this->lastOrder = $lastOrder;      
                $this->currency = $lastOrder->getOrderCurrency();
            }
            
            
            $c = new Criteria();
            $c->add(DiscountUserPeer::SF_GUARD_USER_ID, $this->getUser()->getAttribute('user_id', null, 'sfGuardSecurityUser'));
            $userDiscount = DiscountUserPeer::doSelectOne($c);

            $uid = DiscountPeer::doSelectIdsByUser($this->getUser()->getGuardUser());

            $c = new Criteria();
            $c->add(DiscountPeer::ACTIVE, true);

            if ($uid)
            {
                $uc = $c->getNewCriterion(DiscountPeer::ID, $uid, Criteria::IN);
                $uc->addOr($c->getNewCriterion(DiscountPeer::ALL_CLIENTS, true));
                $c->add($uc);
            }
            else
            {
                $c->add(DiscountPeer::ALL_CLIENTS, true);
            }

            $discount_count = DiscountPeer::doCount($c);

            $this->user_discounts = $discount_count > 0 || $user_discount && $user_discount->getDiscount()->getValue() > 0;
        }
        else
        {
            stUser::processAuthentication();
        }

        $newsletterConfig = stConfig::getInstance($this->getContext(), 'stNewsletterBackend');

        $newsletterConfig = $newsletterConfig->load();

        $this->newsletterConfig = $newsletterConfig;
        
        
        $pointsConfig = stConfig::getInstance($this->getContext(), 'stPointsBackend');

        $pointsConfig = $pointsConfig->load();
        
        stPoints::refreshLoginStatusPoints();  
      
        $this->pointsConfig = $pointsConfig;
        
    }

    public function executeTest()
    {
        $this->getUser()->setAuthenticated(false);
        $this->redirect('stUserData/userPanel');
    }

    public function executeEditProfile()
    {
        $this->smarty = new stSmarty($this->getModuleName());

        if($this->getUser()->isAuthenticated())
        {

            $userDataId = $this->getRequestParameter('userDataId');
            $userData = $this->getRequestParameter('user_data');
            $userDataType = $this->getRequestParameter('userDataType');
            $showEditProfileForm = $this->getRequestParameter('showEditProfileForm');
            $showMessage = $this->getRequestParameter('showMessage');
            $this->isMyUserData($userDataId);

            $showEditProfileForm = true;

            $this->userDataId = $userDataId;
            $this->userDataType = $userDataType;
            $this->showMessage = $showMessage;
            $this->showEditProfileForm = $showEditProfileForm;

        }
        else
        {
            stUser::processAuthentication();
        }
    }

    public function executeSaveProfile()
    {
        if($this->getUser()->isAuthenticated())
        {

            $userDataId = $this->getRequestParameter('userDataId');
            $userData = $this->getRequestParameter('user_data');
            $userDataType = $this->getRequestParameter('userDataType');
            $showEditProfileForm = $this->getRequestParameter('showEditProfileForm');
                       
           // print_r($userData);
           // die();
           
            if($userDataType=="billing")
            {
                $isBilling = 1;
            }
            else 
            {
                $isBilling = 0;
            }
            
            if($this->hasRequestParameter('user_data_delivery'))
            {
                $userData['country'] = $this->getRequestParameter('user_data_delivery[country]');
            }
          
                        
                // $c = new Criteria();
                // $c->add(UserDataPeer::SF_GUARD_USER_ID, $this->getUser()->getGuardUser()->getId());
                // $c->add(UserDataPeer::IS_BILLING, $isBilling);
//                 
                // if(!UserDataPeer::doSelectOne($c))
                // {
                    // $userData['isDefault']=1;
                // }
                
            
                // if($userData['isDefault']==1){
                   // $this->setDefaultUserData($userData['id'], $userData['isBilling']);
                // }
    
            
            stUser::updateUserData($userData['id'],$this->getUser()->getGuardUser()->getId(),$userData['isBilling'],$userData['isDefault'],$userData);

            if(!$showEditProfileForm)
            {
                $showEditProfileForm == false;
            }

            $this->userDataId = $userDataId;
            $this->userDataType = $userDataType;
            $this->showEditProfileForm = $showEditProfileForm;

            $this->redirect('stUserData/editProfile?userDataType='.$userDataType.'&userDataId='.$userDataId.'&showMessage=true');

        }
        else
        {
            stUser::processAuthentication();
        }
    }


    /**
     * Usuwanie profilu
     */
    public function executeCreateProfile()
    {

        if($this->getUser()->isAuthenticated())
        {
            $userDataType = $this->getRequestParameter('userDataType');

            $userData = stUser::updateUserData('',$this->getUser()->getAttribute('user_id', null, 'sfGuardSecurityUser'),$this->getUserDataTypeNumericValue($userDataType),0);

            $this->redirect('stUserData/editProfile?userDataType='.$userDataType.'&userDataId='.$userData->getId().'&showEditProfileForm=true');
        }
        else
        {
            stUser::processAuthentication();
        }
    }

    /**
     * Usuwanie profilu
     */
    public function executeDeleteProfile()
    {
        if($this->getUser()->isAuthenticated())
        {

            $userDataType = $this->getRequestParameter('userDataType');

            $c = new Criteria();
            $c->add(UserDataPeer::ID, $this->getRequestParameter('userDataId'));
            $c->add(UserDataPeer::SF_GUARD_USER_ID, $this->getUser()->getAttribute('user_id', null, 'sfGuardSecurityUser'));
            UserDataPeer::doDelete($c);

            if($this->getUserDataTypeNumericValue($userDataType)==1)
            {
                $userData = $this->getUserDataBillingDefault($this->getUser()->getAttribute('user_id', null, 'sfGuardSecurityUser'));
            }
            else
            {
                $userData = $this->getUserDataDeliveryDefault($this->getUser()->getAttribute('user_id', null, 'sfGuardSecurityUser'));
            }

            $this->redirect('stUserData/editProfile?userDataType='.$userDataType.'&userDataId='.$userData->getId());

        }
        else
        {
            stUser::processAuthentication();
        }
    }


    /**
     */
    public function setDefaultUserData($userDataId, $isBilling)
    {
        if($this->getUser()->isAuthenticated())
        {

            $con = Propel::getConnection();
            $c1 = new Criteria();
            $c1->add(UserDataPeer::SF_GUARD_USER_ID , $this->getUser()->getAttribute('user_id', null, 'sfGuardSecurityUser'));

            if($isBilling == 1)
            {
                $c1->add(UserDataPeer::IS_BILLING, 1);
            }
            else
            {
                $c1->add(UserDataPeer::IS_BILLING, 0);
            }

            $c1->add(UserDataPeer::IS_DEFAULT, 1);

            $c2 = new Criteria();
            $c2->add(UserDataPeer::IS_DEFAULT, 0);

            BasePeer::doUpdate($c1, $c2, $con);

            $c = new Criteria();
            $c->add(UserDataPeer::SF_GUARD_USER_ID, $this->getUser()->getAttribute('user_id', null, 'sfGuardSecurityUser'));
            $c->add(UserDataPeer::ID, $userDataId);

            $userData = UserDataPeer::doSelectOne($c);

            $userData->setIsDefault(1);
            $userData->save();

        }
        else
        {
            stUser::processAuthentication();
        }
    }

    /**
     */
    public function executeSetDefaultProfile()
    {
        if($this->getUser()->isAuthenticated())
        {

            $userDataId = $this->getRequestParameter('userDataId');
            $userDataType = $this->getRequestParameter('userDataType');

            $this->setDefaultUserData($userDataId, $this->getUserDataTypeNumericValue($userDataType));

            $this->redirect('stUserData/editProfile?userDataType='.$userDataType.'&userDataId='.$userDataId.'&showMessage=true');
        }
        else
        {
            stUser::processAuthentication();
        }
    }

    /**
     */
    public function getUserDataTypeNumericValue($userDataType)
    {
        if($userDataType == "billing")
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }



    /**
     * Uchwyt do walidatora tworzenia konta.
     *
     * @return   string
     */
    public function handleErrorCreateFirstUserData()
    {
        $this->smarty = new stSmarty($this->getModuleName());

        $this->updateUserDataFromRequest();
        return sfView::SUCCESS;
    }

    protected function updateUserDataFromRequest()
    {

        $user_config = stConfig::getInstance(sfContext::getInstance(), 'stUser');
        $this->show_region = $user_config->get('show_region');
        $this->show_pesel = $user_config->get('show_pesel');
        $this->show_address_more = $user_config->get('show_address_more');

        $this->smarty = new stSmarty($this->getModuleName());

        $userDataBilling = new UserData();
        $userDataDelivery = new UserData();

        $userDataBillingFromRequest = $this->getRequestParameter('user_data_billing');
        $userDataDeliveryFromRequest = $this->getRequestParameter('user_data_delivery');

        $userDataBilling->setId($userDataBillingFromRequest['id']);
        $userDataDelivery->setId($userDataDeliveryFromRequest['id']);

        if (isset($userDataBillingFromRequest['full_name']))
        {
            $userDataBilling->setFullName($userDataBillingFromRequest['full_name']);
        }

        if (isset($userDataBillingFromRequest['address']))
        {
            $userDataBilling->setAddress($userDataBillingFromRequest['address']);
        }

        if (isset($userDataBillingFromRequest['address_more']))
        {
            $userDataBilling->setAddressMore($userDataBillingFromRequest['address_more']);
        }

        if (isset($userDataBillingFromRequest['region']))
        {
            $userDataBilling->setRegion($userDataBillingFromRequest['region']);
        }

        if (isset($userDataBillingFromRequest['pesel']))
        {
            $userDataBilling->setPesel($userDataBillingFromRequest['pesel']);
        }

        if (isset($userDataBillingFromRequest['code']))
        {
            $userDataBilling->setCode($userDataBillingFromRequest['code']);
        }

        if (isset($userDataBillingFromRequest['town']))
        {
            $userDataBilling->setTown($userDataBillingFromRequest['town']);
        }

        if (isset($userDataBillingFromRequest['country']))
        {
            $userDataBilling->setCountriesId($userDataBillingFromRequest['country']);
        }

        if (isset($userDataBillingFromRequest['phone']))
        {
            $userDataBilling->setPhone($userDataBillingFromRequest['phone']);
        }

        if (isset($userDataBillingFromRequest['company']))
        {
            $userDataBilling->setCompany($userDataBillingFromRequest['company']);
        }

        if (isset($userDataBillingFromRequest['vat_number']))
        {
            $userDataBilling->setVatNumber($userDataBillingFromRequest['vat_number']);
        }

        if (isset($userDataDeliveryFromRequest['full_name']))
        {
            $userDataDelivery->setFullName($userDataDeliveryFromRequest['full_name']);
        }

        if (isset($userDataDeliveryFromRequest['address']))
        {
            $userDataDelivery->setAddress($userDataDeliveryFromRequest['address']);
        }

        if (isset($userDataDeliveryFromRequest['address_more']))
        {
            $userDataDelivery->setAddressMore($userDataDeliveryFromRequest['address_more']);
        }

        if (isset($userDataDeliveryFromRequest['region']))
        {
            $userDataDelivery->setRegion($userDataDeliveryFromRequest['region']);
        }

        if (isset($userDataDeliveryFromRequest['code']))
        {
            $userDataDelivery->setCode($userDataDeliveryFromRequest['code']);
        }

        if (isset($userDataDeliveryFromRequest['town']))
        {
            $userDataDelivery->setTown($userDataDeliveryFromRequest['town']);
        }

        if (isset($userDataDeliveryFromRequest['country']))
        {
            $userDataDelivery->setCountriesId($userDataDeliveryFromRequest['country']);
        }

        if (isset($userDataDeliveryFromRequest['phone']))
        {
            $userDataDelivery->setPhone($userDataDeliveryFromRequest['phone']);
        }

        if (isset($userDataDeliveryFromRequest['company']))
        {
            $userDataDelivery->setCompany($userDataDeliveryFromRequest['company']);
        }


        $this->userDataBilling = $userDataBilling;
        $this->userDataDelivery = $userDataDelivery;
                    
        if ($userDataDeliveryFromRequest['customer_type']==2)
        {
            $this->type1_delivery_checker = 0;
            $this->type2_delivery_checker = 1;
        }
        else
        {
            $this->type1_delivery_checker = 1;
            $this->type2_delivery_checker = 0;
        }
        
        if ($userDataBillingFromRequest['customer_type']==2)
        {
            $this->type1_billing_checker = 0;
            $this->type2_billing_checker = 1;
        }
        else
        {
            $this->type1_billing_checker = 1;
            $this->type2_billing_checker = 0;
        }

        $this->different_delivery = $this->getRequestParameter('different_delivery');


    }

     protected function updateBasketUserData()
    {

        $user_config = stConfig::getInstance(sfContext::getInstance(), 'stUser');
        $this->show_region = $user_config->get('show_region');
        $this->show_pesel = $user_config->get('show_pesel');

        $this->smarty = new stSmarty($this->getModuleName());       

        $userDataBillingFromRequest = $this->getRequestParameter('user_data_billing');
                
        // if ($userDataBillingFromRequest['customer_billing_type']==2)
        // {
        //     $this->type1_billing_checker = 0;
        //     $this->type2_billing_checker = 1;
        // }
        // else
        // {
        //     $this->type1_billing_checker = 1;
        //     $this->type2_billing_checker = 0;
        // }
        
        $userDataDeliveryFromRequest = $this->getRequestParameter('user_data_delivery');
        
        // if ($userDataDeliveryFromRequest['customer_delivery_type']==2)
  //       {
  //           $this->type1_delivery_checker = 0;
  //           $this->type2_delivery_checker = 1;
  //       }
  //       else
  //       {
  //           $this->type1_delivery_checker = 1;
  //           $this->type2_delivery_checker = 0;
  //       }
        
        
        $this->userDataBilling = $this->getRequestParameter('user_data_billing');
        
        $this->userDataDelivery = $this->getRequestParameter('user_data_delivery');

    }


    public function validateCreateFirstUserData()
    {
        $error_exists = false;
        
        $user_config = stConfig::getInstance(sfContext::getInstance(), 'stUser');

        $i18n = $this->getContext()->getI18N();

        $billing = $this->getRequestParameter('user_data_billing', array());       
              
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {            
            // if (stConfig::getInstance('stPaczkomatyBackend')->get('enable')) {
                // $delivery = stDeliveryFrontend::getInstance(stBasket::getInstance($this->getUser()))->getDefaultDelivery();
                // if (is_object($delivery) && in_array($delivery->getPaczkomatyType(), array('ALL', 'COD'))) {
                    // $user_config->set('validate_phone', 1);
// 
                    // if (!$billing['paczkomaty_machine_number']) {
                        // $this->getRequest()->setError('user_data_billing{paczkomaty_machine_number}', true);
                        // $error_exists = true;
                    // }
                // }
            // }
    
            if ($billing['customer_type']==2)
            {
                if (!$billing['company'])
                {
                    $this->getRequest()->setError('user_data_billing{company}', $i18n->__('Brak firmy.'));
                    $error_exists = true;
                }
                
                if (!$billing['vat_number'])
                {
                    $this->getRequest()->setError('user_data_billing{vat_number}', $i18n->__('Brak nipu.'));
                    $error_exists = true;
                }   
            }
            else
            {
                if (!$billing['full_name'])
                {
                    $this->getRequest()->setError('user_data_billing{full_name}', $i18n->__('Brak imienia i nazwiska.'));
                    $error_exists = true;
                }   
            }
            
            if (!$billing['phone']  && $user_config->get('validate_phone')==1)
            {
                    $this->getRequest()->setError('user_data_billing{phone}', $i18n->__('Brak telefonu.'));
                    $error_exists = true;
            }
    
            if ($this->hasRequestParameter('different_delivery'))
            {
                $delivery = $this->getRequestParameter('user_data_delivery', array());
    
                $validator = new sfStringValidator();
                $validator->initialize($this->getContext(), array(
                'max' => 255,
                'max_error' => $i18n->__('Przekroczono dozwoloną liczbę znaków.'),
    
                ));
    
    
                if ($delivery['customer_type']==2)
                {
                    if (!$delivery['company']) 
                    {
                        $this->getRequest()->setError('user_data_delivery{company}', $i18n->__('Brak firmy.'));
                        $error_exists = true;
                    }
                   
                }
                else 
                {
                    if (!$delivery['full_name'])
                    {
                        $this->getRequest()->setError('user_data_delivery{full_name}', $i18n->__('Brak imienia i nazwiska.'));
                        $error_exists = true;
                    }
                }                            
    
                if (!$delivery['address'])
                {
                    $this->getRequest()->setError('user_data_delivery{address}', $i18n->__('Brak adresu.'));
                    $error_exists = true;
                }
       
                if (!$delivery['code'])
                {
                    $this->getRequest()->setError('user_data_delivery{code}', $i18n->__('Brak kodu.'));
                    $error_exists = true;
                }
    
                if (!$delivery['town'])
                {
                    $this->getRequest()->setError('user_data_delivery{town}', $i18n->__('Brak miasta.'));
                    $error_exists = true;
                }
    
                if (!$delivery['phone']  && $user_config->get('validate_phone')==1)
                {
                    $this->getRequest()->setError('user_data_delivery{phone}', $i18n->__('Brak telefonu.'));
                    $error_exists = true;
                }
    
            }
        
        }
        

        return !$error_exists;
    }

    public function validateAddBasketUser()
    {
        $user_config = stConfig::getInstance('stUser');
        $invoice_config = stConfig::getInstance('stInvoiceBackend');

        $error_exists = false;

        $i18n = $this->getContext()->getI18N();

        $user_data_billing = $this->getRequestParameter('user_data_billing');
        
        $user_data_delivery = $this->getRequestParameter('user_data_delivery');

        $delivery = stDeliveryFrontend::getInstance($this->getUser()->getBasket())->getDefaultDelivery();

        if (stConfig::getInstance('stPaczkomatyBackend')->get('enable')) {
            
            if (is_object($delivery) && in_array($delivery->getPaczkomatyType(), array('ALL', 'COD'))) {
                $user_config->set('validate_phone', 1);

                if (!$user_data_billing['paczkomaty_machine_number']) {
                    $this->getRequest()->setError('user_data_billing{paczkomaty_machine_number}', true);
                    $error_exists = true;
                }
            }
        }

        if ($this->getUser()->hasVatEu())
        {
            $user_data_billing['customer_type'] = 2;
        }

        if(!isset($user_data_billing['create_account'])){$user_data_billing['create_account'] = 0;}
        
        if(!isset($user_data_billing['privacy'])){$user_data_billing['privacy'] = 0;}

        if(!isset($user_data_billing['different_delivery']) && !$this->getUser()->isAuthenticated())
        {
            $user_data_billing['different_delivery'] = 0;
            $user_data_delivery['customer_type'] = $user_data_billing['customer_type'];
            $user_data_delivery['company'] = $user_data_billing['company'];
            if(isset($user_data_billing['pesel'])){$user_data_delivery['pesel'] = $user_data_billing['pesel'];}
            $user_data_delivery['full_name'] = $user_data_billing['full_name'];
            $user_data_delivery['address'] = $user_data_billing['address'];
            $user_data_delivery['code'] = $user_data_billing['code'];
            $user_data_delivery['town'] = $user_data_billing['town'];
            if(isset($user_data_billing['region'])){$user_data_delivery['region'] = $user_data_billing['region'];}
            $user_data_delivery['country'] = $user_data_billing['country'];
            $user_data_delivery['phone'] = $user_data_billing['phone'];
        }

        if ($this->getUser()->isAuthenticated() && isset($user_data_billing['paczkomaty_machine_number']) && !empty($user_data_billing['paczkomaty_machine_number'])) {
            $user_data_delivery['phone'] = $user_data_billing['phone'];
        }
        
        if($user_data_billing)
        {
            if (isset($user_data_billing['email']))
            {
                $user_data_billing['email'] = trim($user_data_billing['email']); 

                $c = new Criteria();
            
                $c->add(sfGuardUserPeer::USERNAME, $user_data_billing['email']);    
                $user = sfGuardUserPeer::doSelectOne($c);
    
                if($user)
                {           
                    if(stUser::isFullAccount($user_data_billing['email']) && $user_data_billing['create_account']==1)
                    {
                        $this->getRequest()->setError('user_data_billing{email}', $i18n->__('Taki użytkownik już istnieje.'));
                        $error_exists = true;
                    }
                }
                
                $valid = filter_var($user_data_billing['email'], FILTER_VALIDATE_EMAIL);
                
                if(!$valid)
                {
                    $this->getRequest()->setError('user_data_billing{email}', $i18n->__('Niepoprawny adres.'));
                    $error_exists = true;
                }
            }

            if (!$user_data_billing['full_name'] && $user_data_billing['customer_type']==1)
            {
                 $this->getRequest()->setError('user_data_billing{full_name}', $i18n->__('Brak imienia i nazwiska.'));
                 $error_exists = true;
            }

            
            if (!$user_data_billing['company'] && $user_data_billing['customer_type']==2)
            {
                $this->getRequest()->setError('user_data_billing{company}', $i18n->__('Brak firmy.'));
                $error_exists = true;
            }
            
            if (!$user_data_billing['vat_number'] && $user_data_billing['customer_type']==2)
            {
                $this->getRequest()->setError('user_data_billing{vat_number}', 'Brak numeru NIP.');
                $error_exists = true;
            }
            elseif ($this->getUser()->hasVatEu())
            {
                if (!stTaxVies::hasValidCountryCode($user_data_billing['vat_number'], $invoice_config->get('seller_vat_number')))
                {
                    $this->getRequest()->setError('user_data_billing{vat_number}', $i18n->__('Podany numer VAT UE nie spełnia wymogów wewnątrzwspólnotowego nabycia towarów'));
                    $this->getUser()->setValidVatEu(false);
                    $error_exists = true;                    
                }
                elseif (!stTaxVies::getInstance()->checkVat($user_data_billing['vat_number']))
                {
                    $this->getRequest()->setError('user_data_billing{vat_number}', $i18n->__('Podany numer VAT UE jest nieaktywny lub nieprawidłowy'));
                    $this->getUser()->setValidVatEu(false);
                    $error_exists = true;
                }
                else
                {
                    $billingCountry = CountriesPeer::retrieveById($user_data_billing['country']);
                    list($cc) = stTaxVies::parseVatNumber($user_data_billing['vat_number']);

                    $ccEuFix = array('EL' => 'GR', 'CHE' => 'CH');

                    if (isset($ccEuFix[$cc])) 
                    {
                        $cc = $ccEuFix[$cc];
                    }
                    
                    if ($billingCountry->getIsoA2() != $cc)
                    {
                        $this->getRequest()->setError('user_data_billing{country}', $i18n->__('Wybrany kraj nie jest zgodny z podanym numerem VAT UE'));
                        $this->getUser()->setValidVatEu(false);
                        $error_exists = true;                         
                    }
                    else
                    {
                        $this->getUser()->setValidVatEu(true);
                    }
                }
            }


            if(!$this->getUser()->isAuthenticated())
            {
                if (!$user_data_billing['email'])
                {
                     $this->getRequest()->setError('user_data_billing{email}', $i18n->__('Brak adresu email.'));
                     $error_exists = true;
                }
            }
                           
            if($user_data_billing['create_account']==1  && !$this->getUser()->isAuthenticated())
            {
            
                if($user_data_billing['password1'] != $user_data_billing['password2'])
                {
                    $this->getRequest()->setError('user_data_billing{password1}', $i18n->__('Hasła nie są takie same.'));
                    $this->getRequest()->setError('user_data_billing{password2}', $i18n->__('Hasła nie są takie same.'));
                    $error_exists = true;
                }
            
                if(!$user_data_billing['password1'])
                {
                    $this->getRequest()->setError('user_data_billing{password1}', $i18n->__('Brak hasła.'));
                    $error_exists = true;
                }
                
                if(!$user_data_billing['password2'])
                {
                    $this->getRequest()->setError('user_data_billing{password2}', $i18n->__('Brak hasła.'));
                    $error_exists = true;
                }
                
                if(stTheme::is_responsive()){
                
                    if($user_data_billing['privacy']!=1)
                    {
                        $this->getRequest()->setError('error_privacy', 1);
                        $error_exists = true;
                    }
                }                
                
            }
            
            if (!$user_data_billing['address'])
            {
                 $this->getRequest()->setError('user_data_billing{address}', $i18n->__('Brak adresu.'));
                 $error_exists = true;
            }
            
            if (!$user_data_billing['code'])
            {
                 $this->getRequest()->setError('user_data_billing{code}', $i18n->__('Brak kodu.'));
                 $error_exists = true;
            }
            
            if (!$user_data_billing['town'])
            {
                 $this->getRequest()->setError('user_data_billing{town}', $i18n->__('Brak miasta.'));
                 $error_exists = true;
            }
            
            if (!$user_data_billing['phone'] && $user_config->get('validate_phone')==1)
            {
                 $this->getRequest()->setError('user_data_billing{phone}', $i18n->__('Brak telefonu.'));
                 $error_exists = true;
            }
            
            if ((isset($user_data_billing['different_delivery']) && $user_data_billing['different_delivery'] == 1 || $this->getUser()->isAuthenticated()) && !$delivery->isType('ppo') && !$delivery->isType('inpostp'))
            {
                if (!$user_data_delivery['company'] && $user_data_delivery['customer_type']==2)
                {
                    $this->getRequest()->setError('user_data_delivery{company}', $i18n->__('Brak firmy.'));
                    $error_exists = true;
                }
                
                if (!$user_data_delivery['full_name'] && $user_data_delivery['customer_type']==1)
                {
                        $this->getRequest()->setError('user_data_delivery{full_name}', $i18n->__('Brak imienia i nazwiska.'));
                        $error_exists = true;
                }
                
                if (!$user_data_delivery['address'])
                {
                        $this->getRequest()->setError('user_data_delivery{address}', $i18n->__('Brak adresu.'));
                        $error_exists = true;
                }
                
                if (!$user_data_delivery['code'])
                {
                        $this->getRequest()->setError('user_data_delivery{code}', $i18n->__('Brak kodu.'));
                        $error_exists = true;
                }
                
                if (!$user_data_delivery['town'])
                {
                        $this->getRequest()->setError('user_data_delivery{town}', $i18n->__('Brak miasta.'));
                        $error_exists = true;
                }
                
                if (!$user_data_delivery['phone']  && $user_config->get('validate_phone')==1)
                {
                        $this->getRequest()->setError('user_data_delivery{phone}', $i18n->__('Brak telefonu.'));
                        $error_exists = true;
                }

                if($user_data_delivery['country'] != stDeliveryFrontend::getInstance($this->getUser()->getBasket())->getDefaultDeliveryCountry()->getId())
                {
                    $this->getRequest()->setError('user_data_delivery{country}', $i18n->__('Wybrany kraj nie może się różnić od kraju dostawy'));
                    $error_exists = true;
                } 

                if ($this->getUser()->hasVatEu() && $invoice_config->get('check_vat_eu_delivery_country', true))
                {
                    $deliveryCountry = CountriesPeer::retrieveById($user_data_delivery['country']);
                    list($cc) = stTaxVies::parseVatNumber($user_data_billing['vat_number']);

                    $ccEuFix = array('EL' => 'GR', 'CHE' => 'CH');

                    if (isset($ccEuFix[$cc])) 
                    {
                        $cc = $ccEuFix[$cc];
                    }
                    
                    if ($deliveryCountry->getIsoA2() != $cc)
                    {
                        $this->getRequest()->setError('user_data_delivery{country}', $i18n->__('Wybrany kraj nie jest zgodny z podanym numerem VAT UE'));
                        $this->getUser()->setValidVatEu(false);
                        $error_exists = true;                         
                    }
                    else
                    {
                        $this->getUser()->setValidVatEu(true);
                    }
                }
            } 
            elseif (!$delivery->isType('ppo') && !$delivery->isType('inpostp') && $user_data_billing['country'] != stDeliveryFrontend::getInstance($this->getUser()->getBasket())->getDefaultDeliveryCountry()->getId())
            {           
                $this->getRequest()->setError('user_data_billing{country}', $i18n->__('Wybrany kraj nie może się różnić od kraju dostawy'));
                $error_exists = true;
            }            
            
            if(!stTheme::is_responsive()){
                
                if(!$this->getUser()->isAuthenticated()){
                    
                    if($user_data_billing['privacy']==1)
                    {
                        $user_data_billing['terms'] = 1; 
                    }else{
                        $this->getRequest()->setError('error_privacy', 1);
                        $error_exists = true;
                    }
                    
                }

            }

            if($user_data_billing['terms']!=1 && !$this->getUser()->isAuthenticated())
            {
                $this->getRequest()->setError('error_terms', 1);
                $error_exists = true;
            }
            else 
            {
                if(!$this->getUser()->isAuthenticated())
                {
                    $validator = new stCaptchaGDValidator();
        
                    $validator->initialize($this->getContext(), array('captcha_error' => 'Wprowadzono zły numer.'));
            
                    $captcha = $this->getRequestParameter('captcha');
                    
                    if (!$validator->execute($captcha, $error) && $this->getUser()->getAttribute('captcha_off')!=1)
                    {
                        $this->getRequest()->setError('captcha', $error);
                        $error_exists = true;
                    }else{
                        $this->getUser()->setAttribute('captcha_off', true);
                    }   
                }           
            }

      
            if ($delivery->getDefaultPayment()->getPaymentType()->getModuleName() == 'stEservice') {
                if (!$user_data_billing['full_name']) {
                    $this->getRequest()->setError('user_data_billing{full_name}', $i18n->__('Brak imienia i nazwiska.'));
                    $error_exists = true;
                }
            }
        }
        else
        {
            $error_exists = true;
        }   

        foreach (stGiftCardPlugin::get() as $giftCard)
        {
            if (!stGiftCardPlugin::hasValidBasketProducts($giftCard, $invalidItemIds))
            {
                foreach ($invalidItemIds as $id)
                {
                    $this->getRequest()->setError('basket{products}{' . $id . '}', $this->getContext()->getI18N()->__('Usuń produkt z koszyka, aby zrealizować zamówienie z aktualnym bonem zakupowym', null, 'stGiftCardFrontend'));
                }

                $error_exists = true;
            }
            elseif (!$giftCard->isValidOrderAmount($this->getUser()->getBasket()->getTotalAmount(true, true)))
            {
                $error_exists = true;
            }
        }

        return !$error_exists;
    }

    public function validateCheckBasketUser()
    {
        $error_exists = false;

        $i18n = $this->getContext()->getI18N();
        
        $billing = $this->getRequestParameter('user_data_billing', array());   
        
        $delivery = $this->getRequestParameter('user_data_delivery', array());   
                               
            if ($billing['company'] || $billing['vatNumber'])
            {
                if (!$billing['company']) 
                {
                    $this->getRequest()->setError('user_data_billing{company}', $i18n->__('Brak firmy.'));
                    $error_exists = true;
                }
                
                if (!$billing['vatNumber'])
                {
                    $this->getRequest()->setError('user_data_billing{vatNumber}', $i18n->__('Brak nipu.'));
                    $error_exists = true;
                }
            }
            
            if (!$billing['company'] && !$billing['vatNumber'] && !$billing['full_name'])
            {
                $this->getRequest()->setError('user_data_billing{message}', $i18n->__('Musisz podać imię i nazwisko lub dane firmowe.'));
                $this->getRequest()->setError('user_data_billing{full_name}','');
                $this->getRequest()->setError('user_data_billing{company}','');
                $this->getRequest()->setError('user_data_billing{vatNumber}','');
                $error_exists = true;
            }
            
                           
                       
            if (!$delivery['company'] && !$delivery['full_name'])
            {
                $this->getRequest()->setError('user_data_delivery{message}', $i18n->__('Musisz podać imię i nazwisko lub nazwę firmy.'));
                $this->getRequest()->setError('user_data_delivery{full_name}','');
                $this->getRequest()->setError('user_data_delivery{company}','');
                $error_exists = true;
            }

        return !$error_exists;
    }
    
    public function validateSaveProfile()
    {
        
        $error_exists = false;

        $i18n = $this->getContext()->getI18N();

        $user_data = $this->getRequestParameter('user_data', array());
        
        $user_config = stConfig::getInstance(sfContext::getInstance(), 'stUser');
        
        if($user_data['isBilling']==1)
        {
                        
          if($user_data['customer_type']==2)
          {
             if (!$user_data['company'])
             {
                 $this->getRequest()->setError('user_data{company}', $i18n->__('Brak firmy.'));
                 $error_exists = true;
             }

             if (!$user_data['vat_number'])
             {
                 $this->getRequest()->setError('user_data{vat_number}', $i18n->__('Brak nipu.'));
                 $error_exists = true;
             }
          }
          
          if($user_data['customer_type']==1)
          {
             if (!$user_data['full_name'])
             {
                 $this->getRequest()->setError('user_data{full_name}', $i18n->__('Brak imienia i nazwiska.'));
                 $error_exists = true;
             }
          }
         
          
        }else{
          if($user_data['customer_type']==2)
          {
             if (!$user_data['company'])
             {
                 $this->getRequest()->setError('user_data{company}', $i18n->__('Brak firmy.'));
                 $error_exists = true;
             }
          }
          
          if($user_data['customer_type']==1)
          {
             if (!$user_data['full_name'])
             {
                 $this->getRequest()->setError('user_data{full_name}', $i18n->__('Brak imienia i nazwiska.'));
                 $error_exists = true;
             }
          }
       }
        
        if (!$user_data['phone'] && $user_config->get('validate_phone')==1)
          {
                 $this->getRequest()->setError('user_data{phone}', $i18n->__('Brak telefonu.'));
                 $error_exists = true;
          }
               
                               
        return !$error_exists;
    }


    /**
     * Usuwanie profilu
     */
    public function executeAddBasketUser()
    {
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
                    
            $this->forward('stOrder', 'confirm');
        }
    }

    /**
     * Usuwanie profilu
     */
    public function executeCheckBasketUser()
    {
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $this->forward('stOrder', 'confirm');
        }
    }



    /**
     * Uchwyt do walidatora tworzenia konta.
     *
     * @return   string
     */
    public function handleErrorAddBasketUser()
    {
        $this->updateBasketUserData();
                
        return $this->forward('stBasket', 'index');
    }

    /**
     * Uchwyt do walidatora tworzenia konta.
     *
     * @return   string
     */
    public function handleErrorCheckBasketUser()
    {
        $this->smarty = new stSmarty($this->getModuleName());

        return $this->forward('stBasket', 'index');
    }

    /**
     * Uchwyt do walidatora tworzenia konta.
     *
     * @return   string
     */
    public function handleErrorSaveProfile()
    {
        $this->smarty = new stSmarty($this->getModuleName());

        return $this->forward('stUserData', 'editProfile');
    }


    public function isMyUserData($userDataId)
    {
        $c = new Criteria();
        $c->add(UserDataPeer::ID, $userDataId);
        $c->add(UserDataPeer::SF_GUARD_USER_ID , $this->getUser()->getAttribute('user_id', null, 'sfGuardSecurityUser'));
        $userData = UserDataPeer::doSelectOne($c);


        if (!$userData)
        {
            $this->forward404();
        }

    }
    
   public function executeAjaxProfileChange()
   {
      $id = $this->getRequestParameter('id');
      
      $type = $this->getRequestParameter('type');
      
      if($type=="billing")
      {
        stUser::setDefaultUserData($id, 1, $this->getUser()->getGuardUser()->getId());
        $this->responseUpdateElement('user_'.$type.'_form_content', array('module' => 'stUserData', 'component' => 'orderFormBilling', 'params' => array('profile_id' => $id, 'type' => $type)));   
      }
      
      if($type=="user_edit_profile_billing")
      {
        
        $this->responseUpdateElement('user_edit_profile_content', array('module' => 'stUserData', 'component' => 'ajaxEditProfile', 'params' => array('profile_id' => $id, 'type' => $type)));   
      }
      
      
      if($type=="delivery")
      {
        stUser::setDefaultUserData($id, 0, $this->getUser()->getGuardUser()->getId());
        $this->responseUpdateElement('user_'.$type.'_form_content', array('module' => 'stUserData', 'component' => 'orderFormDelivery', 'params' => array('profile_id' => $id, 'type' => $type)));  
      }
      
      if($type=="user_edit_profile_delivery")
      {
        $this->responseUpdateElement('user_edit_profile_content', array('module' => 'stUserData', 'component' => 'ajaxEditProfile', 'params' => array('profile_id' => $id, 'type' => $type)));  
      }   
      
      return $this->renderResponse();
   }

}
