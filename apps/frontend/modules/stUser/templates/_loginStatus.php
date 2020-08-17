<?php
use_helper('Validation', 'stUrl');
st_theme_use_stylesheet('stUser.css');

$smarty->assign('is_authenticated', $is_authenticated);
$smarty->assign('my_account', st_secure_link_to(__('Moje konto'), 'stUser/loginUser'));

if ($is_authenticated)
{
    $smarty->assign('account_type', $account_type);
    $smarty->assign('username', $username);
    $smarty->assign('points', st_secure_link_to(" / ".$points_value." ".$points_shortcut, 'stPointsFrontend/list'));
    $smarty->assign('logout', st_secure_link_to(__('Wyloguj'), 'stUser/logoutUser'));
    $smarty->assign('remove', st_secure_link_to(__('Usuń'), 'stUser/logoutUser'));
    $smarty->assign('external', st_theme_image_tag($externalAccount.'_icon.png'));
    $smarty->assign('points_system_is_active', $points_system_is_active);
    $smarty->assign('points_show', $points_show);
}


$smarty->display('user_login_status.html');
?>