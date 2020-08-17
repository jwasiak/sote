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
 * @version     $Id: OrderStatus.php 12047 2011-04-05 11:19:42Z michal $
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
class OrderStatus extends BaseOrderStatus
{

   /**
    * Nazwa statusu
    *
    * @return   string
    */
   public function __toString()
   {
      return $this->getName();
   }

   public function getAttachCouponCode()
   {
      return $this->getHasMailNotification() && $this->getType() == 'ST_COMPLETE' && $this->getHasCouponCode();
   }

   public function  getHasCouponCode()
   {
      return parent::getHasCouponCode() && $this->isCouponCodeEnabled();
   }

   public function setAttachCouponCode($v)
   {
      $this->setHasCouponCode($v);
   }

   public function isCouponCodeEnabled()
   {
      return stConfig::getInstance(null, 'stDiscountBackend')->get('coupon_code');
   }

   public function getCouponCodeDiscount()
   {
      return $this->getCouponCode() ? $this->getCouponCode()->getDiscount() : 0;
   }

   public function getCouponCodeValidFor()
   {
      return $this->getCouponCode() ? $this->getCouponCode()->getValidFor() : 0;
   }

   public function setOrderStatusDescription($v)
   {
      $this->setDescription($v);
   }

   public function getCouponCode($con = null)
   {
      return $this->getOrderStatusCouponCode($con);
   }

   public function setCouponCode($v)
   {
      $this->setOrderStatusCouponCode($v);
   }

   public function getNameWithMailNotification()
   {
      $info = array();

      $i18n = sfContext::getInstance()->getI18N();

      if ($this->has_mail_notification)
      {
         $info[] = 'e-mail';
      }

      if ($this->getHasCouponCode())
      {
         $info[] = $i18n->__('kod rabatowy').': '.$this->getCouponCodeDiscount().'%';
      }

      return $info ? $this->getName().' ('.implode(', ',$info).')' : $this->getName();
   }

   /**
    * Ustawia rodzaj statusu
    *
    * @param   string      $type               Rodzaj statusu
    */
   public function setOrderStatusType($type)
   {
      $this->setType($type);
   }

   /**
    * Zwraca rodzaj statusu
    *
    * @return  string      Rodzaj statusu
    */
   public function getOrderStatusType()
   {
      return $this->getType();
   }

   /**
    * Przeciazenie usuwania statusu
    *
    * @param   mixed       $con                Polaczenie bazy danych
    */
   public function delete($con = null)
   {
      parent::delete($con);

      $system_status = OrderStatusPeer::retrieveSystemStatusByType($this->getType());

      $select_criteria = new Criteria();

      $select_criteria->add(OrderPeer::ORDER_STATUS_ID, $this->getId());

      $update_criteria = new Criteria();

      $update_criteria->add(OrderPeer::ORDER_STATUS_ID, $system_status->getId());

      if ($con === null)
      {
         $con = Propel::getConnection();
      }

      BasePeer::doUpdate($select_criteria, $update_criteria, $con);

      if ($this->getType() == 'ST_PENDING' && $this->getIsDefault())
      {
         $system_status->setIsDefault(true);

         $system_status->save($con);
      }

      OrderStatusPeer::clearCache();
   }

   public function save($con = null)
   {
      if ($this->getIsDefault() && $this->isColumnModified(OrderStatusPeer::IS_DEFAULT))
      {
         $sc = new Criteria();

         $sc->add(OrderStatusPeer::IS_DEFAULT, true);

         $uc = new Criteria();

         $uc->add(OrderStatusPeer::IS_DEFAULT, false);

         $conn = Propel::getConnection();

         BasePeer::doUpdate($sc, $uc, $conn);
      }

      $ret = parent::save($con);

      OrderStatusPeer::clearCache();

      return $ret;
   }

   /**
    * Przeciążenie hydrate
    *
    * @param ResultSet $rs
    * @param int $startcol
    * @return object
    */
   public function hydrate(ResultSet $rs, $startcol = 1)
   {
      $this->setCulture(stLanguage::getHydrateCulture());
      return parent::hydrate($rs, $startcol);
   }

   /**
    * Przeciążenie getName
    *
    * @return string
    */
   public function getName()
   {
      if ($this->getCulture() == stLanguage::getOptLanguage())
      {
         return stLanguage::getDefaultValue($this, __METHOD__);
      }

      $v = parent::getName();

      if (is_null($v))
      {
         $v = stLanguage::getDefaultValue($this, __METHOD__);
      }

      return $v;
   }

   public function setName($v)
   {
      if ($this->getCulture() == stLanguage::getOptLanguage())
      {
         stLanguage::setDefaultValue($this, __METHOD__, $v);
      }

      parent::setName($v);
   }

   public function getDescription()
   {
      if ($this->getCulture() == stLanguage::getOptLanguage())
      {
         return stLanguage::getDefaultValue($this, __METHOD__);
      }

      $v = parent::getDescription();

      if (is_null($v))
      {
         $v = stLanguage::getDefaultValue($this, __METHOD__);
      }

      return $v;
   }

   public function setDescription($v)
   {
      if ($this->getCulture() == stLanguage::getOptLanguage())
      {
         stLanguage::setDefaultValue($this, __METHOD__, $v);
      }

      parent::setDescription($v);
   }

}