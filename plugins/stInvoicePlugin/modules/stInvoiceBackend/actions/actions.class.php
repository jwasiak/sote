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
 * @version     $Id: actions.class.php 2285 2009-07-23 12:50:05Z bartek $
 * @author      Bartosz Alejski <bartosz.alejski@sote.pl>
 */

/**
 * Klasa stInvoiceFrontendActions.
 *
 * @package     stInvoicePlugin
 * @subpackage  actions
 */
class stInvoiceBackendActions extends autoStInvoiceBackendActions
{

   public function executeSaveConfigContent()
   {
      $this->forward('stInvoiceBackend', 'configCustom');
   }

   public function updateConfigCustomFromRequest()
   {
      $updateInvoiceDefault = $this->getRequestParameter('invoiceDefault');
      $this->invoiceDefault->set('invoice_on', isset($updateInvoiceDefault['invoice_on']));
      $this->invoiceDefault->set('proforma_on', isset($updateInvoiceDefault['proforma_on']));
      $this->invoiceDefault->set('shop_currency', isset($updateInvoiceDefault['shop_currency']));
      $this->invoiceDefault->set('vat_eu', isset($updateInvoiceDefault['vat_eu']));
      $this->invoiceDefault->set('show_product_code', isset($updateInvoiceDefault['show_product_code']));
      $this->invoiceDefault->set('company_description', $updateInvoiceDefault['company_description']);
      $this->invoiceDefault->set('invoice_description', $updateInvoiceDefault['invoice_description'], true);
      $this->invoiceDefault->set('town', $updateInvoiceDefault['town']);
      $this->invoiceDefault->set('date_label', $updateInvoiceDefault['date_label'], true);
      $this->invoiceDefault->set('invoice_label', $updateInvoiceDefault['invoice_label'], true);
      $this->invoiceDefault->set('seller_company', $updateInvoiceDefault['seller_company']);
      $this->invoiceDefault->set('seller_vat_number', $updateInvoiceDefault['seller_vat_number']);
      $this->invoiceDefault->set('seller_full_name', $updateInvoiceDefault['seller_full_name']);
      $this->invoiceDefault->set('seller_address', $updateInvoiceDefault['seller_address']);
      $this->invoiceDefault->set('seller_address_more', $updateInvoiceDefault['seller_address_more']);
      $this->invoiceDefault->set('seller_region', $updateInvoiceDefault['seller_region']);
      $this->invoiceDefault->set('seller_code', $updateInvoiceDefault['seller_code']);
      $this->invoiceDefault->set('seller_town', $updateInvoiceDefault['seller_town']);
      $this->invoiceDefault->set('seller_country', $updateInvoiceDefault['seller_country']);
      $this->invoiceDefault->set('seller_signature', $updateInvoiceDefault['seller_signature']);
      $this->invoiceDefault->set('customer_company', $updateInvoiceDefault['customer_company']);
      $this->invoiceDefault->set('customer_vat_number', $updateInvoiceDefault['customer_vat_number']);
      $this->invoiceDefault->set('customer_full_name', $updateInvoiceDefault['customer_full_name']);
      $this->invoiceDefault->set('customer_address', $updateInvoiceDefault['customer_address']);
      $this->invoiceDefault->set('customer_address_more', $updateInvoiceDefault['customer_address_more']);
      $this->invoiceDefault->set('customer_region', $updateInvoiceDefault['customer_region']);
      $this->invoiceDefault->set('customer_code', $updateInvoiceDefault['customer_code']);
      $this->invoiceDefault->set('customer_town', $updateInvoiceDefault['customer_town']);
      $this->invoiceDefault->set('customer_country', $updateInvoiceDefault['customer_country']);
      $this->invoiceDefault->set('customer_signature', $updateInvoiceDefault['customer_signature']);
      $this->invoiceDefault->set('number_proforma', $updateInvoiceDefault['number_proforma']);
      $this->invoiceDefault->set('number_confirm', $updateInvoiceDefault['number_confirm']);
      $this->invoiceDefault->set('number_proforma_format_prefix', $updateInvoiceDefault['number_proforma_format_prefix']);
      $this->invoiceDefault->set('number_proforma_format', $updateInvoiceDefault['number_proforma_format']);
      $this->invoiceDefault->set('number_proforma_format_sufix', $updateInvoiceDefault['number_proforma_format_sufix']);
      $this->invoiceDefault->set('number_proforma_format_separator', $updateInvoiceDefault['number_proforma_format_separator']);
      $this->invoiceDefault->set('number_format_prefix', $updateInvoiceDefault['number_format_prefix']);
      $this->invoiceDefault->set('number_format', $updateInvoiceDefault['number_format']);
      $this->invoiceDefault->set('number_format_sufix', $updateInvoiceDefault['number_format_sufix']);
      $this->invoiceDefault->set('number_format_separator', $updateInvoiceDefault['number_format_separator']);
      $this->invoiceDefault->set('status_proforma_on', isset($updateInvoiceDefault['status_proforma_on']));
      $this->invoiceDefault->set('max_day', $updateInvoiceDefault['max_day']);      
   }

