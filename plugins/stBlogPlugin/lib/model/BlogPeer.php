<?php

/**
 * Subclass for performing query and update operations on the 'st_blog' table.
 *
 * 
 *
 * @package plugins.stBlogPlugin.lib.model
 */ 
class BlogPeer extends BaseBlogPeer
{
   protected static $urlPool = array();

   public static function retrieveByUrl($url)
   {
      if (!isset(self::$urlPool[$url]) && !array_key_exists($url, self::$urlPool))
      {
         $c = new Criteria();
         $c->addSelectColumn(BlogI18nPeer::ID);
         $c->add(BlogI18nPeer::URL, $url);
         $c->setLimit(1);
         $rs = BlogI18nPeer::doSelectRS($c);

         if ($rs->next())
         {  
            $row = $rs->getRow();
            $c = new Criteria();
            $c->add(self::ID, $row[0]);
            $c->setLimit(1);
            $tmp = self::doSelectWithI18n($c);     
            self::$urlPool[$url] = $tmp ? $tmp[0] : null;
         }
      }

      return self::$urlPool[$url];
   }  

   public static function doCountWithI18n(Criteria $c, $con = null)
   {
      $c = clone $c;
      
      $c->addJoin(BlogI18nPeer::ID, BlogPeer::ID);

      $c->add(BlogI18nPeer::CULTURE, stLanguage::getHydrateCulture());

      return self::doCount($c, $con);
   }

   public static function doSelectWithI18n(Criteria $c, $culture = null, $con = null)
   {
      if ($culture === null)
      {
         $culture = stLanguage::getHydrateCulture();
      }

      return parent::doSelectWithI18n($c, $culture, $con);
   }

   public static function clearCache()
   {
      $cache = new stFunctionCache('stBlogPlugin');
      
      $cache->removeAll();
   }

}