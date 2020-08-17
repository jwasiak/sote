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
 * @version     $Id: actions.class.php 16775 2012-01-18 11:56:23Z marcin $
 */

/**
 * Akcje aplikacji stOrder
 *
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 *
 * @package     stOrder
 * @subpackage  actions
 */
class stOrderActions extends autostOrderActions
{

   protected $orderProductRequest = null;

   public function executeAjaxPriceModifiers()
   {
      $ids = explode('-', $this->getRequestParameter('ids'));

      $product = ProductPeer::retrieveByPK($this->getRequestParameter('id'));

      $price_brutto = stPrice::computePriceModifiers($product, $product->getPriceBrutto(), 'brutto');

      $price_netto = stPrice::extract($price_brutto, $product->getVat());

      $data = $this->getPriceModifierData($product, $ids);

      $ids = array();

      foreach ($data as $v)
      {
         $ids[] = $v['selected'];
      }

      $options = ProductOptionsValuePeer::retrieveByPKs($ids);

      $price_type = ProductOptionsValuePeer::getPriceType($product);

      foreach ($options as $option)
      {
         stNewProductOptions::addProductPriceModifier($product, $option->getPrice(), $option->getDepth(), $price_type);
      }

      $price_brutto = stPrice::computePriceModifiers($product, $product->getPriceBrutto(), 'brutto');

      $price_netto = stPrice::extract($price_brutto, $product->getVat());

      $this->getResponse()->setContentType('application/json');

      return $this->renderText(json_encode(array('pb' => $price_brutto, 'pn' => $price_netto, 'data' => $data)));
   }

   public static function getPriceModifierDataRecursive($product, $options, &$selected_ids, $price_type, &$data)
   {
      $product_config = $product->getConfiguration();

      $select_options = array();

      $field_id = $options[0]->getProductOptionsField()->getId();

      $selected = $options[0];

      $last_option_id = end($options)->getId();

      $selected_id = current($selected_ids);

      foreach ($options as $option)
      {
         $option_id = $option->getId();

         $field = $option->getProductOptionsField();

         $current_field_id = $field->getId();

         if ($field_id != $current_field_id)
         {
            $data[] = array('field' => $field->getName(), 'data' => $select_options, 'selected' => $selected->getId());

            $selected_id = next($selected_ids);

            if ($selected->hasChildren())
            {
               self::getPriceModifierDataRecursive($product, $selected->getChildOptions($product_config->get('hide_options_with_empty_stock')), $selected_ids, $price_type, $data);
            }

            $select_options = array();

            $selected = $option;
         }
         elseif ($selected_id && $selected_id == $option_id || false === $selected_id && $option->getOptValue() == $field->getOptDefaultValue())
         {
            $selected = $option;
         }

         $select_options[$option_id] = $option->getValue();

         if ($last_option_id == $option_id)
         {
            $data[] = array('field' => $field->getName(), 'data' => $select_options, 'selected' => $selected->getId());

            $selected_id = next($selected_ids);

            if ($selected->hasChildren())
            {
               self::getPriceModifierDataRecursive($product, $selected->getChildOptions($product_config->get('hide_options_with_empty_stock')), $selected_ids, $price_type, $data);
            }
         }
      }

      return $data;
   }

   public function executeAjaxSearchProduct()
   {
      $query = $this->getRequestParameter('query');

      $by = $this->getRequestParameter('by');

      $vat_eu = $this->getRequestParameter('vat_eu');

      $order = OrderPeer::retrieveByPK($this->getRequestParameter('order_id'));

      $currency = stCurrency::getInstance(sfContext::getInstance());

      $prev_currency_id = $currency->get()->getId();

      if ($order)
      {
         $order_currency = CurrencyPeer::retrieveByIso($order->getOrderCurrency()->getShortcut());

         if ($order_currency) {
            $currency->set($order_currency->getId());
            $dispatcher = $this->getController()->getDispatcher();
            $dispatcher->connect('Product.postHydrate', array('appAddPricePluginListener', 'productPostHydrate'));
            $dispatcher->connect('ProductOptionsValue.postHydrate', array('appAddPricePluginListener', 'productOptionsValuePostHydrate'));
            $dispatcher->connect('ProductPeer.postAddSelectColumns', array('appAddPricePluginListener', 'productPostAddSelectColumns'));
            $dispatcher->connect('BasePeer.preDoSelectRs', array('appAddPricePluginListener', 'preDoSelectRs'));         
         }
      }

      $c = new Criteria();

      $c->setLimit(50);

      switch ($by)
      {
         case 'code':
            $c->add(ProductPeer::CODE, $query.'%', Criteria::LIKE);
            break;
         case 'name':
            $c->add(ProductI18nPeer::NAME, '%'.$query.'%', Criteria::LIKE);
            break;
      }

      Product::enableFrontendFunctions();

      $products = ProductPeer::doSelectWithI18n($c, $order->getClientCulture());

      $suggestions = array();

      $data = array();

      sfLoader::loadHelpers(array('Helper', 'stCurrency', 'stProductImage'));

      $i18n = $this->getContext()->getI18N();

      if ($vat_eu)
      {
         $tax = TaxPeer::retrieveByTax(0);

         $tax_id = $tax->getId();
      }

      foreach ($products as $product)
      {
         $price_modifiers = array();

         $price_netto = $product->getPriceNetto(true, false, false);

         $price_brutto = $vat_eu ? $price_netto : $product->getPriceBrutto(true, false, false);         

         $suggestions[] = $product->getCode().': '.$product->getName();

         $hidden_data = array('pm' => $price_modifiers, 'io' => $product->getOptImage(), 'id' => $product->getId());

         $data[] = array('ip' => st_product_image_path($product, 'icon'), 'c' => $product->getCode(), 'n' => $product->getName(), 'pn' => $price_netto, 't' => $vat_eu ? $tax_id : $product->getTaxId(), 'pb' => $price_brutto);
      }

      $currency->set($prev_currency_id);

      Product::enableFrontendFunctions(false);

      return $this->renderJSON(array('query' => $query, 'suggestions' => $suggestions, 'data' => $data));
   }

