<?php 
    use_helper('stCategoryImage', 'stJQueryTools');

   $images = array();

    if (!$category->isNew() && $category->getSfAsset())
    {
        $images[$category->getSfAssetId()] = st_category_image_path($category, 'full');
    }
   
    echo plupload_images_tag('category_images', $images, array('crop' => 'category', 'limit' => 1));
?>