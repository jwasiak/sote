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
 */

/**
 * Akcje dla komponentu profili użytkownika
 *
 * @author Bartosz Alejski <bartosz.alejski@sote.pl>
 *
 * @package     stUser
 * @subpackage  actions
 */
class stUserDataComponents extends sfComponents
{

   public function executeProfileList()
   {
    
      if (!$this->getUser()->isAuthenticated())
      {
         return sfView::NONE;
      }

      $c = new Criteria();

      $c->add(UserDataPeer::FULL_NAME, null, Criteria::ISNOTNULL);

      if (!isset($this->type))
      {
         $this->type = 'billing';
      }
      
      if ($this->type == 'delivery'|| $this->type == 'user_edit_profile_delivery')
      {
         $c->add(UserDataPeer::IS_BILLING, false);
      }
      
      if ($this->type == 'billing'  || $this->type == 'user_edit_profile_billing')
      {
         $c->add(UserDataPeer::IS_BILLING, true);
      }

      if (isset($this->country_id))
      {
         $c->add(UserDataPeer::COUNTRIES_ID, $this->country_id);
      }

      $c->add(UserDataPeer::SF_GUARD_USER_ID, $this->getUser()->getGuardUser()->getId());

      if (UserDataPeer::doCount($c) < 2)
      {
         return sfView::NONE;
      }

      $profiles = UserDataPeer::doSelect($c);

      $items = array();

      foreach ($profiles as $profile)
      {
         $items[$profile->getId()] = array('id' => $profile->getId(), 'label' => $profile->getProfileName());

         if (!isset($this->selected) && $profile->getIsDefault())
         {
            $this->selected = $profile->getId();
         }
      }

      if (!isset($this->selected) && $profiles)
      {
         $this->selected = $profiles[0];
      }

      unset($profiles);

      $this->smarty = new stSmarty('stUserData');

      $this->smarty->assign('profiles', $items);

      $this->smarty->assign('selected', $this->selected);
      
      $this->smarty->assign('type', $this->type);
   }

   /**
    * @deprecated use stUserDataComponents::executeProfileList instead
    */
   public function executeBasketUserDataProfile()
   {
      $this->smarty = new stSmarty('stUserData');

      $this->userDataType = $this->getUserDataTypeNumericValue($this->type);

      $delivery = stDeliveryFrontend::getInstance(stBasket::getInstance($this->getUser()));

      $c = new Criteria();

      if (!$this->userDataType)
      {
         if ($delivery->getDefaultDeliveryCountry())
         {
            $c->add(UserDataPeer::COUNTRIES_ID, $delivery->getDefaultDeliveryCountry()->getId());
         }
         if ($this->getUser()->getUserDataDefaultDelivery())
         {
            $this->defaultUserData = $this->getUser()->getUserDataDefaultDelivery()->getId();
         }
      }
      else
      {
         if ($this->getUser()->getUserDataDefaultBilling())
         {
            $this->defaultUserData = $this->getUser()->getUserDataDefaultBilling()->getId();
         }
      }

      $c->add(UserDataPeer::SF_GUARD_USER_ID, $this->getUser()->getAttribute('user_id', null, 'sfGuardSecurityUser'));

      $c->add(UserDataPeer::IS_BILLING, $this->userDataType);

      $c->add(UserDataPeer::FULL_NAME, null, Criteria::ISNOTNULL);



      $user_data = UserDataPeer::doSelect($c);

      $select_options = array();

      $has_default = false;

      foreach ($user_data as $ud)
      {
         $select_options[$ud->getId()] = $ud->getProfileName();

         if ($ud->getId() == $this->defaultUserProfile)
         {
            $has_default = true;
         }
      }

      if (!$has_default)
      {
         $select_options = array('' => '---') + $select_options;
      }



      $this->select_options = $select_options;
   }

   /**
    */
   public function getUserDataTypeNumericValue($userDataType)
   {
      if ($userDataType == "billing")
      {
         return 1;
      }
      else
      {
         return 0;
      }
   }

