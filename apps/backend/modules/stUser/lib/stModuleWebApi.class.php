<?php
/**
 * SOTESHOP/stWebApiPlugin
 *
 * Ten plik należy do aplikacji stWebApiPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stWebApiPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stModuleWebApi.class.php 14410 2011-08-02 08:51:11Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

define( "WEBAPI_CATEGORY_ERROR", "Kategoria o id %d nie istenieje.");

/**
 * Klasa stProductWebApi
 *
 * @package     stWebApiPlugin
 * @subpackage  libs
 */
class StUserWebApi extends autoStUserWebApi
{

    public function AddUser( $object )
    {
        if (isset($object->_culture)) { $this->__setCulture($object->_culture);}
        stWebApi::getLogin($object->_session_hash, 'webapi_write');
        $this->TestAndValidateAddUserFields( $object );

        $c = new Criteria();
        $c->add(sfGuardUserPeer::USERNAME, $object->username);
        
        if (sfGuardUserPeer::doCount($c) > 0)
        {
            throw new SoapFault("2", sprintf($this->__(WEBAPI_VALIDATE_UNIQUE_ERROR), 'username'));
        }

        $item = new sfGuardUser( );
        if ( $item )
        {

            $this->setFieldsForAddUser( $object, $item );
            //Zapisywanie danych do bazy
            try {
                $item->save( );
            } catch ( Exception $e ) {
                throw new SoapFault( "2", sprintf($this->__(WEBAPI_ADD_ERROR),$e->getMessage()));
            }
            
            self::setAsUser($item);

            // Zwracanie danych
            $object = new StdClass( );
            $this->getFieldsForAddUser( $object, $item );
            return $object;

        } else {
            throw new SoapFault( "1", sprintf($this->__(WEBAPI_ADD_ERROR), "") );
        }
    }

    public function DeleteUser( $object )
    {
        if (isset($object->_culture)) { $this->__setCulture($object->_culture);}
        stWebApi::getLogin($object->_session_hash, 'webapi_write');
        $this->TestAndValidateDeleteUserFields( $object );

        $item = sfGuardUserPeer::retrieveByPk( $object->id );

        if ($item->getIsSuperAdmin() || $item->hasGroup('admin'))
        {
            throw new SoapFault( "1", 'You can\'t delete an administrator account');
        }

        if ( $item )
        {
            // Zwracanie danych
          $obj = new StdClass( );
          $item->delete( );
          $obj->_delete = 1;
          return $obj;
        } else {
            throw new SoapFault( "1", $this->__(WEBAPI_INCORRECT_ID) );
        }
    }

    public static function setAsUser($item)
    {
        $item->addGroupByName('user');
    }

    public function GetUserProfileList( $object )
    {
        if (isset($object->_culture)) { $this->__setCulture($object->_culture);}
        stWebApi::getLogin($object->_session_hash, 'webapi_read');
        $this->TestAndValidateGetUserProfileListFields( $object );

        $c = new Criteria( );

        if (isset($object->_modified_from) && isset($object->_modified_to)) {
            $criterion = $c->getNewCriterion(UserDataPeer::UPDATED_AT, $object->_modified_from, Criteria::GREATER_EQUAL);
            $criterion->addAnd($c->getNewCriterion(UserDataPeer::UPDATED_AT, $object->_modified_to, Criteria::LESS_EQUAL));
            $c->add($criterion);
        } else {
            if (isset($object->_modified_from)) {
                $criterion = $c->getNewCriterion(UserDataPeer::UPDATED_AT, $object->_modified_from, Criteria::GREATER_EQUAL);
                $c->add($criterion);
            }

            if (isset($object->_modified_to)) {
                $criterion = $c->getNewCriterion(UserDataPeer::UPDATED_AT, $object->_modified_to, Criteria::LESS_EQUAL);
                $c->add($criterion);
            }
        }

        if (!isset($object->_limit)) $object->_limit = 20;

        // ustawiamy kryteria wyboru
        $c->setLimit( $object->_limit );
        $c->setOffset( $object->_offset );

        if (isset($object->sf_guard_user_id)) {
            $c->add(UserDataPeer::SF_GUARD_USER_ID,$object->sf_guard_user_id);
        }

        $items = UserDataPeer::doSelect( $c );

        if ( $items )
        {
            // Zwracanie wyniku, dla wszystkich pol z tablicy 'out'
            $items_array = array();
            foreach ( $items as $item )
            {
                $object = new StdClass( );
                $this->getFieldsForGetUserProfileList( $object, $item );
                $items_array[] = $object;
            }
            return $items_array;
        } else {
            return array( );
        }
    }

