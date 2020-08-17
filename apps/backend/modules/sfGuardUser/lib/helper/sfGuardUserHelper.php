<?php
function object_guard_permission_list(sfGuardUser $user, $method, $options)
{
   $sf_user = sfContext::getInstance()->getUser();

   $culture = $sf_user->getCulture();

   $fc = new stFunctionCache('stGuardUser');

   $select_options = $fc->cacheCall('_permission_select_options', array($culture));   

   $selected = array();

   $c = new Criteria();

   $c->addSelectColumn(sfGuardUserPermissionPeer::PERMISSION_ID);

   $c->add(sfGuardUserPermissionPeer::USER_ID, $user->getId());

   $rs = sfGuardUserPermissionPeer::doSelectRs($c);

   while($rs->next())
   {
      $row = $rs->getRow();

      $selected[] = $row[0];
   }

   $disabled = !$sf_user->isSuperAdmin() || $user->getIsSuperAdmin();

   return select_tag($options['control_name'], options_for_select($select_options, $selected), array('multiple' => true, 'size' => 7, 'style' => 'min-width: 180px', 'disabled' => $disabled));
}

function object_guard_group_permission_list(sfGuardGroup $group, $method, $options)
{
   $sf_user = sfContext::getInstance()->getUser();

   $culture = $sf_user->getCulture();

   $fc = new stFunctionCache('stGuardUser');

   $select_options = $fc->cacheCall('_permission_select_options', array($culture));   

   $selected = array();

   $c = new Criteria();

   $c->addSelectColumn(sfGuardGroupPermissionPeer::PERMISSION_ID);

   $c->add(sfGuardGroupPermissionPeer::GROUP_ID, $group->getId());

   $rs = sfGuardGroupPermissionPeer::doSelectRs($c);

   while($rs->next())
   {
      $row = $rs->getRow();

      $selected[] = $row[0];
   }

   return select_tag($options['control_name'], options_for_select($select_options, $selected), array('multiple' => true, 'size' => 7, 'style' => 'min-width: 180px'));
}

function object_guard_group_list(sfGuardUser $user, $method, $options)
{    
   $select_options = array();

   $c = new Criteria();

   $c->add(sfGuardGroupPeer::NAME, array('admin', 'user'), Criteria::NOT_IN);

   $groups = sfGuardGroupPeer::doSelect($c);

   foreach ($groups as $group)
   {
      $select_options[$group->getId()] = $group->getDescription();
   }

   $selected = array();

   $c = new Criteria();

   $c->addSelectColumn(sfGuardUserGroupPeer::GROUP_ID);

   $c->add(sfGuardUserGroupPeer::USER_ID, $user->getId());

   $rs = sfGuardUserGroupPeer::doSelectRs($c);

   while($rs->next())
   {
      $row = $rs->getRow();

      $selected[] = $row[0];
   }

   $disabled = !sfContext::getInstance()->getUser()->isSuperAdmin() || $user->getIsSuperAdmin();   

   return select_tag($options['control_name'], options_for_select($select_options, $selected), array('multiple' => true, 'size' => 10, 'style' => 'min-width: 180px', 'disabled' => $disabled));
}

function object_guard_app_permission_list(sfGuardUser $user, $method, $options)
{
   $select_options = _app_permission_select_options();

   $permission = sfGuardUserModulePermissionPeer::retrieveByPK($user->getId());

   $selected = $permission ? $permission->getPermissions() : array();

   $disabled = !sfContext::getInstance()->getUser()->isSuperAdmin() || $user->getIsSuperAdmin();   

   return select_tag($options['control_name'], options_for_select($select_options, $selected), array('multiple' => true, 'size' => 12, 'style' => 'min-width: 180px', 'disabled' => $disabled));
}

function object_guard_group_app_permission_list(sfGuardGroup $group, $method, $options)
{
   $select_options = _app_permission_select_options();

   $permission = sfGuardGroupModulePermissionPeer::retrieveByPK($group->getId());

   $selected = $permission ? $permission->getPermissions() : array();

   return select_tag($options['control_name'], options_for_select($select_options, $selected), array('multiple' => true, 'size' => 12, 'style' => 'min-width: 180px'));
}

function _app_permission_select_options()
{
   $modules = stAuthUsersListener::getSecuredModules();
    
   foreach ($modules as $name => $label)
   {
      $select_options[$label] = array(
         $name.'.access' => __('dostęp', null, 'sfGuardUser'),
         $name.'.modification' => __('modyfikacja', null, 'sfGuardUser')
      );
   } 

   return $select_options;
}

function _permission_select_options()
{
   $backend = sfGuardPermissionPeer::retrieveByName('backend');
   $update = sfGuardPermissionPeer::retrieveByName('update');
   $webapi_read = sfGuardPermissionPeer::retrieveByName('webapi_read');
   $webapi_write = sfGuardPermissionPeer::retrieveByName('webapi_write');

   if (null === $webapi_read)
   {
      $webapi_read = new sfGuardPermission();

      $webapi_read->setName('webapi_read');

      $webapi_read->save();
   }

   if (null === $webapi_write)
   {
      $webapi_write = new sfGuardPermission();

      $webapi_write->setName('webapi_write');

      $webapi_write->save();
   }   

   return array(
      __("Panel administracyjny", null, 'sfGuardUser') => array(
         $backend->getId() => __('dostęp', null, 'sfGuardUser')
      ),
      __("Panel uaktualnień", null, 'sfGuardUser') => array(
         $update->getId() => __('dostęp', null, 'sfGuardUser')
      ),  
      "WebAPI" => array(
         $webapi_read->getId() => __('dostęp', null, 'sfGuardUser'),
         $webapi_write->getId() => __('modyfikacja', null, 'sfGuardUser'),         
      ),             
   );
}



?>