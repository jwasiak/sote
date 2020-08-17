<?php
class stTrustListener
{    

    /** 
     * Podpięcie zdarzenia dla generatora produktu
     *
     * @param       sfEvent     $event
     */
    public static function generate(sfEvent $event)
    {
        // możemy wywoływać podaną metodę wielokrotnie co powoduje dołączenie kolejnych plików
        $event->getSubject()->attachAdminGeneratorFile('stTrustPlugin', 'stProduct.yml');

    }
    
        /**
     * Zapisywanie id produktu oraz typu
     *
     * @param sfEvent $event
     */
    public static function preSaveProduct(sfEvent $event)
    {
        $action = $event->getSubject();
        
        $event['modelInstance']->setProductId($event->getSubject()->forward_parameters['product_id']);            
                
        
        if (sfContext::getInstance()->getRequest()->getFileSize('trust[icon_f]'))
        {
             $currentFile = sfConfig::get('sf_upload_dir') . $action->trust->getIconF(); 
         
         $fileName = md5(sfContext::getInstance()->getRequest()->getFileName('trust[icon_f]') . time() . rand(0, 99999));
         $ext = sfContext::getInstance()->getRequest()->getFileExtension('trust[icon_f]');
         if (is_file($currentFile))
         {
            unlink($currentFile);
         }
         
        $action->trust->setIconF("/picture/" . $action->getRequestParameter('culture', stLanguage::getOptLanguage()) . '/' . $fileName . $ext);        
        sfContext::getInstance()->getRequest()->moveFile('trust[icon_f]', sfConfig::get('sf_upload_dir') . $action->trust->getIconF());
        }
        
        if (sfContext::getInstance()->getRequest()->getFileSize('trust[icon_s]'))
        {
             $currentFile = sfConfig::get('sf_upload_dir') . $action->trust->getIconS(); 
         
         $fileName = md5(sfContext::getInstance()->getRequest()->getFileName('trust[icon_s]') . time() . rand(0, 99999));
         $ext = sfContext::getInstance()->getRequest()->getFileExtension('trust[icon_s]');
         if (is_file($currentFile))
         {
            unlink($currentFile);
         }
         
        $action->trust->setIconS("/picture/" . $action->getRequestParameter('culture', stLanguage::getOptLanguage()) . '/' . $fileName . $ext);        
        sfContext::getInstance()->getRequest()->moveFile('trust[icon_s]', sfConfig::get('sf_upload_dir') . $action->trust->getIconS());
        }
        
        if (sfContext::getInstance()->getRequest()->getFileSize('trust[icon_t]'))
        {
             $currentFile = sfConfig::get('sf_upload_dir') . $action->trust->getIconT(); 
         
         $fileName = md5(sfContext::getInstance()->getRequest()->getFileName('trust[icon_t]') . time() . rand(0, 99999));
         $ext = sfContext::getInstance()->getRequest()->getFileExtension('trust[icon_t]');
         if (is_file($currentFile))
         {
            unlink($currentFile);
         }
         
        $action->trust->setIconT("/picture/" . $action->getRequestParameter('culture', stLanguage::getOptLanguage()) . '/' . $fileName . $ext);        
        sfContext::getInstance()->getRequest()->moveFile('trust[icon_t]', sfConfig::get('sf_upload_dir') . $action->trust->getIconT());
        }
        
        stFastCacheManager::clearCache();        
            
    }

    /**
     * Ładowanie obiektu pozycjonowania dla produktu
     *
     * @param sfEvent $event
     */
    public static function preGetOrCreateProduct(sfEvent $event)
    {

        $event->setProcessed(true);

        $action = $event->getSubject();

        $c = new Criteria();
        
        $c->add(TrustPeer::PRODUCT_ID, $action->forward_parameters['product_id']);

        $action->trust = TrustPeer::doSelectOne($c);

        if (!$action->trust)
        {
            $action->trust = new Trust();

            $action->trust->setProductId($action->forward_parameters['product_id']);
        }
        
        $action->trust->getProduct()->setCulture($action->getRequestParameter('culture', stLanguage::getOptLanguage()));
        
    }

}
?>
