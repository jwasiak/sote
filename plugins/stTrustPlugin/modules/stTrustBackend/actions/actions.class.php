<?php
/** 
 * SOTESHOP/stTrustPlugin
 * 
 * 
 * @package     stTrustPlugin
 * @author      Bartosz Alejski <bartosz.alejski@sote.pl>
 */
class stTrustBackendActions extends autoStTrustBackendActions
{
     
   public function executeConfig()
   {
      $this->config = stConfig::getInstance('stTrustBackend');        
      $this->config->setCulture($this->getRequestParameter('culture', stLanguage::getOptLanguage()));
      
      if ($this->getRequest()->getMethod() == sfRequest::POST)
      {
         $this->updateConfigFromRequest();
         $this->config->save(true);

         stFastCacheManager::clearCache();
         foreach (glob(sfConfig::get('sf_root_dir').'/cache/smarty_c/*') as $file)
         {
            unlink($file);
         }
      
         $this->setFlash('notice', 'Twoje zmiany zostały zapisane');                  
         $this->redirect('stTrustBackend/config?culture='.$this->getRequestParameter('culture', stLanguage::getOptLanguage()));
         
      }
   }

   public function updateConfigFromRequest()
   {
      $this->config->set('field_on', $this->getRequestParameter('trust[field_on]'));            
      $this->config->set('field_description', $this->getRequestParameter('trust[field_description]'), true);            
                  
      $this->config->set('field_1_on', $this->getRequestParameter('trust[field_1_on]'));
      $this->config->set('field_label_1', $this->getRequestParameter('trust[field_label_1]'), true);            
      $this->config->set('field_sub_label_1', $this->getRequestParameter('trust[field_sub_label_1]'), true);
      $this->config->set('field_description_1', $this->getRequestParameter('trust[field_description_1]'), true);
      
      if ($this->getRequest()->getFileSize('trust[icon_1]'))
      {
         $currentFile = sfConfig::get('sf_upload_dir') . $this->config->get('icon_1', null, true); 
         
         $fileName = md5($this->getRequest()->getFileName('trust[icon_1]') . time() . rand(0, 99999));
         $ext = $this->getRequest()->getFileExtension('trust[icon_1]');
         if (is_file($currentFile))
         {
            unlink($currentFile);
         }
         
         $this->config->set('icon_1', "/picture/" . $this->getRequestParameter('culture', stLanguage::getOptLanguage()) . '/' . $fileName . $ext, true);        
         $this->getRequest()->moveFile('trust[icon_1]', sfConfig::get('sf_upload_dir') . $this->config->get('icon_1', null, true));
      }
      
      $this->config->set('field_2_on', $this->getRequestParameter('trust[field_2_on]'));
      $this->config->set('field_label_2', $this->getRequestParameter('trust[field_label_2]'), true);            
      $this->config->set('field_sub_label_2', $this->getRequestParameter('trust[field_sub_label_2]'), true);
      $this->config->set('field_description_2', $this->getRequestParameter('trust[field_description_2]'), true);
      
      if ($this->getRequest()->getFileSize('trust[icon_2]'))
      {
         $currentFile = sfConfig::get('sf_upload_dir') . $this->config->get('icon_2', null, true); 
         
         $fileName = md5($this->getRequest()->getFileName('trust[icon_2]') . time() . rand(0, 99999));
         $ext = $this->getRequest()->getFileExtension('trust[icon_2]');
         if (is_file($currentFile))
         {
            unlink($currentFile);
         }
         
         $this->config->set('icon_2', "/picture/" . $this->getRequestParameter('culture', stLanguage::getOptLanguage()) . '/' . $fileName . $ext, true);        
         $this->getRequest()->moveFile('trust[icon_2]', sfConfig::get('sf_upload_dir') . $this->config->get('icon_2', null, true));
      }

      
      $this->config->set('field_3_on', $this->getRequestParameter('trust[field_3_on]'));
      $this->config->set('field_label_3', $this->getRequestParameter('trust[field_label_3]'), true);            
      $this->config->set('field_sub_label_3', $this->getRequestParameter('trust[field_sub_label_3]'), true);
      $this->config->set('field_description_3', $this->getRequestParameter('trust[field_description_3]'), true);
      
      if ($this->getRequest()->getFileSize('trust[icon_3]'))
      {
         $currentFile = sfConfig::get('sf_upload_dir') . $this->config->get('icon_3', null, true); 
         
         $fileName = md5($this->getRequest()->getFileName('trust[icon_3]') . time() . rand(0, 99999));
         $ext = $this->getRequest()->getFileExtension('trust[icon_3]');
         if (is_file($currentFile))
         {
            unlink($currentFile);
         }
         
         $this->config->set('icon_3', "/picture/" . $this->getRequestParameter('culture', stLanguage::getOptLanguage()) . '/' . $fileName . $ext, true);        
         $this->getRequest()->moveFile('trust[icon_3]', sfConfig::get('sf_upload_dir') . $this->config->get('icon_3', null, true));
      }
   }

