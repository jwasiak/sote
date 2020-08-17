<?php
class stMoneybookersBackendActions extends stActions
{
    /** 
     * Wyświetla konfigurację modułu
     */
    public function executeIndex()
    {
        $this->config = stConfig::getInstance('stMoneybookersBackend');

        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $this->config->setFromRequest('moneybookers');
            $this->config->save();
            $this->setFlash('notice', 'Twoje zmiany zostały zapisane');
        }
        $this->config->load();
    }

    public function validateIndex()
    {
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            stAuthUsersListener::checkModificationCredentials($this, $this->getRequest(), $this->getModuleName());
        }
        
        return true;
    } 

    public function handleErrorIndex()
    {
        $this->config = stConfig::getInstance('stMoneybookersBackend');
        $this->config->setFromRequest('moneybookers');
        $this->webRequest = new stWebRequest();
        return sfView::SUCCESS;
    }       
}