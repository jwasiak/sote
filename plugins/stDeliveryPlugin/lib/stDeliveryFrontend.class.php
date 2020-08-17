<?php

/**
 * SOTESHOP/stDelivery
 *
 * Ten plik należy do aplikacji stDelivery opartej na licencji (Professional License SOTE).
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stDelivery
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stDeliveryFrontend.class.php 7534 2010-08-11 13:48:48Z marcin $
 * @author      Marcin Butlak <marcin.butlak@sote.pl>
 */

/**
 * Klasa zarządzająca dostawami w sklepie
 *
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 *
 * @package     stDelivery
 * @subpackage  libs
 */
class stDeliveryFrontend
{
   const SESSION_NAMESPACE = 'soteshop/stDeliveryFrontend';

   protected static $instance = null;

   protected 
      $delivery = null,
      $deliveryCountry = null,
      $deliveries = null,
      $deliveryCountries = null,
      $minOrderAmount = null,
      $minOrderQuantity = null,
      $minOrderWeight = null,
      $maxOrderAmount = null,
      $maxOrderQuantity = null,
      $maxOrderWeight = null,
      $basketTotals = null,
      $basket = null,
      $allow = array(),
      $exclude = array(),
      $config = null,
      $dispatcher = null;

   /**
    * Incjalizacja klasy stDelivery
    *
    * @param stBasket $basket
    */
   public function initialize($basket)
   {
      $this->basket = $basket;

      $this->dispatcher = stEventDispatcher::getInstance();

      $this->config = stConfig::getInstance('stDeliveryBackend');
   }

   public function clearBasketTotals()
   {
      $this->basketTotals = null;
   }

   /**
    * Zwraca instancje obiektu
    *
    * @param stBasket $basket
    * @return   stDeliveryFrontend
    */
   public static function getInstance($basket)
   {
      if (!isset(self::$instance))
      {
         $class = __CLASS__;

         self::$instance = new $class();

         self::$instance->initialize($basket);
      }

      return self::$instance;
   }

   /**
    * Usuwa z sesji domyślna dostawę oraz domyślną płatność
    */
   public function clearSession()
   {
      $this->getUser()->getAttributeHolder()->remove('delivery', self::SESSION_NAMESPACE);

      $this->getUser()->getAttributeHolder()->remove('delivery_payment', self::SESSION_NAMESPACE);
   }

   /**
    *
    * @return stUser
    */
   public function getUser()
   {
      return $this->basket->getUser();
   }

   public function getBasket()
   {
      return $this->basket;
   }

   /**
    * Ustawia domyslna dostawe
    *
    * @param mixed $delivery
    */
   public function setDefaultDelivery($delivery)
   {
      if ($delivery)
      {
         if (!is_object($delivery))
         {
            $this->delivery = $this->getDeliveryById($delivery);
         }
         else
         {
            $this->delivery = $delivery;
         }

         $this->getUser()->setAttribute('delivery', $this->delivery ? $this->delivery->getId() : null, self::SESSION_NAMESPACE);
      }
   }

   public function setDefaultDeliveryCountry($delivery_country)
   {
      if ($delivery_country)
      {
         if (!is_object($delivery_country))
         {
            $this->deliveryCountry = $this->getCountryById($delivery_country);
         }
         else
         {
            $this->deliveryCountry = $delivery_country;
         }

         $this->deliveries = null;
         $this->delivery = null;

         $this->getUser()->setAttribute('delivery_country', $this->deliveryCountry ? $this->deliveryCountry->getId() : null, self::SESSION_NAMESPACE);
      }
   }

   /**
    * Pobiera listę aktywnych dostaw
    *
    * @return array of Delivery
    */
   public function getDeliveries()
   {
      if (is_null($this->deliveries))
      {
         $this->deliveries = $this->doSelectDeliveries();
      }

      return $this->deliveries;
   }

   /**
    *
    * Metoda pomocniczna pobierająca listę aktywnych dostaw
    *
    * @param Criteria $c Dodatkowe kryteria filtrujace liste dostaw
    * @return array of Delivery
    */
   public function doSelectDeliveries(Criteria $c = null)
   {
      if (is_null($c))
      {
         $c = new Criteria();
      }
      else
      {
         $c = clone $c;
      }

      $deliveries = array();

      if (false === $this->allow)
      {
         $deliveries = array();
      }
      else
      {
         $this->setBaseFilterCriteria($c);

         $this->setCountriesFilterCriteria($c);

         $this->setMaxFilterCriteria($c);

         $c->addAscendingOrderByColumn(DeliveryPeer::POSITION);

         $deliveries = DeliveryPeer::doSelect($c);
      }

      return array_map(array($this, 'deliveryCallback'), $deliveries);
   }