   public function validateConfig()
   {
      $i18n = $this->getContext()->getI18N();
      $data = $this->getRequestParameter('trust');

      $labelValidator = new sfStringValidator();
      $labelValidator->initialize($this->getContext(), array(
         'max' => 13,
         'max_error' => $i18n->__('Długość tekstu nie może przekraczać %max% znaków', array('%max%' => 13)),
      ));

      foreach (array('field_label_1', 'field_label_2', 'field_label_3', 'field_sub_label_1', 'field_sub_label_2', 'field_sub_label_3') as $name)
      {
         if ($data[$name] && !$labelValidator->execute($data[$name], $error))
         {
            $this->getRequest()->setError('trust{' . $name . '}', $error);
         }
      }

      return !$this->getRequest()->hasErrors();
   }

   public function handleErrorConfig()
   {
      $this->config = stConfig::getInstance('stTrustBackend');        
      $this->config->setCulture($this->getRequestParameter('culture', stLanguage::getOptLanguage()));

      if ($this->getRequest()->getMethod() == sfRequest::POST)
      {
         $this->updateConfigFromRequest();
      }

      return sfView::SUCCESS;
   }

   public function executeDeleteImage()
   {
      $config = stConfig::getInstance('stTrustBackend');   
      $config->setCulture($this->getRequestParameter('culture', stLanguage::getOptLanguage()));
      $image = $this->getRequestParameter('image');

      if (in_array($image, array('icon_1', 'icon_2', 'icon_3')))
      {
         $file = sfConfig::get('sf_upload_dir') . $config->get($image, null, true);

         if (is_file($file) && unlink($file))
         {
            unlink($file);

            $i18n = $this->getContext()->getI18N();

            $this->setFlash('notice', $i18n->__('Ikona została usunięta'));

            $config->set($image, null, true);

            $config->save(true);
         }
      }
      else
      {
         $this->setFlash('warning', $i18n->__('Wystąpił bład podczas próby usuwania ikony'));
      }

      return $this->redirect($this->getRequest()->getReferer());
   }
   
   
    public function executeDeleteProductImage()
   {
      
        $i18n = $this->getContext()->getI18N();
      
        $c = new Criteria();         
        $c->add(TrustPeer::PRODUCT_ID, $this->getRequestParameter('product_id'));                 
        $trust = TrustPeer::doSelectWithI18n($c);                                

        if($trust){
            $trust = $trust[0];     
        }
        
        $trust->setCulture($this->getRequestParameter('culture', stLanguage::getOptLanguage()));
      
      // echo "<pre>";
      // print_r($trust);
      // echo $trust->getIconF();
//       
      // die();
      
      $image = $this->getRequestParameter('image');      

      if (in_array($image, array('icon_f', 'icon_s', 'icon_t')))
      {
          
          if($image=="icon_f"){
            $icon = $trust->getIconF();    
          }
          
          if($image=="icon_s"){
            $icon = $trust->getIconS();    
          }
          
          if($image=="icon_t"){
            $icon = $trust->getIconT();    
          }
          
          
         $file = sfConfig::get('sf_upload_dir') . $icon;

         if (is_file($file) && unlink($file))
         {
              unlink($file);

              $i18n = $this->getContext()->getI18N();

              $this->setFlash('notice', $i18n->__('Ikona została usunięta'));

              if($image=="icon_f"){
                $trust->setIconF(null);    
              }
              
              if($image=="icon_s"){
                $trust->setIconS(null);    
              }
              
              if($image=="icon_t"){
                $trust->setIconT(null);    
              }
    
              $trust->save();
         }
      }
      else
      {
         $this->setFlash('warning', $i18n->__('Wystąpił bład podczas próby usuwania ikony'));
      }

      return $this->redirect($this->getRequest()->getReferer());
   }
    
}