   /**
    * Zwraca obiekt zarzadzajacy zdarzeniami
    *
    * @return   stEventDispatcher
    */
   public function getDispatcher()
   {
      return stEventDispatcher::getInstance();
   }

   /**
    * Wyświetla menu panelu
    *
    * @author Marcin Butlak <marcin.butlak@sote.pl>
    */
   public function executeUserPanelMenu()
   {
      $this->smarty = new stSmarty('stUserData');

      $this->panel_navigator = stTabNavigator::getInstance($this->getContext(), null, null, false);
      $this->panel_navigator->addTab('Moje konto', 'stUserData', 'userPanel', null, 'userPanel');
      $this->panel_navigator->addTab('Moje dane', 'stUser', 'editAccount', null, 'editAccount');
	  
      $this->panel_navigator->setTab(isset($this->action)? $this->action : $this->getActionName());
      $this->getDispatcher()->notify(new sfEvent($this, 'stUserDataComponents.postExecuteUserPanelMenu'));
   }
   
    
   public function executeResponsiveUserPanelMenu()
   {       
      $this->smarty = new stSmarty('stUserData');     
   }
   
   

   public function updateUserLoginForm($user_data, $request_parameter)
   {
      $user_request = $this->getRequestParameter($request_parameter);

      if (isset($user_request['full_name']))
      {
         $user_data->setFullName($user_request['full_name']);
      }

      if (isset($user_request['address']))
      {
         $user_data->setAddress($user_request['address']);
      }

      if (isset($user_request['address_more']))
      {
         $user_data->setAddressMore($user_request['address_more']);
      }

      if (isset($user_request['region']))
      {
         $user_data->setRegion($user_request['region']);
      }

      if (isset($user_request['pesel']))
      {
         $user_data->setPesel($user_request['pesel']);
      }

      if (isset($user_request['code']))
      {
         $user_data->setCode($user_request['code']);
      }

      if (isset($user_request['town']))
      {
         $user_data->setTown($user_request['town']);
      }

      if (isset($user_request['country']))
      {
         $user_data->setCountriesId($user_request['country']);
      }

      if (isset($user_request['phone']))
      {
         $user_data->setPhone($user_request['phone']);
      }

      if (isset($user_request['company']))
      {
         $user_data->setCompany($user_request['company']);
      }

      if (isset($user_request['vatNumber']))
      {
         $user_data->setVatNumber($user_request['vatNumber']);
      }
   }

   /**
    * Formularz billingu w koszyku dla zalogowanego użytkownika
    */
   public function executeOrderFormBilling()
   {
      $delivery = stDeliveryFrontend::getInstance(stBasket::getInstance($this->getUser()));
      $this->smarty = new stSmarty('stUserData');

      $user_config = stConfig::getInstance(sfContext::getInstance(), 'stUser');

      $invoice_config = stConfig::getInstance($this->getContext(), 'stInvoiceBackend');

      if($invoice_config->get('invoice_on')==1)
      {
         $this->show_invoice_request = 1;

         if($invoice_config->get('auto_invoice_on')==1)
         {
            $this->auto_invoice_request = 1;
         }
      }

      $this->show_region = $user_config->get('show_region');
      $this->show_pesel = $user_config->get('show_pesel');
      $this->show_address_more = $user_config->get('show_address_more');    

      $userDataBilling = new UserData();  

      if ($this->getUser()->isAuthenticated() && !$this->getRequestParameter('user_data_billing'))
      {
         $userDataDefaultBilling = isset($this->profile_id) ? UserDataPeer::retrieveByPK($this->profile_id) : $this->getUser()->getUserDataDefaultbilling();
         $user = new stUser();

         if(!$userDataDefaultBilling)
         {
            $userDataDefaultBilling = stUser::addEmptyUserData(1,1);
         }

         $user_data_billing['company'] = $userDataDefaultBilling->getCompany();
         $user_data_billing['vat_number'] = $userDataDefaultBilling->getVatNumber();
         $user_data_billing['customer_type'] = $user_data_billing['company'] ? 2 : 1;
         $user_data_billing['full_name'] = $userDataDefaultBilling->getFullName();
         $user_data_billing['address'] = $userDataDefaultBilling->getAddress();
         $user_data_billing['address_more'] = $userDataDefaultBilling->getAddressMore();
         $user_data_billing['code'] = $userDataDefaultBilling->getCode();
         $user_data_billing['town'] = $userDataDefaultBilling->getTown();
         $user_data_billing['phone'] = $userDataDefaultBilling->getPhone();
         $userDataBilling->setCountriesId($userDataDefaultBilling->getCountriesId());
         $user_data_billing['country'] = $userDataDefaultBilling->getCountriesId();
         $user_data_billing['pesel'] = $userDataDefaultBilling->getPesel();
      }
      else
      {
         $user_data_billing = $this->getRequestParameter('user_data_billing');
         $userDataBilling->setCountriesId($user_data_billing['country']);
      }

      if ($this->getUser()->hasVatEu())
      {
         $user_data_billing['customer_type'] = 2;
      }

      $this->user_data_billing = $user_data_billing;

      $this->userDataBilling = $userDataBilling;
   }
 
