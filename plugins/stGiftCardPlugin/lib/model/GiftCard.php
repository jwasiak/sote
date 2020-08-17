<?php

/**
 * Subclass for representing a row from the 'st_gift_card' table.
 *
 * 
 *
 * @package plugins.stGiftCardPlugin.lib.model
 */ 
class GiftCard extends BaseGiftCard
{
   const DAY = 86400;

   public function getCode()
   {
      if ($this->isNew() && !parent::getCode()) 
      {
         $this->generate();
      }

      return parent::getCode();
   }

   public function validateDate()
   {
      $current_time = time();

      return !$this->getValidTo() || strtotime($this->getValidTo()) + (self::DAY - 1) >= $current_time;
   }   
   
   public function isValid()
   {
      return $this->isActive() && $this->validateDate();
   }

   public function isValidOrderAmount($amount)
   {
      return $this->getMinOrderAmount() <= $amount;
   }
   
   public function isActive()
   {
      return $this->status == 'A';
   }
   
   public function isUsed()
   {
      return $this->status == 'U';
   }

   public function getAllowAllProducts()
   {
      $value = parent::getAllowAllProducts();

      return null === $value && !$this->isNew() ? true : $value;
   }
   
   public function isPending()
   {  
      return $this->status == 'P';
   }

   public function setValidFor($v)
   {
      $valid_to = date('Y-m-d', time() + $v * 24 * 60 * 60);

      $this->setValidTo($valid_to);
   }

   public function save($con = null)
   {
      if ($this->isNew() && !$this->code) 
      {
         $this->generate();
      }

      return parent::save($con);
   }

   public function generate()
   {
      $c = new Criteria();
      $c->addSelectColumn('MAX('.GiftCardPeer::ID.')');
      $rs = GiftCardPeer::doSelectRs($c);

      if ($rs->next())
      {
         $prefix = $rs->getInt(1);
      }
      else 
      {
         $prefix = 1;
      }         

      $config = stConfig::getInstance('stGiftCardBackend');

      $generator = new stKeyGenerator($prefix + 1, $config->get('code_format'));

      $this->setCode($generator->generate());     
   }
}
