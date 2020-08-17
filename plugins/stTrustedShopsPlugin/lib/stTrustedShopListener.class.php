<?php
class stTrustedShopsListener
{
    public static function append(sfEvent $event, $components) {

        $certificate = TrustedShopsPeer::retrieveByCulture(sfContext::getInstance()->getUser()->getCulture());

        if (in_array($event['slot'], array('before_head_ends', 'before-head-ends')) && is_object($certificate))
            if ($certificate->getTrustBadgeCode() !== null)
                $components[] = $event->getSubject()->createComponent('stTrustedShopsFrontend', 'showTrustbadge');
                
        return $components;
    }
    
    public static function saveTrustedShops(sfEvent $event)
    {
        $subject = $event->getSubject();

        if ($subject->getType() == 'Excellence' && $subject->isActive())
        {
            $c = new Criteria();
            $c->add(TrustedShopsProtectionProductsPeer::TRUSTED_SHOPS_ID, $subject->getId());
            TrustedShopsProtectionProductsPeer::doDelete($c);

            $connector = new stTrustedShopsConnector();
            $results = $connector->getProtectionItems($subject->getCertificate());

            if (is_array($results->item)) {
                foreach($results->item as $result) {
                    self::addProtectionProduct($subject->getId(), $result);
                }
            } elseif(is_object($results->item)) {
                self::addProtectionProduct($subject->getId(), $results->item);
            }
        }
    }

    protected static function addProtectionProduct($id, $pp) {
        $tspp = new TrustedShopsProtectionProducts();
        $tspp->setTrustedShopsId($id);
        $tspp->setCurrency($pp->currency);
        $tspp->setGross($pp->grossFee);
        $tspp->setNetto($pp->netFee);
        $tspp->setAmount($pp->protectedAmountDecimal);
        $tspp->setDuration($pp->protectionDurationInt);
        $tspp->setProductId($pp->tsProductID);
        $tspp->save();
    }

    public static function preBasketSummary(sfEvent $event)
    {
        if ($event->getSubject()->getUser()->getAttribute('ts_buyer_protection', false, 'soteshop/stTrustedShopsPlugin'))
        {
            $event->getSubject()->basket->get();
            $event->getSubject()->basket->getItems();

            $tsProduct = new BasketProduct();

            $tsppId = $event->getSubject()->getUser()->getAttribute('ts_buyer_protection_id', false, 'soteshop/stTrustedShopsPlugin');

            $tspp = TrustedShopsProtectionProductsPeer::retrieveByPK($tsppId);

            if (is_object($tspp)) 
            {
                $tsProduct->setName(sfContext::getInstance()->getI18n()->__('Ochrona Kupującego Trusted Shops', null, 'stTrustedShopsFrontend'));
                $currency = stCurrency::getInstance($event->getSubject())->get();
                $tsProduct->setBasePriceBrutto(stCurrency::calculateCurrencyPrice($tspp->getGross(), $currency->getExchange(), true));
                $tsProduct->setVat(round((($tspp->getGross()/$tspp->getNetto())-1)*100));
                $tsProduct->setQuantity(1);
                $event->getSubject()->basket->get()->addBasketProduct($tsProduct);
            }
        }
    }

    public static function preBasketIndex(sfEvent $event) {
        $event->getSubject()->getUser()->setAttribute('ts_buyer_protection', false, 'soteshop/stTrustedShopsPlugin');
    }

    public static function preOrderConfirm(sfEvent $event)
    {
        if ($event->getSubject()->getUser()->getAttribute('ts_buyer_protection', false, 'soteshop/stTrustedShopsPlugin'))
        {
            $tsProduct = new BasketProduct();

            $tsppId = $event->getSubject()->getUser()->getAttribute('ts_buyer_protection_id', false, 'soteshop/stTrustedShopsPlugin');

            $tspp = TrustedShopsProtectionProductsPeer::retrieveByPK($tsppId);

            if (is_object($tspp))
            {
                $tsProduct->setName(sfContext::getInstance()->getI18n()->__('Ochrona Kupującego Trusted Shops', null, 'stTrustedShopsFrontend'));
                $currency = stCurrency::getInstance($event->getSubject())->get();
                $tsProduct->setBasePriceBrutto(stCurrency::calculateCurrencyPrice($tspp->getGross(), $currency->getExchange(), true));
                $tsProduct->setVat(round((($tspp->getGross()/$tspp->getNetto())-1)*100));
                $tsProduct->setQuantity(1);

                $basket = $event->getSubject()->getUser()->getBasket();
                $basket->get();
                $basket->getItems();

                $basket->get()->addBasketProduct($tsProduct);
            }
        }
    }