   /**
    * Pobranie obejktu z danymi użytkownika
    */
   public function executeOrderFormDelivery()
   {
      $this->smarty = new stSmarty('stUserData');

      $basket = stBasket::getInstance($this->getUser());

      $this->delivery = stDeliveryFrontend::getInstance($basket);

      $user_config = stConfig::getInstance(sfContext::getInstance(), 'stUser');

      $this->show_region = $user_config->get('show_region');
      $this->show_pesel = $user_config->get('show_pesel');
      $this->show_address_more = $user_config->get('show_address_more');

      if ($this->getUser()->isAuthenticated() && !$this->getRequestParameter('user_data_delivery'))
      {
         $userDataDefaultDelivery = isset($this->profile_id) ? UserDataPeer::retrieveByPK($this->profile_id) : $this->getUser()->getUserDataDefaultDelivery();
         $user = new stUser();
         
   		if(!$userDataDefaultDelivery)
   		{
   			$userDataDefaultDelivery = stUser::addEmptyUserData(0,1);
   		}
		 
         $user_data_delivery['company'] = $userDataDefaultDelivery->getCompany();
         $user_data_delivery['customer_type'] = $user_data_delivery['company'] ? 2 : 1;
         $user_data_delivery['full_name'] = $userDataDefaultDelivery->getFullName();
         $user_data_delivery['address'] = $userDataDefaultDelivery->getAddress();
         $user_data_delivery['address_more'] = $userDataDefaultDelivery->getAddressMore();
         $user_data_delivery['region'] = $userDataDefaultDelivery->getRegion();
         $user_data_delivery['code'] = $userDataDefaultDelivery->getCode();
         $user_data_delivery['town'] = $userDataDefaultDelivery->getTown();
         $user_data_delivery['phone'] = $userDataDefaultDelivery->getPhone();
      }
      else
      {
         $user_data_delivery = $this->getRequestParameter('user_data_delivery');
      }

      $this->user_data_delivery = $user_data_delivery;

      $this->delivery_country_id = $this->delivery->getDefaultDeliveryCountry() ? $this->delivery->getDefaultDeliveryCountry()->getId() : null;
   }

