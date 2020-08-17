<?php 

use_helper('stPaczkomaty');
$paczkomaty_params = array();

if ($paczkomaty_pack->hasAllegroTransactionId())
{
    $paczkomaty_params['function'] = 'AllegroParcelCollect';
}
else
{
    $paczkomaty_params['function'] = 'ParcelCollect';
}

if ($paczkomaty_pack->hasCashOnDelivery())
{
    $paczkomaty_params['paymentavailable'] = 't';
}

?>
<?php if($paczkomaty_pack->isNew()):?>
    <?php echo input_hidden_tag('order', $sf_request->getParameter('order'));?>
    <div class="row">
        <label for="paczkomaty_pack_customer_email">
            <?php echo __('Adres e-mail odbiorcy', array(), 'stPaczkomatyBackend');?>:
        </label>
        <div class="field<?php if ($sf_request->hasError('paczkomaty_pack{customer_email}')):?> form-error<?php endif; ?>">
            <?php if ($sf_request->hasError('paczkomaty_pack{customer_email}')):?>
                <?php echo form_error('paczkomaty_pack{customer_email}', array('class' => 'form-error-msg'));?>
            <?php endif;?>
            <?php echo input_tag('paczkomaty_pack[customer_email]', !$sf_request->hasParameter('paczkomaty_pack[customer_email]') ? $paczkomaty_pack->getCustomerEmail() : $sf_request->getParameter('paczkomaty_pack[customer_email]'), array('size' => 30));?> 
            <div class="clr"></div>
        </div>
    </div>
    <div class="row">
        <label for="paczkomaty_pack_customer_phone">
            <?php echo __('Numer komórkowy odbiorcy', array(), 'stPaczkomatyBackend');?>:
        </label>
        <div class="field<?php if ($sf_request->hasError('paczkomaty_pack{customer_phone}')): ?> form-error<?php endif;?>">
            <?php if ($sf_request->hasError('paczkomaty_pack{customer_phone}')):?>
                <?php echo form_error('paczkomaty_pack{customer_phone}', array('class' => 'form-error-msg'));?>
            <?php endif;?>
            <?php echo input_tag('paczkomaty_pack[customer_phone]', !$sf_request->hasParameter('paczkomaty_pack[customer_phone]') ? $paczkomaty_pack->getCustomerPhone() : $sf_request->getParameter('paczkomaty_pack[customer_phone]'), array('size' => 15));?> 
            <div class="clr"></div>
        </div>
    </div>
    <div class="row">
        <label for="paczkomaty_pack_customer_paczkomat">
            <?php echo __('Paczkomat odbiorcy', array(), 'stPaczkomatyBackend');?>:
        </label>
        <?php show_paczkomaty_dropdown_list('paczkomaty_pack[customer_paczkomat]', $paczkomaty_pack->getCustomerPaczkomat(), array('paczkomaty' => $paczkomaty_params));?>
        <div class="clr"></div>
    </div>
<?php else:?>
    <div class="row">
        <label for="paczkomaty_pack_customer_email">
            <?php echo __('Adres e-mail odbiorcy', array(), 'stPaczkomatyBackend');?>:
        </label>
        <?php echo $paczkomaty_pack->getCustomerEmail();?> 
        <div class="clr"></div>
    </div>
    <div class="row">
        <label for="paczkomaty_pack_customer_phone">
            <?php echo __('Numer komórkowy odbiorcy', array(), 'stPaczkomatyBackend');?>:
        </label>
        <?php echo $paczkomaty_pack->getCustomerPhone();?>
        <div class="clr"></div>
    </div>
    <div class="row">
        <label for="paczkomaty_pack_customer_paczkomat">
            <?php echo __('Paczkomat odbiorcy', array(), 'stPaczkomatyBackend');?>:
        </label>
        <div id="st-paczkomaty-customer-machine">
            <img src="/images/backend/icons/indicator.gif" alt="loading..." />
        </div>
        <div class="clr"></div>
    </div>
<?php endif;?>
