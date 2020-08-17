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
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: actions.class.php 17561 2012-03-29 09:15:29Z marcin $
 */

/**
 * Akcje aplikacji stOrder
 *
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 *
 * @package     stOrder
 * @subpackage  actions
 */
class stOrderActions extends stActions
{
   public function preExecute()
   {
      $ret = parent::preExecute();

      if ($this->hasSessionExpired() && !$this->getRequest()->isXmlHttpRequest() && in_array($this->getContext()->getActionName(), array('confirm', 'save')))
      {
         return $this->redirect('@stBasket?action=index&session_expired=true');
      }

      $this->getUser()->setParameter('hide', true, 'soteshop/stLanguagePlugin');
      $this->getUser()->setParameter('hide', true, 'soteshop/stCurrencyPlugin');

      return $ret;
   }
   /**
    * Zwraca użytkownika
    *
    * @return   stUser
    */
   public function getUser()
   {
      return parent::getUser();
   }

   /**
    * Zwraca obiekt obsługi zdarzeń
    *
    * @return   stEventDispatcher
    */
   public function getDispatcher()
   {
      return stEventDispatcher::getInstance();
   }

   /**
    * Wyświetla listę zamówien klienta
    */
   public function executeList()
   {
      $this->smarty = new stSmarty($this->getModuleName());

      $this->forwardif($this->getUser()->isAnonymous(), 'stUser', 'loginUser');

      $c = new Criteria();

      $c->addDescendingOrderByColumn(OrderPeer::CREATED_AT);

      $c->add(OrderPeer::SF_GUARD_USER_ID, $this->getUser()->getGuardUser()->getId());

      $this->pager = new sfPropelPager('Order', 20);

      $this->pager->setCriteria($c);

      $this->pager->setPage($this->getRequestParameter('page'));

      $this->pager->init();
   }



   public function executeDownloadInvoice()
   {
      $this->smarty = new stSmarty($this->getModuleName());

      $this->order = OrderPeer::retrieveByIdAndHashCode($this->getRequestParameter('id'), $this->getRequestParameter('hash_code'));



      $this->forward404Unless($this->order, 'Operacja niedozwolona - brak zamówienia o podanym numerze i ciągu hash');

      stUser::loginUserOnlyUsername($this->order->getSfGuardUser()->getUsername());

      if($this->getRequestParameter('proforma')==1)
      {
         $c = new Criteria();
         $c->add(InvoicePeer::ORDER_ID, $this->getRequestParameter('id'));
         $c->add(InvoicePeer::IS_PROFORMA, 1);
         $invoice = InvoicePeer::doSelectOne($c);
      }

      if($this->getRequestParameter('proforma')==0)
      {
         $c = new Criteria();
         $c->add(InvoicePeer::ORDER_ID, $this->getRequestParameter('id'));
         $c->add(InvoicePeer::IS_CONFIRM, 1);
         $invoice = InvoicePeer::doSelectOne($c);
      }

      $this->redirect('stInvoicePdf/show?id='.$invoice->getId().'&download=1&hash_code='.$this->getRequestParameter('hash_code'));
   }



   /**
    * Wyświetla dane szczególowe zamówienia klienta
    */
   public function executeShow()
   {
      $this->smarty = new stSmarty($this->getModuleName());
      
      $this->basket_config = stConfig::getInstance('stBasket');
      
      $this -> config_points = stConfig::getInstance(sfContext::getInstance(), 'stPointsBackend');
      $this -> config_points->setCulture(sfContext::getInstance()->getUser()->getCulture());

      $this->order = OrderPeer::retrieveByIdAndHashCode($this->getRequestParameter('id'), $this->getRequestParameter('hash_code'));

      $this->forward404Unless($this->order, 'Operacja niedozwolona - brak zamówienia o podanym numerze i ciągu hash');

      $this->user_data_billing = $this->order->getOrderUserDataBilling();

      $this->user_data_delivery = $this->order->getOrderUserDataDelivery();

      $this->currency = $this->order->getOrderCurrency();

      $this->delivery = $this->order->getOrderDelivery();

      if ($this->order->getOrderPayment() && $this->order->getOrderPayment()->getPaymentType())
      {
         $this->payment = $this->order->getOrderPayment()->getPaymentType();
      }

      $this->order_products = $this->order->getOrderProducts();

      if ($this->getRequestParameter('confirm'))
      {

         // if ($this->getRequestParameter('cancel') == 1)
         // {
            // $this->order->setOrderStatusId(1);
// 
            // $this->order->save();
// 
            // $this->setFlash('notice', 'Zamówienie zostało anulowane.');
// 
            // $this->redirect('@stOrderShowForUser?id='.$this->order->getId().'&hash_code='.$this->order->getHashCode());
         // }

         if (!$this->order->getIsConfirmed())
         {
            $this->order->setIsConfirmed(true);

            $this->order->save();

            $this->setFlash('notice', 'Twoje zamówienie zostało potwierdzone.');
         }
         else
         {
            $this->setFlash('notice', 'Twoje zamówienie zostało już wcześniej potwierdzone.');
         }

         if ($this->getRequestParameter('register') == 1)
         {
            stUser::setIsConfirm($this->order->getSfGuardUser()->getUsername());
            stUser::loginUserOnlyUsername($this->order->getSfGuardUser()->getUsername());

            $this->redirect('@stOrderShowForUser?id='.$this->order->getId().'&hash_code='.$this->order->getHashCode());
         }
         else
         {
            $this->redirect('@stOrderShowForUser?id='.$this->order->getId().'&hash_code='.$this->order->getHashCode());
         }
      }
   }

