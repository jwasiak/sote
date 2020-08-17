<?php 
    use_helper('stProducerImage', 'stJQueryTools');

   $images = array();

    if (!$producer->isNew() && $producer->getSfAsset())
    {
        $images[$producer->getSfAssetId()] = st_producer_image_path($producer, 'full');
    }
   
    echo plupload_images_tag('producer_images', $images, array('crop' => 'producer', 'limit' => 1));
?>