   public function executeMode()
   {
      $type = $this->getRequestParameter('type');

      $this->getUser()->setAttribute('edit_mode', $type == 'edit', 'soteshop/stOrder');

      return $this->redirect('stOrder/edit?id='.$this->getRequestParameter('id'));
   }

   protected function getOrderOrCreate($id = 'id')
   {
      $order = parent::getOrderOrCreate($id);

      $user = $this->getUser();

      $edit_mode = $this->getUser()->getAttribute('edit_mode', false, 'soteshop/stOrder');

      $user->setParameter('hide', $edit_mode, 'stOrder/edit/fields/proforma');

      $user->setParameter('hide', $edit_mode, 'stOrder/edit/fields/invoice');

      $order = parent::getOrderOrCreate($id);

      return $order;
   }

   protected function getPriceModifierData($product, $selected_ids = array())
   {
      $options = ProductOptionsValuePeer::doSelectByProduct($product);

      $price_type = ProductOptionsValuePeer::getPriceType($product);

      $data = array();

      self::getPriceModifierDataRecursive($product, $options, $selected_ids, $price_type, $data);

      return $data;
   }

   /**
    * Filtr po kolumnie klient
    * Szukanie po imieniu i nazwisku, ale również po mail'u jeśli zawarta jest '@' w wyszukiwaniu
    *
    * @param      Criteria    $c
    */
   protected function addFiltersCriteria($c)
   {
      parent::addFiltersCriteria($c);

      if (isset($this->filters['order_product']) && $this->filters['order_product'])
      {

         if (is_numeric($this->filters['order_product']))
         {
            $token = array('id' => $this->filters['order_product']);
         }
         else
         {
            $tokens = stJQueryToolsHelper::parseTokensFromRequest($this->filters['order_product']);
            $token = $tokens ? $tokens[0] : null;
         }

         if ($token && !isset($token['new']))
         {
            $c->addJoin(OrderPeer::ID, OrderProductPeer::ORDER_ID);
            $c->add(OrderProductPeer::PRODUCT_ID, $token['id']);
         }
         elseif ($token)
         {
            $c->addJoin(OrderPeer::ID, OrderProductPeer::ORDER_ID);
            $cc = $c->getNewCriterion(OrderProductPeer::CODE, trim($token['id']), Criteria::LIKE);
            $cc->addOr($c->getNewCriterion(OrderProductPeer::NAME, '%'.trim($token['id']).'%', Criteria::LIKE));
            $c->add($cc);
         }
      }

      if (isset($this->filters['filter_client']) && !empty($this->filters['filter_client']))
      {
         $cc = $c->getNewCriterion(OrderPeer::OPT_CLIENT_NAME, '%'.$this->filters['filter_client'].'%', Criteria::LIKE);

         $cc->addOr($c->getNewCriterion(OrderPeer::OPT_CLIENT_EMAIL, '%'.$this->filters['filter_client'].'%', Criteria::LIKE));

         $cc->addOr($c->getNewCriterion(OrderPeer::OPT_CLIENT_COMPANY, '%'.$this->filters['filter_client'].'%', Criteria::LIKE));

         $c->add($cc);
      }

      OrderPeer::addStatusFilterCriteria($c, $this->filters);

      if (isset($this->filters['is_confirmed']) && !empty($this->filters['is_confirmed']))
      {
         $c->add(OrderPeer::IS_CONFIRMED, $this->filters['is_confirmed']);
      }

      if (isset($this->filters['is_payed']) && $this->filters['is_payed'] !== "")
      {
         $c->add(OrderPeer::OPT_IS_PAYED, $this->filters['is_payed']);
      }

      if (isset($this->filters['filter_delivery']) && $this->filters['filter_delivery'] !== "")
      {
         $c->addJoin(OrderPeer::ORDER_DELIVERY_ID, OrderDeliveryPeer::ID);
         $c->add(OrderDeliveryPeer::DELIVERY_ID, $this->filters['filter_delivery']);
      }

      if (isset($this->filters['filter_payment']) && $this->filters['filter_payment'] !== "" || isset($this->filters['gift_card_code']) && $this->filters['gift_card_code'] !== "")
      {
         $c->addJoin(OrderPeer::ID, OrderHasPaymentPeer::ORDER_ID);
         $c->addJoin(OrderHasPaymentPeer::PAYMENT_ID, PaymentPeer::ID);

         if ($this->filters['filter_payment'] == 'gift_card')
         {
            $c->add(PaymentPeer::GIFT_CARD_ID, null, Criteria::ISNOTNULL);
         }
         elseif (isset($this->filters['filter_payment']) && $this->filters['filter_payment'] !== "")
         {
            $c->add(PaymentPeer::PAYMENT_TYPE_ID, $this->filters['filter_payment']);
         }

         if (isset($this->filters['gift_card_code']) && $this->filters['gift_card_code'] !== "")
         {
            $giftCard = GiftCardPeer::retrieveByCode($this->filters['gift_card_code']);
            $c->add(PaymentPeer::GIFT_CARD_ID, $giftCard ? $giftCard->getId() : 0);
         }
      }

      if (isset($this->filters['discount_coupon_code']) && $this->filters['discount_coupon_code'] !== "")
      {
         $c->addJoin(OrderPeer::DISCOUNT_COUPON_CODE_ID, DiscountCouponCodePeer::ID);
         $c->add(DiscountCouponCodePeer::CODE, $this->filters['discount_coupon_code']);
      }

      $c->add(OrderPeer::OPT_ALLEGRO_NICK, null, Criteria::ISNULL);
   }

