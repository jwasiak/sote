<?php

/**
 * Subclass for representing a row from the 'st_discount_coupon_code' table.
 *
 * 
 *
 * @package plugins.stDiscountPlugin.lib.model
 */
class DiscountCouponCode extends BaseDiscountCouponCode
{

   protected $isValid = null;

   public function setCcEditDiscount($v)
   {
      $this->setDiscount($v);
   }

   public function getCode()
   {
      if (parent::getCode() === null)
      {
         $this->generate();
      }

      return $this->code;
   }

   public function isValid()
   {
      if (null === $this->isValid)
      {
         $this->isValid = $this->validateUsage() && $this->validateDate();
      }

      return $this->isValid;
   }

   public function getAllowAllProducts()
   {
      $value = parent::getAllowAllProducts();

      return null === $value && !$this->isNew() ? true : $value;
   }

   public function incrementUsage()
   {
      $this->setUsed($this->used + 1);
   }

   public function setValidFrom($v)
   {
      parent::setValidFrom($v);

      $this->isValid = null;
   }

   public function setValidTo($v)
   {
      parent::setValidTo($v);

      $this->isValid = null;
   }

   public function setValidUsage($v)
   {
      parent::setValidUsage($v);

      $this->isValid = null;
   }

   public function setUsed($v)
   {
      parent::setUsed($v);

      $this->isValid = null;
   }

   public function getUsageLeft()
   {
      $left = $this->getValidUsage() - $this->getUsed();

      return $left > 0 ? $left : 0;
   }

   public function setValidFor($v)
   {
      $valid_to = date('Y-m-d H:i:s', time() + $v * 24 * 60 * 60);

      $this->setValidTo($valid_to);
   }

   public function validateUsage()
   {
      return !$this->getValidUsage() || $this->getUsed() < $this->getValidUsage();
   }

   public function validateDate()
   {
      $current_time = time();

      return (!$this->getValidFrom() || strtotime($this->getValidFrom()) <= $current_time) && (!$this->getValidTo() || strtotime($this->getValidTo()) >= $current_time);
   }

   public function save($con = null)
   {
      if (null === $this->code)
      {
         $this->generate();
      }

      if ($this->valid_usage > 0 && $this->used > $this->valid_usage)
      {
         $this->used = $this->valid_usage;
      }

      parent::save($con);
   }


   public function generate()
   {
      $c = new Criteria();
      $c->addSelectColumn('MAX('.DiscountCouponCodePeer::ID.')');
      $rs = DiscountCouponCodePeer::doSelectRs($c);

      if ($rs->next())
      {
         $prefix = $rs->getInt(1);
      }
      else 
      {
         $prefix = 1;
      }         

      $config = stConfig::getInstance('stDiscountBackend');

      $generator = new stKeyGenerator($prefix + 1, $config->get('code_format'));

      $this->setCode($generator->generate());     
   }
}