   /**
    * Zwraca kraje dostawy
    *
    * @param boolean $without_max_restrictions
    * @return array
    */
   public function getDeliveryCountries($without_max_restrictions = false)
   {
      if (is_null($this->deliveryCountries))
      {
         $c = new Criteria();

         $c->addSelectColumn(CountriesPeer::ID);

         $c->addJoin(CountriesAreaHasCountriesPeer::COUNTRIES_ID, CountriesPeer::ID);

         $c->addJoin(CountriesAreaHasCountriesPeer::COUNTRIES_AREA_ID, CountriesAreaPeer::ID);

         $c->addJoin(CountriesAreaPeer::ID, DeliveryPeer::COUNTRIES_AREA_ID);

         $c->add(CountriesAreaPeer::IS_ACTIVE, true);

         $this->setBaseFilterCriteria($c);

         if (!$without_max_restrictions)
         {
            $this->setMaxFilterCriteria($c);
         }

         $c->addGroupByColumn(CountriesPeer::ID);

         $rs = CountriesPeer::doSelectRS($c);

         $ids = array();

         while($rs->next())
         {
            list($id) = $rs->getRow();
            $ids[$id] = $id;
         }

         $countries = array();

         foreach (CountriesPeer::doSelectActiveCached() as $country)
         {
            if (isset($ids[$country->getId()]))
            {
               $countries[] = $this->deliveryCountryCallback($country);
            }
         }

         $this->deliveryCountries = $countries;
      }

      return $this->deliveryCountries;
   }

   /**
    *
    * Jest dostawa domyślna?
    *
    * @return bool
    */
   public function hasDefaultDelivery()
   {
      return (bool) $this->getDefaultDelivery();
   }

   /**
    *
    * Są dostawy?
    *
    * @return bool
    */
   public function hasDeliveries()
   {
      $deliveries = $this->getDeliveries();

      return!empty($deliveries);
   }

   /**
    * Sprawdza czy dostawy nie wykluczają się wzajemnie
    *
    * @return boolean
    */
   public function hasValidAllowCriteria()
   {
      $this->getDeliveries();

      return false !== $this->allow && !empty($this->allow);
   }

   /**
    *
    * Zwraca łączny koszt dostawy
    *
    * @return float
    */
   public function getTotalDeliveryCost($with_tax = false, $with_currency = false)
   {
      $total_amount = 0.00;

      $delivery = $this->getDefaultDelivery();

      if ($delivery)
      {
         $total_amount += $delivery->getTotalCost($with_tax, $with_currency);

         $payment = $delivery->getDefaultPayment();

         if ($payment)
         {

            if ($delivery->isFree() && $payment->isFree())
            {
               return 0.00;
            }

            $total_amount += $payment->getCost($with_tax, $with_currency);
         }
      }

      return $total_amount > 0 ? $total_amount : 0.00;
   }

   /**
    * Pobiera domyslna dostawe
    *
    * @return stDeliveryFrontendContainer
    */
   public function getDefaultDelivery()
   {
      if (null === $this->delivery)
      {
         $deliveries = $this->getDeliveries();

         $default = $this->getUser()->getAttribute('delivery', null, self::SESSION_NAMESPACE);

         $defaultDelivery = null;

         foreach ($deliveries as $delivery)
         {
            if (null === $defaultDelivery && $delivery->getDelivery()->getIsDefault())
            {
               $defaultDelivery = $delivery;
            }

            if ($default)
            {
               if ($default == $delivery->getId())
               {
                  $this->setDefaultDelivery($delivery);
                  break;
               }
            }
            elseif ($delivery->getDelivery()->getIsDefault())
            {
               $this->setDefaultDelivery($delivery);
               break;
            }
            
         }

         if (null === $this->delivery && !empty($deliveries))
         {
            $this->setDefaultDelivery($defaultDelivery ? $defaultDelivery : current($deliveries));
         }
      }

      return $this->delivery;
   }

