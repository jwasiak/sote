<?php
/**
 * SOTESHOP/appFacebookRemarketingPlugin
 * 
 * 
 * @package     appFacebookRemarketingPlugin
 * @author      Pawel Byszewski <pawel@apes-apps.com>
 */

class appFacebookRemarketingFrontendComponents extends sfComponents
{
    public function executeFbremarketing()
    {
        
        $config = stConfig::getInstance('appFacebookRemarketingBackend');
        
        $this->fbremarketingConfig = $config->load();
        
        $this->fbremarketingConfig['code_fbremarketing'] = $config->get('code_fbremarketing', null, true);
        
        if ($this->fbremarketingConfig['enable_fbremarketing'] != 1 || $this->fbremarketingConfig['code_fbremarketing'] == null)
        {
            return sfView::NONE;
        }

        if ((sfContext::getInstance()->getActionName()=="show") && (sfContext::getInstance()->getModuleName()=="stProduct") && $this->fbremarketingConfig['product_card'] == 1)
        {
            $this->product_card = 1;

            $this->product = sfContext::getInstance()->getActionStack()->getLastEntry()->getActionInstance()->product;

        }

        if ((sfContext::getInstance()->getActionName()=="summary") && (sfContext::getInstance()->getModuleName()=="stOrder") && $this->fbremarketingConfig['order'] == 1)
        {
            $this->orders = 1;

            $this->order = sfContext::getInstance()->getActionStack()->getLastEntry()->getActionInstance()->order;

        }
        
        $this->smarty = new stSmarty('appFacebookRemarketingFrontend');
         
    }

    public function executeFbAddTrack() {
        
        $config = stConfig::getInstance('appFacebookRemarketingBackend');
        
        $this->fbremarketingConfig = $config->load();
        
        $this->fbremarketingConfig['code_fbremarketing'] = $config->get('code_fbremarketing', null, true);
        
        if ($this->fbremarketingConfig['enable_fbremarketing'] != 1 || $this->fbremarketingConfig['code_fbremarketing'] == null || $this->fbremarketingConfig['cart'] != 1)
        {
            return sfView::NONE;
        }                

        $this->items = $this->getUser()->getBasket()->getlastAddedItems();

        $this->currency = stCurrency::getInstance(sfContext::getInstance())->get();

    }
}