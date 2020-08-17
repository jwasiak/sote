<?php use_helper('Date') ?>

<?php $smarty->assign('host', $sf_request->getHost()) ?>

<?php $smarty->assign('contact_head', $head) ?>

<?php $smarty->assign('contact_foot', $foot) ?>

<?php $smarty->assign('contact_email', $contact['email']) ?>

<?php $smarty->assign('contact_name', $contact['name']) ?>

<?php $smarty->assign('contact_surname', $contact['surname']) ?>

<?php $smarty->assign('contact_phone', $contact['phone']) ?>

<?php $smarty->assign('contact_question', $contact['question']) ?>

<?php $smarty->display('contact_send_contact_html_mail.html') ?>