   /**
    * Pobiera domyslny kraj dostawy
    *
    * @return stDeliveryCountryFrontendContainer
    */
   public function getDefaultDeliveryCountry()
   {
      if (is_null($this->deliveryCountry))
      {
         $countries = $this->getDeliveryCountries();

         $default = $this->getUser()->getAttribute('delivery_country', null, self::SESSION_NAMESPACE);

         foreach ($countries as $country)
         {
            if ($default)
            {
               if ($default == $country->getId())
               {
                  $this->setDefaultDeliveryCountry($country);

                  break;
               }
            }
            else
            {
               if ($country->getDeliveryCountry()->getIsDefault())
               {
                  $this->setDefaultDeliveryCountry($country);

                  break;
               }
            }
         }

         if (is_null($this->deliveryCountry) && !empty($countries))
         {
            $this->setDefaultDeliveryCountry(current($countries));
         }
      }

      return $this->deliveryCountry;
   }

   /**
    *
    * Ustawia kryteria filtrowania dla dostaw - podstawowe kryteria filtrowania
    *
    * @param Criteria $c
    */
   protected function setBaseFilterCriteria($c)
   {
      $c->add(DeliveryPeer::ACTIVE, true);

      $this->dispatcher->notify(new sfEvent($this, 'stDeliveryFrontend.postSetBaseFilterCriteria', array('criteria' => $c)));
   }

   /**
    * Ustawia kryteria filtrowania dla dostaw - krytuje filtrowania wedlug domyslnego kraju
    */
   protected function setCountriesFilterCriteria($c)
   {
      if ($this->getDefaultDeliveryCountry())
      {      
         $ca = new Criteria();
         $ca->addSelectColumn(CountriesAreaPeer::ID);
         $ca->addJoin(CountriesAreaHasCountriesPeer::COUNTRIES_AREA_ID, CountriesAreaPeer::ID);
         $ca->add(CountriesAreaHasCountriesPeer::COUNTRIES_ID, $this->getDefaultDeliveryCountry()->getId());
         $ca->add(CountriesAreaPeer::IS_ACTIVE, true);
         $rs = CountriesAreaPeer::doSelectRS($ca);

         while($rs->next()) 
         {
            $row = $rs->getRow();
            $ids[] = $row[0];
         }

         $c->add(DeliveryPeer::COUNTRIES_AREA_ID, $ids, Criteria::IN); 
      }
   }

   /**
    *
    * Ustawia kryteria filtrowania dla dostaw - maksymalne wartości zamówienia
    *
    * @param Criteria $c
    */
   public function setMaxFilterCriteria($c)
   {
      if (!$this->basket->isEmpty())
      {
         $totals = $this->getBasketTotals();

         $query = '((%1$s = 0 OR %1$s <= %3$s) AND (%2$s = 0 OR %2$s >= %3$s))';

         $c->add(DeliveryPeer::MAX_ORDER_AMOUNT, sprintf($query, DeliveryPeer::MIN_ORDER_AMOUNT, DeliveryPeer::MAX_ORDER_AMOUNT, $totals['amount']), Criteria::CUSTOM);

         $c->add(DeliveryPeer::MAX_ORDER_QUANTITY, sprintf($query, DeliveryPeer::MIN_ORDER_QUANTITY, DeliveryPeer::MAX_ORDER_QUANTITY, $totals['quantity']), Criteria::CUSTOM);

         $c->add(DeliveryPeer::MAX_ORDER_WEIGHT, sprintf($query, DeliveryPeer::MIN_ORDER_WEIGHT, DeliveryPeer::MAX_ORDER_WEIGHT, $totals['weight']), Criteria::CUSTOM);

         $cc = null;  

         if (!$this->allow && $this->config->get('alternate_deliveries'))
         {
            $this->allow = $this->config->get('alternate_deliveries');
         }

         if ($this->allow)
         {
            $c->add(DeliveryPeer::ID, $this->allow, Criteria::IN);
         }
         else
         {
            $c->add(DeliveryPeer::ALLOW_IN_SELECTED_PRODUCTS, false);
         }

         // if ($this->exclude)
         // {
         //    $ec = $c->getNewCriterion(DeliveryPeer::ID, $this->exclude, Criteria::NOT_IN);

         //    if ($cc)
         //    {
         //       $cc->addAnd($ec);
         //    }
         //    else
         //    {
         //       $cc = $ec;
         //    }
         // }

         // if ($cc)
         // {
         //    $c->add($cc);
         // } 

         $c1 = $c->getNewCriterion(DeliveryPeer::VOLUME, 0);

         $ids = DeliveryPeer::retrieveIdsFor($totals, $c);

         if ($ids)
         {
            $c1->addOr($c->getNewCriterion(DeliveryPeer::ID, $ids, Criteria::IN));          
         }

         $c2 = $c->getNewCriterion(DeliveryPeer::TYPE_ID, null, Criteria::ISNULL);
         $c2->addAnd($c->getNewCriterion(DeliveryPeer::WIDTH, $totals['width'], Criteria::GREATER_EQUAL));
         $c2->addAnd($c->getNewCriterion(DeliveryPeer::HEIGHT, $totals['height'], Criteria::GREATER_EQUAL));
         $c2->addAnd($c->getNewCriterion(DeliveryPeer::DEPTH, $totals['depth'], Criteria::GREATER_EQUAL));
         $c2->addAnd($c->getNewCriterion(DeliveryPeer::VOLUME, $totals['volume'], Criteria::GREATER_EQUAL)); 

         $c1->addOr($c2);           

         $c->add($c1);

         if ($this->config->get('alternate_deliveries') && !DeliveryPeer::doCount($c))
         {
            $c->remove(DeliveryPeer::MAX_ORDER_AMOUNT);
            $c->remove(DeliveryPeer::MAX_ORDER_QUANTITY);
            $c->remove(DeliveryPeer::MAX_ORDER_WEIGHT); 
            $c->remove($c1);           
         }
      }
   }

