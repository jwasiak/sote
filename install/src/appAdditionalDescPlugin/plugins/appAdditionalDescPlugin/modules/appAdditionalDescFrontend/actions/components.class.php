<?php
/*
 * @author  Krzysztof Bebło <krzysztof.beblo@sote.pl>
 */
class appAdditionalDescFrontendComponents extends sfComponents
{
    public function executeShow()
    {
        $config =  stConfig::getInstance(sfContext::getInstance(), 'appAdditionalDescBackend');
        if (!($config->get('desc2_on')) || ($config->get('desc2_position')!=$this->position))
        {
            return sfView::NONE;
        }
        
        $this->smarty = new stSmarty('appAdditionalDescFrontend');
        $product = sfContext::getInstance()->getActionStack()->getLastEntry()->getActionInstance()->product;
        $this->description2 = $product->getDescription2();     
    }
    
        public function executeShowRight()
    {
        $config =  stConfig::getInstance(sfContext::getInstance(), 'appAdditionalDescBackend');
        if (!($config->get('desc2_on')) || ($config->get('desc2_position')!='right'))
        {
            return sfView::NONE;
        }
        
        $this->smarty = new stSmarty('appAdditionalDescFrontend');
        $product = sfContext::getInstance()->getActionStack()->getLastEntry()->getActionInstance()->product;
        $this->description2 = $product->getDescription2();
    }
}