<?php

class stPayPalExpressCheckout {

    public function addOrder($response, Product $product) {

        $config = stConfig::getInstance('stPaypal');

        $custom = $response->getPaymentRequest_0_Custom();
        if (!empty($custom)) $custom = json_decode($custom, true);

        /**
         * User
         **/
        $c = new Criteria();
        $c->add(sfGuardUserPeer::USERNAME, $response->getEmail());
        $user = sfGuardUserPeer::doSelectOne($c);

        $billingUserData = $this->getUserDataFromResponse($response, new UserData()); 
        $deliveryUserData = clone $billingUserData;

        if (is_null($user)) {
            $user = stUser::addUser($response->getEmail());

            $billingUserData->setSfGuardUserId($user->getId());
            $billingUserData->setIsDefault(1);
            $billingUserData->setIsBilling(1);
            $billingUserData->save();

            $deliveryUserData->setSfGuardUserId($user->getId());
            $deliveryUserData->setIsDefault(1);
            $deliveryUserData->setIsBilling(0);
            $deliveryUserData->save();
        } else {
            $c = new Criteria();
            $c->add(UserDataPeer::SF_GUARD_USER_ID, $user->getId());
            $c->add(UserDataPeer::IS_BILLING, 1);
            $c->add(UserDataPeer::IS_DEFAULT, 1);
            $defaultBillingUserData = UserDataPeer::doSelectOne($c);

            $c = new Criteria();
            $c->add(UserDataPeer::SF_GUARD_USER_ID, $user->getId());
            $c->add(UserDataPeer::IS_BILLING, 0);
            $c->add(UserDataPeer::IS_DEFAULT, 1);
            $defaultDeliveryUserData = UserDataPeer::doSelectOne($c);

            $stUser = sfContext::getInstance()->getUser();

            if (!$stUser->thisSameUserDataObject($defaultBillingUserData, $billingUserData)) {
                $billingUserData->setSfGuardUserId($user->getId());
                $billingUserData->setIsBilling(1);
                $billingUserData->save();

                stUser::setDefaultUserData($billingUserData->getId(), 1, $user->getId());
            }

            if (!$stUser->thisSameUserDataObject($defaultDeliveryUserData, $deliveryUserData)) {
                $deliveryUserData->setSfGuardUserId($user->getId());
                $deliveryUserData->save();

                stUser::setDefaultUserData($deliveryUserData->getId(), 0, $user->getId());
            }            
        }

        /**
         * Order
         **/
        $order = new Order();
        $order->setClientCulture(sfContext::getInstance()->getUser()->getCulture());
        $order->setHost(sfContext::getInstance()->getRequest()->getHost());
        $order->setOrderStatus(OrderStatusPeer::retrieveDefaultPendingStatus());

        /**
         * User billing and delivery data for order
         **/
        $order->setGuardUser($user);
        $orderBilling = $this->mirrorUserData($order->getOrderUserDataBilling(), $billingUserData);
        $orderDelivery = $this->mirrorUserData($order->getOrderUserDataDelivery(), $deliveryUserData);

        /**
         * Order currency
         **/
        $orderCurrency = $order->getOrderCurrency();

        $c = new Criteria();
        $c->add(CurrencyPeer::SHORTCUT, $response->getPaymentRequest_0_CurrencyCode());
        $currency = CurrencyPeer::doSelectOne($c);

        $orderCurrency->setName($currency->getName());
        $orderCurrency->setExchange($currency->getExchange());
        $orderCurrency->setFrontSymbol($currency->getFrontSymbol());
        $orderCurrency->setBackSymbol($currency->getBackSymbol());
        $orderCurrency->setShortcut($currency->getShortcut());

        $orderProduct = new OrderProduct();
        $orderProduct->setProductId($product->getId());
        $orderProduct->setQuantity($response->getL_PaymentRequest_0_Qty0());
        $orderProduct->setCode($product->getCode());
        $orderProduct->setName($product->getName());
        $orderProduct->setBasePriceBrutto($response->getL_PaymentRequest_0_Amt0());
        $orderProduct->setImage($product->getOptImage());
        $orderProduct->setTax($product->getTax());
        $orderProduct->setPointsEarn($product->getPointsEarn());

        $priceModifiers = $product->getPriceModifiers();

        if ($priceModifiers)
        {
            foreach ($priceModifiers as $index => $price_modifier)
            {
                $priceModifiers[$index]['value'] = null;
                if (isset($priceModifiers[$index]['custom']['label']))
                {
                    $priceModifiers[$index]['label'] = $priceModifiers[$index]['custom']['label'];
                }
            }

            $orderProduct->setPriceModifiers($priceModifiers);
        }

        $order->addOrderProduct($orderProduct);

        /**
         * Order delivery
         **/
        $delivery = DeliveryPeer::retrieveByPK($config->get('express_delivery'));
        $orderDelivery = $order->getOrderDelivery();
        $orderDelivery->setName($delivery->getName());
        $orderDelivery->setTaxId($delivery->getTaxId());
        $orderDelivery->setDeliveryId($delivery->getId());

        $orderDelivery->setCostBrutto($response->getPaymentRequest_0_ShippingAmt()*$currency->getExchange());
        $orderDelivery->setOptTax($delivery->getTax()->getVat());

        /**
         * Confirm order
         **/
        if (stUser::isFullAccount($user)) {
            $order->setIsConfirmed(1);
        }

        /**
         * Save order
         **/
        $order->save();

        /**
         * Generate order number
         **/
        $dateFormat = new sfDateFormat();
        $orderConfig = stConfig::getInstance('stOrder');
        $format = $orderConfig->get('number_format');
        $date = $dateFormat->getDate($order->getCreatedAt(), 'd');
        $number = str_replace(array('{NUMER}', '{DZIEN}', '{MIESIAC}', '{ROK}'), array($order->getId(), $date['mday'], $date['mon'], $date['year']), $format);

        $order->setNumber($number);
        $order->save();

        /**
         * Payment
         **/
        $c = new Criteria();
        $c->add(PaymentTypePeer::MODULE_NAME, 'stPaypal');
        $paymentType = PaymentTypePeer::doSelectOne($c);

        $stPayment = new stPayment();
        $paymentId = $stPayment->add($user->getId(), $paymentType->getId(), stPayment::getUnpayedAmountByOrder($order));
        $stPayment->addPaymentForOrder($order->getId(), $paymentId);

        /**
         * Invoice
         **/
        stInvoiceListener::crateInvoiceProforma($order);

        return $order;
    }

