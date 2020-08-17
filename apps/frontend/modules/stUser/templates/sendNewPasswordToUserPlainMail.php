<?php $smarty->assign('user_name', $user) ?>

<?php $smarty->assign('user_submit', link_to(__('Zmień Hasło'), '@stChangePassForUser?hash_code=' . $hashCode, 'absolute=true')) ?>

<?php $smarty->display('user_send_new_password_to_user_plain_mail.html') ?>