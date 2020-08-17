<?php
st_theme_use_stylesheet('stProductOptionsPlugin.css');
$smarty->assign('colors', $avail_colors);
$smarty->display('list_colors.html');
