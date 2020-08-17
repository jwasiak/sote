<?php
use_helper('stJQueryTools');

use_javascript('/plugins/appImageTagPlugin/js/jquery.taggd.js?v3');
use_stylesheet('/plugins/appImageTagPlugin/css/taggd.css?v3');
use_stylesheet('/plugins/appImageTagPlugin/css/backend.css?v3');
use_javascript('/jQueryTools/autocompleter/js/jquery.autocomplete.js?v3');
use_stylesheet('/jQueryTools/autocompleter/css/styles.css?v3');

function object_app_it_image(Category $category)
{
    $images = appCategoryImageTagGalleryPeer::doSelectImagesByCategory($category);

    if (!$images)
    {
        $tag = appCategoryImageTagPeer::retrieveByCategory($category);


        if (null === $tag)
        {
            $tag = new appCategoryImageTag();
            $tag->setCategory($category);
            $tag->resetModified();
        }

        if ($tag->hasImage())
        {
            $images = array($tag->getImagePath());
        }
    }

    return plupload_images_tag('app_it_images', $images, array('edit_url' => '@appImageTagBackend?category_id='.$category->getId().'&culture='.$category->getCulture()));    
}