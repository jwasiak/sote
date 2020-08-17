<?php
use_helper('Validation', 'stCaptchaGD');
st_theme_use_stylesheet('stNewsletterPlugin.css');


if(stTheme::is_responsive()):
    $smarty->assign("is_authenticated",sfContext::getInstance()->getUser()->isAuthenticated());
endif;

$smarty->assign("email",$newsletterUser->getEmail());
$smarty->assign("button_back",link_to(__('Wróć do zakupów'), '/'));
$smarty->display("newsletter_remove.html");
?>