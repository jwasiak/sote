<?php use_helper('Date', 'stUrl') ?>

<?php $smarty->assign('host', $sf_request->getHost()) ?>

<?php $smarty->assign('user_name', $user->getUsername()) ?>

<?php $smarty->assign('user_head', $head) ?>

<?php $smarty->assign('user_foot', $foot) ?>

<?php $smarty->assign('bg_header_color', $mail_config->get('bg_header_color')) ?>

<?php $smarty->assign('bg_footer_color', $mail_config->get('bg_footer_color')) ?>

<?php $smarty->assign('bg_action_color', $mail_config->get('bg_action_color')) ?>

<?php $smarty->assign('bg_action_link_color', $mail_config->get('bg_action_link_color')) ?>

<?php $smarty->assign('link_color', $mail_config->get('link_color')) ?>

 <?php $smarty->assign('logo', $mail_config->get('logo')) ?>

<?php $smarty->assign('user_created_at', date("d-m-Y H:i", strtotime($user->getCreatedAt()))) ?>

<?php $smarty->assign('user_submit', st_url_for('@stConfirmDeleteForUser?user=' . $user->getId() . '&hash_code=' . $user->getHashCode().'&language='.$languageShortcut, 'absolute=true')) ?>

<?php $smarty->display('user_send_request_user_confirm_delete_html_mail.html') ?>
