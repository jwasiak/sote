<?php

class stAllegroOrderBar
{

    /**
     * Language version
     *
     * @var sfI18N
     */
    protected $i18n;

    protected $msg = null;

    /**
     * Allegro config instance
     *
     * @var stConfig
     */
    protected $config = null;

    /**
     * Allegro API instance
     *
     * @var stAllegroApi
     */
    protected $api = null;

    /**
     * Default Tax instance
     *
     * @var Tax
     */
    protected $tax = null;

    /**
     * Default OrderStatus instance
     *
     * @var OrderStatus
     */
    protected $orderStatus = null;

    protected static $userGroup = null;

    protected $allegroPaymentType = null;

    /**
     * @var stEventDispatcher
     */
    protected $dispatcher;

    /**
     * stAllegroApi
     *
     * @var stAllegroApi
     */
    protected $stAllegro = null;

    public function __construct()
    {
        $this->i18n = sfContext::getInstance()->getI18n();
        $this->user = sfContext::getInstance()->getUser();
        $this->config = stConfig::getInstance('stAllegroBackend');
        $this->api = stAllegroApi::getInstance();
        $this->orderStatus = OrderStatusPeer::retrieveDefaultPendingStatus();
        $this->tax = TaxPeer::retrieveByTax(23);
        $this->dispatcher = stEventDispatcher::getInstance();
    }

    public function init()
    {
        $this->user->setAttribute('imported', array(), 'stAllegroPlugin');
    }

    public function close()
    {

        $con = Propel::getConnection();
        sfLoader::loadHelpers(array('Helper', 'stPartial', 'stAdminGenerator'));
        $this->msg = st_get_partial('stAllegroBackend/importedOrders', array('orders' => $this->getImported()));
        // $this->config->set('webapi_order_backward_compatibility_check', false);
        $this->config->save(true);
    }

    public function getTitle()
    {
        return $this->i18n->__('Import zamówień w toku', null, 'stAllegroBackend');
    }

    public function getMessage()
    {
        return $this->msg;
    }

    public function importOrder($from)
    {

        $response = $this->api->getOrderCheckoutForms($from);

        foreach ($response->checkoutForms as $form) {
            $order = $this->getOrder($form);

            if (null === $order) {
            
                $order = new Order();
                $order->setClientCulture('pl_PL');
                $order->setOptAllegroCheckoutFormId($form->id);
                $order->setOptAllegroNick($form->buyer->login);
                $user = $this->getOrCreateUser($form);
                $order->setOrderCurrency($this->getOrderCurrency());
                $order->setOrderStatus($this->orderStatus);
                $order->setsfGuardUser($user);
                $this->addProducts($order, $form->lineItems);
                $this->addOrderUserDataBilling($order, $form);
                $this->addOrderUserDataDelivery($order, $form);
                $this->addOrderDelivery($order, $form->delivery);
            }

            if ($form->messageToSeller) {
                $order->setDescription($this->replace4Bytes($form->messageToSeller));
            }

            $isNew = $order->isNew();

            if (!$isNew && !trim($order->getOrderUserDataDelivery()->getFullName()))
            {
                $address = $form->delivery->address;
                $order->getOrderUserDataDelivery()->setFullName($address->firstName . ' ' . $address->lastName);
                $order->getOrderUserDataDelivery()->save();
            }

            if ($order->isModified()) {
                $order->save();
            }

            if ($isNew) {
                $order->setNumber(OrderPeer::updateOrderNumber($order->getId(), $order->getCreatedAt()));
                $this->addOrderPayment($order, $form->payment);
                $this->addOrderInvoice($order, $form->invoice);
                $this->updateStock($order);
                $this->addImported($order, $form);
            }

            usleep(100000);
        }


        return $from + $response->count;
    }

    protected function replace4Bytes($string) 
    {
	    return preg_replace('%(?:
	          \xF0[\x90-\xBF][\x80-\xBF]{2}      # planes 1-3
	        | [\xF1-\xF3][\x80-\xBF]{3}          # planes 4-15
	        | \xF4[\x80-\x8F][\x80-\xBF]{2}      # plane 16
	    )%xs', '', $string);    
	}

