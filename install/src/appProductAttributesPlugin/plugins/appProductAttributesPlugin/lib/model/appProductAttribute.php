<?php

/**
 * Subclass for representing a row from the 'app_product_attribute' table.
 *
 * 
 *
 * @package plugins.appProductAttributesPlugin.lib.model
 */ 
class appProductAttribute extends BaseappProductAttribute
{
   protected $color = null;

   public function getName()
   {
      if ($this->getCulture() == stLanguage::getOptLanguage())
      {
         return stLanguage::getDefaultValue($this, __METHOD__);
      }

      $v = parent::getName();

      if (null === $v)
      {
         $v = stLanguage::getDefaultValue($this, __METHOD__);
      }

      return $v;
   }

   public function setName($v)
   {
      if ($this->getCulture() == stLanguage::getOptLanguage())
      {
         stLanguage::setDefaultValue($this, __METHOD__, $v);
      }

      parent::setName($v);
   }  

   public function getColor($create = false)
   {
      if (null === $this->color)
      {
         $this->color = appProductAttributeColorPeer::retrieveByPK($this->id);

         if (null === $this->color && $create)
         {
            $this->color = new appProductAttributeColor();
         }
      }

      return $this->color;
   } 

   public function delete($con = null)
   {
      $id = $this->getId();

      $c = new Criteria();

      $c->addJoin(appProductAttributeVariantPeer::ID, appProductAttributeHasVariantPeer::VARIANT_ID);

      $c->add(appProductAttributeHasVariantPeer::ATTRIBUTE_ID, $this->getId());

      foreach (appProductAttributeVariantPeer::doSelect($c) as $variant)
      {
         $variant->delete();
      }

      parent::delete($con);
   }
}
