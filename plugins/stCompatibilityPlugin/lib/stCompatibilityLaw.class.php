<?php

class stCompatibilityLaw {

    const DE = 'de';

    const FR = 'fr';

    protected static $show = array();

    public static function show($language) {
        if (!isset(self::$show[$language]))  {
            $config = stConfig::getInstance('stCompatibilityBackend');
            $userLanguage = sfContext::getInstance()->getUser()->getCulture();
            list($userLanguage, ) = explode('_', strtolower($userLanguage));

            if ($language == $userLanguage && $config->get('mode_'.$userLanguage)) return self::$show[$language] = true;
            return self::$show[$language] = false;
        }

        return self::$show[$language];
    }
    
    public static function isSection($section,$lang=null){
        
        $config = stConfig::getInstance(sfContext::getInstance(), 'stCompatibilityBackend');
        
        $selected_countries = unserialize($config->get($section));
        $page_language = sfContext::getInstance()->getUser()->getCulture();
        
        $lang_country = array('ar' => 'SA', 'bg'=>'BG','da'=>'DK','el'=>'GR','et'=>'EE','fi'=>'FI','he'=>'IL','hr'=>'HR','hu'=>'HU','ja'=>'JP','ko'=>'KP',
        'lt'=>'LT','lv'=>'LV','nl'=>'NL','ro'=>'RO','sl'=>'SI','sv'=>'SE','tr'=>'TR','pl_PL'=>'PL','en_US'=>'GB','cs'=>'CZ','de'=>'DE','es'=>'ES','fr'=>'FR',
        'it'=>'IT','no'=>'NO','pt'=>'PT','ru'=>'RU','sk'=>'SK','zh'=>'CN');
        
        if(isset($lang)){
            if(in_array($lang, $selected_countries)){
                return true;    
            }
        }elseif(sfContext::getInstance()->getUser()->isAuthenticated()){
            
          
            
            $c = new Criteria();
            $c->add(UserDataPeer::SF_GUARD_USER_ID, sfContext::getInstance()->getUser()->getGuardUser()->getId());
            $c->add(UserDataPeer::IS_BILLING, 1);
            $c->add(UserDataPeer::IS_DEFAULT, 1);
            $userData = UserDataPeer::doSelectOne($c);
            
            if($userData){

                if(in_array(stCompatibilityLaw::getIsoCountry($userData->getCountriesId()), $selected_countries)){
                    return true;    
                    
                }
                
            }else{
                if(in_array($lang_country[$page_language], $selected_countries)){
                    return true;    
                }   
            }

        }else{
            if(in_array($lang_country[$page_language], $selected_countries)){
                return true;    
            }
        }
        
        return false;
            
    }    

    public static function getIsoCountry($id){
        $c = new Criteria();
        $c->add(CountriesPeer::ID,$id);
        $country = CountriesPeer::doSelectOne($c);
        if($country){
            return $country->getIsoA2();
        }
    }
    
    public static function isBasketHasProductService($basket) {
        foreach ($basket->getItems() as $product){
            if (is_object($product->getProduct())){
                if($product->getProduct()->getIsService()==1)
                {
                    return TRUE;
                }
            }
            
        }
        return FALSE;
    }

}