    protected function addOrderDelivery(Order $order, $delivery)
    {
        $orderDelivery = new OrderDelivery();

        $orderDelivery->setName('Dostawa Allegro - ' . $delivery->method->name);
        $orderDelivery->setTax($this->tax);
        $orderDelivery->setCostBrutto($delivery->cost->amount);
        $orderDelivery->setOptAllegroDeliveryMethodId($delivery->method->id);
        $orderDelivery->setOptAllegroDeliverySmart($delivery->smart);


        if (isset($delivery->pickupPoint) && $delivery->pickupPoint && false !== strpos($delivery->method->name, 'Paczkomaty')) {
            $orderDelivery->setPaczkomatyNumber($delivery->pickupPoint->id);
        } elseif (isset($delivery->pickupPoint) && $delivery->pickupPoint && preg_match('/Paczka24|Ruchu|Poczta/i', $delivery->method->name)) {
            $orderDelivery->setPickupPoint($delivery->pickupPoint->id);
        }

        $order->setOrderDelivery($orderDelivery);
    }

    protected function updateStock(Order $order)
    {
        $config = stConfig::getInstance('stProduct');

        if ($config->get('depository_enabled') && $config->get('get_depository') == 'order')
        {
            $c = new Criteria();

            $items = $order->getOrderProducts($c);

            stDepositoryPluginListener::decreaseAll($items);
        }
    }

    protected function addOrderInvoice(Order $order, $invoice)
    {
        if ($invoice->required && $invoice->address) {

            $userData = $order->getOrderUserDataBilling();

            if (isset($invoice->address->naturalPerson) && $invoice->address->naturalPerson) {
                $userData->setFullName($invoice->address->naturalPerson->firstName . ' ' . $invoice->address->naturalPerson->lastName);
            } else {
                $userData->setFullName('');
            }

            $userData->setAddress($invoice->address->street);
            $userData->setTown($invoice->address->city);
            $country = CountriesPeer::retrieveByIsoA2($invoice->address->countryCode);
            $userData->setCountries($country);

            if (isset($invoice->address->company) && $invoice->address->company) {
                if ($invoice->address->company->name)
                {
                    $userData->setCompany($invoice->address->company->name);
                }

                if ($invoice->address->company->taxId)
                {
                    $userData->setVatNumber($invoice->address->company->taxId);
                }
            }

            $userData->setCode($invoice->address->zipCode);

            $userData->save();
        }

        $invoiceId = stInvoiceListener::crateInvoiceProforma($order);

        if ($invoice->required) {
            stInvoiceListener::crateInvoiceRequest($order, $invoiceId);
        }
    }

    protected function addOrderPayment(Order $order, $payment)
    {
        $c = new Criteria();
        $c->add(PaymentTypePeer::MODULE_NAME, 'stAllegro');
        $c->add(PaymentTypePeer::HIDE_MODULE, 1);
        $paymentType = PaymentTypePeer::doSelectOne($c);

        if (null === $paymentType) {
            $paymentType = new PaymentType();
            $paymentType->setHideModule(true);
            $paymentType->setModuleName('stAllegro');
            $paymentType->setActive(false);
            $paymentType->setCulture('pl_PL');
            $paymentType->setName("Płatność w serwisie Allegro");
            $paymentType->save();
        }

        $paymentInstance = stPayment::newPaymentInstance($paymentType->getId(), $order->getOptTotalAmount(), array(
            'user_id' => $order->getsfGuardUser()->getId(),
        ));

        if ($payment->type == "ONLINE") {
            $paymentInstance->setAllegroPaymentType(strtolower($payment->provider));
        } else {
            $paymentInstance->setAllegroPaymentType(strtolower($payment->type));
        }

        $paymentInstance->setTransactionId($payment->id);

        $ohp = new OrderHasPayment();
        $ohp->setOrder($order);
        $ohp->setPayment($paymentInstance);
        $ohp->save();

        $order->setOrderPayment($paymentInstance);

        if (null !== $payment->paidAmount && $payment->type == "ONLINE") {
            $paymentInstance->setStatus(true);
            $paymentInstance->setPayedAt(strtotime($payment->finishedAt));
        }

        $paymentInstance->save();
    }

