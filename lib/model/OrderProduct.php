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
 * @version     $Id: OrderProduct.php 17561 2012-03-29 09:15:29Z marcin $
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
class OrderProduct extends BaseOrderProduct
{

   protected static $order = array();

   /**
    * Zwraca cene produktu
    *
    * @param   bool        $with_vat           Uwzględnij VAT
    * @param   bool        $with_currency      Uwzględnij walutę
    * @return   float
    */
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

   public function getGlobalCurrency()
   {
      return $this->getOrder()->getOrderCurrency();
   }

   public function getCurrencyExchange()
   {
      $currency = $this->getCurrency();

      return $currency['exchange'];
   }

   public function hasLocalCurrency()
   {
      return $this->currency && $this->currency['code'] == $this->getGlobalCurrency()->getShortcut() && $this->currency['exchange'] != 1;
   }

   public function hasPriceModifiers()
   {
      return (bool) $this->getPriceModifiers();
   }

   public function getPriceBrutto($with_currency = false, $with_discount = true, $with_wholesale = true)
   {

      if ($this->product_for_points)
      {
           return 0;
      }
       
      if ($this->version >= 2)
      {
         $price = $this->price_brutto;
      }
      elseif (null === $this->custom_price_brutto)
      {
         $price = null === $this->price_brutto ? stPrice::calculate($this->price, $this->vat) : $this->price_brutto;

         if ($this->wholesale && $with_wholesale)
         {
            $price = $this->getWholesalePriceBrutto($with_currency);
         }
         elseif ($with_currency)
         {
            $price = $this->hasLocalCurrency() ? $this->currency['price'] : $this->getGlobalCurrency()->exchange($price);
         }
         elseif ($this->hasLocalCurrency())
         {
            $price = $this->getGlobalCurrency()->exchange($this->currency['price'], true);
         }

         if ($this->price_modifiers)
         {
            $price = stPrice::computePriceModifiers($this, $price, 'brutto', $with_currency);
         }
      }
      else
      {
         $price = $this->custom_price_brutto;
      }

      if ($this->discount && $with_discount)
      {
         $price = stDiscount::apply($price, $this->discount);
      }

      return $price;
   }

   public function setCustomPriceNetto($v)
   {
      $this->setCustomPrice($v);
   }

   public function getPriceModifiersIds()
   {
      $arr = array();

      foreach ((array) $this->price_modifiers as $modifier)
      {
         $arr[] = $modifier['custom']['id'];
      }

      return $arr;
   }

   public function setDiscount($v)
   {
      if ($v && !isset($v[0]))
      {
         $v = array($v);
      }
      
      parent::setDiscount($v);
   }   

   public function getPriceModifierLabels()
   {
      $arr = array();

      if ($this->price_modifiers)
      {
         foreach ($this->price_modifiers as $modifier)
         {
            if (isset($modifier['custom']['field']))
            {
               $arr[] = $modifier['custom']['field'].': '.$modifier['label'];
            } 
            elseif (isset($modifier['label']) && $modifier['label'])
            {
               $arr[] = $modifier['label'];
            }
         }
      }

      return implode(', ', $arr);
   }

   public function getPriceModifiersSerialized()
   {
      $arr = array();

      foreach ((array) $this->price_modifiers as $modifier)
      {
         $arr[] = array('label' => $modifier['label'], 'type' => null, 'custom' => array('id' => $modifier['custom']['id'], 'type' => 'product_options'));
      }

      return json_encode($arr);
   }

   public function getPriceNetto($with_currency = false, $with_discount = true, $with_wholesale = true)
   {
      return stPrice::extract($this->getPriceBrutto($with_currency, $with_discount, $with_wholesale), $this->getVat());
   }

   public function getVat()
   {
      $vat = parent::getVat();

      if (null === $vat)
      {
         $this->vat = $this->getTax()->getVat();
      }

      return $this->vat;
   }
   
   public function getVatValue()
   {   
      return $this->getVat();
   }

   public function getTax($con = null)
   {
      $this->aTax = parent::getTax($con);

      if (null === $this->aTax && null !== $this->vat)
      {
         $this->aTax = TaxPeer::retrieveByTax($this->vat);
      }

      return $this->aTax;
   }

   public function getTaxId()
   {
      $this->tax_id = parent::getTaxId();

      if (null === $this->tax_id && null !== $this->vat)
      {
         $tax = TaxPeer::retrieveByTax($this->vat);

         if ($tax)
         {
            $this->aTax = $tax;

            $this->tax_id = $tax->getId();
         }
      }

      return $this->tax_id;
   }

