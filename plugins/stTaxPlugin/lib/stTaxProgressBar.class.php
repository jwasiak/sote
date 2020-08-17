<?php

class stTaxProgressBar
{

   protected
   $steps,
   $type,
   $tax;

   public function init()
   {
      stLock::lock('frontend');
   }

   public function __construct()
   {
      $this->steps = self::getParam('steps');

      $this->tax = self::getParam('tax');
   }

   public function updateProductPrice($offset)
   {
      $i18n = sfContext::getInstance()->getI18N();

      self::setMessage($i18n->__('Przeliczanie cen produktów w toku', null, 'stTaxBackend'));

      $c = new Criteria();

      $c->add(ProductPeer::TAX_ID, $this->tax['id']);

      $c->setOffset($offset);

      $c->setLimit(10);

      $products = ProductPeer::doSelect($c);

      foreach ($products as $product)
      {
         $product->setCulture('pl_PL');

         if ($this->tax['type'] == 'netto')
         {
            $this->updateProductPriceNetto($product);
         }
         elseif ($product->getCurrencyExchange() && $product->getCurrencyExchange() != 1)
         {
            $this->updateProductCurrencyPrice($product);
         }
         else
         {
            $this->updateProductPriceBrutto($product);
         }

         $product->setOptVat($this->tax['value']);

         $product->save();
      }

      $offset += count($products);

      if ($offset >= $this->steps['products'])
      {
         self::setAction('updateDeliveryCost');
      }

      return $offset;
   }

   public function updateDeliveryCost($offset)
   {
      $i18n = sfContext::getInstance()->getI18N();

      self::setMessage($i18n->__('Przeliczanie kosztów dostaw w toku', null, 'stTaxBackend'));

      $c = new Criteria();

      $c->setOffset($offset - $this->steps['products']);

      $c->setLimit(10);

      $c->add(DeliveryPeer::TAX_ID, $this->tax['id']);

      $deliveries = DeliveryPeer::doSelect($c);

      foreach ($deliveries as $delivery)
      {
         $delivery->setCulture('pl_PL');

         if ($this->tax['type'] == 'netto')
         {
            $this->updateDeliveryCostNetto($delivery);
         }
         else
         {
            $this->updateDeliveryCostBrutto($delivery);
         }

         $delivery->save();
      }

      $offset += count($deliveries);

      return $offset;
   }

   public function close()
   {
      sfContext::getInstance()->getUser()->getAttributeHolder()->removeNamespace('soteshop/stTaxProgressBar');

      $tax = TaxPeer::retrieveByPK($this->tax['id']);

      $tax->setUpdateResume(null);

      $tax->save();

      stLock::unlock('frontend');

      $i18n = sfContext::getInstance()->getI18N();

      sfLoader::loadHelpers(array('Helper', 'stUrl'));

      $link = st_link_to($i18n->__('Powróć do edycji', null, 'stTaxBackend'), 'stTaxBackend/edit?id='.$this->tax['id']); 

      self::setMessage($i18n->__('Aktualizacja cen została zakończona pomyślnie', null, 'stTaxBackend').'.<br/>'.$link);
   }

   public static function setParam($name, $value)
   {
      sfContext::getInstance()->getUser()->setAttribute($name, $value, 'soteshop/stTaxProgressBar');
   }

   public static function getParam($name, $default = null)
   {
      return sfContext::getInstance()->getUser()->getAttribute($name, $default, 'soteshop/stTaxProgressBar');
   }

   public static function setMessage($message)
   {
      sfContext::getInstance()->getUser()->setAttribute('stProgressBar-stTax', $message, 'symfony/flash');
   }

   protected function getCurrencyPrice($netto, $exchange)
   {
      $brutto = stPrice::calculate($netto, $this->tax['value']);

      return stCurrency::calculateCurrencyPrice($brutto, $exchange);
   }

