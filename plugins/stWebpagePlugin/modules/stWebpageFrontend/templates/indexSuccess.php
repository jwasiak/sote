<?php
$version = $sf_context->getController()->getTheme()->getVersion();
use_helper('stUrl');

if ($version < 7)
{
    st_theme_use_stylesheet('stThemeDemo.css');
    st_theme_use_stylesheet('jquery.lightbox-0.5.css');
    use_javascript('photoGallery/textGallery.js', 'last');
    use_javascript('photoGallery/jquery.lightbox-0.5.js', 'last');
}

$smarty->assign('id', $webpage->getId());
$smarty->assign('content', $webpage->getContent());
$smarty->assign('content_name', $webpage->getName());
$smarty->assign('url', st_url_for('stWebpageFrontend/index?url='.$webpage->getFriendlyUrl()));



$smarty->display('webpage_show.html');
?>