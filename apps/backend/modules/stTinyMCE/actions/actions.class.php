<?php

class stTinyMCEActions extends stActions
{
    public function executeConfig()
    {
        $this->labels = $this->getLabels();
            
        $this->config = stConfig::getInstance('stTinyMCE');

        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $this->config->setFromRequest('config');
            $this->config->save();
            $this->setFlash('notice', 'Twoje zmiany zostały zapisane');
        }
    }


    protected function getLabels()
    {
        $i18n = $this->getContext()->getI18n();

        return array(
            'config{advanced}' => $i18n->__('Włącz edycje zaawansowaną'),
        );  
    }
}