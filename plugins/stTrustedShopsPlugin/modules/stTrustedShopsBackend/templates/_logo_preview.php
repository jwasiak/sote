<?php use_stylesheet('backend/stTrustedShopsPlugin.css'); ?>
<div id="trusted_shops_sealbox">
    <div class="trusted_shops_sealbox_top_small"></div>
    <div class="trusted_shops_sealbox_middle">
        <img src="/images/frontend/theme/default/stTrustedShopsPlugin/logo.png" alt="" title="<?php echo __('Znak Jakości Trusted Shops – tu możesz sprawdzić ważność!');?>"/>
        <div class="trusted_shops_sealbox_txt">
            <?php echo $trusted_shops->getUrl();?> <?php echo __('to sklep internetowy z Certyfikatem i Ochroną Kupującego, certyfikowany przez Trusted Shops. Zobacz więcej...')?>
        </div>
    </div>
    <div class="trusted_shops_sealbox_bottom"></div>
</div>