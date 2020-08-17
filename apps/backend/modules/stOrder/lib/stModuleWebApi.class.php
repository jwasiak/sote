<?php
/**
 * SOTESHOP/stWebApiPlugin
 *
 * Ten plik należy do aplikacji stWebApiPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE.
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania.
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stWebApiPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: stModuleWebApi.class.php 16567 2011-12-21 13:38:08Z piotr $
 * @author      Michal Prochowski <michal.prochowski@sote.pl>
 */

/**
 * Klasa stOrderWebApi
 *
 * @package     stWebApiPlugin
 * @subpackage  libs
 */
class StOrderWebApi extends autoStOrderWebApi
{
    public static function getOrderUserDataDeliveryCountry($item) {
        return $item->getOrderUserDataDelivery()->getCountry();
    }

    public static function getHasAllegroSmartDelivery(Order $order)
    {
        return $order->getOrderDelivery() ? $order->getOrderDelivery()->getOptAllegroDeliverySmart() : false;
    }

    public static function getOrderUserDataDeliveryName($item) {
        return $item->getOrderUserDataDelivery()->getName();
    }

    public static function getOrderUserDataDeliverySurname($item) {
        return $item->getOrderUserDataDelivery()->getSurname();
    }

    public static function getOrderUserDataDeliveryStreet($item) {
        return $item->getOrderUserDataDelivery()->getStreet();
    }

    public static function getOrderUserDataDeliveryHouse($item) {
        return $item->getOrderUserDataDelivery()->getHouse();
    }

    public static function getOrderUserDataDeliveryFlat($item) {
        return $item->getOrderUserDataDelivery()->getFlat();
    }

    public static function getOrderUserDataDeliveryCode($item) {
        return $item->getOrderUserDataDelivery()->getCode();
    }

    public static function getOrderUserDataDeliveryTown($item) {
        return $item->getOrderUserDataDelivery()->getTown();
    }

    public static function getOrderUserDataDeliveryPhone($item) {
        return $item->getOrderUserDataDelivery()->getPhone();
    }

    public static function getOrderUserDataDeliveryCompany($item) {
        return $item->getOrderUserDataDelivery()->getCompany();
    }

    public static function getOrderUserDataDeliveryVatNumber($item) {
        return $item->getOrderUserDataDelivery()->getVatNumber();
    }

    public static function getOrderUserDataBillingCountry($item) {
        return $item->getOrderUserDataBilling()->getCountry();
    }

    public static function getOrderUserDataBillingName($item) {
        return $item->getOrderUserDataBilling()->getName();
    }

    public static function getOrderUserDataBillingSurname($item) {
        return $item->getOrderUserDataBilling()->getSurname();
    }

    public static function getOrderUserDataBillingStreet($item) {
        return $item->getOrderUserDataBilling()->getStreet();
    }

    public static function getOrderUserDataBillingHouse($item) {
        return $item->getOrderUserDataBilling()->getHouse();
    }

    public static function getOrderUserDataBillingFlat($item) {
        return $item->getOrderUserDataBilling()->getFlat();
    }

    public static function getOrderUserDataBillingCode($item) {
        return $item->getOrderUserDataBilling()->getCode();
    }

    public static function getOrderUserDataBillingTown($item) {
        return $item->getOrderUserDataBilling()->getTown();
    }

    public static function getOrderUserDataBillingPhone($item) {
        return $item->getOrderUserDataBilling()->getPhone();
    }

    public static function getOrderUserDataBillingCompany($item) {
        return $item->getOrderUserDataBilling()->getCompany();
    }

    public static function getOrderUserDataBillingVatNumber($item) {
        return $item->getOrderUserDataBilling()->getVatNumber();
    }

    public static function getOrderDeliveryName($item) {
        return $item->getOrderDelivery()->getName();
    }

    public static function getOrderDeliveryCost($item) {
        return $item->getOrderDelivery()->getCost(true, true);
    }

    public static function getOrderDeliveryTax($item) {
        return $item->getOrderDelivery()->getOptTax();
    }

    public static function getOrderDeliveryNumber($item) {
        return $item->getOrderDelivery()->getNumber();
    }

    public static function getOrderDeliveryInpost($item) {
        return $item->getOrderDelivery()->getPaczkomatyNumber();
    }

    public static function getOrderCurrencyName($item) {
        return $item->getOrderCurrency()->getName();
    }

    public static function getOrderCurrencyExchange($item) {
        return $item->getOrderCurrency()->getExchange();
    }

