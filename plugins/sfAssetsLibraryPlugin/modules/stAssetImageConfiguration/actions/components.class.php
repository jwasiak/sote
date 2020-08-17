<?php

class stAssetImageConfigurationComponents extends sfComponents 
{
    public function executeImageCropper()
    {
        if (!isset($this->asset) && !isset($this->trigger)) 
        {
            return sfView::NONE;
        }

        $image_types = sfAssetsLibraryTools::getCropImageTypes($this->for);

        if (!$image_types) 
        {
            return sfView::NONE;
        }

        if (!isset($this->namespace))
        {
            $this->namespace = uniqid();
        }

        $this->id = 'crop_overlay_'.$this->namespace;

        $this->image_types = $image_types;         
    }
}