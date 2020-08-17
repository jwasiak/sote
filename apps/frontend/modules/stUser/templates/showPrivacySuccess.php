<?php use_helper('stUrl'); ?>
<?php st_theme_use_stylesheet('stUser.css') ?>

<?php $smarty = new stSmarty('stUser') ?>

<?php $smarty->assign('webpage', $webpage) ?>

<?php $smarty->display('user_show_privacy.html') ?>