   protected function updateProductCurrencyPrice(Product $product)
   {
      $exchange = $product->getCurrencyExchange();

      if ($product->getPriceNetto())
      {
         $product->setCurrencyPrice($this->getCurrencyPrice($product->getPriceNetto(), $exchange));
      }

      if ($product->getOldPriceNetto())
      {
         $product->setCurrencyoldPrice($this->getCurrencyPrice($product->getOldPriceNetto(), $exchange));
      }

      if ($product->getWholesaleANetto())
      {
         $product->setCurrencyWholesaleA($this->getCurrencyPrice($product->getWholesaleANetto(), $exchange));
      }

      if ($product->getWholesaleBNetto())
      {
         $product->setCurrencyWholesaleB($this->getCurrencyPrice($product->getWholesaleBNetto(), $exchange));
      }

      if ($product->getWholesaleCNetto())
      {
         $product->setCurrencyWholesaleC($this->getCurrencyPrice($product->getWholesaleCNetto(), $exchange));
      }

      foreach (self::getProductOptions($product) as $value)
      {
         list($price, $prefix, $postfix) = self::parseProductOptionPrice($value->getPrice());

         if ($postfix != '%' && $price)
         {
            $price = stCurrency::calculateCurrencyPrice($price, $exchange, true);

            $price = stPrice::extract($price, $this->tax['prev_value']);

            $price = stPrice::calculate($price, $this->tax['value']);

            $value->setPrice($prefix.stCurrency::calculateCurrencyPrice($price, $exchange));
         }

         $value->setIsUpdated(true);

         $value->save();
      }
   }

   protected function updateProductPriceBrutto(Product $product)
   {
      $product->setPriceBrutto(null);

      $product->setOldPriceBrutto(null);

      $product->setWholesaleABrutto(null);

      $product->setWholesaleBBrutto(null);

      $product->setWholesaleCBrutto(null);

      foreach (self::getProductOptions($product) as $value)
      {
         list($price, $prefix, $postfix) = self::parseProductOptionPrice($value->getPrice());

         if ($price && $postfix != '%' && $value->getPriceType() != 'netto')
         {
            $price = stPrice::extract($price, $this->tax['prev_value']);

            $price = stPrice::calculate($price, $this->tax['value']);

            $value->setPrice($prefix.$price);
         }

         $value->setIsUpdated(true);

         $value->save();
      }
   }

   protected function updateProductPriceNetto(Product $product)
   {
      $product->setPriceNetto(null);

      $product->setOldPriceNetto(null);

      $product->setWholesaleANetto(null);

      $product->setWholesaleBNetto(null);

      $product->setWholesaleCNetto(null);

      foreach (self::getProductOptions($product) as $value)
      {
         list($price, $prefix, $postfix) = self::parseProductOptionPrice($value->getPrice());

         if ($price && $postfix != '%' && $value->getPriceType() != 'brutto')
         {
            $price = stPrice::calculate($price, $this->tax['prev_value']);

            $price = stPrice::extract($price, $this->tax['value']);

            $value->setPrice($prefix.$price);
         }

         $value->setIsUpdated(true);

         $value->save();
      }
   }

   protected function updateDeliveryCostNetto(Delivery $delivery)
   {
      $tax = $this->tax['value'];

      $delivery->getTax()->setVat($this->tax['prev_value']);

      $delivery->setCostNetto(stPrice::extract($delivery->getCostBrutto(), $tax));

      foreach ($delivery->getDeliveryHasPaymentTypes() as $payment)
      {
         $payment->setDelivery($delivery);

         $payment->setCostNetto(stPrice::extract($payment->getCostBrutto(), $tax));
      }

      foreach ($delivery->getDeliverySectionss() as $section)
      {
         $section->setDelivery($delivery);

         $section->setCostNetto(stPrice::extract($section->getCostBrutto(), $tax));
      }

      $delivery->getTax()->setVat($tax);
   }

   protected function updateDeliveryCostBrutto(Delivery $delivery)
   {
      $tax = $this->tax['value'];

      $delivery->setCostBrutto(stPrice::calculate($delivery->getCostNetto(), $tax));

      foreach ($delivery->getDeliveryHasPaymentTypes() as $payment)
      {
         $payment->setCostBrutto(stPrice::calculate($payment->getCostNetto(), $tax));
      }

      foreach ($delivery->getDeliverySectionss() as $section)
      {
         $section->setCostBrutto(stPrice::calculate($section->getCostNetto(), $tax));
      }
   }

   protected static function parseProductOptionPrice($price)
   {
      $prefix = $price{0} == '+' || $price{0} == '-' ? $price{0} : null;

      $postfix = substr($price, -1) == '%' ? '%' : '';

      return array(trim($price, '-+%'), $prefix, $postfix);
   }

   protected static function getProductOptions(Product $product)
   {
      $c = new Criteria();

      $c->add(ProductOptionsValuePeer::IS_UPDATED, false);

      return $product->getProductOptionsValues($c);
   }

   protected static function setAction($action)
   {
      $user = sfContext::getInstance()->getUser();

      $name = sfContext::getInstance()->getRequest()->getParameter('name');

      $info = $user->getAttribute($name, array(), 'soteshop/stProgressBarPlugin');

      $info['method'] = $action;

      $user->setAttribute($name, $info, 'soteshop/stProgressBarPlugin');
   }

}
