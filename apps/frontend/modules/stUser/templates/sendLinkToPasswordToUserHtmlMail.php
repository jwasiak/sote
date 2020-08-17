<?php use_helper('Date','stApplication', 'stUrl') ?>

<?php $smarty->assign('host', $sf_request->getHost()) ?>    

<?php $smarty->assign('user_name', $user) ?>

<?php $smarty->assign('user_submit', st_url_for('@stChangePassForUser?hash_code=' . $hashCode, 'absolute=true')) ?>

<?php $smarty->assign('user_head', $head) ?>

<?php $smarty->assign('user_foot', $foot) ?>


<?php $smarty->assign('bg_header_color', $mail_config->get('bg_header_color')) ?>

<?php $smarty->assign('bg_footer_color', $mail_config->get('bg_footer_color')) ?>

<?php $smarty->assign('bg_action_color', $mail_config->get('bg_action_color')) ?>

<?php $smarty->assign('bg_action_link_color', $mail_config->get('bg_action_link_color')) ?>

<?php $smarty->assign('link_color', $mail_config->get('link_color')) ?>

 <?php $smarty->assign('logo', $mail_config->get('logo')) ?>


<?php $smarty->assign('date', date("d-m-Y H:i"));?>

<?php $smarty->display('user_send_link_to_change_password_to_user_html_mail.html') ?>