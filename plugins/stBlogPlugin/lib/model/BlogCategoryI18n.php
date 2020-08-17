<?php

/**
 * Subclass for representing a row from the 'st_blog_category_i18n' table.
 *
 * 
 *
 * @package plugins.stBlogPlugin.lib.model
 */ 
class BlogCategoryI18n extends BaseBlogCategoryI18n
{
    
   public function getName()
   {
      if ($this->getCulture() == stLanguage::getOptLanguage())
      {
         return stLanguage::getDefaultValue($this, __METHOD__);
      }

      $v = parent::getName();

      if (is_null($v))
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
}
