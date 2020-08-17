<?php

/**
 * Subclass for performing query and update operations on the 'st_smarty_slot' table.
 *
 * 
 *
 * @package lib.model
 */ 
class SmartySlotPeer extends BaseSmartySlotPeer
{
   public static function retrieveByNameAndTheme($name, Theme $theme)
   {  
      $c = new Criteria();

      $c->add(self::NAME, $name);

      $c->add(self::THEME_ID, $theme->getId());

      return self::doSelectOne($c);
   }
}
