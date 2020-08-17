<?php

/**
 * SOTESHOP/stBasket
 *
 * Ten plik należy do aplikacji stBasket opartej na licencji (Professional License SOTE).
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stBasket
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stBasket.class.php 17077 2012-02-13 07:40:25Z marcin $
 */

/**
 * Klasa zarządzająca koszykami w sklepie
 *
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 *
 * @package     stBasket
 * @subpackage  libs
 */
class stBasket
{
   /**
    * Przestrzeń nazw dla sesji
    * @var const
    */
   const SESSION_NAMESPACE = 'soteshop/stBasket';

   const ERR_OUT_OF_STOCK = -1;
   
   const ERR_MIN_QTY = -2;
   
   const ERR_POINTS = -3;

   const ERR_MAX_QTY = -4;

   /**
    * Basket model instance
    *
    * @var Basket $basket
    */
   protected $basket = null;

   protected $items = null;

   protected
      $user = null,
      $dispatcher = null,
      $productConfig = null,
      $couponCode = null,
      $basketConfig = null,
      $lastAddedItems = array(),
      $totalTaxAmount = array(),
      $totalAmount = array(),
      $totalWeight = null,
      $totalQuantity = null,
      $discountConfig = null,
      $giftItem = null,
      $discount = null;
   protected static $instance = null;

   /**
    * Zwraca instancje obiektu
    *
    * @return     stBasket    object
    */
   public static function getInstance(sfGuardSecurityUser $user)
   {
      if (!isset(self::$instance))
      {
         $class = __CLASS__;
         self::$instance = new $class();
         self::$instance->initialize($user);
      }

      return self::$instance;
   }

   /**
    * Zwraca obiekt do obsługi zdarzeń
    *
    * @return   stEventDispatcher
    */
   public function getDispatcher()
   {
      return $this->dispatcher;
   }

   public function getContext()
   {
      return $this->user->getContext();
   }

   /**
    * Incjalizuje koszyk
    *
    * @param   sfGuardSecurityUser $user
    */
   public function initialize(sfGuardSecurityUser $user)
   {
      $this->user = $user;

      $this->dispatcher = stEventDispatcher::getInstance();

      if (!$this->user->hasAttribute('product_list', self::SESSION_NAMESPACE))
      {
         $this->user->setAttribute('product_list', array(), self::SESSION_NAMESPACE);
      }

      $this->basketConfig = stConfig::getInstance('stBasket');

      $this->productConfig = stConfig::getInstance('stProduct');

      $this->discountConfig = stConfig::getInstance('stDiscountBackend');
   }

   /**
    * Zapisuje zawartosc koszyka
    */
   public function save()
   {
      if ($this->basket)
      {
         $gift = $this->getGiftItem();

         if ($gift && !$gift->isDeleted())
         {

            $discount = $this->getDiscount();
            $this->setDiscount(false);
            $gift->setDeleted(true);
            $total_amount = $this->getTotalAmount(true);
            $gift->setDeleted(false);
            $this->setDiscount($discount);
            $this->clearProductTotals();
            // throw new Exception($total_amount);

            if (!$gift->getProduct() || !ProductGroupPeer::isGift($gift->getProduct(), $total_amount, true))
            {
               $gift->delete();
            }
         }
            
         $this->basket->save();

         $this->setBasketCookieId();
         
         self::clearCache();
      }
   }

