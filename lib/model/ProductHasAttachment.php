<?php

/**
 * Subclass for representing a row from the 'st_product_has_attachment' table.
 *
 * 
 *
 * @package lib.model
 */
class ProductHasAttachment extends BaseProductHasAttachment
{

   protected
   $attachmentEditFilename = null,
   $description = null,
   $modifyUpdateAt = false;

   public function getAttachment()
   {
      return $this->getsfAsset();
   }

   public function getFilename()
   {
      return $this->getSfAssetId() ? $this->getsfAsset()->getFilename() : null;
   }

   public function changeFilename($v)
   {
      if ($this->getSfAssetId())
      {
         $this->getsfAsset()->setFilename($v);
      }
      else
      {
         throw new sfException("You must create an asset first");
      }
   }

   public function getPath()
   {
      return $this->getSfAssetId() ? $this->getsfAsset()->getPath() : null;
   }

   public function setAttachmentEditFilename($v)
   {
      $this->attachmentEditFilename = $v;
   }

   public function getAttachmentEditFilename()
   {
      if (!$this->attachmentEditFilename && $this->sf_asset_id)
      {
         return $this->getsfAsset()->getFilename(true);
      }

      return $this->attachmentEditFilename;
   }

   public function getAttachmentListFilesize()
   {
      return $this->getsfAsset() ? $this->getsfAsset()->getFilesize(true) : null;
   }

   public function setAttachmentEditLanguage($v)
   {
      $this->setLanguageId($v);
   }

   public function setDescription($v)
   {
      $this->description = $v;
   }

   public function getDescription()
   {
      if ($this->getsfAssetId())
      {
         $this->getsfAsset()->setCulture($this->getAssetCulture());
         return $this->getsfAsset()->getDescription();
      }

      return $this->description;
   }

   public function setLanguageId($v)
   {
      parent::setLanguageId($v);

      if ($this->getLanguage())
      {
         $this->setOptCulture($this->getLanguage()->getOriginalLanguage());
      }
   }

   public function getAssetCulture()
   {
      return $this->getOptCulture();
   }

   public function createAsset($source_file, $filename, $check_duplicate = true)
   {
      $asset = $this->getsfAsset();

      if (!$asset)
      {
         $asset = new sfAsset();
      }
      else
      {
         $asset->destroy();

         $this->modifyUpdateAt = true;
      }

      $asset->setFilename($filename);

      $product = $this->getProduct();

      $path = 'media/products/'.$product->getAssetFolder().'/attachments/'.$this->getOptCulture();

      $folder = sfAssetFolderPeer::retrieveByPath($path);

      if (!$folder)
      {
         $folder = sfAssetFolderPeer::createFromPath($path);
      }

      $asset->setFolderId($folder->getId());

      $asset->create($source_file, true, $check_duplicate);

      $this->setsfAsset($asset);
   }

   public function renameAsset($custom_filename)
   {
      $asset = $this->getsfAsset();

      $ext = sfAssetsLibraryTools::getFileExtension($asset->getFilename());

      if ($asset->getFilename(true) != $custom_filename)
      {
         $custom_filename = $custom_filename.'.'.$ext;

         $asset->move($asset->getsfAssetFolder(), $custom_filename);
      }

      return $asset;
   }

   public function save($con = null)
   {
      if (!$this->modifyUpdateAt)
      {
         $this->modifiedColumns[] = ProductHasAttachmentPeer::UPDATED_AT;
      }

      if ($this->description && $this->getsfAsset())
      {
         $this->getsfAsset()->setCulture($this->getAssetCulture());
         $this->getsfAsset()->setDescription($this->description);

      }elseif(!$this->description && $this->getsfAsset())
      {
         $this->getsfAsset()->setCulture($this->getAssetCulture());
         $this->getsfAsset()->setDescription("");
      }


      parent::save($con);
   }
}
