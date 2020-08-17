<?php $smarty->assign('user_name', $user->getUsername()) ?>

<?php $smarty->assign('user_password', $password) ?>

<?php $smarty->assign('user_head', $head) ?>

<?php $smarty->assign('user_foot', $foot) ?>

<?php $smarty->assign('user_content_head', $head_content) ?>

<?php $smarty->assign('user_content_foot', $foot_content) ?>

<?php $smarty->assign('user_created_at', $user->getCreatedAt()) ?>

<?php $smarty->assign('user_submit', st_url_for('@stConfirmForUser?user=' . $user->getId() . '&hash_code=' . $user->getHashCode().'&language='.$languageShortcut, true)) ?>

<?php $smarty->display('user_send_new_user_to_user_plain_mail.html') ?>