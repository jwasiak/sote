<?php
use_helper('Validation', 'stCaptchaGD');
st_theme_use_stylesheet('stNewsletterPlugin.css');

$smarty->assign("email",$newsletterUser->getEmail());
$smarty->assign("register_message_on",$newsletter_config->get('register_message_on'));


$smarty->assign("button_back",link_to(__('Wróć do zakupów'), '/'));
$smarty->display("newsletter_confirm.html");
?>
