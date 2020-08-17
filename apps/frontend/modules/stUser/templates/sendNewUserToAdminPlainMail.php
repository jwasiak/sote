<?php $smarty->assign('user_id', $user->getId()) ?>

<?php $smarty->assign('user_name', $user->getUsername()) ?>

<?php $smarty->assign('user_head', $head) ?>

<?php $smarty->assign('user_foot', $foot) ?>

<?php $smarty->assign('user_created_at', $user->getCreatedAt()) ?>

<?php $smarty->display('user_send_new_user_to_admin_plain_mail.html') ?>