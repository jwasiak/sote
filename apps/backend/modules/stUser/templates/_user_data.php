<?php if(!$user_data->getAddress()): ?>

   <?php if($user_data->getIsBilling()==1): ?>
        <?php echo link_to(__("Brak danych"), "user/userDataBillingEdit?user_id=".$user_data->getSfGuardUserId()); ?>
    <?php else: ?> 
        <?php echo link_to(__("Brak danych"), "user/userDataDeliveryEdit?user_id=".$user_data->getSfGuardUserId()); ?>
    <?php endif; ?>
    
<?php else: ?> 

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
        <span class="st_order-address-street"><?php echo $user_data->getAddress(); ?></span><br />
        <?php if($user_data->getAddressMore()): ?>
        <span class="st_order-address-street"><?php echo $user_data->getAddressMore(); ?></span><br />
        <?php endif;?>
        <?php if($user_data->getRegion()): ?>
        <span class="st_order-address-street"><?php echo $user_data->getRegion(); ?></span><br />
        <?php endif;?>
        <span class="st_order-address-code"><?php echo $user_data->getCode() ?></span>
        <span class="st_order-address-town"><?php echo $user_data->getTown() ?></span>
        <span class="st_order-address-country"><?php echo $user_data->getcountries() ?></span>
        <?php if($user_data->getPesel()): ?>
        <br><span class="st_order-address-town"><?php echo __('PESEL') ?>&nbsp;<?php echo $user_data->getPesel(); ?></span>
        <?php endif;?>


    </p>
    <p>
        <?php echo $user_data->getPhone() ?>
    </p>
    <?php if($user_data->getIsBilling()==1): ?>
        <?php if($user_data->getVatNumber()): ?>
            <p>
                <?php echo __('NIP') ?>&nbsp;<?php echo $user_data->getVatNumber() ?>
            </p>
        <?php endif; ?>
    <?php endif; ?>




</address>

<?php endif; ?>