   public function getDiscountInPercent()
   {
      return stDiscount::percent($this->getPriceBrutto(false, false), $this->discount);
   }

   public function getDiscountValue($with_currency = false)
   {
      return $this->getPriceBrutto($with_currency, false) - $this->getPriceBrutto($with_currency);
   }

   public function getDiscountType()
   {
      return isset($this->discount[0]['type'])  ? $this->discount[0]['type'] : '%';
   }

   public function getBasePriceNetto($with_currency = false)
   {
      return stPrice::extract($this->getBasePriceBrutto($with_currency), $this->vat);
   }

   public function getBasePriceBrutto($with_currency = false)
   {
      $price = stPrice::round($this->price_brutto);

      if (true === $with_currency)
      {
         $price = $this->hasLocalCurrency() ? $this->currency['price'] : $this->getGlobalCurrency()->exchange($price);
      }

      return $price;
   }

   public function setPriceNetto($v)
   {
      $this->setPrice($v);
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

   public function getImage()
   {
      $image = parent::getImage();

      if ((null === $image || !is_file(sfConfig::get('sf_web_dir').'/'.$image)) &&  null !== $this->getProduct())
      {
         $image = $this->getProduct()->getOptImage();
      }

      return $image;
   }

   public function getWholesalePriceNetto($with_currency = false)
   {
      $price = stPrice::extract($this->getWholesalePriceBrutto(), $this->vat);

      if ($with_currency)
      {
         $price = $this->getGlobalCurrency()->exchange($price, false, $this->hasLocalCurrency() ? $this->getCurrencyExchange() : null);
      }

      return $price;
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

   /**
    * Zwraca łączną kwotę za produkt (cena x ilosc)
    *
    * @param   bool        $with_vat           Uwzględnij VAT
    * @param   bool        $with_currency      Uwzględnij walutę
    * @return   float
    */
   public function getTotalAmount($with_vat = false, $with_currency = false)
   {
      return stCurrency::formatPrice($this->getQuantity() * $this->getPrice($with_vat, $with_currency));
   }

   public function getTaxAmount($with_currency = false)
   {
      return $this->getPrice(true, $with_currency) - $this->getPrice(false, $with_currency);
   }

   public function getTotalTaxAmount($with_currency = false)
   {
      return $this->getTaxAmount($with_currency) * $this->getQuantity();
   }

   public function getTotalWeight()
   {
      return $this->getProduct() ? $this->getProduct()->getWeight() * $this->getQuantity() : 0;
   }

   public function getOptions($to_array = false)
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
      elseif ($to_array)
      {
         if (preg_match_all('/<li>([^<]+)<\/li>/', $options, $matches))
         {
            return $matches[1];
         }
      }

      return $options;
   }

   public function hasOldOptions()
   {
      return null !== $this->options;
   }

   /**
    * Sprawdza czy produkt istnieje fizycznie w bazie danych
    */
   public function productValidate()
   {
      return $this->getProductId() !== null && $this->getProduct() !== null;
   }

   public function save($con = null)
   {


      $update = !$this->isNew() && $this->isModified();

      if ($this->isColumnModified(OrderProductPeer::TAX_ID) && $this->tax_id)
      {
         $this->setVat($this->getTax()->getVat());
      }

      if ($this->isNew())
      {
         $price_brutto = $this->getPriceBrutto(true, false);
         $this->setPriceBrutto($price_brutto);
         $this->setPrice(stPrice::extract($price_brutto, $this->vat));
         $this->setVersion(3);
      }

      parent::save($con);
   }

   /**
    *
    * @return Order
    */
   public function getOrder($con = null)
   {
      $id = $this->getOrderId();
      
      if (!isset(self::$order[$id]))
      {
         self::$order[$id] = parent::getOrder();
      }

      return self::$order[$id];
   }

   public function addPriceModifier($value, $type, $prefix, $level = 1, $custom = array())
   {
      $price_modifiers = $this->getPriceModifiers();

      if (isset($custom['label']))
      {
         $label = $custom['label'];

         unset($custom['label']);
      }
      else
      {
         $label = null;
      }

      $price_modifier = stPrice::createPriceModifier($value, $type, $prefix, $level, $custom);

      $price_modifier['label'] = $label;

      $price_modifiers[] = $price_modifier;

      $this->setPriceModifiers($price_modifiers);
   }

    public function setPriceModifiers($v)
   {
      parent::setPriceModifiers($v);

      $this->_price_brutto = array();
   }

}