   /**
    * Pobranie obejktu z danymi użytkownika
    */
   public function executeOrderForm()
   {
      $this->smarty = new stSmarty('stUserData');

      $basket = stBasket::getInstance($this->getUser());

      $this->delivery = stDeliveryFrontend::getInstance($basket);

      $this->config = stConfig::getInstance($this->getContext(), 'stSecurityBackend');

      $invoice_config = stConfig::getInstance($this->getContext(), 'stInvoiceBackend');

      if($invoice_config->get('invoice_on')==1)
      {
         $this->show_invoice_request = 1;

         if($invoice_config->get('auto_invoice_on')==1)
         {
            $this->auto_invoice_request = 1;
         }
      }
	
      $user_config = stConfig::getInstance(sfContext::getInstance(), 'stUser');

      $this->show_region = $user_config->get('show_region');
      $this->show_pesel = $user_config->get('show_pesel');
      $this->show_address_more = $user_config->get('show_address_more');

      
      $user_data_billing = $this->getRequestParameter('user_data_billing', array());   
      $user_data_delivery = $this->getRequestParameter('user_data_delivery', array());

      if (!isset($user_data_billing['customer_type']))
      {
         $user_data_billing['customer_type'] = 1;
      }
      
      if (!isset($user_data_delivery['customer_type']))
      {
         $user_data_delivery['customer_type'] = 1;
      }      

      if($user_config->get('change_default_user'))
      {
         $user_data_billing['customer_type'] = 2;
         $user_data_delivery['customer_type'] = 2;
      }

      if ($this->getUser()->hasVatEu())
      {
         $user_data_billing['customer_type'] = 2;
      }

      $this->user_data_billing = $user_data_billing;
	   $this->user_data_delivery = $user_data_delivery;

      if ($this->getRequest()->getMethod() == sfRequest::POST && $this->hasRequestParameter('submit_save'))
      {
         $this->user_basket_form_error = $this->hasRequestParameter('submit_save');
      }

      $this->delivery_country_id = $this->delivery->getDefaultDeliveryCountry() ? $this->delivery->getDefaultDeliveryCountry()->getId() : null;
   }

   /**
    * Pobranie obejktu z danymi użytkownika
    */
   public function getUserData($id)
   {
      $c = new Criteria();
      $c->add(UserDataPeer::ID, $id);
      $userData = UserDataPeer::doSelectOne($c);

      if (!$userData)
      {
         return false;
      }

      return $userData;
   }

   /**
    */
   public function executeEditProfileForm()
   {
      $this->smarty = new stSmarty('stUserData');

      $user_config = stConfig::getInstance(sfContext::getInstance(), 'stUser');
      $this->show_region = $user_config->get('show_region');
      $this->show_pesel = $user_config->get('show_pesel');
      $this->show_address_more = $user_config->get('show_address_more');

      $userDataId = $this->getRequestParameter('userDataId');
      $showEditProfileForm = $this->getRequestParameter('showEditProfileForm');
      $userDataType = $this->getRequestParameter('userDataType');
      $showMessage = $this->getRequestParameter('showMessage');

      $userData = $this->getUserData($userDataId);



      $userDataFromRequest = $this->getRequestParameter('user_data');

      //$userDataDeliveryFromRequest = $this->getRequestParameter('user_data_delivery');


      if ($userDataFromRequest)
      {

         $userData->setId($userDataFromRequest['id']);

         if (isset($userDataFromRequest['full_name']))
         {
            $userData->setFullName($userDataFromRequest['full_name']);
         }

         if (isset($userDataFromRequest['address']))
         {
            $userData->setAddress($userDataFromRequest['address']);
         }

         if (isset($userDataFromRequest['address_more']))
         {
            $userData->setAddressMore($userDataFromRequest['address_more']);
         }

         if (isset($userDataFromRequest['region']))
         {
            $userData->setRegion($userDataFromRequest['region']);
         }

         if (isset($userDataFromRequest['code']))
         {
            $userData->setCode($userDataFromRequest['code']);
         }

         if (isset($userDataFromRequest['town']))
         {
            $userData->setTown($userDataFromRequest['town']);
         }

         if (isset($userDataFromRequest['country']))
         {
            $userData->setCountriesId($userDataFromRequest['country']);
         }

         if (isset($userDataDeliveryFromRequest['country']))
         {
            $userData->setCountriesId($userDataDeliveryFromRequest['country']);
         }

         if (isset($userDataFromRequest['phone']))
         {
            $userData->setPhone($userDataFromRequest['phone']);
         }

         if (isset($userDataFromRequest['company']))
         {
            $userData->setCompany($userDataFromRequest['company']);
         }

         if (isset($userDataFromRequest['pesel']))
         {
            $userData->setPesel($userDataFromRequest['pesel']);
         }
      }
		
	  if ($this->getRequestParameter('user_data[customer_type]') == 2  || $userData->getCompany()!="")
      {
         $this->type1_checker = 0;
         $this->type2_checker = 1;
      }
      else
      {
         $this->type1_checker = 1;
         $this->type2_checker = 0;
      }		


      $this->userData = $userData;
      $this->showEditProfileForm = $showEditProfileForm;
      $this->userDataType = $userDataType;
      $this->userDataType = $userDataType;
      
      
      $this->showMessage = $showMessage;

   }

