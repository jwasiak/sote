<?php

class stCashBillBackendActions extends stActions {

    public function initializeParameters() {

        $this->webRequest = new stWebRequest();
        $this->config = stConfig::getInstance('stCashBillBackend');

        $i18n = $this->getContext()->getI18n();
        $this->labels = array(
            'cashbill{shop_id}' => $i18n->__('Identyfikator'),
            'cashbill{secret_key}' => $i18n->__('Klucz'),
        );
    }

    public function executeIndex() {
        $this->initializeParameters();
        if ($this->getRequest()->getMethod() == sfRequest::POST) {
            $this->config->setFromRequest('config');
            $this->config->save();

            $this->setFlash('notice', $this->getContext()->getI18n()->__('Twoje zmiany zostały zapisane', null, 'stAdminGeneratorPlugin'));
        }
    }

    public function validateIndex() {
        if ($this->getRequest()->getMethod() == sfRequest::POST)
            stAuthUsersListener::checkModificationCredentials($this, $this->getRequest(), $this->getModuleName());
        return true;
    }      

    public function handleErrorIndex() {
        $this->initializeParameters();
        return sfView::SUCCESS;
    }
}
