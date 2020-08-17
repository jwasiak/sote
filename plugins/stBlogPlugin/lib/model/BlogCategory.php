<?php

/**
 * Subclass for representing a row from the 'st_blog_category' table.
 *
 * 
 *
 * @package plugins.stBlogPlugin.lib.model
 */ 
class BlogCategory extends BaseBlogCategory
{
   public function hydrate(ResultSet $rs, $startcol = 1)
   {
      $this->setCulture(stLanguage::getHydrateCulture());

      return parent::hydrate($rs, $startcol);
   }

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

   public function getUrl()
   {
      if ($this->getCulture() == stLanguage::getOptLanguage())
      {
         $v = stLanguage::getDefaultValue($this, __METHOD__);
      }
      else
      {
         $v = parent::getUrl();

         if (is_null($v))
         {
            $v = stLanguage::getDefaultValue($this, __METHOD__);
         }
      }

      if (null === $v && !$this->isNew())
      {               
         $v = $this->generateUrl();
      }

      return $v;      
   }

   public function setUrl($v)
   {
      if ($this->getCulture() == stLanguage::getOptLanguage())
      {
         stLanguage::setDefaultValue($this, __METHOD__, $v);
      }

      parent::setUrl($v);
   }

   public function urlFilter($friendly_url)
   {
      $c = new Criteria();

      $c->add(BlogCategoryI18nPeer::ID, $this->getPrimaryKey(), Criteria::NOT_EQUAL);

      $c->add(BlogCategoryI18nPeer::URL, $friendly_url);

      if (BlogCategoryI18nPeer::doCount($c) > 0)
      {
         return stPropelSeoUrlBehavior::makeSeoFriendly($friendly_url.'-'.$this->getId());
      }

      return false;
   }

   protected function generateUrl()
   {
      $url = stPropelSeoUrlBehavior::makeSeoFriendly($this->getName());

      $this->setUrl($url);

      $this->save();

      return $this->getUrl();
   }
}

sfPropelBehavior::add('BlogCategory', array('stPropelSeoUrlBehavior' => array('source_column' => 'Name', 'target_column' => 'Url', 'target_column_filter' => 'urlFilter')));