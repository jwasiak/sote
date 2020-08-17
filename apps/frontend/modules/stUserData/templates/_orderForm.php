<?php
use_helper('Validation', 'Object', 'stCaptchaGD', 'stUrl', 'stUserPassValidation', 'stDelivery');
st_theme_use_stylesheet('stUser.css');
use_javascript('stUser.js', 'last');
use_javascript('jquery.infieldlabel.js', 'last');
$user_config = stConfig::getInstance(sfContext::getInstance(), 'stUser');

$smarty->assign('error_billing_company', form_error('user_data_billing[company]', array('suffix' => '', 'prefix' => '', 'class' => 'st_error error_label')));
$smarty->assign('error_billing_vat', form_error('user_data_billing[vat_number]', array('suffix' => '', 'prefix' => '', 'class' => 'st_error error_label')));
$smarty->assign('error_billing_full_name', form_error('user_data_billing[full_name]', array('suffix' => '', 'prefix' => '', 'class' => 'st_error error_label')));
$smarty->assign('error_billing_address', form_error('user_data_billing[address]', array('suffix' => '', 'prefix' => '', 'class' => 'st_error error_label')));
$smarty->assign('error_billing_region', form_error('user_data_billing[region]', array('suffix' => '', 'prefix' => '', 'class' => 'st_error error_label')));
$smarty->assign('error_billing_code', form_error('user_data_billing[code]', array('suffix' => '', 'prefix' => '', 'class' => 'st_error error_label')));
$smarty->assign('error_billing_town', form_error('user_data_billing[town]', array('suffix' => '', 'prefix' => '', 'class' => 'st_error error_label')));
$smarty->assign('error_billing_phone', form_error('user_data_billing[phone]', array('suffix' => '', 'prefix' => '', 'class' => 'st_error error_label')));
$smarty->assign('error_billing_email', form_error('user_data_billing[email]', array('suffix' => '', 'prefix' => '', 'class' => 'st_error error_label')));
$smarty->assign('error_billing_email_exist', form_error('user_data_billing[email_exist]', array('suffix' => '', 'prefix' => '', 'class' => 'st_error error_label')));
$smarty->assign('error_billing_password1', form_error('user_data_billing[password1]', array('suffix' => '', 'prefix' => '', 'class' => 'st_error error_label')));
$smarty->assign('error_billing_password2', form_error('user_data_billing[password2]', array('suffix' => '', 'prefix' => '', 'class' => 'st_error error_label')));
$smarty->assign('error_billing_password_parse', form_error('user_data_billing[password_parse]', array('suffix' => '', 'prefix' => '', 'class' => 'st_error error_label')));

$smarty->assign('error_billing_password1', $sf_request->getError('user_data_billing{password1}'));
$smarty->assign('error_billing_password2', $sf_request->getError('user_data_billing{password2}'));

$smarty->assign('error_billing_privacy', $sf_request->getError('error_privacy'));
$smarty->assign('error_billing_terms', $sf_request->getError('error_terms'));

$smarty->assign('error_billing_company', $sf_request->getError('user_data_billing{company}'));
$smarty->assign('error_billing_vat', $sf_request->getError('user_data_billing{vat_number}'));
$smarty->assign('error_billing_full_name', $sf_request->getError('user_data_billing{full_name}'));
$smarty->assign('error_billing_address', $sf_request->getError('user_data_billing{address}'));
$smarty->assign('error_billing_region', $sf_request->getError('user_data_billing{region}'));
$smarty->assign('error_billing_code_town', $sf_request->getError('user_data_billing{code}') . $sf_request->getError('user_data_billing{town}'));
$smarty->assign('error_billing_code', $sf_request->getError('user_data_billing{code}'));
$smarty->assign('error_billing_town', $sf_request->getError('user_data_billing{town}'));

$smarty->assign('error_billing_phone', $sf_request->getError('user_data_billing{phone}'));
$smarty->assign('error_billing_email', $sf_request->getError('user_data_billing{email}') . $sf_request->getError('user_data_billing{email_exist}'));
$smarty->assign('error_billing_country', $sf_request->getError('user_data_billing{country}'));

