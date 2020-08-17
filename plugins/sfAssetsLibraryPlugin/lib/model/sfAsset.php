<?php

class sfAsset extends BasesfAsset
{
   protected static $folders = array(); 

   protected $crop = null;

   public function __toString()
   {
      return $this->getFilename();
   }

   public function getImageCrop()
   {
      return $this->getCrop();
   }

   public function setCrop($crop)
   {
      $this->crop = $crop;
   }

   public function getCrop()
   {
      if (null === $this->crop)
      {
         $crop_file = $this->getFullPath().'.json';

         if (is_file($crop_file))
         {
            $this->crop = json_decode(file_get_contents($crop_file), true);  
         }
         else
         {
            $this->crop = array();
         }
      }

      return $this->crop;
   }

   public function getCropByImageType($type)
   {
      $crop = $this->getCrop();

      return isset($crop[$type]) ? $crop[$type] : array();
   }

   public function getsfAssetFolder($con = null)
   {
      if (isset(self::$folders[$this->folder_id]))
      {
         $this->setsfAssetFolder(self::$folders[$this->folder_id]);
      }
      else
      {
         self::$folders[$this->folder_id] = parent::getsfAssetFolder($con);
      }

      return parent::getsfAssetFolder($con);
   }

   public function getImageInfo()
   {
      return getimagesize($this->getFullPath());
   }

   public function getFilename($trim_ext = false)
   {
      $filename = parent::getFilename();

      if ($trim_ext)
      {
         $tmp = explode('.', $filename);

         $filename = $tmp[0];
      }

      return $filename;
   }

   /**
    * Get folder relative path
    *
    * @return string
    */
   public function getFolderPath()
   {
      $folder = $this->getsfAssetFolder();
      if (!$folder)
      {
         throw new Exception(sprintf('You must set define the folder for an asset prior to getting its path. Asset %d doesn\'t have a folder yet.', $this->getFilename()));
      }
      return $folder->getRelativePath();
   }

   public function countProductForSfAssets($criteria = null, $distinct = false, $con = null)
   {
      include_once 'lib/model/om/BaseProductForSfAssetPeer.php';
      if ($criteria === null)
      {
         $criteria = new Criteria();
      }
      elseif ($criteria instanceof Criteria)
      {
         $criteria = clone $criteria;
      }

      $criteria->add(ProductForSfAssetPeer::SF_ASSET_ID, $this->getId());

      return ProductForSfAssetPeer::doCount($criteria, $distinct, $con);
   }

   public function getPath()
   {
      $c = new Criteria();
      $c->add(sfAssetFolderPeer::ID, $this->getFolderId());

      $folder = sfAssetFolderPeer::doSelectOne($c);

      if ($folder)
      {

         return "/".$folder->getRelativePath()."/".$this->getFileName();
      }

      return "";
   }

   /**
    * Gives the file relative path
    *
    * @return string
    */
   public function getRelativePath()
   {
      return $this->getFolderPath().'/'.$this->getFilename();
   }

   public function setRawFilename($filename)
   {
      parent::setFilename($filename);
   }

   /**
    * Gives full filesystem path
    *
    * @param string $thumbnail_type
    * @return string
    */
   public function getFullPath($thumbnail_type = 'full')
   {
      return sfAssetsLibraryTools::getThumbnailPath($this->getFolderPath(), $this->getFilename(), $thumbnail_type);
   }

   public function setFilename($filename)
   {
      $filename = sfAssetsLibraryTools::sanitizeName($filename);

      return parent::setFilename($filename);
   }

   public function getFilesize($auto_format = false)
   {
      $filesize = parent::getFilesize();

      if ($auto_format)
      {
         if ($filesize < 1024)
         {
            return number_format($filesize, 1).' KB';
         }
         else
         {
            return number_format($filesize / 1024, 1).' MB';
         }
      }

      return $filesize;
   }

   /**
    * Gives the URL for the given thumbnail
    *
    * @param string $thumbnail_type
    * @return string
    */
   public function getUrl($thumbnail_type = 'full', $relative_path = null)
   {
      if (is_null($relative_path))
      {
         if (!$folder = $this->getsfAssetFolder())
         {
            throw new Exception(sprintf('You must set define the folder for an asset prior to getting its path. Asset %d doesn\'t have a folder yet.', $this->getFilename()));
         }
         $relative_path = $folder->getRelativePath();
      }
      $url = sfAssetsLibraryTools::getMediaDir();
      if ($thumbnail_type == 'full')
      {
         $url .= $relative_path.DIRECTORY_SEPARATOR.$this->getFilename();
      }
      else
      {
         $url .= sfAssetsLibraryTools::getThumbnailDir($relative_path).$thumbnail_type.'_'.$this->getFilename();
      }

      return sfAssetsLibraryTools::fixUrl($url);
   }

   public function autoSetType()
   {
      $this->setType(sfAssetsLibraryTools::getType($this->getFullPath()));
   }

   public function isImage()
   {
      $type = $this->getType();
      return $type == 'image' || $type == 'jpeg' || $type == 'jpg' || $type == 'png' || $type == 'gif';
   }