    protected function getUserDataFromResponse(stPaypalCallerResponse $r, UserData $u) {

        $u->setFullName($r->getPaymentRequest_0_ShipToName());
        $u->setAddress($r->getPaymentRequest_0_ShipToStreet());
        $u->setCode($r->getPaymentRequest_0_ShipToZip());
        $u->setTown($r->getPaymentRequest_0_ShipToCity());
        $u->setRegion($r->getPaymentRequest_0_ShipToState());

        $c = new Criteria();
        $c->add(CountriesPeer::ISO_A2, $r->getPaymentRequest_0_ShipToCountryCode());
        $country = CountriesPeer::doSelectOne($c);
        $u->setCountriesId(is_null($country) ? '36' : $country->getId());

        return $u;
    }

    protected function mirrorUserData($target, $source) {

        $attributes = array('countries', 'full_name', 'address', 'region', 'code', 'town');

        foreach($attributes as $attribute) {
            $setter = 'set'.sfInflector::camelize($attribute);
            $getter = 'get'.sfInflector::camelize($attribute);

            $target->$setter($source->$getter());
        }
    }

    public static function validateProduct(Product $product, $quantity) {

        $context = sfContext::getInstance();
        $i18n = $context->getI18n();

        if ($product->getPriceBrutto() <= 0)
            return self::returnValidareProductError($i18n->__('Cena produktu musi być większa niż 0'));

        if (!is_numeric($quantity) || empty($quantity))
            return self::returnValidareProductError($i18n->__('Podana wartość musi być liczbą całkowitą...', null, 'stBasket'));
        
        $minAmount = stConfig::getInstance('stOrder')->get('min_amount', 0);

        if ($minAmount > 0 && $minAmount > $product->getPriceBrutto())
            return self::returnValidareProductError($i18n->__('Minimalna wartość zamówienia wynosi %min_amount%', array('%min_amount%' => st_price($min_amount, true, true)), 'stOrder'));

        $maxQuantity = $product->getStock();

        if ($product->getStock() == null || !$product->getIsStockValidated())
            $maxQuantity = stConfig::getInstance('stBasket')->get('max_quantity', 0);

        $productMaxQty = $product->getMaxQty();

        $max = $productMaxQty && $productMaxQty < $maxQuantity ? $productMaxQty : $maxQuantity;
        if ($max < $quantity)
            return self::returnValidareProductError($i18n->__('Brak wymaganej ilości towaru w magazynie', null, 'stBasket'));

        return true;
    }

    public static function returnValidareProductError($message) {
        sfContext::getInstance()->getUser()->setAttribute('express_checkout_error', $message, 'stPaypal');
        return false;
    }
}
