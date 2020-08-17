<?php use_helper('Validation', 'stCaptchaGD') ?>
<?php st_theme_use_stylesheet('stUser.css') ?>

<?php $smarty->assign('form_start', form_tag('stUser/saveMigrationAccount', array('class' => 'st_form'))) ?>

<?php $smarty->assign('error_email', form_error('user[email]', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error'))) ?>          

<?php $smarty->assign('label_email', label_for('user[email]',__('E-mail (login)'))) ?>
      
<?php $smarty->assign('input_email', input_tag('user[email]',""), array('id'=>'st_form-user-email','class'=>form_has_error('user{email}') ? 'st_form-error' : '')) ?> 
                    
<?php $smarty->assign('hidden_old_login', input_hidden_tag('user[old_login]', $old_login)) ?>

<?php $smarty->assign('hidden_password', input_hidden_tag('user[password]', $password)) ?>

<?php $smarty->assign('register_submit', submit_tag(__('Zarejestruj'))) ?>    
                    
<?php $smarty->display('user_migration.html'); ?>