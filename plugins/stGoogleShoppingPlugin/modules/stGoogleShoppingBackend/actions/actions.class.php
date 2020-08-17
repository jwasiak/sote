<?php

class stGoogleShoppingBackendActions extends autostGoogleShoppingBackendActions {
    
    protected function updateConfigFromRequest() {
        $config = $this->getRequestParameter('config');
        foreach (stGoogleShopping::getAvailabilities() as $availability)
            $this->config->set('availability_'.$availability->getId(), $config['availability_'.$availability->getId()]);
        parent::updateConfigFromRequest();
    }

     protected function saveConfig() 
    {      
        parent::saveConfig();

        stFunctionCache::clearFrontendModule('stProduct', 'product');
        stTheme::clearSmartyCache(true);
        stFastCacheManager::clearCache();
    }


    public function executeProductEnable() {
        $list = $this->getRequestParameter('google_shopping[selected]', array());
        foreach ($list as $id) {
            $c = new Criteria();
            $c->add(GoogleShoppingPeer::PRODUCT_ID, $id);
            $object = GoogleShoppingPeer::doSelectOne($c);
            if (!$object) {
                $object = new GoogleShopping();
                $object->setProductId($id);
            }
            $object->setActive(true);
            $object->save();
        }

        return $this->redirect('stGoogleShoppingBackend/list?page='.$this->getRequestParameter('page', 1));
    }

    public function executeProductDisable() {
        $list = $this->getRequestParameter('google_shopping[selected]', array());
        foreach ($list as $id) {
            $c = new Criteria();
            $c->add(GoogleShoppingPeer::PRODUCT_ID, $id);
            $object = GoogleShoppingPeer::doSelectOne($c);
            if (!$object) {
                $object = new GoogleShopping();
                $object->setProductId($id);
            }
            $object->setActive(false);
            $object->save();
        }

        return $this->redirect('stGoogleShoppingBackend/list?page='.$this->getRequestParameter('page', 1));
    }
    
      protected function addFiltersCriteria($c)
  {
    if (isset($this->filters['code_is_empty']))
    {
      $criterion = $c->getNewCriterion(ProductPeer::CODE, '');
      $criterion->addOr($c->getNewCriterion(ProductPeer::CODE, null, Criteria::ISNULL));
      $c->add($criterion);
    }
    else if (isset($this->filters['code']) && $this->filters['code'] !== '')
    {
        if (method_exists($this, 'filterCriteriaByProductCode'))
        {
            $filter_anyway = !$this->filterCriteriaByProductCode($c, $this->filters['code']);
        }   
        else
        {
            $filter_anyway = true;
        }  
  
        if ($filter_anyway)
        {
            $c->add(ProductPeer::CODE, '%' . $this->filters['code'] . '%', Criteria::LIKE);
        }
    }
    if (isset($this->filters['product_is_empty']))
    {
      $criterion = $c->getNewCriterion(ProductPeer::OPT_NAME, '');
      $criterion->addOr($c->getNewCriterion(ProductPeer::OPT_NAME, null, Criteria::ISNULL));
      $c->add($criterion);
    }
    else if (isset($this->filters['product']) && $this->filters['product'] !== '')
    {
        if (method_exists($this, 'filterCriteriaByProductOptName'))
        {
            $filter_anyway = !$this->filterCriteriaByProductOptName($c, $this->filters['product']);
        }   
        else
        {
            $filter_anyway = true;
        }  
  
        if ($filter_anyway)
        {
            $c->add(ProductPeer::OPT_NAME, '%' . $this->filters['product'] . '%', Criteria::LIKE);
        }
    }
    if (isset($this->filters['active_is_empty']))
    {
      $criterion = $c->getNewCriterion(GoogleShoppingPeer::ACTIVE, '');
      $criterion->addOr($c->getNewCriterion(GoogleShoppingPeer::ACTIVE, null, Criteria::ISNULL));
      $c->add($criterion);
    }
    else if (isset($this->filters['active']) && $this->filters['active'] !== '')
    {
        if($this->filters['active']==null || $this->filters['active']==0){        
            $criterion = $c->getNewCriterion(GoogleShoppingPeer::ACTIVE, '');
            $criterion->addOr($c->getNewCriterion(GoogleShoppingPeer::ACTIVE, null, Criteria::ISNULL));
            $c->add($criterion);              
        }
        
        if($this->filters['active']==1){        
            $c->add(GoogleShoppingPeer::ACTIVE, $this->filters['active']);   
        }
      
    }
    $this->getDispatcher()->notify(new sfEvent($this, 'autoStGoogleShoppingBackendActions.addFiltersCriteria', array('criteria' => $c)));
  }

    public function executeAddAll() {

        $c = new Criteria();        
        $criterion = $c->getNewCriterion(GoogleShoppingPeer::ACTIVE,1);
        $criterion->addOr($c->getNewCriterion(GoogleShoppingPeer::ACTIVE,0));
        $c->add($criterion);
        GoogleShoppingPeer::doDelete($c);
        
        $con = Propel::getConnection();
        $results = $con->executeQuery("INSERT INTO `st_google_shopping`( `product_id`, `active`) (SELECT id, 1 FROM st_product WHERE active = 1)");        

        return $this->redirect('stGoogleShoppingBackend/list?page='.$this->getRequestParameter('page', 1));
    }
    
    public function executeDeleteAll() {
        
        $c = new Criteria();        
        $criterion = $c->getNewCriterion(GoogleShoppingPeer::ACTIVE,1);
        $criterion->addOr($c->getNewCriterion(GoogleShoppingPeer::ACTIVE,0));
        $c->add($criterion);
        GoogleShoppingPeer::doDelete($c);
        
                      
        return $this->redirect('stGoogleShoppingBackend/list?page='.$this->getRequestParameter('page', 1));
    }
}
