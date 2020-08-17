<?php 
st_theme_use_stylesheet('stSocialLinksPlugin.css');

$smarty->assign("facebook", $config->get('facebook', null, true));
$smarty->assign("twitter", $config->get('twitter', null, true));
$smarty->assign("youtube", $config->get('youtube', null, true));
$smarty->assign("google", null);
$smarty->assign("instagram", $config->get('instagram', null, true));
$smarty->assign("pinterest", $config->get('pinterest', null, true));
$smarty->assign("allegro", $config->get('allegro', null, true));
$smarty->assign("newsletter", $config->get('newsletter'));

$smarty->display("show.html")
?>