    public static function postAjaxPaymentUpdate(sfEvent $event)
    {
        $event->getSubject()->responseUpdateElement('st-trusted_shops', array('module' => 'stTrustedShopsFrontend', 'component'=> 'showExcellenceBuyerProtection'));
    }

    public static function postOrderSave(sfEvent $event)
    {
        if ($event->getSubject()->getUser()->getAttribute('ts_buyer_protection', false, 'soteshop/stTrustedShopsPlugin'))
        {
            $certificate = TrustedShopsPeer::retrieveByCulture($event->getSubject()->getUser()->getCulture());
            if (is_object($certificate) && $certificate->getType() == 'Excellence' && $certificate->isActive())
            {
                $order = $event->getSubject()->order;

                $amount = $order->getTotalAmountWithDelivery(true, true);

                $c = new Criteria();
                $c->add(TrustedShopsProtectionProductsPeer::TRUSTED_SHOPS_ID, $certificate->getId());
                $c->add(TrustedShopsProtectionProductsPeer::CURRENCY, $order->getOrderCurrency()->getShortcut());
                $c->add(TrustedShopsProtectionProductsPeer::AMOUNT, $amount, Criteria::GREATER_EQUAL);
                $c->addAscendingOrderByColumn(TrustedShopsProtectionProductsPeer::AMOUNT);
                $tspp = TrustedShopsProtectionProductsPeer::doSelectOne($c);

                if (is_object($tspp))
                {
                    $product = new OrderProduct();

                    $product->setQuantity(1);
                    $product->setCode($tspp->getProductId());
                    $product->setName(sfContext::getInstance()->getI18n()->__('Ochrona Kupującego Trusted Shops', null, 'stTrustedShopsFrontend'));
                    $currency = stCurrency::getInstance($event->getSubject())->get();
                    $product->setBasePriceNetto(stCurrency::calculateCurrencyPrice($tspp->getNetto(), $currency->getExchange(), true));
                    $product->setBasePriceBrutto(stCurrency::calculateCurrencyPrice($tspp->getGross(), $currency->getExchange(), true));

                    $vat = round((($tspp->getGross()/$tspp->getNetto())-1)*100);
                    $c = new Criteria();
                    $c->add(TaxPeer::VAT, $vat);
                    $tax = TaxPeer::doSelectOne($c);
                    if (!is_object($tax)) {
                        $tax = new Tax();
                        $tax->setVatName($vat.'%');
                        $tax->setVat($vat);
                        $tax->save();
                    }
                    $product->setTaxId($tax->getId());

                    $order->addOrderProduct($product);
                    $order->save();

                    $basket = stBasket::getInstance($event->getSubject()->getUser());
                    $delivery = stDeliveryFrontend::getInstance($basket);

                    $c = new Criteria();
                    $c->add(TrustedShopsHasPaymentTypePeer::TRUSTED_SHOPS_ID, $certificate->getId());
                    $c->add(TrustedShopsHasPaymentTypePeer::PAYMENT_TYPE_ID, $delivery->getDefaultDelivery()->getDefaultPayment()->getId());
                    $payment = TrustedShopsHasPaymentTypePeer::doSelectOne($c);
                    if (is_object($payment))
                    {
                        $paymentType = $payment->getMethod();
                    } else {
                        $paymentType = 'OTHER';
                    }

                    $date = $order->getCreatedAt('c');
                    $date = explode('+', $date);
                    $date = $date[0];

                    $connector = new stTrustedShopsConnector();
                    $result = $connector->requestForProtectionV2($certificate->getCertificate(),
                    $tspp->getProductId(),
                    $amount,
                    $order->getOrderCurrency()->getShortcut(),
                    $paymentType,
                    $order->getGuardUser()->getUsername(),
                    $order->getGuardUser()->getId(),
                    $order->getNumber(),
                    $date,
                    'SOTE',
                    $certificate->getUsername(),
                    $certificate->getPassword());
                        
                    $tsOrder = new TrustedShopsHasOrder();
                    $tsOrder->setOrderId($order->getId());
                    $tsOrder->setTrustedShopsId($certificate->getId());
                    $tsOrder->setStatus($result);
                    $tsOrder->setChecked(false);
                    $tsOrder->save();
                }
            }
        }
    }
}