   public function validateConfigCustom()
   {
      $this->checkCredentials();

      $request = $this->getRequest();

      if ($request->getMethod() == sfRequest::POST)
      {
         $invoice = $request->getParameter('invoiceDefault');

         if ($invoice['vat_eu'] && !stTaxVies::getInstance()->checkVat($invoice['seller_vat_number']))
         {
            $request->setError('invoiceDefault{seller_vat_number}', 'Podany numer VAT UE jest nieprawidłowy');
         }
      }

      return !$request->hasErrors();
   }

   public function handleErrorConfigCustom()
   {
      $this->invoiceDefault = stConfig::getInstance($this->getContext(), 'stInvoiceBackend');

      $this->updateConfigCustomFromRequest();

      return sfView::SUCCESS;
   }

   public function executeConfigCustom()
   {
      $i18n = sfI18N::getInstance();
      $this->invoiceDefault = stConfig::getInstance('stInvoiceBackend');
      $this->invoiceDefault->setCulture($this->getRequestParameter('culture', stLanguage::getOptLanguage()));
        
      if ($this->getRequest()->getMethod() == sfRequest::POST)
      {
      
         $this->updateConfigCustomFromRequest();

         $this->invoiceDefault->save(true);
         $this->setFlash('notice',  $i18n->__('Twoje zmiany zostały zapisane')); 
         $this->redirect('stInvoiceBackend/configCustom?culture='.$this->getRequestParameter('culture', stLanguage::getOptLanguage()));
      }

      //return parent::executeConfigCustom();      
   }

   public function executeSaveEditProformaInvoice()
   {
      if ($this->getRequest()->getMethod() == sfRequest::POST)
      {
         $this->checkCredentials();

         $updateInvoice = $this->getRequestParameter('invoice');

         $updateInvoiceProducts = $this->getRequestParameter('invoice_product');

         $updateInvoiceUserSeller = $this->getRequestParameter('invoice_user_seller');

         $updateInvoiceUserCustomer = $this->getRequestParameter('invoice_user_customer');

         if ($this->hasRequestParameter("addNwProduct"))
         {
            $this->addProformaInvoiceProduct($updateInvoice['invoice_id']);
         }
         $this->updateInvoice($updateInvoice, $updateInvoiceUserCustomer, $updateInvoiceUserSeller, $updateInvoiceProducts);

         if ($this->hasRequestParameter("updateStatusInvoice"))
         {
            $this->updateStatusInvoiceAsPayment($updateInvoice['invoice_id']);
         }
         $this->redirect("stInvoiceBackend/viewEditCustom?id=" . $updateInvoice['invoice_id'] . "&type=" . $updateInvoice['type']);
      }
   }

   public function executeDeleteProformaInvoiceProduct()
   {
      $this->checkCredentials();

      $product_id = $this->getRequestParameter('product_id');
      $invoice_id = $this->getRequestParameter('id');

      $this->delateProformaInvoiceProduct($product_id);

      $this->redirect("stInvoiceBackend/viewEditCustom?id=" . $invoice_id);
   }

