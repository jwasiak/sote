<?php

class stCompatibilityBackendActions extends stActions {

    public function executeIndex() {
        $context = $this->getContext();
        $this->config = stConfig::getInstance($context);
        $this->config->setCulture($this->getRequestParameter('culture', stLanguage::getOptLanguage()));        

        if ($this->getRequest()->getMethod() == sfRequest::POST) {
            
            $updateConfig = $this->getRequestParameter('config');
            
            if($this->hasRequestParameter('saveReset')){
                $this->config->set('change_terms_cookie_hash', md5(microtime(true)));
                $this->config->set('change_terms_cookie_time', date('Ymd', strtotime("+30 day")));                           
            }            
            
            if($updateConfig['change_terms_on']==1 && $updateConfig['change_terms_cookie_time']=="" || $updateConfig['change_terms_on']==1 && $updateConfig['change_terms_cookie_time'] < date('Ymd')){
                $this->config->set('change_terms_cookie_time', date('Ymd', strtotime("+30 day")));
            }
            
            $this->config->set('mode_de', $updateConfig['mode_de']);
            $this->config->set('mode_fr', $updateConfig['mode_fr']);
            $this->config->set('save_for', $updateConfig['save_for']);
            $this->config->set('cookies_info_color', $updateConfig['cookies_info_color']);
            $this->config->set('cookies_info_background', $updateConfig['cookies_info_background']);
            $this->config->set('cookies_info_width', $updateConfig['cookies_info_width']);
            $this->config->set('cookies_info_on', $updateConfig['cookies_info_on']);
            $this->config->set('description', $updateConfig['description'], true);
            $this->config->set('change_terms_color', $updateConfig['change_terms_color']);
            $this->config->set('change_terms_background', $updateConfig['change_terms_background']);
            $this->config->set('change_terms_width', $updateConfig['change_terms_width']);
            $this->config->set('change_terms_on', $updateConfig['change_terms_on']);
            $this->config->set('change_terms_description', $updateConfig['change_terms_description'], true);
            $this->config->set('star', $updateConfig['star'], true);
            $this->config->set('basket_opinion_show', $updateConfig['basket_opinion_show']);
            $this->config->set('basket_opinion_text', $updateConfig['basket_opinion_text'], true);
            $this->config->set('terms_digital', $updateConfig['terms_digital']);
            $this->config->set('terms_digital_show_online', $updateConfig['terms_digital_show_online']);
            $this->config->set('terms_digital_text', $updateConfig['terms_digital_text'], true);
            $this->config->set('terms_service', $updateConfig['terms_service']);
            $this->config->set('terms_service_products', $updateConfig['terms_service_products']);
            $this->config->set('terms_service_text', $updateConfig['terms_service_text'], true);
            $this->config->set('terms_right_2_cancel', $updateConfig['terms_right_2_cancel']);
            $this->config->set('terms_right_2_cancel_text', $updateConfig['terms_right_2_cancel_text'], true);
            $this->config->set('terms_in_mail_confirm_order', $updateConfig['terms_in_mail_confirm_order']);
            $this->config->set('right_2_cancel_in_mail_confirm_order', $updateConfig['right_2_cancel_in_mail_confirm_order']);
            $this->config->set('terms_in_mail_confirm_order_format', $updateConfig['terms_in_mail_confirm_order_format']);
            $this->config->set('right_2_cancel_in_mail_confirm_order_format', $updateConfig['right_2_cancel_in_mail_confirm_order_format']);
            $this->config->set('courier_fee', $updateConfig['courier_fee']);
            
            $this->config->set('terms_shop_show', $updateConfig['terms_shop_show']);
            $this->config->set('terms_shop_text', $updateConfig['terms_shop_text'], true);
            
            $this->config->set('terms_privacy_show', $updateConfig['terms_privacy_show']);
            $this->config->set('terms_privacy_text', $updateConfig['terms_privacy_text'], true);
            
            $this->config->set('terms_privacy_newsletter_show', $updateConfig['terms_privacy_newsletter_show']);
            $this->config->set('terms_privacy_newsletter_text', $updateConfig['terms_privacy_newsletter_text'], true);
            
            
            if($updateConfig['save_for']==1){
                    
                $ue_countries_array = array('PL');
                                
                if($updateConfig['mode_de']==1){
                    $countries_array = array();
                    $selected_countries = unserialize($this->config->get('mode_de_countrys'));
                    $this->config->set('mode_de_countrys', serialize(array_merge($selected_countries,$ue_countries_array)));
                }
                
                if($updateConfig['basket_opinion_show']==1){                     
                    $countries_array = array();
                    $selected_countries = unserialize($this->config->get('basket_opinion_show_countrys'));
                    $this->config->set('basket_opinion_show_countrys', serialize(array_merge($selected_countries,$ue_countries_array)));
                }

                if($updateConfig['terms_in_mail_confirm_order']==1){
                    $countries_array = array();
                    $selected_countries = unserialize($this->config->get('terms_in_mail_confirm_order_countrys'));
                    $this->config->set('terms_in_mail_confirm_order_countrys', serialize(array_merge($selected_countries,$ue_countries_array)));
                }

                if($updateConfig['right_2_cancel_in_mail_confirm_order']==1){
                    $countries_array = array();
                    $selected_countries = unserialize($this->config->get('right_2_cancel_in_mail_confirm_order_countrys'));
                    $this->config->set('right_2_cancel_in_mail_confirm_order_countrys', serialize(array_merge($selected_countries,$ue_countries_array)));
                }

                if($updateConfig['terms_right_2_cancel']==1){
                    $countries_array = array();
                    $selected_countries = unserialize($this->config->get('terms_right_2_cancel_countrys'));
                    $this->config->set('terms_right_2_cancel_countrys', serialize(array_merge($selected_countries,$ue_countries_array)));
                }

                if($updateConfig['terms_digital']==1){                 
                    $countries_array = array();
                    $selected_countries = unserialize($this->config->get('terms_digital_countrys'));
                    $this->config->set('terms_right_2_cancel_countrys', serialize(array_merge($selected_countries,$ue_countries_array)));
                }

                if($updateConfig['terms_digital']==1){                     
                    $countries_array = array();
                    $selected_countries = unserialize($this->config->get('terms_digital_countrys'));
                    $this->config->set('terms_digital_countrys', serialize(array_merge($selected_countries,$ue_countries_array)));
                }
                
                if($updateConfig['terms_service']==1){
                    $countries_array = array();
                    $selected_countries = unserialize($this->config->get('terms_service_countrys'));
                    $this->config->set('terms_service_countrys', serialize(array_merge($selected_countries,$ue_countries_array)));
                }

                if($updateConfig['courier_fee']==1){
                    $countries_array = array();
                    $selected_countries = unserialize($this->config->get('courier_fee_countrys'));
                    $this->config->set('courier_fee_countrys', serialize(array_merge($selected_countries,$ue_countries_array)));
                }
                
                if($updateConfig['terms_shop_show']==1){                     
                    $countries_array = array();
                    $selected_countries = unserialize($this->config->get('terms_shop_countrys'));
                    $this->config->set('terms_shop_countrys', serialize(array_merge($selected_countries,$ue_countries_array)));
                }
                
                if($updateConfig['terms_privacy_show']==1){                     
                    $countries_array = array();
                    $selected_countries = unserialize($this->config->get('terms_privacy_countrys'));
                    $this->config->set('terms_privacy_countrys', serialize(array_merge($selected_countries,$ue_countries_array)));
                }
                
                if($updateConfig['terms_privacy_newsletter_show']==1){                     
                    $countries_array = array();
                    $selected_countries = unserialize($this->config->get('terms_privacy_newsletter_countrys'));
                    $this->config->set('terms_privacy_newsletter_countrys', serialize(array_merge($selected_countries,$ue_countries_array)));
                }
            }
            
            if($updateConfig['save_for']==2){
                
                $ue_countries_array = array('AT','BE','BG','HR','CY','CZ','DK','EE','FI','FR','DE','GR','HU','IE','IT','LV','LT','LU','MT','MC','NL','PL','PT','RO','SK','SI','ES','SE','GB');
                                
                if($updateConfig['mode_de']==1){
                    $countries_array = array();
                    $selected_countries = unserialize($this->config->get('mode_de_countrys'));
                    $this->config->set('mode_de_countrys', serialize(array_merge($selected_countries,$ue_countries_array)));
                }
                
                if($updateConfig['basket_opinion_show']==1){                     
                    $countries_array = array();
                    $selected_countries = unserialize($this->config->get('basket_opinion_show_countrys'));
                    $this->config->set('basket_opinion_show_countrys', serialize(array_merge($selected_countries,$ue_countries_array)));
                }

                if($updateConfig['terms_in_mail_confirm_order']==1){
                    $countries_array = array();
                    $selected_countries = unserialize($this->config->get('terms_in_mail_confirm_order_countrys'));
                    $this->config->set('terms_in_mail_confirm_order_countrys', serialize(array_merge($selected_countries,$ue_countries_array)));
                }

                if($updateConfig['right_2_cancel_in_mail_confirm_order']==1){
                    $countries_array = array();
                    $selected_countries = unserialize($this->config->get('right_2_cancel_in_mail_confirm_order_countrys'));
                    $this->config->set('right_2_cancel_in_mail_confirm_order_countrys', serialize(array_merge($selected_countries,$ue_countries_array)));
                }

                if($updateConfig['terms_right_2_cancel']==1){
                    $countries_array = array();
                    $selected_countries = unserialize($this->config->get('terms_right_2_cancel_countrys'));
                    $this->config->set('terms_right_2_cancel_countrys', serialize(array_merge($selected_countries,$ue_countries_array)));
                }

                if($updateConfig['terms_digital']==1){                 
                    $countries_array = array();
                    $selected_countries = unserialize($this->config->get('terms_digital_countrys'));
                    $this->config->set('terms_right_2_cancel_countrys', serialize(array_merge($selected_countries,$ue_countries_array)));
                }

                if($updateConfig['terms_digital']==1){                     
                    $countries_array = array();
                    $selected_countries = unserialize($this->config->get('terms_digital_countrys'));
                    $this->config->set('terms_digital_countrys', serialize(array_merge($selected_countries,$ue_countries_array)));
                }
                
                if($updateConfig['terms_service']==1){
                    $countries_array = array();
                    $selected_countries = unserialize($this->config->get('terms_service_countrys'));
                    $this->config->set('terms_service_countrys', serialize(array_merge($selected_countries,$ue_countries_array)));
                }

                if($updateConfig['courier_fee']==1){
                    $countries_array = array();
                    $selected_countries = unserialize($this->config->get('courier_fee_countrys'));
                    $this->config->set('courier_fee_countrys', serialize(array_merge($selected_countries,$ue_countries_array)));
                }
                
                if($updateConfig['terms_shop_show']==1){                     
                    $countries_array = array();
                    $selected_countries = unserialize($this->config->get('terms_shop_countrys'));
                    $this->config->set('terms_shop_countrys', serialize(array_merge($selected_countries,$ue_countries_array)));
                }
                
                if($updateConfig['terms_privacy_show']==1){                     
                    $countries_array = array();
                    $selected_countries = unserialize($this->config->get('terms_privacy_countrys'));
                    $this->config->set('terms_privacy_countrys', serialize(array_merge($selected_countries,$ue_countries_array)));
                }
                
                 if($updateConfig['terms_privacy_newsletter_show']==1){                     
                    $countries_array = array();
                    $selected_countries = unserialize($this->config->get('terms_privacy_newsletter_countrys'));
                    $this->config->set('terms_privacy_newsletter_countrys', serialize(array_merge($selected_countries,$ue_countries_array)));
                }

            }

            $this->config->save(true);
            stTheme::clearSmartyCache();
            stFastCacheManager::clearCache();

            foreach (glob(sfConfig::get('sf_root_dir').'/cache/frontend/*/template/stWebpageFrontend/_footerWebpage/*/*') as $file)
                unlink($file);

            $this->setFlash('notice', $context->getI18n()->__('Twoje zmiany zostały zapisane', null, 'stAdminGeneratorPlugin'));
            $this->redirect('stCompatibilityBackend/index?culture='.$this->getRequestParameter('culture', stLanguage::getOptLanguage()));
        }
    }

