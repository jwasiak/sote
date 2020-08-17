<?php 

class stBackendComponents extends sfComponents {

    public function executeMenu() {
        $this->items = sfConfig::get('app_navigation_bar_display');
        $this->inverted = false;
        $this->first_call = true;
    }

    public function executeAbuseInformation() {
        
    }

    public function executeUpdateInfo()
    {
        $version = trim(file_get_contents("http://pear.sote.pl/Chiara_PEAR_Server_REST/r/soteshop/stable.txt"));

        $this->has_valid_license = stCommunication::hasValidLicense();
        
        $this->update = version_compare(stRegisterSync::getPackageVersion('soteshop'), $version, '<');
    }

    public function executePopupInfo() {
        $context = $this->getContext();

        $this->isOpen = stLicense::isOpen();

        $productsCount = ProductPeer::doCount(new Criteria);
        $this->hasId = (bool)$context->getRequest()->getParameter('id', null);
        $this->productsLimit = stLimits::getLimit();
        $this->sProductsLimit = number_format($this->productsLimit, 0, ',', ' ');

        if ($context->getModuleName() == 'stProduct' && $context->getActionName() == 'edit' && $productsCount >= $this->productsLimit)
            $this->showProductAddInfo = true;
        else
            $this->showProductAddInfo = false;
    }
    
    public function executeHelpInfo()
    {
                
    }
}