   public function addProformaInvoiceProduct($invoice_id)
   {

      $c = new Criteria();
      $c->add(TaxPeer::IS_DEFAULT, 1);
      $tax = TaxPeer::doSelectOne($c);

      $invoiceProduct = new InvoiceProduct();

      $invoiceProduct->setInvoiceId($invoice_id);
      $invoiceProduct->setVatId($tax->getId());
      $invoiceProduct->setVat($tax->getVat());
      $invoiceProduct->setDiscount(0);
      $invoiceProduct->setQuantity(1);

      $invoiceProduct->save();
   }

   public function delateProformaInvoiceProduct($product_id)
   {
      $c = new Criteria();
      $c->add(InvoiceProductPeer::ID, $product_id);
      $invoiceProducts = InvoiceProductPeer::doDelete($c);
   }

   public function executeUpdate()
   {
      $order_id = $this->getRequestParameter('id');
      $invoice_id = $this->getRequestParameter('invoice_id');

      $c = new Criteria();
      $c->add(OrderPeer::ID, $order_id);
      $order = OrderPeer::doSelectOne($c);

      $c = new Criteria();
      $c->add(InvoicePeer::ID, $invoice_id);
      $invoice = InvoicePeer::doSelectOne($c);

      stInvoice::updateInvoice($order, $invoice);
      $this->redirect("stInvoiceBackend/viewCustom?id=" . $invoice->getId());
   }

   public function updateInvoice($incomingInvoice, $incomingInvoiceUserCustomer, $incomingInvoiceUserSeller, $incomingInvoiceProducts)
   {
      $c = new Criteria();
      $c->add(InvoicePeer::ID, $incomingInvoice['invoice_id']);
      $invoice = InvoicePeer::doSelectOne($c);

      $invoice->setCompanyDescription($incomingInvoice['company_description']);
      $invoice->setInvoiceDescription($incomingInvoice['invoice_description']);
      $invoice->setDateSelle($incomingInvoice['date_selle']);
      $invoice->setDateCreateCopy($incomingInvoice['date_create_copy']);
      $invoice->setSignatureSeller($incomingInvoice['seller_signature']);
      $invoice->setSignatureCustomer($incomingInvoice['customer_signature']);
      $invoice->setTown($incomingInvoice['town']);
      $invoice->setMaxDay($incomingInvoice['max_day']);
      $invoice->setPaymentType($incomingInvoice['payment_type']);

      $invoice->setNumber($incomingInvoice['number']);

      $invoice->save();

      $c = new Criteria();
      $c->add(InvoiceUserCustomerPeer::ID, $incomingInvoiceUserCustomer['user_customer_id']);
      $invoiceUserCustomer = InvoiceUserCustomerPeer::doSelectOne($c);

      $invoiceUserCustomer->setCountry($incomingInvoiceUserCustomer['country']);
      $invoiceUserCustomer->setFullName($incomingInvoiceUserCustomer['full_name']);
      $invoiceUserCustomer->setAddress($incomingInvoiceUserCustomer['address']);
      $invoiceUserCustomer->setAddressMore($incomingInvoiceUserCustomer['address_more']);
      $invoiceUserCustomer->setRegion($incomingInvoiceUserCustomer['region']);
      $invoiceUserCustomer->setCode($incomingInvoiceUserCustomer['code']);
      $invoiceUserCustomer->setTown($incomingInvoiceUserCustomer['town']);
      $invoiceUserCustomer->setPesel($incomingInvoiceUserCustomer['pesel']);
      $invoiceUserCustomer->setCompany($incomingInvoiceUserCustomer['company']);
      $invoiceUserCustomer->setVatNumber($incomingInvoiceUserCustomer['vat_number']);

      $invoiceUserCustomer->save();

      $c = new Criteria();
      $c->add(InvoiceUserSellerPeer::ID, $incomingInvoiceUserSeller['user_seller_id']);
      $invoiceUserSeller = InvoiceUserSellerPeer::doSelectOne($c);
      $invoiceUserSeller->setCountry($incomingInvoiceUserSeller['country']);
      $invoiceUserSeller->setFullName($incomingInvoiceUserSeller['full_name']);
      $invoiceUserSeller->setAddress($incomingInvoiceUserSeller['address']);
      $invoiceUserSeller->setAddressMore($incomingInvoiceUserSeller['address_more']);
      $invoiceUserSeller->setRegion($incomingInvoiceUserSeller['region']);
      $invoiceUserSeller->setCode($incomingInvoiceUserSeller['code']);
      $invoiceUserSeller->setTown($incomingInvoiceUserSeller['town']);
      $invoiceUserSeller->setCompany($incomingInvoiceUserSeller['company']);
      $invoiceUserSeller->setVatNumber($incomingInvoiceUserSeller['vat_number']);

      $invoiceUserSeller->save();


      $optTotalPriceBrutto = 0;
      foreach ($incomingInvoiceProducts as $row)
      {
         $vatArray = explode(":", $row['vat']);

         $c = new Criteria();
         $c->add(InvoiceProductPeer::ID, $row['product_id']);
         $product = InvoiceProductPeer::doSelectOne($c);

         $product->setCode($row['code']);
         $product->setName($row['name']);
         $product->setPkwiu($row['pkwiu']);
         $product->setQuantity($row['quantity']);
         $product->setMeasureUnit($row['measure_unit']);
         $product->setDiscount($row['discount']);
         $product->setPriceNetto($row['price_netto']);
         $product->setPriceBrutto($row['price_brutto']);
         $product->setVatId($vatArray[0]);
         $product->setVat($vatArray[1]);
         $product->setVatAmmount($row['vat_ammount']);
         $product->setTotalPriceNetto($row['total_price_netto']);
         $product->setOptTotalPriceBrutto($row['opt_total_price_brutto']);

         $product->save();

         $optTotalPriceBrutto += $row['opt_total_price_brutto'];
      }

      $invoice->setOptTotalAmmountBrutto($optTotalPriceBrutto);
      $invoice->save();
   }

