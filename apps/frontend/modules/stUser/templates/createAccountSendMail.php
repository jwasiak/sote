<?php
$smarty->assign('day', substr($change_date, 0, 10));
$smarty->assign('hour', substr($change_date, 10));
$smarty->assign('login', $to);
$smarty->assign('password', $password);

$smarty->display('user_create_account_send_mail.html');
?>