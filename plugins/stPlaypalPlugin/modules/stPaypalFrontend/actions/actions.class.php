<?php

class stPaypalFrontendActions extends stActions
{

   protected $order = null;
   protected $paypalCaller = null;
   protected $orderPayment = null;

   public function executeSetExpressCheckout()
   {
      $this->smarty = new stSmarty('stPaypalFrontend');

      $config = stConfig::getInstance('stPaypal');

      $order = $this->getOrder();

      $controller = $this->getController();

      $paypal = $this->getPaypalCallerService();

      $request = new stPaypalCallerRequest();

      $request->setPaymentAction('Sale');

      $request->setLandingPage('Billing');

      $request->setSolutionType('Sole');

      $request->setAllowNote(false);

      $request->setAddrOverride(false);

      $request->setReqConfirmShipping(false);

      $request->setNoShipping(!$config->get('show_shipping_info'));

      $request->setReturnUrl($controller->genUrl('@stPaypalDoExpressCheckout?order_id=' . $order->getId() . '&order_hash=' . $order->getHashCode(), true));

      $request->setCancelUrl($controller->genUrl('@stOrderSummary?id=' . $order->getId() . '&hash_code=' . $order->getHashCode(), true));

      $culture = $order->getClientCulture();

      if ($culture == 'pl_PL')
      {
        $culture = 'PL';
      }
      elseif ($culture == 'en_US')
      {
        $culture = 'US';
      }

      $request->setLocaleCode(strtoupper($culture));

      $request->setCurrencyCode($order->getOrderCurrency()->getShortcut());

      $this->processOrderBillingAddress($request);

      $this->processOrderSummary($request);

      $this->paypal_response = $paypal->setExpressCheckout($request);

      $this->postExecute();

      if ($this->paypal_response->isSuccessful())
      {
         $this->redirect($paypal->getExpressCheckoutUrl($this->paypal_response->getToken()));
      }
      else
      {
         if (sfConfig::get('sf_debug'))
         {
            throw new stPaypalCallerException(var_export($this->paypal_response->getItems(), true));
         }

         $content = 'SetExpressCheckout - '.$order->getId(). ":\n" . var_export($this->paypal_response->getItems(), true);
         file_put_contents(sfConfig::get('sf_root_dir').'/log/paypal.txt', '['.date('d-m-Y H:i:s').'] '.$content."\n\n", FILE_APPEND);
      }
   }

   /**
    *
    * @return <type>
    */
   public function executeIpn()
   {
      $request = $this->getRequest();

      $parameters = $request->getParameterHolder()->getAll();

      unset($parameters['module']);

      unset($parameters['action']);

      unset($parameters['order_id']);

      unset($parameters['order_hash']);

      try
      {
         if (isset($parameters['test_ipn']) && $parameters['test_ipn'])
         {
            $response = stPaypalCallerService::curlCall('https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_notify-validate', $parameters);
         }
         else
         {
            $response = stPaypalCallerService::curlCall('https://www.paypal.com/cgi-bin/webscr?cmd=_notify-validate', $parameters);
         }

         if ($response == 'VERIFIED')
         {
            if ($parameters['payment_status'] == 'Completed')
            {
               $order = $this->getOrder();

               if ($this->validatePayment($order, $parameters['mc_gross']))
               {
                  $order_payment = $this->getOrderPaymentByPaymentHash('PAYPAL-' . $parameters['txn_id']);

                  if ($order_payment && !$order_payment->getStatus())
                  {
                     $order_payment->setStatus(true);

                     $order_payment->save();
                  }
               }
            }
         }
      }
      catch(stPaypalCallerException $e)
      {
         file_put_contents(sfConfig::get('sf_root_dir').'/log/paypal_ipn.txt', '['.date('d-m-Y H:i:s').'] '.$e->getMessage(). '('.$e->getCode().')' ."\n".var_export($parameters, true)."\n\n", FILE_APPEND);
         throw $e;
      }

      return sfView::HEADER_ONLY;
   }

