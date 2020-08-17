<?php

/**
 * SOTESHOP/stInvoicePlugin
 *
 * Ten plik należy do aplikacji stInvoicePlugin opartej na licencji (Professional License SOTE). 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stInvoicePlugin
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: components.class.php 2285 2009-07-23 12:50:05Z bartek $
 * @author      Bartosz Alejski <bartosz.alejski@sote.pl>
 */

/**
 * Komponent stInvoiceFrontendComponents
 *
 * @package     stInvoicePlugin
 * @subpackage  actions
 */
class stInvoiceBackendComponents extends autoStInvoiceBackendComponents
{

   public function executeConfigContent()
   {
      $this->config = stConfig::getInstance('stInvoiceBackend');
      $this->config->setCulture($this->getRequestParameter('culture', stLanguage::getOptLanguage()));

      $c = new Criteria();

      $c->add(PaymentTypePeer::ACTIVE, 1);

      $payments = PaymentTypePeer::doSelect($c);

      foreach ($payments as $payment)
      {
         $pay[$payment->getId()] = $payment->getOptName();
      }

      $this->pay = $pay;
   }

   public function executeViewContent()
   {
      $invoice_id = $this->getRequestParameter('id');
      $invoice_type = $this->getRequestParameter('type');
      $i18n = $this->getContext()->getI18N();
      
      $user = sfContext::getInstance()->getUser();
      $this->culture = $user->getCulture();
      
      $this->config = stConfig::getInstance('stInvoiceBackend');

      $c = new Criteria();
      $c->add(InvoicePeer::ID, $invoice_id);
      $invoice = InvoicePeer::doSelectOne($c);

      $c = new Criteria();
      $c->add(InvoiceProductPeer::INVOICE_ID, $invoice_id);
      $invoiceProducts = InvoiceProductPeer::doSelect($c);

      $c = new Criteria();
      $c->add(InvoiceUserCustomerPeer::ID, $invoice->getInvoiceUserCustomerId());
      $InvoiceUserCustomer = InvoiceUserCustomerPeer::doSelectOne($c);

      $c = new Criteria();
      $c->add(InvoiceUserSellerPeer::ID, $invoice->getInvoiceUserSellerId());
      $InvoiceUserSeller = InvoiceUserSellerPeer::doSelectOne($c);

      $c = new Criteria();
      $c->addDescendingOrderByColumn(TaxPeer::IS_DEFAULT);
      $tax = TaxPeer::doSelect($c);

      $c = new Criteria();
      $c->add(InvoiceCurrencyPeer::ID, $invoice->getInvoiceCurrencyId());
      $invoiceCurrency = InvoiceCurrencyPeer::doSelectOne($c);


      if ($invoiceCurrency)
      {
         $shortcut = $invoiceCurrency->getShortcut();
      }
      else
      {

         $shortcut = "PLN";
      }

      foreach ($invoiceProducts as $product)
      {
         $c = new Criteria();
         $c->add(TaxPeer::ID, $product->getVatId());
         $vat = TaxPeer::doSelectOne($c);

         $product->setVat($vat);
      }

      $i = 0;
      foreach ($tax as $vat)
      {
         $i++;
         $c = new Criteria();
         $c->add(InvoiceProductPeer::INVOICE_ID, $invoice_id);
         $c->add(InvoiceProductPeer::VAT_ID, $vat->getId());
         $vatProducts = InvoiceProductPeer::doSelect($c);


         $price_brutto_bufor = 0;

         foreach ($vatProducts as $vatProduct)
         {
            $price_brutto_bufor += stCurrency::formatPrice($vatProduct->getOptTotalPriceBrutto());
         }

         if ($price_brutto_bufor != 0)
         {
            $taxProducts[$i]['vat_id'] = $vat->getId();
            $taxProducts[$i]['vat_name'] = $vat->getVatName();
            $taxProducts[$i]['vat'] = $vat->getVat();
            $taxProducts[$i]['is_default'] = $vat->getIsDefault();
            $taxProducts[$i]['total_netto'] = stPrice::extract($price_brutto_bufor, $vat->getVat());
            $taxProducts[$i]['total_ammount_vat'] = $price_brutto_bufor - stPrice::extract($price_brutto_bufor, $vat->getVat());
            $taxProducts[$i]['total_brutto'] = $price_brutto_bufor;
         }
      }

      $c = new Criteria();
      $c->add(InvoiceStatusPeer::INVOICE_ID, $invoice->getId());
      $status = InvoiceStatusPeer::doSelectOne($c);

      if ($invoice->getIsConfirm() != 1)
      {

         if ($status->getHandMod() != 1)
         {
            $payment = $invoice->getOrder()->getOrderPayment();

            $status->setInvoiceId($invoice->getId());
            $status->setPaymentId($payment->getId());
            $status->setOptPaymentTypeName($payment->getPaymentType()->getName());
            $status->setOptPaymentStatus($payment->getStatus());

            $status->setOptPaymentTypeId($payment->getPaymentTypeId());
         }
      }

      $c = new Criteria();
      $c->add(InvoiceStatusPeer::INVOICE_ID, $invoice->getId());
      $status = InvoiceStatusPeer::doSelectOne($c);


      $this->status = $status;

      $this->paid_amount = $status->getPaidAmount() > 0 && !$status->getOptPaymentStatus() ? $status->getPaidAmount() : $invoice->getTotalAmount();

      if ($this->paid_amount > $invoice->getTotalAmount())
      {
         $this->paid_amount = $invoice->getTotalAmount();
      }

      $this->unpaid_amount = $invoice->getTotalAmount() - $this->paid_amount;

      $this->taxProducts = $taxProducts;

      $this->invoiceProducts = $invoiceProducts;

      $this->shortcut = $shortcut;

      $this->invoice = $invoice;

      $this->InvoiceUserCustomer = $InvoiceUserCustomer;

      $this->InvoiceUserSeller = $InvoiceUserSeller;

      $this->invoiceType = $invoice_type;

      if ($this->invoice->hasDiscount() && (string)$this->invoice->getTotalAmount() != (string)$this->invoice->getOrder()->getTotalAmountWithDelivery(true, true))
      {
         $this->setFlash('warning', $i18n->__('W zamówieniu wykorzystano rabat od kwoty zamówienia proszę sprawdzić poprawność wygenerowanych cen na fakturze'));
      }
   }

