<?php

/**
 * Subclass for representing a row from the 'app_category_image_tag' table.
 *
 * 
 *
 * @package plugins.appImageTagPlugin.lib.model
 */ 
class appCategoryImageTag extends BaseappCategoryImageTag
{
    protected $culture = null;

    public function hasImage()
    {
        return null !== $this->image || null !== $this->getCategory()->getSfAssetId();
    }

    public function getImagePath($system = false)
    {
        if (!$system && null === $this->image && null !== $this->getCategory()->getSfAssetId())
        {
            $path = '/'.$this->getCategory()->getOptImage();
        }
        else
        {
            $path = $this->getImageDir().'/'.$this->image;
        }

        if ($system)
        {
            return sfConfig::get('sf_web_dir').$path;
        }

        return $path;
    }

    public function getImageDir() 
    {
        return '/uploads/collections';
    }

    public function removeImage()
    {
        $file = $this->getImagePath(true);

        if (is_file($file))
        {
            unlink($file);
        }

        $this->setImage(null);
    }

    public function delete($con = null)
    {
        $ret = parent::delete($con);

        $this->removeImage();

        return $ret;
    }  

    public function setCulture($v)
    {
        $this->culture = $v;
    } 

    public function getCulture()
    {
        return $this->culture;
    }   

    public function getDescription()
    {
        return null;
    }

    public function getUrl()
    {
        return null;
    }

    public function getDescriptionColor()
    {
        return null;
    }
}
