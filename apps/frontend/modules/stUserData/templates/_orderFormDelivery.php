<?php use_helper('Validation', 'Object', 'stCaptchaGD', 'stUrl', 'stUserPassValidation', 'stDelivery') ?>
<?php st_theme_use_stylesheet('stUser.css') ?>
<?php use_javascript('stUser.js', 'last') ?>
<?php use_javascript('jquery.infieldlabel.js', 'last') ?>
<?php $user_config = stConfig::getInstance(sfContext::getInstance(), 'stUser'); ?>

<?php $smarty->assign('error_company', form_error('user_data_delivery[company]', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error error_label'))) ?>    
<?php $smarty->assign('error_full_name', form_error('user_data_delivery[full_name]', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error error_label'))) ?>
<?php $smarty->assign('error_address', form_error('user_data_delivery[address]', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error error_label'))) ?>
<?php $smarty->assign('error_region', form_error('user_data_delivery[region]', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error error_label'))) ?>
<?php $smarty->assign('error_code', form_error('user_data_delivery[code]', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error error_label'))) ?>
<?php $smarty->assign('error_town', form_error('user_data_delivery[town]', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error error_label'))) ?>        
<?php $smarty->assign('error_phone', form_error('user_data_delivery[phone]', array('suffix'=>'', 'prefix'=>'', 'class'=>'st_error error_label'))) ?>

<?php $smarty->assign('error_delivery_company', $sf_request->getError('user_data_delivery{company}')); ?>
<?php $smarty->assign('error_delivery_full_name', $sf_request->getError('user_data_delivery{full_name}')); ?>
<?php $smarty->assign('error_delivery_address', $sf_request->getError('user_data_delivery{address}')); ?>
<?php $smarty->assign('error_delivery_region', $sf_request->getError('user_data_delivery{region}')); ?>
<?php $smarty->assign('error_delivery_code_town', $sf_request->getError('user_data_delivery{code}').$sf_request->getError('user_data_delivery{town}')); ?>
<?php $smarty->assign('error_delivery_code', $sf_request->getError('user_data_delivery{code}')); ?>
<?php $smarty->assign('error_delivery_town', $sf_request->getError('user_data_delivery{town}')); ?>
<?php $smarty->assign('error_delivery_phone', $sf_request->getError('user_data_delivery{phone}')); ?>
<?php $smarty->assign('error_delivery_vat', $sf_request->getError('user_data_delivery{vat_number}')); ?>
<?php $smarty->assign('error_delivery_country', $sf_request->getError('user_data_delivery{country}')); ?>

<?php
if ($sf_request->getErrors() && $user_basket_form_error): 
$smarty->assign('errors', __('Uzupełnij zaznaczone pola.'));
endif;
?>
<?php $smarty->assign('show_region', $show_region);?>
<?php $smarty->assign('show_address_more', $show_address_more);?>

<?php $smarty->assign('label_delivery_customer_type1', __('Klient indywidualny')) ?>
<?php $smarty->assign('radio_delivery_customer_type1', radiobutton_tag('user_data_delivery[customer_type]', 1, $user_data_delivery['customer_type'] == 1)) ?>

<?php $smarty->assign('label_delivery_customer_type2', __('Firma')) ?>
<?php $smarty->assign('radio_delivery_customer_type2', radiobutton_tag('user_data_delivery[customer_type]', 2, $user_data_delivery['customer_type'] == 2)) ?>

<?php $smarty->assign('label_delivery_company', label_for('company',"* ".__('Firma'))) ?>
<?php $smarty->assign('input_delivery_company', input_tag('user_data_delivery[company]',  $user_data_delivery['company'], array('id'=>'company', 'maxlength'=>'255', 'class'=>form_has_error('user_data_delivery{company}') ? 'st_form-error' : ''))) ?> 

<?php $smarty->assign('label_delivery_full_name', label_for('full_name',"* ".__('Imię i nazwisko'), array('id'=>'full_name_delivery_label'))) ?>
<?php $smarty->assign('label_delivery_full_name_text', __('Imię i nazwisko')); ?>
<?php $smarty->assign('input_delivery_full_name', input_tag('user_data_delivery[full_name]', $user_data_delivery['full_name'], array('id'=>'full_name', 'maxlength'=>'255', 'class'=>form_has_error('user_data_delivery{full_name}') ? 'st_form-error' : ''))) ?>

<?php $smarty->assign('label_delivery_address', label_for('address',"* ".__('Ulica nr domu / nr lokalu'))) ?>
<?php $smarty->assign('input_delivery_address', input_tag('user_data_delivery[address]', $user_data_delivery['address'], array('id'=>'address', 'maxlength'=>'255', 'class'=>form_has_error('user_data_delivery{address}') ? 'st_form-error' : ''))) ?>

<?php $smarty->assign('label_delivery_address_more', label_for('address_more',__('Adres ciąg dalszy'))) ?>
<?php $smarty->assign('input_delivery_address_more', input_tag('user_data_delivery[address_more]', $user_data_delivery['address_more'], array('id'=>'address_more', 'maxlength'=>'255', 'class'=>form_has_error('user_data_delivery{address_more}') ? 'st_form-error' : ''))) ?>

<?php $smarty->assign('label_delivery_region', label_for('region',__('Województwo'))) ?>
<?php $smarty->assign('input_delivery_region', input_tag('user_data_delivery[region]', $user_data_delivery['region'], array('id'=>'region', 'maxlength'=>'255', 'class'=>form_has_error('user_data_delivery{region}') ? 'st_form-error' : ''))) ?>

<?php $smarty->assign('label_delivery_code', label_for('code',"* ".__('Kod'), array('id'=>'label_code'))) ?>
<?php $smarty->assign('input_delivery_code', input_tag('user_data_delivery[code]', $user_data_delivery['code'], array('id'=>'code', 'maxlength'=>'255', 'class'=>form_has_error('user_data_delivery{code}') ? 'st_form-error' : ''))) ?>

<?php $smarty->assign('label_delivery_town', label_for('town',"* ".__('Miasto'), array('id'=>'label_town'))) ?> 
<?php $smarty->assign('input_delivery_town', input_tag('user_data_delivery[town]', $user_data_delivery['town'], array('id'=>'town', 'maxlength'=>'255', 'class'=>form_has_error('user_data_delivery{town}') ? 'st_form-error' : ''))) ?> 

<?php $smarty->assign('label_delivery_country', label_for('country',__('Kraj'))) ?>
<?php $smarty->assign('select_delivery_country', delivery_countries_select_tag('user_data_delivery[country]',  $delivery_country_id)) ?>                


<?php
if($user_config->get('validate_phone')==1){ 
    $smarty->assign('label_delivery_phone', label_for('phone',"* ".__('Telefon')));
}else{
    $smarty->assign('label_delivery_phone', label_for('phone',__('Telefon')));
} 
?>

<?php $smarty->assign('input_delivery_phone', input_tag('user_data_delivery[phone]', $user_data_delivery['phone'], array('id'=>'phone', 'maxlength'=>'255', 'class'=>form_has_error('user_data_delivery{phone}') ? 'st_form-error' : ''))) ?>

<?php if(stTheme::is_responsive()): ?>

<?php $user_config->get('validate_phone')==1 ? $phone_label = "* ".__('Telefon') : $phone_label = __('Telefon'); ?>
    
<!-- delivery -->   
<?php $smarty->assign('input_delivery_company', input_tag('user_data_delivery[company]',  $user_data_delivery['company'], array('id'=>'company_delivery', 'placeholder'=> '* '.__("Firma"), 'maxlength'=>'255', 'class'=>'form-control'))); ?>
<?php $smarty->assign('input_delivery_full_name', input_tag('user_data_delivery[full_name]', $user_data_delivery['full_name'], array('id'=>'full_name_delivery', 'placeholder'=> "* ".__('Imię i nazwisko'), 'maxlength'=>'255', 'class'=>'form-control'))); ?>
<?php $smarty->assign('input_delivery_address', input_tag('user_data_delivery[address]', $user_data_delivery['address'], array('id'=>'address_delivery', 'placeholder'=> '* '.__("Ulica nr domu / nr lokalu"), 'maxlength'=>'255', 'class'=>'form-control'))); ?>
<?php $smarty->assign('input_delivery_address_more', input_tag('user_data_delivery[address_more]', $user_data_delivery['address_more'], array('id'=>'address_more_delivery', 'placeholder'=>__("Adres ciąg dalszy"), 'maxlength'=>'255', 'class'=>'form-control'))); ?>
<?php $smarty->assign('input_delivery_region', input_tag('user_data_delivery[region]', $user_data_delivery['region'], array('id'=>'region_delivery', 'placeholder'=>__("Województwo"), 'maxlength'=>'255', 'class'=>'form-control'))); ?>
<?php $smarty->assign('input_delivery_code', input_tag('user_data_delivery[code]', $user_data_delivery['code'], array('id'=>'code_delivery', 'placeholder'=> '* '.__("Kod"), 'maxlength'=>'255', 'class'=>'form-control'))); ?>
<?php $smarty->assign('input_delivery_town', input_tag('user_data_delivery[town]', $user_data_delivery['town'], array('id'=>'town_delivery', 'placeholder'=> '* '.__("Miasto"), 'maxlength'=>'255', 'class'=>'form-control'))); ?>
<?php $smarty->assign('input_delivery_phone', input_tag('user_data_delivery[phone]', $user_data_delivery['phone'], array('id'=>'phone_delivery', 'placeholder'=> $phone_label, 'maxlength'=>'255', 'class'=>'form-control'))); ?>

<?php endif; ?>

<?php $smarty->assign('is_authenticated', $sf_user->isAuthenticated()); ?>
<?php $smarty->assign('hidden_is_authenticated', input_hidden_tag('user_data_delivery[is_authenticated]', $sf_user->isAuthenticated())); ?>

<?php $smarty->display('userdata_order_form_delivery.html') ?>