$smarty->assign('error_delivery_company', form_error('user_data_delivery[company]', array('suffix' => '', 'prefix' => '', 'class' => 'st_error error_label')));
$smarty->assign('error_delivery_vat', form_error('user_data_delivery[vat_number]', array('suffix' => '', 'prefix' => '', 'class' => 'st_error error_label')));
$smarty->assign('error_delivery_full_name', form_error('user_data_delivery[full_name]', array('suffix' => '', 'prefix' => '', 'class' => 'st_error error_label')));
$smarty->assign('error_delivery_address', form_error('user_data_delivery[address]', array('suffix' => '', 'prefix' => '', 'class' => 'st_error error_label')));
$smarty->assign('error_delivery_region', form_error('user_data_delivery[region]', array('suffix' => '', 'prefix' => '', 'class' => 'st_error error_label')));
$smarty->assign('error_delivery_code', form_error('user_data_delivery[code]', array('suffix' => '', 'prefix' => '', 'class' => 'st_error error_label')));
$smarty->assign('error_delivery_town', form_error('user_data_delivery[town]', array('suffix' => '', 'prefix' => '', 'class' => 'st_error error_label')));
$smarty->assign('error_delivery_phone', form_error('user_data_delivery[phone]', array('suffix' => '', 'prefix' => '', 'class' => 'st_error error_label')));

$smarty->assign('error_delivery_company', $sf_request->getError('user_data_delivery{company}'));
$smarty->assign('error_delivery_full_name', $sf_request->getError('user_data_delivery{full_name}'));
$smarty->assign('error_delivery_address', $sf_request->getError('user_data_delivery{address}'));
$smarty->assign('error_delivery_region', $sf_request->getError('user_data_delivery{region}'));
$smarty->assign('error_delivery_code_town', $sf_request->getError('user_data_delivery{code}') . $sf_request->getError('user_data_delivery{town}'));
$smarty->assign('error_delivery_code', $sf_request->getError('user_data_delivery{code}'));
$smarty->assign('error_delivery_town', $sf_request->getError('user_data_delivery{town}'));
$smarty->assign('error_delivery_phone', $sf_request->getError('user_data_delivery{phone}'));
$smarty->assign('error_delivery_country', $sf_request->getError('user_data_delivery{country}'));

if ($sf_request->getErrors() && $user_basket_form_error) {
    $smarty->assign('errors', __('Uzupełnij zaznaczone pola.'));
}

$smarty->assign('show_region', $show_region);
$smarty->assign('show_address_more', $show_address_more);
$smarty->assign('show_pesel', $show_pesel);

$smarty->assign('label_billing_customer_type1', __('Klient indywidualny'));
$smarty->assign('radio_billing_customer_type1', radiobutton_tag('user_data_billing[customer_type]', 1, $user_data_billing['customer_type'] == 1, array('disabled' => $sf_user->hasVatEu())));

$smarty->assign('label_billing_customer_type2', __('Firma'));
$smarty->assign('radio_billing_customer_type2', radiobutton_tag('user_data_billing[customer_type]', 2, $user_data_billing['customer_type'] == 2));

$smarty->assign('label_billing_company', label_for('company_billing', "* " . __('Firma')));
$smarty->assign('input_billing_company', input_tag('user_data_billing[company]',  $user_data_billing['company'], array('id' => 'company_billing', 'maxlength' => '255', 'class' => form_has_error('user_data_billing{company}') ? 'st_form-error' : '')));

$smarty->assign('label_billing_nip', label_for('nip_billing', "* " . __($sf_user->hasVatEu() ? 'Numer VAT UE' : 'NIP')));
$smarty->assign('input_billing_nip', input_tag('user_data_billing[vat_number]', $user_data_billing['vat_number'], array('id' => 'nip_billing', 'maxlength' => '255', 'class' => form_has_error('user_data_billing{vat_number}') ? 'st_form-error' : '')));

$smarty->assign('label_billing_email', label_for('email_billing', "* " . __('E-mail')));
$smarty->assign('input_billing_email', input_tag('user_data_billing[email]', $user_data_billing['email'], array('id' => 'email_billing', 'maxlength' => '255', 'class' => form_has_error('user_data_billing{email}') ? 'st_form-error' : '')));

$smarty->assign('checkbox_create_account', checkbox_tag('user_data_billing[create_account]', 1, $user_data_billing['create_account'], array('id' => 'create_account', 'class' => 'checkobox')));

$smarty->assign('label_billing_password1', label_for('password1_billing', "* " . __('Hasło'), array('id' => 'label-password1')));
$smarty->assign('input_billing_password1', input_password_tag('user_data_billing[password1]', $user_data_billing['password1'], array('id' => 'password1_billing', 'maxlength' => '255', 'autocomplete' => 'off', 'class' => form_has_error('user_data_billing{password1}') ? 'st_form-error' : '')));

