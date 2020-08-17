<?php

/**
 * SOTESHOP/stUser 
 * 
 * Ten plik należy do aplikacji stUser opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stUser
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: stInvoice.class.php 665 2009-04-16 07:43:27Z michal $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa myUser
 *
 * @package     stUser
 * @subpackage  libs
 */
class stInvoice
{

   public static function getAmmountWord($digits)
   {

      $i18n = sfContext::getInstance()->getI18N();

      $jednosci = Array(__('zero', null, 'stInvoicePdf'), __('jeden', null, 'stInvoicePdf'), __('dwa', null, 'stInvoicePdf'), __('trzy', null, 'stInvoicePdf'), __('cztery', null, 'stInvoicePdf'), __('pięć', null, 'stInvoicePdf'), __('sześć', null, 'stInvoicePdf'), __('siedem', null, 'stInvoicePdf'), __('osiem', null, 'stInvoicePdf'), __('dziewięć', null, 'stInvoicePdf'));
      $dziesiatki = Array('', __('dziesięć', null, 'stInvoicePdf'), __('dwadzieścia', null, 'stInvoicePdf'), __('trzydzieści', null, 'stInvoicePdf'), __('czterdzieści', null, 'stInvoicePdf'), __('pięćdziesiąt', null, 'stInvoicePdf'), __('sześćdziesiąt', null, 'stInvoicePdf'), __('siedemdziesiąt', null, 'stInvoicePdf'), __('osiemdziesiąt', null, 'stInvoicePdf'), __('dziewięćdziesiąt', null, 'stInvoicePdf'));
      $setki = Array('', __('sto', null, 'stInvoicePdf'), __('dwieście', null, 'stInvoicePdf'), __('trzysta', null, 'stInvoicePdf'), __('czterysta', null, 'stInvoicePdf'), __('pięćset', null, 'stInvoicePdf'), __('sześćset', null, 'stInvoicePdf'), __('siedemset', null, 'stInvoicePdf'), __('osiemset', null, 'stInvoicePdf'), __('dziewięćset', null, 'stInvoicePdf'));
      $nastki = Array(__('dziesieć', null, 'stInvoicePdf'), __('jedenaście', null, 'stInvoicePdf'), __('dwanaście', null, 'stInvoicePdf'), __('trzynaście', null, 'stInvoicePdf'), __('czternaście', null, 'stInvoicePdf'), __('piętnaście', null, 'stInvoicePdf'), __('szesnaście', null, 'stInvoicePdf'), __('siedemnaście', null, 'stInvoicePdf'), __('osiemnaście', null, 'stInvoicePdf'), __('dziewiętnaście', null, 'stInvoicePdf'));
      $tysiace = Array(__('tysiąc', null, 'stInvoicePdf'), __('tysiące', null, 'stInvoicePdf'), __('tysięcy', null, 'stInvoicePdf'));

      $digits = (string) $digits;
      $digits = strrev($digits);
      $i = strlen($digits);

      $string = '';

      if ($i > 5 && $digits[5] > 0)
         $string .= $setki[$digits[5]] . ' ';
      if ($i > 4 && $digits[4] > 1)
         $string .= $dziesiatki[$digits[4]] . ' ';
      elseif ($i > 3 && $digits[4] == 1)
         $string .= $nastki[$digits[3]] . ' ';
      if ($i > 3 && $digits[3] > 0 && $digits[4] != 1)
         $string .= $jednosci[$digits[3]] . ' ';

      $tmpStr = substr(strrev($digits), 0, -3);
      if (strlen($tmpStr) > 0)
      {
         $tmpInt = (int) $tmpStr;
         if ($tmpInt == 1)
            $string .= $tysiace[0] . ' ';
         elseif (( $tmpInt % 10 > 1 && $tmpInt % 10 < 5 ) && ( $tmpInt < 10 || $tmpInt > 20 ))
            $string .= $tysiace[1] . ' ';
         else
            $string .= $tysiace[2] . ' ';
      }

      if ($i > 2 && $digits[2] > 0)
         $string .= $setki[$digits[2]] . ' ';
      if ($i > 1 && $digits[1] > 1)
         $string .= $dziesiatki[$digits[1]] . ' ';
      elseif ($i > 0 && $digits[1] == 1)
         $string .= $nastki[$digits[0]] . ' ';
      if ($digits[0] > 0 && $digits[1] != 1)
         $string .= $jednosci[$digits[0]] . ' ';

      return $string;
   }

   public static function updateOrCreatePayment(Invoice $invoice, Order $order)
   {
      $c = new Criteria();

      $c->setLimit(1);

      $statuses = $invoice->getInvoiceStatuss($c);

      if (!$statuses)
      {
         $status = new InvoiceStatus();

         $status->setInvoiceId($invoice->getId());
      } 
      else 
      {
         $status = $statuses[0];
      }

      $payment = $order->getOrderPayment();

      $status->setPaidAmount($order->getPaidAmount());

      $status->setOptPaymentTypeName($payment->getPaymentType()->getName());

      if (!$payment->getGiftCardId())
      {
         $status->setPaymentId($payment->getId());
      }

      if ($payment->getPaymentTypeId())
      {
         $status->setOptPaymentTypeId($payment->getPaymentTypeId());
      }

      $status->save();
   }