   /**
    *
    * Pobiera maksymalną dozwoloną kwotę zamówienia
    *
    * @return float
    */
   public function getMaxOrderAmount()
   {
      if (is_null($this->maxOrderAmount))
      {
         $this->maxOrderAmount = $this->getValueByColumn(DeliveryPeer::MAX_ORDER_AMOUNT);
      }

      return $this->maxOrderAmount;
   }

   public function getMinOrderAmount()
   {
      if (is_null($this->minOrderAmount))
      {
         $this->minOrderAmount = $this->getValueByColumn(DeliveryPeer::MIN_ORDER_AMOUNT, false);
      }

      return $this->minOrderAmount;
   }

   /**
    *
    * Pobiera maksymalną dozwoloną wagę zamówienia
    *
    * @return float
    */
   public function getMaxOrderWeight()
   {
      if (is_null($this->maxOrderWeight))
      {
         $this->maxOrderWeight = $this->getValueByColumn(DeliveryPeer::MAX_ORDER_WEIGHT);
      }

      return $this->maxOrderWeight;
   }

   public function getMinOrderWeight()
   {
      if (is_null($this->minOrderWeight))
      {
         $this->minOrderWeight = $this->getValueByColumn(DeliveryPeer::MIN_ORDER_WEIGHT, false);
      }

      return $this->minOrderWeight;
   }

   /**
    *
    * Pobiera maksymlaną dozwoloną ilość sztuk w zamówieniu
    *
    * @return integer
    */
   public function getMaxOrderQuantity()
   {
      if (is_null($this->maxOrderQuantity))
      {
         $this->maxOrderQuantity = $this->getValueByColumn(DeliveryPeer::MAX_ORDER_QUANTITY);
      }

      return $this->maxOrderQuantity;
   }

   public function getMinOrderQuantity()
   {
      if (is_null($this->minOrderQuantity))
      {
         $this->minOrderQuantity = $this->getValueByColumn(DeliveryPeer::MIN_ORDER_QUANTITY, false);
      }

      return $this->minOrderQuantity;
   }

   protected function getValueByColumn($column, $max = true)
   {
      $con = Propel::getConnection();

      $c = new Criteria();

      if ($max)
      {
         $c->addAsColumn('max_value', sprintf('MAX(%s)', $column));
      }
      else
      {
         $c->addAsColumn('max_value', sprintf('MIN(%s)', $column));
      }

      $this->setBaseFilterCriteria($c);

      $this->setCountriesFilterCriteria($c);

      $rs = BasePeer::doSelect($c, $con);

      return $rs->next() ? $rs->get(1) : 0;
   }