   protected function addAllegroFiltersCriteria($c)
   {
      parent::addAllegroFiltersCriteria($c);

      if (isset($this->filters['order_product']) && $this->filters['order_product'])
      {

         if (is_numeric($this->filters['order_product']))
         {
            $token = array('id' => $this->filters['order_product']);
         }
         else
         {
            $tokens = stJQueryToolsHelper::parseTokensFromRequest($this->filters['order_product']);
            $token = $tokens ? $tokens[0] : null;
         }

         if ($token && !isset($token['new']))
         {
            $c->addJoin(OrderPeer::ID, OrderProductPeer::ORDER_ID);
            $c->add(OrderProductPeer::PRODUCT_ID, $token['id']);
         }
         elseif ($token)
         {
            $c->addJoin(OrderPeer::ID, OrderProductPeer::ORDER_ID);
            $cc = $c->getNewCriterion(OrderProductPeer::CODE, trim($token['id']), Criteria::LIKE);
            $cc->addOr($c->getNewCriterion(OrderProductPeer::NAME, '%'.trim($token['id']).'%', Criteria::LIKE));
            $c->add($cc);
         }
      }

      if (isset($this->filters['filter_client']) && !empty($this->filters['filter_client']))
      {
         $cc = $c->getNewCriterion(OrderPeer::OPT_CLIENT_NAME, '%'.$this->filters['filter_client'].'%', Criteria::LIKE);

         $cc->addOr($c->getNewCriterion(OrderPeer::OPT_CLIENT_EMAIL, '%'.$this->filters['filter_client'].'%', Criteria::LIKE));

         $cc->addOr($c->getNewCriterion(OrderPeer::OPT_CLIENT_COMPANY, '%'.$this->filters['filter_client'].'%', Criteria::LIKE));

         $c->add($cc);
      }

      OrderPeer::addStatusFilterCriteria($c, $this->filters);

      if (isset($this->filters['is_confirmed']) && !empty($this->filters['is_confirmed']))
      {
         $c->add(OrderPeer::IS_CONFIRMED, $this->filters['is_confirmed']);
      }

      if (isset($this->filters['is_payed']) && $this->filters['is_payed'] !== "")
      {
         $c->add(OrderPeer::OPT_IS_PAYED, $this->filters['is_payed']);
      }

      if (isset($this->filters['filter_delivery']) && $this->filters['filter_delivery'] !== "")
      {
         $c->addJoin(OrderPeer::ORDER_DELIVERY_ID, OrderDeliveryPeer::ID);
         $c->add(OrderDeliveryPeer::DELIVERY_ID, $this->filters['filter_delivery']);
      }

      if (isset($this->filters['filter_payment']) && $this->filters['filter_payment'] !== "")
      {
         $c->addJoin(OrderPeer::ID, OrderHasPaymentPeer::ORDER_ID);
         $c->addJoin(OrderHasPaymentPeer::PAYMENT_ID, PaymentPeer::ID);
         $c->add(PaymentPeer::PAYMENT_TYPE_ID, $this->filters['filter_payment']);
      }

      // $c->add(OrderPeer::OPT_ALLEGRO_AUCTION_ID, null, Criteria::ISNULL);
   }

   protected function addSortCriteria($c)
   {
      if ($sort_column = $this->getUser()->getAttribute('sort', null, 'sf_admin/autoStOrder/sort'))
      {
         if ($sort_column == 'total_amount')
         {
            $this->addOptTotalAmountCriteria($c);
         }
         else
         {
            $sort_column = $this->translateSortColumn($sort_column);
         }

         if ($this->getUser()->getAttribute('type', null, 'sf_admin/autoStOrder/sort') == 'asc')
         {
            if ($sort_column == OrderPeer::NUMBER)
            {
               $c->addAscendingOrderByColumn($sort_column.' + 0');
            }

            $c->addAscendingOrderByColumn($sort_column);
         }
         else
         {
            if ($sort_column == OrderPeer::NUMBER)
            {
               $c->addDescendingOrderByColumn($sort_column.' + 0');
            }

            $c->addDescendingOrderByColumn($sort_column);
            
         }
      }
   }

