<?php 
    use_helper('stJQueryTools');

   $images = array();

    if (!$slide_banner->isNew() && $slide_banner->getImage())
    {
        $images['/'.$slide_banner->getImagePath()] = '/'.$slide_banner->getImagePath();
    }
   
    echo plupload_images_tag('slider_banner_image', $images, array('crop' => 'slide', 'limit' => 1, 'cover' => false));
?>