   public function getBasketTotals()
   {
      if (null === $this->basketTotals)
      {
         $amount = 0;
         $weight = 0;
         $quantity = 0;
         $height = 0;
         $width = 0;
         $depth = 0;
         $volume = 0;
         $delivery_price = 0;
         $amount_with_currency = 0;
         $availabe_ids = array_values(DeliveryPeer::retrieveAllowedIdsCached());
         $this->allow = $availabe_ids;
         $this->exclude = array();

         $dids = DeliveryPeer::retrieveIdsCached();
                  
         $currency = stCurrency::getInstance(sfContext::getInstance())->get();

         $modified = false;

         foreach ($this->basket->getItems() as $item)
         {
            $total_amount = $item->getTotalAmount(true, true);
            $amount_with_currency += $total_amount;
            $amount += $currency->exchange($total_amount, true);
            $weight += $item->getTotalWeight();
            $quantity += $item->getQuantity();
            $product_width = $item->getWidth();
            $product_height = $item->getHeight();
            $product_depth = $item->getDepth();
            $delivery_price += $item->getTotalDeliveryPrice();

            if ($width < $product_width)
            {
               $width = $product_width;
            }

            if ($height < $product_height)
            {
               $height = $product_height;
            }

            if ($depth < $product_depth)
            {
               $depth = $product_depth;
            }

            $volume += $item->getTotalVolume();

            $deliveries = $item->getProduct()->getDeliveries();

            if (!$deliveries || !$deliveries['ids'])
            {
               $deliveries = array('mode' => 'allow', 'ids' => $availabe_ids);
            }

            if ($deliveries)
            {
               if ($deliveries['ids'])
               {
                  $ids = array_intersect($dids, $deliveries['ids']);

                  if ($deliveries['mode'] == 'allow' && false !== $this->allow && $ids)
                  {  
                     $this->allow = $this->allow && $modified ? array_intersect($this->allow, $ids) : $ids;
                     $modified = true;
                  } 
                  elseif ($deliveries['mode'] == 'exclude' && $this->allow)
                  {
                     $this->allow = array_intersect($this->allow, array_diff($availabe_ids, $ids));
                     $modified = true;
                  }
               }
            }

            if (!$this->allow)
            {
               $this->allow = false;
            }
         }

         $this->basketTotals = array(
            'amount_with_currency' => $amount_with_currency,
            'amount' => $amount,
            'weight' => $weight,
            'quantity' => $quantity,
            'width' => $width,
            'height' => $height,
            'depth' => $depth,
            'volume' => $volume,
            'delivery_price' => $delivery_price,
         );
      }

      return $this->basketTotals;
   }

   /**
    *
    * Metoda pomocnicza - Zwraca rozszerzony obiekt Delivery
    *
    * @param DeliveryHasPaymentType $delivery_payment
    * @return stDeliveryFrontendContainer Obiekt rozszerzony
    */
   protected function deliveryCallback($delivery)
   {
      $delivery = new stDeliveryFrontendContainer($this, $delivery);

      return $delivery;
   }

   protected function deliveryCountryCallback($delivery_country)
   {
      $delivery_country = new stDeliveryCountryFrontendContainer($this, $delivery_country);

      return $delivery_country;
   }

   /**
    *
    * Pobiera rozszerzoną dostawę na podstawie id
    *
    * @param integer $id Id dostawy
    * @return stDeliveryFrontendContainer Rozszerzona dostawa
    */
   protected function getDeliveryById($id)
   {
      $deliveries = $this->getDeliveries();

      foreach ($deliveries as $delivery)
      {
         if ($delivery->getId() == $id)
         {
            return $delivery;
         }
      }

      return null;
   }

   /**
    *
    * Pobiera kraj dostawy na podstawie id
    *
    * @param integer $id Id dostawy
    * @return stDeliveryCountryFrontendContainer Kraj dostawy
    */
   protected function getCountryById($id)
   {
      $delivery_countries = $this->getDeliveryCountries();

      foreach ($delivery_countries as $delivery_country)
      {
         if ($delivery_country->getId() == $id)
         {
            return $delivery_country;
         }
      }

      return null;
   }

}

/**
 * Kontener rozszerzający funkcjonalność modelu Delivery
 *
 * @see Delivery
 */
class stDeliveryFrontendContainer
{
   protected
      $delivery = null,
      $deliveryPayments = null,
      $deliveryPayment = null,
      $deliveryFrontend = null,
      $additionalCost = null;

