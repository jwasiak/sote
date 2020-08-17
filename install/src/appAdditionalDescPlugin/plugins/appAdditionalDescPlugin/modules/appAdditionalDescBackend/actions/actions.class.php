<?php
/** 
 * SOTESHOP/appAdditionalDescPlugin
 * 
 * 
 * @package     appAdditionalDescPlugin
 * @author      Pawel Byszewski <pawel@apes-apps.com>
 */
class appAdditionalDescBackendActions extends sfActions
{
     
    public function executeIndex()
    {

        $i18n = $this->getContext()->getI18N();

        $this->config = stConfig::getInstance('appAdditionalDescBackend');
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $this->config->setFromRequest('additional_desc');
            $this->config->save();
            stFastCacheManager::clearCache();
            $this->setFlash('notice', $i18n->__('Twoje zmiany zostały zapisane', null, 'stAdminGeneratorPlugin'));        
            
        }
        
        $this->config->load();

    }

    public function executeInfo()
    {

        $this->lang = $this->getUser()->getCulture();
        
    }
}