   /**
    *
    * Finalizacja płatności Paypal Express Checkout
    *
    */
   public function executeDoExpressCheckout()
   {
      $this->smarty = new stSmarty('stPaypalFrontend');

      $this->order_id = $this->getRequestParameter('order_id');

      $this->hash_code = $this->getRequestParameter('order_hash');

      $token = $this->getRequestParameter('token');

      $controller = $this->getController();

      $paypal = $this->getPaypalCallerService();

      $response = $this->getExpressCheckoutDetails($token);

      $request = new stPaypalCallerRequest();

      $request->setPayerId($response->getPayerId());

      $request->setToken($token);

      $request->setPaymentAction('Sale');

      $request->setButtonSource('Sote_ShoppingCart_EC_PL');

      $request->setCurrencyCode($response->getCurrencyCode());

      $request->setNotifyUrl($controller->genUrl('@stPaypalIpn?order_id=' . $this->order_id . '&order_hash=' . $this->hash_code, true));

      $request->setAmt($response->getAmt());

      $request->setItemAmt($response->getItemAmt());
            
      $request->setItems($response->getItems());

      $this->paypal_response = $paypal->doExpressCheckoutPayment($request);

      if ($this->paypal_response->isSuccessful())
      {
         $order = OrderPeer::retrieveByIdAndHashCode($this->order_id, $this->hash_code);
         $order_payment = $order->getOrderPayment();

         if ($this->paypal_response->getPaymentStatus() == 'Completed')
         {
            $order_payment->setStatus(true);
         }

         $order_payment->setHash('PAYPAL-' . $this->paypal_response->getTransactionId());

         $order_payment->save();
      }
      else
      {
         if (sfConfig::get('sf_debug'))
         {
            throw new stPaypalCallerException($response->getItemAmt() . ':' . $response->getShippingAmt() . ':' . $response->getAmt() . var_export($this->paypal_response->getItems(), true));
         }

         $content = 'DoExpressCheckout - '.$this->order_id. ":\n" . var_export($this->paypal_response->getItems(), true);
         file_put_contents(sfConfig::get('sf_root_dir').'/log/paypal.txt', '['.date('d-m-Y H:i:s').'] '.$content."\n\n", FILE_APPEND);
      }
   }

   /**
    *
    * Wykonuje żądanie o szczegółowe informacje transakcji Paypal
    *
    * @param string $token Unikalny klucz otrzymany z Paypal
    * @return stPaypalCallerResponse Odpowiedź
    */
   protected function getExpressCheckoutDetails($token)
   {
      $paypal = $this->getPaypalCallerService();

      $request = new stPaypalCallerRequest();

      $request->setToken($token);

      return $paypal->getExpressCheckoutDetails($request);
   }

   /**
    *
    * Uzupełnia żądanie o dane produktów z zamówienia
    *
    * @param stPaypalCallerRequest $request Żądanie API
    */
   protected function processOrderProducts($request)
   {
      $order_products = $this->getOrder()->getOrderProducts();

      foreach ($order_products as $index => $order_product)
      {
         $item = new stPaypalCallerItem($index);

         $item->setName($order_product->getName());

         $item->setNumber($order_product->getCode());

         $item->setAmt($order_product->getPrice(false, true));

         $item->setQty($order_product->getQuantity());

         $item->setTaxAmt($order_product->getTaxAmount(true));

         if ($order_product->getOptions())
         {
            $item->setDesc(implode(', ', $order_product->getOptions(true)));
         }

         $request->addItem($item);

         $this->itemAmount += $order_product->getTotalAmount(false, true);

         $this->itemTaxAmount += $order_product->getTotalTaxAmount(true);
      }
   }

   /**
    *
    * Uzupełnia żądanie o dane podsumowania z zamówienia
    *
    * @param stPaypalCallerRequest $request Żądanie API
    */
   protected function processOrderSummary($request)
   {
      $order = $this->getOrder();

      $item = new stPaypalCallerItem(0);

      $item->setName($this->getContext()->getI18N()->__('Zamówienie numer %number%', array('%number%' => $order->getNumber()), 'stOrder'));

      $item->setAmt($order->getUnpaidAmount());

      $item->setQty(1);

      $request->addItem($item);

      $unpaid_amount = $order->getUnpaidAmount();
      
      $request->setAmt($unpaid_amount);
      
      $request->setItemAmt($unpaid_amount);
   }

   /**
    *
    * Uzupełnia żądanie o dane billingowe z zamówienia
    *
    * @param stPaypalCallerRequest $request Żądanie API
    */
   protected function processOrderBillingAddress($request)
   {
      $billing = $this->order->getOrderUserDataBilling();

      $request->setEmail($this->order->getGuardUser()->getUsername());

      if ($billing)
      {
         $request->setShipToName($billing->getFullName());

         $request->setShipToStreet($billing->getAddress());

         if ($billing->getAddressMore())
         {
            $request->setShipToStreet2($billing->getAddressMore());
         }

         $request->setShipToCity($billing->getTown());

         $request->setShipToZip($billing->getCode());

         $request->setShipToPhoneNum($billing->getPhone());

         $request->setShipToCountryCode($billing->getCountry()->getIsoA2());
      }
   }