   /**
    * Zwraca orginalny obiekt dostawy
    *
    * @return Delivery
    */
   public function getDelivery()
   {
      return $this->delivery;
   }

   public function __construct($delivery_frontend, $delivery)
   {
      $this->delivery = $delivery;

      $this->deliveryFrontend = $delivery_frontend;
   }

   public function getAdditionalCost($with_tax = false, $with_currency = false)
   {
      if ($this->isFree())
      {
         return 0.00;
      }

      if (is_null($this->additionalCost))
      {
         $basket = $this->deliveryFrontend->getBasket();

         $type = $this->delivery->getSectionCostType();

         $c = new Criteria();

         switch ($type)
         {
            case "ST_BY_ORDER_AMOUNT":
               $value = $basket->getTotalAmount(true, false, false);
               break;
            case "ST_BY_ORDER_QUANTITY":
               $value = $basket->getTotalProductQuantity();
               break;
            case "ST_BY_ORDER_WEIGHT":
               $value = $basket->getTotalProductWeight();
               break;
            default:
               $value = 0;
               break;
         }

         if ($type)
         {
            $c->add(DeliverySectionsPeer::VALUE_FROM, $value, Criteria::LESS_EQUAL);
            
            $c->setLimit(1);

            $c->addDescendingOrderByColumn(DeliverySectionsPeer::VALUE_FROM);

            $tmp = $this->getDeliverySectionss($c);

            $this->additionalCost = isset($tmp[0]) ? $tmp[0] : 0.00;
         }
         else
         {
            $this->additionalCost = 0.00;
         }
      }

      if (is_object($this->additionalCost))
      {
         if ($with_tax)
         {
            $cost = $this->additionalCost->getCostBrutto($with_currency);
         }
         else
         {
            $cost = $this->additionalCost->getCostNetto($with_currency);
         }
      }
      else
      {
         $cost = $this->additionalCost;
      }

      return $cost;
   }

   /**
    *
    * Zwraca aktualnego użytkownika
    *
    * @return stUser
    */
   public function getUser()
   {
      return $this->deliveryFrontend->getUser();
   }

   public function getDefaultCost($with_tax = false, $with_currency = false)
   {
      if ($this->isFree())
      {
         return '0.00';
      }

      if ($with_tax)
      {
         $cost = $this->delivery->getCostBrutto($with_currency);
      }
      else
      {
         $cost = $this->delivery->getCostNetto($with_currency);
      }

      return $cost;
   }

   public function getTotalCost($with_tax = false, $with_currency = false)
   {
      $totals = $this->deliveryFrontend->getBasketTotals();

      if (!$this->isFree()) 
      {
         $price_type = stConfig::getInstance('stProduct')->get('delivery_price_type', 'netto');
         
         if ($price_type == 'netto' && $with_tax) 
         {  
            $delivery_price = stPrice::calculate($totals['delivery_price'], $this->delivery->getTax()->getVat());
         } 
         elseif ($price_type == 'brutto' && !$with_tax) 
         {
            $delivery_price = stPrice::extract($totals['delivery_price'], $this->delivery->getTax()->getVat());
         }
         else 
         {
            $delivery_price = $totals['delivery_price'];
         }
      } 
      else 
      {
         $delivery_price = 0;
      }

      if ($with_currency)
      {
         $delivery_price = stCurrency::exchange($delivery_price);
      }

      return $this->getDefaultCost($with_tax, $with_currency) + $this->getAdditionalCost($with_tax, $with_currency) + $delivery_price;
   }

   /**
    *
    * Jest darmowa?
    *
    * @return bool
    */
   public function isFree()
   {
      $free_from = stCurrency::exchange($this->delivery->getFreeFrom());

      $basket = $this->deliveryFrontend->getBasket();

      $discount = $basket->getDiscount();

      $basket->setDiscount(false);

      $total_amount = $basket->getTotalAmount(true, true);

      $basket->setDiscount($discount);

      return $free_from > 0 && $total_amount >= $free_from;
   }

   /**
    *
    * Jest domyślna?
    *
    * @return bool
    */
   public function getIsDefault()
   {
      $delivery = $this->deliveryFrontend->getDefaultDelivery();

      if ($delivery)
      {
         return $delivery->getId() == $this->delivery->getId();
      }

      return $this->delivery->getIsDefault();
   }