    public static function getOrderCurrencyShortcut($item) {
        return $item->getOrderCurrency()->getShortcut();
    }

    public static function setOrderDeliveryNumber($item, $value) {
        return $item->getOrderDelivery()->setNumber($value);
    }

    public static function getOrderUserDataBillingAddress($item) {
        return $item->getOrderUserDataBilling()->getAddress();
    }

    public static function getOrderUserDataBillingAddressMore($item) {
        return $item->getOrderUserDataBilling()->getAddressMore();
    }

    public static function getOrderUserDataBillingFullName($item) {
        return $item->getOrderUserDataBilling()->getFullName();
    }

    public static function getOrderUserDataDeliveryAddress($item) {
        return $item->getOrderUserDataDelivery()->getAddress();
    }

    public static function getOrderUserDataDeliveryAddressMore($item) {
        return $item->getOrderUserDataDelivery()->getAddressMore();
    }

    public static function getOrderUserDataDeliveryFullName($item) {
        return $item->getOrderUserDataDelivery()->getFullName();
    }

    public static function getOptions($item) {
        return $item->getPriceModifierLabels();
    }

    public static function getOrderAllegroDeliveryMethodId(Order $order)
    {
        return $order->getOrderDelivery()->getOptAllegroDeliveryMethodId();
    }

    public static function getOrderAllegroCheckoutFormId(Order $order)
    {
        return $order->getOptAllegroCheckoutFormId();
    }

    public static function getClientEmail(Order $order)
    {
        return $order->getOptClientEmail();
    }

    public static function getAllegroOfferId(OrderProduct $orderProduct)
    {
        return $orderProduct->getAllegroAuctionId();
    }

    public static function getOrderDeliveryType(Order $order)
    {
        $delivery = $order->getOrderDelivery()->getDelivery();
        
        return $delivery && $delivery->getDeliveryType() ? $delivery->getDeliveryType()->getType() : null;
    }

    public static function getOrderDeliveryPickupPoint(Order $order)
    {
        return $order->getOrderDelivery()->getPickupPoint();
    }

    public function getFieldsForGetOrderProductList( $object, $item ) {
        parent::getFieldsForGetOrderProductList($object, $item);
        $object->discount_amount = stWebApi::formatData($item->getDiscountValue(), "double");
        $object->discount_type = stWebApi::formatData($item->getDiscountType(), "string"); 
    }

    /**
     * Pobieranie danych
     *
     * @param   object      $object             obiekt z parametrami
     * @return  object      okiekt z danymi
     * @throws WEBAPI_INCORRECT_ID WEBAPI_REQUIRE_ERROR
     */
    public function GetOrderProductList( $object )
    {
        if (isset($object->_culture)) { $this->__setCulture($object->_culture);}
        stWebApi::getLogin($object->_session_hash, 'webapi_read');
        $this->TestAndValidateGetOrderProductListFields( $object );
        $c = new Criteria( );

        if (isset($object->_modified_from) && isset($object->_modified_to)) {
            $criterion = $c->getNewCriterion(OrderProductPeer::UPDATED_AT, $object->_modified_from, Criteria::GREATER_EQUAL);
            $criterion->addAnd($c->getNewCriterion(OrderProductPeer::UPDATED_AT, $object->_modified_to, Criteria::LESS_EQUAL));
            $c->add($criterion);
        } else {
            if (isset($object->_modified_from)) {
                $criterion = $c->getNewCriterion(OrderProductPeer::UPDATED_AT, $object->_modified_from, Criteria::GREATER_EQUAL);
                $c->add($criterion);
            }

            if (isset($object->_modified_to)) {
                $criterion = $c->getNewCriterion(OrderProductPeer::UPDATED_AT, $object->_modified_to, Criteria::LESS_EQUAL);
                $c->add($criterion);
            }
        }

        if (!isset($object->_limit)) $object->_limit = 20;

        // ustawiamy kryteria wyboru
        $c->setLimit( $object->_limit );
        $c->setOffset( $object->_offset );
        $c->add(OrderProductPeer::ORDER_ID, $object->order_id);

        $items = OrderProductPeer::doSelect( $c );

        $without_discount = isset($object->without_discount) && $object->without_discount;

        if ( $items )
        {
            // Zwracanie wyniku, dla wszystkich pol z tablicy 'out'
            $items_array = array();
            $order = OrderPeer::retrieveByPK($object->order_id);
            $prev = self::initOrder($order);
            foreach ( $items as $item )
            {
                $order_product = new StdClass( );
                $this->getFieldsForGetOrderProductList( $order_product, $item );

                if ($without_discount)
                {
                    $order_product->price = stWebApi::formatData($item->getPriceNetto(true, false), "double");
                    $order_product->price_brutto = stWebApi::formatData($item->getPriceBrutto(true, false), "double");
                }

                if ($item->getIsSet() && $item->getVersion() < 3)
                {
                    $c = new Criteria();
                    $c->addJoin(ProductPeer::ID, OrderProductHasSetPeer::PRODUCT_ID);
                    $c->add(OrderProductHasSetPeer::ORDER_PRODUCT_ID, $item->getId());
                   
                    $product = $item->getProduct();

                    $product->setCulture($order->getClientCulture());

                    $total = $order_product->price_brutto;

                    $products = ProductPeer::doSelectWithI18n($c);

                    $cnt = count($products) + 1;

                    $price_brutto = stPrice::round($total / $cnt);

                    $price_netto = stPrice::extract($price_brutto, $order_product->vat);

                    $left = stPrice::round($total - $price_brutto * $cnt);

                    $set = array(
                        self::createSet($product->getId(), $product->getCode(), $product->getName(), stPrice::extract($price_brutto + $left, $order_product->vat), $price_brutto + $left)
                    );

                    foreach ($products as $index => $product)
                    {
                        $set[] = self::createSet($product->getId(), $product->getCode(), $product->getName(), $price_netto, $price_brutto);
                    }                    

                    $order_product->set = $set;
                }
                elseif ($item->getIsSet())
                {
                    $set = array();

                    $c = new Criteria();
                    $c->add(OrderProductHasSetPeer::ORDER_PRODUCT_ID, $item->getId()); 

                    $ophs = OrderProductHasSetPeer::doSelect($c);

                    foreach ($ophs as $current)
                    {
                        $set[] = self::createSet($current->getProductId(), $current->getCode(), $current->getName(), $current->getPriceNetto(), $current->getPriceBrutto());
                    } 

                    $order_product->set = $set;                  
                }
                else
                {
                    $order_product->set = array();
                }

                $items_array[] = $order_product;
            }
            self::restoreDefaults($prev);
            return $items_array;
        } else {
            return array( );
        }
    }

