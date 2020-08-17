<?php

class stGoogleShoppingBackendComponents extends autostGoogleShoppingBackendComponents {
    
    public function executeGenerateXml() {
        $this->generate = false;
        if ($this->getRequest()->hasParameter('generate')) $this->generate = true;
        
        $stGoogleShopping = new stGoogleShopping();
        $this->steps = $stGoogleShopping->getStepsCount();
    }
}
