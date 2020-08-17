<?php
if (version_compare($version_old, '1.0.5.6', '<'))
{
    $databaseManager = new sfDatabaseManager();
    $databaseManager->initialize();
         
        $permission = new sfGuardPermission();
        $permission->setName("update");
        $permission->setDescription("update permission");
        $permission->save();
        
        $permission = new sfGuardPermission();
        $permission->setName("backend");
        $permission->setDescription("backend permission");
        $permission->save();
       
        $c = new Criteria();
        $c->addJoin(sfGuardUserGroupPeer::USER_ID, sfGuardUserPeer::ID);
        $c->addJoin(sfGuardUserGroupPeer::GROUP_ID, sfGuardGroupPeer::ID);
        $c->add(sfGuardGroupPeer::NAME, 'admin');

        $admins = sfGuardUserPeer::doSelect($c);
                
        foreach ($admins as $admin)
        {
             $admin->addPermissionByName('update');
             $admin->addPermissionByName('backend');
        }
        
        $path = sfConfig::get('sf_data_dir') .DIRECTORY_SEPARATOR."config".DIRECTORY_SEPARATOR."__stAuth.yml" ;  
        
        unlink($path);
}

if (version_compare($version_old, '1.0.5.14', '<'))
{
    $path = sfConfig::get('sf_root_dir') .DIRECTORY_SEPARATOR."apps".DIRECTORY_SEPARATOR."backend".DIRECTORY_SEPARATOR."lib".DIRECTORY_SEPARATOR."model".DIRECTORY_SEPARATOR."sfGuardUser.php";  
        
    unlink($path);
}

if (version_compare($version_old, '1.0.5.16', '<'))
{
        $databaseManager = new sfDatabaseManager();
        $databaseManager->initialize();

        $c = new Criteria();
        $c->addJoin(sfGuardUserPeer::ID, sfGuardUserGroupPeer::USER_ID);
        $c->addJoin(sfGuardUserGroupPeer::GROUP_ID, sfGuardGroupPermissionPeer::GROUP_ID);
        $c->addJoin(sfGuardPermissionPeer::ID, sfGuardGroupPermissionPeer::PERMISSION_ID);
        $c->add(sfGuardPermissionPeer::NAME, 'admin');

        $admins = sfGuardUserPeer::doSelect($c);

        foreach ($admins as $admin)
        {
            $admin->setIsConfirm(1);
            $admin->save();
        }
}

if (version_compare($version_old, '1.0.5.28', '<'))
{
   $remove_path = sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.'backend'.DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.'sfGuardUser'.DIRECTORY_SEPARATOR.'templates';

   if (is_file($remove_path.DIRECTORY_SEPARATOR.'_list_td_action_select.php'))
   {
      unlink($remove_path.DIRECTORY_SEPARATOR.'_list_td_action_select.php');
   }

   if (is_file($remove_path.DIRECTORY_SEPARATOR.'_list_select_control.php'))
   {
      unlink($remove_path.DIRECTORY_SEPARATOR.'_list_select_control.php');
   }

   if (is_file($remove_path.DIRECTORY_SEPARATOR.'_form_edit.php'))
   {
      unlink($remove_path.DIRECTORY_SEPARATOR.'_form_edit.php');
   }
}

if (version_compare($version_old, '2.0.0.6', '<'))
{
   $remove_path = sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.'backend'.DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.'sfGuardUser'.DIRECTORY_SEPARATOR.'templates';

   $remove_list = array(
      '_list_td_action_select.php',
      '_list_select_control.php',
      '_edit_form.php',
      '_webapi_read.php',
      '_webapi_write.php',
   );

   foreach ($remove_list as $file)
   {
      if (is_file($remove_path.'/'.$file))
      {
         unlink($remove_path.'/'.$file);
      }
   }
}