    /**
     * Licznie ilości rekordów
     *
     * @return  object      okiekt z liczba rekordów 
     * @throws WEBAPI_COUNT_ERROR
     */
    public function CountUserProfile( $object )
    {
        if (isset($object->_culture)) { $this->__setCulture($object->_culture);}
        stWebApi::getLogin($object->_session_hash, 'webapi_read');
        $c = new Criteria();

        if (isset($object->sf_guard_user_id)) {
            $c->add(UserDataPeer::SF_GUARD_USER_ID,$object->sf_guard_user_id);
        }


        try{
            //Zwracanie danych
            $obj = new StdClass( );
            $obj->_count = UserDataPeer::doCount($c);
            return $obj;
        } catch ( Exception $e ) {
            throw new SoapFault( "1", $this->__(WEBAPI_COUNT_ERROR) );
        }
    }

    /** 
     * Pobieranie danych
     *
     * @param   object      $object             obiekt z parametrami
     * @return  object      okiekt z danymi
     * @throws WEBAPI_INCORRECT_ID WEBAPI_REQUIRE_ERROR
     */
    public function GetUser( $object )
    {
        if (isset($object->_culture)) { $this->__setCulture($object->_culture);}
        stWebApi::getLogin($object->_session_hash, 'webapi_read');
        $this->TestAndValidateGetUserFields( $object );

        $item = sfGuardUserPeer::retrieveByPk( $object->id );
        
        if ($item  && !$item->getIsSuperAdmin() && !$item->hasGroup('admin'))
        {
            $object = new StdClass( );
            $this->getFieldsForGetUser( $object, $item );        
            return $object;
        } else {
            throw new SoapFault( "1", $this->__(WEBAPI_INCORRECT_ID) );
        }
    }

    public function GetUserList( $object )
    {
        if (isset($object->_culture)) { $this->__setCulture($object->_culture);}
        stWebApi::getLogin($object->_session_hash, 'webapi_read');
        $this->TestAndValidateGetUserListFields( $object );
        $c = new Criteria( );

        if (isset($object->_modified_from) && isset($object->_modified_to)) {
            $criterion = $c->getNewCriterion(sfGuardUserPeer::CREATED_AT, $object->_modified_from, Criteria::GREATER_EQUAL);
            $criterion->addAnd($c->getNewCriterion(sfGuardUserPeer::CREATED_AT, $object->_modified_to, Criteria::LESS_EQUAL));
            $c->add($criterion);
        } else {
            if (isset($object->_modified_from)) {
                $criterion = $c->getNewCriterion(sfGuardUserPeer::CREATED_AT, $object->_modified_from, Criteria::GREATER_EQUAL);
                $c->add($criterion);
            }

            if (isset($object->_modified_to)) {
                $criterion = $c->getNewCriterion(sfGuardUserPeer::CREATED_AT, $object->_modified_to, Criteria::LESS_EQUAL);
                $c->add($criterion);
            }
        }

        if (!isset($object->_limit)) $object->_limit = 20;

        // ustawiamy kryteria wyboru
        $c->setLimit( $object->_limit );
        $c->setOffset( $object->_offset );

        $this->addUserGroupCriteria($c);

        $items = sfGuardUserPeer::doSelect( $c );

        if ( $items )
        {
            // Zwracanie wyniku, dla wszystkich pol z tablicy 'out'
            $items_array = array();
            foreach ( $items as $item )
            {
                $object = new StdClass( );
                $this->getFieldsForGetUserList( $object, $item );
                $items_array[] = $object;
            }
            return $items_array;
        } else {
            return array( );
        }
    }


