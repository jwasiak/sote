<?php
use_helper('Validation', 'Object');
st_theme_use_stylesheet('stUser.css');
use_javascript('jquery.infieldlabel.js', 'last');
$user_config = stConfig::getInstance(sfContext::getInstance(), 'stUser');

$smarty->assign('show_region', $show_region);
$smarty->assign('show_pesel', $show_pesel);
$smarty->assign('show_address_more', $show_address_more);

$smarty->assign('error_billing_message', form_error('user_data_billing[message]', array('suffix' => '', 'prefix' => '', 'class' => 'st_error')));
$smarty->assign('error_billing_full_name', form_error('user_data_billing[full_name]', array('suffix' => '', 'prefix' => '', 'class' => 'st_error')));
$smarty->assign('error_billing_address', form_error('user_data_billing[address]', array('suffix' => '', 'prefix' => '', 'class' => 'st_error')));
$smarty->assign('error_billing_code', form_error('user_data_billing[code]', array('suffix' => '', 'prefix' => '', 'class' => 'st_error')));
$smarty->assign('error_billing_town', form_error('user_data_billing[town]', array('suffix' => '', 'prefix' => '', 'class' => 'st_error')));
$smarty->assign('error_billing_phone', form_error('user_data_billing[phone]', array('suffix' => '', 'prefix' => '', 'class' => 'st_error')));
$smarty->assign('error_billing_vat', form_error('user_data_billing[vat_number]', array('suffix' => '', 'prefix' => '', 'class' => 'st_error')));

$smarty->assign('error_billing_company', $sf_request->getError('user_data_billing{company}'));
$smarty->assign('error_billing_full_name', $sf_request->getError('user_data_billing{full_name}'));
$smarty->assign('error_billing_address', $sf_request->getError('user_data_billing{address}'));
$smarty->assign('error_billing_region', $sf_request->getError('user_data_billing{region}'));
$smarty->assign('error_billing_code_town', $sf_request->getError('user_data_billing{code}') . $sf_request->getError('user_data_billing{town}'));
$smarty->assign('error_billing_code', $sf_request->getError('user_data_billing{code}'));
$smarty->assign('error_billing_town', $sf_request->getError('user_data_billing{town}'));
$smarty->assign('error_billing_phone', $sf_request->getError('user_data_billing{phone}'));
$smarty->assign('error_billing_vat', $sf_request->getError('user_data_billing{vat_number}'));
$smarty->assign('error_billing_country', $sf_request->getError('user_data_billing{country}'));

$smarty->assign('label_billing_customer_type1', __('Klient indywidualny'));
$smarty->assign('radio_billing_customer_type1', radiobutton_tag('user_data_billing[customer_type]', 1, $user_data_billing['customer_type'] == 1, array('disabled' => $sf_user->hasVatEu())));

$smarty->assign('label_billing_customer_type2', __('Firma'));
$smarty->assign('radio_billing_customer_type2', radiobutton_tag('user_data_billing[customer_type]', 2, $user_data_billing['customer_type'] == 2));

$smarty->assign('label_billing_company', label_for('billing-company', "* " . __('Firma')));
$smarty->assign('input_billing_company', input_tag('user_data_billing[company]',  $user_data_billing['company'], array('id' => 'billing-company', 'maxlength' => '255', 'class' => form_has_error('user_data_billing{company}') ? 'st_form-error billing-company' : 'billing-company')));

$smarty->assign('label_billing_full_name', label_for('billing-full_name', "* " . __('Imię i nazwisko'), array('id' => 'full_name_billing_label')));
$smarty->assign('label_billing_full_name_text', __('Imię i nazwisko'));
$smarty->assign('input_billing_full_name', input_tag('user_data_billing[full_name]', $user_data_billing['full_name'], array('id' => 'billing-full_name', 'maxlength' => '255', 'class' => form_has_error('user_data_billing{full_name}') ? 'st_form-error billing-full-name' : 'billing-full-name')));

$smarty->assign('label_billing_address', label_for('billing-address', "* " . __('Ulica nr domu / nr lokalu')));
$smarty->assign('input_billing_address', input_tag('user_data_billing[address]', $user_data_billing['address'], array('id' => 'billing-address', 'maxlength' => '255', 'class' => form_has_error('user_data_billing{address}') ? 'st_form-error billing-address' : 'billing-address')));

$smarty->assign('label_billing_address_more', label_for('billing-address_more', __('Adres ciąg dalszy')));
$smarty->assign('input_billing_address_more', input_tag('user_data_billing[address_more]', $user_data_billing['address_more'], array('id' => 'billing-address_more', 'maxlength' => '255', 'class' => form_has_error('user_data_billing{address_more}') ? 'st_form-error billing-address-more' : 'billing-address-more')));

$smarty->assign('label_billing_region', label_for('billing-region', __('Województwo')));
$smarty->assign('input_billing_region', input_tag('user_data_billing[region]', $user_data_billing['region'], array('id' => 'billing-region', 'maxlength' => '255', 'class' => form_has_error('user_data_billing{region}') ? 'st_form-error billing-region' : 'billing-region')));

$smarty->assign('label_billing_code', label_for('billing-code', "* " . __('Kod')));
$smarty->assign('input_billing_code', input_tag('user_data_billing[code]', $user_data_billing['code'], array('id' => 'billing-code', 'maxlength' => '255', 'class' => form_has_error('user_data_billing{code}') ? 'st_form-error billing-code' : 'billing-code')));

$smarty->assign('label_billing_town', label_for('billing-town', "* " . __('Miasto')));
$smarty->assign('input_billing_town', input_tag('user_data_billing[town]', $user_data_billing['town'], array('id' => 'billing-town', 'maxlength' => '255', 'class' => form_has_error('user_data_billing{town}') ? 'st_form-error billing-town' : 'billing-town')));