   /**
    * Akcja wyświetlająca strone potwierdzenia
    */
   public function executeConfirm()
   {
      $this->smarty = new stSmarty($this->getModuleName());  
      
      $this->basket_config = stConfig::getInstance('stBasket');
      
      $this->compatibility_config = stConfig::getInstance('stCompatibilityBackend');
      
      $this -> config_points = stConfig::getInstance(sfContext::getInstance(), 'stPointsBackend');
      $this -> config_points->setCulture(sfContext::getInstance()->getUser()->getCulture());

      $this->setFlash('stCurrency-hide_list', true);

      $user_data_billing = $this->getRequestParameter('user_data_billing');
      
      $user_data_delivery = $this->getRequestParameter('user_data_delivery');
      
        if(!isset($user_data_billing['create_account'])){$user_data_billing['create_account'] = 0;}
        
        if(!isset($user_data_billing['privacy'])){$user_data_billing['privacy'] = 0;}
        
        if(!isset($user_data_billing['different_delivery']) && !$this->getUser()->isAuthenticated())
        {
            $user_data_billing['different_delivery'] = 0;
            $user_data_delivery['customer_type'] = $user_data_billing['customer_type'];
            $user_data_delivery['company'] = $user_data_billing['company'];
            if(isset($user_data_billing['pesel'])){$user_data_delivery['pesel'] = $user_data_billing['pesel'];}
            $user_data_delivery['full_name'] = $user_data_billing['full_name'];
            $user_data_delivery['address'] = $user_data_billing['address'];
         if (isset($user_data_billing['address_more']))
         {
            $user_data_delivery['address_more'] = $user_data_billing['address_more'];
         }
            $user_data_delivery['code'] = $user_data_billing['code'];
            $user_data_delivery['town'] = $user_data_billing['town'];
            if(isset($user_data_billing['region'])){$user_data_delivery['region'] = $user_data_billing['region'];}
            $user_data_delivery['country'] = $user_data_billing['country'];
            $user_data_delivery['phone'] = $user_data_billing['phone'];
        }
      
       $invoice_config = stConfig::getInstance($this->getContext(), 'stInvoiceBackend');

       if($invoice_config->get('invoice_on')==1 && $invoice_config->get('auto_invoice_on')==1 && $user_data_billing['vat_number']!="")
       {
            $user_data_billing['invoice'] = 1;
       }
      
      
      $this->user_data_billing = $user_data_billing;

      $this->user_data_delivery = $user_data_delivery;

      $this->is_authenticated = $this->getUser()->isAuthenticated();

      $this->forward404Unless($user_data_billing, 'Operacja niedozwolona - brak danych bilingowych...');

      $this->forward404Unless($user_data_delivery, 'Operacja niedozwolona - brak danych dostawy...');

      $this->delivery_date = $this->getRequestParameter('delivery[date]');

      $this->delivery_time = $this->getRequestParameter('delivery[time]');

      $this->basket = stBasket::getInstance($this->getUser());

      $this->forward404if($this->basket->isEmpty(), 'Operacja niedozwolona - pusty koszyk...');

      $this->currency = stCurrency::getInstance($this->getContext())->get();

      $this->forward404Unless($this->currency, 'Operacja niedozwolona - brak ustawionej waluty...');

      $this->delivery = stDeliveryFrontend::getInstance($this->basket);

      $this->forward404Unless($this->delivery->getDefaultDelivery(), 'Operacja niedozwolona - brak ustawionej dostawy...');

      $total_amount = $this->delivery->getTotalDeliveryCost(true, true) + $this->basket->getTotalAmount(true, true);

      $final_total_amount = $total_amount;

      $paid = 0;

      if (stGiftCardPlugin::isActive() && stGiftCardPlugin::calculateAmountLeft($total_amount) == 0)
      {
         $pt = new PaymentType();

         $pt->setName('Bony zakupowe');

         $this->paymentType = $pt;
      }
      else
      {
         $this->paymentType = $this->delivery->getDefaultDelivery()->getDefaultPayment()->getPaymentType();
      }

      if (stGiftCardPlugin::isActive())
      {
         $paid = stGiftCardPlugin::getTotalAmountPaid();

         $final_total_amount -= $paid;
      }

      $this->forward404Unless($this->paymentType, 'Operacja niedozwolona - brak ustawionej platnosci...');

      $this->total_amount = $total_amount;

      $this->paid = $paid;

      $this->final_total_amount = $final_total_amount >= 0 ? $final_total_amount : 0;
      
      $this->additional_confirm_text = TextPeer::retrieveBySystemName('stOrderConfirm');
   }