    /**
     * Licznie ilości rekordów
     *
     * @return  object      okiekt z liczba rekordów 
     * @throws WEBAPI_COUNT_ERROR
     */
    public function CountUser( $object )
    {
        if (isset($object->_culture)) { $this->__setCulture($object->_culture);}
        stWebApi::getLogin($object->_session_hash, 'webapi_read');
        try{
            $c = new Criteria( );

            if (isset($object->_modified_from) && isset($object->_modified_to)) {
                $criterion = $c->getNewCriterion(sfGuardUserPeer::CREATED_AT, $object->_modified_from, Criteria::GREATER_EQUAL);
                $criterion->addAnd($c->getNewCriterion(sfGuardUserPeer::CREATED_AT, $object->_modified_to, Criteria::LESS_EQUAL));
                $c->add($criterion);
            } else {
                if (isset($object->_modified_from)) {
                    $criterion = $c->getNewCriterion(sfGuardUserPeer::CREATED_AT, $object->_modified_from, Criteria::GREATER_EQUAL);
                    $c->add($criterion);
                }

                if (isset($object->_modified_to)) {
                    $criterion = $c->getNewCriterion(sfGuardUserPeer::CREATED_AT, $object->_modified_to, Criteria::LESS_EQUAL);
                    $c->add($criterion);
                }
            }

            $this->addUserGroupCriteria($c);

            //Zwracanie danych
            $obj = new StdClass( );
            $obj->_count = sfGuardUserPeer::doCount($c);
            return $obj;
        } catch ( Exception $e ) {
            throw new SoapFault( "1", sprintf($this->__(WEBAPI_COUNT_ERROR),$e->getMessage()) );
        }
    }


    public function getFieldsForGetUserProfileList( $object, $item ) {

        parent::getFieldsForGetUserProfileList($object, $item);

        if (method_exists($item, "getStreet")) {
            $street = $item->getStreet();
            if (empty($street)) {
                $aparser = new stAddressParser($item->getAddress());
                $result = $aparser->getAddress();
                $street = $result['s1'];
            }
            $object->street = stWebApi::formatData($street, "string");
        }

        if (method_exists($item, "getHouse")) {
            $house = $item->getHouse();
            if (empty($house)) {
                $aparser = new stAddressParser($item->getAddress());
                $result = $aparser->getAddress();
                $house = $result['n1'];
            }
            $object->house = stWebApi::formatData($house, "string");
        }

        if (method_exists($item, "getFlat")) {
            $flat = $item->getFlat();
            if (empty($flat)) {
                $aparser = new stAddressParser($item->getAddress());
                $result = $aparser->getAddress();
                $flat = $result['n2'];
            }
            $object->flat = stWebApi::formatData($flat, "string");
        }
    }

    public function getFieldsForGetUserProfile( $object, $item ) {

        parent::getFieldsForGetUserProfile($object, $item);

        if (method_exists($item, "getStreet")) {
            $street = $item->getStreet();
            if (empty($street)) {
                $aparser = new stAddressParser($item->getAddress());
                $result = $aparser->getAddress();
                $street = $result['s1'];
            }
            $object->street = stWebApi::formatData($street, "string");
        }

        if (method_exists($item, "getHouse")) {
            $house = $item->getHouse();
            if (empty($house)) {
                $aparser = new stAddressParser($item->getAddress());
                $result = $aparser->getAddress();
                $house = $result['n1'];
            }
            $object->house = stWebApi::formatData($house, "string");
        }

        if (method_exists($item, "getFlat")) {
            $flat = $item->getFlat();
            if (empty($flat)) {
                $aparser = new stAddressParser($item->getAddress());
                $result = $aparser->getAddress();
                $flat = $result['n2'];
            }
            $object->flat = stWebApi::formatData($flat, "string");
        }
    }

    public static function getDiscount(sfGuardUser $user)
    {
        $discounts = $user->getDiscountUsers();

        return $discounts ? $discounts[0]->getDiscount() : 0;
    }

    public static function setDiscount(sfGuardUser $user, $value)
    {
        $discounts = $user->getDiscountUsers();

        if (!$discounts)
        {
            $discount = new DiscountUser();
            $user->addDiscountUser($discount);
        }
        else
        {
            $discount = $discounts[0];
        }

        $discount->setDiscount($value);
    }

    public static function getWholesale($item) {
        switch ($item->getWholesale()) {
            case 'a':
                return 1;
            case 'b':
                return 2;
            case 'c':
                return 3;
            default:
                return 0;
        }
    }

    public static function setWholesale($item, $v) {
        switch ($v) {
            case '1':
                $v = 'a';
                break;
            case '2':
                $v = 'b';
                break;
            case '3':
                $v = 'c';
                break;
            default:
                $v = 0;
                break;
        }
        $item->setWholesale($v);
    }

    protected function addUserGroupCriteria(Criteria $c)
    {
        $group = sfGuardGroupPeer::retrieveByName('user');

        if (!$group)
        {
            throw new SoapFault( "1", sprintf($this->__(WEBAPI_COUNT_ERROR),'User group does not exist'));
        }

        $c->addJoin(sfGuardUserPeer::ID, sfGuardUserGroupPeer::USER_ID);
        $c->add(sfGuardUserGroupPeer::GROUP_ID, $group->getId());    
    }
}