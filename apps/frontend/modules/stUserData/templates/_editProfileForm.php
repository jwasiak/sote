<?php use_helper('Validation', 'Object') ?>
<?php st_theme_use_stylesheet('stUser.css') ?>
<?php use_javascript('jquery.infieldlabel.js', 'last') ?>
<?php $user_config = stConfig::getInstance(sfContext::getInstance(), 'stUser'); ?>

<?php $smarty->assign('show_region', $show_region);?>
<?php $smarty->assign('show_pesel', $show_pesel);?>
<?php $smarty->assign('show_address_more', $show_address_more);?>

<?php $smarty->assign('form_start', form_tag('stUserData/saveProfile', array('class' => 'st_form_ver6', 'name'=>'register'))) ?>
<?php $smarty->assign('error_message', form_error('user_data[message]', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error'))) ?>        
<?php $smarty->assign('error_company', form_error('user_data[company]', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error'))) ?>        
<?php $smarty->assign('error_full_name', form_error('user_data[full_name]', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error'))) ?>
<?php $smarty->assign('error_address', form_error('user_data[address]', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error'))) ?>
<?php $smarty->assign('error_address_more', form_error('user_data[address_more]', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error'))) ?>
<?php $smarty->assign('error_region', form_error('user_data[region]', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error'))) ?>
<?php $smarty->assign('error_code', form_error('user_data[code]', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error'))) ?>        
<?php $smarty->assign('error_town', form_error('user_data[town]', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error'))) ?>        
<?php $smarty->assign('error_phone', form_error('user_data[phone]', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error'))) ?>        
<?php $smarty->assign('error_vat', form_error('user_data[vat_number]', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error'))) ?>

<?php $smarty->assign('error_company', $sf_request->getError('user_data{company}')); ?>
<?php $smarty->assign('error_nip', $sf_request->getError('user_data{vat_number}')); ?>
<?php $smarty->assign('error_full_name', $sf_request->getError('user_data{full_name}')); ?>
<?php $smarty->assign('error_address', $sf_request->getError('user_data{address}')); ?>
<?php $smarty->assign('error_region', $sf_request->getError('user_data{region}')); ?>
<?php $smarty->assign('error_code_town', $sf_request->getError('user_data{code}').$sf_request->getError('user_data{town}')); ?>
<?php $smarty->assign('error_code', $sf_request->getError('user_data{code}')); ?>
<?php $smarty->assign('error_town', $sf_request->getError('user_data{town}')); ?>
<?php $smarty->assign('error_phone', $sf_request->getError('user_data{phone}')); ?>


<?php if ($userData->getIsBilling()==1): ?>
    <?php $smarty->assign('billing_data', $userData->getIsBilling()==1) ?>
<?php endif; ?>

<?php $smarty->assign('label_customer_type1', __('Klient indywidualny')) ?>
<?php $smarty->assign('radio_customer_type1', radiobutton_tag('user_data[customer_type]', 1, $type1_checker)) ?>

<?php $smarty->assign('label_customer_type2', __('Firma')) ?>
<?php $smarty->assign('radio_customer_type2', radiobutton_tag('user_data[customer_type]', 2, $type2_checker)) ?>

<?php $smarty->assign('label_company', label_for('company',"* ".__('Firma'))) ?>
<?php $smarty->assign('input_company', input_tag('user_data[company]', $userData->getCompany(), array('id'=>'company', 'maxlength'=>'255', 'class'=>form_has_error('user_data{company}') ? 'st_form-error' : ''))) ?>
 
<?php $smarty->assign('label_full_name', label_for('full_name',"* ".__('Imię i nazwisko'), array('id'=>'full_name_label'))) ?>
<?php $smarty->assign('label_full_name_text', __('Imię i nazwisko')); ?>
<?php $smarty->assign('input_full_name', input_tag('user_data[full_name]', $userData->getFullName(), array('id'=>'full_name', 'maxlength'=>'255', 'class'=>form_has_error('user_data{full_name}') ? 'st_form-error' : ''))) ?>

<?php $smarty->assign('label_address', label_for('address',"* ".__('Ulica nr domu / nr lokalu'))) ?>
<?php $smarty->assign('input_address',  input_tag('user_data[address]', $userData->getAddress(), array('id'=>'address', 'maxlength'=>'255', 'class'=>form_has_error('user_data{address}') ? 'st_form-error' : ''))) ?>

<?php $smarty->assign('label_address_more', label_for('address_more',__('Adres ciąg dalszy'))) ?>
<?php $smarty->assign('input_address_more',  input_tag('user_data[address_more]', $userData->getAddressMore(), array('id'=>'address_more', 'maxlength'=>'255', 'class'=>form_has_error('user_data{address_more}') ? 'st_form-error' : ''))) ?>

<?php $smarty->assign('label_region', label_for('region',__('Województwo'))) ?>
<?php $smarty->assign('input_region', input_tag('user_data[region]', $userData->getRegion(), array('id'=>'region', 'maxlength'=>'255'))) ?>

<?php $smarty->assign('label_pesel', label_for('pesel',__('PESEL'))) ?>
<?php $smarty->assign('input_pesel', input_tag('user_data[pesel]', $userData->getPesel(), array('id'=>'pesel', 'maxlength'=>'255'))) ?>

<?php $smarty->assign('label_code', label_for('code',"* ".__('Kod'))) ?>
<?php $smarty->assign('input_code', input_tag('user_data[code]', $userData->getCode(), array('id'=>'code', 'maxlength'=>'255', 'class'=>form_has_error('user_data{code}') ? 'st_form-error code' : 'code'))) ?>

<?php $smarty->assign('label_town', label_for('town',"* ".__('Miasto'))) ?>
<?php $smarty->assign('input_town', input_tag('user_data[town]', $userData->getTown(), array('id'=>'town', 'maxlength'=>'255', 'class'=>form_has_error('user_data{town}') ? 'st_form-error town' : 'town'))) ?>
 
<?php $smarty->assign('label_country', label_for('st_form-userData-field6',__('Kraj'))) ?>

<?php if ($userData->getIsBilling()!=1): ?>

    <?php if ($userData->getAddress()==""): ?>

        <?php $smarty->assign('select_country',  st_get_component('stUserData', 'deliveryCountriesSelect', array('id'=>'user_data_country','force_default_country_id' => $userData->getCountriesId()))) ?>                

    <?php else: ?>
    
        <?php $smarty->assign('select_country', object_select_tag($userData->getCountriesId(), 'getId', array('id'=>'user_data_country', 'related_class' => 'Countries', 'peer_method'=>"doSelectActive", 'control_name' => 'user_data[country]'))) ?>                
    
    <?php endif; ?>
    
<?php else: ?>
    
    <?php $smarty->assign('select_country', object_select_tag($userData->getCountriesId(), 'getId', array('id'=>'user_data_country', 'related_class' => 'Countries', 'peer_method'=>"doSelectActive", 'control_name' => 'user_data[country]'))) ?>                
    
<?php endif; ?>

<?php
if($user_config->get('validate_phone')==1){ 
    $smarty->assign('label_phone', label_for('phone',"* ".__('Telefon')));
}else{
    $smarty->assign('label_phone', label_for('phone',__('Telefon')));
} 
?>

<?php $smarty->assign('input_phone', input_tag('user_data[phone]', $userData->getPhone(), array('id'=>'phone', 'maxlength'=>'255', 'class'=>form_has_error('user_data{phone}') ? 'st_form-error' : ''))) ?>
 
<?php $smarty->assign('label_nip', label_for('nip',"* ".__($sf_user->hasVatEu() ? 'VAT UE' : 'NIP'))) ?>
<?php $smarty->assign('input_nip', input_tag('user_data[vat_number]', $userData->getVatNumber(), array('id'=>'nip', 'maxlength'=>'255', 'class'=>form_has_error('user_data{vat_number}') ? 'st_form-error' : ''))) ?>

<?php $smarty->assign('hidden_is_default', input_hidden_tag('user_data[isDefault]', $userData->getIsDefault())) ?>

<?php if(stTheme::is_responsive()): ?>

<?php if ($userData->getIsBilling()==1): ?>
<?php $smarty->assignComponent('edit_profiles', 'stUserData', 'profileList', array('type' => 'user_edit_profile_billing', 'selected' => $sf_request->getParameter('user_billing_profile'))); ?>
<?php else: ?>
<?php $smarty->assignComponent('edit_profiles', 'stUserData', 'profileList', array('type' => 'user_edit_profile_delivery', 'selected' => $sf_request->getParameter('user_delivery_profile'))); ?>
<?php endif; ?>

<?php if($showMessage == true): ?>
    <?php $smarty->assign('show_message', $showMessage) ?>
<?php endif; ?>

<?php $user_config->get('validate_phone')==1 ? $phone_label = "* ".__('Telefon') : $phone_label = __('Telefon'); ?>
    
<!-- billing -->    
<?php $smarty->assign('input_company', input_tag('user_data[company]',  $userData->getCompany(), array('id'=>'company', 'placeholder'=> '* '.__("Firma"), 'maxlength'=>'255', 'class'=>'form-control'))); ?>
<?php $smarty->assign('input_nip', input_tag('user_data[vat_number]', $userData->getVatNumber(), array('id'=>'nip','placeholder'=> "* ".__($sf_user->hasVatEu() ? "Numer VAT UE" : "NIP"), 'maxlength'=>'255', 'class'=>'form-control'))) ?>
<?php $smarty->assign('input_full_name', input_tag('user_data[full_name]', $userData->getFullName(), array('id'=>'full_name', 'placeholder'=> "* ".__('Imię i nazwisko'), 'maxlength'=>'255', 'class'=>'form-control'))); ?>
<?php $smarty->assign('input_address', input_tag('user_data[address]', $userData->getAddress(), array('id'=>'address', 'placeholder'=> '* '.__("Ulica nr domu / nr lokalu"), 'maxlength'=>'255', 'class'=>'form-control'))); ?>
<?php $smarty->assign('input_address_more', input_tag('user_data[address_more]', $userData->getAddressMore(), array('id'=>'address_more', 'placeholder'=>__("Adres ciąg dalszy"), 'maxlength'=>'255', 'class'=>'form-control'))); ?>
<?php $smarty->assign('input_region', input_tag('user_data[region]', $userData->getRegion(), array('id'=>'region', 'placeholder'=>__("Województwo"), 'maxlength'=>'255', 'class'=>'form-control'))); ?>
<?php $smarty->assign('input_code', input_tag('user_data[code]', $userData->getCode(), array('id'=>'code', 'placeholder'=> '* '.__("Kod"), 'maxlength'=>'255', 'class'=>'form-control'))); ?>
<?php $smarty->assign('input_town', input_tag('user_data[town]', $userData->getTown(), array('id'=>'town', 'placeholder'=> '* '.__("Miasto"), 'maxlength'=>'255', 'class'=>'form-control'))); ?>
<?php $smarty->assign('input_phone', input_tag('user_data[phone]', $userData->getPhone(), array('id'=>'phone', 'placeholder'=> $phone_label, 'maxlength'=>'255', 'class'=>'form-control'))); ?>
<?php $smarty->assign('input_pesel', input_tag('user_data[pesel]', $userData->getPesel(), array('id'=>'billing-pesel', 'placeholder'=>__('PESEL'), 'maxlength'=>'255', 'class'=>'form-control'))); ?>

<?php $smarty->assign('show_add', $userData->getAddress()); ?>


<?php if ($userData->getIsBilling()!=1): ?>

    <?php if ($userData->getAddress()==""): ?>

        <?php $smarty->assign('select_country',  st_get_component('stUserData', 'deliveryCountriesSelect', array('id'=>'user_data_country','force_default_country_id' => $userData->getCountriesId()))) ?>                

    <?php else: ?>
    
        <?php $smarty->assign('select_country', object_select_tag($userData->getCountriesId(), 'getId', array('id'=>'user_data_country', 'class' => 'form-control', 'related_class' => 'Countries', 'peer_method'=>"doSelectActive", 'control_name' => 'user_data[country]'))) ?>                
    
    <?php endif; ?>
    
<?php else: ?>
    
    <?php $smarty->assign('select_country', object_select_tag($userData->getCountriesId(), 'getId', array('id'=>'user_data_country', 'class' => 'form-control', 'related_class' => 'Countries', 'peer_method'=>"doSelectActive", 'control_name' => 'user_data[country]'))) ?>                
    
<?php endif; ?>

<?php endif; ?>




    <?php $smarty->assign('is_default', $userData->getIsDefault()) ?>  
    <?php $smarty->assign('checkbox_set_as_default', checkbox_tag('user_data[isDefault]', 1, $userData->getIsDefault(), array('id'=>'st_form-user-default'))) ?>
    
<?php $smarty->assign('delete_url', 'stUserData/deleteProfile?userDataType='.$userDataType.'&userDataId='.$userData->getId()) ?>

<?php $smarty->assign('save_submit', submit_tag(__('Zapisz'),array('name'=>'submit_save'))) ?>                        
<?php $smarty->assign('hidden_show_edit_profile_form', input_hidden_tag('showEditProfileForm', $showEditProfileForm)) ?>
<?php $smarty->assign('hidden_uderdata_type', input_hidden_tag('userDataType', $userDataType)) ?>
<?php $smarty->assign('hidden_user_data_id', input_hidden_tag('user_data[id]', $userData->getId())) ?>
<?php $smarty->assign('hidden_user_data_is_billing', input_hidden_tag('user_data[isBilling]', $userData->getIsBilling())) ?>
<?php $smarty->assign('hidden_userdata_id', input_hidden_tag('userDataId', $userData->getId())) ?>

<?php $smarty->display('userdata_edit_profile_form.html') ?>