   public function validateSave()
   {
      if($this->getUser()->isAuthenticated()){
          if(sfContext::getInstance()->getUser()->hasGroup('admin')){
            return $this->redirect('stOrder/adminOrder');    
          }
      }else{
          $user = sfGuardUserPeer::retrieveByUsername($this->getRequestParameter('user_data_billing[email]'));
      
          if($user){
              if($user->hasGroup('admin')){
                return $this->redirect('stOrder/adminOrder');    
              }   
          }
      }

      $config = stConfig::getInstance('stProduct');

      $request = $this->getRequest();

      $user_data_billing = $request->getParameter('user_data_billing');
      $user_data_delivery = $request->getParameter('user_data_delivery');

      $secure_token = stSecureToken::generate(array(
         'billing_country' => $user_data_billing['country'],
         'delivery_country' => $user_data_delivery['country'],
         'delivery_id' => $request->getParameter('delivery_id'),
         'payment_id' => $request->getParameter('payment_id'),
      ));

      $this->forward404if($secure_token != $request->getParameter('secure_token'), 'Operacja niedozwolona - nieprawidłowy token bezpieczeństwa');

      $basket = stBasket::getInstance($this->getUser());

      $this->forward404if($basket->isEmpty(), 'Operacja niedozwolona - pusty koszyk...');

      $currency = stCurrency::getInstance($this->getContext())->get();

      $this->forward404Unless($currency, 'Operacja niedozwolona - brak ustawionej waluty...');   

      $delivery = stDeliveryFrontend::getInstance($basket);

      $delivery->setDefaultDeliveryCountry($user_data_delivery['country']);

      $delivery->setDefaultDelivery($request->getParameter('delivery_id'));

      $delivery->getDefaultDelivery()->setDefaultPayment($request->getParameter('payment_id'));

      $this->forward404Unless($delivery->hasDefaultDelivery(), 'Operacja niedozwolona - brak ustawionej dostawy...');   

      $ok = true;

      $i18n = $this->getContext()->getI18N();
      
      if ($this->getRequest()->getMethod() == sfRequest::POST && $this->getUser()->hasVatEu())
      {
         $invoice_config = stConfig::getInstance('stInvoiceBackend');

         if (!stTaxVies::hasValidCountryCode($user_data_billing['vat_number'], $invoice_config->get('seller_vat_number')))
         {
            $this->getRequest()->setError('user_data_billing[vat_number]', $i18n->__('Podany numer VAT UE nie spełnia wymogów wewnątrzwspólnotowego nabycia towarów', null, 'stUserData'));
            $this->getUser()->setValidVatEu(false);
            $ok = false;                    
         }
         elseif (!stTaxVies::getInstance()->checkVat($user_data_billing['vat_number']))
         {
            $this->getRequest()->setError('user_data_billing[vat_number]', $i18n->__('Podany numer VAT UE jest nieaktywny lub nieprawidłowy', null, 'stUserData'));
            $this->getUser()->setValidVatEu(false);
            $ok = false;
         }
         else
         {
            $billingCountry = CountriesPeer::retrieveById($user_data_billing['country']);
            list($cc) = stTaxVies::parseVatNumber($user_data_billing['vat_number']);

            $ccEuFix = array('EL' => 'GR', 'CHE' => 'CH');

            if (isset($ccEuFix[$cc])) 
            {
               $cc = $ccEuFix[$cc];
            }
            
            if ($billingCountry->getIsoA2() != $cc)
            {
               $this->getRequest()->setError('user_data_billing[country]', $i18n->__('Wybrany kraj nie jest zgodny z podanym numerem VAT UE', null, 'stUserData'));
               $this->getUser()->setValidVatEu(false);
               $ok = false;                         
            }
            else
            {
               $this->getUser()->setValidVatEu(true);
            }
         }

         if (!$ok)
         {
            return false;
         }
      }
       
      stLock::wait('stOrder', 5);

      stLock::lock('stOrder');
      
      if ($this->getRequest()->getMethod() == sfRequest::POST)
      {         
         sfLoader::loadHelpers(array('Helper', 'stProduct'), 'stProduct');

         foreach ($basket->getItems() as $item)
         {      
            if (!$item->productValidate()) 
            {
               $request->setError('quantity_' . $item->getItemId(), $i18n->__('Product wycofany z oferty', null, 'stBasket'));

               $ok = false;
            } 
            else
            {
               $uom = st_product_uom($item->getProduct());

               $error = $basket->validateQuantity($item);  

               if ($error == stBasket::ERR_MAX_QTY) 
               {
                  $request->setError('quantity_' . $item->getItemId(), $i18n->__('Maksymalna ilość jaką możesz zamówić w ramach jednego zamówienia to %quantity% %uom%', array('%quantity%' => $item->getProductMaxQty(), '%uom%' => $uom), 'stBasket'));

                  $ok = false;
               }
               elseif ($error == stBasket::ERR_OUT_OF_STOCK) 
               {
                  $request->setError('quantity_' . $item->getItemId(), $i18n->__('Brak wymaganej ilości towaru w magazynie (dostępnych: %stock% %uom%)', array('%stock%' => $item->getMaxQuantity(), '%uom%' => $uom), 'stBasket'));

                  $ok = false;
               } 
               elseif ($error == stBasket::ERR_MIN_QTY) 
               {
                  $request->setError('quantity_' . $item->getItemId(), $i18n->__('Minimalna ilość to %quantity% %uom%', array('%quantity%' => $item->getProductMinQty(), '%uom%' => $uom), 'stBasket'));

                  $ok = false;
               }
               elseif ($error == stBasket::ERR_POINTS) 
               {
                  $request->setError('quantity_' . $item->getItemId(), $i18n->__('Brak wymaganej ilości punktów', null, 'stBasket'));

                  $ok = false;
               } 
            }  
         }        
      }

      if (!$ok) {
         stLock::unlock('stOrder');
      }

      return $ok;
   }
   
