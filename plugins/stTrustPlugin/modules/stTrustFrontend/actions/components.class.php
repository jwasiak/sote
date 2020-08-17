<?php
/** 
 * SOTESHOP/stTrustPlugin
 * 
 * 
 * @package     stTrustPlugin
 * @author      Bartosz Alejski <bartosz.alejski@sote.pl>
 */
class stTrustFrontendComponents extends sfComponents {
     
   public function executeShow()
   {
       $smarty = new stSmarty('stTrustFrontend');

        $config = stConfig::getInstance($this->getContext(), 'stTrustBackend');        
        $config->setCulture($this->getUser()->getCulture());    
        
        $c = new Criteria();         
        $c->add(TrustPeer::PRODUCT_ID, $this->product->getID());         
        $trust = TrustPeer::doSelectWithI18n($c);                                
        
        if($trust){
            $trust = $trust[0];             
        
        if($config->get('field_on')==1 || $trust->getFieldOn()==1){
        
            if($trust->getFieldOn()==1){
                $smarty->assign("field_description", $trust->getFieldDescription());
                $smarty->assign("field_on", $trust->getFieldOn());
            }else{
                $smarty->assign("field_description", $config->get('field_description', null, true));
                $smarty->assign("field_on", $config->get('field_on'));
            }                        
        }
        
        
        if($config->get('field_1_on')==1 || $trust->getFieldFOn()==1){
        
            if($trust->getFieldFOn()==1){
                $smarty->assign("field_1_on", $trust->getFieldFOn());
                $smarty->assign("field_label_1", $trust->getFieldLabelF());
                $smarty->assign("field_sub_label_1", $trust->getFieldSubLabelF());
                $smarty->assign("field_description_1", $trust->getFieldDescriptionF());
                
                if($trust->getIconF()!=""){
                    $smarty->assign("icon_1", $trust->getIconF());
                }else{
                    $smarty->assign("icon_1", $config->get('icon_1', null, true));
                }
                
                
            }else{
                $smarty->assign("field_1_on", $config->get('field_1_on'));
                $smarty->assign("field_label_1", $config->get('field_label_1', null, true));
                $smarty->assign("field_sub_label_1", $config->get('field_sub_label_1', null, true));
                $smarty->assign("field_description_1", $config->get('field_description_1', null, true));
                $smarty->assign("icon_1", $config->get('icon_1', null, true));   
            }
        
        }
       
        if($config->get('field_2_on')==1 || $trust->getFieldSOn()==1){
        
            if($trust->getFieldSOn()==1){
                $smarty->assign("field_2_on", $trust->getFieldSOn());
                $smarty->assign("field_label_2", $trust->getFieldLabelS());
                $smarty->assign("field_sub_label_2", $trust->getFieldSubLabelS());
                $smarty->assign("field_description_2", $trust->getFieldDescriptionS());
                
                if($trust->getIconS()!=""){
                    $smarty->assign("icon_2", $trust->getIconS());
                }else{
                    $smarty->assign("icon_2", $config->get('icon_2', null, true));
                }
                
            }else{
                $smarty->assign("field_2_on", $config->get('field_2_on'));
                $smarty->assign("field_label_2", $config->get('field_label_2', null, true));
                $smarty->assign("field_sub_label_2", $config->get('field_sub_label_2', null, true));
                $smarty->assign("field_description_2", $config->get('field_description_2', null, true));
                $smarty->assign("icon_2", $config->get('icon_2', null, true));   
            }
        
        }

        if($config->get('field_3_on')==1 || $trust->getFieldTOn()==1){
        
            if($trust->getFieldTOn()==1){
                $smarty->assign("field_3_on", $trust->getFieldTOn());
                $smarty->assign("field_label_3", $trust->getFieldLabelT());
                $smarty->assign("field_sub_label_3", $trust->getFieldSubLabelT());
                $smarty->assign("field_description_3", $trust->getFieldDescriptionT());
                
                if($trust->getIconT()!=""){
                    $smarty->assign("icon_3", $trust->getIconT());
                }else{
                    $smarty->assign("icon_3", $config->get('icon_3', null, true));
                }
                
            }else{
                $smarty->assign("field_3_on", $config->get('field_3_on'));
                $smarty->assign("field_label_3", $config->get('field_label_3', null, true));
                $smarty->assign("field_sub_label_3", $config->get('field_sub_label_3', null, true));
                $smarty->assign("field_description_3", $config->get('field_description_3', null, true));
                $smarty->assign("icon_3", $config->get('icon_3', null, true));
            }
        
        }

        }else{
                $smarty->assign("field_description", $config->get('field_description', null, true));
                $smarty->assign("field_on", $config->get('field_on'));
                
                $smarty->assign("field_1_on", $config->get('field_1_on'));
                $smarty->assign("field_label_1", $config->get('field_label_1', null, true));
                $smarty->assign("field_sub_label_1", $config->get('field_sub_label_1', null, true));
                $smarty->assign("field_description_1", $config->get('field_description_1', null, true));
                $smarty->assign("icon_1", $config->get('icon_1', null, true));
            
                $smarty->assign("field_2_on", $config->get('field_2_on'));
                $smarty->assign("field_label_2", $config->get('field_label_2', null, true));
                $smarty->assign("field_sub_label_2", $config->get('field_sub_label_2', null, true));
                $smarty->assign("field_description_2", $config->get('field_description_2', null, true));
                $smarty->assign("icon_2", $config->get('icon_2', null, true));  
            
                $smarty->assign("field_3_on", $config->get('field_3_on'));
                $smarty->assign("field_label_3", $config->get('field_label_3', null, true));
                $smarty->assign("field_sub_label_3", $config->get('field_sub_label_3', null, true));
                $smarty->assign("field_description_3", $config->get('field_description_3', null, true));
                $smarty->assign("icon_3", $config->get('icon_3', null, true));
            
        }

        return $smarty;
  
    }
    
}