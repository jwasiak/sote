<?php

/**
 * Subclass for performing query and update operations on the 'st_admin_generator_filter' table.
 *
 * 
 *
 * @package plugins.stAdminGeneratorPlugin.lib.model
 */ 
class AdminGeneratorFilterPeer extends BaseAdminGeneratorFilterPeer
{
   public static function retrieveExisting($guard_user_id, $name, $namespace)
   {
      $c = new Criteria();

      $c->add(AdminGeneratorFilterPeer::NAME, $name);

      $c->add(AdminGeneratorFilterPeer::MODULE_NAMESPACE, $namespace);

      $c->add(AdminGeneratorFilterPeer::GUARD_USER_ID, $guard_user_id);

      return self::doSelectOne($c);
   }
}
