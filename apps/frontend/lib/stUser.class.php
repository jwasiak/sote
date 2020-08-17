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
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stUser.class.php 617 2009-04-09 13:02:31Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/** 
 * Klasa myUser
 *
 * @package     stUser
 * @subpackage  libs
 */
class stUser extends sfGuardSecurityUser
{
   protected $basket = null;

    /** 
     * Domyślne dane dostawy
     *
     * @author Marcin Butlak <marcin.butlak@sote.pl>
     * @var UserData
     */
    private $userDataDelivery = null;

    /** 
     * Domyślne dane bilingowe 
     *
     * @author Marcin Butlak <marcin.butlak@sote.pl>
     * @var UserData
     */
    private $userDataBilling = null;


    public static function addUser($username, $password = 'anonymous')
    {
        
        $username = str_replace(' ', '', $username);
        $user = new sfGuardUser();
        $user->setUsername($username);
        $user->setPassword($password);
        $user->setHashCode(md5(microtime()));
        $user->save();       
        
        stNewsletter::addNewUserToNewsletterList($user->getUsername(),$user->getId());

        $user->addGroupByName('user');

        return $user;
    }

   public static function addEmptyUserData($isBilling="0", $isDefault)
   {
       $userData = new UserData();
       $userData->setIsBilling($isBilling);
       $userData->setIsDefault($isDefault);

       $country = CountriesPeer::doSelectDefault(new Criteria());

       $userData->setCountriesId($country ? $country->getId() : null);

       return $userData;
   }

    public static function addEmptyUser()
    {
        $user = new sfGuardUser();

        return $user;
    }
    
    public static function setIsConfirm($username,$confirm=1)
    {
        $c = new Criteria();
        $c->add(sfGuardUserPeer::USERNAME, $username);
        if($user = sfGuardUserPeer::doSelectOne($c))
        {
            $user->setIsConfirm($confirm);
            $user->save();
        
            return $user;
        }
        return false;
    }

    public static function setExternalAccount($username,$external)
    {
        $c = new Criteria();
        $c->add(sfGuardUserPeer::USERNAME, $username);
        if($user = sfGuardUserPeer::doSelectOne($c))
        {
            $user->setExternalAccount($external);
            $user->save();

            return $user;
        }
        return false;
    }

    public function hasVatEu()
    {
        return (bool)$this->getAttribute('vat_eu', false, 'sfGuardSecurityUser');
    }

    public function setVatEu($v)
    {
        $this->setAttribute('vat_eu', $v, 'sfGuardSecurityUser');
    }

    public function hasValidVatEu()
    {
        return (bool)$this->getAttribute('valid_vat_eu', false, 'sfGuardSecurityUser');
    }

    public function setValidVatEu($v)
    {
        $this->setAttribute('valid_vat_eu', $v, 'sfGuardSecurityUser');        
    }

    public function setVatEx($v)
    {
        $this->setAttribute('vat_ex', $v, 'sfGuardSecurityUser');
    }

    public function hasVatEx()
    {
        return (bool)$this->getAttribute('vat_ex', false, 'sfGuardSecurityUser');
    }
    
    public function getVatEx()
    {
        return $this->getAttribute('vat_ex', null, 'sfGuardSecurityUser');  
    }

    public function loginUser($username, $password = "anonymous", $remember = false)
    {

        $user = sfGuardUserPeer::retrieveByUsername($username);

        // user exists?
        if ($user)
        {
            // password is ok?
            if ($user->checkPassword($password))
            {
                $this->signIn($user, $remember);

                return true;
            }
        }
    }

    public function getBasket()
    {
      if (null === $this->basket)
      {
         $this->basket = stBasket::getInstance($this);
      }

      return $this->basket;
    }

    public function signIn($user, $remember = false, $con = null)
    {
       parent::signIn($user, $remember, $con);

       if ($this->isAuthenticated())
       {
         $default = $this->getUserDataDefaultDelivery();

         if ($default && $default->getCountriesId())
         {
            $delivery = stDeliveryFrontend::getInstance($this->getBasket());

            $delivery->setDefaultDeliveryCountry($default->getCountriesId());
         }
       }
    }    
    
    public static function hiddenLoginUser($username, $password, $remember = false)
    {
        $user = sfGuardUserPeer::retrieveByUsername($username);
        
        if(is_object($user))
        {
            if ($user->checkPassword($password))
            {
                $sf_context = sfContext::getInstance();
                $sf_user = $sf_context->getUser();
                $sf_user->signIn($user, $remember);

                if ($user->getLanguage())
                {
                    $sf_user->setCulture($user->getLanguage());
                }

                return true;
            }
        }

        return false;
    }

    public static function loginUserOnlyUsername($username, $remember = false)
    {
        $user = sfGuardUserPeer::retrieveByUsername($username);
        
        if(is_object($user))
        {
                $context = sfContext::getInstance();
                $context->getUser()->signIn($user, $remember);
                return true;
        }
        return false;
    }
    
    
    public static function isFullAccount($username)
    {
        $user = $username instanceof sfGuardUser ? $username : sfGuardUserPeer::retrieveByUsername($username);

        return null !== $user && !$user->checkPassword("anonymous");
    }
    