   /**
    * Dodaje produkt do koszyka
    * Jesli dany produkt znajduje sie juz w koszyku zwieksza jego ilosc
    *
    * @param   integer     $id_product         ID produktu
    * @param   integer     $num                ilosc sztuk danego produktu - domyslnie 1
    */
   public function addItem($id, $quantity = 1, &$error = false, $updateQuantity = false)
   {
      $this->getDispatcher()->notify(new sfEvent($this, 'stBasket.preAddItem', array('id_product' => $id, 'num' => $quantity)));

      $item = $this->getItem($id);

      $themeVersion = sfContext::getInstance()->getController()->getTheme()->getVersion();

      if ($this->getGiftItem() && $this->getContext()->getRequest()->hasParameter('gift'))
      {
         return $this->getGiftItem();
      }

      $remove = false;

      if ($item)
      {
         
         if($item -> getProductForPoints() && $themeVersion < 7)
         {
            if(stPoints::getUnusedUserPoints() >= $item->getProduct()->getPointsValue())
            {
               $item->setQuantity($item->getQuantity() + $quantity);
            }
            else
            {
               if($item->getProduct()->getPointsOnly())
               {                   
                  $error =  self::ERR_POINTS;
               }
               else
               {
                  $item->setQuantity($item->getQuantity() + $quantity);
               }
            }
         }
         else
         {
            $item->setQuantity($item->getQuantity() + $quantity);
         }
      }
      else
      {

         if ($product = ProductPeer::retrieveByPK($id))
         {
            if(($product->getPointsOnly()==1 && $product->getPointsValue() > stPoints::getUnusedUserPoints()) && ($themeVersion < 7))
            {
               $error =  self::ERR_POINTS;
               $remove = true;
            }

            if ($this->getContext()->getRequest()->hasParameter('option_list'))
            {
               $option_list = $this->getContext()->getRequest()->getParameter('option_list');
               
               if ($option_list)
               {
                  $ids = explode('-', $option_list);
                  $options = ProductOptionsValuePeer::doSelectByIds($ids);
                  stNewProductOptions::updateProductBySelectedOptions($product, $options);                  
               }
            }
            
            $item = new BasketProduct();   
            
            $item->setProduct($product);
            
            if ($this->getContext()->getRequest()->getParameter('product_set_discount'))
            {
               $item->setProductSetDiscountId($this->getContext()->getRequest()->getParameter('product_set_discount'));
            }
            
            if ($this->getContext()->getRequest()->hasParameter('gift'))
            {
               $item->setIsGift(ProductGroupPeer::isGift($product));
            }
            elseif ($product->getIsGift())
            {
                return false;
            }

            $item = $this->populateItem($item, $product);

            if ($item->getIsGift())
            {
               $quantity = 1;
            }

            $item->setQuantity($quantity);

            $this->getDispatcher()->notify(new sfEvent($this, 'stBasket.modAddItem', array('product' => $product, 'item' => $item)));

            $this->get()->addBasketProduct($item, true);

            if (!isset($this->items[$item->getItemId()]))
            {
               $this->items[$item->getItemId()] = $item;
            }

            self::setPointsOnlyProduct($item);

            $product->resetModified();
         }
         else
         {
            return false;
         }
      }
      
      $previous_quantity = $item->getQuantity() - $quantity;

      $this->getDispatcher()->notify(new sfEvent($this, 'stBasket.postAddItem', array('item' => $item)));
      
      if (false === $error)
      {
         $error = $this->validateQuantity($item, $updateQuantity);
      }
      
      $quantity = $item->getQuantity() - $previous_quantity;

      $this->lastAddedItems[$item->getItemId()] = array(
         'item' => $item, 
         'quantity' => $quantity > 0 ? $quantity : 0,
         'error_code' => $error
      );
      
      if ($error && $remove)
      {
        $this->removeItem($item->getItemId());
        $this->save();
        $this->refresh($item->getItemId());
      }
      
      $this->clearProductTotals();

      return $item;
   }

   public function getlastAddedItems()
   {
      return $this->lastAddedItems;
   }

   public function updateItem($id, $quantity, &$error = false, $updateQuantity = false)
   {
      $themeVersion = sfContext::getInstance()->getController()->getTheme()->getVersion();

      $item = $this->getItem($id);

      if ($this->getGiftItem() && $this->getContext()->getRequest()->hasParameter('gift'))
      {
         return $this->getGiftItem();
      }

      if ($item)
      {
         $error = false; 
         if($item -> getProductForPoints() && ($themeVersion < 7)){
           
           $new_qty = $quantity-$item->getQuantity();
           
           $add_points_value = $new_qty * $item->getProduct()->getPointsValue();
           
           if(stPoints::getUnusedUserPoints() >= $add_points_value){
                $item->setQuantity($quantity);   
           }else{
               if($item->getProduct()->getPointsOnly()){                   
                    $error =  self::ERR_POINTS;
               }else{
                   $item->setQuantity($quantity);
                   stPoints::refreshLoginStatusPoints();
               }
           }
             
         }else{
            $item->setQuantity($quantity);
            
         }
           
      }
      else
      {
         return false;
      }

      if (false === $error)
      {
         $error = $this->validateQuantity($item, $updateQuantity);
      }

      $this->clearProductTotals();

      return $item;
   }