   protected function addAllegroSortCriteria($c)
   {
      if ($sort_column = $this->getUser()->getAttribute('sort', null, 'sf_admin/autoStOrder/allegro_sort'))
      {
         if ($sort_column == 'total_amount')
         {
            $this->addOptTotalAmountCriteria($c);
         }
         else
         {
            $sort_column = $this->translateAllegroSortColumn($sort_column);
         }

         if ($sort_column == OrderStatusPeer::OPT_NAME)
         {
            $c->addJoin(OrderPeer::ORDER_STATUS_ID, OrderStatusPeer::ID);
         }

         if ($this->getUser()->getAttribute('type', null, 'sf_admin/autoStOrder/allegro_sort') == 'asc')
         {
            if ($sort_column == OrderPeer::NUMBER)
            {
               $c->addAscendingOrderByColumn($sort_column.' + 0');
            }

            $c->addAscendingOrderByColumn($sort_column);
         }
         else
         {
            if ($sort_column == OrderPeer::NUMBER)
            {
               $c->addDescendingOrderByColumn($sort_column.' + 0');
            }

            $c->addDescendingOrderByColumn($sort_column);
         }
      }
   }

   /**
    * Wysłanie maila ze statusem po zapisie zamówienia
    *
    * @param        $order      Order
    */
   public function saveOrder($order)
   {
      $i18n = $this->getContext()->getI18N();

      $edit_mode = $this->getUser()->getAttribute('edit_mode', false, 'soteshop/stOrder');

      $culture = $this->getUser()->getCulture();

      if ($order->getClientCulture())
      {
         $this->getUser()->setCulture($order->getClientCulture());
      }

      $order_status_modified = $order->isColumnModified(OrderPeer::ORDER_STATUS_ID);

      if ($edit_mode)
      {
         $this->cleanOrderProducts($order);

         $this->cleanOrderPayments($order);

         $order->forceTotalAmountUpdate();
      }

      parent::saveOrder($order);

      $this->saveOrderPayment($order);

      // OrderPeer::updateOptIsPaid($order);

      if ($order_status_modified && $order->getOrderStatus()->getHasMailNotification())
      {
         $status = $this->sendOrderStatus($order);
         
         if(stPoints::isPointsAssigned($order)==false){
            stPoints::addPointForOrder($order);    
         }
         
      }

      $this->getUser()->setCulture($culture);

      if ($order_status_modified && $order->getOrderStatus()->getHasMailNotification())
      {
         if (!$status)
         {
            $this->setFlash('warning', 'e-mail informujący o zmianie statusu nie został wysłany do klienta -> sprawdź konfigurację e-mail...');
         }
         else
         {
            $flash_text = $i18n->__('Twoje zmiany zostały zapisane - informacja o zmianie statusu wysłana na adres');

            $this->setFlash('notice', $flash_text.' "'.$this->order->getGuardUser().'"');
         }
      }

      DashboardPeer::doRefreshAll();
   }

   /**
    * Weryfikuje poprawność formatu numeru zamówienia
    *
    * @return   bool
    */
   public function validateConfig()
   {
      if ($this->getRequest()->getMethod() == sfRequest::POST)
      {
         $number_format = $this->getRequestParameter('config[number_format]');

         $validator = new stOrderValidator();

         if (!$validator->execute($number_format, $error))
         {
            $this->getRequest()->setError('config{number_format}', $error);
            return false;
         }
      }

      return true;
   }

   public function validateOrderStatusEdit()
   {
      $ok = true;

      if ($this->getRequest()->getMethod() == sfRequest::POST && $this->hasRequestParameter('order_status[attach_coupon_code]'))
      {
         $coupon_code = $this->getRequestParameter('coupon_code');

         $validator = new sfNumberValidator();

         if (empty($coupon_code['discount']))
         {
            $this->getRequest()->setError('order_status{coupon_code_discount}', 'Podaj kod');

            $ok = false;
         }
         else
         {
            $validator->initialize($this->getContext(), array(
                'type' => 'any',
                'min' => 0.1,
                'max' => 99,
                'min_error' => 'Wartość musi być większa od 0',
                'max_error' => 'Wartość nie może być większa od 99',
                'type_error' => "Nieprawidłowy format (przykład: 10, 10.5)",
                'nan_error' => "Nieprawidłowy format (przykład: 10, 10.5)"
            ));

            if (!$validator->execute($coupon_code['discount'], $error))
            {
               $this->getRequest()->setError('order_status{coupon_code_discount}', $error);

               $ok = false;
            }
         }

         if (empty($coupon_code['valid_for']) && $coupon_code['valid_for'] === '')
         {
            $this->getRequest()->setError('order_status{coupon_code_valid_for}', 'Podaj ilość dni');

            $ok = false;
         }
         else
         {
            $validator->initialize($this->getContext(), array(
                'type' => 'integer',
                'min' => 0,
                'min_error' => 'Wartość nie może być ujemna',
                'type_error' => "Nieprawidłowy format (przykład: 1, 10)",
                'nan_error' => "Nieprawidłowy format (przykład: 1, 10)"
            ));

            if (!$validator->execute($coupon_code['valid_for'], $error))
            {
               $this->getRequest()->setError('order_status{coupon_code_valid_for}', $error);

               $ok = false;
            }
         }
      }

      return $ok;
   }