   public function copyInvoice($id)
   {
      $c = new Criteria();
      $c->add(InvoicePeer::ID, $id);
      $invoice = InvoicePeer::doSelectOne($c);

      $c = new Criteria();
      $c->add(InvoiceUserCustomerPeer::ID, $invoice->getInvoiceUserCustomerId());
      $invoiceUserCustomer = InvoiceUserCustomerPeer::doSelectOne($c);

      $cloneInvoiceUserCustomer = $invoiceUserCustomer->copy();
      $cloneInvoiceUserCustomer->save();

      $c = new Criteria();
      $c->add(InvoiceUserSellerPeer::ID, $invoice->getInvoiceUserSellerId());
      $invoiceUserSeller = InvoiceUserSellerPeer::doSelectOne($c);

      $cloneInvoiceUserSeller = $invoiceUserSeller->copy();
      $cloneInvoiceUserSeller->save();

      $cloneInvoice = $invoice->copy();
      $cloneInvoice->setInvoiceUserSellerId($cloneInvoiceUserSeller->getId());
      $cloneInvoice->setInvoiceUserCustomerId($cloneInvoiceUserCustomer->getId());

      $cloneInvoice->save();

      $c = new Criteria();
      $c->add(InvoiceStatusPeer::INVOICE_ID, $id);
      $invoiceStatus = InvoiceStatusPeer::doSelectOne($c);

      $cloneInvoiceStatus = $invoiceStatus->copy();
      $cloneInvoiceStatus->setInvoiceId($cloneInvoice->getId());

      $cloneInvoiceStatus->save();

      $c = new Criteria();
      $c->add(InvoiceProductPeer::INVOICE_ID, $id);
      $invoiceProducts = InvoiceProductPeer::doSelect($c);

      foreach ($invoiceProducts as $product)
      {
         $cloneProduct = $product->copy();

         $cloneProduct->setInvoiceId($cloneInvoice->getId());

         $cloneProduct->save();
      }

      return $cloneInvoice;
   }

