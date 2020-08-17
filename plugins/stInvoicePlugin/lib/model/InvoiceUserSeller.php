<?php

/**
 * Subclass for representing a row from the 'st_invoice_user_seller' table.
 *
 *
 *
 * @package plugins.stInvoicePlugin.lib.model
 */
class InvoiceUserSeller extends BaseInvoiceUserSeller
{
   public function getFullName()
   {
      $fullname = parent::getFullName();

      if (null === $fullname)
      {
         if($this->getName()!="" || $this->getSurname()!="")
         {
            $fullname = $this->getName().' '.$this->getSurname();
         }
      }

      return $fullname;
   }

   public function getAddress()
   {
      $address = parent::getAddress();

      if (null === $address)
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

      return $address;
   }

   public function getName()
   {
      $name = parent::getName();
      if (empty($name))
      {
         $fullname_array = explode(' ', parent::getFullName());
         $name = $fullname_array[0];
      }

      return $name;
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

      return $surname;
   }

      public function getStreet()
      {
         $street = parent::getStreet();
         if (empty($street))
         {
            $aparser = new stAddressParser(parent::getAddress());
            $result  = $aparser->getAddress();
            $street = $result['s1'];
         }

         return $street;
      }

      public function getHouse()
      {
         $house = parent::getHouse();
         if (empty($house))
         {
            $aparser = new stAddressParser(parent::getAddress());
            $result  = $aparser->getAddress();
            $house = $result['n1'];
         }

         return $house;
      }

      public function getFlat()
      {
         $flat = parent::getFlat();
         if (empty($flat))
         {
            $aparser = new stAddressParser(parent::getAddress());
            $result  = $aparser->getAddress();
            $flat = $result['n2'];
         }

         return $flat;
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

            $this->street = $crypt->Decrypt($this->street);

            $this->house = $crypt->Decrypt($this->house);

            $this->flat = $crypt->Decrypt($this->flat);

            $this->code = $crypt->Decrypt($this->code);

            $this->town = $crypt->Decrypt($this->town);
            
         }
      }

      return $ret;
   }

   public function save($con = null, $forced = false)
   {
      $config = stConfig::getInstance(null, 'stRegister');

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

         if ($this->isColumnModified(InvoiceUserSellerPeer::REGION) || $this->isColumnModified(InvoiceUserSellerPeer::ADDRESS) || $this->isColumnModified(InvoiceUserSellerPeer::ADDRESS_MORE) || $this->isColumnModified(InvoiceUserSellerPeer::STREET) || $this->isColumnModified(InvoiceUserSellerPeer::HOUSE) || $this->isColumnModified(InvoiceUserSellerPeer::FLAT) || $this->isColumnModified(InvoiceUserSellerPeer::CODE) || $this->isColumnModified(InvoiceUserSellerPeer::TOWN) || $forced == true)
         {
            $crypt = new Crypt();


            $address = $this->getAddress();

            if ($this->isColumnModified(InvoiceUserSellerPeer::ADDRESS) || $forced == true)
            {
               $address_crypt = $crypt->Encrypt($this->getAddress());

               $this->setAddress($address_crypt);
            }

            $address_more = $this->getAddressMore();

            if ($this->isColumnModified(InvoiceUserSellerPeer::ADDRESS_MORE) || $forced == true)
            {
               $address_more_crypt = $crypt->Encrypt($this->getAddressMore());

               $this->setAddressMore($address_more_crypt);
            }

            $region = $this->getRegion();

            if ($this->isColumnModified(InvoiceUserSellerPeer::REGION) || $forced == true)
            {
               $region_crypt = $crypt->Encrypt($this->getRegion());

               $this->setRegion($region_crypt);
            }

            $street = $this->getStreet();

            if ($this->isColumnModified(InvoiceUserSellerPeer::STREET) || $forced == true)
            {
               $street_crypt = $crypt->Encrypt($this->getStreet());

               $this->setStreet($street_crypt);
            }

            $house = $this->getHouse();

            if ($this->isColumnModified(InvoiceUserSellerPeer::HOUSE) || $forced == true)
            {
               $house_crypt = $crypt->Encrypt($this->getHouse());

               $this->setHouse($house_crypt);
            }

            $flat = $this->getFlat();

            if ($this->isColumnModified(InvoiceUserSellerPeer::FLAT) || $forced == true)
            {
               $flat_crypt = $crypt->Encrypt($this->getFlat());

               $this->setFlat($flat_crypt);
            }

            $code = $this->getCode();

            if ($this->isColumnModified(InvoiceUserSellerPeer::CODE) || $forced == true)
            {
               $code_crypt = $crypt->Encrypt($this->getCode());

               $this->setCode($code_crypt);
            }

            $town = $this->getTown();

            if ($this->isColumnModified(InvoiceUserSellerPeer::TOWN) || $forced == true)
            {
               $town_crypt = $crypt->Encrypt($this->getTown());

               $this->setTown($town_crypt);
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
            
         }
         else
         {
            parent::save($con);
         }
      }
   }

}