   public function supportsThumbnails()
   {
      return $this->isImage() && class_exists('sfThumbnail');
   }

   public function create($asset_path, $for = 'product', $move = true, $checkDuplicate = true)
   {
      if (!is_file($asset_path))
      {
         throw new sfAssetException('Asset "%asset%" not found', array('%asset%' => $asset_path));
      }

      // calculate asset properties
      if (!$this->getFilename())
      {
         list(, $filename) = sfAssetsLibraryTools::splitPath($asset_path);
         $this->setFilename($filename);
      }

      // check folder
      if (!$this->getsfAssetFolder()->exists())
      {
         $this->getsfAssetFolder()->create();
      }
   
      // check if a file with this name already exists
      if ($checkDuplicate && sfAssetPeer::exists($this->getsfAssetFolder()->getId(), $this->getFilename()))
      {
         $this->setFilename(uniqid().'-'.$this->getFilename());
      }
      
      $this->setFilesize(filesize($asset_path) / 1024);

      $this->autoSetType();

      $full_path = sfAssetsLibraryTools::fixPath($this->getFullPath());
      
      stJQueryToolsHelper::pluploadCopy(sfAssetsLibraryTools::fixPath($asset_path), $full_path, $move);

      $old = umask(0);

      chmod($full_path, 0644);

      umask($old);
   }

   public function getFilepaths($for, $with_full = true)
   {
      $filepaths = $with_full ? array('full' => $this->getFullPath()) : array();
      
      if ($this->isImage())
      {
         $config = stConfig::getInstance(null, 'stAsset');

         $thumbnails = $config->get($for, array());

         // Add path to the thumbnails
         foreach ($thumbnails as $key => $params)
         {
            $filepaths[$key] = $this->getFullPath($key);
         }
      }

      return $filepaths;
   }

   /**
    * Change asset directory and/or name
    *
    * @param sfAssetFolder $new_folder
    * @param string $new_filename
    */
   public function move(sfAssetFolder $new_folder, $new_filename = null, $for = 'product')
   {
      if (sfAssetPeer::exists($new_folder->getId(), $new_filename ? $new_filename : $this->getFilename()))
      {
         throw new sfAssetException('The target folder "%folder%" already contains an asset named "%name%". The asset has not been moved.', array('%folder%' => $new_folder, '%name%' => $new_filename ? $new_filename : $this->getFilename()));
      }

      $old_filepaths = $this->getFilepaths($for);

      if ($new_filename)
      {
         if (sfAssetsLibraryTools::sanitizeName($new_filename) != $new_filename)
         {
            throw new sfAssetException('The filename "%name%" contains incorrect characters. The asset has not be altered.', array('%name%' => $new_filename));
         }
         $this->setFilename($new_filename);
      }
      $this->setFolderId($new_folder->getId());

      $success = true;

      foreach ($old_filepaths as $type => $filepath)
      {
         if (file_exists(sfAssetsLibraryTools::fixPath($filepath)))
         {
            $success = rename(sfAssetsLibraryTools::fixPath($filepath), sfAssetsLibraryTools::fixPath($this->getFullPath($type))) && $success;
         }
      }

      if (!$success)
      {
         throw new sfAssetException('Some or all of the file operations failed. It is possible that the moved asset or its thumbnails are missing.');
      }
   }

   /**
    * Physically remove assets
    */
   public function destroy($for = 'product', $with_full = true)
   {
      $success = true;
      foreach ($this->getFilepaths($for, $with_full) as $filepath)
      {
         $filepath = sfAssetsLibraryTools::fixPath($filepath);

         if (!is_file($filepath))
            continue;

         $success = unlink($filepath) && $success;
      }

      return $success;
   }

   public function delete($con = null, $for = 'product')
   {
      $success = $this->destroy($for);

      $this->deleteCropFile();
      
      parent::delete($con);

      return $success;
   }

   public function deleteCropFile()
   {
      $crop_file = $this->getFullPath().'.json';

      if (is_file($crop_file))
      {
         unlink($crop_file);
      }     

      $this->setCrop(array()); 
   }

   public function updateCropFile()
   {
      $crop_file = $this->getFullPath().'.json';
      file_put_contents($crop_file, json_encode($this->getCrop()));      
   }

   public function save($con = null)
   {
      if ($this->getCrop()) 
      {
         $this->updateCropFile();
      }

      return parent::save($con);
   }

   public function getDescription()
   {
      if ($this->getCulture() == stLanguage::getOptLanguage())
      {
         return stLanguage::getDefaultValue($this, __METHOD__);
      }
      $v = parent::getDescription();
      if (is_null($v))
         $v = stLanguage::getDefaultValue($this, __METHOD__);
      return $v;
   }

   public function setDescription($v)
   {
      if ($this->getCulture() == stLanguage::getOptLanguage())
      {
         stLanguage::setDefaultValue($this, __METHOD__, $v);
      }

      parent::setDescription($v);
   }   

   public static function clearStaticPool()
   {
      self::$folders = array();
   }

}