   public function executeViewEditContent()
   {
      $invoice_id = $this->getRequestParameter('id');
      $type = $this->getRequestParameter('type');
    
      $this->config = stConfig::getInstance('stInvoiceBackend');

      $c = new Criteria();
      $c->add(InvoicePeer::ID, $invoice_id);
      $invoice = InvoicePeer::doSelectOne($c);

      $c = new Criteria();
      $c->add(InvoiceProductPeer::INVOICE_ID, $invoice_id);
      $invoiceProducts = InvoiceProductPeer::doSelect($c);

      $c = new Criteria();
      $c->add(InvoiceUserCustomerPeer::ID, $invoice->getInvoiceUserCustomerId());
      $invoiceUserCustomer = InvoiceUserCustomerPeer::doSelectOne($c);

      $c = new Criteria();
      $c->add(InvoiceUserSellerPeer::ID, $invoice->getInvoiceUserSellerId());
      $invoiceUserSeller = InvoiceUserSellerPeer::doSelectOne($c);

      $c = new Criteria();
      $tax = TaxPeer::doSelect($c);


      foreach ($tax as $vat)
      {
         $vatArray[$vat->getId() . ":" . $vat->getVat()] = $vat->getVatName();
      }


      $c = new Criteria();
      $c->add(PaymentTypePeer::ACTIVE, 1);
      $payments = PaymentTypePeer::doSelect($c);


      foreach ($payments as $payment)
      {
         $pay[$payment->getId()] = $payment->getOptName();
      }

      $this->pay = $pay;

      $c = new Criteria();
      $c->add(InvoiceStatusPeer::INVOICE_ID, $invoice->getId());
      $status = InvoiceStatusPeer::doSelectOne($c);

      $this->status = $status;
      
      $this->paid_amount = $status->getPaidAmount() > 0 && $status->getOptPaymentStatus() ? $status->getPaidAmount() : $invoice->getTotalAmount();

      $this->unpaid_amount = $invoice->getTotalAmount() - $this->paid_amount;      

      $this->vatArray = $vatArray;

      $this->invoiceProducts = $invoiceProducts;

      $this->invoice = $invoice;

      $this->invoiceUserCustomer = $invoiceUserCustomer;

      $this->invoiceUserSeller = $invoiceUserSeller;

      $this->type = $type;
   }

   public function executeFullName()
   {
      $this->fullName = $this->invoice->getInvoiceUserCustomer()->getFullName();
   }

   public function executeVatNumber()
   {
      $this->vatNumber = $this->invoice->getInvoiceUserCustomer()->getVatNumber();
   }

   public function executeCompany()
   {
      $this->comapny = $this->invoice->getInvoiceUserCustomer()->getCompany();
   }

   public function executeProformaNumber()
   {
      $c = new Criteria();
      $c->add(InvoicePeer::ID, $this->invoice->getInvoiceProformaId());
      $invoiceProforma = InvoicePeer::doSelectOne($c);

      if ($invoiceProforma)
      {
         $this->value = $invoiceProforma->getNumber();
      }
      else
      {
         $this->value = "-";
      }
   }

}