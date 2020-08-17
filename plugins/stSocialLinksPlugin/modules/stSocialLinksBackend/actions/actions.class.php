<?php

class stSocialLinksBackendActions extends sfActions
{
    public function executeIndex()
    {
        $i18n = $this->getContext()->getI18N();

        $this->config = stConfig::getInstance('stSocialLinksBackend');
        
        $this->config->setCulture($this->getRequestParameter('culture', stLanguage::getOptLanguage()));

        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            
            $this->config->set('enable', $this->getRequestParameter('sociallinks[enable]'));

            $this->config->set('facebook', $this->getRequestParameter('sociallinks[facebook]'), true);

            $this->config->set('twitter', $this->getRequestParameter('sociallinks[twitter]'), true);

            $this->config->set('youtube', $this->getRequestParameter('sociallinks[youtube]'), true);
            
            $this->config->set('google', null);
            
            $this->config->set('instagram', $this->getRequestParameter('sociallinks[instagram]'), true);

            $this->config->set('pinterest', $this->getRequestParameter('sociallinks[pinterest]'), true);

            $this->config->set('allegro', $this->getRequestParameter('sociallinks[allegro]'), true);

            $this->config->set('newsletter', $this->getRequestParameter('sociallinks[newsletter]'));

            $this->config->save();
            
            stFastCacheManager::clearCache();
            
            $this->setFlash('notice', $i18n->__('Twoje zmiany zostały zapisane', null, 'stAdminGeneratorPlugin'));
            
            $this->redirect('stSocialLinksBackend/index?culture=' . $this->getRequestParameter('culture', stLanguage::getOptLanguage()));
        }
        
        $this->config->load();
    }
}