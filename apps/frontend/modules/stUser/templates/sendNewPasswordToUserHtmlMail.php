<?php use_helper('Date','stApplication', 'stUrl') ?>

<?php $smarty->assign('host', $sf_request->getHost()) ?>    

<?php $smarty->assign('user_name', $user->getUsername()) ?>

<?php $smarty->assign('user_password', $password) ?>

<?php $smarty->assign('user_head', $head) ?>

<?php $smarty->assign('user_foot', $foot) ?>

<?php $smarty->assign('user_content_head', $head_content) ?>

<?php $smarty->assign('user_content_foot', $foot_content) ?>

<?php $smarty->assign('user_link', st_url_for('@stGoToLogin', 'absolute=true for_app=frontend')) ?>

<?php $smarty->assign('bg_header_color', $mail_config->get('bg_header_color')) ?>

<?php $smarty->assign('bg_footer_color', $mail_config->get('bg_footer_color')) ?>

<?php $smarty->assign('bg_action_color', $mail_config->get('bg_action_color')) ?>

<?php $smarty->assign('bg_action_link_color', $mail_config->get('bg_action_link_color')) ?>

<?php $smarty->assign('link_color', $mail_config->get('link_color')) ?>

 <?php $smarty->assign('logo', $mail_config->get('logo')) ?>

<?php $smarty->assign('date', date("d-m-Y H:i"));?>


<?php $smarty->display('user_send_new_password_to_user_html_mail.html') ?>