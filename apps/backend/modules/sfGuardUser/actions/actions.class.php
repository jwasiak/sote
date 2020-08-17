<?php

/**
 * SOTESHOP/stAuthUsers 
 * 
 * Ten plik należy do aplikacji stAuthUsers opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 * 
 * @package     stAuthUsers
 * @subpackage  actions
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/open (Open License SOTE) Otwarta Licencja SOTE
 * @version     $Id: actions.class.php 251 2009-03-30 11:35:06Z marek $
 */
class sfGuardUserActions extends autosfGuardUserActions
{

   protected function addFiltersCriteria($c)
   {
      parent::addFiltersCriteria($c);

      $group = sfGuardGroupPeer::retrieveByName('admin');

      $c->addJoin(sfGuardUserPeer::ID, sfGuardUserGroupPeer::USER_ID);
      $c->add(sfGuardUserGroupPeer::GROUP_ID, $group->getId());
   }

   public function executeDelete()
   {
      if (!$this->getUser()->isSuperAdmin())
      {
         $this->setFlash('warning', 'Nie posiadasz uprawnień do wykonywania tej operacji');

         return $this->redirect('sfGuardUser/list?page='.$this->getRequestParameter('page', 1));
      }

      if ($this->getRequestParameter('sf_guard_user[selected]['.$this->getUser()->getGuardUserId().']') !== null)
      {
         $this->setFlash('warning', 'Nie możesz usunąć własnego konta');

         return $this->redirect('sfGuardUser/list?page='.$this->getRequestParameter('page', 1));
      }

      return parent::executeDelete();
   }

   /**
    * Przeciążenie zapisu - automatyczne nadawanie grupy
    *
    * @param   sfGuardUser $sf_guard_user      Użytkownik  
    */
   protected function savesfGuardUser($sf_guard_user)
   {
      if (!$this->getUser()->isSuperAdmin())
      {
         $sf_guard_user->setIsSuperAdmin(false);
      }

      parent::savesfGuardUser($sf_guard_user);

      if ($this->getUser()->isSuperAdmin())
      {
         $this->saveGroups($sf_guard_user);      

         $this->savePermissions($sf_guard_user);   

         $this->saveModulePermissions($sf_guard_user);
      }

      $this->saveUpdateCredentials();
   }

   public function validateList()
   {
      if (!$this->getUser()->isSuperAdmin())
      {
         return $this->redirect('sfGuardAuth/secure');
      }

      return true;
   }

   public function validateEdit()
   {
      if (!$this->getUser()->isSuperAdmin() && $this->getUser()->getGuardUserId() != $this->getRequest()->getParameter('id'))
      {
         return $this->redirect('sfGuardAuth/secure');
      }

      if ($this->getRequest()->getMethod() == sfRequest::POST)
      {
         if (!$this->getRequest()->getParameter('id'))
         {
            $error_exists = false;

            $i18n = $this->getContext()->getI18N();


            if (!$this->getRequestParameter('sf_guard_user[password]'))
            {
               $this->getRequest()->setError('sf_guard_user{password}', $i18n->__('Proszę podać hasło.'));
               $error_exists = true;
            }

            if (!$this->getRequestParameter('sf_guard_user[password_bis]'))
            {
               $this->getRequest()->setError('sf_guard_user{password_bis}', $i18n->__('Proszę podać hasło.'));
               $error_exists = true;
            }

            return !$error_exists;
         }
      }

      return true;
   }

   protected function saveModulePermissions(sfGuardUser $user)
   {
      $user_id = $user->getId();

      sfGuardUserModulePermissionPeer::doDelete($user_id);

      $permission = new sfGuardUserModulePermission();

      $permission->setId($user_id);

      $permissions = $this->getRequestParameter('module_permission');

      $permission->setPermissions($permissions);

      $permission->save();
   }

   protected function saveGroups(sfGuardUser $user)
   {
      $user_id = $user->getId();

      $c = new Criteria();

      $c->add(sfGuardUserGroupPeer::USER_ID, $user_id);

      sfGuardUserGroupPeer::doDelete($c);

      $groups = $this->getRequestParameter('group');

      foreach ($groups as $id)
      {
         $group = new sfGuardUserGroup();

         $group->setUserId($user_id);

         $group->setGroupId($id);

         $group->save();
      }       

      $user->addGroupByName('admin');
   }

   protected function savePermissions(sfGuardUser $user)
   {
      $user_id = $user->getId();

      $c = new Criteria();

      $c->add(sfGuardUserPermissionPeer::USER_ID, $user_id);

      sfGuardUserPermissionPeer::doDelete($c); 

      $permissions = $this->getRequestParameter('permission'); 

      foreach ($permissions as $id)
      {
         $permission = new sfGuardUserPermission();

         $permission->setUserId($user_id);

         $permission->setPermissionId($id);

         $permission->save();
      } 
   }

   protected function saveUpdateCredentials()
   {
      $config = stConfig::getInstance('stAuth');

      $permission = sfGuardPermissionPeer::retrieveByName('update');

      $group_ids = array();

      $c = new Criteria();

      $c->addSelectColumn(sfGuardGroupPeer::ID);

      $c->addJoin(sfGuardGroupPeer::ID, sfGuardGroupPermissionPeer::GROUP_ID);

      $c->add(sfGuardGroupPermissionPeer::PERMISSION_ID, $permission->getId());

      $rs = sfGuardGroupPermissionPeer::doSelectRs($c);

      while($rs->next())
      {
         $group_ids[] = $rs->getInt(1);
      }

      $c = new Criteria();

      $c->addJoin(sfGuardUserPeer::ID, sfGuardUserPermissionPeer::USER_ID, Criteria::LEFT_JOIN);

      if ($group_ids)
      {
         $c->addJoin(sfGuardUserPeer::ID, sfGuardUserGroupPeer::USER_ID, Criteria::LEFT_JOIN);
      }

      $criterion = $c->getNewCriterion(sfGuardUserPeer::IS_SUPER_ADMIN, true);

      $criterion->addOr($c->getNewCriterion(sfGuardUserPermissionPeer::PERMISSION_ID, $permission->getId()));

      if ($group_ids)
      {
         $criterion->addOr($c->getNewCriterion(sfGuardUserGroupPeer::GROUP_ID, $group_ids, Criteria::IN));
      }

      $c->add($criterion);

      $c->addGroupByColumn(sfGuardUserPeer::ID);

      $users = sfGuardUserPeer::doSelect($c);

      $credentials = array();

      foreach ($users as $user)
      {
         $credentials[] = array('username' => $user->getUsername(), 'salt' => $user->getSalt(), 'password' => $user->getPassword());
      }

      $config->set('users', $credentials);

      $config->save();
   }
}
