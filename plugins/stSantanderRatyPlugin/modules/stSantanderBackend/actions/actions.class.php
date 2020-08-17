<?php


class stSantanderBackendActions extends stActions
{
    public function executeSave()
    {
        return $this->forward('stSantanderBackend', 'config');
    }

    public function executeConfig()
    {
        $this->config = stConfig::getInstance('stSantanderBackend');

        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $this->config->setFromRequest('config');

            $this->config->save();

            $this->setFlash('notice', $this->getContext()->getI18N()->__('Twoje zmiany zostały zapisane', null, 'stAdminGeneratorPlugin'));

            return $this->redirect('@stSantanderBackend?action=config');
        }
    }
}