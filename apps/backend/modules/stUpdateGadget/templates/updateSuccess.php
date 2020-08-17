<?php use_stylesheet('/css/update/style2.css');?>
<div id="status_box" class="status_box_backend">
    <?php if($status === 'SOTE_CONNECTION_ERROR'):?>
        <div class="status_alert">
            <h4>
                <?php echo __('Błąd połączenia z serwerem aktualizacji.', null, 'stInstallerWeb');?>
            </h4>
            <div class="clear"></div>
        </div>
    <?php elseif($status === 'UPGRADE_SERVICE_NOT_ACTIVE'):?>
        <div class="status_alert">
            <h4>
                <?php echo __('Dostęp do aktualizacji wygasł dnia', null, 'stInstallerWeb');?>: <?php echo $upgradeServiceTime;?>
            </h4>
            <div class="clear"></div>
        </div>
    <?php elseif($status === 'PACKAGES_FOUND'):?>
        <div class="status_alert">
            <h4><?php echo __('Sklep nieaktualny', null, 'stInstallerWeb');?></h4> <?php echo __('Zaktualizuj swój sklep do najnowszej wersji.', null, 'stInstallerWeb');?>
            <div class="clear"></div>
        </div>
    <?php elseif($status === 'NOTHING_TO_UPGRADE'):?>
        <div class="status_current">
            <h4><?php echo __('Sklep aktualny', null, 'stInstallerWeb');?></h4> <?php echo __('Twój sklep jest zaktualizowany do najnowszej wersji.', null, 'stInstallerWeb');?>
        </div>
    <?php endif;?>
</div>