   public static function updateInvoice($order, $invoice)
   {
      stEventDispatcher::getInstance()->notify(new sfEvent($invoice, 'stInvoiceListener.preUpdateInvoice', array('order'=>$order)));

      $context = sfContext::getInstance();
      $i18n = $context->getI18N();

      $invoiceDataDefault = stConfig::getInstance('stInvoiceBackend');
      
      $invoiceDataDefault->setCulture($order->getClientCulture());

      $shop_currency = $invoiceDataDefault->get('shop_currency');

      $invoice->setOrderId($order->getId());
      $invoice->setCompanyDescription($invoiceDataDefault->get('company_description'));
      $invoice->setInvoiceDescription($invoiceDataDefault->get('invoice_description', null, true));
      $invoice->setTown($invoiceDataDefault->get('town'));

      if (!$invoice->getInvoiceUserSeller())
      {
         $invoice->setInvoiceUserSeller(new InvoiceUserSeller());
      }

      if (!$invoice->getInvoiceUserCustomer())
      {
         $invoice->setInvoiceUserCustomer(new InvoiceUserCustomer());
      }      
   
      $invoice->getInvoiceUserSeller()->setCompany($invoiceDataDefault->get('seller_company'));
      $invoice->getInvoiceUserSeller()->setVatNumber($invoiceDataDefault->get('seller_vat_number'));
      $invoice->getInvoiceUserSeller()->setFullName($invoiceDataDefault->get('seller_full_name'));
      $invoice->getInvoiceUserSeller()->setAddress($invoiceDataDefault->get('seller_address'));
      $invoice->getInvoiceUserSeller()->setAddressMore($invoiceDataDefault->get('seller_address_more'));
      $invoice->getInvoiceUserSeller()->setRegion($invoiceDataDefault->get('seller_region'));
      $invoice->getInvoiceUserSeller()->setCode($invoiceDataDefault->get('seller_code'));
      $invoice->getInvoiceUserSeller()->setTown($invoiceDataDefault->get('seller_town'));
      $invoice->getInvoiceUserSeller()->setCountry($invoiceDataDefault->get('seller_country'));
      // $invoice->getInvoiceUserSeller()->save();

      $invoice->getInvoiceUserCustomer()->setCompany($order->getOrderUserDataBilling()->getCompany());
      $invoice->getInvoiceUserCustomer()->setVatNumber($order->getOrderUserDataBilling()->getVatNumber());
      $invoice->getInvoiceUserCustomer()->setPesel($order->getOrderUserDataBilling()->getPesel());
      $invoice->getInvoiceUserCustomer()->setFullName($order->getOrderUserDataBilling()->getFullName());
      $invoice->getInvoiceUserCustomer()->setAddress($order->getOrderUserDataBilling()->getAddress());
      $invoice->getInvoiceUserCustomer()->setAddressMore($order->getOrderUserDataBilling()->getAddressMore());
      $invoice->getInvoiceUserCustomer()->setRegion($order->getOrderUserDataBilling()->getRegion());
      $invoice->getInvoiceUserCustomer()->setCode($order->getOrderUserDataBilling()->getCode());
      $invoice->getInvoiceUserCustomer()->setTown($order->getOrderUserDataBilling()->getTown());
            
      $order->getOrderUserDataBilling()->getCountry()->setCulture($order->getClientCulture());       
      $invoice->getInvoiceUserCustomer()->setCountry($order->getOrderUserDataBilling()->getCountry()->getName());
      // $invoice->getInvoiceUserCustomer()->save();

      $invoice->setSignatureCustomer($invoiceDataDefault->get('customer_signature'));
      $invoice->setSignatureSeller($invoiceDataDefault->get('seller_signature'));

      if (!$invoice->getInvoiceCurrency())
      {
         $invoiceCurrency = new InvoiceCurrency();

         $invoice->setInvoiceCurrency($invoiceCurrency);  
      }   
      else
      {
         $invoiceCurrency = $invoice->getInvoiceCurrency();
      }

      if ($shop_currency)
      {
         $invoiceCurrency->setName($order->getOrderCurrency()->getName());

         $invoiceCurrency->setExchange($order->getOrderCurrency()->getExchange());

         $invoiceCurrency->setShortcut($order->getOrderCurrency()->getShortcut());

         $invoiceCurrency->setFrontSymbol($order->getOrderCurrency()->getFrontSymbol());

         $invoiceCurrency->setBackSymbol($order->getOrderCurrency()->getBackSymbol());
      }
      else
      {
         $defaultCurrency = stCurrency::getDefault();

         $invoiceCurrency->setName($defaultCurrency->getName());

         $invoiceCurrency->setExchange($defaultCurrency->getExchange());

         $invoiceCurrency->setShortcut($defaultCurrency->getShortcut());

         $invoiceCurrency->setFrontSymbol($defaultCurrency->getFrontSymbol());

         $invoiceCurrency->setBackSymbol($defaultCurrency->getBackSymbol()); 
      }

      // $invoice->setOptTotalAmmountBrutto($order->getTotalAmountWithDelivery(true, $shop_currency));
      // $invoice->save();

      $c = new Criteria();
      $c->add(InvoiceProductPeer::INVOICE_ID, $invoice->getId());
      InvoiceProductPeer::doDelete($c);

      $shipping_method = $i18n->__('Dostawa', null, 'stInvoicePdf');

      sfLoader::loadHelpers(array('Helper', 'stOrder', 'stProduct'), 'stProduct');

      $totalProductDiscountAmount = $order->getTotalProductDiscountAmount(true, $shop_currency);

      if (!$invoice->getIsProforma())
      {
         $discount = ($totalProductDiscountAmount / $order->getTotalAmount(true, $shop_currency, false)) * 100;     
      }
      else
      {
         $discount = 0;
      }

      $totalAmount = 0;

      if ($invoice->getIsProforma())
      {
         $invoice->setOrderDiscount($totalProductDiscountAmount);
      }

      foreach ($order->getOrderProducts() as $orderProduct)
      {
         if(!$orderProduct->getProductForPoints() && (!$orderProduct->getIsGift() || $orderProduct->getIsGift() && $orderProduct->getPrice() > 0)) {  
          
         $invoiceProduct = new InvoiceProduct();

         $invoiceProduct->setInvoiceId($invoice->getId());

         $invoiceProduct->setProductId($orderProduct->getId());

         if ($orderProduct->hasPriceModifiers())
         {
            $options = st_order_render_product_options($orderProduct);
         }
         else
         {
            $options = "";
         }

         if (!$shop_currency)
         {
            $price_brutto = $order->getOrderCurrency()->exchange($orderProduct->getPrice(true), true);
         }
         else
         {
            $price_brutto = $orderProduct->getPrice(true);
         }

         if ($discount > 0)
         {
            $price_brutto = stPrice::applyDiscount($price_brutto, $discount);
         }

         $price_netto = stPrice::extract($price_brutto, $orderProduct->getVat());

         $invoiceProduct->setCode($orderProduct->getCode());

         $invoiceProduct->setName($orderProduct->getName() . $options);

         $invoiceProduct->setQuantity($orderProduct->getQuantity());

         $invoiceProduct->setMeasureUnit(st_product_uom($orderProduct->getProduct()));

         $discountProduct = $orderProduct->getDiscount();

         $invoiceProduct->setDiscount($discountProduct['percent']);

         $invoiceProduct->setPriceNetto($price_netto);

         $invoiceProduct->setPriceBrutto($price_brutto);

         $totalPriceBrutto = $orderProduct->getQuantity() * $price_brutto;

         $totalAmount += $totalPriceBrutto;

         $invoiceProduct->setOptTotalPriceBrutto($totalPriceBrutto);

         $totalVatAmount = $totalPriceBrutto * ($orderProduct->getVat() / (100 + $orderProduct->getVat()));

         $invoiceProduct->setVatAmmount($totalVatAmount);

         $invoiceProduct->setTotalPriceNetto($totalPriceBrutto - $totalVatAmount);

         $invoiceProduct->setVat($orderProduct->getVat());

         $invoiceProduct->setVatId($orderProduct->getTax()->getId());

         $invoiceProduct->save();
         
         }
      }

      // koszty dostawy

      $delivery = $order->getOrderDelivery();

      $deliveryCostBrutto = $delivery->getCostBrutto($shop_currency);

      if ($deliveryCostBrutto)
      {
         $delivery_cost_netto = $delivery->getCostNetto($shop_currency);

         $invoiceProduct = new InvoiceProduct();

         $invoiceProduct->setInvoiceId($invoice->getId());

         $invoiceProduct->setName($shipping_method." - ".$delivery->getName());

         $invoiceProduct->setQuantity(1);

         $invoiceProduct->setDiscount("");

         $invoiceProduct->setOptTotalPriceBrutto($deliveryCostBrutto);

         $invoiceProduct->setPkwiu("");

         $invoiceProduct->setMeasureUnit(st_product_uom($orderProduct->getProduct()));

         $invoiceProduct->setPriceNetto($delivery_cost_netto);

         $invoiceProduct->setPriceBrutto($deliveryCostBrutto);

         $invoiceProduct->setTotalPriceNetto($delivery_cost_netto);

         $invoiceProduct->setVatAmmount($deliveryCostBrutto - $delivery_cost_netto);

         $invoiceProduct->setVat($delivery->getOptTax());

         $invoiceProduct->setVatId($delivery->getTaxId());

         $invoiceProduct->save();
      }

      $invoice->setOptTotalAmmountBrutto($totalAmount + $deliveryCostBrutto);

      $invoice->save();

      self::updateOrCreatePayment($invoice, $order);
   }

}