$smarty->assign('label_billing_password2', label_for('password2_billing', "* " . __('Powtórz hasło'), array('id' => 'label-password2')));
$smarty->assign('input_billing_password2', input_password_tag('user_data_billing[password2]', $user_data_billing['password2'], array('id' => 'password2_billing', 'maxlength' => '255', 'autocomplete' => 'off', 'class' => form_has_error('user_data_billing{password2}') ? 'st_form-error' : '')));

$smarty->assign('label_billing_full_name', label_for('full_name_billing', "* " . __('Imię i nazwisko'), array('id' => 'full_name_billing_label')));
$smarty->assign('label_billing_full_name_text', __('Imię i nazwisko'));
$smarty->assign('input_billing_full_name', input_tag('user_data_billing[full_name]', $user_data_billing['full_name'], array('id' => 'full_name_billing', 'maxlength' => '255', 'class' => form_has_error('user_data_billing{full_name}') ? 'st_form-error' : '')));

$smarty->assign('label_billing_address', label_for('address_billing', "* " . __('Ulica nr domu / nr lokalu')));
$smarty->assign('input_billing_address', input_tag('user_data_billing[address]', $user_data_billing['address'], array('id' => 'address_billing', 'maxlength' => '255', 'class' => form_has_error('user_data_billing{address}') ? 'st_form-error' : '')));

$smarty->assign('label_billing_address_more', label_for('address_more_billing', __('Adres ciąg dalszy')));
$smarty->assign('input_billing_address_more', input_tag('user_data_billing[address_more]', $user_data_billing['address_more'], array('id' => 'address_more_billing', 'maxlength' => '255', 'class' => form_has_error('user_data_billing{address_more}') ? 'st_form-error' : '')));

$smarty->assign('label_billing_region', label_for('region_billing', __('Województwo')));
$smarty->assign('input_billing_region', input_tag('user_data_billing[region]', $user_data_billing['region'], array('id' => 'region_billing', 'maxlength' => '255', 'class' => form_has_error('user_data_billing{region}') ? 'st_form-error' : '')));

$smarty->assign('label_billing_code', label_for('code_billing', "* " . __('Kod')));
$smarty->assign('input_billing_code', input_tag('user_data_billing[code]', $user_data_billing['code'], array('id' => 'code_billing', 'maxlength' => '255', 'class' => form_has_error('user_data_billing{code}') ? 'st_form-error' : '')));

$smarty->assign('label_billing_town', label_for('town_billing', "* " . __('Miasto')));
$smarty->assign('input_billing_town', input_tag('user_data_billing[town]', $user_data_billing['town'], array('id' => 'town_billing', 'maxlength' => '255', 'class' => form_has_error('user_data_billing{town}') ? 'st_form-error' : '')));

$smarty->assign('label_billing_country', label_for('country_billing', __('Kraj')));
$smarty->assign('select_billing_country', countries_select_tag('user_data_billing[country]', isset($user_data_billing['country']) ? $user_data_billing['country'] : $delivery_country_id));


if ($user_config->get('validate_phone') == 1) {
    $smarty->assign('label_billing_phone', label_for('phone_billing', "* " . __('Telefon')));
} else {
    $smarty->assign('label_billing_phone', label_for('phone_billing', __('Telefon')));
}

$smarty->assign('input_billing_phone', input_tag('user_data_billing[phone]', $user_data_billing['phone'], array('id' => 'phone_billing', 'maxlength' => '255', 'class' => form_has_error('user_data_billing{phone}') ? 'st_form-error' : '')));

$smarty->assign('label_billing_pesel', label_for('billing-pesel', __('PESEL')));
$smarty->assign('input_billing_pesel', input_tag('user_data_billing[pesel]', $user_data_billing['pesel'], array('id' => 'billing-pesel', 'maxlength' => '255', 'class' => form_has_error('user_data_billing{pesel}') ? 'st_form-error' : '')));

$smarty->assign('checkbox_different_delivery', checkbox_tag('user_data_billing[different_delivery]', 1, $user_data_billing['different_delivery'], array('id' => 'different_delivery', 'class' => 'checkobox')));


$smarty->assign('label_delivery_customer_type1', __('Klient indywidualny'));
$smarty->assign('label_delivery_customer_type1', __('Klient indywidualny'));
$smarty->assign('radio_delivery_customer_type1', radiobutton_tag('user_data_delivery[customer_type]', 1, $user_data_delivery['customer_type'] == 1));

