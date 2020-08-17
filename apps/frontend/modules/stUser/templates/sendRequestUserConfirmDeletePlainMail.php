<?php $smarty->assign('user_name', $user->getUsername()) ?>

<?php $smarty->assign('user_head', $head) ?>

<?php $smarty->assign('user_foot', $foot) ?>

<?php $smarty->assign('user_created_at', $user->getCreatedAt()) ?>

<?php $smarty->assign('user_submit', link_to(__('Potwierdź usunięcie konta'), '@stConfirmDeleteForUser?user=' . $user->getId() . '&hash_code=' . $user->getHashCode().'&language='.$languageShortcut, 'absolute=true')) ?>

<?php $smarty->display('user_send_request_user_confirm_delete_plain_mail.html') ?>
