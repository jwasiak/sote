<?php

class appProductAttributeFrontendActions extends stActions 
{
   public function executeFilter()
   {
      if ($this->getRequest()->getMethod() == sfRequest::POST)
      {
         $this->getUser()->setParameter('selected', CategoryPeer::retrieveByPK($this->getRequestParameter('category_id')), 'soteshop/stCategory');
         $app_product_filter = $this->getRequestParameter('app_product_filter');

         appProductAttributeHelper::setFilters($this->getContext(), $app_product_filter);         

         stFastCacheController::disable();
      }

      $return_url = appProductAttributeHelper::getFilterUrl($this->getRequest()->getReferer());

      return $this->redirect($return_url);
   }

   public function executeClearFilter()
   {
      $this->getUser()->setParameter('selected', CategoryPeer::retrieveByPK($this->getRequestParameter('category_id')), 'soteshop/stCategory');
      appProductAttributeHelper::clearFilters($this->getContext());

      return $this->redirect($this->getRequest()->getReferer());
   }
}