   public function handleErrorSave()
   {
      
      return $this->forward($this->getModuleName(), 'confirm');  
   }

   /**
    * Akcja zapisujacą dane zamówienie
    */
   public function executeSave()
   {     
       
      $basket = $this->getUser()->getBasket();

      $currency = stCurrency::getInstance($this->getContext())->get();

      $delivery = stDeliveryFrontend::getInstance($basket);

      $this->order = new Order();

      $this->order->setClientCulture($this->getUser()->getCulture());

      $this->order->setHost(sfContext::getInstance()->getRequest()->getHost());

      $this->order->setOrderStatus(OrderStatusPeer::retrieveDefaultPendingStatus());

      $this->updateCouponCode($basket);

      if ($basket->hasDiscount())
      {
         $this->order->setDiscount($basket->getDiscount());
      }

      $ret = $this->getDispatcher()->notifyUntil(new sfEvent($this, 'stOrderActions.preProcessOrderUserData', array('order' => $this->order)));

      if (!$ret->isProcessed())
      {
         $this->processOrderUserData();
      }

      $this->mirrorOrderCurrency($currency);

      $this->mirrorOrderProduct($basket->getItems());

      $this->mirrorOrderDelivery($delivery, $basket->getTotalAmount(true), $basket->getItems());

      if ($this->getRequest()->hasParameter('user_data_billing[description]'))
      {
         $this->description = $this->getRequestParameter('user_data_billing[description]');
         $this->order->setDescription($this->description);
      }

      $this->getDispatcher()->filter(new sfEvent($this, 'stOrderActions.filterOrderSave', array('order' => $this->order)), $this->order);

      // w przypadku gdy użytkownik ma pełne konto i jest zalogowany ustaw potwierdzenie na 1
      if ($this->getUser()->isAuthenticated() && stUser::isFullAccount($this->getUser()->getUsername()))
      {
         $this->order->setIsConfirmed(1);         
      }else{
          //if(!$this->getUser()->isAnonymousAccount()){
            $logout = 1;
          //}                    
      }

      $this->order->setSessionHash(session_id());
      
      $this->order->save();

      stLock::unlock('stOrder');

      $this->generateOrderNumber();
      
      // czyszczenie produktów w koszyku za punkty
      sfContext::getInstance() -> getUser() -> setAttribute('product_for_points', '', 'soteshop/stPointsFrontend');

      $this->processGiftCard();

      $basket->clear();

      $this->postExecute();

      OrderPeer::updateOptIsPaid($this->order);

      $this->sendMail();

      $this->setFlash('send_analytics', true);

      if($logout == 1)
      {
        $this->getUser()->signOut();
      }

      return $this->redirect('@stOrderSummary?id='.$this->order->getId().'&hash_code='.$this->order->getHashCode());
   }

    /**
    * Akcja wyświetlająca ostatni etap zamówienia
    */
   public function executeAdminOrder()
   {
      $this->smarty = new stSmarty($this->getModuleName());   
   }


   /**
    * Akcja wyświetlająca ostatni etap zamówienia
    */
   public function executeSummary()
   {
      $this->smarty = new stSmarty($this->getModuleName());
      
      $this -> config_points = stConfig::getInstance(sfContext::getInstance(), 'stPointsBackend');
      $this->config_points->setCulture(sfContext::getInstance()->getUser()->getCulture());

      $admin = $this->getRequestParameter('admin');

      $this->admin = $admin; 

      if($admin!=1)
      {
         $id = $this->getRequestParameter('id');
         
         $this->id = $id;

         $hash_code = $this->getRequestParameter('hash_code');
         
         $this->hash_code = $hash_code; 

         $this->order = OrderPeer::retrieveByIdAndHashCode($id, $hash_code);

         $this->forward404Unless($this->order, 'Operacja niedozwolona - zamówienie o podanym id i ciągu hash nie istnieje...');

         $currency = stCurrency::getInstance($this->getContext());

         $currency->setByIso($this->order->getOrderCurrency()->getShortcut());

         $config = stConfig::getInstance(sfContext::getInstance(), array(
                     'company' => stConfig::STRING,
                     'nip' => stConfig::STRING,
                     'street' => stConfig::STRING,
                     'house' => stConfig::STRING,
                     'flat' => stConfig::STRING,
                     'code' => stConfig::STRING,
                     'town' => stConfig::STRING,
                     'phone' => stConfig::STRING,
                     'fax' => stConfig::STRING,
                     'bank' => stConfig::STRING,
                     'email' => stConfig::STRING
                        )
                        , 'stShopInfoBackend');

         $config->load();

         $this->company = $config->get('company');
         $this->nip = $config->get('nip');
         $this->street = $config->get('street');
         $this->house = $config->get('house');
         $this->flat = $config->get('flat');
         $this->code = $config->get('code');
         $this->town = $config->get('town');
         $this->phone = $config->get('phone');
         $this->fax = $config->get('fax');
         $this->bank = $config->get('bank');
         $this->email = $config->get('email');

         if (class_exists('TextPeer'))
            $this->order_summary_text = TextPeer::retrieveBySystemName('stOrderSummary');

         $this->setFlash('stCurrency-hide_list', true, false);

         $this->total_amount = stPayment::getUnpayedAmountByOrder($this->order);
         
      }
      
   }

