<?php

/**
 * Subclass for representing a row from the 'app_product_attribute_variant' table.
 *
 * 
 *
 * @package plugins.appProductAttributesPlugin.lib.model
 */ 
class appProductAttributeVariant extends BaseappProductAttributeVariant
{
   public static function getTypes()
   {
      return array(
         'C' => __('Kolor'),
         'P' => __('Obrazek'),
      );      
   }

   public function getValue()
   {
      if ($this->getCulture() == stLanguage::getOptLanguage())
      {
         return stLanguage::getDefaultValue($this, __METHOD__);
      }

      $v = parent::getValue();

      if (null === $v)
      {
         $v = stLanguage::getDefaultValue($this, __METHOD__);
      }

      return $v;
   }

   public function setValue($v)
   {
      if ($this->getCulture() == stLanguage::getOptLanguage())
      {
         stLanguage::setDefaultValue($this, __METHOD__, $v);
      }

      parent::setValue($v);
   }

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

   public function setColorType($v)
   {
      $this->setType($v);
   }

   public function setColor($v)
   {
      $this->setOptValue($v);
   }

   public function setPicture($v)
   {
      $this->setOptValue($v);
   }

   public function isColorType()
   {
      return $this->type == 'C';
   }

   public function isPictureType()
   {
      return $this->type == 'P';
   }

   public function getTypeLabel()
   {
      $types = self::getTypes();

      return $types[$this->type];
   }

   public function getUploadDir()
   {
      return 'uploads/product_attributes/colors';
   }

   public function getPicturePath()
   {
      return '/'.$this->getOptValue();
   }

   public function getColor()
   {
      return $this->getOptValue();
   }

   public function delete($con = null)
   {
      $ret = parent::delete($con);

      $fc = new stFunctionCache('appProductAttributeVariant');

      $fc->removeAll();

      if ($this->isPictureType())
      {
         $this->removePicture();
      }
      
      return $ret;      
   }   

   public function save($con = null)
   {
   	$ret = parent::save($con);

      $fc = new stFunctionCache('appProductAttributeVariant');

      $fc->removeAll();

      return $ret;   	
   }

   public function removePicture()
   {
      $file = sfConfig::get('sf_web_dir').$this->getPicturePath();

      if (is_file($file))
      {
         unlink($file);
      }
   }    
}