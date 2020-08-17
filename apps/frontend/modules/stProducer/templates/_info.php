<?php
use_helper('stProducerImage');
st_theme_use_stylesheet('stProducer.css');
if($producer)
{
    $smarty->assign('name',$producer->getName());
    $smarty->assign('description',$producer->getDescription());
    $smarty->assign('photo', st_producer_image_tag($producer, 'large'));
    $smarty->display('producer_info.html');
}
?>