   /**
    * Tworzenie kopii aktualnej waluty
    *
    * @param   Currency    $currency           Aktualnie wybrana waluta w sklepie
    */
   protected function mirrorOrderCurrency($currency)
   {
      $order_currency = $this->order->getOrderCurrency();

      $currency = $this->getDispatcher()->filter(new sfEvent($this, 'stOrderActions.filterMirrorOrderCurrency', array('currency' => $currency)), $currency)->getReturnValue();

      $order_currency->setName($currency->getName());

      $order_currency->setExchange($currency->getExchange());

      $order_currency->setFrontSymbol($currency->getFrontSymbol());

      $order_currency->setBackSymbol($currency->getBackSymbol());

      $order_currency->setShortcut($currency->getShortcut());
   }

   /**
    * Tworzenie kopii danych dostawy użytkownika
    *
    * @param      UserData    $user_data_delivery
    */
   protected function mirrorOrderUserDataDelivery($user_data_delivery)
   {
      $order_delivery = $this->order->getOrderUserDataDelivery();

      $user_data_delivery = $this->getDispatcher()->filter(new sfEvent($this, 'stOrderActions.filterMirrorOrderUserDataDelivery', array('user_data_delivery' => $user_data_delivery)), $user_data_delivery)->getReturnValue();

      $this->mirrorUserData($user_data_delivery, $order_delivery);
   }

   /**
    * Tworzenie kopii danych bilingowych użytkownika
    *
    * @param      UserData    $user_data_billing
    */
   protected function mirrorOrderUserDataBilling($user_data_billing)
   {
      $order_billing = $this->order->getOrderUserDataBilling();

      $user_data_billing = $this->getDispatcher()->filter(new sfEvent($this, 'stOrderActions.filterMirrorOrderUserDataBilling', array('user_data_billing' => $user_data_billing)), $user_data_billing)->getReturnValue();

      if ($this->getUser()->hasVatEu())
      {
         $order_billing->setHasValidVatEu($this->getUser()->hasValidVatEu());
      }

      $this->mirrorUserData($user_data_billing, $order_billing);
   }

   /**
    * Tworzenie kopii danych użytkownika z $source do $target
    *
    * @param   UserData    $source             Dane źródłowe
    * @param   UserDate    $target              Dane docelowe
    */
   protected function mirrorUserData($source, $target)
   {
      $target->setCountries($source->getCountries());

      $target->setFullName($source->getFullName());

      $target->setAddress($source->getAddress());

      $target->setAddressMore($source->getAddressMore());

      $target->setRegion($source->getRegion());

      $target->setPesel($source->getPesel());

      $target->setCode($source->getCode());

      $target->setTown($source->getTown());

      $target->setPhone($source->getPhone());

      $target->setCompany($source->getCompany());

      $target->setVatNumber($source->getVatNumber());
   }