   /**
    * Aktualizuje status płatności
    */
   protected function updatePaymentStatus($paypal_status, $payment_hash)
   {
      $payment = $this->getOrderPaymentByPaymentHash($payment_hash);

      if ($paypal_status == 'Completed' && $payment->getStatus() == false)
      {
         $payment->setStatus(true);

         $payment->save();
      }
   }

   protected function validatePayment($order, $pay_amount)
   {
      $pay_amount = stCurrency::round($pay_amount);

      $order_amount = stCurrency::round(stPayment::getUnpayedAmountByOrder($order));

      return $order_amount == $pay_amount;
   }

   /**
    *
    * Pobiera aktualne zamówienie
    *
    * @return Order
    */
   protected function getOrder()
   {
      if (is_null($this->order))
      {
         $c = new Criteria();

         $c->add(OrderPeer::ID, $this->getRequestParameter('order_id'));

         $c->add(OrderPeer::HASH_CODE, $this->getRequestParameter('order_hash'));

         $c->setLimit(1);

         $tmp = OrderPeer::doSelectJoinAll($c);

         if (!empty($tmp))
         {
            $this->order = $tmp[0];
         }
      }

      return $this->order;
   }

   /**
    *
    * Pobiera płatność dla zamówienia
    *
    * @param int $payment_hash Unikalny kod płatności
    * @return Payment
    */
   protected function getOrderPaymentByOrder($order_id, $order_hash)
   {
      $c = new Criteria();

      $c->add(OrderPeer::ID, $this->getRequestParameter('order_id', $order_id));

      $c->add(OrderPeer::HASH_CODE, $this->getRequestParameter('order_hash', $order_hash));

      $c->addJoin(OrderHasPaymentPeer::PAYMENT_ID, PaymentPeer::ID);

      $c->addJoin(OrderHasPaymentPeer::ORDER_ID, OrderPeer::ID);

      return PaymentPeer::doSelectOne($c);
   }

   protected function getOrderPaymentByPaymentHash($payment_hash)
   {
      $c = new Criteria();

      $c->add(PaymentPeer::HASH, $payment_hash);

      return PaymentPeer::doSelectOne($c);
   }

   /**
    *
    * Pobiera instancje stPaypalCallerService
    *
    * @return stPaypalCallerService
    */
   protected function getPaypalCallerService()
   {
      if (is_null($this->paypalCaller))
      {
         $config = stConfig::getInstance($this->getContext(), 'stPaypal');

         $this->paypalCaller = stPaypalCallerService::getInstance();

         if ($config->get('test_mode'))
         {
            $this->paypalCaller->setApiUsername($config->get('sandbox_api_username'));

            $this->paypalCaller->setApiPassword($config->get('sandbox_api_password'));

            $this->paypalCaller->setApiSignature($config->get('sandbox_api_signature'));

            $this->paypalCaller->setApiEnvironment('sandbox');
         }
         else
         {
            $this->paypalCaller->setApiUsername($config->get('live_api_username'));

            $this->paypalCaller->setApiPassword($config->get('live_api_password'));

            $this->paypalCaller->setApiSignature($config->get('live_api_signature'));
         }
      }

      return $this->paypalCaller;
   }

