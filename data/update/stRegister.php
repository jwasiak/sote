<?php
try {
if (version_compare($version_old, '1.0.3.8', '<'))
{
    $databaseManager = new sfDatabaseManager();
    $databaseManager->initialize();
    
    $config = stConfig::getInstance(null, 'stRegister');
          
    if(!$config->get('shop_hash') || $config->get('shop_hash')=="")
    {
        $shop_hash = Crypt::getShopHash($config->get('license'));
        $config->set('shop_hash',$shop_hash).
        $config->save();
    }        
}

if (version_compare($version_old, '1.1.0.7', '<'))
{
   $databaseManager = new sfDatabaseManager();
   $databaseManager->initialize();

   $c = new Criteria();
   $c->addJoin(sfGuardUserPeer::ID, sfGuardUserGroupPeer::USER_ID);
   $c->addJoin(sfGuardUserGroupPeer::GROUP_ID, sfGuardGroupPermissionPeer::GROUP_ID);
   $c->addJoin(sfGuardPermissionPeer::ID, sfGuardGroupPermissionPeer::PERMISSION_ID);
   $c->add(sfGuardPermissionPeer::NAME, 'admin');

   $users = sfGuardUserPeer::doSelect($c);

   foreach ($users as $user)
   {
     $user->setIsConfirm(1);
     $user->save();
   }
}

} catch (Exception $e) {}