   /**
    *
    * Zwraca listę płatności dostawy
    *
    * @return array Of stDeliveryPaymentFrontendContainer
    */
   public function getDeliveryPayments()
   {
      if (is_null($this->deliveryPayments))
      {
         $c = new Criteria();

         $this->setFilterCriteria($c);

         $this->deliveryPayments = DeliveryHasPaymentTypePeer::doSelect($c);

         $this->deliveryPayments = array_filter($this->deliveryPayments, array($this, 'paymentFilterCallback'));

         $this->deliveryPayments = array_map(array($this, 'paymentCallback'), $this->deliveryPayments);
      }
      
      return $this->deliveryPayments;
   }

   /**
    *
    * Ustawia kryteria filtrowania dla płatności
    *
    * @param Criteria $c
    */
   protected function setFilterCriteria($c)
   {
      $c->add(DeliveryHasPaymentTypePeer::DELIVERY_ID, $this->getId());

      $c->add(DeliveryHasPaymentTypePeer::IS_ACTIVE, true);

      $c->addAscendingOrderByColumn(DeliveryHasPaymentTypePeer::ID);
   }

   /**
    *
    * Są płatności?
    *
    * @return bool
    */
   public function hasDeliveryPayments()
   {
      $delivery_payments = $this->getDeliveryPayments();

      return!empty($delivery_payments);
   }

   /**
    *
    * @return stDeliveryPaymentFrontendContainer
    */
   public function getDefaultPayment()
   {
      if (null === $this->deliveryPayment)
      {
         $payments = $this->getDeliveryPayments();

         $default = $this->getUser()->getAttribute('delivery_payment', null, stDeliveryFrontend::SESSION_NAMESPACE);

         $defaultPayment = null;

         foreach ($payments as $payment)
         {
            if ($payment->getDeliveryPayment()->getIsDefault())
            {
               $defaultPayment = $payment;
            }

            if ($default)
            {
               if ($default == $payment->getId())
               {
                  $this->setDefaultPayment($payment);

                  break;
               }
            }
            elseif ($defaultPayment)
            {
                  $this->setDefaultPayment($payment);

                  break;
            }
         }

         if (null === $this->deliveryPayment && !empty($payments))
         {
            $this->setDefaultPayment($defaultPayment ? $defaultPayment : current($payments));    
         }
      }

      return $this->deliveryPayment;
   }

   /**
    *
    * Ustawia domyślną płatność
    *
    * @param mixed $delivery_payment Id lub rozszerzony obiekt płatności
    */
   public function setDefaultPayment($delivery_payment, $saveToSession = true)
   {
      if ($delivery_payment)
      {
         if (!is_object($delivery_payment))
         {
            $this->deliveryPayment = $this->getPaymentById($delivery_payment);
         }
         else
         {
            $this->deliveryPayment = get_class($delivery_payment) != 'stDeliveryPaymentFrontendContainer' ? $this->paymentCallback($delivery_payment) : $delivery_payment;
         }

         if ($saveToSession)
         {
            $this->getUser()->setAttribute('delivery_payment', $this->deliveryPayment ? $this->deliveryPayment->getId() : null, stDeliveryFrontend::SESSION_NAMESPACE);
         }
      }
   }

   /**
    *
    * Wykonuje metody obiektu Delivery nie występujące w stDeliveryFrontendContainer
    *
    * @param string $name Nazwa metody
    * @param array $arguments Argumenty metody
    * @return mixed
    */
   public function __call($name, $arguments)
   {
      return call_user_func_array(array($this->delivery, $name), $arguments);
   }

   protected function paymentFilterCallback($delivery_payment)
   {
      $payment = $delivery_payment->getPayment();
      return $payment && $payment->getActive() && $payment->checkPaymentConfiguration() && (!$payment->getHideForWholesale() || $payment->getHideForWholesale() && !stWholesalePluginListener::getWholesaleType());
   }

   /**
    *
    * Metoda pomocnicza - Zwraca rozszerzony obiekt DeliveryHasPaymentType
    *
    * @param DeliveryHasPaymentType $delivery_payment
    * @return stDeliveryPaymentFrontendContainer Obiekt rozszerzony
    */
   protected function paymentCallback($delivery_payment)
   {
      $delivery_payment = new stDeliveryPaymentFrontendContainer($this->deliveryFrontend, $delivery_payment);

      $delivery_payment->setDelivery($this);

      return $delivery_payment;
   }

