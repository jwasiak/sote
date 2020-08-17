<?php

/**
 * Subclass for representing a row from the 'st_smarty_content_block' table.
 *
 * 
 *
 * @package lib.model
 */ 
class SmartyContentBlock extends BaseSmartyContentBlock
{
   public function getContentByName($name, $default = null)
   {
      return isset($this->content[$name]) ? $this->content[$name] : $default;
   }

   public function setContentByName($name, $value)
   {
      $content = $this->content ? $this->content : array();

      $content[$name] = $value;

      $this->setContent($content);      
   }

   public function getImagesContent()
   {
      $content = $this->getContentByName('content');

      $images = array();

      if ($content)
      {
         $matches = array();

         if (preg_match_all('/<img.*?src="([^"]+)"[^\/]*\/>/', $content, $matches))
         {
            foreach ($matches[0] as $index => $match) 
            {
               $md5 = md5($match);

               if (!isset($images[$md5]))
               {
                  $images[$md5] = array('html' => $match, 'path' => $matches[1][$index]);
               }
            }
         }
      }

      return $images;
   }

   public function save($con = null)
   {
      $ret = parent::save($con);

      self::clearCache($this->name);

      return $ret;
   }

   public function getUploadDir()
   {
      return 'uploads/smarty/content_block/'.$this->name.'/'.$this->opt_culture;
   }

   public function delete($con = null)
   {
      $ret = parent::delete($con);

      self::clearCache($this->name);

      $upload_dir = sfConfig::get('sf_web_dir').'/'.$this->getUploadDir();

      if (is_dir($upload_dir))
      {
         foreach (glob($upload_dir.'/*') as $file)
         {
            unlink($file);
         }

         rmdir($upload_dir);
      }

      return $ret;      
   }

   public static function clearCache($name)
   {
      $fc = new stFunctionCache('SmartyContentBlock');

      $fc->removeByNamespace($name);

      stFastCacheManager::clearCache();
   }
}
