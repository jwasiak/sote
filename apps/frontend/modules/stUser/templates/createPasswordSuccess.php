<?php use_helper('Validation', 'stCaptchaGD', 'stUserPassValidation', 'stUrl') ?>
<?php use_javascript('jquery.infieldlabel.js', 'last'); ?>
<?php st_theme_use_stylesheet('stUser.css') ?>

<?php $smarty->assign('login', $login) ?>
            
<?php $smarty->assign('form_start', form_tag(st_secure_url_for('stUser/createPassword'), array('class' => 'st_form_ver6'))) ?>
        
<?php $smarty->assign('error_email', form_error('user[email]', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error'))) ?>          

<?php $smarty->assign('label_email', label_for('st_form-user-email',__('E-mail (login)'))) ?>
      
<?php $smarty->assign('input_email', input_tag('user[email]', $login, array('id'=>'st_form-user-email','disabled'=>'disabled','class'=>form_has_error('user{email}') ? 'st_form-error' : ''))) ?> 

<?php $smarty->assign('input_hidden_email', input_hidden_tag('user[email]', $login)) ?>
                    
<?php $smarty->assign('error_password1', form_error('user[password1]', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error'))) ?>

<?php $smarty->assign('label_password1', label_for('st_form-user-password1',__('Hasło'))) ?>

<?php $smarty->assign('input_password1', input_password_tag('user[password1]', $sf_params->get('user[password1]'), array('id'=>'st_form-user-password1','class'=>form_has_error('user{password1}') ? 'st_form-error' : ''))) ?> 

<?php $smarty->assign('error_password2', form_error('user[password2]', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error'))) ?>

<?php $smarty->assign('label_password2', label_for('st_form-user-password2',__('Potwierdź hasło'))) ?>

<?php $smarty->assign('input_password2', input_password_tag('user[password2]', $sf_params->get('user[password2]'), array('id'=>'st_form-user-password2','class'=>form_has_error('user{password2}') ? 'st_form-error' : ''))) ?>


<?php if($config->get('captcha_on', stConfig::INT)==1  && sfContext::getInstance()->getUser()->getAttribute('captcha_off')!=1): ?>

    <?php $smarty->assign('captcha_on', $config->get('captcha_on', stConfig::INT)==1) ?>
                
    <?php $smarty->assign('error_captcha', form_error('captcha', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error'))) ?>

    <?php $smarty->assign('get_captcha', get_captcha('270')) ?>
                
    <?php $smarty->assign('label_captcha', label_for('captcha_img',__('Cyfry z obrazka'))) ?>

    <?php $smarty->assign('input_captcha', input_tag('captcha', '', array('id'=>'captcha_img','class'=>form_has_error('captcha') ? 'st_form-error' : ''))) ?>
    
<?php endif; ?>

<?php
$smarty->assign('error_email', $sf_request->getError('user{email}'));
$smarty->assign('error_password1', $sf_request->getError('user{password1}'));
$smarty->assign('error_password2', $sf_request->getError('user{password2}'));
$smarty->assign('error_captcha', $sf_request->getError('captcha'));
?>
            
<?php $smarty->assign('error_privacy', form_error('user[privacy]', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error'))) ?>
                
<?php $smarty->assign('checkbox_privacy', checkbox_tag('user[privacy]', 1, true, array('id'=>'st_form-user-privacy','class'=>form_has_error('user{privacy}') ? 'st_form-error' : ''))) ?> 

<?php $smarty->assignPartial('link_to_privacy', 'stUser', 'privacy'); ?>

<?php $smarty->assign('register_submit', submit_tag(__('Zarejestruj'))) ?>                        

<?php
 if(stTheme::is_responsive()):
    $smarty->assign('input_email', input_tag('user[email]', $login, array('id'=>'st_form-user-email','disabled'=>'disabled','class'=>'form-control')));
    $smarty->assign('input_password1', input_password_tag('user[password1]', $sf_params->get('user[password1]'), array('id'=>'st_form-user-password1', 'autocomplete'=>'off' , 'placeholder'=>"* ".__('Hasło'), 'maxlength'=>'255', 'class'=>'form-control')));
    $smarty->assign('input_password2', input_password_tag('user[password2]', $sf_params->get('user[password2]'), array('id'=>'st_form-user-password2', 'autocomplete'=>'off', 'placeholder'=>"* ".__('Potwierdź hasło'), 'maxlength'=>'255', 'class'=>'form-control')));
    $smarty->assign('input_captcha', input_tag('captcha', '', array('id'=>'captcha_img', 'placeholder'=>"* ".__('Cyfry z obrazka'), 'maxlength'=>'255', 'class'=>'form-control')));
endif;
?>

<?php $smarty->display('user_create_password.html') ?>