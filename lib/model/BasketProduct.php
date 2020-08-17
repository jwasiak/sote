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
 * @version     $Id: BasketProduct.php 16444 2011-12-12 13:01:21Z marcin $
 */

/**
 * Klasa reprezentujaca wiersz dla tabeli 'st_basket_product'
 *
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 *
 * @package     stBasket
 * @subpackage  libs
 */
class BasketProduct extends BaseBasketProduct implements DiscountInterface
{

   protected static
   $_config = null,
   $globalCurrency = null;

   protected 
      $productSetDiscount = null,
      $_price_brutto = array(),
      $vat_eu = false,
      $productOptions = null;

   public function __construct()
   {
      $this->updateVatEu();
   }

   public function getProductOptions()
   {
      if (null === $this->productOptions)
      {
         $ids = array();

         foreach ($this->getPriceModifiers() as $pm)
         {
            if (isset($pm['custom']['type']) && $pm['custom']['type'] == 'product_options' || isset($pm['type']) && $pm['type'] == 'product_options')
            {
               $ids[] = $pm['custom']['id'];
            }
         }

         $productOptions = ProductOptionsValuePeer::doSelectByIds($ids);

         $this->productOptions = count($productOptions) == count($ids) ? $productOptions : array();
      }

      return $this->productOptions;
   }

   public function updateVatEu()
   {
      if (sfContext::hasInstance() && SF_APP == 'frontend')
      {
         $user = sfContext::getInstance()->getUser();

         $this->vat_eu = $user->hasVatEu() || $user->hasVatEx();
      }      
   }

   public function setVatEu($vat_eu)
   {
      $this->vat_eu = $vat_eu;

      $this->_price_brutto = array();
   }

   public function getConfiguration()
   {
      if (null === self::$_config)
      {
         self::$_config = stConfig::getInstance(null, 'stBasket');
      }

      return self::$_config;
   }

   public function getGlobalCurrency()
   {
      if (null === self::$globalCurrency && SF_APP == 'frontend')
      {
         self::$globalCurrency = stCurrency::getInstance(sfContext::getInstance())->get();
      }

      return self::$globalCurrency;
   }

   public function getTotalDiscountAmount($with_tax = false, $with_currency = false)
   {
      if ($with_tax)
      {
         return $this->getDiscountBrutto($with_currency) * $this->getQuantity();
      }
      else
      {
         return $this->getDiscountNetto($with_currency) * $this->getQuantity();
      }
   }

   public function getTotalDeliveryPrice()
   {
      return $this->getProduct() ? $this->getProduct()->getDeliveryPrice() * $this->getQuantity() : 0;
   }

   public function hasLocalCurrency()
   {
      if (SF_APP != 'frontend')
      {
         return false;
      }

      return $this->currency['id'] == $this->getGlobalCurrency()->getId() && $this->currency['exchange'] != 1;
   }

   public function getCurrencyExchange()
   {
      $currency = $this->getCurrency();

      return $currency['exchange'];
   }

   public function getMaxQuantity()
   {
      $max_quantity = parent::getMaxQuantity();

      if ($this->getProduct())
      {
         $max_quantity = $this->getProduct()->getStock();
      }

      if (null === $max_quantity || $this->getProduct() && !$this->getProduct()->getIsStockValidated())
      {
         $max_quantity = $this->getConfiguration()->get('max_quantity');
      }

      if ($this->getProduct() && $this->getProduct()->getIsStockValidated() && $this->product_set_discount_id && $this->getProductSetDiscount())
      {
         foreach ($this->getProductSetDiscount()->getProducts() as $product)
         {
            if ($max_quantity > $product->getStock())
            {
               $max_quantity = $product->getStock();
            }
         }
      }

      return $max_quantity;
   }

   public function getPrice($with_tax = false, $with_currency = false, $with_discount = true)
   {
      if ($with_tax)
      {
         $price = $this->getPriceBrutto($with_currency, $with_discount);
      }
      else
      {
         $price = $this->getPriceNetto($with_currency, $with_discount);
      }

      return $price;
   }

   public function hasPriceModifiers()
   {
      return !empty($this->price_modifiers);
   }

   public function getName()
   {
      if ($this->product_set_discount_id && $this->getProductSetDiscount())
      {
         $name = array();

         foreach ($this->getProductSetDiscount()->getProducts() as $product)
         {
            $name[] = $product->getName();
         }

         return implode(' + ', $name);
      }

      if (sfContext::hasInstance() && $this->productValidate())
      {
         $name = $this->getProduct()->getName();

         if ($this->getIsGift())
         {
            $name .= ' ('.sfContext::getInstance()->getI18N()->__('prezent', null, 'stBasket').')';
         }

         return $name;
      }

      return parent::getName();
   }