   /**
    */
   public function executeEditProfileList()
   {
      $this->smarty = new stSmarty('stUserData');

      if ($this->getUser()->isAuthenticated())
      {

         $userDataType = $this->getRequestParameter('userDataType');
         $showEditProfileForm = $this->getRequestParameter('showEditProfileForm');

         if ($userDataType == "delivery")
         {
            $is_billing = 0;
         }
         else
         {
            $is_billing = 1;
         }

         $userDataAll = stUser::getUserDataAll($this->getUser()->getAttribute('user_id', null, 'sfGuardSecurityUser'), $is_billing, null, false);

         $this->userDatas = $userDataAll;
         $this->userDataType = $userDataType;
         $this->showEditProfileForm = $showEditProfileForm;
      }
      else
      {
         stUser::processAuthentication();
      }
   }

   public function executeDeliveryCountriesSelect()
   {
      $basket = stBasket::getInstance($this->getUser());
      $delivery = stDeliveryFrontend::getInstance($basket);
      $this->delivery_countries = $delivery->getDeliveryCountries(true);

      if ($this->force_default_country_id)
      {
         $this->default_delivery_country_id = $this->force_default_country_id;
      }
      else
      {
         $this->default_delivery_country_id = $delivery->getDefaultDeliveryCountry() ? $delivery->getDefaultDeliveryCountry()->getId() : $this->user_data_delivery->getCountriesId();
      }
   }
   
      /**
    * Pobranie obejktu z danymi użytkownika
    */
   public function executeAjaxEditProfile()
   {
      $this->smarty = new stSmarty('stUserData');
      
      $delivery = stDeliveryFrontend::getInstance(stBasket::getInstance($this->getUser()));
      $user_config = stConfig::getInstance(sfContext::getInstance(), 'stUser');

      $this->show_region = $user_config->get('show_region');
      $this->show_pesel = $user_config->get('show_pesel');
      $this->show_address_more = $user_config->get('show_address_more');          
      $userDataDefault = UserDataPeer::retrieveByPK($this->profile_id);

      $user_data['company'] = $userDataDefault->getCompany();
      $user_data['vat_number'] = $userDataDefault->getVatNumber();
      $user_data['customer_type'] = $user_data['company'] ? 2 : 1;
      $user_data['full_name'] = $userDataDefault->getFullName();
      $user_data['address'] = $userDataDefault->getAddress();
      $user_data['address_more'] = $userDataDefault->getAddressMore();
      $user_data['code'] = $userDataDefault->getCode();
      $user_data['town'] = $userDataDefault->getTown();
      $user_data['phone'] = $userDataDefault->getPhone();
      
      $user_data['country'] = $userDataDefault->getCountriesId();
      $user_data['pesel'] = $userDataDefault->getPesel();
      
      if ($userDataDefault->getCompany()!="")
      {
         $this->type1_checker = 0;
         $this->type2_checker = 1;
      }
      else
      {
         $this->type1_checker = 1;
         $this->type2_checker = 0;
      } 
            
      $this->user_data = $user_data;
      $this->userData = $userDataDefault;
      
   }

}