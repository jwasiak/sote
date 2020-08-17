<?php
use_helper('Javascript');

$response = sfContext::getInstance()->getResponse();

$response->addJavascript('photoGallery/jquery.lightbox-0.5.js','last');
stTheme::useStylesheet('jquery.lightbox-0.5.css');

$config = stConfig::getInstance(sfContext::getInstance(), 'stAsset');

$galleryConfig = $config->get('gallery');


if($galleryConfig['zoom_on']==1)
{
   $response->addJavascript('photoGallery/jquery.jqzoom-core.js','last');
}
else
{
   $response->addJavascript('photoGallery/jquery.jqzoom-core-no-zoom.js','last');
}

stTheme::useStylesheet('jquery.jqzoom.css');
?>