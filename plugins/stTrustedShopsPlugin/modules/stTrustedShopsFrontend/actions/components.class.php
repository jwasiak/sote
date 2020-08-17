<?php

class stTrustedShopsFrontendComponents extends sfComponents {

    public function executeShowExcellenceBuyerProtection() {
        $this->smarty = new stSmarty('stTrustedShopsFrontend');
        $cert = TrustedShopsPeer::retrieveByCulture($this->getUser()->getCulture());

        if (is_object($cert) && $cert->getType() == 'Excellence' && $cert->isActive()) {
            $this->certificate = $cert->getCertificate();

            $stBasket = stBasket::getInstance($this->getUser());
            $stDelivery = stDeliveryFrontend::getInstance($stBasket);
            $stCurrency = stCurrency::getInstance($this->getContext());

            $c = new Criteria();
            $c->add(TrustedShopsProtectionProductsPeer::TRUSTED_SHOPS_ID, $cert->getId());
            $c->add(TrustedShopsProtectionProductsPeer::CURRENCY, $stCurrency->get()->getShortcut());
            $c->add(TrustedShopsProtectionProductsPeer::AMOUNT, $stBasket->getTotalAmount(true,true) + $stDelivery->getTotalDeliveryCost(true,true), Criteria::GREATER_EQUAL);
            $c->addAscendingOrderByColumn(TrustedShopsProtectionProductsPeer::AMOUNT);
            $tspp = TrustedShopsProtectionProductsPeer::doSelectOne($c);

            $connector = new stTrustedShopsConnector();

            if (is_object($tspp) && $connector->checkLogin($cert->getCertificate(), $cert->getUsername(), $cert->getPassword()) == 1) { 
                $this->amount = $tspp->getAmount();
                $this->price = $tspp->getGross();
                $this->currency = $tspp->getCurrency();
                $this->getUser()->setAttribute('ts_buyer_protection_id', $tspp->getId(), 'soteshop/stTrustedShopsPlugin');
                $this->checked = $this->getUser()->getAttribute('ts_buyer_protection', false, 'soteshop/stTrustedShopsPlugin');
            } else return sfView::NONE;
        } else return sfView::NONE;
    }

    public function executeShowClassicBuyerProtection() {
        $r = $this->getRequest();
        if ($r->hasParameter('id') && $r->hasParameter('hash_code')) {

            $this->smarty = new stSmarty('stTrustedShopsFrontend');
            $cert = TrustedShopsPeer::retrieveByCulture($this->getUser()->getCulture());

            if (is_object($cert) && $cert->getType() == 'Classic' && $cert->isActive()) {
                $order = OrderPeer::retrieveByIdAndHashCode($r->getParameter('id'), $r->getParameter('hash_code'));

                $this->certificate = $cert->getCertificate();
                $this->email = $order->getGuardUser()->getUsername();
                $this->userId = $order->getGuardUser()->getId();
                $this->orderId = $order->getNumber();
                $this->orderAmount = number_format($order->getTotalAmountWithDelivery(true, true), 2, '.', '');
                $this->currency = $order->getOrderCurrency()->getShortcut();

                $c = new Criteria();
                $c->add(TrustedShopsHasPaymentTypePeer::TRUSTED_SHOPS_ID, $cert->getId());
                $c->add(TrustedShopsHasPaymentTypePeer::PAYMENT_TYPE_ID, $order->getOrderPayment()->getPaymentTypeId());
                $payment = TrustedShopsHasPaymentTypePeer::doSelectOne($c);
                
                if (is_object($payment)) {
                    $this->paymentType = $payment->getMethod();
                } else {
                    $this->paymentType = 'OTHER';
                }

            } else return sfView::NONE;
        } else return sfView::NONE;
    }

    
    public function executeShowTrustbadge() {
        $certificate = TrustedShopsPeer::retrieveByCulture($this->getUser()->getCulture());
        
        if (!is_object($certificate))
            return sfView::NONE;

        $this->code = $certificate->getTrustbadgeCode();
    }
    
    public function executeShowRatingWidget() {
        $this->smarty = new stSmarty('stTrustedShopsFrontend');
        $certificate = TrustedShopsPeer::retrieveByCulture($this->getUser()->getCulture());

        if (is_object($certificate) && $certificate->getRatingWidget()) {
            $this->certificate = $certificate->getCertificate();
        } else 
            return sfView::NONE;
    }

    public function executeOrderSummary() {
        if ($this->getRequest()->hasParameter('id') && $this->getRequest()->hasParameter('hash_code')) {
            
            $certificate = TrustedShopsPeer::retrieveByCulture($this->getUser()->getCulture());
            if (!is_object($certificate))
                return sfView::NONE;

            $id = $this->getRequestParameter('id');
            $hashCode = $this->getRequestParameter('hash_code');

            $order = OrderPeer::retrieveByIdAndHashCode($id, $hashCode);
            if (!is_object($order))
               return sfView::NONE;

            $c = new Criteria();
            $c->add(OrderHasPaymentPeer::ORDER_ID, $order->getId());
            $c->addJoin(OrderHasPaymentPeer::PAYMENT_ID, PaymentPeer::ID);
            $c->add(PaymentPeer::GIFT_CARD_ID, null, Criteria::ISNULL);
            $orderHasPayment = OrderHasPaymentPeer::doSelectOne($c);
            if (!is_object($orderHasPayment))
               return sfView::NONE;

            $this->email = $order->getGuardUser()->getUsername();
            $this->number = $order->getNumber();
            $this->amount = number_format($order->getTotalAmountWithDelivery(true, true), 2, '.', '');
            $this->currency = $order->getOrderCurrency()->getShortcut();
            $this->payment = $orderHasPayment->getPayment()->getPaymentType()->getName();
        }
    }
    
}