    public function executeBuyProduct() {
        $quantity = $this->getRequestParameter('quantity', 1);
        $options = $this->getRequestParameter('option_list', null);

        $config = stConfig::getInstance('stPaypal');
        $controller = $this->getController();

        if (!$config->get('express'))
            return $this->redirect($controller->genUrl('@homepage', true));

        $paypal = $this->getPaypalCallerService();
        $paypal->setApiVersion(108);

        /**
         * @var Product $product
         */
        $product = ProductPeer::retrieveByPK($this->getRequestParameter('product_id', null));

        $delivery = DeliveryPeer::retrieveByPK($config->get('express_delivery'));

        if (is_object($product) && is_object($delivery)) {

            $request = new stPaypalCallerRequest();
            $request->setPaymentRequest_0_PaymentAction('Sale');
            $request->setLandingPage('Billing');
            $request->setSolutionType('Sole');
            $request->setAllowNote(true);
            $request->setNoShipping(0);
            $request->setAddrOverride(true);
            $request->setReqConfirmShipping(false);
            $request->setReturnUrl($controller->genUrl('@stPaypalCreateOrder', true));
            $request->setCancelUrl($controller->genUrl('@stProductUrl?url='.$product->getUrl(), true));
            $request->setLocaleCode($this->getUser()->getCulture());
            $request->setPaymentRequest_0_CurrencyCode(stCurrency::getInstance($this->getContext())->get()->getShortcut());

            if ($product->getOptHasOptions() > 1) {
                // $selectedOption = $name = $cOptions = array();
                // $ids = explode('-', $options);
                // $options = ProductOptionsValuePeer::retrieveByPKs($ids);
                // foreach ($ids as $ids) {
                //     $selectedOption[$option->getProductOptionsField()->getId()] = $option->getId();
                //     $name[$option->getProductOptionsField()->getId()] = $option->getProductOptionsField()->getName().': '.$option->getValue();
                //     $cOptions[$option->getId()] = $option->getValue();
                // }

                // ksort($selectedOption);
                // ksort($name);

                // $x = null;
                // stNewProductOptions::updateProductRecursive($product, ProductOptionsValuePeer::doSelectByProduct($product), 'brutto', $selectedOption, $x);
                $ids = explode('-', $options);
                $selectedOptions = array();

                foreach ($ids as $id)
                {
                    $selectedOptions[] = ProductOptionsValuePeer::retrieveByPK($id);
                }

                stNewProductOptions::updateProductBySelectedOptions($product, $selectedOptions);

                $option_label = array();

                foreach ($product->getPriceModifiers() as $modifier)
                {
                    $options_label[] = $modifier['custom']['field'].': '.$modifier['custom']['label'];
                }

                $name = $product->getName().' ('.implode(', ', $options_label).')';
            } else {
                $name = $product->getName();
            }

            if (!stPayPalExpressCheckout::validateProduct($product, $quantity)) {
                return $this->redirect($controller->genUrl('@stProductUrl?url='.$product->getUrl(), true));
            }

            $item = new stPaypalCallerItem(0);
            $item->setPaymentRequest_0_Name($name);
            $item->setPaymentRequest_0_Amt($product->getPriceBrutto(true));
            $item->setPaymentRequest_0_Number($product->getCode());
            $item->setPaymentRequest_0_Qty($quantity);
            $request->addItem($item);

            $request->setPaymentRequest_0_ItemAmt($item->getPaymentRequest_0_Amt()*$quantity);

            $type = $delivery->getSectionCostType();
            switch ($type) {
                case "ST_BY_ORDER_AMOUNT":
                    $value = $request->getPaymentRequest_0_ItemAmt();
                    break;
                case "ST_BY_ORDER_QUANTITY":
                    $value = $quantity;
                    break;
                case "ST_BY_ORDER_WEIGHT":
                    $value = ($product->getWeight()*$quantity);
                    break;
            }

            $additionalCost = 0;

            if ($product->getDeliveryPrice())
            {
               $price_type = stConfig::getInstance('stProduct')->get('delivery_price_type', 'netto');

               if ($price_type == 'netto')
               {
                  $deliveryPrice = stPrice::calculate($product->getDeliveryPrice(), $delivery->getTax()->getVat());
               }
               else
               {
                  $deliveryPrice = $product->getDeliveryPrice();
               }

               $additionalCost += $deliveryPrice;
            }

            if ($type) {
                $c = new Criteria();
                $c->add(DeliverySectionsPeer::VALUE_FROM, $value, Criteria::LESS_EQUAL);
                $c->setLimit(1);    
                $c->addDescendingOrderByColumn(DeliverySectionsPeer::VALUE_FROM);
                $tmp = $delivery->getDeliverySectionss($c);
                if (isset($tmp[0]) && is_object($tmp[0])) {
                    $additionalCost = $tmp[0]->getCostBrutto(true);
                }
            }

            if ($delivery->getFreeDelivery() && $request->getPaymentRequest_0_ItemAmt() >= $delivery->getFreeDelivery()) {
                $delivery->setCostBrutto(0);
            }

            $request->setPaymentRequest_0_ShippingAmt($delivery->getCostBrutto(true) + $additionalCost);
            $request->setPaymentRequest_0_Amt($request->getPaymentRequest_0_ItemAmt()+$request->getPaymentRequest_0_ShippingAmt());

            $request->setPaymentRequest_0_Custom(json_encode(array('o' => $options)));

            $this->paypalResponse = $paypal->setExpressCheckout($request);

            $this->postExecute();

            if ($this->paypalResponse->isSuccessful()) {
                return $this->redirect($paypal->getExpressCheckoutUrl($this->paypalResponse->getToken()));
            } else {
                if (sfConfig::get('sf_debug'))
                    throw new stPaypalCallerException(var_export($this->paypalResponse->getItems(), true));
            }
        }
    }

