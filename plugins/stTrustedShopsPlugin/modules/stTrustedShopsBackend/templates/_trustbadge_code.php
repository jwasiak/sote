<?php use_helper('stTrustedShops');?>
<?php echo object_textarea_tag($trusted_shops, 'getTrustbadgeCode', array('size' => '80x10', 'control_name' => 'trusted_shops[trustbadge_code]'));?>
<?php if(!$trusted_shops->isNew()):?>
    <div style="margin-top:2px;">
        <a href="<?php echo st_trusted_shops_backend_integration_url($trusted_shops);?>" target="_blank"><?php echo __('Kliknij, aby przejdź do centrum integracji TrustedShops i pobrać kod Trustbadge.');?></a>
    </div>
<?php endif;?>
