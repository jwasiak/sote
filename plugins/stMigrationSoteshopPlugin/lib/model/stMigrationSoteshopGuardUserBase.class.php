<?php

/**
 * SOTESHOP/stMigrationSoteshopPlugin 
 * 
 * Ten plik należy do aplikacji stMigrationSoteshopPlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stMigrationSoteshopPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stMigrationSoteshopGuardUserModel.class.php 704 2009-09-22 12:52:40Z marcin $
 */

/**
 * Klasa odpowiadająca za obsługę procesu migracji
 *
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 * @package     stMigrationSoteshopPlugin
 * @subpackage  libs
 */
class stMigrationSoteshopGuardUserModel extends stMigrationModel
{

   protected $billing = null;
   protected $delivery = null;

   public function postCreate($user)
   {
      $user->setIsConfirm(true);

      $user->setIsActive(true);

      $this->billing = null;

      $this->delivery = null;
   }

   public function postSave($user, $con = null)
   {
      if ($this->billing)
      {
         $this->billing->setsfGuardUser($user);

         $this->billing->save($con);
      }

      if ($this->delivery)
      {
         $this->delivery->setsfGuardUser($user);

         $this->delivery->save($con);
      }

      $user->addGroupByName('user');
   }

   public function setMWholesale($user, $hurt)
   {
      if ($hurt)
      {
         $user->setWholesale('a');
      }
   }

   public function setMCreatedAt($user, $date_add, $date_update)
   {
      if (!empty($date_add))
      {
         $user->setCreatedAt($date_add);
      }
      elseif (!empty($date_update))
      {
         $user->setCreatedAt($date_update);
      }
   }

   public function validateFillin($user, $data = array())
   {
      $c = new Criteria();

      $c->add(sfGuardUserPeer::USERNAME, $this->decrypt($data['crypt_login']));

      return!sfGuardUserPeer::doCount($c);
   }

   public function setMUsername($user, $username)
   {
      $user->setUsername($this->decrypt($username));
   }

   public function setMPassword($user, $password)
   {
      $user->setPasswordHash($password);

      $user->setSalt('');

      $user->setAlgorithm('stMigrationSoteshopHelper::algorithm');
   }

   public function setMUserData($user, $billing, $delivery = array())
   {
      if (!sfToolkit::isArrayValuesEmpty($billing))
      {
         $this->billing = new UserData();

         $this->billing->setIsBilling(true);

         $this->billing->setIsDefault(true);

         $this->billing->setFullName(stMigrationSoteshopHelper::getFullName($billing['crypt_name'], $billing['crypt_surname']));

         $this->billing->setAddress(stMigrationSoteshopHelper::getAddress($billing['crypt_street'], $billing['crypt_street_n1'],  $billing['crypt_street_n2']));

         $this->billing->setCode($this->decrypt($billing['crypt_postcode']));

         $this->billing->setTown($this->decrypt($billing['crypt_city']));

         $country = $this->retrieveCountryByName($this->decrypt($billing['crypt_country']));

         $this->billing->setCountries($country);

         $this->billing->setPhone($this->decrypt($billing['crypt_phone']));

         $this->billing->setCompany($this->decrypt($billing['crypt_firm']));

         $this->billing->setVatNumber($this->decrypt($billing['crypt_nip']));
      }

      if (sfToolkit::isArrayValuesEmpty($delivery) && $this->billing)
      {
         $this->delivery = $this->billing->copy();
         
         $this->delivery->setIsBilling(false);
      }
      elseif (!sfToolkit::isArrayValuesEmpty($delivery))
      {
         $this->delivery = new UserData();

         $this->delivery->setIsDefault(true);

         $this->delivery->setFullName(stMigrationSoteshopHelper::getFullName($delivery['crypt_cor_name'], $delivery['crypt_cor_surname']));

         $this->delivery->setAddress(stMigrationSoteshopHelper::getAddress($delivery['crypt_cor_street'], $delivery['crypt_cor_street_n1'],  $delivery['crypt_cor_street_n2']));

         $this->delivery->setCode($this->decrypt($delivery['crypt_cor_postcode']));

         $this->delivery->setTown($this->decrypt($delivery['crypt_cor_city']));

         $country = $this->retrieveCountryByName($this->decrypt($delivery['crypt_cor_country']));

         $this->delivery->setCountries($country);

         $this->delivery->setPhone($this->decrypt($delivery['crypt_cor_phone']));

         $this->delivery->setCompany($this->decrypt($delivery['crypt_cor_firm']));
      }
      
   }

   protected function retrieveCountryByName($name)
   {
      $c = new Criteria();

      $c->add(CountriesI18nPeer::NAME, $name);

      $c->add(CountriesI18nPeer::CULTURE, 'pl_PL');

      $countries = CountriesPeer::doSelectWithI18n($c);

      return isset($countries[0]) ? $countries[0] : CountriesPeer::retrieveByPk(36);
   }

   protected function decrypt($data)
   {
      return stMigrationSoteshopHelper::decrypt($data);
   }
}

?>