$smarty->assign('label_delivery_customer_type2', __('Firma'));
$smarty->assign('radio_delivery_customer_type2', radiobutton_tag('user_data_delivery[customer_type]', 2, $user_data_delivery['customer_type'] == 2));

$smarty->assign('label_delivery_company', label_for('company_delivery', "* " . __('Firma')));
$smarty->assign('input_delivery_company', input_tag('user_data_delivery[company]',  $user_data_delivery['company'], array('id' => 'company_delivery', 'maxlength' => '255', 'class' => form_has_error('user_data_delivery{company}') ? 'st_form-error' : '')));

$smarty->assign('label_delivery_full_name', label_for('full_name_delivery', "* " . __('Imię i nazwisko'), array('id' => 'full_name_delivery_label')));
$smarty->assign('label_delivery_full_name_text', __('Imię i nazwisko'));
$smarty->assign('input_delivery_full_name', input_tag('user_data_delivery[full_name]', $user_data_delivery['full_name'], array('id' => 'full_name_delivery', 'maxlength' => '255', 'class' => form_has_error('user_data_delivery{full_name}') ? 'st_form-error' : '')));

$smarty->assign('label_delivery_address', label_for('address_delivery', "* " . __('Ulica nr domu / nr lokalu')));
$smarty->assign('input_delivery_address', input_tag('user_data_delivery[address]', $user_data_delivery['address'], array('id' => 'address_delivery', 'maxlength' => '255', 'class' => form_has_error('user_data_delivery{address}') ? 'st_form-error' : '')));

$smarty->assign('label_delivery_address_more', label_for('address_more_delivery', __('Adres ciąg dalszy')));
$smarty->assign('input_delivery_address_more', input_tag('user_data_delivery[address_more]', $user_data_delivery['address_more'], array('id' => 'address_more_delivery', 'maxlength' => '255', 'class' => form_has_error('user_data_delivery{address_more}') ? 'st_form-error' : '')));

$smarty->assign('label_delivery_region', label_for('region_delivery', __('Województwo')));
$smarty->assign('input_delivery_region', input_tag('user_data_delivery[region]', $user_data_delivery['region'], array('id' => 'region_delivery', 'maxlength' => '255', 'class' => form_has_error('user_data_delivery{region}') ? 'st_form-error' : '')));

$smarty->assign('label_delivery_code', label_for('code_delivery', "* " . __('Kod')));
$smarty->assign('input_delivery_code', input_tag('user_data_delivery[code]', $user_data_delivery['code'], array('id' => 'code_delivery', 'maxlength' => '255', 'class' => form_has_error('user_data_delivery{code}') ? 'st_form-error' : '')));

$smarty->assign('label_delivery_town', label_for('town_delivery', "* " . __('Miasto')));
$smarty->assign('input_delivery_town', input_tag('user_data_delivery[town]', $user_data_delivery['town'], array('id' => 'town_delivery', 'maxlength' => '255', 'class' => form_has_error('user_data_delivery{town}') ? 'st_form-error' : '')));

$smarty->assign('label_delivery_country', label_for('country_delivery', __('Kraj')));
$smarty->assign('select_delivery_country', delivery_countries_select_tag('user_data_delivery[country]',  $delivery_country_id));

if ($user_config->get('validate_phone') == 1) {
    $smarty->assign('label_delivery_phone', label_for('phone_delivery', "* " . __('Telefon')));
} else {
    $smarty->assign('label_delivery_phone', label_for('phone_delivery', __('Telefon')));
}

$smarty->assign('input_delivery_phone', input_tag('user_data_delivery[phone]', $user_data_delivery['phone'], array('id' => 'phone_delivery', 'maxlength' => '255', 'class' => form_has_error('user_data_delivery{phone}') ? 'st_form-error' : '')));

$smarty->assign('checkbox_privacy', checkbox_tag('user_data_billing[privacy]', 1, $user_data_billing['privacy'], array('id' => 'user_data_billing_privacy', 'class' => 'checkobox')));

$smarty->assign('checkbox_terms', checkbox_tag('user_data_billing[terms]', 1, $user_data_billing['terms'], array('id' => 'user_data_billing_terms', 'class' => 'checkobox')));

$smarty->assignPartial('link_to_privacy', 'stUser', 'privacy');

$compatibility_config = stConfig::getInstance('stCompatibilityBackend');

$terms_shop_text = $compatibility_config->get('terms_shop_text', null, true);

$terms_text = $terms_shop_text;