    public function validateIndex() {
        if ($this->getRequest()->getMethod() == sfRequest::POST) {
            stAuthUsersListener::checkModificationCredentials($this, $this->getRequest(), $this->getModuleName());
        }
        return true;
    }  
     
    public function executeCountries() {
        $context = $this->getContext();
        $this->config = stConfig::getInstance($context);
        $this->config->setCulture($this->getRequestParameter('culture', stLanguage::getOptLanguage()));
        
        $section = $this->getRequestParameter('section');
         
        if ($this->getRequest()->getMethod() == sfRequest::POST) {
            
            $countries_config_array = array();            
            $updateCountry = $this->getRequestParameter('country');

            foreach ($updateCountry as $key => $value) {
                $countries_config_array[]=$key;
            };
                        
            $this->config->set($section, serialize($countries_config_array));

            if($this->config -> get('save_for')==1 || $this->config -> get('save_for')==2){
                $this->config->set('save_for', 3);
            }

            $this->config->save(true);
            stTheme::clearSmartyCache();
            stFastCacheManager::clearCache();
            ProductGroupPeer::cleanCache();
                
            $this->setFlash('notice', $context->getI18n()->__('Twoje zmiany zostały zapisane', null, 'stAdminGeneratorPlugin'));
            $this->redirect('stCompatibilityBackend/countries?section='.$section);
        }
            
         
         $countries_array = array();
         $selected_countries = unserialize($this->config->get($section));
         $ue_countries_array = array('AT','BE','BG','HR','CY','CZ','DK','EE','FI','FR','DE','GR','HU','IE','IT','LV','LT','LU','MT','MC','NL','PL','PT','RO','SK','SI','ES','SE','GB');
         
         
         $c = new Criteria();
         $c->addAscendingOrderByColumn(CountriesPeer::OPT_NAME);
         $countries = CountriesPeer::doSelect($c);
         
         foreach ($countries as $countrie){    
             
             $iso = $countrie->getIsoA2();
             
         
             
             if($countrie->getContinent()=="E"){
                 
                 if(in_array($iso,$ue_countries_array)){
                     $countries_array['UE'][$iso]['name'] = $countrie->getName();
                     
                     if(in_array($iso, $selected_countries)){
                        $countries_array['UE'][$iso]["is_selected"] = 1;    
                     }
                            
                 }else{
                     $countries_array['E'][$iso]['name'] = $countrie->getName();
                     if(in_array($iso, $selected_countries)){
                        $countries_array['E'][$iso]["is_selected"] = 1;    
                     }
                 }
                 
             }elseif($countrie->getContinent()=="SA"){
                 $countries_array['SA'][$iso]['name'] = $countrie->getName();
                 if(in_array($iso, $selected_countries)){
                        $countries_array['SA'][$iso]["is_selected"] = 1;    
                 }
             }elseif($countrie->getContinent()=="NA"){
                 $countries_array['NA'][$iso]['name'] = $countrie->getName();
                 if(in_array($iso, $selected_countries)){
                        $countries_array['NA'][$iso]["is_selected"] = 1;    
                 }
             }elseif($countrie->getContinent()=="AS"){
                 $countries_array['AS'][$iso]['name'] = $countrie->getName();
                 if(in_array($iso, $selected_countries)){
                        $countries_array['AS'][$iso]["is_selected"] = 1;    
                 }
             }elseif($countrie->getContinent()=="AO"){
                 $countries_array['AO'][$iso]['name'] = $countrie->getName();
                 if(in_array($iso, $selected_countries)){
                        $countries_array['AO'][$iso]["is_selected"] = 1;    
                 }
             }elseif($countrie->getContinent()=="AF"){
                 $countries_array['AF'][$iso]['name'] = $countrie->getName();
                 if(in_array($iso, $selected_countries)){
                        $countries_array['AF'][$iso]["is_selected"] = 1;    
                 }
             }

         }

        // echo "<pre>";
        // print_r($countries_array);
//         
        // die();
        
        $this->countries = $countries_array;
        $this->section = $section;
           
    }

    public function executeProductConfig()
    {
        $request = $this->getRequest();

        $product_id = $request->getParameter('product_id');

        $this->product = ProductPeer::retrieveByPK($product_id);

        $this->product->setCulture($request->getParameter('culture', stLanguage::getOptLanguage()));  

        if ($request->getMethod() == sfRequest::POST)
        {
            $product_config = $request->getParameter('product_config');
            $this->product->setIsService(isset($product_config['is_service']));
            $this->product->save();

            $i18n = $this->getContext()->getI18n();
            $this->setFlash('notice', $i18n->__('Twoje zmiany zostały zapisane', null, 'stAdminGeneratorPlugin'));

            return $this->redirect('@stCompatibilityPlugin?action=productConfig&product_id='.$product_id.'&culture='.$this->product->getCulture());
        }
    }
}