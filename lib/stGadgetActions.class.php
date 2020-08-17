<?php
class stGadgetActions extends stActions
{
   protected $_gadgets = array();

   public function preExecute()
   {
      $this->setLayout('layout_gadget');

      $gadget = $this->getGadget();

      sfLoader::loadHelpers(array('Helper','stBackend'));

      if ($gadget)
      {
         $refresh = $gadget->getConfigurationParameter('refresh', false);

         $cache = $this->getRequestParameter('cache', true);

         $refreshed_at = $this->getRequestParameter('refreshed_at');

         if ($refreshed_at && $refreshed_at != $gadget->getRefreshedAt())
         {
            $gadget->setRefreshedAt($refreshed_at);

            $gadget->save();
         }

         if ($cache && $refresh && $gadget->getRefreshBy() > 0)
         {
            $this->setResponseMaxAge($gadget->getRefreshBy());
         }
         else
         {
            $this->getResponse()->setHttpHeader('Cache-Control', 'no-cache');
         }
      }

      parent::preExecute();
   }
   
   protected function setResponseMaxAge($max_age)
   {
      $response = $this->getResponse();

      $response->setHttpHeader('Cache-Control', '');

      $response->addCacheControlHttpHeader('private');
      
      $response->addCacheControlHttpHeader('must-revalidate');      
      
      $response->addCacheControlHttpHeader('max-age', $max_age);
      
      $response->addCacheControlHttpHeader('s-maxage', $max_age);

      $response->setHttpHeader('Expires', false);

      $response->setHttpHeader('Pragma', false);      
   }

   /**
    * @return DashboardGadget
    * @throws sfException
    */
   protected function getGadget()
   {
      $id = $this->getRequestParameter('gadget_id');

      $dashboard_id = $this->getRequestParameter('dashboard_id');

      if (!isset($this->_gadgets[$id][$dashboard_id]))
      {
         $gadget = DashboardGadgetPeer::retrieveByPK($id, $dashboard_id);

         if (null === $gadget)
         {
            return null;
         }

         $this->_gadgets[$id][$dashboard_id] = $gadget;
      }

      return $this->_gadgets[$id][$dashboard_id];
   }

   protected function getGadgetViewType()
   {
      $layout = $this->getGadget()->getDashboard()->getLayout();

      $column = $this->getGadget()->getDashboardColumnNo();

      switch ($layout)
      {
         case 'one_column_layout':
            $view = 'detailed';
         break;

         case 'two_column_layout1':
         case 'two_column_layout2':
         case 'two_column_layout3':
         case 'three_column_layout2':
            $view = 'simple';
         break;

         case 'three_column_layout1':
            $view = $column == 1 ? 'detailed' : 'simple';
      }    

      return $view;  
   }
}