    public function setGuardUser($user)
    {
        $this->setAttribute('user_id', $user->getId(), 'sfGuardSecurityUser');
    }
    
    public function unsetGuardUser()
    {
        $this->setAttribute('user_id', null, 'sfGuardSecurityUser');
    }    

    public function logoutUser()
    {
        $this->signOut();
    }

    public function signOut()
    {
        $ret = parent::signOut();

        $this->getBasket()->needRefresh(true);

        return $ret;
    }
    
    public function getGuardUser()
    {
        try {
            $user = parent::getGuardUser();
        }
        catch(sfException $e)
        {
            $user = null;
        }
        
        return $user;
    }

    public function getEmail()
    {
        return $this->getGuardUser()->getUsername();
    }

    public static function updateUserData($user_data_id = null, $user_id, $isBilling, $isDefault = 0, $data = null)
    {

        if ($user_data_id == null)
        {
            $userData = new UserData();
        } else
        {
            $c = new Criteria();
            $c->add(UserDataPeer::ID, $user_data_id);
            $userData = UserDataPeer::doSelectOne($c);
        }

        $userData->setSfGuardUserId($user_id);
        $userData->setIsBilling($isBilling);
        $userData->setIsDefault($isDefault);
        $defaultCountry = CountriesPeer::doSelectDefault(new Criteria());
        $userData->setCountriesId($defaultCountry->getId());

        if ($data != null)
        {
            $userData->setFullName($data['full_name']);
            $userData->setAddress($data['address']);

            if (isset($data['address_more']))
            {
                $userData->setAddressMore($data['address_more']);
            }

            $userData->setRegion($data['region']);
            $userData->setCode($data['code']);
            $userData->setTown($data['town']);
            $userData->setCountriesId($data['country']);
            $userData->setPhone($data['phone']);
            $userData->setCompany($data['company']);

            if($isBilling==1)
            {
                $userData->setVatNumber($data['vat_number']);
                
                if (isset($data['pesel']))
                {
                    $userData->setPesel($data['pesel']);
                }
            }
        }

        $userData->save();
        
        if($isDefault==1)
        {
            stUser::setDefaultUserData($userData->getId(), $isBilling, $user_id);
        }

        return $userData;
    }

    public static function setDefaultUserData($userDataId, $isBilling, $user_id)
    {
        $con = Propel::getConnection();
        $c1 = new Criteria();
        $c1->add(UserDataPeer::SF_GUARD_USER_ID, $user_id);

        if ($isBilling == 1)
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
        $c->add(UserDataPeer::SF_GUARD_USER_ID, $user_id);
        $c->add(UserDataPeer::ID, $userDataId);

        $userData = UserDataPeer::doSelectOne($c);
        $userData->setIsDefault(1);
        $userData->save();
    }
    
    public static function checkExsistUserData($user_id)
    {
        $c = new Criteria();
        $c->add(UserDataPeer::SF_GUARD_USER_ID, $user_id);
        $userDataAll = UserDataPeer::doSelect($c);
        
        if($userDataAll)
        {
            foreach($userDataAll as $userData)
            {
                if($userData->getStreet()=="")
                {
                    return false;       
                }       
            }
        }
        
        return true;
    }
    
    
    /** 
     *
     * @deprecated Zastąpiona przez getUserData() (usunąć w alpha-3) 
     */
    public static function getUserDataAll($user_id, $is_billing, $country_id = null, $without_default = null)
    {
        $c = new Criteria();
        
        if ($without_default)
        {
            $c->add(UserDataPeer::IS_DEFAULT, 0);
        }
        
        if ($country_id)
        {
            $c->add(UserDataPeer::COUNTRIES_ID, $country_id);
        }
        
        $c->add(UserDataPeer::SF_GUARD_USER_ID, $user_id);
        $c->add(UserDataPeer::IS_BILLING, $is_billing);
     
        return UserDataPeer::doSelect($c);
    }

    /** 
     * Zwraca dane użytkownika
     *
     * @author Marcin Butlak <marcin.butlak@sote.pl>
     * @param   bool        $default            Zwracaj dane domyślne 
     * @param   bool        $billing            Zwracaj dane bilingowe
     * @return  array       Tablica danych użytkownika (array of UserData) 
     */
    public function getUserData($default = null, $billing = null)
    {
        if (!$this->isAuthenticated())
        {
            return array();
        }

        $c = new Criteria();

        $c->add(UserDataPeer::SF_GUARD_USER_ID, $this->getGuardUser()->getId());

        if (isset($billing))
        {
            $c->add(UserDataPeer::IS_BILLING, $billing);
        }

        if (isset($default))
        {
            $c->add(UserDataPeer::IS_DEFAULT, $default);
        }

        return UserDataPeer::doSelect($c);
    }

