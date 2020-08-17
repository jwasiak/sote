<?php
use_helper('Date', 'stUrl');

$smarty->assign("host", $sf_request->getHost());
$smarty->assign("email", $user->getEmail());

$smarty->assign('date', date("d-m-Y H:i"));

$smarty->assign('user_head', $head);

$smarty->assign('user_foot', $foot);

$smarty->assign('bg_header_color', $mail_config->get('bg_header_color'));

$smarty->assign('bg_footer_color', $mail_config->get('bg_footer_color'));

$smarty->assign('bg_action_color', $mail_config->get('bg_action_color'));

$smarty->assign("register_message_templates", $newsletter_config->get('register_message_templates', null, true));

$smarty->assign("register_message_title", $newsletter_config->get('register_message_title', null, true));

$smarty->assign('bg_action_link_color', $mail_config->get('bg_action_link_color'));

$smarty->assign('link_color', $mail_config->get('link_color'));

$smarty->assign('logo', $mail_config->get('logo'));

$smarty->display("newsletter_mail_register_html.html");
?>