<?php

/**
 * Subclass for representing a row from the 'app_product_attribute_variant_i18n' table.
 *
 * 
 *
 * @package plugins.appProductAttributesPlugin.lib.model
 */ 
class appProductAttributeVariantI18n extends BaseappProductAttributeVariantI18n
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
