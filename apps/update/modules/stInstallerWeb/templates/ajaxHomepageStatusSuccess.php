<?php if(stLicense::isOpen()):?>
    <div class="status_alert">
        <h4>
            <?php echo __('Wersja OPEN nie posiada dostępu do aktualizacji.', null, 'stInstallerWeb');?>
        </h4>
        <a href="<?php echo __('http://www.sote.pl/licencja-soteshop.html', null, 'stInstallerWeb');?>" target="_blank">
            <?php echo __('Zamów wersję komercyjną.', null, 'stInstallerWeb');?>
        </a>
        <div class="clear"></div>
    </div>
<?php elseif($status === 'SOTE_CONNECTION_ERROR'):?>
    <div class="status_alert">
        <h4>
            <?php echo __('Błąd połączenia z serwerem aktualizacji.', null, 'stInstallerWeb');?>
        </h4>
        <div class="clear"></div>
    </div>
<?php elseif($status === 'UPGRADE_SERVICE_NOT_ACTIVE'):?>
    <div class="status_alert">
        <h4>
            <?php echo __('Sklep nieaktualny', null, 'stInstallerWeb'); ?>
        </h4>
        <?php $license_info = stCommunication::getLicenseInfo(30); ?>
        <?php if ($license_info['type'] == 'ROK' || $license_info['type'] == 'MIESIĄC'): $message = stCommunication::blockSite(30) ? __('Przedłuż usługę korzystania z SOTESHOP') : __('Przedłuż usługę korzystania z SOTESHOP. Twój sklep będzie zablokowany za %days% dni', array('%days%' => $days)); ?>
            <div style="color: #C62929">
                <?php echo $message ?> <form class="st_admin-actions" style="float: none; margin: 10px 0px; color: #C62929" action="<?php echo $sf_user->getCulture() == 'pl_PL' ? 'https://www.sote.pl/category/zamow' : 'https://www.soteshop.com/category/order'; ?>" method="post"><button style="padding: 5px 10px" type="submit"><?php echo __('Zamów') ?></button></form>
            </div>
        <?php else: ?>
            <?php echo __('Dostęp do aktualizacji wygasł dnia', null, 'stInstallerWeb');?>: <?php echo $upgradeServiceTime;?>
            <p style="color: #C62929">
                <?php if ($sf_user->getCulture() == 'pl_PL'): ?>
                    Zamów dostęp do <a style="color: #C62929" href="http://www.sote.pl/dostep-do-aktualizacji.html" target="sote">aktualizacji sklepu</a>
                <?php else: ?>
                    Order access to <a style="color: #C62929" href="http://www.soteshop.com/access-to-update.html" target="sote">shop updates</a>
                <?php endif ?>
            </p>
        <?php endif ?>
        <div class="clear"></div>
    </div>
<?php elseif($status === 'PACKAGES_FOUND'):?>
    <div class="status_alert">
        <h4><?php echo __('Sklep nieaktualny', null, 'stInstallerWeb');?></h4> <?php echo __('Zaktualizuj swój sklep do najnowszej wersji.', null, 'stInstallerWeb');?>
        <div class="clear"></div>
        <div class="st_admin-actions">
            <span class="download"><?php echo link_to(__('Pobierz aktualizacje', null, 'stInstallerWeb'),'stInstallerWeb/upgradeList');?></span>
            <span class="install"><?php echo link_to(__('Instaluj aktualizacje', null, 'stInstallerWeb'),'stInstallerWeb/syncList');?></span>
        </div>
        <div class="clear"></div>
    </div>
<?php elseif($status === 'NOTHING_TO_UPGRADE'):?>
        <?php if($isSeven):?>
            <div class="status_current">
                <h4><?php echo __('Sklep aktualny', null, 'stInstallerWeb');?></h4>
                <?php echo __('Twój sklep jest zaktualizowany do najnowszej wersji.', null, 'stInstallerWeb');?>
            </div>
        <?php else:?>
            <div class="status_alert">
                <h4><?php echo __('Dostępna jest nowa wersja sklepu.', null, 'stInstallerWeb');?></h4>
                <a href="<?php echo __('http://www.sote.pl/aktualizacja-soteshop-z-wersji-6-do-7.html');?>" target="_blank">
                    <?php echo __('Zamów aktualizację do wersji 7.', null, 'stInstallerWeb');?>
                </a>
            </div>
        <?php endif;?>
    </div>
<?php endif;?>