   public function validateEdit()
   {
      $i18n = $this->getContext()->getI18N();

      $ok = true;

      $edit_mode = $this->getUser()->getAttribute('edit_mode', false, 'soteshop/stOrder');

      if ($edit_mode && $this->getRequest()->getMethod() == sfRequest::POST)
      {
         if (!$this->hasRequestParameter('validation_token')) {
            $this->setFlash('warning', 'Przesłane żądanie jest niekompletne, proszę ponownie wprowadzić i zapisać zmiany.<br>Jeżeli problem będzie się powtarzał proszę spróbować ponownie z poziomu innej przeglądarki, komputera lub innego połączenia internetowego');

            return $this->redirect($this->getRequest()->getReferer());
         }

         $order_products = $this->getOrderProductRequest();

         if (false === $order_products)
         {
            $this->setFlash('warning', 'Przesłane żądanie jest niekompletne, proszę ponownie wprowadzić i zapisać zmiany.<br>Jeżeli problem będzie się powtarzał proszę spróbować ponownie z poziomu innej przeglądarki, komputera lub innego połączenia internetowego');

            return $this->redirect($this->getRequest()->getReferer());
         }

         $index = 0;

         foreach ($order_products as $order_product)
         {
            if (empty($order_product['name']))
            {
               $this->getRequest()->setError('order{product}{'.$index.'}{name}', $i18n->__('Podaj nazwę produktu'));

               $ok = false;
            }

            if (empty($order_product['code']))
            {
               $this->getRequest()->setError('order{product}{'.$index.'}{code}', $i18n->__('Podaj kod produktu'));

               $ok = false;
            }

            $index++;
         }

         if (!$ok)
         {
            $this->getRequest()->setError('order{product}', $i18n->__('Popraw dane'));
         }
         elseif (!$order_products)
         {
            $this->getRequest()->setError('order{product}', $i18n->__('Musisz dodać przynajmniej jeden produkt'));
         }

         if (!$this->validateUserData('billing'))
         {
            $ok = false;
         }

         if (!$this->validateUserData('delivery'))
         {
            $ok = false;
         }
      }

      return $ok;
   }

   protected function validateUserData($type)
   {
      $i18n = $this->getContext()->getI18N();

      $request = $this->getRequest();

      $ok = true;

      $parameters = $request->getParameter('order[user_data]['.$type.']');

      $error_namespace = 'order{user_data}{'.$type.'}';

      if (isset($parameters['address']) && empty($parameters['address']))
      {
         $request->setError($error_namespace.'{address}', $i18n->__('Adres linia 1'));

         $ok = false;
      }

      if (isset($parameters['code']) && empty($parameters['code']))
      {
         $request->setError($error_namespace.'{code}', $i18n->__('Uzupełnij kod pocztowy'));

         $ok = false;
      }

      if (isset($parameters['town']) && empty($parameters['town']))
      {
         $request->setError($error_namespace.'{town}', $i18n->__('Uzupełnij miasto'));

         $ok = false;
      }

      if (!$ok)
      {
         $request->setError('order{user_data}', $i18n->__('Popraw dane'));
      }

      return $ok;
   }

   public function handleErrorEdit()
   {
      $ret = parent::handleErrorEdit();

      $request = $this->getOrderProductRequest();

      $order_products = $this->order->getOrderProducts();

      foreach ($order_products as $order_product)
      {
         if (!$order_product->isNew() && !isset($request[$order_product->getId()]))
         {
            $order_product->setDeleted(true);
         }
      }

      return $ret;
   }

   protected function cleanOrderProducts($order)
   {
      $request = $this->getOrderProductRequest();

      $order_products = $order->getOrderProducts();

      foreach ($order_products as $order_product)
      {
         if (!$order_product->isNew() && !isset($request[$order_product->getId()]))
         {
            $order_product->delete();
         }
      }
   }

   protected function cleanOrderPayments($order)
   {
      $request = array();

      $order_request = $this->getRequestParameter('order');

      foreach ($order_request['payment'] as $data)
      {
         if (!$data['payment_id'])
         {
            continue;
         }

         $request[$data['payment_id']] = $data['payment_id'];
      }

      foreach ($order->getOrderHasPaymentsJoinPayment() as $ohp)
      {
         $payment = $ohp->getPayment();

         if (!$payment->isNew() && !isset($request[$payment->getId()]))
         {
            echo "deleteing: {$payment->getId()}<br />";
            $payment->delete();
         }
      }
   }

   protected function getOrderProductRequest()
   {
      if (null === $this->orderProductRequest)
      {
         $request = json_decode($this->getRequestParameter('order[product]'), true);  

         if (false === $request) 
         {
            return false;
         }

         $tmp = array();  

         if ($request)
         {      
            foreach ($request as $index => $v)
            {
               if (isset($v['oid']) && $v['oid'])
               {
                  $tmp[$v['oid']] = $v;
               }
               else
               {
                  $tmp['new-'.$index] = $v;
               }
            }
         }

         $this->orderProductRequest = $tmp;
      }

      return $this->orderProductRequest;
   }

