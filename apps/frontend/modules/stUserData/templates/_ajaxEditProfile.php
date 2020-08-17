<?php use_helper('Validation', 'Object') ?>
<?php $user_config = stConfig::getInstance(sfContext::getInstance(), 'stUser'); ?>

<?php $smarty->assign('show_region', $show_region);?>
<?php $smarty->assign('show_pesel', $show_pesel);?>
<?php $smarty->assign('show_address_more', $show_address_more);?>


<?php if ($userData->getIsBilling()==1): ?>
    <?php $smarty->assign('billing_data', $userData->getIsBilling()==1) ?>
<?php endif; ?>

<?php $smarty->assign('label_customer_type1', __('Klient indywidualny')) ?>
<?php $smarty->assign('radio_customer_type1', radiobutton_tag('user_data[customer_type]', 1, $type1_checker)) ?>

<?php $smarty->assign('label_customer_type2', __('Firma')) ?>
<?php $smarty->assign('radio_customer_type2', radiobutton_tag('user_data[customer_type]', 2, $type2_checker)) ?>


<?php
if($user_config->get('validate_phone')==1){ 
    $smarty->assign('label_phone', label_for('phone',"* ".__('Telefon')));
}else{
    $smarty->assign('label_phone', label_for('phone',__('Telefon')));
} 
?>

<?php if($showMessage == true): ?>
    <?php $smarty->assign('show_message', $showMessage) ?>
<?php endif; ?>

<?php $user_config->get('validate_phone')==1 ? $phone_label = "* ".__('Telefon') : $phone_label = __('Telefon'); ?>
    
<!-- billing -->    
<?php $smarty->assign('input_company', input_tag('user_data[company]',  $userData->getCompany(), array('id'=>'company', 'placeholder'=> '* '.__("Firma"), 'maxlength'=>'255', 'class'=>'form-control'))); ?>
<?php $smarty->assign('input_nip', input_tag('user_data[vat_number]', $userData->getVatNumber(), array('id'=>'nip','placeholder'=> "* ".__($sf_user->hasVatEu() ? "Numer VAT UE" : "NIP"), 'maxlength'=>'255', 'class'=>'form-control'))) ?>
<?php $smarty->assign('input_full_name', input_tag('user_data[full_name]', $userData->getFullName(), array('id'=>'full_name', 'placeholder'=> "* ".__('Imię i nazwisko'), 'maxlength'=>'255', 'class'=>'form-control'))); ?>
<?php $smarty->assign('input_address', input_tag('user_data[address]', $userData->getAddress(), array('id'=>'address', 'placeholder'=> '* '.__("Adres"), 'maxlength'=>'255', 'class'=>'form-control'))); ?>
<?php $smarty->assign('input_address_more', input_tag('user_data[address_more]', $userData->getAddressMore(), array('id'=>'address_more', 'placeholder'=>__("Adres ciąg dalszy"), 'maxlength'=>'255', 'class'=>'form-control'))); ?>
<?php $smarty->assign('input_region', input_tag('user_data[region]', $userData->getRegion(), array('id'=>'region', 'placeholder'=>__("Województwo"), 'maxlength'=>'255', 'class'=>'form-control'))); ?>
<?php $smarty->assign('input_code', input_tag('user_data[code]', $userData->getCode(), array('id'=>'code', 'placeholder'=> '* '.__("Kod"), 'maxlength'=>'255', 'class'=>'form-control'))); ?>
<?php $smarty->assign('input_town', input_tag('user_data[town]', $userData->getTown(), array('id'=>'town', 'placeholder'=> '* '.__("Miasto"), 'maxlength'=>'255', 'class'=>'form-control'))); ?>
<?php $smarty->assign('input_phone', input_tag('user_data[phone]', $userData->getPhone(), array('id'=>'phone', 'placeholder'=> $phone_label, 'maxlength'=>'255', 'class'=>'form-control'))); ?>
<?php $smarty->assign('input_pesel', input_tag('user_data[pesel]', $userData->getPesel(), array('id'=>'billing-pesel', 'placeholder'=>__('PESEL'), 'maxlength'=>'255', 'class'=>'form-control'))); ?>


<?php $smarty->assign('is_default', $userData->getIsDefault()) ?>  
<?php $smarty->assign('checkbox_set_as_default', checkbox_tag('user_data[isDefault]', 1, $userData->getIsDefault(), array('id'=>'st_form-user-default'))) ?>
    

<?php $smarty->assign('save_submit', submit_tag(__('Zapisz'),array('name'=>'submit_save'))) ?>                        
<?php $smarty->assign('hidden_show_edit_profile_form', input_hidden_tag('showEditProfileForm', $showEditProfileForm)) ?>

<?php if ($userData->getIsBilling()==1): ?>
    <?php $smarty->assign('hidden_uderdata_type', input_hidden_tag('userDataType', "billing")) ?>
    <?php $smarty->assign('delete_url', '/stUserData/deleteProfile?userDataType=billing&userDataId='.$userData->getId()) ?>
<?php else: ?>    
    <?php $smarty->assign('hidden_uderdata_type', input_hidden_tag('userDataType', "delivery")) ?>
    <?php $smarty->assign('delete_url', '/stUserData/deleteProfile?userDataType=delivery&userDataId='.$userData->getId()) ?>
<?php endif; ?>



<?php if ($userData->getIsBilling()!=1): ?>

    <?php if ($userData->getAddress()==""): ?>

        <?php $smarty->assign('select_country',  st_get_component('stUserData', 'deliveryCountriesSelect', array('id'=>'user_data_country', 'class'=>'form-control', 'force_default_country_id' => $userData->getCountriesId()))) ?>                

    <?php else: ?>
    
        <?php $smarty->assign('select_country', object_select_tag($userData->getCountriesId(), 'getId', array('id'=>'user_data_country', 'class'=>'form-control', 'related_class' => 'Countries', 'peer_method'=>"doSelectActive", 'control_name' => 'user_data[country]'))) ?>                
    
    <?php endif; ?>
    
<?php else: ?>
    
    <?php $smarty->assign('select_country', object_select_tag($userData->getCountriesId(), 'getId', array('id'=>'user_data_country', 'class'=>'form-control', 'related_class' => 'Countries', 'peer_method'=>"doSelectActive", 'control_name' => 'user_data[country]'))) ?>                
    
<?php endif; ?>


<?php $smarty->assign('hidden_user_data_id', input_hidden_tag('user_data[id]', $userData->getId())) ?>
<?php $smarty->assign('hidden_user_data_is_billing', input_hidden_tag('user_data[isBilling]', $userData->getIsBilling())) ?>
<?php $smarty->assign('hidden_userdata_id', input_hidden_tag('userDataId', $userData->getId())) ?>

<?php $smarty->display('userdata_ajax_edit_profile.html') ?>