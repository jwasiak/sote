<?php 
use_helper('stUrl');
st_theme_use_stylesheet('stUser.css');
$smarty = new stSmarty('stUser');
$smarty->assign('webpage', $webpage);
$smarty->display('user_show_right_2_cancel.html');