   /**
    * Usuwa produkt o danym ID z koszyka
    *
    * @param   integer     $id_product         ID produktu
    */
   public function removeItem($id)
   {
      $item = $this->getItem($id);

      $themeVersion = sfContext::getInstance()->getController()->getTheme()->getVersion();

      if(is_object($item)){
          
          if((stPoints::isItemByPoints($item->getItemId()) && ($themeVersion < 7))){
              stPoints::removeItemByPoints($item->getItemId());
              $value = stPoints::getLoginStatusPoints() + ($item -> getProduct() -> getPointsValue() * $item -> getQuantity());
              stPoints::setLoginStatusPoints($value);
          }
          
          $item->delete();  
      } 

      $this->clearProductTotals();
   }

   public function setDiscount($discount)
   {
      $this->discount = $discount;
      $this->clearProductTotals();
   }

   public function getDiscount()
   {
      return $this->discount;
   }

   public function hasDiscount()
   {
      if (null === $this->discount)
      {
         stDiscount::updateBasketDiscount($this); 
      }

      return $this->discount;
   }

   /**
    * Zwraca wszystkie produkty z koszyka w postaci tablicy modelów BasketProduct
    *
    * @return   array
    */
   public function getItems()
   {
      if (null === $this->items)
      {
         $ids = BasketProductPeer::doSelectProductIds($this->get());

         if ($this->getCouponCode())
         {
            stDiscount::updateDiscountCouponCodeProductIds($this->getCouponCode(), $ids);
         }
         
         DiscountPeer::setProductBatchIds($ids);

         $c = new Criteria();

         $c->addAscendingOrderByColumn(BasketProductPeer::ID);

         $this->items = array();

         foreach ($this->get()->getBasketProductsJoinProduct($c) as $item)
         {
            $this->items[$item->getItemId()] = $item;
         }
      }

      return $this->items;
   }

   public function refresh($item_id = null)
   {
       if (null === $item_id)
       {
          $coupon_code = $this->getCouponCode();
    
          if ($coupon_code && !$coupon_code->isValid())
          {
             $this->setCouponCode(null);
          }
      }

      $this->get()->clearCollBasketProducts();

      $this->items = null;

      foreach ($this->getItems() as $item)
      {
         if (!$item->getProduct() || $item_id !== null && $item->getItemId() != $item_id)
            continue;

         $image = null;
         $product = $item->getProduct();

         $ids = array();

         $custom_modifiers = array();

         $item->updateVatEu();

         foreach ($item->getPriceModifiers() as $pm)
         {
            if (isset($pm['custom']['type']) && $pm['custom']['type'] == 'product_options' || isset($pm['type']) && $pm['type'] == 'product_options')
            {
               $ids[$pm['custom']['id']] = $pm['custom']['id'];
            }
            else
            {
               $custom_modifiers[] = $pm;
            }
         }

         if ($item->getProduct()->getOptHasOptions() > 1)
         {
            // ProductOptionsValue::setProductPool($product);

            $options = $item->getProductOptions();
            
            if ($options)
            {
               stNewProductOptions::updateProductBySelectedOptions($product, $options);
            }
            else
            {
               $item->setProduct(null);
            }
         }

         $this->populateItem($item, $product);

         if ($custom_modifiers)
         {
            foreach ($custom_modifiers as $pm)
            {
               if (isset($pm['label']))
               {
                  $pm['custom']['label'] = $pm['label'];
               }

               $item->addPriceModifier($pm['value'], $pm['type'], $pm['prefix'], $pm['level'], $pm['custom']);
            }
         }
         
         $this->dispatcher->notify(new sfEvent($this, 'stBasket.refresh', array('item' => $item, 'product' => $item->getProduct())));
      }

      $this->clearProductTotals();

      $this->needRefresh(false);
   }

   /**
    * Zwraca produkt o danych ID
    *
    * @param   integer     $id_product         ID produktu
    * @return   object
    */
   public function getItem($id)
   {
      $id = stBasket::generateItemId($id);

      $items = $this->getItems();

      return isset($items[$id]) ? $items[$id] : null;
   }

