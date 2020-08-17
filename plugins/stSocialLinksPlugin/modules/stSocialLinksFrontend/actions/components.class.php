<?php

class stSocialLinksFrontendComponents extends sfComponents
{
    public function executeShow()
    {	
    	$config = stConfig::getInstance($this->getContext(), 'stSocialLinksBackend');
    	$config->load();      
        if (!$config->get('enable')) 
      	{
         return sfView::NONE;
      	}
      	$this->config = $config;
    	$this->smarty = new stSmarty('stSocialLinksFrontend');
    }
}