   /**
    * Tworzenie kopii produktów koszyka
    *
    * @param         array       $basket_products
    */
   protected function mirrorOrderProduct($basket_products)
   {
      $has_valid_vat_eu = $this->getUser()->hasValidVatEu();

      $tax = null;

      if ($has_valid_vat_eu)
      {
         $c = new Criteria();
         $c->add(TaxPeer::VAT_NAME, 'ue');
         $tax = TaxPeer::doSelectOne($c);

         if (null === $tax)
         {
            $tax = new Tax();

            $tax->setVat(0);

            $tax->setVatName('ue');

            $tax->setIsSystemDefault(true);

            $tax->save();
         }
      }

      if ($this->getUser()->hasVatEx())
      {
         $tax = stTax::getEx();
      }

      foreach ($basket_products as $basket_product)
      {
         $order_product = new OrderProduct();

         $order_product->setVersion(2);

         $order_product->setProductId($basket_product->getProductId());

         $order_product->setQuantity($basket_product->getQuantity());

         $order_product->setCode($basket_product->getCode());

         $order_product->setName($basket_product->getName());

         $order_product->setPriceNetto($basket_product->getPriceNetto(true, false));

         $order_product->setPriceBrutto($basket_product->getPriceBrutto(true, false));

         $order_product->setImage($basket_product->getImage());

         $order_product->setPriceModifiers($basket_product->getPriceModifiers());

         $order_product->setIsGift($basket_product->getIsGift());

         $order_product->setTax($tax ? $tax : $basket_product->getProduct()->getTax());

         if ($basket_product->getProductSetDiscount())
         {
            $set_discount = $basket_product->getProductSetDiscount();

            $products = $set_discount->getProducts(true, false);

            $total = $basket_product->getProductSetDiscount()->getTotalProductAmount(false);

            $value = $set_discount->getValue();

            $discount_sum = 0;

            $highest = null;

            $sf_user = $this->getUser();

            $user = $sf_user->isAuthenticated() ? $sf_user->getGuardUser() : null;

            $with_discount = !stDiscount::isDisabledForWholesale($user);

            foreach ($products as $product)
            {
               $price = $product->getPriceBrutto(true);

               if ($with_discount)
               {
                  if ($set_discount->getPriceType() == '%')
                  {
                     $price = stPrice::applyDiscount($price, $value);
                  }
                  elseif ($value > 0)
                  {
                     $take = stPrice::round(($price / $total) * $value);
                     $discount_sum += $take;
                     $price -= $take;                     
                  }
               }

               $ophs = new OrderProductHasSet();
               $ophs->setProduct($product);
               $ophs->setPriceNetto(stPrice::extract($price, $order_product->getTax()->getVat()));
               $ophs->setPriceBrutto($price);
               $ophs->setName($product->getName());
               $ophs->setCode($product->getCode());
               $order_product->addOrderProductHasSet($ophs);

               if (null === $highest || $highest['price'] < $price)
               {
                  $highest = array('set' => $ophs, 'price' => $price);
               }
            }

            $diff = $discount_sum - $value;
            
            if ($with_discount && $set_discount->getPriceType() == 'P' && $diff != 0)
            {
               $price = $highest['set']->getPriceBrutto(true) + $diff;
               $highest['set']->setPriceBrutto($price);
               $highest['set']->setPriceNetto(stPrice::extract($price, $order_product->getTax()->getVat()));
            } 

            $order_product->setIsSet(true);
         }
         
         $order_product->setProductForPoints($basket_product->getProductForPoints());
         
         $order_product->setPointsValue($basket_product->getProduct() -> getPointsValue());
         
         $order_product->setPointsEarn($basket_product->getPointsEarn());

         if (stDiscount::percent($basket_product->getPriceBrutto(false, false), $basket_product->getDiscount()) > $basket_product->getProduct()->getMaxDiscount())
         {
            $order_product->setDiscount(array('value' => $basket_product->getProduct()->getMaxDiscount(), 'type' => '%'));
         }
         else
         {
            $order_product->setDiscount($basket_product->getDiscount());
         }

         $order_product = $this->getDispatcher()->filter(new sfEvent($this, 'stOrderActions.filterMirrorOrderProduct', array('order_product' => $order_product, 'basket_product' => $basket_product)), $order_product)->getReturnValue();

         $this->order->addOrderProduct($order_product);
      }
   }

   /**
    * Tworzenie kopii dostawy
    *
    * @param      stDeliveryFrontend    $delivery
    */
   protected function mirrorOrderDelivery($delivery)
   {
      $default_delivery = $delivery->getDefaultDelivery();

      $default_payment = $default_delivery->getDefaultPayment();

      $order_delivery = $this->order->getOrderDelivery();

      $order_delivery->setName($default_delivery->getName());

      $order_delivery->setCostNetto($default_delivery->getTotalCost());

      $order_delivery->setCostBrutto($default_delivery->getTotalCost(true));

      $order_delivery->setPaymentCostNetto($default_payment->getCost());

      $order_delivery->setPaymentCostBrutto($default_payment->getCost(true));

      $order_delivery->setOptTax($default_delivery->getTax()->getVat());

      $order_delivery->setDeliveryId($default_delivery->getDelivery()->getId());

      $order_delivery->setTaxId($default_delivery->getTax()->getId());


      if ($this->getRequestParameter('delivery[date]') != "")
      {
         $delivery_date = $this->getRequestParameter('delivery[date]');
      }
      else
      {
         $delivery_date = '00-00-00';
      }

      if ($this->getRequestParameter('delivery[time]') != "")
      {
         $delivery_time = $this->getRequestParameter('delivery[time]');
      }
      else
      {
         $delivery_time = '00:00:00';
      }

      if ($this->getRequestParameter('delivery[date]') != "" || $this->getRequestParameter('delivery[time]') != "")
      {
         $date_delivery = explode("-", $delivery_date);
         $order_delivery->setDeliveryDate($date_delivery[2]."-".$date_delivery[1]."-".$date_delivery[0]." ".$delivery_time);
      }
   }

   protected function processGiftCard()
   {
      foreach (stGiftCardPlugin::get() as $gift_card)
      {
         if ($gift_card->getStatus() != 'A')
         {
            continue;
         }

         $gift_card->setStatus('P');

         $payment = new Payment();

         $payment->setAmount($gift_card->getAmount());

         $payment->setStatus(false);

         $payment->setGiftCard($gift_card);

         $payment->save();

         $pho = new OrderHasPayment();

         $pho->setPaymentId($payment->getId());

         $pho->setOrderId($this->order->getId());

         $pho->save();

         $payment->setStatus(true);

         $payment->save();
      }

      stGiftCardPlugin::clear();
   }

