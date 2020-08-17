<?php 
    use_helper('stJQueryTools');

   $images = array();

    if (!$blog->isNew() && $blog->getImageMainPage() && null === $blog->getGallery())
    {
        $images[$blog->getImageMainPage()] = '/'.$blog->getImagePath();
    }
    elseif (!$blog->isNew() && $blog->getGallery())
    {
        foreach ($blog->getGallery() as $index => $image) {
            $images[$image] = '/'.$blog->getGalleryPath($image);
        }
    }
       
    echo plupload_images_tag('blog_image_main_page', $images, array('crop' => 'false', 'limit' => 9, 'cover' => true)); 

?>