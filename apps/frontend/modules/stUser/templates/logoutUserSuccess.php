<?php use_helper('Validation','stUrl') ?>

<?php st_theme_use_stylesheet('stUser.css') ?>

<?php $smarty->assign('username', $username) ?>

<?php $smarty->assign('redirect', SF_ENVIRONMENT != 'theme') ?> 

<?php $smarty->display('user_logout_user.html') ?>