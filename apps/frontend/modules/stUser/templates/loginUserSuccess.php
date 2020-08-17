<?php
use_helper('Validation','stUrl');
st_theme_use_stylesheet('stUser.css');
use_javascript('jquery.infieldlabel.js', 'last');
$smarty->assign('new_user_icon', st_theme_image_tag('icon_new_user.gif'));
$register_url = st_secure_url_for('stUser/createAccount');
$smarty->assign('register_link', content_tag('a', __('Zarejestruj się'), array('href' => $register_url)));

//default2
$smarty->assign('register_url', $register_url);
$smarty->assign('form_start', tag('form', array('class' => 'st_form_ver6', 'action' => st_secure_url_for('stUser/loginUser'), 'method' => 'post'), true));
$smarty->assign('error_email', form_error('user[email]', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error')));
$smarty->assign('label_email', label_for('st_form-user-email',__('E-mail (login)')));
$smarty->assign('input_email', input_tag('user[email]', $sf_params->get('user[email]'), array('id'=>'st_form-user-email','class'=>form_has_error('user{email}') ? 'st_form-error' : '')));
$smarty->assign('error_password', form_error('user[password]', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error')));
$smarty->assign('label_password', label_for('st_form-user-password',__('Hasło')));
$smarty->assign('input_password', input_password_tag('user[password]', $sf_params->get('user[password]'), array('id'=>'st_form-user-password','class'=>form_has_error('user{password}') ? 'st_form-error' : '')));
$smarty->assign('login_submit', submit_tag(__('Zaloguj')));
$smarty->assign('remind_password_link', link_to(__('Przypomnij hasło'), 'stUser/remindPassword'));

$smarty->assign('error_email', $sf_request->getError('user{email}'));
$smarty->assign('error_password', $sf_request->getError('user{password}'));

$user_config = stConfig::getInstance(sfContext::getInstance(), 'stUser');
$login_google_on = $user_config->get('google_auth_on');
$smarty->assign('login_google_on', $login_google_on);        
$smarty->assign('google_url', stGooglePlusAccess::authUser('create'));

if ($sf_request->getErrors()): 
$smarty->assign('login_show_error', 1);
endif;

if(stTheme::is_responsive()):
    $smarty->assign('input_email', input_tag('user[email]', $sf_params->get('user[email]'), array('id'=>'st_form-user-email', 'placeholder'=>__('E-mail (login)'), 'maxlength'=>'255', 'class'=>'form-control')));
    $smarty->assign('input_password', input_password_tag('user[password]', $sf_params->get('user[password]'), array('id'=>'st_form-user-password', 'placeholder'=>__('Hasło'), 'maxlength'=>'255', 'class'=>'form-control')));
endif;

$smarty->assignPartial('privacy_link', 'stUser', 'privacy');

$smarty->display('user_login_user.html');
?>