   protected function updateOrderUserData()
   {
      $request = $this->getRequestParameter('order[user_data]');

      if ($request)
      {
         $this->order->getOrderUserDataBilling()->fromArray($request['billing'], BasePeer::TYPE_FIELDNAME);

         $this->order->getOrderUserDataDelivery()->fromArray($request['delivery'], BasePeer::TYPE_FIELDNAME);

         if (isset($request['billing']['full_name']))
         {
            $this->order->setOptClientName($request['billing']['full_name']);
         }

         if (isset($request['billing']['company']))
         {
            $this->order->setOptClientCompany($request['billing']['company']);
         }

      }
   }

   protected function updateOrderProducts()
   {
      $request = $this->getOrderProductRequest();

      if ($request)
      {
         $order_products = array();

         foreach ($this->order->getOrderProducts() as $order_product)
         {
            $order_products[$order_product->getId()] = $order_product;
         }

         $currency = $this->order->getOrderCurrency();

         foreach ($request as $id => $v)
         {
            if (isset($order_products[$id]))
            {
               $order_product = $order_products[$id];
            }
            else
            {
               $order_product = new OrderProduct();
               $order_product->setVersion(2);
               $this->order->addOrderProduct($order_product);
            }

            if ($v['code'] != $order_product->getCode())
            {
               $order_product->setCode($v['code']);

               $c = new Criteria();

               $c->add(ProductPeer::CODE, $v['code']);

               $product = ProductPeer::doSelectOne($c);

               if ($product)
               {
                  $order_product->setProductId($product->getId());

                  $order_product->setImage($product->getOptImage());
               }
            }

            if ($v['discount'])
            {
               if ($v['discount_type'] == '%') 
               {
                   $discount = array('value' => null, 'percent' => $v['discount']);
               } 
               else
               {
                   $discount = array('name' => null, 'value' => $v['discount']);
               }

               $order_product->setDiscount(array('value' => $v['discount'], 'type' => $v['discount_type']));
            }
            else
            {
               $order_product->setDiscount(null);
            }

            $order_product->setName($v['name']);

            $order_product->setTaxId($v['tax']);

            if ($order_product->getVersion() >= 2)
            {
                $order_product->setPriceNetto($v['price_netto']);
                $order_product->setPriceBrutto($v['price_brutto']);
            }
            else
            {
                $order_product->setCustomPriceNetto($v['price_netto']);
                $order_product->setCustomPriceBrutto($v['price_brutto']);
            }

            $order_product->setQuantity($v['quantity']);
         }
      }
   }

   protected function updateOrderStatusOrderStatusFromRequest()
   {
      parent::updateOrderStatusOrderStatusFromRequest();

      if ($this->hasRequestParameter('order_status[attach_coupon_code]'))
      {
         $coupon_code = $this->getRequestParameter('coupon_code');

         $cc = new OrderStatusCouponCode();

         $cc->setDiscount($coupon_code['discount']);

         $cc->setValidFor($coupon_code['valid_for']);

         $this->order_status->setCouponCode($cc);
      }
   }

   protected function updateOrderFromRequest()
   {
      parent::updateOrderFromRequest();

      $order = $this->getRequestParameter('order');

      if (isset($order['delivery_number']))
      {
         $this->order->getOrderDelivery()->setNumber($order['delivery_number']);
      }

      if (isset($order['discount']))
      {
         $this->order->setDiscountId($order['discount'] === "" ? null : $order['discount']);
      }

      $this->updateOrderProducts();

      $this->updateOrderUserData();

      $this->updateOrderDelivery();
   }

   protected function updateOrderDelivery()
   {
      $order = $this->getRequestParameter('order');

      $order_delivery = $this->order->getOrderDelivery();

      if (isset($order['delivery']['type_id']))
      {
         $order_delivery->setDeliveryId($order['delivery']['type_id']);

         $order_delivery->setName($order_delivery->getDelivery()->getName());
      }
      elseif (isset($order['delivery']['type']))
      {
         $order_delivery->setName($order['delivery']['type']);
      }

      if (isset($order['delivery']['cost']))
      {
         $order_delivery->setCustomCostBrutto($order['delivery']['cost']);
      }

      if (isset($order['delivery']['delivery_date']) && !empty($order['delivery']['delivery_date']))
      {
         $order_delivery->setDeliveryDate($order['delivery']['delivery_date']);
      }

      $order_delivery->setNumber($order['delivery']['number']);
   }

   protected function saveOrderPayment(Order $order)
   {
      $request = $this->getRequestParameter('order');

      $payments = array();

      foreach ($order->getOrderHasPaymentsJoinPayment() as $ohp)
      {
         $payments[$ohp->getPayment()->getId()] = $ohp->getPayment();
      }

      foreach ($request['payment'] as $data)
      {
         $payment = $data['payment_id'] && isset($payments[$data['payment_id']]) ? $payments[$data['payment_id']] : null;

         if (!$payment)
         {
            $payment = stPayment::newPaymentInstance($data['payment_type'], $data['payment_amount'], array('user_id' => $order->getSfGuardUserId(), 'is_paid' => isset($data['payment_status'])));

            $order->addOrderPayment($payment);
         }

         if (isset($data['payment_type']))
         {
            $payment->setPaymentTypeId($data['payment_type']);
         }

         if (isset($data['payment_amount']))
         {
            $payment->setAmount($data['payment_amount']);
         }

         if (isset($data['payment_status']) || null !== $payment->getGiftCard())
         {
            $payment->setStatus(true);
         }
         else
         {
            $payment->setStatus(false);

            $payment->setPayedAt(null);
         }

         $payment->save();
      }
   }

