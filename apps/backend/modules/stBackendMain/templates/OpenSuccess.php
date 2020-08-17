<?php use_helper('I18N', 'stAdminGenerator'); ?>
<?php use_stylesheet("backend/open.css"); ?>
<?php echo st_get_admin_head('Open', __('Opcja ta jest dostępna TYLKO w wersji komercyjnej.', array()), __('Korzystasz z darmowej wersji Open', array()),NULL) ?>
<div id="open_site">
    <div class="left_side">
        <div class="feature_title">
            <div class="feature_title_left"><?php echo __('Dodatkowe funkcje komercyjne') ?></div>
            <div class="feature_title_right"></div>
            <div style="clear: both;"></div>
        </div>
        <div>
            <div style="float: left; width: 500px; border-left: 1px solid #BFC0BF; text-align: left; padding-left: 10px;">
                <div class="open-form-row-first">
                    <div class="open-form-row-title"><?php echo __('Aktualizacje (nowe funkcje) dla wersji 6 komercyjne') ?></div>
                    <div><img src="/images/backend/beta/icons/16x16/tick.png" alt="plus" width="22" height="18"/></div>
                </div>
                <div class="open-form-row">
                    <div class="open-form-row-title"><?php echo __('Kodowanie danych klientów w bazie danych') ?></div>
                    <div><img src="/images/backend/beta/icons/16x16/tick.png" alt="plus" width="22" height="18"/></div>
                </div>
                <div class="open-form-row">
                    <?php if ($action_name == 'setConfiguration'): ?><div class="open-form-row-title-selected"><?php else: ?><div class="open-form-row-title"><?php endif; ?><?php echo __('Edycja wybranych danych na listach w panelu') ?></div>
                    <div><img src="/images/backend/beta/icons/16x16/tick.png" alt="plus" width="22" height="18"/></div>
                </div>
                <div class="open-form-row">
                    <?php if ($action_name == 'mode'): ?><div class="open-form-row-title-selected"><?php else: ?><div class="open-form-row-title"><?php endif; ?><?php echo __('Edycja zamówień') ?></div>
                    <div><img src="/images/backend/beta/icons/16x16/tick.png" alt="plus" width="22" height="18"/></div>
                </div>
                <div class="open-form-row">
                    <?php if ($action_name == 'couponCodeList'): ?><div class="open-form-row-title-selected"><?php else: ?><div class="open-form-row-title"><?php endif; ?><?php echo __('Kody rabatowe') ?></div>
                    <div><img src="/images/backend/beta/icons/16x16/tick.png" alt="plus" width="22" height="18"/></div>
                </div>
                <div class="open-form-row">
                    <?php if ($module_name == 'stPointsBackend' || $action_name == 'pointsInfoEdit'): ?><div class="open-form-row-title-selected"><?php else: ?><div class="open-form-row-title"><?php endif; ?><?php echo __('System punktowy') ?></div>
                    <div><img src="/images/backend/beta/icons/16x16/tick.png" alt="plus" width="22" height="18"/></div>
                </div>
                <div class="open-form-row">
                    <?php if ($module_name == 'stAllegroBackend' || $action_name == 'allegroList'): ?><div class="open-form-row-title-selected"><?php else: ?><div class="open-form-row-title"><?php endif; ?><?php echo __('Allegro') ?></div>
                    <div><img src="/images/backend/beta/icons/16x16/tick.png" alt="plus" width="22" height="18"/></div>
                </div>
                <div class="open-form-row-last">
                    <?php if ($module_name == 'sfGuardGroup'): ?><div class="open-form-row-title-selected"><?php else: ?><div class="open-form-row-title"><?php endif; ?><?php echo __('Uprawnienia administratorów') ?></div>
                    <div><img src="/images/backend/beta/icons/16x16/tick.png" alt="plus" width="22" height="18"/></div>
                </div>
                <div class="open-form-row-last">
                    <?php if ($module_name == 'appProductAttributeBackend'): ?><div class="open-form-row-title-selected"><?php else: ?><div class="open-form-row-title"><?php endif; ?><?php echo __('Atrybuty produktów') ?></div>
                    <div><img src="/images/backend/beta/icons/16x16/tick.png" alt="plus" width="22" height="18"/></div>
                </div>
                <div class="open-form-row-last">
                    <?php if ($module_name == 'stGroupPriceBackend'): ?><div class="open-form-row-title-selected"><?php else: ?><div class="open-form-row-title"><?php endif; ?><?php echo __('Grupy cenowe') ?></div>
                    <div><img src="/images/backend/beta/icons/16x16/tick.png" alt="plus" width="22" height="18"/></div>
                </div>
                <div class="open-form-row-last">
                    <?php if ($action_name == 'addPriceList'): ?><div class="open-form-row-title-selected"><?php else: ?><div class="open-form-row-title"><?php endif; ?><?php echo __('Ceny w walutach') ?></div>
                    <div><img src="/images/backend/beta/icons/16x16/tick.png" alt="plus" width="22" height="18"/></div>
                </div>
            </div>
        </div>
        <div style="clear: both;"></div>
        <div class="feature_title">
            <div class="feature_title_left"><?php echo __('Systemy płatności') ?></div>
            <div class="feature_title_right"></div>
            <div style="clear: both;"></div>
        </div>
        <div>
            <div style="float: left; width: 500px; border-left: 1px solid #BFC0BF; text-align: left; padding-left: 10px;">
                <div class="open-form-row">
                    <?php if ($module_name == 'stPlatnosciPlBackend'): ?><div class="open-form-row-title-selected"><?php else: ?><div class="open-form-row-title"><?php endif; ?><?php echo __('PayU') ?></div>
                    <div><img src="/images/backend/beta/icons/16x16/tick.png" alt="plus" width="22" height="18"/></div>
                </div>
                <div class="open-form-row">
                    <?php if ($module_name == 'stDotpayBackend'): ?><div class="open-form-row-title-selected"><?php else: ?><div class="open-form-row-title"><?php endif; ?><?php echo __('Dotpay') ?></div>
                    <div><img src="/images/backend/beta/icons/16x16/tick.png" alt="plus" width="22" height="18"/></div>
                </div>
                <div class="open-form-row">
                    <?php if ($module_name == 'stPrzelewy24Backend'): ?><div class="open-form-row-title-selected"><?php else: ?><div class="open-form-row-title"><?php endif; ?><?php echo __('Przelewy24') ?></div>
                    <div><img src="/images/backend/beta/icons/16x16/tick.png" alt="plus" width="22" height="18"/></div>
                </div>
                <div class="open-form-row">
                    <?php if ($module_name == 'stLukasBackend'): ?><div class="open-form-row-title-selected"><?php else: ?><div class="open-form-row-title"><?php endif; ?><?php echo __('Lukas') ?></div>
                    <div><img src="/images/backend/beta/icons/16x16/tick.png" alt="plus" width="22" height="18"/></div>
                </div>
                <div class="open-form-row">
                    <?php if ($module_name == 'stPolcardBackend'): ?><div class="open-form-row-title-selected"><?php else: ?><div class="open-form-row-title"><?php endif; ?><?php echo __('Polcard') ?></div>
                    <div><img src="/images/backend/beta/icons/16x16/tick.png" alt="plus" width="22" height="18"/></div>
                </div>
                <div class="open-form-row">
                    <?php if ($module_name == 'stEcardBackend'): ?><div class="open-form-row-title-selected"><?php else: ?><div class="open-form-row-title"><?php endif; ?><?php echo __('eCard') ?></div>
                    <div><img src="/images/backend/beta/icons/16x16/tick.png" alt="plus" width="22" height="18"/></div>
                </div>
            </div>
        </div>
        <div style="clear: both;"></div>
        <div class="feature_title_last">
            <div class="feature_title_left"><?php echo __('Porównywarki') ?></div>
            <div class="feature_title_right"></div>
            <div style="clear: both;"></div>
        </div>
        <div>
            <div style="float: left; width: 500px; border-left: 1px solid #BFC0BF; text-align: left; padding-left: 10px;">
                <div class="open-form-row">
                    <?php if ($module_name == 'stCeneoBackend'): ?><div class="open-form-row-title-selected"><?php else: ?><div class="open-form-row-title"><?php endif; ?><?php echo __('Ceneo') ?></div>
                    <div><img src="/images/backend/beta/icons/16x16/tick.png" alt="plus" width="22" height="18"/></div>
                </div>
                <div class="open-form-row">
                    <?php if ($module_name == 'stZakupomatBackend'): ?><div class="open-form-row-title-selected"><?php else: ?><div class="open-form-row-title"><?php endif; ?><?php echo __('Zakupomat') ?></div>
                    <div><img src="/images/backend/beta/icons/16x16/tick.png" alt="plus" width="22" height="18"/></div>
                </div>
                <div class="open-form-row">
                    <?php if ($module_name == 'stNokautBackend'): ?><div class="open-form-row-title-selected"><?php else: ?><div class="open-form-row-title"><?php endif; ?><?php echo __('Nokaut') ?></div>
                    <div><img src="/images/backend/beta/icons/16x16/tick.png" alt="plus" width="22" height="18"/></div>
                </div>
                <div class="open-form-row">
                    <?php if ($module_name == 'stOferciakBackend'): ?><div class="open-form-row-title-selected"><?php else: ?><div class="open-form-row-title"><?php endif; ?><?php echo __('Oferciak') ?></div>
                    <div><img src="/images/backend/beta/icons/16x16/tick.png" alt="plus" width="22" height="18"/></div>
                </div>
                <div class="open-form-row">
                    <?php if ($module_name == 'stOkazjeBackend'): ?><div class="open-form-row-title-selected"><?php else: ?><div class="open-form-row-title"><?php endif; ?><?php echo __('Okazje') ?></div>
                    <div><img src="/images/backend/beta/icons/16x16/tick.png" alt="plus" width="22" height="18"/></div>
                </div>
                <div class="open-form-row">
                    <?php if ($module_name == 'stRadarBackend'): ?><div class="open-form-row-title-selected"><?php else: ?><div class="open-form-row-title"><?php endif; ?><?php echo __('Radar') ?></div>
                    <div><img src="/images/backend/beta/icons/16x16/tick.png" alt="plus" width="22" height="18"/></div>
                </div>
                <div class="open-form-row">
                    <?php if ($module_name == 'stSkapiecBackend'): ?><div class="open-form-row-title-selected"><?php else: ?><div class="open-form-row-title"><?php endif; ?><?php echo __('Skąpiec') ?></div>
                    <div><img src="/images/backend/beta/icons/16x16/tick.png" alt="plus" width="22" height="18"/></div>
                </div>
                <div class="open-form-row">
                    <?php if ($module_name == 'stSklepy24Backend'): ?><div class="open-form-row-title-selected"><?php else: ?><div class="open-form-row-title"><?php endif; ?><?php echo __('Sklepy24') ?></div>
                    <div><img src="/images/backend/beta/icons/16x16/tick.png" alt="plus" width="22" height="18"/></div>
                </div>
            </div>
        </div>
        <div style="clear: both;"></div>
    </div>
    <div class="right_side">
        <div style="clear: both;"></div>
        <div style="float: left; width: 553px; padding-right: 20px;">
            <div class="order_license"><?php if ($lang == 'pl_PL'): ?> <a target="sote" href="http://www.sote.pl/licencja-soteshop.html"> <?php else: ?> <a target="sote" href="http://www.soteshop.com/soteshop-license.html"> <?php endif; ?><?php echo __('Zamów wersję komercyjną za'); ?></a>  <b><?php if ($lang == 'pl_PL'): ?> 1990 zł<?php else: ?> €499.00<?php endif; ?></b><?php echo ', '.__('a otrzymsz dodatkowo') ?>:</div>
            <div class="open-form-row-right">
                <div class="open-form-row-right-title"><?php echo __('Gwarancję na program') ?></div>
                <div class="right-price"><?php if ($lang == 'pl_PL'): ?> 12 miesięcy <?php else: ?> 12 months <?php endif; ?></div>
            </div>
            <div class="open-form-row-right">
                <div class="open-form-row-right-title"><?php echo __('Pomoc techniczną') ?></div>
                <div class="right-price"><?php if ($lang == 'pl_PL'): ?> 3 miesiące <?php else: ?> 3 months <?php endif; ?></div>
            </div>
            <div class="open-form-row-right">
                <div class="open-form-row-right-title"><?php echo __('Kupon do <a href="http://www.sote.pl/category/aplikacje" target="_blank">WebStore</a>') ?></div>
                <div class="right-price"><?php if ($lang == 'pl_PL'): ?> 100 zł <?php else: ?> €25.00 <?php endif; ?></div>
            </div>
        </div>
        <div style="clear: both;"></div>
        <div style="margin: 50px 0px 50px 180px;">
            <?php if ($lang == 'pl_PL'): ?> <a class="aaa" target="sote" href="http://www.sote.pl/licencja-soteshop.html"> <?php else: ?> <a class="aaa" target="sote" href="http://www.soteshop.com/soteshop-license.html"> <?php endif; ?><span><?php echo __('Zamów wersję komercyjną') ?></span></a>
        </div>
        <div style="margin: 10px 0px 60px 130px;">
            <?php if ($lang == 'pl_PL'): ?>
                <img src="/images/backend/open/open_ecommerce.png">
            <?php else: ?>
                <img src="/images/backend/open/open_en_ecommerce.png">
            <?php endif; ?>
        </div>
        <?php if ($showChangeLicenseButton):?>
            <?php echo st_get_admin_actions_head('style="margin-top: 10px;');?>
                <?php echo st_get_admin_action('edit', __('Aktywuj wersje komercyjną', null, 'stBackendMain'), 'stShopInfoBackend/changeLicense');?>
            <?php echo st_get_admin_actions_foot();?>
        <?php endif;?>
    </div>
</div>
<div style="clear: both;"></div>  
<?php echo st_get_admin_foot() ?>