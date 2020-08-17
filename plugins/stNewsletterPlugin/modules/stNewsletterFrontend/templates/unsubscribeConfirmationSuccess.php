<?php 
$smarty->assign('message', __('Na twój adres "%%email%%" został wysłany link potwierdzający wypisanie się z newslettera.', array('%%email%%' => $email)));
$smarty->display('newsletter_unsubscribe_confirmation.html') 
?>