$terms_text = preg_replace('/{LINK_TO_PRIVACY}/', '$', $terms_text);
$terms_text = preg_replace('/{\/LINK_TO_PRIVACY}/', '$', $terms_text);
$terms_text = preg_replace('/{LINK_TO_TERMS}/', '%', $terms_text);
$terms_text = preg_replace('/{\/LINK_TO_TERMS}/', '%', $terms_text);

$tmp_string_terms_privacy = explode("$", $terms_text);
$tmp_string_terms_shop = explode("%", $terms_text);

$terms_privacy = $tmp_string_terms_privacy[1];
$terms_shop = $tmp_string_terms_shop[1];
$terms_text = $terms_shop_text;

$terms_text = preg_replace('/{LINK_TO_PRIVACY}/', '%', $terms_text);
$terms_text = preg_replace('/{\/LINK_TO_PRIVACY}/', '%', $terms_text);
$terms_text = preg_replace('/{LINK_TO_TERMS}/', '%', $terms_text);
$terms_text = preg_replace('/{\/LINK_TO_TERMS}/', '%', $terms_text);

$tmp_string = explode("%", $terms_text);

$string = '';

foreach ($tmp_string as $value) {
    if ($value == $terms_privacy) {
        $string .= st_get_component('stWebpageFrontend', 'linkterms', array('state' => 'PRIVACY', 'label' => $terms_privacy));
    } elseif ($value == $terms_shop) {
        $string .= st_get_component('stWebpageFrontend', 'linkterms', array('state' => 'TERMS', 'label' => $terms_shop));
    } else {
        $string .= $value;
    }
}

$smarty->assign("terms_shop_text", $string);

if ($config->get('captcha_on', stConfig::INT) == 1  && sfContext::getInstance()->getUser()->getAttribute('captcha_off') != 1) {
    $smarty->assign('captcha_on', $config->get('captcha_on', stConfig::INT) == 1);

    $smarty->assign('error_captcha', form_error('captcha', array('suffix' => '', 'prefix' => '', 'class' => 'st_error red')));

    $smarty->assign('error_captcha', $sf_request->getError('captcha'));

    $smarty->assign('get_captcha', get_captcha('270'));

    $smarty->assign('label_captcha', label_for('captcha_img', "* " . __('Cyfry z obrazka')));

    $smarty->assign('input_captcha', input_tag('captcha', '', array('id' => 'captcha_img', 'class' => form_has_error('captcha') ? 'st_form-error' : '')));
}

$smarty->assign('label_description', label_for('order_description', __('Uwagi do zamówienia')));

$smarty->assign('description', input_hidden_tag('user_data_billing[description]', $user_data_billing['description'], array('id' => 'order_description')));