    /** 
     * Zwraca domyślne dane bilingowe
     *
     * @author Marcin Butlak <marcin.butlak@sote.pl>
     * @return   UserData
     */
    public function getUserDataDefaultBilling()
    {
        if (is_null($this->userDataBilling))
        {
            $billing = $this->getUserData(true, true);

            if($billing)
            {
                $this->userDataBilling = $billing[0];
            }
        }

        return $this->userDataBilling;
    }
	
	

    /** 
     * Zwraca domyślne dane dostawy
     *
     * @author Marcin Butlak <marcin.butlak@sote.pl>
     * @return   UserData
     */
    public function getUserDataDefaultDelivery()
    {
        if (is_null($this->userDataDelivery))
        {
            $delivery = $this->getUserData(true, false);

            if($delivery)
            {
                $this->userDataDelivery = $delivery[0];
            }
        }

        return $this->userDataDelivery;
    }

    public static function createNewUserWithUserData($userDataBilling, $userDataDelivery, $diffrentData = 0)
    {
        $user_id = stUser::addUser($userDataBilling['email'], "anonymous");

        if($diffrentData==1)
        {
            stUser::updateUserData('',$user_id,1,1,$userDataBilling);
            stUser::updateUserData('',$user_id,0,1,$userDataDelivery);
        }
        else
        {
            stUser::updateUserData('',$user_id,1,1,$userDataBilling);
            stUser::updateUserData('',$user_id,0,1,$userDataBilling);
        }

    }

    public function thisSameUserData($userDataArray, $userDataObject)
    {
        if($userDataArray['company']!=$userDataObject->getCompany())
        {
            return false;
        }
        
        if($userDataArray['vat_number']!=$userDataObject->getVatNumber())
        {
            return false;
        }

        if($userDataArray['full_name']!=$userDataObject->getFullName())
        {
            return false;
        }

        if($userDataArray['address']!=$userDataObject->getAddress())
        {
            return false;
        }

        if($userDataArray['address_more']!=$userDataObject->getAddressMore())
        {
            return false;
        }

        if($userDataArray['region']!=$userDataObject->getRegion())
        {
            return false;
        }

        if($userDataArray['pesel']!=$userDataObject->getPesel())
        {
            return false;
        }

        if($userDataArray['code']!=$userDataObject->getCode())
        {
            return false;
        }

        if($userDataArray['town']!=$userDataObject->getTown())
        {
            return false;
        }

        if($userDataArray['country']!=$userDataObject->getCountriesId())
        {
            return false;
        }

        if($userDataArray['phone']!=$userDataObject->getPhone())
        {
            return false;
        }

        return true;
    }

	public function thisSameUserDataArray($user_data_1, $user_data_2)
    {
        if($user_data_1['company']!=$user_data_2['company'])
        {
            return false;
        }
		
		if($user_data_1['vat_number']!=$user_data_2['vat_number'])
        {
            return false;
        }

        if($user_data_1['full_name']!=$user_data_2['full_name'])
        {
            return false;
        }
		
		if($user_data_1['address']!=$user_data_2['address'])
        {
            return false;
        }
		
		if($user_data_1['address_more']!=$user_data_2['address_more'])
        {
            return false;
        }
		
		if($user_data_1['code']!=$user_data_2['code'])
        {
            return false;
        }
		
		if($user_data_1['town']!=$user_data_2['town'])
        {
            return false;
        }
		
		if($user_data_1['country']!=$user_data_2['country'])
        {
            return false;
        }
		
		if($user_data_1['phone']!=$user_data_2['phone'])
        {
            return false;
        }
		
		if($user_data_1['region']!=$user_data_2['region'])
        {
            return false;
        }
		
		if($user_data_1['pesel']!=$user_data_2['pesel'])
        {
            return false;
        }
				
        return true;
    }

    public function sessionTimeOut()
    {
        return $this->isAnonymous() && $this->hasAccount() && $this->getAttribute('user_id', null, 'sfGuardSecurityUser');
    }

    public function hasAccount()
    {
        return !$this->isAnonymousAccount();
    }

    public function isAnonymousAccount()
    {
        $guard_user = $this->getGuardUser();

        return $guard_user ? $guard_user->checkPassword("anonymous") : false;
    }

    public function isSameUser($user_id)
    {
        $guard_user = $this->getUser()->getGuardUser();

        return ($guard_user ? $guard_user->getId() : 0) == $user_id;
    }


    public static function  processAuthentication()
    {
       
        
        $context = sfContext::getInstance();
        
        $controller = $context->getController();
        
        $user = $context->getUser();
        
        

        if($user->sessionTimeOut())
        {
            $url = $controller->genUrl('stUser/loginUser', true);
        }
        else
        {
            $url = $controller->genUrl('@homepage');
        }
        
        $controller->redirect($url);
    }


    public function thisSameUserDataObject($obj1, $obj2) {

        if (is_null($obj1) || is_null($obj2)) return false;

        $attributes = array('company', 'full_name', 'address', 'address_more', 'region',
                            'pesel', 'code', 'town', 'countries_id', 'phone');

        foreach($attributes as $attribute) {
            $method = 'get'.sfInflector::camelize($attribute);
            if ($obj1->$method() != $obj2->$method()) return false;
        }
        return true;
    }
    
}