   /**
    *
    * @param Order $order 
    */
   protected function attachCouponCode(Order $order)
   {
      if (!$order->getOrderStatus()->getAttachCouponCode())
      {
         return null;
      }

      $order_status = $order->getOrderStatus();

      $coupon_code = new DiscountCouponCode();

      $coupon_code->setDiscount($order_status->getCouponCodeDiscount());

      $coupon_code->setValidUsage(1);

      $coupon_code->setOrderId($order->getId());

      $coupon_code->setValidFrom($order->getUpdatedAt());

      $valid_for = $order_status->getCouponCodeValidFor();

      if ($valid_for > 0)
      {
         $coupon_code->setValidFor($valid_for);
      }

      $coupon_code->save();

      return $coupon_code;
   }

   /**
    * Wysyła mail z zamówieniem do klienta
    */
   public function sendOrderStatus($order)
   {
      $send_link = 0;

      $c = new Criteria();
      $c->add(InvoicePeer::ORDER_ID , $order->getId());
      $c->add(InvoicePeer::IS_CONFIRM , 1);
      $invoice = InvoicePeer::doSelectOne($c);

      if($invoice)
      {
         $send_link = 1;
      }
      
      $mail_config = stConfig::getInstance($this->getContext(), 'stMailAccountBackend');

      $coupon_code = $this->attachCouponCode($order);

      $mailHtmlHead = stMailer::getHtmlMailDescription("header");

      $mailHtmlFoot = stMailer::getHtmlMailDescription("footer");

      $mailHtmlHeadContent = stMailer::getHtmlMailDescription("top_order_status");
      
      $mailHtmlHeadContent = stEventDispatcher::getInstance()->filter(new sfEvent($this, 'stOrder.sendOrderStatus_mailHtmlHeadContent', array('order' => $order)), $mailHtmlHeadContent)->getReturnValue();
      
      $mailHtmlFootContent = stMailer::getHtmlMailDescription("bottom_order_status");

      $orderStatus = $order->getOrderStatus();
      $orderStatus->setCulture($order->getClientCulture());

      $mailHtmlHead = str_replace('{ORDER_STATUS}', $orderStatus, $mailHtmlHead);

      $mailHtmlFoot = str_replace('{ORDER_STATUS}', $orderStatus, $mailHtmlFoot);

      $mailHtmlHeadContent = str_replace('{ORDER_STATUS}', "<b>".$orderStatus."</b>", $mailHtmlHeadContent);
      
      $mailHtmlFootContent = str_replace('{ORDER_STATUS}', "<b>".$orderStatus."</b>", $mailHtmlFootContent);

      $html = stMailTemplate::render('orderStatusHtml', array('order' => $order, 'send_link' => $send_link, 'coupon_code' => $coupon_code, 'head' => $mailHtmlHead,
                  'foot' => $mailHtmlFoot, 'head_content' => $mailHtmlHeadContent, 'foot_content' => $mailHtmlFootContent, 'mail_config'=>$mail_config ));

      $mailPlainHead = stMailer::getPlainMailDescription("header");

      $mailPlainFoot = stMailer::getPlainMailDescription("footer");

      $mailPlainHeadContent = stMailer::getPlainMailDescription("top_order_status");
      
      $mailPlainHeadContent = stEventDispatcher::getInstance()->filter(new sfEvent($this, 'stOrder.sendOrderStatus_mailPlainHeadContent', array('order' => $order)), $mailPlainHeadContent)->getReturnValue();

      $mailPlainFootContent = stMailer::getPlainMailDescription("bottom_order_status");

      $mailPlainHead = str_replace('{ORDER_STATUS}', $order->getOrderStatus(), $mailPlainHead);

      $mailPlainFoot = str_replace('{ORDER_STATUS}', $order->getOrderStatus(), $mailPlainFoot);

      $mailPlainHeadContent = str_replace('{ORDER_STATUS}', $order->getOrderStatus(), $mailPlainHeadContent);

      $mailPlainFootContent = str_replace('{ORDER_STATUS}', $order->getOrderStatus(), $mailPlainFootContent);

      $plain = stMailTemplate::render('orderStatusPlain', array('order' => $order, 'send_link' => $send_link, 'coupon_code' => $coupon_code, 'head' => $mailPlainHead,
                  'foot' => $mailPlainFoot, 'head_content' => $mailPlainHeadContent, 'foot_content' => $mailPlainFootContent));

      $mail = stMailer::getInstance();

      /**
       * zmieniono z $i18n = $this->getContext()->getI18N(); na potrzeby wysyłania maila z API 
       */
      $context = sfContext::getInstance();
      $i18n = $context->getI18N();

      if($order->getHost()!="")
      {
         $host = $order->getHost();
      }
      else
      {
         $host = $context->getRequest()->getHost();
      }

      $subject = $i18n->__('Zamówienie numer %number%: %status%', array('%host%' => $host, '%number%' => $order->getNumber(), '%status%' => $order->getOrderStatus()));

      $c = new Criteria();
      $c->add(sfGuardUserPeer::ID, $order->getSfGuardUserId());
      $user = sfGuardUserPeer::doSelectOne($c);

      if($user){
         $user_mail = $user->getUsername(); 
      }else{
          $user_mail = $order->getOptClientEmail();
      }
    
      $mail->setSubject($subject)->setHtmlMessage($html)->setPlainMessage($plain)->setTo($user_mail);

      stEventDispatcher::getInstance()->notify(new sfEvent($mail, 'stOrderActions.sendOrderStatus', array('order_status' => $orderStatus, 'order'=> $order)));

      $ret = $mail->sendToClient();

      if (!$ret && $coupon_code)
      {
         $coupon_code->delete();
      }

      return $ret;
   }