if (stTheme::is_responsive()) {

    $user_config->get('validate_phone') == 1 ? $phone_label = "* " . __('Telefon') : $phone_label = __('Telefon');

    $smarty->assign('input_billing_email', input_tag('user_data_billing[email]', $user_data_billing['email'], array('id' => 'email_billing', 'placeholder' => '* ' . __("E-mail"), 'maxlength' => '255', 'class' => 'form-control')));
    $smarty->assign('input_billing_password1', input_password_tag('user_data_billing[password1]', $user_data_billing['password1'], array('id' => 'password1_billing', 'maxlength' => '255', 'placeholder' => '* ' . __("Hasło"), 'autocomplete' => 'off', 'class' => 'form-control')));
    $smarty->assign('input_billing_password2', input_password_tag('user_data_billing[password2]', $user_data_billing['password2'], array('id' => 'password2_billing', 'maxlength' => '255', 'placeholder' => '* ' . __("Powtórz hasło"), 'autocomplete' => 'off', 'class' => 'form-control')));
    $smarty->assign('input_captcha', input_tag('captcha', '', array('id' => 'captcha_img', 'placeholder' => '* ' . __("Cyfry z obrazka"), 'class' => 'form-control')));

    $smarty->assign('input_billing_company', input_tag('user_data_billing[company]',  $user_data_billing['company'], array('id' => 'company_billing', 'placeholder' => '* ' . __("Firma"), 'maxlength' => '255', 'class' => 'form-control')));
    $smarty->assign('input_billing_nip', input_tag('user_data_billing[vat_number]', $user_data_billing['vat_number'], array('id' => 'nip_billing', 'placeholder' => "* " . __($sf_user->hasVatEu() ? "Numer VAT UE" : "NIP"), 'maxlength' => '255', 'class' => 'form-control')));
    $smarty->assign('input_billing_full_name', input_tag('user_data_billing[full_name]', $user_data_billing['full_name'], array('id' => 'full_name_billing', 'placeholder' => "* " . __('Imię i nazwisko'), 'maxlength' => '255', 'class' => 'form-control')));
    $smarty->assign('input_billing_address', input_tag('user_data_billing[address]', $user_data_billing['address'], array('id' => 'address_billing', 'placeholder' => '* ' . __("Ulica nr domu / nr lokalu"), 'maxlength' => '255', 'class' => 'form-control')));
    $smarty->assign('input_billing_address_more', input_tag('user_data_billing[address_more]', $user_data_billing['address_more'], array('id' => 'address_more_billing', 'placeholder' => __("Adres ciąg dalszy"), 'maxlength' => '255', 'class' => 'form-control')));
    $smarty->assign('input_billing_region', input_tag('user_data_billing[region]', $user_data_billing['region'], array('id' => 'region_billing', 'placeholder' => __("Województwo"), 'maxlength' => '255', 'class' => 'form-control')));
    $smarty->assign('input_billing_code', input_tag('user_data_billing[code]', $user_data_billing['code'], array('id' => 'code_billing', 'placeholder' => '* ' . __("Kod"), 'maxlength' => '255', 'class' => 'form-control')));
    $smarty->assign('input_billing_town', input_tag('user_data_billing[town]', $user_data_billing['town'], array('id' => 'town_billing', 'placeholder' => '* ' . __("Miasto"), 'maxlength' => '255', 'class' => 'form-control')));
    $smarty->assign('select_billing_country', countries_select_tag('user_data_billing[country]', isset($user_data_billing['country']) ? $user_data_billing['country'] : $delivery_country_id));
    $smarty->assign('input_billing_phone', input_tag('user_data_billing[phone]', $user_data_billing['phone'], array('id' => 'phone_billing', 'placeholder' => $phone_label, 'maxlength' => '255', 'class' => 'form-control')));
    $smarty->assign('input_billing_pesel', input_tag('user_data_billing[pesel]', $user_data_billing['pesel'], array('id' => 'billing-pesel', 'placeholder' => __('PESEL'), 'maxlength' => '255', 'class' => 'form-control')));

    $smarty->assign('input_delivery_company', input_tag('user_data_delivery[company]',  $user_data_delivery['company'], array('id' => 'company_delivery', 'placeholder' => '* ' . __("Firma"), 'maxlength' => '255', 'class' => 'form-control')));
    $smarty->assign('input_delivery_full_name', input_tag('user_data_delivery[full_name]', $user_data_delivery['full_name'], array('id' => 'full_name_delivery', 'placeholder' => "* " . __('Imię i nazwisko'), 'maxlength' => '255', 'class' => 'form-control')));
    $smarty->assign('input_delivery_address', input_tag('user_data_delivery[address]', $user_data_delivery['address'], array('id' => 'address_delivery', 'placeholder' => '* ' . __("Ulica nr domu / nr lokalu"), 'maxlength' => '255', 'class' => 'form-control')));
    $smarty->assign('input_delivery_address_more', input_tag('user_data_delivery[address_more]', $user_data_delivery['address_more'], array('id' => 'address_more_delivery', 'placeholder' => __("Adres ciąg dalszy"), 'maxlength' => '255', 'class' => 'form-control')));
    $smarty->assign('input_delivery_region', input_tag('user_data_delivery[region]', $user_data_delivery['region'], array('id' => 'region_delivery', 'placeholder' => __("Województwo"), 'maxlength' => '255', 'class' => 'form-control')));
    $smarty->assign('input_delivery_code', input_tag('user_data_delivery[code]', $user_data_delivery['code'], array('id' => 'code_delivery', 'placeholder' => '* ' . __("Kod"), 'maxlength' => '255', 'class' => 'form-control')));
    $smarty->assign('input_delivery_town', input_tag('user_data_delivery[town]', $user_data_delivery['town'], array('id' => 'town_delivery', 'placeholder' => '* ' . __("Miasto"), 'maxlength' => '255', 'class' => 'form-control')));
    $smarty->assign('input_delivery_phone', input_tag('user_data_delivery[phone]', $user_data_delivery['phone'], array('id' => 'phone_delivery', 'placeholder' => $phone_label, 'maxlength' => '255', 'class' => 'form-control')));
}

$smarty->assign('under_basket_socket', stSocketView::openComponents('under_basket_socket') . stSocketView::openPartials('under_basket_socket'));

$smarty->display('userdata_order_form.html');