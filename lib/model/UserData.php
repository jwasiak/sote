<?php

/**
 * Subclass for representing a row from the 'st_user_data' table.
 *
 *
 *
 * @package lib.model
 */
class UserData extends BaseUserData
{
   public function getFullName()
   {
      $fullname = parent::getFullName();

      if (empty($fullname))
      {
         if($this->getName()!="" || $this->getSurname()!="")
         {
            $fullname = $this->getName().' '.$this->getSurname();
         }
      }

      return stXssSafe::clean($fullname);
   }

   public function getAddress()
   {
      $address = parent::getAddress();

      if (empty($address))
      {
         if($this->getStreet()!="" || $this->getHouse()!="" || $this->getFlat()!="")
         {
            $old_address = $this->getStreet().' '.$this->getHouse();

            if($this->getFlat()!="")
            {

               $old_address.= '/'.$this->getFlat();
            }

            $address = $old_address;
         }
      }

      return stXssSafe::clean($address);
   }

   public function getAddressMore()
   {
      return stXssSafe::clean($this->address_more);
   }

   public function getRegion()
   {
      return stXssSafe::clean($this->region);
   }

   public function getPesel()
   {
      return stXssSafe::clean($this->pesel);
   }

   public function getCompany()
   {
      return stXssSafe::clean($this->company);
   }

   public function getVatNumber()
   {
      return stXssSafe::clean($this->vat_number);
   }

   public function getName()
   {
      $name = parent::getName();
      if (empty($name))
      {
         $fullname_array = explode(' ', parent::getFullName());
         $name = $fullname_array[0];
      }

      return stXssSafe::clean($name);
   }

   public function getSurname()
   {
      $surname = parent::getSurname();
      if (empty($surname))
      {
         $fullname_array = explode(' ', parent::getFullName());

         foreach ($fullname_array as $key => $array)
         {
            if($key!=0)
            {
               $surname.= $array;
               $surname.= " ";
            }
         }
      $surname = substr($surname,0,strlen($surname)-1);

      }

      return stXssSafe::clean($surname);
   }

   public function getStreet()
   {
      return stXssSafe::clean($this->street);
   }

   public function getHouse()
   {
      return stXssSafe::clean($this->house);
   }

   public function getFlat()
   {     
      return stXssSafe::clean($this->flat);
   }

   public function getCode()
   {
      return stXssSafe::clean($this->code);
   }

   public function getTown()
   {
      return stXssSafe::clean($this->town);
   }

   public function getPhone()
   {
      return stXssSafe::clean($this->phone);
   }

   public function getProfileName()
   {

      if ($this->getCompany())
      {
         return $this->getCompany()." ".$this->getAddress()." ".$this->getCode()." ".$this->getTown();
      }
      else
      {
         return $this->getFullName()." " .$this->getAddress()." ".$this->getCode()." ".$this->getTown();
      }
   }

   public function hydrate(ResultSet $rs, $startcol = 1)
   {
      $ret = parent::hydrate($rs, $startcol);

      $config = stConfig::getInstance(null, 'stRegister');

      //jeśli jest klucz to koduj / dekoduj
      if ($config->get('shop_hash') && Crypt::is_mcrypt())
      {

         if ($this->getCrypt())
         {
            $crypt = new Crypt();

            $this->address = $crypt->Decrypt($this->address);

            $this->address_more = $crypt->Decrypt($this->address_more);

            $this->region = $crypt->Decrypt($this->region);

            $this->pesel = $crypt->Decrypt($this->pesel);

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

      $this->getDispatcher()->notify(new sfEvent($this, 'UserData.preSaveBeforeCrypt'));

      //jeśli jest klucz to koduj / dekoduj
      if (!$config->get('shop_hash') || !Crypt::is_mcrypt())
      {
         parent::save($con);
      }
      else
      {

         if ($this->getCrypt() == 0)
         {
            //wymusza zapis wszystkich danych w przypadku znalezienia niezakryptowanego recordu

            $forced = true;
         }

         if ($this->isColumnModified(UserDataPeer::PESEL) || $this->isColumnModified(UserDataPeer::REGION) || $this->isColumnModified(UserDataPeer::ADDRESS) || $this->isColumnModified(UserDataPeer::ADDRESS_MORE) || $this->isColumnModified(UserDataPeer::STREET) || $this->isColumnModified(UserDataPeer::HOUSE) || $this->isColumnModified(UserDataPeer::FLAT) || $this->isColumnModified(UserDataPeer::CODE) || $this->isColumnModified(UserDataPeer::TOWN) || $this->isColumnModified(UserDataPeer::PHONE) || $forced == true)
         {
            $crypt = new Crypt();


            $address = $this->getAddress();

            if ($this->isColumnModified(UserDataPeer::ADDRESS) || $forced == true)
            {
               $address_crypt = $crypt->Encrypt($this->getAddress());

               $this->setAddress($address_crypt);
            }

            $address_more = $this->getAddressMore();

            if ($this->isColumnModified(UserDataPeer::ADDRESS_MORE) || $forced == true)
            {
               $address_more_crypt = $crypt->Encrypt($this->getAddressMore());

               $this->setAddressMore($address_more_crypt);
            }

            $region = $this->getRegion();

            if ($this->isColumnModified(UserDataPeer::REGION) || $forced == true)
            {
               $region_crypt = $crypt->Encrypt($this->getRegion());

               $this->setRegion($region_crypt);
            }

            $pesel = $this->getPesel();

            if ($this->isColumnModified(UserDataPeer::PESEL) || $forced == true)
            {
               $pesel_crypt = $crypt->Encrypt($this->getPesel());

               $this->setPesel($pesel_crypt);
            }

            $street = $this->getStreet();

            if ($this->isColumnModified(UserDataPeer::STREET) || $forced == true)
            {
               $street_crypt = $crypt->Encrypt($this->getStreet());

               $this->setStreet($street_crypt);
            }

            $house = $this->getHouse();

            if ($this->isColumnModified(UserDataPeer::HOUSE) || $forced == true)
            {
               $house_crypt = $crypt->Encrypt($this->getHouse());

               $this->setHouse($house_crypt);
            }

            $flat = $this->getFlat();

            if ($this->isColumnModified(UserDataPeer::FLAT) || $forced == true)
            {
               $flat_crypt = $crypt->Encrypt($this->getFlat());

               $this->setFlat($flat_crypt);
            }

            $code = $this->getCode();

            if ($this->isColumnModified(UserDataPeer::CODE) || $forced == true)
            {
               $code_crypt = $crypt->Encrypt($this->getCode());

               $this->setCode($code_crypt);
            }

            $town = $this->getTown();

            if ($this->isColumnModified(UserDataPeer::TOWN) || $forced == true)
            {
               $town_crypt = $crypt->Encrypt($this->getTown());

               $this->setTown($town_crypt);
            }

            $phone = $this->getPhone();

            if ($this->isColumnModified(UserDataPeer::PHONE) || $forced == true)
            {
               $phone_crypt = $crypt->Encrypt($this->getPhone());

               $this->setPhone($phone_crypt);
            }

            $this->setCrypt(1);

            // zapis

            parent::save($con);


            $this->setAddress($address);

            $this->setAddressMore($address_more);

            $this->setRegion($region);

            $this->setPesel($pesel);

            $this->setStreet($street);

            $this->setHouse($house);

            $this->setFlat($flat);

            $this->setCode($code);

            $this->setTown($town);

            $this->setPhone($phone);

            $this->resetModified();
         }
         else
         {
            parent::save($con);
         }
      }
   }

}
