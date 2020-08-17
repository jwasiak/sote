<?php

class stPayByNetBackendActions extends stActions {

    public function executeIndex() {
        $this->stWebRequest = new stWebRequest();
        $this->config = stConfig::getInstance('stPayByNetBackend');
        $this->labels = $this->getLabels();
        if ($this->getRequest()->getMethod() == sfRequest::POST) {
            $this->config->setFromRequest('config');
            $this->config->save();
            $this->setFlash('notice', 'Twoje zmiany zostały zapisane');
        }
        $this->config->load();
    }

    public function validateIndex() {
        if ($this->getRequest()->getMethod() == sfRequest::POST) {
            stAuthUsersListener::checkModificationCredentials($this, $this->getRequest(), $this->getModuleName());
        }
        return true;
    }      

    public function handleErrorIndex() {
        $this->stWebRequest = new stWebRequest();
        $this->config = stConfig::getInstance('stPayByNetBackend');
        $this->labels = $this->getLabels();
        return sfView::SUCCESS;
    }

    public function getLabels() {
        $i18n = $this->getContext()->getI18n();
        return array(
            'config{id_client}' => $i18n->__('Identyfikator'),
            'config{password}' => $i18n->__('Hasło'),
            'config{account}' => $i18n->__('Numer rachunku bankowego'),
            'config{account_name}' => $i18n->__('Nazwa sprzedawcy'),
            'config{account_code}' => $i18n->__('Kod pocztowy'),
            'config{account_city}' => $i18n->__('Miasto'),
            'config{account_street}' => $i18n->__('Adres'));
    }
}