    protected function addOrderUserDataBilling(Order $order, $form)
    {
        $userData = new OrderUserDataBilling();

        if ($form->buyer->guest) {
            $address = $form->delivery->address;
            $userData->setFullName($address->firstName . ' ' . $address->lastName);
            $userData->setAddress($address->street);
            $userData->setTown($address->city);
            $country = CountriesPeer::retrieveByIsoA2($address->countryCode);
            $userData->setCountries($country);
            $userData->setCompany($address->companyName);
            $userData->setPhone($address->phoneNumber);
            $userData->setCode($address->zipCode);
        } else {
            $userData->setFullName($form->buyer->firstName . ' ' . $form->buyer->lastName);
            $userData->setAddress($form->buyer->address->street);
            $userData->setTown($form->buyer->address->city);
            $country = CountriesPeer::retrieveByIsoA2($form->buyer->address->countryCode);
            $userData->setCountries($country);
            $userData->setCompany($form->buyer->companyName);
            $userData->setPhone($form->buyer->phoneNumber);
            $userData->setCode($form->buyer->address->postCode);
        }

        $this->dispatcher->notify(new sfEvent($this, 'stAllegroOrderBar.addOrderUserDataBilling', array('order_user_data_billing' => $userData, 'order' => $order, 'allegro_form' => $form)));

        $order->setOrderUserDataBilling($userData);
    }

    protected function addOrderUserDataDelivery(Order $order, $form)
    {           
        $userData = new OrderUserDataDelivery();

        $address = $form->delivery->address;

        if (isset($form->delivery->pickupPoint) && $form->delivery->pickupPoint)
        {
            $pickupPoint = $form->delivery->pickupPoint;           

            $userData->setFullName($address->firstName . ' ' . $address->lastName);
            $userData->setAddress($pickupPoint->address->street);
            $userData->setTown($pickupPoint->address->city);
            $country = CountriesPeer::retrieveByIsoA2('PL');
            $userData->setCountries($country);
            $userData->setCompany($pickupPoint->name);
            $userData->setPhone($form->delivery->address->phoneNumber);
            $userData->setCode($pickupPoint->address->zipCode);            
        }
        else
        {
            $userData->setFullName($address->firstName . ' ' . $address->lastName);
            $userData->setAddress($address->street);
            $userData->setTown($address->city);
            $country = CountriesPeer::retrieveByIsoA2($address->countryCode);
            $userData->setCountries($country);
            $userData->setCompany($address->companyName);
            $userData->setPhone($address->phoneNumber);
            $userData->setCode($address->zipCode);
        }

        $this->dispatcher->notify(new sfEvent($this, 'stAllegroOrderBar.addOrderUserDataDelivery', array('order_user_data_delivery' => $userData, 'order' => $order, 'allegro_form' => $form)));

        $order->setOrderUserDataDelivery($userData);
    }

    protected function addProducts(Order $order, $items)
    {
        $offerIds = array();

        $createdAt = 0;

        foreach ($items as $item) {
            $offerIds[] = $item->offer->id;
        }

        $offers = AllegroAuctionPeer::doSelectByAuctionIds($offerIds);

        foreach ($items as $item) {
            $offer = isset($offers[$item->offer->id]) ? $offers[$item->offer->id] : null;

            $product = null;

            if ($offer) {
                $product = $offer->getProduct();
            }

            $orderProduct = new OrderProduct();

            $orderProduct->setVersion(2);

            if ($product) {
                $orderProduct->setProduct($product);
            }

            $orderProduct->setQuantity($item->quantity);

            $orderProduct->setCode($product ? $product->getCode() : $item->offer->id);

            $orderProduct->setName($this->config->get('import_product_name', 'offer') == 'offer' || !$product ? $item->offer->name : $product->getName());

            $orderProduct->setPriceNetto(null);

            $orderProduct->setAllegroAuctionId($item->offer->id);

            $orderProduct->setPriceBrutto($item->price->amount);

            if ($product) {
                $orderProduct->setImage($product->getOptImage());
            }

            if ($product) {
                $offer->getProductOptionsArray();

                $priceModifiers = $product->getPriceModifiers();

                /**
                 * @see BasketProduct::setPriceModifiers()
                 **/
                foreach ($priceModifiers as $index => $value) {
                    if (isset($value['custom']['label'])) {
                        $label = $value['custom']['label'];

                        unset($value['custom']['label']);

                        $value['label'] = $label;

                        $priceModifiers[$index] = $value;
                    }
                }

                $orderProduct->setPriceModifiers($priceModifiers);
            }

            $orderProduct->setTax($product ? $product->getTax() : $this->tax);

            $this->dispatcher->notify(new sfEvent($this, 'stAllegroOrderBar.addProducts', array('order_product' => $orderProduct, 'order' => $order, 'auction' => $offer, 'allegro_item' => $item)));

            $order->addOrderProduct($orderProduct);

            $time = strtotime($item->boughtAt);

            if ($createdAt < $time) {
                $createdAt = $time;
            }
        }

        $order->setCreatedAt($time);
    }

