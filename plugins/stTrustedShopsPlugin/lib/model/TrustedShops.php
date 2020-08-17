<?php

class TrustedShops extends BaseTrustedShops {

    public function getType() {
        return ucfirst(strtolower($this->type));
    }

    public function delete($con = null) {
        parent::delete($con);

        $stCache = new stFunctionCache('stTrustedShopsPlugin');
        $stCache->removeAll();

        stTheme::clearSmartyCache(true);

        stFastCacheManager::clearCache();
    }

    public function save($con = null) {
        $isNew = false;
        if($this->isNew()) {
            $result = stTrustedShopsConnector::checkCertificate($this->certificate);

            $this->setType($result->typeEnum);
            $this->setStatus($result->stateEnum);
            $this->setUrl($result->url);
            $this->setLanguage($result->certificationLanguage);

            if ($result->stateEnum == 'INVALID_TS_ID') {
                if (stTrustedShopsConnector::updateRating($this->certificate, 1) == 'OK') {
                    $this->setRatingStatus(1);
                }
            }

            $isNew = true;
        }

        $stCache = new stFunctionCache('stTrustedShopsPlugin');
        $stCache->removeAll();

        stTheme::clearSmartyCache(true);

        stFastCacheManager::clearCache();

        parent::save($con);

        if($isNew) {
            foreach (PaymentTypePeer::doSelect(new Criteria()) as $paymentType) {

                $method = 'OTHER';
                if ($paymentType->getModuleName() == 'stPaypal') $method = 'PAYPAL';
                if ($paymentType->getModuleName() == 'stDotpay') $method = 'DOTPAY';
                if ($paymentType->getModuleName() == 'stEcard') $method = 'CREDIT_CARD';
                if ($paymentType->getModuleName() == 'stLukas') $method = 'OTHER';
                if ($paymentType->getModuleName() == 'stMoneybookers') $method = 'MONEYBOOKERS';
                if ($paymentType->getModuleName() == 'stPlatnosciPl') $method = 'PLATNOSCI';
                if ($paymentType->getModuleName() == 'stPolcard') $method = 'CREDIT_CARD';
                if ($paymentType->getModuleName() == 'stPrzelewy24') $method = 'PRZELEWY24';
                if ($paymentType->getModuleName() == 'stZagiel') $method = 'OTHER';
                if ($paymentType->getModuleName() == 'stStandardPayment' && $paymentType->getName() == 'Płatność gotówką') $method = 'CASH_ON_PICKUP';
                if ($paymentType->getModuleName() == 'stStandardPayment' && $paymentType->getName() == 'Płatność przelewem') $method = 'PREPAYMENT';

                $c = new Criteria();
                $c->add(TrustedShopsHasPaymentTypePeer::TRUSTED_SHOPS_ID, $this->getId());
                $c->add(TrustedShopsHasPaymentTypePeer::PAYMENT_TYPE_ID, $paymentType->getId());
                $trustedShopsPaymentType = TrustedShopsHasPaymentTypePeer::doSelectOne($c);

                if (!is_object($trustedShopsPaymentType)) {
                    $trustedShopsPaymentType = new TrustedShopsHasPaymentType();
                    $trustedShopsPaymentType->setTrustedShopsId($this->getId());
                    $trustedShopsPaymentType->setPaymentTypeId($paymentType->getId());
                    $trustedShopsPaymentType->setMethod($method);
                    $trustedShopsPaymentType->save();
                }
            }
        }
    }

    public function isActive() {
        if (in_array($this->status, array('PRODUCTION', 'TEST', 'INTEGRATION'))) return true;
        return false;
    }

    public function isRating() {
        if ($this->status == 'INVALID_TS_ID' && $this->rating_status == '1') return true;
        return false;
    }
    
    public function getTrustBadgeCode() {
        $v = trim($this->trustbadge_code);
        if (empty($v))
            return null;

        return $this->trustbadge_code;
    }
    
}
