<?php
/** 
 * SOTESHOP/appFacebookRemarketingPlugin
 * 
 * 
 * @package     appFacebookRemarketingPlugin
 * @author      Pawel Byszewski <pawel@apes-apps.com>
 */
class appFacebookRemarketingBackendActions extends sfActions
{
     
    public function executeIndex()
    {
        
        $i18n = $this->getContext()->getI18N();

        $this->config = stConfig::getInstance('appFacebookRemarketingBackend');

        $this->config->setCulture($this->getRequestParameter('culture', stLanguage::getOptLanguage()));
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {

            $this->config->set('enable_fbremarketing', $this->getRequestParameter('fbremarketing[enable_fbremarketing]'));

            $this->config->set('code_fbremarketing', $this->getRequestParameter('fbremarketing[code_fbremarketing]'), true);
            
            $this->config->set('product_card', $this->getRequestParameter('fbremarketing[product_card]'));

            $this->config->set('cart', $this->getRequestParameter('fbremarketing[cart]'));

            $this->config->set('order', $this->getRequestParameter('fbremarketing[order]'));

            if ($this->config->get('enable_fbremarketing') && $this->config->get('code_fbremarketing', null, true)) 
            {
                stAppStats::activate('Piksel Facebooka');
            }
            else 
            {
                stAppStats::deactivate('Piksel Facebooka');
            }
            
            $this->config->save();
            
            stFastCacheManager::clearCache();
            
            $this->setFlash('notice', $i18n->__('Twoje zmiany zostały zapisane', null, 'stAdminGeneratorPlugin'));
            
            $this->redirect('appFacebookRemarketingBackend/index?culture=' . $this->getRequestParameter('culture', stLanguage::getOptLanguage()));
        }

        if ($this->config->get('code_fbremarketing', $this->getRequestParameter('fbremarketing[code_fbremarketing]'), true) != '')
        {

            $this->configuration_check = true;

        } else {

            $this->configuration_check = false;
            
        }
        
        $this->config->load();

    }
    
}