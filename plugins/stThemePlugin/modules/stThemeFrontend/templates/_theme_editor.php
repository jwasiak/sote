<?php 
use_helper('stUrl'); 
$smarty = new stSmarty('stThemeFrontend');
$smarty->assign('return_url', $return_url);
$smarty->assign('logout_url', st_url_for('stUser/logoutUser'));
$smarty->assign('theme', $theme);
$smarty->assign('notice', $sf_flash->get('theme_notice'));
$smarty->assign('restore_slots_url', st_url_for('stSmartyFrontend/restoreSlots'));
$smarty->display('theme_editor.html');
?>