<?php 
use_helper('Validation', 'stCaptchaGD');
st_theme_use_stylesheet('stNewsletterPlugin.css');
use_javascript('jquery.infieldlabel.js', 'last');

$form['captcha'] = get_captcha('270');

$smarty->assign('form', $form);

$smarty->display('newsletter_unsubscribe.html'); 
?>