   /**
    * Zwraca ID klienta
    *
    * @return   integer
    */
   public function getUserId()
   {
      if ($this->user->isAuthenticated())
      {
         return $this->user->getGuardUser()->getId();
      }

      return false;
   }

   /**
    * Zwraca instancje modelu DiscountCouponCode
    *
    * @return DiscountCouponCode
    */
   public function getCouponCode()
   {
      if (!$this->discountConfig->get('coupon_code'))
      {
         return null;
      }

      if (null === $this->couponCode)
      {
         $this->couponCode = $this->get()->getDiscountCouponCode();
      }

      return $this->couponCode;
   }

   public function setCouponCode($v)
   {
      $this->get()->setDiscountCouponCode($v);

      $this->couponCode = $v;
   }

   public function getUser()
   {
      return $this->user;
   }

   /**
    * Pobierz laczna sume produktow w koszyku
    *
    * @param   bool        $with_tax           Uwzględnij podatek
    * @param   bool        $with_currency      Uwzględnij walute
    * @return   suma
    */
   public function getTotalAmount($with_tax = false, $with_currency = false, $with_vat_eu = true, $with_discount = true)
   {
      $cache_id = $with_tax . '-' . $with_currency . '-' . $with_vat_eu . '-' .  $with_discount;

      if (!isset($this->totalAmount[$cache_id]))
      {
         $total_amount = 0;

         foreach ($this->getItems() as $item)
         {
            if ($item->isDeleted())
            {
                continue;
            }

            if (!$with_vat_eu)
            {
               $item->setVatEu(false);
            }

            $total_amount += $item->getTotalAmount($with_tax, $with_currency, $with_discount);

            $item->setVatEu($this->user->hasVatEu() || $this->user->hasVatEx());
         }

         if ($this->hasDiscount())
         {
            $total_amount = $this->getDiscount()->apply($total_amount);
         }

         $this->totalAmount[$cache_id] = $total_amount;
      }

      return $this->totalAmount[$cache_id];
   }

   /**
    * Pobierz laczna liczbę produktow w koszyku
    *
    * @return   integer
    */
    public function getTotalProductQuantity()
   {
      if (null === $this->totalQuantity)
      {
         $quantity = 0;

         foreach ($this->getItems() as $item)
         {
            $quantity += $item->getQuantity();
         }

         $this->totalQuantity = $quantity;
      }

      return $this->totalQuantity;
   }

   public function getTotalProductDiscountAmount($with_tax = false, $with_currency = false)
   {
      $discount = 0;

      $total_amount = 0;

      foreach ($this->getItems() as $item)
      {
         // $discount += $item->getTotalDiscountAmount($with_tax, $with_currency);
         $total_amount += $item->getTotalAmount($with_tax, $with_currency);
      }

      if ($this->hasDiscount())
      {
         $discount += $total_amount - $this->getDiscount()->apply($total_amount, $with_currency);
      }

      return $discount;    
   }

   /**
    *
    * Pobierz lączną wagę produktów w koszyku
    *
    * @return float
    */
   public function getTotalProductWeight()
   {
      if (null === $this->totalWeight)
      {
         $weight = 0;

         foreach ($this->getItems() as $item)
         {
            $weight += $item->getTotalWeight();
         }

         $this->totalWeight = $weight;
      }

      return $this->totalWeight;
   }

   public function getTotalProductTaxAmount($with_currency = false, $with_vat_eu = true)
   {
      if (!isset($this->totalTaxAmount[$with_currency][$with_vat_eu]))
      {
         $total = 0;

         foreach ($this->getItems() as $item) 
         {
            if (!$with_vat_eu)
            {
               $item->setVatEu(false);
            }

            $total += $item->getTotalTaxAmount($with_currency, $with_vat_eu);

            $item->setVatEu($this->user->hasVatEu() || $this->user->hasVatEx());
         }

         $this->totalTaxAmount[$with_currency][$with_vat_eu] = $total;
      }

      return $this->totalTaxAmount[$with_currency][$with_vat_eu];
   }      