   /**
    * Metoda pomocnicza wykonująca wszystkie potrzebne operacje związane z danymi użytkownika
    */
   protected function processOrderUserData()
   {
        
      $user_data_delivery = $this->getRequestParameter('user_data_delivery');

      $user_data_billing = $this->getRequestParameter('user_data_billing');
      $password = $user_data_billing['password1'];
      $this->password = $password;

      $create_account = $user_data_billing['create_account'];
      $this->create_account = $create_account;

  
      // nie zalogowany
      if ($this->getUser()->isAnonymous())
      {
         $username = $user_data_billing['email'];

         $c = new Criteria();
         $c->add(sfGuardUserPeer::USERNAME, $username);
         $user = sfGuardUserPeer::doSelectOne($c);

         // brak użytkownika
         if (!$user)
         {

            if ($create_account == 1)
            {
               $user = stUser::addUser($username, $password);

               $this->getUser()->setGuardUser($user);

               $user_id = $user->getId();
            }
            else
            {
               $user = stUser::addUser($username);

               stUser::loginUserOnlyUsername($username);

               $user_id = $this->getUser()->getGuardUser()->getId();
            }

            $obj_billing = stUser::updateUserData(null, $user_id, 1, 1, $user_data_billing);

            $obj_delivery = stUser::updateUserData(null, $user_id, 0, 1, $this->getUser()->thisSameUserDataArray($user_data_delivery, $user_data_billing) ? $user_data_billing : $user_data_delivery);
         }
         else
         {

            if ($user->getIsConfirm() == 0 && $create_account == 1)
            {
               $user->setPassword($password);

               $user->save();

               $this->getUser()->setGuardUser($user);

               $user_id = $user->getId();
            }
            else
            {
               $this->getUser()->setGuardUser($user);

               $user_id = $user->getId();
            }

            $obj_billing = stUser::updateUserData(null, $user_id, 1, 1, $user_data_billing);

            $obj_delivery = stUser::updateUserData(null, $user_id, 0, 1, $this->getUser()->thisSameUserDataArray($user_data_delivery, $user_data_billing) ? $user_data_billing : $user_data_delivery);
         }
      }
      else
      {
        // zalogowany
         $user_id = $this->getUser()->getGuardUser()->getId();

         $user_data_billing_default = $this->getUser()->getUserDataDefaultBilling();
         $user_data_delivery_default = $this->getUser()->getUserDataDefaultDelivery();

         if ($user_data_billing_default && $this->getUser()->thisSameUserData($user_data_billing, $user_data_billing_default))
         {
            $obj_billing = $user_data_billing_default;
         }
         else
         {
            //tworzy nowe dane billingowe
            $obj_billing = stUser::updateUserData(null, $user_id, 1, 1, $user_data_billing);
         }

         if ($user_data_delivery_default && $this->getUser()->thisSameUserData($user_data_delivery, $user_data_delivery_default))
         {
            $obj_delivery = $user_data_delivery_default;
         }
         else
         {
            //tworzy nowe dane dostawy
            $obj_delivery = stUser::updateUserData(null, $user_id, 0, 1, $user_data_delivery);
         }
      }

      $this->mirrorOrderUserDataBilling($obj_billing);

      $this->mirrorOrderUserDataDelivery($obj_delivery);

      $this->order->setGuardUser($this->getUser()->getGuardUser());
   }

   protected function updateCouponCode($basket)
   {
      $coupon_code = $basket->getCouponCode();

      if ($coupon_code && $coupon_code->validateUsage())
      {
         $this->order->setDiscountCouponCode($coupon_code);

         $coupon_code->incrementUsage();

         $coupon_code->save();
      }
      elseif ($coupon_code)
      {
         $basket->refreshItems();
      }
   }

   /**
    * Generuje numer dla zamówienia
    */
   protected function generateOrderNumber()
   {
      $number = OrderPeer::updateOrderNumber($this->order->getId(), $this->order->getCreatedAt());

      $this->order->setNumber($number);
      $this->order->resetModified();
   }

