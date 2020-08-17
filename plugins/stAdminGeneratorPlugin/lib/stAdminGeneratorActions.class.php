<?php

class stAdminGeneratorActions extends stActions
{

   public function executeSetConfiguration()
   {
      $action = $this->getRequestParameter('for_action');

      $page = $this->getRequestParameter('page', 1);

      $params = $this->getRequestParameter('params');

      foreach ($params as $name => $value)
      {
         $this->setConfigurationParameter($name, $value, array('action' => $action));
      }

      return $this->redirect($this->getModuleName().'/'.$action.'?page='.$page);
   }

   public function executeSetFilter()
   {
      $action = $this->getRequestParameter('for_action');

      $page = $this->getRequestParameter('page', 1);

      $filter = $this->getRequestParameter('id');

      $admin_filter = AdminGeneratorFilterPeer::retrieveByPk($filter);

      $this->clearFilter($action);

      if ($admin_filter)
      {
         $this->setFilter($admin_filter, $action);
      }

      return $this->redirect($this->getModuleName().'/'.$action.'?page='.$page);
   }

   public function executeSaveFilter()
   {
      if ($this->getRequest()->getMethod() == sfRequest::POST)
      {
           
         $action = $this->getRequestParameter('for_action');

         $page = $this->getRequestParameter('page', 1);

         $filters = $this->getRequestParameter('filters', array());

         $namespace = $this->getModuleName().'/'.$action;

         $guard_user_id = $this->getUser()->getGuardUser()->getId();

         $filter_profile = $this->getRequestParameter('filter_profile');

         $admin_filter = AdminGeneratorFilterPeer::retrieveByPK($this->getRequestParameter('id'));

         if (!$admin_filter)
         {
         
            $admin_filter = new AdminGeneratorFilter();

            $admin_filter->setName($filter_profile['name']);

            $admin_filter->setModuleNamespace($namespace);

            $admin_filter->setGuardUserId($guard_user_id);

            $admin_filter->setAdminGeneratorFilterData(new AdminGeneratorFilterData());
         }

         $admin_filter->setIsGlobal(isset($filter_profile['is_global']));

         $admin_filter->getAdminGeneratorFilterData()->setData($filters);

         $admin_filter->save();

         $this->setFilter($admin_filter, $action);
      }

      return $this->redirect($this->getModuleName().'/'.$action.'?page='.$page);
   }

   public function executeRemoveFilter()
   {
      $action = $this->getRequestParameter('for_action');

      $page = $this->getRequestParameter('page', 1);

      $filter = $this->getRequestParameter('id');

      $admin_filter = AdminGeneratorFilterPeer::retrieveByPk($filter);

      if ($admin_filter)
      {
         $admin_filter->delete();
      }

      $this->clearFilter($action);

      return $this->redirect($this->getModuleName().'/'.$action.'?page='.$page);
   }

   public function setConfigurationParameter($name, $value, $params = array())
   {
      if (!isset($params['action']))
      {
         $params['action'] = $this->getActionName();
      }

      if (!isset($params['module']))
      {
         $params['module'] = $this->getModuleName();
      }

      $this->getUser()->setAttribute($params['action'].'.'.$name, $value, 'soteshop/stAdminGenerator/'.$params['module'].'/config');
   }

   public function getConfigurationParameter($name, $value, $params = array())
   {
      if (!isset($params['action']))
      {
         $params['action'] = $this->getActionName();
      }

      if (!isset($params['module']))
      {
         $params['module'] = $this->getModuleName();
      }

      if (!isset($params['default']))
      {
         $params['default'] = null;
      }

      return $this->getUser()->getAttribute($params['action'].'.'.$name, $params['default'], 'soteshop/stAdminGenerator/'.$params['module'].'/config');
   }

   protected function clearFilter($action)
   {
      $this->getUser()->getAttributeHolder()->removeNamespace('soteshop/stAdminGenerator/'.$this->getModuleName().'/'.$action.'/filters');

      $this->setConfigurationParameter('filter', null, array('action' => $action));
   }

   protected function setFilter(AdminGeneratorFilter $filter, $action)
   {
      $this->getUser()->getAttributeHolder()->add($filter->getAdminGeneratorFilterData()->getData(), 'soteshop/stAdminGenerator/'.$this->getModuleName().'/'.$action.'/filters');

      $this->setConfigurationParameter('filter', array('id' => $filter->getId(), 'name' => $filter->getName(), 'is_global' => $filter->getIsGlobal()), array('action' => $action));
   }

}