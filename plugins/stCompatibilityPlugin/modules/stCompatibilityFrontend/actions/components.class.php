<?php

class stCompatibilityFrontendComponents extends sfComponents {

    public function executeShowPriceDescInFooter() {
        
        
        $this->compatibility_config = stConfig::getInstance('stCompatibilityBackend');
        
        
        if (!stConfig::getInstance('stCompatibilityBackend')->get('mode_de', false)){
            return sfView::NONE;
        }else{
            
        $config = stConfig::getInstance(sfContext::getInstance(), 'stCompatibilityBackend');
        $config->setCulture(sfContext::getInstance()->getUser()->getCulture());       
                
        $this->star_description = $config->get('star', null, true);
        }
            
        $this->smarty = new stSmarty('stCompatibilityFrontend');
        $this->webpage = WebpagePeer::getShippingWebpage();
    }
    
    public function executeShowCookiesInfo() {
        
        $this->smarty = new stSmarty('stCompatibilityFrontend');
        
        $config = stConfig::getInstance(sfContext::getInstance(), 'stCompatibilityBackend');
        $config->setCulture(sfContext::getInstance()->getUser()->getCulture());       
                
        $this->cookies_info_color = $config -> get('cookies_info_color');
        $this->cookies_info_background = $config -> get('cookies_info_background');
        $this->cookies_info_width = $config -> get('cookies_info_width');
        $this->cookies_description = str_replace(array("\r", "\n"), "", $config->get('description', null, true));
        
        $webpage = WebpagePeer::getPrivacyWebpage();
        $this->webpage = $webpage;
       
        if($webpage==""){
            return sfView::NONE;
        }       
    }
    
    public function executeShowChangeTermsInfo() {
        
        $this->smarty = new stSmarty('stCompatibilityFrontend');
        
        $config = stConfig::getInstance(sfContext::getInstance(), 'stCompatibilityBackend');
        $config->setCulture(sfContext::getInstance()->getUser()->getCulture());       
                
        $this->change_terms_color = $config -> get('change_terms_color');
        $this->change_terms_background = $config -> get('change_terms_background');
        $this->change_terms_width = $config -> get('change_terms_width');
        $this->change_terms_cookie_hash = $config -> get('change_terms_cookie_hash');        
                
        $this->change_terms_description = str_replace(array("\r", "\n", "<br/>", "<br>"), "", $config->get('change_terms_description', null, true));
        
        
        $this->is_authenticated = $this->getUser()->isAuthenticated();
        
        
        $terms_webpage = WebpagePeer::getTermsWebpage();
        $this->terms_webpage = $terms_webpage;
        
        $shipping_webpage = WebpagePeer::getShippingWebpage();
        $this->shipping_webpage = $shipping_webpage;
    
        $right_2_cancel_webpage = WebpagePeer::getRight2CancelWebpage();
        $this->right_2_cancel_webpage = $right_2_cancel_webpage;
         
        $privacy_webpage = WebpagePeer::getPrivacyWebpage();
        $this->privacy_webpage = $privacy_webpage;        
        
    }

    public function executeShowFrUserElements() {
        if(!stCompatibilityLaw::show(stCompatibilityLaw::FR)) return sfView::NONE;
        $this->smarty = new stSmarty('stCompatibilityFrontend');
        $c = new Criteria();
        $c->add(TextPeer::SYSTEM_NAME, 'stCompatibility-user-fr');
        $this->text = TextPeer::doSelectOne($c);
        if (!is_object($this->text)) return sfView::NONE;
    }

    public function executeOpinionBasketCheckbox() {
        $config = stConfig::getInstance('stCompatibilityBackend');
        if (!stCompatibilityOpinion::show() || $config->get('basket_opinion_show')==0) 
            return sfView::NONE;

        if (stCompatibilityLaw::isSection("basket_opinion_show_countrys") != true) 
            return sfView::NONE;

        $this->smarty = new stSmarty('stCompatibilityFrontend');
        $this->text = $config->get('basket_opinion_text', null, true);
    }
}