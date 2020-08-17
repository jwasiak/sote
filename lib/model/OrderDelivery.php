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
 * @version     $Id: OrderDelivery.php 16069 2011-11-10 13:57:55Z marcin $
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
class OrderDelivery extends BaseOrderDelivery
{

   protected $currency = null;
   
   protected $order = null;

   public function __toString()
   {
      return $this->getName();
   }

   public function getCost($with_tax = false, $with_currency = false)
   {
      if ($with_tax)
      {
         return $this->getCostBrutto($with_currency);
      }
      else
      {
         return $this->getCostNetto($with_currency);
      }
   }

   public function getPickupPoint()
   {
      $pickupPoint = parent::getPickupPoint();

      if (!$pickupPoint)
      {
         $pickupPoint = $this->getPaczkomatyNumber();

         if (!$pickupPoint)
         {
            $pp = PocztaPolskaPunktOdbioruPeer::retrieveByPK($this->getOrder()->getId());
   
            if ($pp)
            {
               $point = $pp->getPoint();
               $pickupPoint = $point['pni'];
            }
         }

         $this->pickup_point = $pickupPoint;
      }

      return $pickupPoint;
   }

   /**
    * Zwraca instancje modelu zamowienia
    *
    * @return Order
    */
   public function getOrder()
   {
      if (null === $this->order)
      {
         $orders = $this->getOrders();

         $this->order = isset($orders[0]) ? $orders[0] : null;
      }

      return $this->order;
   }
   
   public function setOrder(Order $order)
   {
      $this->order = $order;
   }
   
   public function getCostNetto($with_currency = false)
   {
      $cost = stPrice::extract($this->getCostBrutto(), $this->getOptTax());

      if ($this->custom_cost_brutto !== null)
      {
         return $cost;
      }

      if ($with_currency)
      {
         $cost = $this->getOrder()->getOrderCurrency()->exchange($cost);
      }

      return $cost;
   }

   public function getCostBrutto($with_currency = false)
   {
      if ($this->custom_cost_brutto !== null)
      {
         return $this->custom_cost_brutto;
      }

      $cost = parent::getCostBrutto();

      if (null === $cost)
      {
         $cost = stPrice::calculate($this->cost, $this->getOptTax());
      }

      if ($with_currency)
      {
         $cost = $this->getOrder()->getOrderCurrency()->exchange($cost);
      }

      return $cost + $this->getPaymentCostBrutto($with_currency);
   }

   public function getPaymentCostNetto($with_currency = false)
   {
      $cost = $this->payment_cost;

      if ($with_currency)
      {
         $cost = $this->getOrder()->getOrderCurrency()->exchange($cost);
      }

      return $cost;
   }

   public function getPaymentCostBrutto($with_currency = false)
   {
      $cost = parent::getPaymentCostBrutto();

      if (null === $cost)
      {
         $cost = stPrice::calculate($this->getPaymentCostNetto(), $this->getOptTax());
      }

      if ($with_currency)
      {
         $cost = $this->getOrder()->getOrderCurrency()->exchange($cost);
      }

      return $cost;
   }

   public function getPaymentCost($with_tax = false, $with_currency = false)
   {
      if ($with_tax)
      {
         return $this->getPaymentCostBrutto($with_currency);
      }
      else
      {
         return $this->getPaymentCostNetto($with_currency);
      }
   }

   public function setPaymentCostNetto($v)
   {
      $this->setPaymentCost($v);
   }

   public function setCostNetto($v)
   {
      $this->setCost($v);
   }

   public function getNumber()
   {
      $number = parent::getNumber();

      if (!$number)
      {
         $paczka = PocztaPolskaPaczkaPeer::retrieveByOrder($this->getOrder());

         if ($paczka && $paczka->isSent())
         {
            $number = $paczka->getNumerNadania();
            $this->setNumber($number);
         }
      }

      return $number;
   }

   public function setTax($v)
   {
      $ret = parent::setTax($v);

      if ($v)
      {
         $this->setOptTax($v->getVat());
      }

      return $v;
   }

   public function save($con = null)
   {
      if (null === $this->cost && $this->getOptTax())
      {
         $this->setCost(stPrice::extract($this->getCostBrutto(), $this->getOptTax()));
      }
      elseif (null === $this->cost_brutto && $this->getOptTax())
      {
         $this->setCostBrutto(stPrice::calculate($this->getCost(), $this->getOptTax()));
      }

      return parent::save($con);
   }

}