   /**
    *
    * Pobiera rozszerzony obiekt stDeliveryPaymentFrontendContainer na podstawie id
    *
    * @param integer $id
    * @return stDeliveryPaymentFrontendContainer
    */
   protected function getPaymentById($id)
   {
      $payments = $this->getDeliveryPayments();

      foreach ($payments as $payment)
      {
         if ($payment->getId() == $id)
         {
            return $payment;
         }
      }

      return null;
   }

}

/**
 * Kontener rozszerzający funkcjonalność modelu DeliveryHasPaymentType
 *
 * @see DeliveryHasPaymentType
 */
class stDeliveryPaymentFrontendContainer
{

   protected 
      $deliveryPayment = null,
      $deliveryFrontend = null;

   public function __construct($delivery_frontend, $delivery_payment)
   {
      $this->deliveryPayment = $delivery_payment;

      $this->deliveryFrontend = $delivery_frontend;
   }

   /**
    * Zwraca orginalny obiekt platnosci dostawt
    *
    * @return DeliveryHasPaymentType
    */
   public function getDeliveryPayment()
   {
      return $this->deliveryPayment;
   }

   public function getId()
   {
      return $this->getPayment() ? $this->getPayment()->getId() : null;
   }

   public function getSocketName()
   {
      return $this->getPayment() ? 'stPayment_show_'.$this->getPayment()->getModuleName().'_info' : null;
   }

   public function getSocketNameExists($type = 'component')
   {
      return (bool) array_key_exists($this->getSocketName(), sfConfig::get('st_socket_'.$type));
   }

   public function getName()
   {
      return $this->getPayment() ? $this->getPayment()->getName() : '';
   }

   public function getDescription()
   {
      return $this->getPayment() ? $this->getPayment()->getDescription() : '';
   }

   public function getCost($with_tax = false, $with_currency = false)
   {
      if ($this->isFree())
      {
         return '0.00';
      }

      if ($this->deliveryPayment->getCostType() == '%')
      {
         $totals = $this->deliveryFrontend->getBasketTotals();

         $total_amount = $this->deliveryFrontend->getDefaultDelivery()->getTotalCost($with_tax, $with_currency) + ($with_currency ? $totals['amount_with_currency'] : $totals['amount']);

         $cost = stPrice::percentValue($total_amount, $this->deliveryPayment->getCost());
      }
      elseif ($with_tax)
      {
         $cost = $this->deliveryPayment->getCostBrutto($with_currency);
      }
      else
      {
         $cost = $this->deliveryPayment->getCostNetto($with_currency);
      }

      return $cost;
   }

   public function isFree()
   {
      $free_from = $this->deliveryPayment->getFreeFrom();

      $total_amount = $this->deliveryFrontend->getBasket()->getTotalAmount(true);

      return $free_from > 0 && $total_amount >= $free_from;
   }

   public function getIsDefault()
   {
      $deliveryPayment = $this->deliveryFrontend->getDefaultDelivery()->getDefaultPayment();

      if ($deliveryPayment)
      {
         return $deliveryPayment->getId() == $this->getId();
      }

      return $this->deliveryPayment->getIsDefault();
   }

   public function __call($name, $arguments)
   {
      return call_user_func_array(array($this->deliveryPayment, $name), $arguments);
   }

}

/**
 * Kontener rozszerzający funkcjonalność modelu Countries
 *
 * @see DeliveryHasPaymentType
 */
class stDeliveryCountryFrontendContainer
{

   protected 
      $deliveryCountry = null,
      $deliveryFrontend = null;

   public function __construct($delivery_frontend, $delivery_country)
   {
      $this->deliveryCountry = $delivery_country;

      $this->deliveryFrontend = $delivery_frontend;
   }

   /**
    * Zwraca orginalny obiekt kraju dostawy
    *
    * @return Countires
    */
   public function getDeliveryCountry()
   {
      return $this->deliveryCountry;
   }

   public function getIsDefault()
   {
      $delivery_country = $this->deliveryFrontend->getDefaultDeliveryCountry();

      if ($delivery_country)
      {
         return $delivery_country->getId() == $this->deliveryCountry->getId();
      }

      return $this->deliveryCountry->getIsDefault();
   }

   public function __call($name, $arguments)
   {
      return call_user_func_array(array($this->deliveryCountry, $name), $arguments);
   }

}