<?php 
st_theme_use_stylesheet('stTrustedShopsPlugin.css');
$smarty->assign('certificate', $certificate);
$smarty->display('trusted_shops_show_rating_widget.html');
