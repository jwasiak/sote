<?php 
use_helper('stJQueryTools');
$tag = appCategoryImageTagPeer::retrieveByPK($category->getId());
$images = array();
if ($tag && $tag->hasImage())
{
    $images[] = $tag->getImagePath();
}

echo plupload_images_tag('tag_images', $images, array('edit_url' => '@appImageTagBackend'));
?>