<?php
st_theme_use_stylesheet('stBoxPlugin.css');
$smarty->assign('id',$box->getId());
$smarty->assign('name',$box->getName());
$smarty->assign('content',$box->getContent());
$smarty->assign('show_title', $box->getShowTitle());
$smarty->assign('webmaster_id', $box->getWebmasterId());
$smarty->display('box_single.html');
?>