<?php use_helper('Validation') ?>
<?php st_theme_use_stylesheet('stUser.css') ?>

<?php $smarty->assign('confirm', $confirm); ?>
                    
<?php $smarty->display('user_email_confirm.html'); ?>