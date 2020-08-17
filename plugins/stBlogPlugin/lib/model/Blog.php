<?php

/**
 * SOTESHOP/stBlogPlugin
 *
 * Ten plik należy do aplikacji stBlogPlugin opartej na licencji (Open License SOTE) Otwarta Licencja SOTE. 
 * Nie zmieniaj tego pliku, jeśli chcesz korzystać z automatycznych aktualizacji oprogramowania. 
 * Jeśli chcesz wprowadzać swoje modyfikacje do programu, zapoznaj się z dokumentacją, jak zmieniać 
 * oprogramowanie bez zmiany kodu bazowego http://www.sote.pl/modifications
 *
 * @package     stBlogPlugin
 * @subpackage  libs
 * @copyright   SOTE (www.sote.pl)
 * @license     http://www.sote.pl/license/sote (Professional License SOTE)
 * @version     $Id: config.php 12100 2013-02-01 07:18:36Z pawel $
 * @author      Paweł Byszewski <pawel.byszewski@sote.pl>
 */

/**
 * Klasa Blog
 *
 * @package     stBlogPlugin
 * @subpackage  libs
 */
class Blog extends BaseBlog
{

   public function __toString()
   {
      return $this->getName() ? $this->getName() : '';
   }

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
         return stLanguage::getDefaultValue($this, __METHOD__);

      $v = parent::getUrl();
      if (is_null($v))
         $v = stLanguage::getDefaultValue($this, __METHOD__);
      return $v;
   }

   public function setUrl($v)
   {
      if ($this->getCulture() == stLanguage::getOptLanguage())
         stLanguage::setDefaultValue($this, __METHOD__, $v);
      parent::setUrl($v);
   }

   public function getLongDescription()
   {
      if ($this->getCulture() == stLanguage::getOptLanguage())
      {
         return stLanguage::getDefaultValue($this, __METHOD__);
      }

      $v = parent::getLongDescription();

      if (is_null($v))
      {
         $v = stLanguage::getDefaultValue($this, __METHOD__);
      }

      return $v;
   }

   public function setLongDescription($v)
   {
      if ($this->getCulture() == stLanguage::getOptLanguage())
      {
         stLanguage::setDefaultValue($this, __METHOD__, $v);
      }

      parent::setLongDescription($v);
   }

   public function getShortDescriptionTrimed($length = 50)
   {
      $content = $this->getShortDescription();
      $content = strip_tags($content);
      $contentLength = strlen($content);

      //sprawdzenie czy istnieje potrzeba przyciecia
      if($contentLength <= $length)
      {
         return strip_tags($this->getShortDescription());
      }

      $content = trim(wordwrap($content, $length, "\n"));
      $table = explode("\n", $content);

      if(count($table) > 0)
      {
         return $table[0]."...";
      }
      return "";
   }

   public function setShortDescription($v)
   {
      if ($this->getCulture() == stLanguage::getOptLanguage())
      {
         stLanguage::setDefaultValue($this, __METHOD__, $v);
      }

      parent::setShortDescription($v);
   }

   public function getShortDescription()
   {
      if ($this->getCulture() == stLanguage::getOptLanguage())
      {
         return stLanguage::getDefaultValue($this, __METHOD__);
      }

      $v = parent::getShortDescription();

      if (is_null($v))
      {
         $v = stLanguage::getDefaultValue($this, __METHOD__);
      }

      return $v;
   }

   public function urlFilter($friendly_url)
   {
      $c = new Criteria();

      $c->add(BlogI18nPeer::ID, $this->getPrimaryKey(), Criteria::NOT_EQUAL);

      $c->add(BlogI18nPeer::URL, $friendly_url);

      if (BlogI18nPeer::doCount($c) > 0)
      {
         return $friendly_url.'-'.$this->getPrimaryKey();
      }

      return false;
   }

   public function save($con = null)
   {
      if ($this->asfAsset || $this->getSfAssetId() && $this->isColumnModified(BlogPeer::SF_ASSET_ID))
      {
         $this->setOptImageMainPage($this->getsfAsset()->getRelativePath());
         $this->setOptImage($this->getsfAsset()->getRelativePath());
      }  

      if ($this->isModified())
      {
         BlogPeer::clearCache();
      }   
      
      parent::save($con);
   }

   public function delete($con = null)
   {
      parent::delete($con);
      
      $this->removeImage();

      BlogPeer::clearCache();
   }

   public function setOptImageMainPage($v)
   {
      $this->setImageMainPage($v);
   }

   public function getOptImageMainPage()
   {
      return $this->getImageMainPage();
   }
   
   public function getImageMainPage()
   {    
       if (null !== $this->getGallery())
       {
            $gallery = $this->getGallery();
            return current($gallery);
       }
       
       return parent::getImageMainPage();     
   }

   public function setOptImage($v)
   {
      $this->setImage($v);
   }

   public function getOptImage()
   {
      return $this->getImage();
   }

   public function destroyAsset()
   {
      $asset = $this->getsfAsset();

      if ($asset)
      {
         $asset->delete(null, 'blog');

         $this->setImage(null);

         $this->setImageMainPage(null);

         $this->setsfAsset(null);
      }
   }

   public function createAsset($filename, $source_file)
   {
      if (!$this->getPrimaryKey())
      {
         throw new sfException('Wpis musi być najpierw zapisany do bazy danych...');
      }

      $asset = $this->getsfAsset();

      if (!$asset)
      {
         $asset = new sfAsset();
      }
      else
      {
         $asset->destroy();
      }

      $folder = sfAssetFolderPeer::retrieveByPath('media/blog');

      if (!$folder)
      {
         $folder = sfAssetFolderPeer::createFromPath('media/blog');
      }

      $asset->setsfAssetFolder($folder);

      $asset->setFilename($filename);

      $tmp = $prev = sfConfig::get('app_sfAssetsLibrary_thumbnails');

      foreach ($tmp as $type => $config)
      {
         $tmp[$type]['watermark'] = false;
      }

      sfConfig::set('app_sfAssetsLibrary_thumbnails', $tmp);

      $asset->create($source_file, true, false);

      $this->setsfAsset($asset);

      sfConfig::set('app_sfAssetsLibrary_thumbnails', $prev);

      return $asset;
   }
   
   public static function trim_post($description, $chars)
   {
        $max_length = $chars;
        $s = strip_tags($description);
        
        if (strlen($s) > $max_length)
        {
            $offset = ($max_length - 3) - strlen($s);
            $s = @substr($s, 0, strrpos($s, ' ', $offset)) . '...';
        }
          
        $description = $s;
      
        return $description;
   } 
   

   public function removeImage()
   {
      $path = $this->getImagePath(true);

      if (is_file($path))
      {
         unlink($path);
      }

      $this->setImageMainPage(null);
   }
   
   public function getImageDir($system_dir = false)
   {
       $dir = 'uploads/blog/main';
       
       if ($system_dir)
       {
           return sfConfig::get('sf_web_dir').'/'.$dir;
       }
       
       return $dir;
   }
   
   public function getImagePath($system_dir = false)
   {
      return $this->getImageDir($system_dir).'/'.$this->getImageMainPage();
   }
   
   public function getGalleryPath($name, $system_dir = false)
   {
       return $this->getImageDir($system_dir).'/'.$name;
   }
}

sfPropelBehavior::add('Blog', array('stPropelSeoUrlBehavior' => array('source_column' => 'Name', 'target_column' => 'Url', 'target_column_filter' => 'urlFilter')));