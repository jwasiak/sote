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
 * @version     $Id: stModuleWebApi.class.php 10117 2011-01-11 11:26:42Z piotr $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stProducerWebApi
 *
 * @package     stWebApiPlugin
 * @subpackage  libs
 */
class StWebApiBackendWebApi extends autoStWebApiBackendWebApi
{
    /**
     * Dodawanie danych
     *
     * @param   object      $object             obiekt z parametrami
     * @return  object      okiekt z numer id dodanych danych
     * @throws WEBAPI_ADD_ERROR WEBAPI_REQUIRE_ERROR
     * @todo dodać waliadacje danych
     */
    public function doLogin( $object )
    {
        if (isset($object->_culture)) { $this->__setCulture($object->_culture);}
        $this->TestAndValidatedoLoginFields( $object );
        $item = new WebApiSession( );
        if ( $item )
        {
            $c = new Criteria();
            $c->add(sfGuardGroupPeer::NAME, 'admin');
            $adminGroup = sfGuardGroupPeer::doSelectOne($c);
            
            $c = new Criteria();
            $c->add(sfGuardUserPeer::USERNAME,$object->username);
            $c->addJoin(sfGuardUserGroupPeer::USER_ID,sfGuardUserPeer::ID);
            $c->add(sfGuardUserGroupPeer::GROUP_ID, $adminGroup->getId());
            $user = sfGuardUserPeer::doSelectOne($c);

            if ($user && $user->checkPassword($object->password)) {
                $con = Propel::getConnection();
                // $c1 = new Criteria();
                // $c1->add(WebApiSessionPeer::SF_GUARD_USER_ID, $user->getID());

                // $c2 = new Criteria();
                // $c2->add(WebApiSessionPeer::ACTIVE, 0);

                // BasePeer::doUpdate($c1, $c2, $con);

                $webapiConfig = stConfig::getInstance(sfContext::getInstance(), 'stWebApiBackend');
                $loginHistory = $webapiConfig->get('login_history');

                if ($loginHistory == true)
                {
                    $timeLimit = $webapiConfig->get('session_time');
                    $updatedAt = date("Y-m-d H:i:s", time() - $timeLimit);

                    $c = new Criteria();
                    $c->add(WebApiSessionPeer::UPDATED_AT, $updatedAt, Criteria::LESS_THAN);
                    WebApiSessionPeer::doDelete($c);
                }

                try {
                    $item->setSfGuardUser($user);
                    $item->setHash(md5(microtime()));
                    $item->setActive(1);
                    $item->save( );
                } catch ( Exception $e ) {
                    throw new SoapFault( "2", sprintf(WEBAPI_ADD_ERROR,$e->getMessage()));
                }

                // Zwracanie danych
                $object = new StdClass( );
                $this->getFieldsFordoLogin( $object, $item );
                return $object;
            }
            throw new SoapFault("3", "Złe hasło lub nazwa użtykownika");
        } else {
            throw new SoapFault( "1", sprintf(WEBAPI_ADD_ERROR, "") );
        }
    }

    /**
     * Pobieranie danych
     *
     * @param   object      $object             obiekt z parametrami
     * @return  object      okiekt z danymi
     * @throws WEBAPI_INCORRECT_ID WEBAPI_REQUIRE_ERROR
     */
    public function noop( $object )
    {
        if (isset($object->_culture)) { $this->__setCulture($object->_culture);}
        stWebApi::getLogin($object->hash, 'webapi_read');
        $this->TestAndValidatenoopFields( $object );

        $webapiConfig = stConfig::getInstance(sfContext::getInstance(), 'stWebApiBackend');
        $timeLimit = $webapiConfig->get('session_time');

        $object = new StdClass( );
        $object->time = date(DATE_ATOM, time()+$timeLimit);
        $object->duration = $timeLimit;
        return $object;
    }

    /**
     * Funkcja zwraca parametr echo
     *
     * @param stdClass $object
     * @return stdClass
     */
    public function test($object)
    {
        if (isset($object->_culture)) { $this->__setCulture($object->_culture);}
        if(!isset($object->echo))
        {
            throw new SoapFault('1', 'Należy podać wymagany parametr echo.'); 
        }

        return $object;
    }
    
    
    public function getVersion($object) {
        $packageInfo = sfYaml::load(sfConfig::get('sf_root_dir').'/packages/stWebApiPlugin/package.yml');
        $object = new StdClass();
        $object->version = $packageInfo['package']['version'];
        return $object;
    }

    public function clearCache($object) {
        stWebApi::getLogin($object->_session_hash, 'webapi_write');

        stFunctionCache::clearAll();
        stPartialCache::clearAll();
        stFastCacheManager::clearCache();

        $object->status = 1;
  
        return $object;
    }
}
