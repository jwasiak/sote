<?php

/**
 * Subclass for representing a row from the 'st_smarty_slot' table.
 *
 * 
 *
 * @package lib.model
 */ 
class SmartySlot extends BaseSmartySlot
{
   public function getContents()
   {
      $contents = array();

      $c = new Criteria();

      $c->addAscendingOrderByColumn(SmartySlotContentPeer::ID);

      foreach ($this->getSmartySlotContents($c) as $content)
      {
         $contents[] = $content->getContent();
      }

      return $contents;
   }
}
