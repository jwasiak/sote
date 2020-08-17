<?php use_helper('Validation', 'Object') ?>
<?php st_theme_use_stylesheet('stUser.css') ?>
<?php use_javascript('jquery.infieldlabel.js', 'last') ?>


<?php $smarty->assign('show_region', $show_region);?>
<?php $smarty->assign('show_pesel', $show_pesel);?>
<?php $smarty->assign('show_address_more', $show_address_more);?>

<?php $user_config = stConfig::getInstance(sfContext::getInstance(), 'stUser'); ?>

<?php 
if ($sf_request->getErrors()): 
$smarty->assign('errors', __('Uzupełnij zaznaczone pola.'));
endif;
?>

<?php $smarty->assign('form_start', form_tag('stUserData/createFirstUserData', array('class' => 'st_form_ver6', 'name'=>'register'))) ?>

<?php $smarty->assign('error_billing_message', form_error('user_data_billing[message]', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error'))) ?>      
<?php $smarty->assign('error_billing_full_name', form_error('user_data_billing[full_name]', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error'))) ?>
<?php $smarty->assign('error_billing_address', form_error('user_data_billing[address]', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error'))) ?>
<?php $smarty->assign('error_billing_address_more', form_error('user_data_billing[address_more]', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error'))) ?><?php $smarty->assign('error_billing_code', form_error('user_data_billing[code]', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error'))) ?>
<?php $smarty->assign('error_billing_region', form_error('user_data_billing[region]', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error'))) ?>
<?php $smarty->assign('error_billing_town', form_error('user_data_billing[town]', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error'))) ?>        
<?php $smarty->assign('error_billing_phone', form_error('user_data_billing[phone]', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error'))) ?>        
<?php $smarty->assign('error_billing_vat', form_error('user_data_billing[vatNumber]', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error'))) ?>  

<?php $smarty->assign('error_company', $sf_request->getError('user_data_billing{company}')); ?>
<?php $smarty->assign('error_nip', $sf_request->getError('user_data_billing{vat_number}')); ?>
<?php $smarty->assign('error_full_name', $sf_request->getError('user_data_billing{full_name}')); ?>
<?php $smarty->assign('error_address', $sf_request->getError('user_data_billing{address}')); ?>
<?php $smarty->assign('error_code_town', $sf_request->getError('user_data_billing{code}').$sf_request->getError('user_data_billing{town}')); ?>
<?php $smarty->assign('error_code', $sf_request->getError('user_data_billing{code}')); ?>
<?php $smarty->assign('error_town', $sf_request->getError('user_data_billing{town}')); ?>
<?php $smarty->assign('error_phone', $sf_request->getError('user_data_billing{phone}')); ?>
      

<?php $smarty->assign('label_billing_customer_type1', __('Klient indywidualny')) ?>
<?php $smarty->assign('radio_billing_customer_type1', radiobutton_tag('user_data_billing[customer_type]', 1, $type1_billing_checker)) ?>

<?php $smarty->assign('label_billing_customer_type2', __('Firma')) ?>
<?php $smarty->assign('radio_billing_customer_type2', radiobutton_tag('user_data_billing[customer_type]', 2, $type2_billing_checker)) ?>

<?php $smarty->assign('label_company', label_for('billing_company',"* ".__('Firma'))) ?>
<?php $smarty->assign('input_company', input_tag('user_data_billing[company]', $userDataBilling->getCompany(), array('id'=>'billing_company', 'maxlength'=>'255', 'class'=>form_has_error('user_data_billing{company}') ? 'st_form-error' : ''))) ?>

<?php $smarty->assign('label_full_name', label_for('billing_full_name',"* ".__('Imię i nazwisko'), array('id'=>'full_name_label'))) ?>
<?php $smarty->assign('label_full_name_text', __('Imię i nazwisko')); ?>
<?php $smarty->assign('input_full_name', input_tag('user_data_billing[full_name]', $userDataBilling->getFullName(), array('id'=>'billing_full_name', 'maxlength'=>'255', 'class'=>form_has_error('user_data_billing{full_name}') ? 'st_form-error' : ''))) ?>

<?php $smarty->assign('label_address', label_for('billing_address',"* ".__('Ulica nr domu / nr lokalu'))) ?>
<?php $smarty->assign('input_address', input_tag('user_data_billing[address]', $userDataBilling->getAddress(), array('id'=>'billing_address', 'maxlength'=>'255', 'class'=>form_has_error('user_data_billing{address}') ? 'st_form-error' : ''))) ?>

<?php $smarty->assign('label_address_more', label_for('billing_address_more',__('Adres ciąg dalszy'))) ?>
<?php $smarty->assign('input_address_more', input_tag('user_data_billing[address_more]', $userDataBilling->getAddressMore(), array('id'=>'billing_address_more', 'maxlength'=>'255', 'class'=>form_has_error('user_data_billing{address_more}') ? 'st_form-error' : ''))) ?>

<?php $smarty->assign('label_region', label_for('billing_region',__('Województwo'))) ?>
<?php $smarty->assign('input_region', input_tag('user_data_billing[region]', $userDataBilling->getRegion(), array('id'=>'billing_region', 'maxlength'=>'255', 'class'=>form_has_error('user_data_billing{region}') ? 'st_form-error' : ''))) ?>

<?php $smarty->assign('label_code', label_for('billing_code',"* ".__('Kod'))) ?>
<?php $smarty->assign('input_code', input_tag('user_data_billing[code]', $userDataBilling->getCode(), array('id'=>'billing_code', 'maxlength'=>'255', 'class'=>form_has_error('user_data_billing{code}') ? 'st_form-error' : ''))) ?>

<?php $smarty->assign('label_town', label_for('billing_town',"* ".__('Miasto'))) ?>
<?php $smarty->assign('input_town', input_tag('user_data_billing[town]', $userDataBilling->getTown(), array('id'=>'billing_town', 'maxlength'=>'255', 'class'=>form_has_error('user_data_billing{town}') ? 'st_form-error' : ''))) ?>

<?php $smarty->assign('select_country', object_select_tag($userDataBilling->getCountriesId(), 'getId', array('id'=>'billing_country', 'related_class' => 'Countries', 'peer_method'=>"doSelectActive", 'control_name' => 'user_data_billing[country]'))) ?>

<?php
if($user_config->get('validate_phone')==1){ 
    $smarty->assign('label_phone', label_for('billing_phone',"* ".__('Telefon')));
}else{
    $smarty->assign('label_phone', label_for('billing_phone',__('Telefon')));
} 
?>

<?php $smarty->assign('input_phone', input_tag('user_data_billing[phone]', $userDataBilling->getPhone(), array('id'=>'billing_phone', 'maxlength'=>'255', 'class'=>form_has_error('user_data_billing{phone}') ? 'st_form-error' : ''))) ?>

<?php $smarty->assign('label_nip', label_for('billing_nip',"* ".__('NIP'))) ?>
<?php $smarty->assign('input_nip', input_tag('user_data_billing[vat_number]', $userDataBilling->getVatNumber(), array('id'=>'billing_nip', 'maxlength'=>'255', 'class'=>form_has_error('user_data_billing{vat_number}') ? 'st_form-error' : ''))) ?>

<?php $smarty->assign('label_pesel', label_for('billing_pesel',__('PESEL'))) ?>
<?php $smarty->assign('input_pesel', input_tag('user_data_billing[pesel]', $userDataBilling->getPesel(), array('id'=>'billing_pesel', 'maxlength'=>'255', 'class'=>form_has_error('user_data_billing{pesel}') ? 'st_form-error' : ''))) ?>
   
<?php $smarty->assign('checkbox_delivery', checkbox_tag('different_delivery', 1, $different_delivery, array('id'=>'different_delivery', 'class'=>'checkobox'))) ?>

<?php $smarty->assign('error_delivery_message', form_error('user_data_delivery[message]', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error'))) ?>
<?php $smarty->assign('error_delivery_full_name',form_error('user_data_delivery[full_name]', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error'))) ?>
<?php $smarty->assign('error_delivery_address', form_error('user_data_delivery[address]', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error'))) ?>
<?php $smarty->assign('error_delivery_address_more', form_error('user_data_delivery[address_more]', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error'))) ?>
<?php $smarty->assign('error_delivery_region', form_error('user_data_delivery[region]', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error'))) ?>
<?php $smarty->assign('error_delivery_code', form_error('user_data_delivery[code]', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error'))) ?>        
<?php $smarty->assign('error_delivery_town', form_error('user_data_delivery[town]', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error'))) ?>        
<?php $smarty->assign('error_delivery_phone', form_error('user_data_delivery[phone]', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error'))) ?>        
<?php $smarty->assign('error_delivery_vat', form_error('user_data_delivery[vatNumber]', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error'))) ?>   

<?php $smarty->assign('error_delivery_company', $sf_request->getError('user_data_delivery{company}')); ?>    
<?php $smarty->assign('error_delivery_full_name', $sf_request->getError('user_data_delivery{full_name}')) ?>
<?php $smarty->assign('error_delivery_address', $sf_request->getError('user_data_delivery{address}')) ?>
<?php $smarty->assign('error_delivery_region', $sf_request->getError('user_data_delivery{region}')) ?>
<?php $smarty->assign('error_delivery_code_town', $sf_request->getError('user_data_delivery{code}').$sf_request->getError('user_data_delivery{town}')); ?>
<?php $smarty->assign('error_delivery_code', $sf_request->getError('user_data_delivery{code}')); ?>
<?php $smarty->assign('error_delivery_town', $sf_request->getError('user_data_delivery{town}')); ?>
<?php $smarty->assign('error_delivery_phone', $sf_request->getError('user_data_delivery{phone}')) ?>
     

<?php $smarty->assign('label_delivery_customer_type1', __('Klient indywidualny')) ?>
<?php $smarty->assign('radio_delivery_customer_type1', radiobutton_tag('user_data_delivery[customer_type]', 1, $type1_delivery_checker)) ?>

<?php $smarty->assign('label_delivery_customer_type2', __('Firma')) ?>
<?php $smarty->assign('radio_delivery_customer_type2', radiobutton_tag('user_data_delivery[customer_type]', 2, $type2_delivery_checker)) ?>


<?php $smarty->assign('label_delivery_company', label_for('delivery_company',"* ".__('Firma'))) ?>
<?php $smarty->assign('input_delivery_company', input_tag('user_data_delivery[company]', $userDataDelivery->getCompany(), array('id'=>'delivery_company', 'maxlength'=>'255', 'class'=>form_has_error('user_data_delivery{company}') ? 'st_form-error' : ''))) ?>

<?php $smarty->assign('label_delivery_full_name', label_for('delivery_full_name',"* ".__('Imię i nazwisko'), array('id'=>'full_name_delivery_label'))) ?>
<?php $smarty->assign('label_delivery_full_name_text', __('Imię i nazwisko')); ?>
<?php $smarty->assign('input_delivery_full_name', input_tag('user_data_delivery[full_name]', $userDataDelivery->getFullName(), array('id'=>'delivery_full_name', 'maxlength'=>'255', 'class'=>form_has_error('user_data_delivery{full_name}') ? 'st_form-error' : ''))) ?>

<?php $smarty->assign('label_delivery_address', label_for('delivery_address',"* ".__('Ulica nr domu / nr lokalu'))) ?>
<?php $smarty->assign('input_delivery_address', input_tag('user_data_delivery[address]', $userDataDelivery->getAddress(), array('id'=>'delivery_address', 'maxlength'=>'255', 'class'=>form_has_error('user_data_delivery{address}') ? 'st_form-error' : ''))) ?>

<?php $smarty->assign('label_delivery_address_more', label_for('delivery_address_more',"* ".__('Adres ciąg dalszy'))) ?>
<?php $smarty->assign('input_delivery_address_more', input_tag('user_data_delivery[address_more]', $userDataDelivery->getAddressMore(), array('id'=>'delivery_address_more', 'maxlength'=>'255', 'class'=>form_has_error('user_data_delivery{address_more}') ? 'st_form-error' : ''))) ?>

<?php $smarty->assign('label_delivery_region', label_for('delivery_region',__('Województwo'))) ?>
<?php $smarty->assign('input_delivery_region', input_tag('user_data_delivery[region]', $userDataDelivery->getRegion(), array('id'=>'delivery_region', 'maxlength'=>'255'))) ?>

<?php $smarty->assign('label_delivery_code',  label_for('delivery_code',"* ".__('Kod'))) ?>
<?php $smarty->assign('input_delivery_code', input_tag('user_data_delivery[code]', $userDataDelivery->getCode(), array('id'=>'delivery_code', 'maxlength'=>'255', 'class'=>form_has_error('user_data_delivery{code}') ? 'st_form-error' : ''))) ?>

<?php $smarty->assign('label_delivery_town',  label_for('delivery_town',"* ".__('Miasto'))) ?> 
<?php $smarty->assign('input_delivery_town', input_tag('user_data_delivery[town]', $userDataDelivery->getTown(), array('id'=>'delivery_town', 'maxlength'=>'255', 'class'=>form_has_error('user_data_delivery{town}') ? 'st_form-error' : ''))) ?>
           

<?php $smarty->assign('select_delivery_country',  st_get_component('stUserData', 'deliveryCountriesSelect', array('force_default_country_id' => $userDataDelivery->getCountriesId()))) ?>
                
<?php
if($user_config->get('validate_phone')==1){ 
    $smarty->assign('label_delivery_phone', label_for('delivery_phone',"* ".__('Telefon')));
}else{
    $smarty->assign('label_delivery_phone', label_for('delivery_phone',__('Telefon')));
} 
?>

<?php $smarty->assign('input_delivery_phone', input_tag('user_data_delivery[phone]', $userDataDelivery->getPhone(), array('id'=>'delivery_phone', 'maxlength'=>'255', 'class'=>form_has_error('user_data_delivery{phone}') ? 'st_form-error' : ''))) ?>


<?php if(stTheme::is_responsive()): ?>
<?php $user_config->get('validate_phone')==1 ? $phone_label = "* ".__('Telefon') : $phone_label = __('Telefon'); ?>
    
<!-- billing -->    
<?php $smarty->assign('input_company', input_tag('user_data_billing[company]',  $userDataBilling->getCompany(), array('id'=>'company_billing', 'placeholder'=> '* '.__("Firma"), 'maxlength'=>'255', 'class'=>'form-control'))); ?>
<?php $smarty->assign('input_nip', input_tag('user_data_billing[vat_number]', $userDataBilling->getVatNumber(), array('id'=>'nip_billing','placeholder'=> "* ".__($sf_user->hasVatEu() ? "Numer VAT UE" : "NIP"), 'maxlength'=>'255', 'class'=>'form-control'))) ?>
<?php $smarty->assign('input_full_name', input_tag('user_data_billing[full_name]', $userDataBilling->getFullName(), array('id'=>'full_name_billing', 'placeholder'=> "* ".__('Imię i nazwisko'), 'maxlength'=>'255', 'class'=>'form-control'))); ?>
<?php $smarty->assign('input_address', input_tag('user_data_billing[address]', $userDataBilling->getAddress(), array('id'=>'address_billing', 'placeholder'=> '* '.__("Ulica nr domu / nr lokalu"), 'maxlength'=>'255', 'class'=>'form-control'))); ?>
<?php $smarty->assign('input_address_more', input_tag('user_data_billing[address_more]', $userDataBilling->getAddressMore(), array('id'=>'address_more_billing', 'placeholder'=>__("Adres ciąg dalszy"), 'maxlength'=>'255', 'class'=>'form-control'))); ?>
<?php $smarty->assign('input_region', input_tag('user_data_billing[region]', $userDataBilling->getRegion(), array('id'=>'region_billing', 'placeholder'=>__("Województwo"), 'maxlength'=>'255', 'class'=>'form-control'))); ?>
<?php $smarty->assign('input_code', input_tag('user_data_billing[code]', $userDataBilling->getCode(), array('id'=>'code_billing', 'placeholder'=> '* '.__("Kod"), 'maxlength'=>'255', 'class'=>'form-control'))); ?>
<?php $smarty->assign('input_town', input_tag('user_data_billing[town]', $userDataBilling->getTown(), array('id'=>'town_billing', 'placeholder'=> '* '.__("Miasto"), 'maxlength'=>'255', 'class'=>'form-control'))); ?>
<?php $smarty->assign('select_country', object_select_tag($userDataBilling->getCountriesId(), 'getId', array('id'=>'billing_country', 'class'=>'form-control', 'related_class' => 'Countries', 'peer_method'=>"doSelectActive", 'control_name' => 'user_data_billing[country]'))) ?>
<?php $smarty->assign('input_phone', input_tag('user_data_billing[phone]', $userDataBilling->getPhone(), array('id'=>'phone_billing', 'placeholder'=> $phone_label, 'maxlength'=>'255', 'class'=>'form-control'))); ?>
<?php $smarty->assign('input_pesel', input_tag('user_data_billing[pesel]', $userDataBilling->getPesel(), array('id'=>'billing-pesel', 'placeholder'=>__('PESEL'), 'maxlength'=>'255', 'class'=>'form-control'))); ?>

<!-- delivery -->    
<?php $smarty->assign('input_delivery_company', input_tag('user_data_delivery[company]',  $userDataDelivery->getCompany(), array('id'=>'company_delivery', 'placeholder'=> '* '.__("Firma"), 'maxlength'=>'255', 'class'=>'form-control'))); ?>
<?php $smarty->assign('input_delivery_full_name', input_tag('user_data_delivery[full_name]', $userDataDelivery->getFullName(), array('id'=>'full_name_delivery', 'placeholder'=> "* ".__('Imię i nazwisko'), 'maxlength'=>'255', 'class'=>'form-control'))); ?>
<?php $smarty->assign('input_delivery_address', input_tag('user_data_delivery[address]', $userDataDelivery->getAddress(), array('id'=>'address_delivery', 'placeholder'=> '* '.__("Ulica nr domu / nr lokalu"), 'maxlength'=>'255', 'class'=>'form-control'))); ?>
<?php $smarty->assign('input_delivery_address_more', input_tag('user_data_delivery[address_more]', $userDataDelivery->getAddressMore(), array('id'=>'address_more_delivery', 'placeholder'=>__("Adres ciąg dalszy"), 'maxlength'=>'255', 'class'=>'form-control'))); ?>
<?php $smarty->assign('input_delivery_region', input_tag('user_data_delivery[region]', $userDataDelivery->getRegion(), array('id'=>'region_delivery', 'placeholder'=>__("Województwo"), 'maxlength'=>'255', 'class'=>'form-control'))); ?>
<?php $smarty->assign('input_delivery_code', input_tag('user_data_delivery[code]', $userDataDelivery->getCode(), array('id'=>'code_delivery', 'placeholder'=> '* '.__("Kod"), 'maxlength'=>'255', 'class'=>'form-control'))); ?>
<?php $smarty->assign('input_delivery_town', input_tag('user_data_delivery[town]', $userDataDelivery->getTown(), array('id'=>'town_delivery', 'placeholder'=> '* '.__("Miasto"), 'maxlength'=>'255', 'class'=>'form-control'))); ?>
<?php $smarty->assign('input_delivery_phone', input_tag('user_data_delivery[phone]', $userDataDelivery->getPhone(), array('id'=>'phone_delivery', 'placeholder'=> $phone_label, 'maxlength'=>'255', 'class'=>'form-control'))); ?>

<?php endif; ?>

<?php $smarty->assign('save_submit',submit_tag(__('Zapisz'),array('name'=>'submit_save'))) ?> 



<?php $smarty->assign('hidden_delivery_id', input_hidden_tag('user_data_delivery[id]', $userDataDelivery->getId())) ?>
<?php $smarty->assign('hidden_billing_id', input_hidden_tag('user_data_billing[id]', $userDataBilling->getId())) ?>

<?php $smarty->display('userdata_create_first_user_data.html') ?>