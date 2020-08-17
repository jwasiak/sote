<?php
use_helper('Validation', 'stCaptchaGD', 'stUserPassValidation', 'stUrl');
use_javascript('jquery.infieldlabel.js', 'last');
st_theme_use_stylesheet('stUser.css');

if ($sf_request->getErrors()): 
$smarty->assign('errors', __('Uzupełnij zaznaczone pola.'));
endif;

$smarty->assign('login', $login);
$smarty->assign('form_start', form_tag(st_secure_url_for('stUser/createNewPassword'), array('class' => 'st_form_ver6')));

$smarty->assign('error_email', form_error('user[email]', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error')));
$smarty->assign('label_email', label_for('email',__('E-mail (login)')));
$smarty->assign('input_email', input_tag('user[email]', $login, array('id'=>'email','disabled'=>'disabled','class'=>form_has_error('user{email}') ? 'st_form-error' : '')));

$smarty->assign('error_password1', form_error('user[password1]', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error')));
$smarty->assign('label_password1', label_for('password1',__('Nowe hasło')));
$smarty->assign('input_password1', input_password_tag('user[password1]', $sf_params->get('user[password1]'), array('id'=>'password1','class'=>form_has_error('user{password1}') ? 'st_form-error' : '')));

$smarty->assign('error_password2', form_error('user[password2]', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error')));
$smarty->assign('label_password2', label_for('password2',__('Potwierdź hasło')));
$smarty->assign('input_password2', input_password_tag('user[password2]', $sf_params->get('user[password2]'), array('id'=>'password2','class'=>form_has_error('user{password2}') ? 'st_form-error' : '')));

if($config->get('captcha_on', stConfig::INT)==1  && sfContext::getInstance()->getUser()->getAttribute('captcha_off')!=1)
{
    $smarty->assign('captcha_on', $config->get('captcha_on', stConfig::INT)==1);
    $smarty->assign('error_captcha', form_error('captcha', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error')));
    $smarty->assign('get_captcha', get_captcha('270'));
    $smarty->assign('label_captcha', label_for('captcha',__('Cyfry z obrazka')));
    $smarty->assign('input_captcha', input_tag('captcha', '', array('id'=>'captcha','class'=>form_has_error('captcha') ? 'st_form-error' : '')));
}


$smarty->assign('error_email', $sf_request->getError('user{email}'));
$smarty->assign('error_password1', $sf_request->getError('user{password1}'));
$smarty->assign('error_password2', $sf_request->getError('user{password2}'));
$smarty->assign('error_captcha', $sf_request->getError('captcha'));


if(stTheme::is_responsive()):
    $smarty->assign('input_email', input_tag('user[email]', $login, array('id'=>'st_form-user-email','disabled'=>'disabled','class'=>'form-control')));
    $smarty->assign('input_password1', input_password_tag('user[password1]', $sf_params->get('user[password1]'), array('id'=>'st_form-user-password1', 'autocomplete'=>'off' , 'placeholder'=>"* ".__('Hasło'), 'maxlength'=>'255', 'class'=>'form-control')));
    $smarty->assign('input_password2', input_password_tag('user[password2]', $sf_params->get('user[password2]'), array('id'=>'st_form-user-password2', 'autocomplete'=>'off', 'placeholder'=>"* ".__('Potwierdź hasło'), 'maxlength'=>'255', 'class'=>'form-control')));
    $smarty->assign('input_captcha', input_tag('captcha', '', array('id'=>'captcha_img', 'placeholder'=>"* ".__('Cyfry z obrazka'), 'maxlength'=>'255', 'class'=>'form-control')));
endif;



$smarty->assign('hidden_hash_code', input_hidden_tag('hash_code', $hashCode));
$smarty->assign('register_new_password', submit_tag(__('Zmień hasło')));

$smarty->display('user_create_new_password.html');
?>