    public function getImported()
    {
        return $this->user->getAttribute('imported', array(), 'stAllegroPlugin');
    }

    public function clearImported()
    {
        $this->user->setAttribute('imported', array(), 'stAllegroPlugin');
    }

    public function addImported(Order $order, $form)
    {
        $imported = $this->getImported();

        $offers = array();

        foreach ($form->lineItems as $item) {
            $offers[] = $item->offer->id;
        }

        $imported[] = array(
            'id' => $order->getId(),
            'number' => $order->getNumber(),
            'created_at' => $order->getCreatedAt(),
            'offers' => $offers,
            'total_amount' => $order->getOptTotalAmount(),
            'currency' => $order->getOrderCurrency()->getShortcut(),
        );

        $this->user->setAttribute('imported', $imported, 'stAllegroPlugin');
    }

    /**
     * Pobiera zamówienia na podstawie formularza pozakupowego Allegro
     *
     * @param stdClass $form
     * @return Order
     */
    protected function getOrder($form)
    {
        $c = new Criteria();
        $c->add(OrderPeer::OPT_ALLEGRO_CHECKOUT_FORM_ID, $form->id);
        return OrderPeer::doSelectOne($c);
    }

    public static function getOrCreateUser($form)
    {
        $c = new Criteria();
        $c->add(sfGuardUserPeer::USERNAME, $form->buyer->email);
        $user = sfGuardUserPeer::doSelectOne($c);

        if (null === $user) {
            $user = new sfGuardUser();
            $user->setUsername($form->buyer->email);
            $user->setPassword(md5('anonymous' . rand() . rand()));
            $group = self::getUserGroup();
            $userGroup = new sfGuardUserGroup();
            $userGroup->setsfGuardGroup($group);
            $user->addsfGuardUserGroup($userGroup);
        }

        if (null === $user->getOptAllegroUserId()) {
            $user->setOptAllegroUserId($form->buyer->id);
        }

        return $user;
    }

    public function getOrderCurrency()
    {
        $orderCurrency = new OrderCurrency();
        $orderCurrency->setName('Polski złoty');
        $orderCurrency->setShortcut('PLN');
        $orderCurrency->setExchange(1);
        $orderCurrency->setFrontSymbol(null);
        $orderCurrency->setBackSymbol('zł');
        $orderCurrency->save();
        return $orderCurrency;
    }

    protected static function getUserGroup()
    {
        if (null === self::$userGroup) {
            $c = new Criteria();
            $c->add(sfGuardGroupPeer::NAME, 'user');
            self::$userGroup = sfGuardGroupPeer::doSelectOne($c);
        }

        return self::$userGroup;
    }

    protected function getAllegroPaymentType()
    {
        if (null === $this->allegroPaymentType) {
            $c = new Criteria();
            $c->add(PaymentTypePeer::MODULE_NAME, 'stAllegro');
            $c->add(PaymentTypePeer::HIDE_MODULE, 1);
            $paymentType = PaymentTypePeer::doSelectOne($c);

            if (null === $paymentType) {
                $paymentType = new PaymentType();
                $paymentType->setHideModule(true);
                $paymentType->setModuleName('stAllegro');
                $paymentType->setActive(false);
                $paymentType->setCulture('pl_PL');
                $paymentType->setName("Płatność w serwisie Allegro");
                $paymentType->save();
            }

            $this->allegroPaymentType = $paymentType;
        }

        return $this->allegroPaymentType;
    }
}