   /**
    * Zmniejsza ilość produktu w koszyku.
    * Jeżeli ilość produktu wynosi jeden, usuwa produkt z koszyka
    *
    * @param   integer     $id_product         ID produktu
    * @param   integer     $num                ilosc odejmowanych sztuk danego produktu - domyslnie 1
    */
   public function decrease($id_product, $num = 1)
   {
      if ($item = $this->getItem($id_product))
      {
         $quantity = $item->getQuantity() - $num;

         $item->setQuantity($quantity);

         return $item->getQuantity();
      }

      return false;
   }

   /**
    * Deletes the current shopping cart
    */
   public function clear()
   {
      $this->deleteBasket($this->get());
   }

   /**
    * Clears all items in shopping cart
    */
   public function clearItems()
   {
      $themeVersion = sfContext::getInstance()->getController()->getTheme()->getVersion();
      foreach ($this->getItems() as $item)
      {
         if($item -> getProductForPoints() && $themeVersion < 7){ 
            stPoints::removeItemByPoints($item->getItemId());
         }
         $item->delete();
      }
      
      self::clearCache();
   }

   /**
    * Zwraca aktualny koszyk uzytkownika
    *
    * @param   bool        $create_default     Określa czy ma tworzyć domyślny koszyk, jeżeli żaden nie był wcześniej koszykiem domyślnym
    * @return   Basket
    */
   public function get($create_default = true)
   {
      if (null === $this->basket)
      {
         $basket_id = $this->getBasketCookieId();

         $user = $this->getUserId();

         $authenticated = $this->user->isAuthenticated() && $this->user->getGuardUser()->getIsConfirm();

         if ($basket_id || $authenticated)
         {
            if ($basket_id)
            {
               $this->basket = BasketPeer::retrieveByPK($basket_id);

               if ($this->basket)
               {
                  if ($authenticated && !$this->basket->countBasketProducts())
                  {
                     $this->basket = null;
                  }
                  elseif (null === $this->basket->getSfGuardUserId() && $authenticated)
                  {
                     $this->basket->setSfGuardUserId($user);
                     $this->basket->setIsDefault(true);
                     $this->refresh();
                     $this->save();
                  }
                  elseif ($this->basket->getSfGuardUserId() && !$authenticated && $this->needRefresh())
                  {
                     $this->refresh();
                     $this->save();
                  }
               }
               else
               {
                  $this->clearBasketCookieId();
               }
            }

            if (null === $this->basket && $authenticated)
            {
               $c = new Criteria();

               $c->add(BasketPeer::IS_DEFAULT, true);

               $c->add(BasketPeer::SF_GUARD_USER_ID, $user);

               $this->basket = BasketPeer::doSelectOne($c);

               if ($this->basket)
               {
                  $this->setBasketCookieId($this->basket->getId());
               }
            }
         }

         if (null === $this->basket && $create_default)
         {
            $this->basket = new Basket();

            if ($authenticated)
            {
               $this->basket->setSfGuardUserId($user);
            }

            $this->basket->setIsDefault(true);
         }

         if (null !== $this->basket->getDiscountCouponCodeId() && null === $this->basket->getDiscountCouponCode())
         {
            $this->setCouponCode(null);
            $this->refresh();
            $this->save();
         }         
      }

      return $this->basket;
   }
   
   public function needRefresh($needed = null)
   {
      if (null !== $needed) {
         $this->getUser()->setAttribute('refreshed', !$needed, self::SESSION_NAMESPACE);
      }

      return !$this->getUser()->getAttribute('refreshed', false, self::SESSION_NAMESPACE);
   }

   /**
    * Ustawia domyślny koszyk
    *
    * @param   mixed       $basket             Id koszyka lub instancja modelu Basket
    */
   public function set($basket)
   {
      if (!is_object($basket))
      {
         $basket = BasketPeer::retrieveByPK($basket);
      }

      if ($basket != null)
      {
         if ($prev_basket = $this->get(false))
         {
            $prev_basket->setIsDefault(false);

            $prev_basket->save();
         }
         $basket->setIsDefault(true);

         $basket->setSfGuardUserId($this->getUserId());

         $this->basket = $basket;

         $this->save();
      }
   }

