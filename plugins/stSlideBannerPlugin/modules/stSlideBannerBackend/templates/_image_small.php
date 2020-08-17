<?php 
    use_helper('stJQueryTools');

   $images = array();

    if (!$slide_banner->isNew() && $slide_banner->getImageSmall())
    {
        $images['/'.$slide_banner->getImageSmallPath()] = '/'.$slide_banner->getImageSmallPath();
    }
   
    echo plupload_images_tag('slider_banner_image_small', $images, array('crop' => 'slide_mobile', 'limit' => 1, 'cover' => false));
?>