    public function GetOrderPayment( $object )
    {
        if (isset($object->_culture)) { $this->__setCulture($object->_culture);}
        stWebApi::getLogin($object->_session_hash, 'webapi_read');
        $this->TestAndValidateGetOrderPaymentFields( $object );

        $c = new Criteria();
        $c->add(OrderHasPaymentPeer::ORDER_ID,$object->order_id);
        $c->addJoin(OrderHasPaymentPeer::PAYMENT_ID, PaymentPeer::ID);

        $items = PaymentPeer::doSelect( $c );
        if ( $items )
        {
            $items_array = array();
            foreach ( $items as $item )
            {
                $object = new StdClass( );
                $this->getFieldsForGetOrderPayment( $object, $item );
                $items_array[] = $object;
            }
            return $items_array;
        } else {
            throw new SoapFault( "1", $this->__(WEBAPI_INCORRECT_ID) );
        }
    }

    public static function getPaymentOptName($item) {
        if (is_object($item->getPaymentType())) {
            $name = $item->getPaymentType()->getOptName();

            if ($item->getAllegroPaymentType()) {
                sfLoader::loadHelpers(array('Helper', 'stAllegro'));
                $name .= " - ".st_allegro_payment_type($item->getAllegroPaymentType());
            }

            return $name;
        } 
        else if (is_object($item->getGiftCard())) {
            return "Kod: ".$item->getGiftCard()->getCode();
        }
        
        return null;
    }

    /**
     * Aktualizacja danych
     *
     * @param   object      $object             obiekt z parametrami
     * @return  object      obiekt z true
     * @throws WEBAPI_INCORRECT_ID WEBAPI_UPDATE_ERROR WEBAPI_REQUIRE_ERROR
     * @todo dodać walidacje danych
     */
    public function SetOrderPaymentStatus( $object )
    {
        if (isset($object->_culture)) { $this->__setCulture($object->_culture);}
        stWebApi::getLogin($object->_session_hash, 'webapi_write');
        $this->TestAndValidateSetOrderPaymentStatusFields( $object );

        $c = new Criteria();
        $c->add(OrderHasPaymentPeer::ORDER_ID,$object->order_id);
        $c->addJoin(OrderHasPaymentPeer::PAYMENT_ID, PaymentPeer::ID);

        $item = PaymentPeer::doSelectOne( $c );
        if ( $item )
        {
            $this->setFieldsForSetOrderPaymentStatus( $object, $item );
            //Zapisywanie danych do bazy
            try {
                $item->save( );
            } catch ( Exception $e ) {
                throw new SoapFault( "2", sprintf($this->__(WEBAPI_UPDATE_ERROR),$e->getMessage()) );
            }

            // Zwracanie danych
            $object = new StdClass( );
            $object->_update = true;
            return $object;

        } else {
            throw new SoapFault( "1", $this->__(WEBAPI_INCORRECT_ID) );
        }
    }