   public function executeMakeConfirmInvoice()
   {
      $this->checkCredentials();
      
      $ifirmaConfig = stConfig::getInstance(sfContext::getInstance(), 'stInvoiceBackend');

      $invoice_id = $this->getRequestParameter('id');
      $type = $this->getRequestParameter('type');

      if ($type == "proforma")
      {

         //sprawdz czy istnieje faktura do wystawienia
         $c = new Criteria();
         $c->add(InvoicePeer::INVOICE_PROFORMA_ID, $invoice_id);
         $c->add(InvoicePeer::IS_REQUEST, 1);
         $invoice = InvoicePeer::doSelectOne($c);

         if ($invoice)
         {
            $c = new Criteria();
            $c->add(InvoicePeer::ID, $invoice->getId());
            $invoice = InvoicePeer::doSelectOne($c);

            $invoice->setNumber($this->createInvoiceNumber("confirm", 1));
            $invoice->setDateCreateCopy(date("Y-m-d"));
            $invoice->setDateSelle(date("Y-m-d"));
            $invoice->setIsConfirm(1);
            $invoice->setIsRequest(0);
            $invoice->setIsProforma(0);
            $invoice->save();

            stInvoice::updateInvoice($invoice->getOrder(), $invoice);

            if ($ifirmaConfig->get('ifirma_enabled')) {
                stIfirmaListener::makeInvoiceForOrder($invoice->getOrder());
                $this->redirect('stOrder/edit?id='.$invoice->getOrder()->getId());
            }   
        
            $this->redirect("stInvoiceBackend/viewCustom?id=" . $invoice->getId() . "&type=confirm");
         }
         else
         {
            $newInvoice = $this->copyInvoice($invoice_id);

            $number = $this->createInvoiceNumber("confirm", 1);

            $newInvoice->setNumber($number);
            $newInvoice->setDateCreateCopy(date("Y-m-d"));
            $newInvoice->setDateSelle(date("Y-m-d"));
            $newInvoice->setIsConfirm(1);
            $newInvoice->setIsRequest(0);
            $newInvoice->setIsProforma(0);
            $newInvoice->save();

            stInvoice::updateInvoice($newInvoice->getOrder(), $newInvoice);

            if ($ifirmaConfig->get('ifirma_enabled')) {
                stIfirmaListener::makeInvoiceForOrder($newInvoice->getOrder());
                $this->redirect('stOrder/edit?id='.$newInvoice->getOrder()->getId());
            }   


            $this->redirect("stInvoiceBackend/viewCustom?id=" . $newInvoice->getId() . "&type=confirm");
         }
      }

      if ($type == "request")
      {

         $c = new Criteria();
         $c->add(InvoicePeer::ID, $invoice_id);
         $invoice = InvoicePeer::doSelectOne($c);

         $invoice->setNumber($this->createInvoiceNumber("confirm", 1));
         $invoice->setDateCreateCopy(date("Y-m-d"));
         $invoice->setDateSelle(date("Y-m-d"));
         $invoice->setIsConfirm(1);
         $invoice->setIsRequest(0);
         $invoice->setIsProforma(0);
         $invoice->save();

         stInvoice::updateInvoice($invoice->getOrder(), $invoice);

         if ($ifirmaConfig->get('ifirma_enabled')) {
             stIfirmaListener::makeInvoiceForOrder($invoice->getOrder());
             $this->redirect('stOrder/edit?id='.$invoice->getOrder()->getId());
         }   

         $this->redirect("stInvoiceBackend/viewCustom?id=" . $invoice_id . "&type=confirm");
      }

      // generowanie numeru
      // przypadek zmian w proformie
   }

   public function executeConfirmList()
   {

      parent::executeConfirmList();

      $this->pager->getCriteria()->add(InvoicePeer::IS_CONFIRM, 1);

      $this->pager->init();
   }

