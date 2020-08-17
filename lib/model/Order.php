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
 * @version     $Id: Order.php 16069 2011-11-10 13:57:55Z marcin $
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
class Order extends BaseOrder
{

   /**
    * Płatność zamówienia
    * @var Payment
    */
   protected $aPayment = null;
   protected $aLanguage = null;
   protected $unpaidAmount = null;
   protected $previousColumnValues = array();
   protected $forceTotalAmountUpdate = false;

   protected $hasValidPayment = null;

   /**
    * Płatności zamówienia
    *
    * @var Payment[]
    */
   protected $orderPayments = null;

   /**
    * Zwraca użytkownika
    *
    * @return   sfGuardUser
    */
   public function getGuardUser()
   {
      return $this->getSfGuardUser();
   }

   public function forceTotalAmountUpdate()
   {
      $this->forceTotalAmountUpdate = true;
   }
   
   

   /**
    * Ustawa użytkownika
    *
    * @param   sfGuardUser $v
    */
   public function setGuardUser($v)
   {
      $this->setSfGuardUser($v);
   }

   /**
    * Ustawia id użytkownika
    *
    * @param       integer     $v
    */
   public function setGuardUserId($v)
   {
      $this->setGuardUser($v);
   }

   /**
    * Zwraca dostawę dla zamówienia
    *
    * @return   OrderDelivery
    */
   public function getOrderDelivery($con = null)
   {
      if (!parent::getOrderDelivery($con))
      {
         $this->setOrderDelivery(new OrderDelivery());
      }

      return $this->aOrderDelivery;
   }
   
   public function setOrderDelivery($v)
   {
      parent::setOrderDelivery($v);
      
      $v->setOrder($this);
   }

   public function setDiscount($v)
   {
      if ($v)
      {
         parent::setDiscount($v);
      } 
   }

   public function getOrderStatus($con = null)
   {
      if (null === $this->aOrderStatus)
      {
         $status = OrderStatusPeer::doSelectCached();
         $this->aOrderStatus = isset($status[$this->getOrderStatusId()]) ? $status[$this->getOrderStatusId()] : null;
      }

      return $this->aOrderStatus;
   }

   public function getClientRequestInvoice()
   {
      $c = new Criteria();
      $c->add(InvoicePeer::IS_REQUEST, true);
      return $this->countInvoices($c) > 0;
   }

   public function getOptClientCompany()
   {
      $this->opt_client_company = parent::getOptClientCompany();

      if (!$this->isNew() && null === $this->opt_client_company)
      {
         $con = Propel::getConnection();

         $sc = new Criteria();

         $sc->add(OrderPeer::ID, $this->id);

         $uc = new Criteria();

         $this->opt_client_company = $this->getOrderUserDataBilling()->getCompany() ? $this->getOrderUserDataBilling()->getCompany() : '';

         $uc->add(OrderPeer::OPT_CLIENT_COMPANY, $this->opt_client_company);

         BasePeer::doUpdate($sc, $uc, $con);
      }

      return $this->opt_client_company;
   }

   /**
    * Zwraca walute dla zamówienia
    *
    * @return   OrderCurrency
    */
   public function getOrderCurrency($con = null)
   {
      if (!parent::getOrderCurrency($con))
      {
         $this->setOrderCurrency(new OrderCurrency());
      }

      return $this->aOrderCurrency;
   }
      
   public function setOrderStatusId($v)
   {
      $pv = $this->order_status_id;
            
      parent::setOrderStatusId($v);
      
      if ($pv !== $this->order_status_id && !array_key_exists(OrderPeer::ORDER_STATUS_ID, $this->previousColumnValues))
      {
         $this->previousColumnValues[OrderPeer::ORDER_STATUS_ID] = $pv;
      }      
   }
   