   /**
    * Dodaje nowy koszyk
    *
    * @param   bool        $make_default       Określa czy dodany koszyk ma być ustawiony jako domyślny
    */
   public function addBasket($make_default = false)
   {
      $new_basket = new Basket();
      $new_basket->setSfGuardUserId($this->getUserId());

      if ($make_default)
      {
         $this->set($new_basket);
      }
      else
      {
         $new_basket->save();
      }
   }

   /**
    * Usuwa koszyk
    *
    * @param   mixed       $basket             Id koszyka lub instancja modelu Basket
    */
   public function deleteBasket($basket)
   {
      if (!is_object($basket))
      {
         $basket = BasketPeer::retrieveByPK($basket);
      }

      if ($this->get()->getId() == $basket->getId())
      {
         $this->basket = null;
      }

      $basket->delete();
      
      self::clearCache();
   }

   /**
    * Koszyk posiada produkty
    *
    * @return   bool
    */
   public function hasItems()
   {
      return (bool) $this->getItems();
   }

   /**
    * Koszyk jest pusty
    *
    * @return   bool
    */
   public function isEmpty()
   {
      return!$this->hasItems();
   }

   public function getGiftItem()
   {
      if (null === $this->giftItem)
      {
         $this->giftItem = false;

         foreach ($this->getItems() as $item) 
         {
            if ($item->getIsGift())
            {
               $this->giftItem = $item;
               break;
            }
         }
      }

      return $this->giftItem;
   }

   public function clearProductTotals()
   {
      $this->totalQuantity = null;
      $this->totalWeight = null;
      $this->totalAmount = array();
      $this->totalTaxAmount = array();
      stDeliveryFrontend::getInstance($this)->clearBasketTotals();  
   }

   /**
    *
    * @param Product $product
    * @return <type>
    */
   protected function populateItem(BasketProduct $item, Product $product)
   {
      $item->setName($product->getName());

      $item->setCode($product->getCode());

      $item->setBasePriceNetto($product->getBasePriceNetto());
      $item->setBasePriceBrutto($product->getBasePriceBrutto());

      $item->setVat($product->getVat());

      $item->setWeight($product->getWeight());

      $item->setWholesale($product->getWholesale());

      $item->setCurrency(array('price' => $product->getCurrencyPrice(), 'exchange' => $product->getCurrencyExchange(), 'code' => $product->getCurrency()->getShortcut(), 'id' => $product->getCurrencyId()));
      $item->setMaxQuantity($product->getStock());
      $item->setImage($product->getOptImage());
      $item->setPriceModifiers($product->getPriceModifiers());

      if (!$item->getIsGift())
      {
         $coupon_code = $this->getCouponCode();

         $productSetDiscount = $item->getProductSetDiscount();               
         $item->setDiscount($productSetDiscount ? array('value' => $productSetDiscount->getValue(), 'type' => $productSetDiscount->getPriceType()) : $product->getDiscount());

         if ($coupon_code && stDiscount::isValidDiscountCouponCodeProductIds($coupon_code, $product))
         {
            $discount = stDiscount::calculateCouponCodeDiscount($item, $coupon_code);               
                  
            $item->setDiscount(array('value' => $discount, 'type' => '%'));
         }
      }

      if ($item->isNew())
      {
         // $item->setProduct($product);

         $item->setItemId(stBasket::generateItemId($product->getId()));
      }

      return $item;
   }

   /**
    *
    * @param BasketProduct $item
    * @return <type>
    */
   public function validateQuantity(BasketProduct $item, $updateQuantity = false)
   {   
      $max_quantity = $this->getMaxQuantityForItem($item);

      if ($item->getProduct()->getIsStockValidated() && $item->getQuantity() > $max_quantity && (!$item->getProductMaxQty() || $max_quantity <= $item->getProductMaxQty()) || $item->getQuantity() === 0)
      {         
         if ($updateQuantity)
         {
            $item->setQuantity($max_quantity);
         }

         return self::ERR_OUT_OF_STOCK;
      }

      if ($item->getProductMaxQty() > 0 && $item->getProductMaxQty() < $item->getQuantity())
      {
         if ($updateQuantity)
         {
            $item->setQuantity($item->getProductMaxQty());
         }

         return self::ERR_MAX_QTY;
      }
            
      if ($item->getProductMinQty() > $item->getQuantity())
      {
         if ($updateQuantity)
         {
            $item->setQuantity($item->getProductMinQty());
         }
         
         return self::ERR_MIN_QTY;
      }

      return null;
   }

