<?php use_helper('Validation', 'stUserPassValidation', 'stUrl') ?>
<?php st_theme_use_stylesheet('stUser.css') ?>
<?php use_javascript('jquery.infieldlabel.js', 'last') ?>



<?php $smarty->assign('my_account', link_to(__('Moje konto'), 'stUserData/userPanel')) ?>

<?php $smarty->assign('user_panel_menu', st_get_component('stUserData', 'userPanelMenu')) ?>

<?php $smarty->assign('form_start', '<form method="post" action="'.st_secure_url_for('stUser/editLogin').'" class="st_form_ver6">') ?>

<?php $smarty->assign('error_email', $sf_request->getError('user{email}')) ?>

<?php $smarty->assign('label_email', label_for('email',__('E-mail (login)'))) ?>

<?php $smarty->assign('input_email', input_tag('user[email]', $email, array('id'=>'email','class'=>form_has_error('user{email}') ? 'st_form-error' : ''))) ?>

<?php $smarty->assign('salt', $salt) ?> 

                        
                            
<?php $smarty->assign('form_start_2', '<form method="post" action="'.st_secure_url_for('stUser/editPassword').'" class="st_form_ver6" autocomplete="off">') ?>
    
<?php $smarty->assign('label_user_oldpassword', label_for('oldpassword',__('Stare hasło'))) ?>    

<?php $smarty->assign('error_user_oldpassword', $sf_request->getError('user{oldpassword}')) ?>

<?php $smarty->assign('input_user_oldpassword', input_password_tag('user[oldpassword]',  $sf_params->get('user[oldpassword]'), array('id'=>'oldpassword', 'autocomplete'=>'off','class'=>form_has_error('user{oldpassword}') ? 'st_form-error' : ''))) ?> 
            
<?php $smarty->assign('label_user_password1', label_for('password1',__('Nowe hasło'))) ?>

<?php $smarty->assign('error_user_password1', $sf_request->getError('user{password1}')) ?>

<?php $smarty->assign('input_user_password1',input_password_tag('user[password1]', $sf_params->get('user[password1]'), array('id'=>'password1', 'autocomplete'=>'off','class'=>form_has_error('user{password1}') ? 'st_form-error' : ''))) ?>  


<?php $smarty->assign('label_user_password2', label_for('password2',__('Potwierdź hasło'))) ?>

<?php $smarty->assign('error_user_password2', $sf_request->getError('user{password2}')) ?>

<?php $smarty->assign('input_user_password2', input_password_tag('user[password2]', $sf_params->get('user[password2]'), array('id'=>'password2', 'autocomplete'=>'off','class'=>form_has_error('user{password2}') ? 'st_form-error' : ''))) ?>


<?php if(stTheme::is_responsive()): ?>
     
<?php $smarty->assign('input_email', input_tag('user[email]', $email, array('id'=>'email', 'placeholder'=> __('E-mail (login)'), 'maxlength'=>'255', 'class'=>'form-control'))); ?>

<?php $smarty->assign('input_user_oldpassword', input_password_tag('user[oldpassword]',  $sf_params->get('user[oldpassword]'), array('id'=>'oldpassword', 'autocomplete'=>'off', 'placeholder'=> __('Stare hasło'), 'maxlength'=>'255', 'class'=>'form-control'))); ?>
    
<?php $smarty->assign('input_user_password1',input_password_tag('user[password1]', $sf_params->get('user[password1]'), array('id'=>'password1', 'autocomplete'=>'off', 'placeholder'=> __('Nowe hasło'), 'maxlength'=>'255', 'class'=>'form-control'))); ?> 

<?php $smarty->assign('input_user_password2', input_password_tag('user[password2]', $sf_params->get('user[password2]'), array('id'=>'password2', 'autocomplete'=>'off', 'placeholder'=> __('Potwierdź hasło'), 'maxlength'=>'255', 'class'=>'form-control'))); ?>   
    
<?php endif; ?>
    
    
       
   

<?php
 	if($userDataBilling)
	{
 
    $smarty->assign('billing_company', $userDataBilling->getCompany());
	$smarty->assign('billing_vat_number', $userDataBilling->getVatNumber());
    $smarty->assign('billing_full_name', $userDataBilling->getFullName());
    $smarty->assign('billing_address', $userDataBilling->getAddress());
    $smarty->assign('billing_address_more', $userDataBilling->getAddressMore());
    $smarty->assign('billing_region', $userDataBilling->getRegion());
    $smarty->assign('billing_code', $userDataBilling->getCode());
    $smarty->assign('billing_town', $userDataBilling->getTown());
    $smarty->assign('billing_country', $userDataBilling->getCountries());
	$smarty->assign('billing_phone', $userDataBilling->getPhone());  
	$smarty->assign('billing_pesel', $userDataBilling->getPesel());
  
  	$billing_edit_url = st_url_for('stUserData/editProfile?userDataType=billing&userDataId='.$userDataBilling->getId().'&showEditProfileForm=true');  
    $smarty->assign('billing_edit_url', $billing_edit_url);
	}
?>

<?php
 	if($userDataDelivery)
	{
    $smarty->assign('delivery_company', $userDataDelivery->getCompany());
    $smarty->assign('delivery_full_name', $userDataDelivery->getFullName());
    $smarty->assign('delivery_address', $userDataDelivery->getAddress());
    $smarty->assign('delivery_address_more', $userDataDelivery->getAddressMore());
    $smarty->assign('delivery_region', $userDataDelivery->getRegion());
    $smarty->assign('delivery_code', $userDataDelivery->getCode());
    $smarty->assign('delivery_town', $userDataDelivery->getTown());
    $smarty->assign('delivery_country', $userDataDelivery->getCountries());
	$smarty->assign('delivery_phone', $userDataDelivery->getPhone());  
  
  	$delivery_edit_url = st_url_for('stUserData/editProfile?userDataType=delivery&userDataId='.$userDataDelivery->getId().'&showEditProfileForm=true');
    $smarty->assign('delivery_edit_url', $delivery_edit_url);
    }
?>

<?php if($showMessage == true): ?>
    <?php $smarty->assign('show_message', $showMessage) ?>
<?php endif; ?>

<?php $smarty->display('user_edit_account.html'); ?>