   public function getPreviousColumnValue($col)
   {
      if (!array_key_exists($col, $this->previousColumnValues))
      {
         $getter = 'get'.OrderPeer::translateFieldName($col, BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
                  
         return $this->$getter();
      }
      
      return $this->previousColumnValues[$col];
   }

   public function getOptOrderStatus()
   {
      return $this->getOrderStatus() ? $this->getOrderStatus()->getName() : null;
   }   

   /**
    * Zwraca dane bilingowe dla zamówienia
    *
    * @return   OrderUserDataBilling
    */
   public function getOrderUserDataBilling($con = null)
   {
      if (!parent::getOrderUserDataBilling($con))
      {
         $this->setOrderUserDataBilling(new OrderUserDataBilling());
      }

      return $this->aOrderUserDataBilling;
   }

   /**
    * Zwraca dane dostawy dla zamówienia
    *
    * @return   OrderUserDataDelivery
    */
   public function getOrderUserDataDelivery($con = null)
   {
      if (!parent::getOrderUserDataDelivery($con))
      {
         $this->setOrderUserDataDelivery(new OrderUserDataDelivery());
      }

      return $this->aOrderUserDataDelivery;
   }

   /**
    * Zwraca łączną wartość zamówienia
    *
    * @param   bool        $with_vat           Uwzględnij VAT
    * @return   float
    */
   public function getTotalAmount($with_vat = false, $with_currency = false, $with_discount = true)
   {
      $total_amount = 0;

      $order_products = $this->getOrderProducts();

      foreach ($order_products as $order_product)
      {
         if ($order_product->isDeleted())
            continue;

         if ($this->isNew())
         {
            $order_product->setVersion(2);
         }

         $order_product->setOrder($this);

         $total_amount += $order_product->getTotalAmount($with_vat, $with_currency);
      }

      if ($with_discount && $this->hasDiscount())
      {
         $total_amount = stDiscount::apply($total_amount, array($this->getOrderDiscount()), null, false);
      }

      return $total_amount;
   }

   public function getTotalProductDiscountAmount($with_tax = false, $with_currency = false) 
   {
      return $this->getTotalAmount($with_tax, $with_currency, false) - $this->getTotalAmount($with_tax, $with_currency);
   }  

   public function hasDiscount()
   {
      return $this->getOrderDiscount() !== null;
   }   

   public function getTotalAmountWithDelivery($with_tax = false, $with_currency = false)
   {
      return $this->getTotalAmount($with_tax, $with_currency) + $this->getOrderDelivery()->getCost($with_tax, $with_currency);
   }

   /**
    * Zwraca łączną ilość produktów w zamówieniu
    *
    * @return   integer
    */
   public function getTotalQuantity()
   {
      $total_quantity = 0;

      $order_products = $this->getOrderProducts();

      foreach ($order_products as $order_product)
      {
         $total_quantity += $order_product->getQuantity();
      }

      return $total_quantity;
   }

   public function getTotalWeight()
   {
      $total = 0;

      foreach ($this->getOrderProducts() as $order_product)
      {
         $total += $order_product->getTotalWeight();
      } 

      return $total;     
   }

   public function setOptIsPayed($v)
   {
      $this->hasValidPayment();
      return parent::setOptIsPayed($v);
   }

   /**
    * Sprawdza czy zamówienie jest opłacone
    *
    * @return   bool
    */
   public function getIsPayed()
   {
      if ($this->getOptIsPayed() === null)
      {
         $this->setOptIsPayed(!stPayment::getUnpayedAmountByOrder($this));
      }

      return $this->getOptIsPayed();
   }

   public function hasValidPayment()
	{
		if (strtotime(stConfig::getInstance('stOrder')->get('payment_verification_check')) >= strtotime($this->getCreatedAt()))
		{
			return true;
      }
      
      if (null === $this->hasValidPayment)
      {
         if (null === $this->getPaymentSecurityHash())
         {
            $this->setPaymentSecurityHash($this->generatePaymentSecurityHash());
            OrderPeer::doUpdate($this);
         }

         $this->hasValidPayment = $this->isNew() || $this->getPaymentSecurityHash() == $this->generatePaymentSecurityHash();
      }
      
      return $this->hasValidPayment;
	}

   public function showPayment()
   {
      return $this->getOrderPayment() && $this->getOrderPayment()->getPaymentType()->getModuleName() != 'stStandardPayment' && !$this->getIsPayed() && $this->getOrderStatus()->getType() != 'ST_CANCELED' && !$this->getOrderPayment()->getInProgress();
   }

   /**
    * Przeciażenie zapisu - generowaniu ciagu hash używanego podczas dostępu do zamówienia
    *
    * @param         mixed       $con
    */
   public function save($con = null)
   {
      if ($this->isColumnModified(OrderPeer::DISCOUNT_ID))
      {
         $d = $this->getDiscount();
         
         if (null !==$d)
         {
            $c = $this->getOrderCurrency();
            $value = $d->getPriceType() != '%' ? $c->exchange($d->getValue()) : $d->getValue();

            $this->setOrderDiscount($d ? array('value' => $value, 'type' => $d->getPriceType()) : null);
         }
         else
         {
            $this->setOrderDiscount(null);
         }
      }

      if ($this->isNew())
      {
         $this->setIsMarkedAsRead(false);
         $this->setRemoteAddress($_SERVER['REMOTE_ADDR']);
         $this->setHashCode(md5(serialize($this) . microtime(true)));

         if ($billing = $this->getOrderUserDataBilling())
         {
            $this->setOptClientName($billing->getName() . ' ' . $billing->getSurname());
         }

         if ($user = $this->getsfGuardUser())
         {
            $this->setOptClientEmail($user->getUsername());
         }
         
         $this->setOptTotalAmount($this->getTotalAmountWithDelivery(true, true));

         $this->setOptIsPayed(false);
      }
      elseif ($this->forceTotalAmountUpdate)
      {
         $this->setOptTotalAmount($this->getTotalAmountWithDelivery(true, true));
      }
      
      if ($this->isColumnModified(OrderPeer::ORDER_STATUS_ID) && $this->getOrderStatus())
      {
         if ($this->getOrderStatus()->getType() == 'ST_COMPLETE')
         {
            $gift_cards = GiftCardPeer::doSelectByOrder($this);

            foreach ($gift_cards as $gift_card)
            {
               $gift_card->setStatus('U');

               $gift_card->save();
            }
         }
      }

      if ($this->hasValidPayment())
      { 
         $this->setPaymentSecurityHash($this->generatePaymentSecurityHash());
      }
      
      parent::save($con);
      
      $this->previousColumnValues = array();
   }

   public function isAllegroOrder()
   {
      return null !== $this->getOptAllegroNick() || null !== $this->getOptAllegroCheckoutFormId();
   }

   public function delete($con = null)
   {
      if ($this->getOrderDelivery())
      {
         $this->getOrderDelivery()->delete($con);
      }

      if ($this->getOrderCurrency())
      {
         $this->getOrderCurrency()->delete($con);
      }

      return parent::delete($con);
   }

   public function getOrderLanguage()
   {
      if (null === $this->aLanguage)
      {
         $this->aLanguage = LanguagePeer::retrieveByCulture($this->getClientCulture(), null);
      }

      return $this->aLanguage;
   }

   public function setOrderPayment(Payment $payment)
   {
      $this->aPayment = $payment;
   }

   /**
    * Zwraca listę płatności
    *
    * @return Payment[]
    */
   public function getOrderPayments()
   {
      if (null === $this->orderPayments)
      {
         $c = new Criteria();

         $c->addJoin(PaymentPeer::ID, OrderHasPaymentPeer::PAYMENT_ID);

         $c->add(OrderHasPaymentPeer::ORDER_ID, $this->getId());

         $c->addDescendingOrderByColumn(PaymentPeer::ID);
         
         $this->orderPayments = PaymentPeer::doSelect($c);      
      }

      return $this->orderPayments;
   }

   public function getOrderPayment()
   {
      if (null === $this->aPayment)
      {
         $c = new Criteria();

         $c->addJoin(PaymentPeer::ID, OrderHasPaymentPeer::PAYMENT_ID);

         $c->add(OrderHasPaymentPeer::ORDER_ID, $this->getId());

         $c->addDescendingOrderByColumn(PaymentPeer::ID);

         $payment = PaymentPeer::doSelectOne($c);

         if ($payment && $payment->getGiftCardId())
         {
            $pt = new PaymentType();

            $pt->setName('Bony zakupowe');

            $payment->setPaymentType($pt);
         }

         $this->aPayment = $payment;
      }

      return $this->aPayment;
   }

   public function addOrderPayment(Payment $payment)
   {
      $ohp = new OrderHasPayment();

      $payment->addOrderHasPayment($ohp);

      $this->addOrderHasPayment($ohp);
   }

   public function getOrderProducts($criteria = null, $con = null)
   {
      if (!$criteria)
      {
         $criteria = new Criteria();
      }
      else
      {
         $criteria = clone $criteria;
      }

      $criteria->addAscendingOrderByColumn(OrderProductPeer::ID);

      return parent::getOrderProducts($criteria, $con);
   }

   public function getUnpaidAmount()
   {
      if (null === $this->unpaidAmount)
      {
         $this->unpaidAmount = stPayment::getUnpayedAmountByOrder($this);
      }

      return $this->unpaidAmount;
   }

   public function getPaidAmount()
   {
      return $this->getTotalAmountWithDelivery(true, true) - $this->getUnpaidAmount();
   }

   public function getDescription()
   {
      return stXssSafe::clean($this->description);
   }
   
	protected function generatePaymentSecurityHash()
	{
		return stSecureToken::generate(array(
			intval($this->getOptIsPayed()),
			$this->getHashCode(),
		));
	}
}
