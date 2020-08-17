<?php
use_helper('Validation', 'stCaptchaGD');
st_theme_use_stylesheet('stUser.css');

$smarty->assign('login_link', link_to(__('Przejdź do strony logowania'), 'user/loginUser'));
$smarty->assign('email', $email);


$smarty->display('user_confirm_send_password.html');
?>