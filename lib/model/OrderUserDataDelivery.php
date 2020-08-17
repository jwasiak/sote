<?php

/**
 * SOTESHOP/stOrder
 *
 * Ten plik należy do aplikacji stOrder opartej na licencji (Professional License SOTE).
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stOrder
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: OrderUserDataDelivery.php 12453 2011-04-22 08:34:28Z bartek $
 */

/**
 * SOTESHOP/stOrder
 * Ten plik należy do aplikacji stOrder opartej na licencji (Professional License SOTE).
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stOrder
 * @subpackage  libs
 */
class OrderUserDataDelivery extends BaseOrderUserDataDelivery
{
   public function __toString()
   {
      $fullname = $this->getFullName();

      if (empty($fullname)) {
         if ($this->getName() != "" || $this->getSurname() != "") {
            $fullname = $this->getName() . ' ' . $this->getSurname();
         }
      }

      return $fullname;
   }

   public function getHasValidVatEu()
   {
      return false;
   }

   public function getCountry()
   {
      if ($this->getCountriesId()) {
         return $this->getCountries();
      }
      $value = parent::getCountry();

      $c = new Criteria();

      $c->add(CountriesI18nPeer::NAME, $value);

      $c->addJoin(CountriesI18nPeer::ID, CountriesPeer::ID);

      $country = CountriesPeer::doSelectOne($c);

      return $country ? $country : $value;
   }

   public function getFullName()
   {
      $fullname = parent::getFullName();

      if (empty($fullname)) {
         if ($this->getName() != "" || $this->getSurname() != "") {
            $fullname = $this->getName() . ' ' . $this->getSurname();
         }
      }

      return $fullname;
   }

   public function getAddress()
   {
      $address = parent::getAddress();

      if (empty($address)) {
         if ($this->getStreet() != "" || $this->getHouse() != "" || $this->getFlat() != "") {
            $old_address = $this->getStreet() . ' ' . $this->getHouse();

            if ($this->getFlat() != "") {

               $old_address .= '/' . $this->getFlat();
            }

            $address = $old_address;
         }
      }

      return $address;
   }

   public function getName()
   {
      $name = parent::getName();
      if (empty($name)) {
         $fullname_array = explode(' ', parent::getFullName());
         $name = $fullname_array[0];
      }

      return $name;
   }

   public function getSurname()
   {
      $surname = parent::getSurname();
      if (empty($surname)) {
         $fullname_array = explode(' ', parent::getFullName());

         foreach ($fullname_array as $key => $array) {
            if ($key != 0) {
               $surname .= $array;
               $surname .= " ";
            }
         }
         $surname = substr($surname, 0, strlen($surname) - 1);
      }

      return $surname;
   }

   public function getStreet()
   {
      $street = parent::getStreet();
      if ($this->address) {
         $aparser = new stAddressParser($this->address);
         $result  = $aparser->getAddress();
         $street = $result['s1'];
      }

      return $street;
   }

   public function getHouse()
   {
      $house = parent::getHouse();
      if ($this->address) {
         $aparser = new stAddressParser($this->address);
         $result  = $aparser->getAddress();
         $house = $result['n1'];
      }

      return $house;
   }

   public function getFlat()
   {
      $flat = parent::getFlat();
      if ($this->address) {
         $aparser = new stAddressParser($this->address);
         $result  = $aparser->getAddress();
         $flat = isset($result['n2']) ? $result['n2'] : '';
      }

      return $flat;
   }

   public function hydrate(ResultSet $rs, $startcol = 1)
   {
      $ret = parent::hydrate($rs, $startcol);

      $config = stConfig::getInstance(null, 'stRegister');

      //jeśli jest klucz to koduj / dekoduj
      if ($config->get('shop_hash') && $config->get('shop_hash') != "" && Crypt::is_mcrypt()) {

         if ($this->getCrypt()) {
            $crypt = new Crypt();

            $this->address = $crypt->Decrypt($this->address);

            $this->address_more = $crypt->Decrypt($this->address_more);

            $this->region = $crypt->Decrypt($this->region);

            $this->street = $crypt->Decrypt($this->street);

            $this->house = $crypt->Decrypt($this->house);

            $this->flat = $crypt->Decrypt($this->flat);

            $this->code = $crypt->Decrypt($this->code);

            $this->town = $crypt->Decrypt($this->town);

            $this->phone = $crypt->Decrypt($this->phone);
         }
      }

      return $ret;
   }