   public function getPriceBrutto($with_currency = false, $with_discount = true, $with_wholesale = true)
   {
      $price = $this->price_brutto;

      if ($this->product_set_discount_id && $this->getProductSetDiscount())
      {
         $price = $this->getProductSetDiscount()->getTotalProductAmount(false);
      }
      else
      {
         if ($with_wholesale && $this->wholesale)
         {
            $price = $this->getWholesalePriceBrutto($with_currency);
         }
         elseif ($with_currency)
         {
            $price = $this->hasLocalCurrency() ? $this->currency['price'] : $this->getGlobalCurrency()->exchange($price);
         }

         if ($this->price_modifiers)
         {
            $price = stPrice::computePriceModifiers($this, $price, 'brutto', $with_currency);
         }
      }

      if ($with_discount && $this->discount)
      {
         $price = stDiscount::apply($price, $this->discount, $this->getProduct() ? $this->getProduct()->getMaxDiscount() : 100);
      }

      if ($this->vat_eu && ($this->price_brutto != $this->price || !$this->price_brutto && $price))
      {
         $price = stPrice::extract($price, $this->vat);
      }         
      
      return $price;
   }

   public function getPriceNetto($with_currency = false, $with_discount = true, $with_wholesale = true)
   {
      if (!$this->getVat())
      {
         return $this->getPriceBrutto($with_currency, $with_discount, $with_wholesale);
      }

      return stPrice::extract($this->getPriceBrutto($with_currency, $with_discount, $with_wholesale), $this->getVat());
   }

   public function getBasePriceNetto($with_currency = false)
   {
      if (!$this->getVat())
      {
         return $this->getBasePriceBrutto($with_currency);
      }

      return stPrice::extract($this->getBasePriceBrutto($with_currency), $this->getVat());
   }

   public function getBasePriceBrutto($with_currency = false)
   {
      $price = $this->price_brutto;

      if (true === $with_currency)
      {
         $price = $this->hasLocalCurrency() ? $this->currency['price'] : $this->getGlobalCurrency()->exchange($price);
      }

      if ($this->vat_eu && $this->price_brutto != $this->price)
      {
         $price = stPrice::extract($price, $this->vat);
      }      

      return $price;
   }

   public function setBasePriceNetto($v)
   {
      $this->setPrice($v);
   }

   public function setBasePriceBrutto($v)
   {
      $this->setPriceBrutto($v);
   }

   public function getOptImage()
   {
      return $this->getImage();
   }

   public function setDiscount($v)
   {
      if ($v && !isset($v[0]))
      {
         $v = array($v);
      }

      if (null === $v)
      {
         throw new Exception("Error Processing Request", 1);
         
      }
      
      parent::setDiscount($v);
   }

   public function addDiscount($v)
   {
      $discount = $this->getDiscount();

      $discount[] = $v;

      $this->setDiscount($discount);
   }

   public function getDiscountInPercent()
   {
      $percent = stDiscount::percent($this->getPriceBrutto(false, false), $this->discount);

      return $this->getProduct() && $percent > $this->getProduct()->getMaxDiscount() ? $this->getProduct()->getMaxDiscount() : $percent;
   }

   public function getDiscountNetto($with_currency = false)
   {
      return stPrice::extract($this->getDiscountBrutto($with_currency), $this->opt_vat);
   }

   public function getDiscountBrutto($with_currency = false)
   {
      return $this->getPriceBrutto($with_currency, false) - $this->getPriceBrutto($with_currency);
   }

   public function hasDiscount()
   {
      return $this->discount;
   }  

   public function getWholesalePriceNetto($with_currency = false)
   {
      if (!$this->getVat())
      {
         return $this->getWholesalePriceBrutto($with_currency);
      }

      return stPrice::extract($this->getWholesalePriceBrutto($with_currency), $this->getVat());
   }

   public function getWholesalePriceBrutto($with_currency = false)
   {
      $price = $this->wholesale['brutto'];

      if ($with_currency)
      {
         $price = $this->hasLocalCurrency() ? $this->wholesale['currency'] : $this->getGlobalCurrency()->exchange($price);
      }  

      return $price;
   }

   public function setWholesalePriceBrutto($v)
   {
      parent::setWholesalePriceBrutto($v);
   }

   public function getOptions()
   {
      $options = parent::getOptions();

      if ($this->hasPriceModifiers())
      {
         $content = '';

         $ids = '';

         foreach ($this->getPriceModifiers() as $price_modifier)
         {
            $content .= '<li>'.$price_modifier['label'].'</li>';

            $ids .= '-'.$price_modifier['custom']['id'];
         }

         $options = '<ul>'.$content.'</ul>'.substr($ids, 1);
      }

      return $options;
   }

   public function getVatValue($with_vat_eu = true)
   {
      return $this->getVat($with_vat_eu);
   }

   public function getVat($with_vat_eu = true)
   {
      if ($with_vat_eu && $this->vat_eu)
      {
         return 0;
      }

      return $this->vat;
   }

   public function getPriceModifiers()
   {
      return parent::getPriceModifiers() ? parent::getPriceModifiers() : array();
   }

   public function getCustomItemId()
   {
      return parent::getCustomItemId() ? parent::getCustomItemId() : $this->getProductId();
   }

