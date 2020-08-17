<?php
st_theme_use_stylesheet('stBoxPlugin.css');

foreach ($boxes as $box)
{
    echo st_get_component('stBoxFrontend','boxSingle',array('id'=>$box->getId()));
}
?>
