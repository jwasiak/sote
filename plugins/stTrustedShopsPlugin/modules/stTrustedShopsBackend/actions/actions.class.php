<?php

class stTrustedShopsBackendActions extends autostTrustedShopsBackendActions {

    public function executeIndex() {
        if (!TrustedShopsPeer::doCount(new Criteria())) $this->redirect('stTrustedShopsBackend/information');
        else $this->redirect('stTrustedShopsBackend/list');
    }

    public function executeInformation() {
        $this->menu_items = $this->getMenuItems();
        $this->hasCertificate = TrustedShopsPeer::doCount(new Criteria());
    }

    protected function getMenuItems() {
        $i18n = $this->getContext()->getI18N();
        return array(
            'stTrustedShopsBackend/information' => $i18n->__('Informacje ogólne'),
            'stTrustedShopsBackend/list' => $i18n->__('Lista certyfikatów'),
            'stTrustedShopsBackend/config' => $i18n->__('Konfiguracja'),
        );
    }

    public function executeRatingActive() {
        if ($this->getRequest()->hasParameter('id')) {
            $i18n = $this->getContext()->getI18N();
            $id = $this->getRequest()->getParameter('id');

            $cert = TrustedShopsPeer::retrieveByPK($id);

            if (is_object($cert)) {
                $cert->setRatingStatus(0);
                switch (stTrustedShopsConnector::updateRating($cert->getCertificate(), 1)) {
                    case 'OK':
                        $this->setFlash('notice', $i18n->__('Dziękujemy za aktywację funkcji Opinia Klienta Trusted Shops!'));
                        $cert->setRatingStatus(1);
                        break;
                    case 'INVALID_TSID':
                        $this->setFlash('warning', $i18n->__('Nieprawidłowy identyfikator Trusted Shops.'));
                        break;
                    case 'NOT_REGISTERED_FOR_TRUSTEDRATING':
                        $this->setFlash('warning', $i18n->__('Dla tego identyfikatora Trusted Shops nie nastąpiła jeszcze aktywacja Opinii Klienta.'));
                        break;
                }
                $cert->save();
            }
        }
        $this->redirect('stTrustedShopsBackend/ratingEdit?id='.$id);
    }

    protected function updateProtectionPaymentsTrustedShopsFromRequest() {
        parent::updateProtectionPaymentsTrustedShopsFromRequest();

        $trusted_shops = $this->getRequestParameter('trusted_shops');

        if(isset($trusted_shops['payment_method'])) {
            foreach($trusted_shops['payment_method'] as $id => $method) {
                $c = new Criteria();
                $c->add(TrustedShopsHasPaymentTypePeer::TRUSTED_SHOPS_ID, $this->getRequestParameter('id'));
                $c->add(TrustedShopsHasPaymentTypePeer::PAYMENT_TYPE_ID, $id);
                $trustedShopsPaymentType = TrustedShopsHasPaymentTypePeer::doSelectOne($c);

                if (!is_object($trustedShopsPaymentType)) {
                    $trustedShopsPaymentType = new TrustedShopsHasPaymentType();
                    $trustedShopsPaymentType->setTrustedShopsId($this->getRequestParameter('id'));
                    $trustedShopsPaymentType->setPaymentTypeId($id);
                }

                $trustedShopsPaymentType->setMethod($method);
                $trustedShopsPaymentType->save();
            }
        }
    }

    public function validateEdit() {
        $return = true;
        
        if ($this->getRequest()->getMethod() == sfRequest::POST && $this->getRequest()->hasParameter('id') && $this->getRequest()->getParameter('id') != '') {

            $certificate = TrustedShopsPeer::retrieveByPK($this->getRequest()->getParameter('id'));
            
            if (is_object($certificate)) {
                $trustedShops = $this->getRequest()->getParameter('trusted_shops');

                $config = stConfig::getInstance('stTrustedShopsBackend');

                if ($certificate->getType() == 'Excellence') {
                    if (!isset($trustedShops['username']) || empty($trustedShops['username'])) {
                        $this->getRequest()->setError('trusted_shops{username}', 'Proszę uzupełnić pole.');
                        $return = false;
                    }

                    if (!isset($trustedShops['password']) || empty($trustedShops['password'])) {
                        $this->getRequest()->setError('trusted_shops{password}', 'Proszę uzupełnić pole.');
                        $return = false;
                    }

                    if ($return == true) {
                        $result = stTrustedShopsConnector::checkLogin($trustedShops['certificate'], $trustedShops['username'], $trustedShops['password']);

                        if ($result != 1) {
                            $this->getRequest()->setError('trusted_shops{username}', stTrustedShopsConnector::getCheckLoginError($result));
                            $return = false;
                        }
                    }
                }
            }
        }
        return $return;
    }
}