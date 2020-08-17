<?php if(!$sf_user->getAttribute('edit_mode', false, 'soteshop/stOrder')): ?>
<?php $culture = sfContext::getInstance()->getUser()->getCulture();?>
<address>
    <?php if($user_data->getCompany()): ?>
    <p>
        <?php echo $user_data->getCompany(); ?>
    </p>
    <?php endif;?>
    <p>
        <span class="st_order-address-name"><?php echo $user_data->getFullName(); ?></span>
    </p>
    <p>
        <span class="st_order-address-street"><?php echo $user_data->getAddress(); ?></span><br>

        <?php if($user_data->getAddressMore()): ?>
         <span class="st_order-address-street"><?php echo $user_data->getAddressMore(); ?></span><br>
        <?php endif;?>
        <?php if($user_data->getRegion()): ?>
           <span class="st_order-address-street"><?php echo $user_data->getRegion(); ?></span><br>
        <?php endif;?>
        <span class="st_order-address-code"><?php echo $user_data->getCode() ?></span>
        <span class="st_order-address-town"><?php echo $user_data->getTown() ?></span>
        <span class="st_order-address-country"><?php $user_data->getCountry()->setCulture($culture); echo $user_data->getCountry()->getName() ?></span>
        <?php if($user_data->getPesel()): ?>
        <br><span class="st_order-address-street"><?php echo __('PESEL') ?>&nbsp;<?php echo $user_data->getPesel() ?></span>
        <?php endif; ?>
    </p>
    
    <p>
        <?php echo $user_data->getPhone() ?>
    </p>
    <?php if($user_data->getVatNumber()): ?>
    <p>
<?php if ($user_data->getHasValidVatEu()): ?>
        <?php echo __('VAT UE') ?>: <?php echo $user_data->getVatNumber() ?>
        &nbsp;<a class="help" target="_blank" title="<?php echo __('Numer VAT UE został zweryfikowany za pośrednictwem usługi VIES. Kliknij na ikonkę, aby przejść do informacji szczegółowych.') ?>" href="<?php echo stTaxVies::checkVatUrl($user_data->getVatNumber()) ?>" style="background: url(/images/backend/eu.png) no-repeat 0px 2px"></a>
<?php else: ?>
        <?php echo __('NIP') ?>: <?php echo $user_data->getVatNumber() ?>
<?php endif; ?>
    </p>
    <?php endif; ?>
    

</address>
<?php else: ?>

<div class="form">
   <p>
      <?php echo label_for('order[user_data]['.$type.'][company]', __('firma:')) ?>
      <?php echo input_tag('order[user_data]['.$type.'][company]', $user_data->getCompany(), array('class' => 'company-field'))?>
      <br class="st_clear_all">
   </p>
   <p>
      <?php echo label_for('order[user_data]['.$type.'][full_name]', __('imię i nazwisko:')) ?>
      <?php echo input_tag('order[user_data]['.$type.'][full_name]', $user_data->getFullName(), array('class' => 'name-surname-field'))?>
      <br class="st_clear_all">
   </p>
   <?php echo form_error('order[user_data]['.$type.'][address]') ?>
   <?php echo form_error('order[user_data]['.$type.'][address]') ?>
   <p>
      <?php echo label_for('order[user_data]['.$type.'][address]', __('adres:')) ?>
      <?php echo input_tag('order[user_data]['.$type.'][address]', $user_data->getAddress(), array('class' => 'street-field'.(form_has_error('order{user_data}{'.$type.'}{address}') ? ' form_error' : '')))?>
      <br class="st_clear_all">
   </p>
   <p>
      <?php echo label_for('order[user_data]['.$type.'][address]', __('adres cd:')) ?>
      <?php echo input_tag('order[user_data]['.$type.'][address_more]', $user_data->getAddressMore(), array('class' => 'street-field'.(form_has_error('order{user_data}{'.$type.'}{address_more}') ? ' form_error' : '')))?>
      <br class="st_clear_all">
   </p>
   <p>
      <?php echo label_for('order[user_data]['.$type.'][region]', __('województwo:')) ?>
      <?php echo input_tag('order[user_data]['.$type.'][region]', $user_data->getRegion(), array('class' => 'street-field'.(form_has_error('order{user_data}{'.$type.'}{region}') ? ' form_error' : '')))?>
      <br class="st_clear_all">
   </p>
   <?php echo form_error('order[user_data]['.$type.'][code]') ?>
   <?php echo form_error('order[user_data]['.$type.'][town]') ?>
   <p>
      <?php echo label_for('order[user_data]['.$type.'][code]', __('kod, miasto:')) ?>
      <?php echo input_tag('order[user_data]['.$type.'][code]', $user_data->getCode(), array('class' => 'code-town-field'.(form_has_error('order{user_data}{'.$type.'}{code}') ? ' form_error' : '')))?>
      <?php echo input_tag('order[user_data]['.$type.'][town]', $user_data->getTown(), array('class' => 'code-town-field'.(form_has_error('order{user_data}{'.$type.'}{town}') ? ' form_error' : '')))?>
      <br class="st_clear_all">
   </p>
   <p>
<?php if ($user_data->getCountriesId()): ?>
      <?php echo label_for('order[user_data]['.$type.'][countries_id]', __('kraj:')) ?>
      <?php echo object_select_tag($user_data->getCountries(), 'getId', array('related_class' => 'Countries', 'control_name' => 'order[user_data]['.$type.'][countries_id]', 'peer_method' => 'doSelectActive','class' => 'country-field')); ?>
<?php else: $user_data->getCountry()->setCulture($culture) ?>
      <?php echo label_for('order[user_data]['.$type.'][country]', __('kraj:')) ?>
      <?php echo input_tag('order[user_data]['.$type.'][country]', $user_data->getCountry()->getName()) ?>
<?php endif; ?>
      <br class="st_clear_all">
   </p>
   <?php if ($user_data instanceof OrderUserDataBilling): ?>
   <p>
      <?php echo label_for('order[user_data]['.$type.'][pesel]', __('pesel:')) ?>
      <?php echo input_tag('order[user_data]['.$type.'][pesel]', $user_data->getPesel(), array('class' => 'street-field'.(form_has_error('order{user_data}{'.$type.'}{pesel}') ? ' form_error' : '')))?>
      <br class="st_clear_all">
   </p>
   <?php endif; ?>
   <p>
      <?php echo label_for('order[user_data]['.$type.'][phone]', __('telefon:')) ?>
      <?php echo input_tag('order[user_data]['.$type.'][phone]', $user_data->getPhone(), array('class' => 'phone-field'))?>
      <br class="st_clear_all">
   </p>
<?php if ($user_data instanceof OrderUserDataBilling): ?>
   <p>
      <?php echo label_for('order[user_data]['.$type.'][vat_number]', __('nip:')) ?>
      <?php echo input_tag('order[user_data]['.$type.'][vat_number]', $user_data->getVatNumber(), array('class' => 'vat_number-field'))?>
      <br class="st_clear_all">
   </p>
<?php endif; ?>
</div>

    
<?php endif;?>