<?php

class sfGuardGroupActions extends autosfGuardGroupActions
{
   public function validateEdit()
   {
      if (!$this->getUser()->isSuperAdmin())
      {
         return $this->redirect('sfGuardAuth/secure');
      }

      return true;
   }

   public function validateList()
   {
      if (!$this->getUser()->isSuperAdmin())
      {
         return $this->redirect('sfGuardAuth/secure');
      }

      return true;
   }   

   public function addFiltersCriteria($c)
   {
      $c->add(sfGuardGroupPeer::NAME, array('admin', 'user'), Criteria::NOT_IN);

      parent::addFiltersCriteria($c);
   }

   protected function savesfGuardGroup($sf_guard_group)
   {
      parent::savesfGuardGroup($sf_guard_group);

      $this->savePermissions($sf_guard_group);   

      $this->saveModulePermissions($sf_guard_group);
   }

   protected function saveModulePermissions(sfGuardGroup $group)
   {
      $group_id = $group->getId();

      sfGuardGroupModulePermissionPeer::doDelete($group_id);

      $permission = new sfGuardGroupModulePermission();

      $permission->setId($group_id);

      $permissions = $this->getRequestParameter('module_permission');

      $permission->setPermissions($permissions);

      $permission->save();
   } 

   protected function savePermissions(sfGuardGroup $group)
   {
      $group_id = $group->getId();

      $c = new Criteria();

      $c->add(sfGuardGroupPermissionPeer::GROUP_ID, $group_id);

      sfGuardGroupPermissionPeer::doDelete($c); 

      $permissions = $this->getRequestParameter('permission'); 

      foreach ($permissions as $id)
      {
         $permission = new sfGuardGroupPermission();

         $permission->setGroupId($group_id);

         $permission->setPermissionId($id);

         $permission->save();
      } 
   }     
}