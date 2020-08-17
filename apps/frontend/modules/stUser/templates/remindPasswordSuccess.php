<?php use_helper('Validation', 'stCaptchaGD', 'stUrl'); ?>

<?php use_javascript('jquery.infieldlabel.js', 'last'); ?>
<?php st_theme_use_stylesheet('stUser.css') ?>

<?php if(!$send_true) : ?>

    <?php $smarty->assign('not_send_true', !$send_true) ?>
    
    <?php $smarty->assign('form_start', form_tag(st_secure_url_for('stUser/remindPassword'), array('class' => 'st_form_ver6'))) ?>
    
    <?php $smarty->assign('label_email', label_for('email',__('E-mail (login)'))) ?>
    
    <?php $smarty->assign('error_email', form_error('user[email]', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error'))) ?>
    
    <?php $smarty->assign('input_email', input_tag('user[email]',$sf_params->get('user[email]'), array('id'=>'email','class'=>form_has_error('user{email}') ? 'st_form-error' : ''))) ?>
    
    <?php if($config->get('captcha_on', stConfig::INT)==1  && sfContext::getInstance()->getUser()->getAttribute('captcha_off')!=1): ?>
    
        <?php $smarty->assign('captcha_on', $config->get('captcha_on', stConfig::INT)==1) ?>
    
        <?php $smarty->assign('error_captcha', form_error('captcha', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error'))) ?>
        
        <?php $smarty->assign('get_captcha', get_captcha("270")) ?>
        
        <?php $smarty->assign('label_captcha', label_for('captcha',__('Cyfry z obrazka'))) ?>
        
        <?php $smarty->assign('input_captcha', input_tag('captcha', '', array('id'=>'captcha','class'=>form_has_error('captcha') ? 'st_form-error' : ''))) ?> 
    
    <?php endif; ?>
    
    <?php $smarty->assign('remind_submit', submit_tag(__('Przypomnij'))) ?>                        

<?php else: ?>

    <?php $smarty->assign('email_send_to', $sf_params->get('user[email]')) ?>

<?php endif; ?>

<?php $smarty->assignPartial('privacy_link', 'stUser', 'privacy'); ?>

<?php 
if(stTheme::is_responsive()):
    $smarty->assign('input_email', input_tag('user[email]',  $sf_params->get('user[email]'), array('id'=>'st_form-user-email', 'placeholder'=>"* ".__('E-mail (login)'), 'maxlength'=>'255', 'class'=>'form-control')));
    $smarty->assign('input_captcha', input_tag('captcha', '', array('id'=>'captcha_img', 'placeholder'=>"* ".__('Cyfry z obrazka'), 'maxlength'=>'255', 'class'=>'form-control')));
endif;
?>

<?php
$smarty->assign('error_email', $sf_request->getError('user{email}'));
$smarty->assign('error_captcha', $sf_request->getError('captcha'));
?>

<?php $smarty->display('user_remind_password.html') ?>