   public function executeRequestList()
   {

      parent::executeRequestList();

      $this->pager->getCriteria()->add(InvoicePeer::IS_REQUEST, 1);

      $this->pager->init();
   }

   public function executeProformaList()
   {

      parent::executeProformaList();

      $this->pager->getCriteria()->add(InvoicePeer::IS_PROFORMA, 1);

      $this->pager->init();
   }

   public function getInvoiceNumber($type)
   {
      $this->invoiceDefault = stConfig::getInstance($this->getContext(), 'stInvoiceBackend');
      $invoice = $this->invoiceDefault->load();

      if ($type == "proforma")
      {

         return $invoice['number_proforma'];
      }

      if ($type == "confirm")
      {
         return $invoice['number_confirm'];
      }
   }

   public function incarseInvoiceNumber($type)
   {

      $this->invoiceDefault = stConfig::getInstance($this->getContext(), 'stInvoiceBackend');
      $invoice = $this->invoiceDefault->load();

      if ($type == "proforma")
      {
         $this->invoiceDefault->set('number_proforma', $invoice['number_proforma'] + 1);
      }

      if ($type == "confirm")
      {
         $this->invoiceDefault->set('number_confirm', $invoice['number_confirm'] + 1);
      }

      $this->invoiceDefault->save(true);
   }

   public function createInvoiceNumber($type, $inc)
   {
      $this->invoiceDefault = stConfig::getInstance($this->getContext(), 'stInvoiceBackend');
      $invoice = $this->invoiceDefault->load();

      $number = "";

      if ($type == "proforma")
      {
         if ($invoice['number_proforma_format_prefix'] != "")
         {
            $number.= $invoice['number_proforma_format_prefix'];
            $number.= $invoice['number_proforma_format_separator'];
         }

         if ($invoice['number_proforma_format'] == 1)
         {
            $number.= $this->invoiceDefault->get('number_proforma');
            $number.= $invoice['number_format_separator'];
            $number.= date('m');
            $number.= $invoice['number_format_separator'];
            $number.= date('Y');
         }

         if ($invoice['number_proforma_format'] == 2)
         {
            $number.= $this->invoiceDefault->get('number_proforma');
            $number.= $invoice['number_format_separator'];
            $number.= date('Y');
         }

         if ($invoice['number_proforma_format'] == 3)
         {
            $number.= $this->invoiceDefault->get('number_proforma');
         }

         if ($invoice['number_proforma_format_sufix'] != "")
         {
            $number.= $invoice['number_proforma_format_separator'];
            $number.= $invoice['number_proforma_format_sufix'];
         }
      }

      if ($type == "confirm")
      {

         if ($invoice['number_format_prefix'] != "")
         {
            $number.= $invoice['number_format_prefix'];
            $number.= $invoice['number_format_separator'];
         }

         if ($invoice['number_format'] == 1)
         {
            $number.= $this->invoiceDefault->get('number_confirm');
            $number.= $invoice['number_format_separator'];
            $number.= date('m');
            $number.= $invoice['number_format_separator'];
            $number.= date('Y');
         }

         if ($invoice['number_format'] == 2)
         {
            $number.= $this->invoiceDefault->get('number_confirm');
            $number.= $invoice['number_format_separator'];
            $number.= date('Y');
         }

         if ($invoice['number_format'] == 3)
         {
            $number.= $this->invoiceDefault->get('number_confirm');
         }


         if ($invoice['number_format_sufix'] != "")
         {
            $number.= $invoice['number_format_separator'];
            $number.= $invoice['number_format_sufix'];
         }
      }

      if ($inc == 1)
      {
         $this->invoiceDefault->set('number_'.$type, $this->invoiceDefault->get('number_'.$type) + 1);

         $this->invoiceDefault->save(true);
      }

      return $number;
   }

   public function executeConfirmall()
   {
      // pobranie id zaznaczonych elementów
      $ids = $this->getRequestParameter('invoice[selected]', array());
      foreach ($ids as $id)
      {
         $this->makeConfirmAllInvoice($id);
      }
      // powrót
      return $this->redirect('stInvoiceBackend/requestList');
   }

