<?php
use_helper('Date');
$smarty->assign("host", $sf_request->getHost());
$smarty->assign("email", $user->getEmail());
$smarty->display("newsletter_mail_register_plain.html");
?>