<?php

/**
 * Subclass for representing a row from the 'sm_group_price' table.
 *
 * 
 *
 * @package lib.model
 */ 
class GroupPrice extends BaseGroupPrice
{
	
  public function __toString()
  {
    return $this->getName();
  }

}