   public function makeConfirmAllInvoice($id = null)
   {
      $c = new Criteria();
      $c->add(InvoicePeer::ID, $id);
      $invoice = InvoicePeer::doSelectOne($c);

      $invoice->setNumber($this->createInvoiceNumber("confirm", 1));
      $invoice->setDateCreateCopy(date("Y-m-d"));
      $invoice->setDateSelle(date("Y-m-d"));
      $invoice->setIsConfirm(1);
      $invoice->setIsRequest(0);
      $invoice->setIsProforma(0);
      $invoice->save();

      $c = new Criteria();
      $c->add(InvoiceStatusPeer::INVOICE_ID, $id);
      $invoiceStatus = InvoiceStatusPeer::doSelectOne($c);

      if ($invoiceStatus->getHandMod() != 1)
      {
         $this->updateStatusInvoiceAsPayment($id);
      }
   }

   public function getChangeStatus($invoice_id)
   {
      //  Pobierz status faktury

      $c = new Criteria();
      $c->add(InvoiceStatusPeer::INVOICE_ID, $invoice_id);
      $invoiceStatus = InvoiceStatusPeer::doSelectOne($c);

      //  Pobierz statusy płatnosci

      $c = new Criteria();
      $c->add(PaymentPeer::ID, $invoiceStatus->getPaymentId());
      $payment = PaymentPeer::doSelectOne($c);

      //  Pobierz typ płatnosci

      $c = new Criteria();
      $c->add(PaymentTypePeer::ID, $payment->getPaymentTypeId());
      $orderPaymentType = PaymentTypePeer::doSelectOne($c);


      $c = new Criteria();
      $c->add(PaymentTypePeer::ID, $invoiceStatus->getOptPaymentTypeId());
      $invoicePaymentType = PaymentTypePeer::doSelectOne($c);

      $chenges = array();

      if ($payment->getStatus() != $invoiceStatus->getOptPaymentStatus())
      {

         $chenges['invoice']['status'] = $invoiceStatus->getOptPaymentStatus();

         $chenges['payment']['status'] = $payment->getStatus();

         $chenges['invoice']['type']['id'] = $invoicePaymentType->getId();
         $chenges['invoice']['type']['name'] = $invoicePaymentType->getOptName();

         $chenges['payment']['type']['id'] = $orderPaymentType->getId();
         $chenges['payment']['type']['name'] = $orderPaymentType->getOptName();
      }



      if ($orderPaymentType->getId() != $invoicePaymentType->getId())
      {
         $chenges['invoice']['status'] = $invoiceStatus->getOptPaymentStatus();

         $chenges['payment']['status'] = $payment->getStatus();

         $chenges['invoice']['type']['id'] = $invoicePaymentType->getId();
         $chenges['invoice']['type']['name'] = $invoicePaymentType->getOptName();

         $chenges['payment']['type']['id'] = $orderPaymentType->getId();
         $chenges['payment']['type']['name'] = $orderPaymentType->getOptName();
      }

      return $chenges;
   }

   public function checkChangeStatus($invoice_id)
   {
      //  Pobierz status faktury

      $c = new Criteria();
      $c->add(InvoiceStatusPeer::INVOICE_ID, $invoice_id);
      $invoiceStatus = InvoiceStatusPeer::doSelectOne($c);

      //  Pobierz statusy płatnosci

      $c = new Criteria();
      $c->add(PaymentPeer::ID, $invoiceStatus->getPaymentId());
      $payment = PaymentPeer::doSelectOne($c);

      //  Pobierz typ płatnosci

      $c = new Criteria();
      $c->add(PaymentTypePeer::ID, $payment->getPaymentTypeId());
      $orderPaymentType = PaymentTypePeer::doSelectOne($c);

      $c = new Criteria();
      $c->add(PaymentTypePeer::ID, $invoiceStatus->getOptPaymentTypeId());
      $invoicePaymentType = PaymentTypePeer::doSelectOne($c);

      $chenges = array();

      if ($payment->getStatus() != $invoiceStatus->getOptPaymentStatus())
      {
         return true;
      }


      if ($orderPaymentType->getId() != $invoicePaymentType->getId())
      {
         return true;
      }

      return false;
   }