   /**
    * Dodanie błędu wysyłania
    */
   protected function getLabels()
   {
      $labels = parent::getLabels();
      $labels['send_error'] = '';
      $labels['order{product}'] = 'Zawartość';
      $labels['order{user_data}'] = 'Dane klienta';
      return $labels;
   }

   protected function filterCriteriaByIsConfirmed(Criteria $c, $v)
   {
      if (!$v)
      {
         $criterion = $c->getNewCriterion(OrderPeer::IS_CONFIRMED, false);
         $criterion->addOr($c->getNewCriterion(OrderPeer::IS_CONFIRMED, null, Criteria::ISNULL));
         $c->add($criterion);
      }
      else
      {
         $c->add(OrderPeer::IS_CONFIRMED, $v);
      }
      return true;
   }

   public function executeEdit()
   {
      parent::executeEdit();

      if (!$this->order->isAllegroOrder())
      {
         $this->getUser()->setParameter('allegro', true, 'soteshop/stAdminGenerator/hidden');
      }
   }

   /**
    * wyswietl zamowienie pdf
    */
   public function executePrintPdf()
   {
      return $this->redirect('stOrderPrintPdf/show?id='.$this->getRequestParameter('id').'&download=1');
   }

   protected function filterCriteriaByOrderOptTotalAmount(Criteria $c, $total_amount)
   {
      $custom = array();

      $column = sprintf('ROUND(%s * %s, 2)', OrderPeer::OPT_TOTAL_AMOUNT, OrderCurrencyPeer::EXCHANGE);

      if ($total_amount['from'])
      {
         $custom[] = sprintf('%s >= %s', $column, floatval($total_amount['from']));
      }

      if ($total_amount['to'])
      {
         $custom[] = sprintf('%s <= %s', $column, floatval($total_amount['to']));
      }


      if ($custom)
      {
         $this->addOptTotalAmountCriteria($c);

         $c->add(OrderPeer::OPT_TOTAL_AMOUNT, implode(' AND ', $custom), Criteria::CUSTOM);
      }

      return true;
   }

   protected function addOptTotalAmountCriteria(Criteria $c)
   {
      if (!$c->getColumnForAs('total_amount'))
      {
         $c->addJoin(OrderPeer::ORDER_CURRENCY_ID, OrderCurrencyPeer::ID);
         
         $c->addAsColumn('total_amount', sprintf('ROUND(%s * %s, 2)', OrderPeer::OPT_TOTAL_AMOUNT, OrderCurrencyPeer::EXCHANGE));
      }
   }

   public function executeBulkStatusUpdate()
   {
      if ($this->getRequest()->getMethod() == sfRequest::POST)
      {
         $id = $this->getRequestParameter('id');
         $page = $this->getRequestParameter('page');
         $order = $this->getRequestParameter('order');

         $culture = $this->getUser()->getCulture();

         foreach (OrderPeer::retrieveByPKs(array_values($order['selected'])) as $order ) 
         {
            $order->setOrderStatusId($id);
            $order->save();

            if ($order->getClientCulture())
            {
               $this->getUser()->setCulture($order->getClientCulture());
            }

            if($order->getOrderStatus()->getHasMailNotification())
            {
               $this->sendOrderStatus($order);
            }
         }

         DashboardPeer::doRefreshAll();

         $this->getUser()->setCulture($culture);
      }



      return $this->redirect($this->getRequest()->getReferer());
   }

   public function executeBulkPaymentStatusUpdate()
   {
      if ($this->getRequest()->getMethod() == sfRequest::POST)
      {
         $id = $this->getRequestParameter('id');
         $page = $this->getRequestParameter('page');
         $order = $this->getRequestParameter('order');

         $c = new Criteria();
         $c->addJoin(PaymentPeer::ID, OrderHasPaymentPeer::PAYMENT_ID);
         $c->add(OrderHasPaymentPeer::ORDER_ID, array_values($order['selected']), Criteria::IN);

         foreach (PaymentPeer::doSelect($c) as $payment)
         {
            if (null !== $payment->getGiftCardId()) 
            {
               continue;
            }

            $payment->setStatus($id);
            $payment->save();
         }
         
         DashboardPeer::doRefreshAll();
      }

      return $this->redirect($this->getRequest()->getReferer());
   }

   public function executeBulkConfirmedStatusUpdate()
   {
      if ($this->getRequest()->getMethod() == sfRequest::POST)
      {
         $id = $this->getRequestParameter('id');
         $page = $this->getRequestParameter('page');
         $order = $this->getRequestParameter('order');


         foreach (OrderPeer::retrieveByPKs(array_values($order['selected'])) as $order ) 
         {
            $order->setIsConfirmed($id);
            OrderPeer::doUpdate($order);
         }

         DashboardPeer::doRefreshAll();
      }

      return $this->redirect($this->getRequest()->getReferer());
   }

}