    /** 
     * Pobieranie danych
     *
     * @param   object      $object             obiekt z parametrami
     * @return  object      okiekt z danymi
     * @throws WEBAPI_INCORRECT_ID WEBAPI_REQUIRE_ERROR
     */
    public function GetOrderByNumber( $object )
    {
		if (isset($object->_culture)) { $this->__setCulture($object->_culture);}
        stWebApi::getLogin($object->_session_hash, 'webapi_read');
        $this->TestAndValidateGetOrderByNumberFields( $object );

        $item = OrderPeer::retrieveByNumber( $object->number );
        
        if ( $item )
        {
            $object = new StdClass( );
            $this->getFieldsForGetOrderByNumber( $object, $item );        
            return $object;
        } else {
            throw new SoapFault( "1", $this->__(WEBAPI_INCORRECT_ID) );
        }
    }

    /**
     * Pobieranie danych
     *
     * @param   object      $object             obiekt z parametrami
     * @return  object      okiekt z danymi
     * @throws WEBAPI_INCORRECT_ID WEBAPI_REQUIRE_ERROR
     */
    public function GetOrderListByUser( $object )
    {
        if (isset($object->_culture)) { $this->__setCulture($object->_culture);}
        stWebApi::getLogin($object->_session_hash, 'webapi_read');
        $this->TestAndValidateGetOrderListFields( $object );

        if (!isset($object->user_id) && !isset($object->user_name)) return array();

        $userId = null;
        if (isset($object->user_id)) $userId = $object->user_id;

        if ($userId == null && isset($object->user_name))
        {
            $userC = new Criteria();
            $userC->add(sfGuardUserPeer::USERNAME, $object->user_name);
            $user = sfGuardUserPeer::doSelectOne($userC);
             
            if(!is_object($user)) return array();
            $userId = $user->getId();
        }

        if ($userId == null) return array();

        $c = new Criteria( );

        $c->add(OrderPeer::SF_GUARD_USER_ID, $userId);

        if (isset($object->_modified_from) && isset($object->_modified_to)) {
            $criterion = $c->getNewCriterion(OrderPeer::UPDATED_AT, $object->_modified_from, Criteria::GREATER_EQUAL);
            $criterion->addAnd($c->getNewCriterion(OrderPeer::UPDATED_AT, $object->_modified_to, Criteria::LESS_EQUAL));
            $c->add($criterion);
        } else {
            if (isset($object->_modified_from)) {
                $criterion = $c->getNewCriterion(OrderPeer::UPDATED_AT, $object->_modified_from, Criteria::GREATER_EQUAL);
                $c->add($criterion);
            }

            if (isset($object->_modified_to)) {
                $criterion = $c->getNewCriterion(OrderPeer::UPDATED_AT, $object->_modified_to, Criteria::LESS_EQUAL);
                $c->add($criterion);
            }
        }

        if (!isset($object->_limit)) $object->_limit = 20;

        // ustawiamy kryteria wyboru
        $c->setLimit( $object->_limit );
        $c->setOffset( $object->_offset );

        $items = OrderPeer::doSelect( $c );

        if ( $items )
        {
            // Zwracanie wyniku, dla wszystkich pol z tablicy 'out'
            $items_array = array();
            foreach ( $items as $item )
            {
                $object = new StdClass( );
                $this->getFieldsForGetOrderList( $object, $item );
                $items_array[] = $object;
            }
            return $items_array;
        } else {
            return array( );
        }
    }

