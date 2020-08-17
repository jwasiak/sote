<?php

class stCompatibilityListener 
{
    public static function append(sfEvent $event, $components) 
    {
        $config = stConfig::getInstance(sfContext::getInstance(), 'stCompatibilityBackend');
        switch ($event['slot']) 
        {
          
            case 'user_before_order_fieldset_billing':
            case 'user_create_account_before_fieldset':
            case 'newsletter_add_before_fieldset':
                $components[] = $event->getSubject()->createComponent('stCompatibilityFrontend', 'showFrUserElements');
                break;
        }
        
        $config = stConfig::getInstance(sfContext::getInstance(), 'stCompatibilityBackend');

        if ($config->get('cookies_info_on') && ($event['slot'] == 'base_footer' ||  $event['slot'] == 'base-footer')) 
        {
            $components[] = $event->getSubject()->createComponent('stCompatibilityFrontend', 'showCookiesInfo');
            
        }
        
         $datetime1 = new DateTime($config -> get('change_terms_cookie_time'));
         $datetime2 = new DateTime(date('Ymd'));                                
         $interval = $datetime2->diff($datetime1);                                
         
         $show_message = 0;
                                
         if($config -> get('change_terms_on') == 1 && $config -> get('change_terms_cookie_time') >= date('Ymd')){
             $show_message = 1;
         }                                            
        
        if ($show_message == 1 && $event['slot'] == 'base-footer')        
        {
            $components[] = $event->getSubject()->createComponent('stCompatibilityFrontend', 'showChangeTermsInfo');
            
        }
        
        if ($config->get('mode_de') && ($event['slot'] == 'base_footer' ||  $event['slot'] == 'base-footer')) 
        {
            
            $components[] = $event->getSubject()->createComponent('stCompatibilityFrontend', 'showPriceDescInFooter');
        }

        return $components;
    }

    public static function postExecuteOrderSave(sfEvent $event) {
        if ($event->getSubject()->getRequestParameter('user_data_billing[opinion]') || !stConfig::getInstance('stCompatibilityBackend')->get('basket_opinion_show')) {
            $order = $event->getSubject()->order;
            $order->setShowOpinion(true);
            $order->save();
        }
    }
}
