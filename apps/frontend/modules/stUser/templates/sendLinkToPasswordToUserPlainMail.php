<?php $smarty->assign('user_name', $user) ?>

<?php $smarty->assign('user_submit', link_to(__('Zmień hasło'), '@stChangePassForUser?hash_code=' . $hashCode, 'absolute=true')) ?>

<?php $smarty->display('user_send_link_to_change_password_to_user_plain_mail.html') ?>