   protected function getMaxQuantityForItem($current)
   {
      $max_quantity = $current->getMaxQuantity();

      if (null === $current->getProductSetDiscountId())
      {
         foreach ($this->getItems() as $item) 
         {
            if ($item->getProductSetDiscount())
            {
               foreach ($item->getProductSetDiscount()->getProducts() as $product)
               {
                  if ($current->getProductId() == $product->getId())
                  {
                     $max_quantity -= $item->getQuantity();
                  }
               }
            }
         }
      }

      return $max_quantity > 0 ? $max_quantity : 0;
   }
   
   protected function setBasketCookieId()
   {
      if (!$this->isEmpty())
      {
         $this->getContext()->getResponse()->setCookie('basket', $this->basket->getId(), time() + 14 * 86400, "/");
      }

      $this->getUser()->setAttribute("id", $this->basket->getId(), self::SESSION_NAMESPACE);
   }

   protected function clearBasketCookieId()
   {
      $this->getContext()->getResponse()->setCookie('basket', null, time() - 3600, "/");
   }

   protected function getBasketCookieId()
   {
      $id = $this->getContext()->getRequest()->getCookie('basket');

      if (!$id)
      {
         $id = $this->getUser()->getAttribute("id", null, self::SESSION_NAMESPACE);
      }

      return $id;
   }

   public static function generateItemId($id)
   {
      if (!is_numeric($id))
      {
         return $id;
      }

      $request = sfContext::getInstance()->getRequest();

      $product_set_discount = $request->getParameter('product_set_discount');

      if ($product_set_discount)
      {
        $id .= '-'.$product_set_discount;
      }

      if ($request->hasParameter('gift'))
      {
         $id .= '-1';
      }

      $ids = $request->getParameter('option_list');

      if ($ids)
      {
         $id = md5($id.$ids);

      }

      $event = stEventDispatcher::getInstance()->filter(new sfEvent(null, 'stBasket.generateItemId'), $id);

      return $event->getReturnValue();
   }
   
   public static function cacheId()
   {       
      return array(session_id());               
   }
   
   public static function clearCache()
   {      
   }   

   /**
    * Zwraca łączną cenę produktu (ilosc x cena)
    *
    * @param   BasketProduct $basket_product   Produkt w koszyku
    * @param   bool        $with_tax           Uwzględnij podatek
    * @param   bool        $with_currency      Uwzględnij walute
    * @return   float
    */
   public static function getProductTotalAmount($basket_product, $with_tax = false, $with_currency = false)
   {
      return $basket_product->getTotalAmount($with_tax, $with_currency);
   }

   /**
    * Weryfikuje czy podany koszyk nalezy do danego uzytkownika
    *
    * @param   mixed       $basket             Id koszyka lub instancja modelu Basket
    * @param   sfGuardSecurityUser $user
    */
   public static function validateBasket($basket, $user)
   {
      if (!is_object($basket))
      {
         $basket = BasketPeer::retrieveByPK($basket);
      }
    
      if ($guard_user = $user->getGuardUser())
      {
         $guard_user_id = $guard_user->getId();
      }
      else
      {
         $guard_user_id = 0;
      }
    
      return isset($basket) && $basket->getUserId() == $guard_user_id;
   }

   public static function isEnabled(Product $product)
   {
      if ($product->getIsStockValidated())
      {
         return null === $product->getStock() || $product->getStock() >= $product->getMinQty();
      }
      
      return true;      
   }

   public static function isHidden(Product $product)
   {
      return $product->getConfiguration()->get('hide_basket') || !$product->isPriceVisible();
   }
   
   protected static function setPointsOnlyProduct($item)
   {
        $themeVersion = sfContext::getInstance()->getController()->getTheme()->getVersion();
        if($item->getProduct()->getPointsOnly() && $themeVersion < 7){
     
          stPoints::addItemByPoints($item->getItemId());
          $item -> setProductForPoints(true);
 
        }       
   }
}
