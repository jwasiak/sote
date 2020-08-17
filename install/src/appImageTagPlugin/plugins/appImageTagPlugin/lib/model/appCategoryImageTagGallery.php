<?php

/**
 * Subclass for representing a row from the 'app_category_image_tag_gallery' table.
 *
 * 
 *
 * @package plugins.appImageTagPlugin.lib.model
 */ 
class appCategoryImageTagGallery extends BaseappCategoryImageTagGallery
{
    public function hasImage()
    {
        return null !== $this->image || null !== $this->getCategory()->getSfAssetId();
    }

    public function removeImage()
    {
        $file = appCategoryImageTagGalleryPeer::getImagePath($this->category_id, $this->image, true);

        if (is_file($file))
        {
            unlink($file);
        }

        $config = stConfig::getInstance(null, 'stAsset');

        $thumbnails = $config->get('app_image_tag', array());

        $file = appCategoryImageTagGalleryPeer::getImagePath($this->category_id, $this->image);

        $folder = dirname($file);
        $filename = basename($file);

        foreach ($thumbnails as $type => $params)
        {
            $file = sfAssetsLibraryTools::getThumbnailPath($folder, $filename, $type);

            if (is_file($file))
            {
                unlink($file);
            }            
        }

        $this->setImage(null);
    }

    public function createImage($source)
    {
        $filename = uniqid().'-'.basename($source);

        if (null === $this->category_id)
        {
            throw new Exception("First you must set category id using appCategoryImageTag::setCategoryId method");
        }

        $file = appCategoryImageTagGalleryPeer::getImagePath($this->category_id, $filename, true);
        $dir = dirname($file);

        if (!is_dir($dir))
        {
            mkdir($dir, 0755, true);
        }

        rename($source, $file);
        $this->setImage($filename);
    }

    public function getDescription()
    {
        if ($this->getCulture() == stLanguage::getOptLanguage())
        {
            return stLanguage::getDefaultValue($this, __METHOD__);
        }

        $v = parent::getDescription();

        if (null === $v) 
        {
            $v = stLanguage::getDefaultValue($this, __METHOD__);
        }
        
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

    public function getUrl()
    {
        if ($this->getCulture() == stLanguage::getOptLanguage())
        {
            return stLanguage::getDefaultValue($this, __METHOD__);
        }

        $v = parent::getUrl();

        if (null === $v) 
        {
            $v = stLanguage::getDefaultValue($this, __METHOD__);
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

    public function getImagePath($system = false)
    {
        if (null === $this->image && null !== $this->getCategory()->getSfAssetId())
        {
            $path = '/'.$this->getCategory()->getOptImage();

            if ($system)
            {
                return sfConfig::get('sf_web_dir').$path;
            }

            return $path;
        }

        return appCategoryImageTagGalleryPeer::getImagePath($this->category_id, $this->image, $system);
    }

    public function delete($con = null)
    {
        $ret = parent::delete($con);

        if (null === $this->image)
        {
            $tag = appCategoryImageTagPeer::retrieveByPK($this->getCategoryId());
            
            if (null !== $tag)
            {
                $tag->delete();
            }
        }

        $this->removeImage();

        return $ret;
    }  
}
