<?php
use_helper('Validation', 'stUrl');
st_theme_use_stylesheet('stUser.css');
$smarty->assign('form_start', tag('form', array('class' => 'st_form_ver6', 'action' => st_secure_url_for('stUser/LoginUserBasket'), 'method' => 'post'), true));

$smarty->assign('remind_password', link_to(__('Przypomnij hasło'), 'stUser/remindPassword'));

$smarty->assign('create_account', link_to(__('Zarejestruj się'), 'stUser/createAccount?basketReturn=1'));

$smarty->assign('error_email', form_error('user[email]', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error')));
$smarty->assign('label_email', label_for('st_form-user_basket-email',__('E-mail (login)')));
$smarty->assign('email', input_tag('user[email]', $sf_params->get('user[email]'), array('id'=>'st_form-user_basket-email','class'=>form_has_error('user{email}') ? 'st_form-error' : '')));

$smarty->assign('error_password', form_error('user[password]', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error')));
$smarty->assign('label_password', label_for('st_form-user_basket-password',__('Hasło')));
$smarty->assign('password', input_password_tag('user[password]',  $sf_params->get('user[password]'), array('id'=>'st_form-user_basket-password','class'=>form_has_error('user{email}') ? 'st_form-error' : '')));

$smarty->assign('error_email', $sf_request->getError('user{email}'));
$smarty->assign('error_password', $sf_request->getError('user{password}'));

$smarty->assign('login_submit',  submit_tag(__('Zaloguj'), array('name'=>'submit_login')));

$smarty->assign('login_show_error', $login_show_error);

$smarty->assign('login_google_on', $login_google_on);

$smarty->assign('google_url', stGooglePlusAccess::authUser('basket'));

$smarty->assign('form_google_start', tag('form', array('class' => 'st_form_ver6', 'action' => st_secure_url_for('stUser/googleSingIn'), 'method' => 'post'), true));

if(stTheme::is_responsive()):
    $smarty->assign('email', input_tag('user[email]', $sf_params->get('user[email]'), array('id'=>'st_form-user_basket-email', 'placeholder'=> __("E-mail"), 'maxlength'=>'255', 'class'=>'form-control')));
    $smarty->assign('password', input_password_tag('user[password]',  $sf_params->get('user[password]'), array('id'=>'st_form-user_basket-password', 'placeholder'=> __("Hasło"), 'maxlength'=>'255', 'class'=>'form-control')));
endif;

$smarty->display('user_basket_login.html');
?>