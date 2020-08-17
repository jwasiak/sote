<?php

/**
 * Subclass for performing query and update operations on the 'st_smarty_content_block' table.
 *
 * 
 *
 * @package lib.model
 */ 
class SmartyContentBlockPeer extends BaseSmartyContentBlockPeer
{
   public static function retrieveByName($name, $culture)
   {  
      $c = new Criteria();

      $c->add(self::NAME, $name);

      $c->add(self::OPT_CULTURE, $culture);

      return self::doSelectOne($c);
   }
}
