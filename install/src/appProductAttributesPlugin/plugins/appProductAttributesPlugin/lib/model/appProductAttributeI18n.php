<?php

/**
 * Subclass for representing a row from the 'app_product_attribute_i18n' table.
 *
 * 
 *
 * @package plugins.appProductAttributesPlugin.lib.model
 */ 
class appProductAttributeI18n extends BaseappProductAttributeI18n
{
   public function save($con = null)
   {
      if (null === $this->culture)
      {
         return 0;
      }

      return parent::save($con);
   }   
}