   /**
    * Wysyła mail z zamówieniem do klienta
    */
   function mailWithOrderToUser()
   {
      $this->smarty = new stSmarty($this->getModuleName());
      
      $mail_config = stConfig::getInstance($this->getContext(), 'stMailAccountBackend');
      
      $config_points = stConfig::getInstance(sfContext::getInstance(), 'stPointsBackend');
      $config_points->setCulture(sfContext::getInstance()->getUser()->getCulture());
      $compatibility_config = stConfig::getInstance('stCompatibilityBackend');
     
      $mail = stMailer::getInstance();

      if($compatibility_config->get('terms_in_mail_confirm_order')==1 && stCompatibilityLaw::isSection("terms_in_mail_confirm_order_countrys", stCompatibilityLaw::getIsoCountry($this->order->getOrderUserDataBilling()->getCountry()->getId()))){
         $webpage = WebpagePeer::getTermsWebpage();

         if ($webpage)
         {
            if ($compatibility_config->get('terms_in_mail_confirm_order_format') == 'pdf' && is_file($webpage->getPdfAttachmentPath()))
            {
               $mail->addAttachment($webpage->getName().'.pdf', $webpage->getPdfAttachmentPath());
            }
            else
            {
               $webpage_terms_in_mail = $webpage;
            } 
         }  
      }
      
      if($compatibility_config->get('right_2_cancel_in_mail_confirm_order')==1 && stCompatibilityLaw::isSection("right_2_cancel_in_mail_confirm_order_countrys", stCompatibilityLaw::getIsoCountry($this->order->getOrderUserDataBilling()->getCountry()->getId()))){
         $webpage = WebpagePeer::getRight2CancelWebpage();

         if ($webpage)
         {
            if ($compatibility_config->get('right_2_cancel_in_mail_confirm_order_format') == 'pdf' && is_file($webpage->getPdfAttachmentPath()))
            {
               $mail->addAttachment($webpage->getName().'.pdf', $webpage->getPdfAttachmentPath());
            }        
            else
            {
               $webpage_right_2_cancel_in_mail = $webpage;
            }  
         }         
      }
     
      $mailHtmlHead = stMailer::getHtmlMailDescription("header");

      $mailHtmlFoot = stMailer::getHtmlMailDescription("footer");

      $mailHtmlHeadContent = stMailer::getHtmlMailDescription("top_order_confirm");

      $mailHtmlFootContent = stMailer::getHtmlMailDescription("bottom_order_confirm");

      $sendOrderToUserHtmlMailMessage = stMailTemplate::render('sendOrderToUserHtml', array('webpage_terms_in_mail' => $webpage_terms_in_mail, 'webpage_right_2_cancel_in_mail' => $webpage_right_2_cancel_in_mail, 'order' => $this->order, 'head' => $mailHtmlHead, 'foot' => $mailHtmlFoot, 'head_content' => $mailHtmlHeadContent, 'foot_content' => $mailHtmlFootContent, 'password' => $this->password, 'create_account' => $this->create_account, 'smarty' => $this->smarty, 'config_points' => $config_points, 'mail_config' => $mail_config));

      $sendOrderToUserPlainMailMessage = stMailTemplate::render('sendOrderToUserPlain', array('webpage_terms_in_mail' => $webpage_terms_in_mail, 'webpage_right_2_cancel_in_mail' => $webpage_right_2_cancel_in_mail, 'order' => $this->order, 'smarty' => $this->smarty));

      $mail->setSubject(__('Zamówienie numer').': '.$this->order->getNumber())->setHtmlMessage($sendOrderToUserHtmlMailMessage)->setPlainMessage($sendOrderToUserPlainMailMessage)->setTo($this->order->getSfGuardUser()->getUsername());

      stEventDispatcher::getInstance()->notify(new sfEvent($mail, 'stOrderActions.mailWithOrderToUser', array('order' => $this->order)));

      $ret = $mail->sendToClient();

      return $ret;
   }

   /**
    * Wysyła mail z zamówieniem do administratora
    */
   function mailWithOrderToAdmin()
   {
      $user = $this->getUser();

      $culture = $user->getCulture();
      
      $mail_config = stConfig::getInstance($this->getContext(), 'stMailAccountBackend');
      
      $config_points = stConfig::getInstance(sfContext::getInstance(), 'stPointsBackend');
      $config_points -> setCulture($culture);

      $this->order = OrderPeer::retrieveByPK($this->order->getId()); // reload order culture hack

      $c = new Criteria();
      $c->add(LanguagePeer::IS_DEFAULT_PANEL, 1);
      $language = LanguagePeer::doSelectOne($c);
      if (is_object($language))
         $user->setCulture($language->getOriginalLanguage());


      $c = new Criteria();
      $c->add(InvoicePeer::ORDER_ID, $this->order->getId());
      $c->add(InvoicePeer::IS_REQUEST, 1);
      $invoice = InvoicePeer::doSelectOne($c);

      $is_invoice_request = 0;

      if (is_object($invoice))
      {
         $is_invoice_request = 1;
      }

      $this->smarty = new stSmarty($this->getModuleName());

      $mailHtmlHead = stMailer::getHtmlMailDescription("header");

      $mailHtmlFoot = stMailer::getHtmlMailDescription("footer");

      $sendOrderToAdminHtmlMailMessage = stMailTemplate::render('sendOrderToAdminHtml', array('invoice' => $is_invoice_request, 'order' => $this->order, 'head' => $mailHtmlHead, 'foot' => $mailHtmlFoot, 'smarty' => $this->smarty, 'config_points' => $config_points, 'mail_config' => $mail_config));

      $sendOrderToAdminPlainMailMessage = stMailTemplate::render('sendOrderToAdminPlain', array('invoice' => $is_invoice_request, 'order' => $this->order, 'smarty' => $this->smarty));

      $mail = stMailer::getInstance();
      $mail->removeAttachments();
      $mail->setSubject(__('Złożono nowe zamówienie numer').': '.$this->order->getNumber())->setHtmlMessage($sendOrderToAdminHtmlMailMessage)->setPlainMessage($sendOrderToAdminPlainMailMessage)->setReplyTo($this->order->getSfGuardUser()->getUsername());
      stEventDispatcher::getInstance()->notify(new sfEvent($mail, 'stOrderActions.sendMailWithOrderToAdmin', array('order' => $this->order)));

      $ret = $mail->sendToMerchant();

      $user->setCulture($culture);

      return $ret;
   }

   /**
    * Obsługuje wysyłanie mail'i
    */
   function SendMail()
   {
      $mail_error = $this->MailWithOrderToUser();
      $mail_error = $this->MailWithOrderToAdmin();

      return $mail_error;
   }

}