$smarty->assign('label_billing_country', label_for('billing-country', __('Kraj')));
$smarty->assign('select_billing_country', object_select_tag($userDataBilling->getCountriesId(), 'getId', array('id' => 'billing-country', 'related_class' => 'Countries', 'control_name' => 'user_data_billing[country]')));


if ($user_config->get('validate_phone') == 1) {
    $smarty->assign('label_billing_phone', label_for('billing-phone', "* " . __('Telefon')));
} else {
    $smarty->assign('label_billing_phone', label_for('billing-phone', __('Telefon')));
}


$smarty->assign('input_billing_phone', input_tag('user_data_billing[phone]', $user_data_billing['phone'], array('id' => 'billing-phone', 'maxlength' => '255', 'class' => form_has_error('user_data_billing{phone}') ? 'st_form-error billing-phone' : 'billing-phone')));

$smarty->assign('label_billing_nip', label_for('billing-vat_number', "* " . __($sf_user->hasVatEu() ? 'Numer VAT UE' : 'NIP')));
$smarty->assign('input_billing_nip', input_tag('user_data_billing[vat_number]', $user_data_billing['vat_number'], array('id' => 'billing-vat_number', 'maxlength' => '255', 'class' => form_has_error('user_data_billing{vat_number}') ? 'st_form-error' : '')));

$smarty->assign('label_billing_pesel', label_for('billing-pesel', __('PESEL')));
$smarty->assign('input_billing_pesel', input_tag('user_data_billing[pesel]', $user_data_billing['pesel'], array('id' => 'billing-pesel', 'maxlength' => '255', 'class' => form_has_error('user_data_billing{pesel}') ? 'st_form-error' : '')));

$smarty->assign('description', input_hidden_tag('user_data_billing[description]', $user_data_billing['description'], array('id' => 'order_description')));

$smarty->assign('under_basket_socket', stSocketView::openComponents('under_basket_socket').stSocketView::openPartials('under_basket_socket'));

if (stTheme::is_responsive()) {
    $user_config->get('validate_phone') == 1 ? $phone_label = "* " . __('Telefon') : $phone_label = __('Telefon');

    $smarty->assign('input_billing_company', input_tag('user_data_billing[company]',  $user_data_billing['company'], array('id' => 'company_billing', 'placeholder' => '* ' . __("Firma"), 'maxlength' => '255', 'class' => 'form-control')));
    $smarty->assign('input_billing_nip', input_tag('user_data_billing[vat_number]', $user_data_billing['vat_number'], array('id' => 'nip_billing', 'placeholder' => "* " . __($sf_user->hasVatEu() ? "Numer VAT UE" : "NIP"), 'maxlength' => '255', 'class' => 'form-control')));
    $smarty->assign('input_billing_full_name', input_tag('user_data_billing[full_name]', $user_data_billing['full_name'], array('id' => 'full_name_billing', 'placeholder' => "* " . __('Imię i nazwisko'), 'maxlength' => '255', 'class' => 'form-control')));
    $smarty->assign('input_billing_address', input_tag('user_data_billing[address]', $user_data_billing['address'], array('id' => 'address_billing', 'placeholder' => '* ' . __("Ulica nr domu / nr lokalu"), 'maxlength' => '255', 'class' => 'form-control')));
    $smarty->assign('input_billing_address_more', input_tag('user_data_billing[address_more]', $user_data_billing['address_more'], array('id' => 'address_more_billing', 'placeholder' => __("Adres ciąg dalszy"), 'maxlength' => '255', 'class' => 'form-control')));
    $smarty->assign('input_billing_region', input_tag('user_data_billing[region]', $user_data_billing['region'], array('id' => 'region_billing', 'placeholder' => __("Województwo"), 'maxlength' => '255', 'class' => 'form-control')));
    $smarty->assign('input_billing_code', input_tag('user_data_billing[code]', $user_data_billing['code'], array('id' => 'code_billing', 'placeholder' => '* ' . __("Kod"), 'maxlength' => '255', 'class' => 'form-control')));
    $smarty->assign('input_billing_town', input_tag('user_data_billing[town]', $user_data_billing['town'], array('id' => 'town_billing', 'placeholder' => '* ' . __("Miasto"), 'maxlength' => '255', 'class' => 'form-control')));
    $smarty->assign('select_billing_country', object_select_tag($userDataBilling->getCountriesId(), 'getId', array('id' => 'billing-country', 'class' => 'form-control', 'related_class' => 'Countries', 'control_name' => 'user_data_billing[country]')));
    $smarty->assign('input_billing_phone', input_tag('user_data_billing[phone]', $user_data_billing['phone'], array('id' => 'phone_billing', 'placeholder' => $phone_label, 'maxlength' => '255', 'class' => 'form-control')));
    $smarty->assign('input_billing_pesel', input_tag('user_data_billing[pesel]', $user_data_billing['pesel'], array('id' => 'billing-pesel', 'placeholder' => __('PESEL'), 'maxlength' => '255', 'class' => 'form-control')));

    $smarty->assign('is_authenticated', $sf_user->isAuthenticated());
    $smarty->assign('username', $sf_user->isAuthenticated() ? $sf_user->getGuardUser()->getUsername() : "");
    $smarty->assign('external_account', $sf_user->isAuthenticated() ? $sf_user->getGuardUser()->getExternalAccount() : "");
}

$smarty->assign('is_authenticated', $sf_user->isAuthenticated());

$smarty->assign('username', $sf_user->isAuthenticated() ? $sf_user->getGuardUser()->getUsername() : "");

$smarty->assign('external_account', $sf_user->isAuthenticated() ? $sf_user->getGuardUser()->getExternalAccount() : "");

$smarty->display('userdata_order_form_billing.html');