    public function executeCreateOrder() {
        $config = stConfig::getInstance('stPaypal');
        $controller = $this->getController();

        if (!$config->get('express'))
            return $this->redirect($controller->genUrl('@homepage', true));

        $paypal = $this->getPaypalCallerService();
        $paypal->setApiVersion(108);

        $token = $this->getRequestParameter('token');
        $response = $this->getExpressCheckoutDetails($token);

        if (!$response->getEmail())
            return $this->redirect($controller->genUrl('@homepage', true));

        $custom = $response->getPaymentRequest_0_Custom();
        if (!empty($custom))
            $custom = json_decode($custom, true);
        else
            $custom = array();

        $c = new Criteria();
        $c->add(ProductPeer::CODE, $response->getL_PaymentRequest_0_Number0());
        $product = ProductPeer::doSelectOne($c);
        if(is_object($product)) {
            if ($product->getOptHasOptions() && $custom['o']) {
                // $selectedOption = $ids = array();
                
                $ids = explode("-", $custom['o']);

                // $options = ProductOptionsValuePeer::retrieveByPKs($ids);
                // foreach ($options as $option)
                //     $selectedOption[$option->getProductOptionsField()->getId()] = $option->getId();

                // ksort($selectedOption);

                // $x = null;
                // stNewProductOptions::updateProductRecursive($product, ProductOptionsValuePeer::doSelectByProduct($product), 'brutto', $selectedOption, $x);

                $selectedOptions = array();

                foreach ($ids as $id)
                {
                    $selectedOptions[] = ProductOptionsValuePeer::retrieveByPK($id);
                }

                stNewProductOptions::updateProductBySelectedOptions($product, $selectedOptions);
            }

            if (!stPayPalExpressCheckout::validateProduct($product, $response->getL_PaymentRequest_0_Qty0())) {
                return $this->redirect($controller->genUrl('@stProductUrl?url='.$product->getUrl(), true));
            }
        } else {
            return $this->redirect($controller->genUrl('@homepage', true));
        }

        $delivery = DeliveryPeer::retrieveByPK($config->get('express_delivery'));

        $c = new Criteria();
        $c->add(CountriesPeer::ISO_A2, $response->getPaymentRequest_0_ShipToCountryCode());
        $country = CountriesPeer::doSelectOne($c);

        if(is_object($delivery) && is_object($country)) {
            $c = new Criteria();
            $c->add(CountriesAreaHasCountriesPeer::COUNTRIES_ID, $country->getId());
            $c->add(CountriesAreaHasCountriesPeer::COUNTRIES_AREA_ID, $delivery->getCountriesAreaId());
            if (!CountriesAreaHasCountriesPeer::doCount($c)) {
                stPayPalExpressCheckout::returnValidareProductError($this->getContext()->getI18N()->__('Dostawa nie jest możliwa do wskazanego kraju'));
                return $this->redirect($controller->genUrl('@stProductUrl?url='.$product->getUrl(), true));
            }
        }

        $ex = new stPayPalExpressCheckout();
        $order = @$ex->addOrder($response, $product);

        $this->sendMail($order);

        if(is_object($order))    
            $this->redirect($controller->genUrl('@stPaypalDoExpressCheckoutForProduct?order_id='.$order->getId().'&order_hash='.$order->getHashCode().'&token='.$token, true));
        else
            throw new Exception('Order object don\'t exists.');
    }