   public function saveInvoiceStatus($id = null, $new_status, $hand_mod = 0)
   {

      $c = new Criteria();
      $c->add(InvoiceStatusPeer::INVOICE_ID, $id);
      $invoiceStatus = InvoiceStatusPeer::doSelectOne($c);


      if ($invoiceStatus)
      {

         $invoiceStatus->setOptPaymentTypeName($new_status['name']);
         $invoiceStatus->setOptPaymentTypeId($new_status['type_id']);
         $invoiceStatus->setOptPaymentStatus($new_status['is_confirm']);
         $invoiceStatus->setHandMod($hand_mod);

         $invoiceStatus->save();

         return $invoiceStatus;
      }
   }

   public function updateStatusInvoiceAsPayment($id)
   {
      if ($this->checkChangeStatus($id))
      {
         $statusInfo = $this->getChangeStatus($id);

         if ($statusInfo['payment']['status'] == "")
         {
            $statusInfo['payment']['status'] = 0;
         }

         $new_status['name'] = $statusInfo['payment']['type']['name'];
         $new_status['type_id'] = $statusInfo['payment']['type']['id'];
         $new_status['is_confirm'] = $statusInfo['payment']['status'];

         $this->saveInvoiceStatus($id, $new_status, 0);
      }
   }

  public function executeIfirmaConfig() 
  {
  $i18n = sfI18N::getInstance();
    
    $this->forward_parameters = $this->getUser()->getAttributeHolder()->getAll('sf_admin/autoStInvoiceBackend/ifirma_forward_parameters');
      
    $this->config = $this->loadIfirmaConfigOrCreate();
  
    $this->labels = $this->getIfirmaConfigLabels();
    
    if ($this->getRequest()->getMethod() == sfRequest::POST) 
    {  
        $this->updateIfirmaConfigFromRequest();
    
        $this->saveIfirmaConfig();
        
        $this->setFlash('notice', $i18n->__('Twoje zmiany zostały zapisane', null, 'stAdminGeneratorPlugin'));
        
        return $this->redirect('stInvoiceBackend/ifirmaConfig?culture='.$this->config->getCulture());
    } 
  }  

  public function executeRegisterIfirmaConfig() 
  {
    $i18n = sfI18N::getInstance();
    
    $this->forward_parameters = $this->getUser()->getAttributeHolder()->getAll('sf_admin/autoStInvoiceBackend/register_ifirma_forward_parameters');
      
    $this->config = $this->loadRegisterIfirmaConfigOrCreate();
  
    $this->labels = $this->getRegisterIfirmaConfigLabels();
    
    if ($this->getRequest()->getMethod() == sfRequest::POST) 
    {  
        $this->updateRegisterIfirmaConfigFromRequest();
    
        $this->saveRegisterIfirmaConfig();
        
        $this->setFlash('notice', $i18n->__('Rejestracja zakończona powodzeniem. Na podany adres email zostały wysłane informacje (login oraz hasło) dotyczące logowania w serwisie.', null, 'stInvoiceBackend'));
        
        return $this->redirect('stInvoiceBackend/registerIfirmaConfig?culture='.$this->config->getCulture());
    } 
  } 

    public function handleErrorRegisterIfirmaConfig()
    {
    $i18n = sfI18N::getInstance();
    
    $this->forward_parameters = $this->getUser()->getAttributeHolder()->getAll('sf_admin/autoStInvoiceBackend/register_ifirma_forward_parameters');
      
    $this->config = $this->loadRegisterIfirmaConfigOrCreate();
  
    $this->labels = $this->getRegisterIfirmaConfigLabels();
    
    return sfView::SUCCESS;
    }

    protected function checkCredentials()
    {
      stAuthUsersListener::checkModificationCredentials($this, $this->getRequest(), $this->getModuleName());      
    }

}
