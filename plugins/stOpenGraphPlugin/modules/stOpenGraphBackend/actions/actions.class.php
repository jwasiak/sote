<?php
/** 
 * SOTESHOP/stOpenGraphPlugin
 * 
 * 
 * @package     stOpenGraphPlugin
 * @author      Bartosz Alejski <bartosz.alejski@sote.pl>
 */
class stOpenGraphBackendActions extends stActions
{
     
   public function executeOpenGraphConfig()
   {
        $this->config = stConfig::getInstance($this->getContext(), 'stOpenGraphBackend');        
        $this->config->setCulture($this->getRequestParameter('culture', stLanguage::getOptLanguage()));
                
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
          

            $this->config->set('text', strip_tags($this->getRequestParameter('og[text]')), true);            
            $this->config->set('title', strip_tags($this->getRequestParameter('og[title]')), true); 
              
              if ($this->getRequest()->getFileSize('og[image]'))
              {
                 $currentFile = sfConfig::get('sf_upload_dir') . $this->config->get('image', null, true); 
                  
                 $fileName = md5($this->getRequest()->getFileName('og[image]') . time() . rand(0, 99999));
                 $ext = $this->getRequest()->getFileExtension('og[image]');
                 if (is_file($currentFile))
                 {
                    unlink($currentFile);
                 }
                
                 $this->config->set('image', "/picture/" . $this->getRequestParameter('culture', stLanguage::getOptLanguage()) . '/' . $fileName . $ext, true);        
                 $this->getRequest()->moveFile('og[image]', sfConfig::get('sf_upload_dir') . $this->config->get('image', null, true));
              }

            $this->config->save(true);
                        
            
            
            stFastCacheManager::clearCache();
            foreach (glob(sfConfig::get('sf_root_dir').'/cache/smarty_c/*') as $file)
            {unlink($file);}
            
            $this->setFlash('notice', 'Twoje zmiany zostały zapisane');
            $this->redirect('stOpenGraphBackend/openGraphConfig?culture='.$this->getRequestParameter('culture', stLanguage::getOptLanguage()));            
        }
    }

   public function executeDeleteImage()
   {       
        $this->config = stConfig::getInstance($this->getContext(), 'stOpenGraphBackend');        
        $this->config->setCulture($this->getRequestParameter('culture', stLanguage::getOptLanguage()));                
        
        $this->config->set('image', "", true);            

        $this->config->save(true);
            
        stFastCacheManager::clearCache();
        foreach (glob(sfConfig::get('sf_root_dir').'/cache/smarty_c/*') as $file)
        {unlink($file);}
        
        $this->setFlash('notice', 'Twoje zmiany zostały zapisane');
        $this->redirect('stOpenGraphBackend/openGraphConfig?culture='.$this->getRequestParameter('culture', stLanguage::getOptLanguage()));            
       
    }

}