   public function addPriceModifier($value, $type, $prefix, $level = 1, $custom = array())
   {
      $price_modifiers = $this->getPriceModifiers(); 

      $price_modifiers[] = stPrice::createPriceModifier($value, $type, $prefix, $level, $custom);

      $this->setPriceModifiers($price_modifiers);
   }

   public function setPriceModifiers($v)
   {
      foreach ($v as $index => $value)
      {
         if (isset($value['custom']['label']))
         {
            $label = $value['custom']['label'];

            unset($value['custom']['label']);

            $value['label'] = $label;

            $v[$index] = $value; 
         }        
      }

      parent::setPriceModifiers($v);

      $this->_price_brutto = array();
   }

   public function getTotalAmount($with_tax = false, $with_currency = false, $with_discount = true)
   {

      if ($this->product_for_points)
      {
           return 0;
      }
      
      return $this->getPrice($with_tax, $with_currency, $with_discount) * $this->quantity;

   }

   public function getTaxAmount($with_currency = false)
   {
      return $this->getPriceBrutto($with_currency) - $this->getPriceNetto($with_currency);
   }

   public function getTotalTaxAmount($with_currency = false)
   {
      return $this->getTaxAmount($with_currency) * $this->quantity;
   }

   public function getTotalWeight()
   {
      return $this->weight * $this->quantity;
   }

   public function getTotalVolume()
   {
      return $this->quantity * $this->getVolume();
   }

   public function getVolume()
   {
      return $this->getProduct() ? round($this->getWidth() * $this->getHeight() * $this->getDepth()) : 0; 
   }

   /**
    * Sprawdza czy produkt istnieje fizycznie w bazie danych
    */
   public function productValidate()
   {
      return $this->product_id !== null && $this->getProduct() && $this->getProduct()->getActive();
   }

   public function getProductStockInDecimals()
   {
      return $this->product_id && $this->getProduct() ? $this->getProduct()->getStockInDecimals() : 0;
   }
   
   public function getProductStepQty()
   {
      return $this->product_id ? $this->getProduct()->getStepQty() : 0;
   }
   
   public function getProductMinQty()
   {
      return $this->product_id ? $this->getProduct()->getMinQty() : 1;
   }
   
   public function getProductMaxQty()
   {
      $maxQty = 0;
      
      if ($this->getProduct())
      {
         $product = $this->getProduct();
         $maxQty = min($product->getMaxQty(), stConfig::getInstance('stBasket')->get('max_quantity'));
      }

      return $maxQty;
   }  

   public function getProduct($con = null)
   {
      if (!$this->product_id)
      {
         return null;
      }
      
      $product = parent::getProduct();

      if ($product)
      {
         $product->setOptImage($this->getImage());

         $product->resetModified();
      }

      return $product;
   } 

   /**
    * Return Product Set Discount instance
    *
    * @return Discount
    */
   public function getProductSetDiscount()
   {
      if (null === $this->productSetDiscount && $this->product_set_discount_id)
      {
         $this->productSetDiscount = DiscountPeer::retrieveByPK($this->product_set_discount_id);
         
         if ($this->productSetDiscount && $this->productSetDiscount->getActive())
         {
            $this->productSetDiscount->setProduct($this->getProduct());
            $this->productSetDiscount->getProduct()->setPriceModifiers($this->getPriceModifiers());
         }
         else
         {
            $this->productSetDiscount = false;
         }
      }

      return $this->productSetDiscount;
   }

   public function setProductSetDiscountId($v)
   {
      $this->productSetDiscount = null;
      parent::setProductSetDiscountId($v);
   }
   
   public function getPointsEarn()
   {
          
      if ($this->product_set_discount_id && $this->getProductSetDiscount())
      {
         $points_earn = 0;

         foreach ($this->getProductSetDiscount()->getProducts() as $product)
         {
            $points_earn += $product->getPointsEarn();
         }

         return $points_earn;
      }

      return $this->getProduct() ? $this->getProduct()->getPointsEarn() : 0;
   }

   public function getWidth()
   {
      if (null === $this->getProduct())
      {
         return 0;
      }

      $config = stConfig::getInstance('stDeliveryBackend');
      return $this->getProduct()->getWidth() + stPrice::percentValue($this->getProduct()->getWidth(), $config->get('product_package_margin', 0));     
   }

   public function getHeight()
   {
      if (null === $this->getProduct())
      {
         return 0;
      } 

      $config = stConfig::getInstance('stDeliveryBackend');
      return $this->getProduct()->getHeight() + stPrice::percentValue($this->getProduct()->getHeight(), $config->get('product_package_margin', 0));     
   }

   public function getDepth()
   {
      if (null === $this->getProduct())
      {
         return 0;
      } 

      $config = stConfig::getInstance('stDeliveryBackend');
      return $this->getProduct()->getDepth() + stPrice::percentValue($this->getProduct()->getDepth(), $config->get('product_package_margin', 0));     
   }

}