    public function GetOrderProductCount( $object )
    {
        if (isset($object->_culture)) { $this->__setCulture($object->_culture);}
        stWebApi::getLogin($object->_session_hash, 'webapi_read');

        try{
            $c = new Criteria( );
            $c->add(OrderProductPeer::ORDER_ID, $object->order_id);

            if (isset($object->_modified_from) && isset($object->_modified_to)) {
                $criterion = $c->getNewCriterion(OrderProductPeer::UPDATED_AT, $object->_modified_from, Criteria::GREATER_EQUAL);
                $criterion->addAnd($c->getNewCriterion(OrderProductPeer::UPDATED_AT, $object->_modified_to, Criteria::LESS_EQUAL));
                $c->add($criterion);
            } else {
                if (isset($object->_modified_from)) {
                    $criterion = $c->getNewCriterion(OrderProductPeer::UPDATED_AT, $object->_modified_from, Criteria::GREATER_EQUAL);
                    $c->add($criterion);
                }

                if (isset($object->_modified_to)) {
                    $criterion = $c->getNewCriterion(OrderProductPeer::UPDATED_AT, $object->_modified_to, Criteria::LESS_EQUAL);
                    $c->add($criterion);
                }
            }

            //Zwracanie danych
            $obj = new StdClass( );
            $obj->_count = OrderProductPeer::doCount($c);
            return $obj;
        } catch ( Exception $e ) {
            throw new SoapFault( "1", sprintf($this->__(WEBAPI_COUNT_ERROR),$e->getMessage()) );
        }
    }

    public function UpdateOrderStatus($object) {
        $order = OrderPeer::retrieveByPK($object->id);
        $sendMail = false;
        if (is_object($order)) {
            if ($order->getOrderStatusId() != $object->order_status_id) {
                $newStatus = OrderStatusPeer::retrieveByPK($object->order_status_id);
                if (is_object($newStatus) && $newStatus->getHasMailNotification()) $sendMail = true;
            }
        }

        $return = parent::UpdateOrderStatus($object);

        if ($sendMail) {
            $order = OrderPeer::retrieveByPK($object->id);
            $orderActions = new stOrderActions();
            $sf_user = sfContext::getInstance()->getUser();
            $sf_user->setCulture($order->getClientCulture());
            $orderActions->sendOrderStatus($order);
            $sf_user->setCulture($this->__getCulture());
        }
        
        $obj = new StdClass();
        $obj->order = $order;
        stEventDispatcher::getInstance()->notify(new sfEvent($obj, 'stOrderApiActions.postUpdateStatus', array()));
        
        return $return;
    }

    public static function initOrder(Order $order)
    {
        $context = sfContext::getInstance();
        $currency = stCurrency::getInstance($context);
        $prev_culture = $context->getUser()->getCulture();
        $context->getUser()->setCulture($order->getClientCulture());

        $prev_currency_id = $currency->get()->getId();

        $order_currency = CurrencyPeer::retrieveByIso($order->getOrderCurrency()->getShortcut());

        if ($order_currency) {
            $currency->set($order_currency->getId());
            $dispatcher = $context->getController()->getDispatcher();
            $dispatcher->connect('Product.postHydrate', array('appAddPricePluginListener', 'productPostHydrate'));
            $dispatcher->connect('ProductOptionsValue.postHydrate', array('appAddPricePluginListener', 'productOptionsValuePostHydrate'));
            $dispatcher->connect('ProductPeer.postAddSelectColumns', array('appAddPricePluginListener', 'productPostAddSelectColumns'));
            $dispatcher->connect('BasePeer.preDoSelectRs', array('appAddPricePluginListener', 'preDoSelectRs'));         
        }  

        Product::enableFrontendFunctions(); 

        return array('currency' => $prev_currency_id, );    
    }

    public static function restoreDefaults($prev)
    {
        $currency = stCurrency::getInstance(sfContext::getInstance());
        $currency->set($prev['currency']);

        Product::enableFrontendFunctions(false);
    }

    public static function createSet($id, $code, $name, $price_netto = null, $price_brutto = null)
    {
        return array(
            'id' => stWebApi::formatData($id, 'integer'),
            'code' => stWebApi::formatData($code, 'string'),
            'name' => stWebApi::formatData($name, 'string'),
            'price' => stWebApi::formatData($price_netto, 'double'),
            'price_brutto' => stWebApi::formatData($price_brutto, 'double'),
        );
    }

    public static function getOrderDiscountValue(Order $order)
    {
        $discount = $order->getOrderDiscount();

        return $discount ? $discount['value'] : 0;
    }

    public static function getOrderDiscountType(Order $order)
    {
        $discount = $order->getOrderDiscount();

        return $discount ? $discount['type'] : 0;
    }

    public static function getTotalAmount(Order $order)
    {
        return $order->getOptTotalAmount();
    }

    public static function getOrderAllegroAuctionId(Order $order)
    {
        return null !== $order->getOptAllegroCheckoutFormId() || null !== $order->getOptAllegroNick();
    }
}