    public function executeDoExpressCheckoutForProduct() {

        $this->smarty = new stSmarty('stPaypalFrontend');

        $this->order_id = $this->getRequestParameter('order_id');

        $this->hash_code = $this->getRequestParameter('order_hash');

        $token = $this->getRequestParameter('token');

        $config = stConfig::getInstance('stPaypal');
        $controller = $this->getController();

        if (!$config->get('express'))
            return $this->redirect($controller->genUrl('@homepage', true));

        $paypal = $this->getPaypalCallerService();

        $response = $this->getExpressCheckoutDetails($token);

        $request = new stPaypalCallerRequest();

        $request->setPayerId($response->getPayerId());

        $request->setToken($token);

        $request->setPaymentAction('Sale');

        $request->setButtonSource('SOTE_Cart_Expresscheckout');

        $request->setCurrencyCode($response->getCurrencyCode());

        $request->setNotifyUrl($controller->genUrl('@stPaypalIpn?order_id=' . $this->order_id . '&order_hash=' . $this->hash_code, true));

        $request->setAmt($response->getAmt());

        $this->paypal_response = $paypal->doExpressCheckoutPayment($request);

        if ($this->paypal_response->isSuccessful())
        {
            $order = OrderPeer::retrieveByIdAndHashCode($this->order_id, $this->hash_code);
            $order_payment = $order->getOrderPayment();

            if ($this->paypal_response->getPaymentStatus() == 'Completed')
            {
                $order_payment->setStatus(true);
            }

            $order_payment->setHash('PAYPAL-' . $this->paypal_response->getTransactionId());

            $order_payment->save();
        }
        else
        {
            if (sfConfig::get('sf_debug'))
            {
                throw new stPaypalCallerException($response->getItemAmt() . ':' . $response->getShippingAmt() . ':' . $response->getAmt() . var_export($this->paypal_response->getItems(), true));
            }
        }
    }

    public function sendMail($order) {

        $this->smarty = new stSmarty('stOrder');

        $config_points = stConfig::getInstance('stPointsBackend');
        $config_points->setCulture(sfContext::getInstance()->getUser()->getCulture());

        $mail_config = stConfig::getInstance('stMailAccountBackend');

        $mailHtmlHead = stMailer::getHtmlMailDescription("header");
        $mailHtmlFoot = stMailer::getHtmlMailDescription("footer");
        $mailHtmlHeadContent = stMailer::getHtmlMailDescription("top_order_confirm");
        $mailHtmlFootContent = stMailer::getHtmlMailDescription("bottom_order_confirm");

        $sendOrderToUserHtmlMailMessage = stMailTemplate::render('stOrder/sendOrderToUserHtml', array('order' => $order, 'head' => $mailHtmlHead, 'foot' => $mailHtmlFoot, 'head_content' => $mailHtmlHeadContent, 'foot_content' => $mailHtmlFootContent, 'smarty' => $this->smarty, 'config_points' => $config_points, 'mail_config' => $mail_config));
        $sendOrderToUserPlainMailMessage = stMailTemplate::render('stOrder/sendOrderToUserPlain', array('order' => $order, 'smarty' => $this->smarty, 'config_points' => $config_points));

        $mail = stMailer::getInstance();
        $mail->setSubject($this->getRequest()->getHost().' - '.__('zamówienie numer', null, 'stOrder').': '.$order->getNumber())->setHtmlMessage($sendOrderToUserHtmlMailMessage)->setPlainMessage($sendOrderToUserPlainMailMessage)->setTo($order->getSfGuardUser()->getUsername())->sendToClient();

        $user = $this->getContext()->getUser();
        $culture = $user->getCulture();

        $c = new Criteria();
        $c->add(LanguagePeer::IS_DEFAULT_PANEL, 1);
        $language = LanguagePeer::doSelectOne($c);
        if (is_object($language)) 
            $user->setCulture($language->getOriginalLanguage());

        $sendOrderToAdminHtmlMailMessage = stMailTemplate::render('stOrder/sendOrderToAdminHtml', array('order' => $order, 'head' => $mailHtmlHead, 'foot' => $mailHtmlFoot, 'smarty' => $this->smarty, 'config_points' => $config_points, 'mail_config' => $mail_config));
        $sendOrderToAdminPlainMailMessage = stMailTemplate::render('stOrder/sendOrderToAdminPlain', array('order' => $order, 'smarty' => $this->smarty, 'config_points' => $config_points));

        $mail = stMailer::getInstance();
        $mail->setSubject($this->getRequest()->getHost().' - '.__('złożono nowe zamówienie numer', null, 'stOrder').': '.$order->getNumber())->setHtmlMessage($sendOrderToAdminHtmlMailMessage)->setPlainMessage($sendOrderToAdminPlainMailMessage)->setReplyTo($order->getSfGuardUser()->getUsername());

        stEventDispatcher::getInstance()->notify(new sfEvent($mail, 'stOrderActions.sendMailWithOrderToAdmin', array('order' => $order)));
        
        $ret = $mail->sendToMerchant();

        $user->setCulture($culture);

        return $ret;
    }
}