   public function save($con = null, $forced = false)
   {
      $config = stConfig::getInstance(null, 'stRegister');

      if ($this->getCountriesId() && $this->isColumnModified(OrderUserDataDeliveryPeer::COUNTRIES_ID)) {
         $this->setCountry($this->getCountries());
      }

      //jeśli jest klucz to koduj / dekoduj
      if (!$config->get('shop_hash') || !Crypt::is_mcrypt()) {
         parent::save($con);
      } else {

         if ($this->getCrypt() == 0) {
            //wymusza zapis wszystkich danych w przypadku znalezienia niezakryptowanego recordu

            $forced = true;
         }

         if ($this->isColumnModified(OrderUserDataDeliveryPeer::REGION) || $this->isColumnModified(OrderUserDataDeliveryPeer::ADDRESS) || $this->isColumnModified(OrderUserDataDeliveryPeer::ADDRESS_MORE) || $this->isColumnModified(OrderUserDataDeliveryPeer::STREET) || $this->isColumnModified(OrderUserDataDeliveryPeer::HOUSE) || $this->isColumnModified(OrderUserDataDeliveryPeer::FLAT) || $this->isColumnModified(OrderUserDataDeliveryPeer::CODE) || $this->isColumnModified(OrderUserDataDeliveryPeer::TOWN) || $this->isColumnModified(OrderUserDataDeliveryPeer::PHONE) || $forced = true) {
            $crypt = new Crypt();

            $address_more = $this->getAddressMore();

            if ($this->isColumnModified(OrderUserDataDeliveryPeer::ADDRESS_MORE) || $forced == true) {
               $address_more_crypt = $crypt->Encrypt($this->getAddressMore());

               $this->setAddressMore($address_more_crypt);
            }

            $region = $this->getRegion();

            if ($this->isColumnModified(OrderUserDataDeliveryPeer::REGION) || $forced == true) {
               $region_crypt = $crypt->Encrypt($this->getRegion());

               $this->setRegion($region_crypt);
            }

            //new format addresss ******************

            $address = $this->getAddress();

            if ($this->isColumnModified(OrderUserDataDeliveryPeer::ADDRESS) || $forced == true) {
               $address_crypt = $crypt->Encrypt($this->getAddress());

               $this->setAddress($address_crypt);
            }

            //old format addresss ******************


            $street = $this->getStreet();

            if ($this->isColumnModified(OrderUserDataDeliveryPeer::STREET) || $this->isColumnModified(OrderUserDataDeliveryPeer::ADDRESS) || $forced = true) {
               $street_crypt = $crypt->Encrypt($this->getStreet());

               if ($this->isColumnModified(OrderUserDataDeliveryPeer::ADDRESS)) {

                  $aparser = new stAddressParser($address);
                  $result  = $aparser->getAddress();
                  $street_crypt = $crypt->Encrypt($result['s1']);

                  $street = $street_crypt;
               }
               $this->setStreet($street_crypt);
            }

            $house = $this->getHouse();

            if ($this->isColumnModified(OrderUserDataDeliveryPeer::HOUSE) || $this->isColumnModified(OrderUserDataDeliveryPeer::ADDRESS) || $forced = true) {
               $house_crypt = $crypt->Encrypt($this->getHouse());

               if ($this->isColumnModified(OrderUserDataDeliveryPeer::ADDRESS)) {

                  $aparser = new stAddressParser($address);
                  $result  = $aparser->getAddress();
                  $house_crypt = $crypt->Encrypt($result['n1']);

                  $house = $house_crypt;
               }

               $this->setHouse($house_crypt);
            }

            $flat = $this->getFlat();

            if ($this->isColumnModified(OrderUserDataDeliveryPeer::FLAT) || $this->isColumnModified(OrderUserDataDeliveryPeer::ADDRESS) || $forced = true) {
               $flat_crypt = $crypt->Encrypt($this->getFlat());

               if ($this->isColumnModified(OrderUserDataDeliveryPeer::ADDRESS)) {

                  $aparser = new stAddressParser($address);
                  $result  = $aparser->getAddress();
                  $flat_crypt = $crypt->Encrypt(isset($result['n2']) ? $result['n2'] : '');

                  $flat = $flat_crypt;
               }

               $this->setFlat($flat_crypt);
            }

            $code = $this->getCode();

            if ($this->isColumnModified(OrderUserDataDeliveryPeer::CODE) || $forced = true) {
               $code_crypt = $crypt->Encrypt($this->getCode());

               $this->setCode($code_crypt);
            }

            $town = $this->getTown();

            if ($this->isColumnModified(OrderUserDataDeliveryPeer::TOWN) || $forced = true) {
               $town_crypt = $crypt->Encrypt($this->getTown());

               $this->setTown($town_crypt);
            }

            $phone = $this->getPhone();

            if ($this->isColumnModified(OrderUserDataDeliveryPeer::PHONE) || $forced = true) {
               $phone_crypt = $crypt->Encrypt($this->getPhone());

               $this->setPhone($phone_crypt);
            }

            $this->setCrypt(1);

            // zapis

            parent::save($con);

            $this->setAddress($address);

            $this->setAddressMore($address_more);

            $this->setRegion($region);

            $this->setStreet($street);

            $this->setHouse($house);

            $this->setFlat($flat);

            $this->setCode($code);

            $this->setTown($town);

            $this->setPhone($phone);
         } else {
            parent::save($con);
         }
      }
   }
}
