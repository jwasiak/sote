<?php use_helper('I18N', 'stAdminGenerator', 'stBackend');?>
<?php st_include_partial('stProduct/header', array('related_object' => $product, 'title' => __('Dodatkowe opcje'), 'route' => null));?>
<?php st_include_component('stProduct', 'editMenu', array('related_object' => $product));?>
<div id="sf_admin_content_config">
    <?php if (stSoteshopVersion::getVersion() == stSoteshopVersion::ST_SOTESHOP_VERSION_POLISH):?>
        <div class="application_shortcuts" style="min-height: 100px; margin: 10px; border: 1px solid #ccc; padding: 10px;">
            <ul>
                <li>
                    <div class="icon" style="float: left;">
                        <a style="background-image: url(<?php echo get_app_icon('/images/backend/main/icons/stAllegroPlugin.png');?>); background-size: 35px 35px;" href="<?php echo url_for('@stAllegroPlugin?action=list&product_id='.$product->getId());?>"></a>
                    </div>
                    <div class="name">
                        <?php echo link_to(__('Allegro'), '@stAllegroPlugin?action=list&product_id='.$product->getId());?>
                    </div>
                </li>
                <li>
                    <div class="icon" style="float: left;">
                        <a style="background-image: url(<?php echo get_app_icon('/images/backend/main/icons/stLukasPlugin.png');?>); background-size: 35px 35px;" href="<?php echo url_for('stProduct/lukasEdit?product_id='.$product->getId());?>"></a>
                    </div>
                    <div class="name">
                        <?php echo link_to(__('Credit Agricole Raty'), 'stProduct/lukasEdit?product_id='.$product->getId());?>
                    </div>
                </li>
                <?php if(!is_null(stRegisterSync::getPackageVersion('stPoznajomosciPlugin'))):?>
                    <li>
                        <div class="icon" style="float: left;">
                            <a style="background-image: url(<?php echo get_app_icon('/images/backend/main/icons/stPoznajomosciPlugin.png');?>); background-size: 35px 35px;" href="<?php echo url_for('stProduct/poznajomosciEdit?product_id='.$product->getId());?>"></a>
                        </div>
                        <div class="name">
                            <?php echo link_to(__('Poznajomosci.pl'), 'stProduct/poznajomosciEdit?product_id='.$product->getId());?>
                        </div>
                    </li>
                <?php endif;?>
                <li>
                    <div class="icon" style="float: left;">
                        <a style="background-image: url(<?php echo get_app_icon('/images/backend/main/icons/stPriceCompare.png');?>); background-size: 35px 35px;" href="<?php echo url_for('stProduct/priceCompareCustom?product_id='.$product->getId());?>"></a>
                    </div>
                    <div class="name">
                        <?php echo link_to(__('Porównywarki cen'), 'stProduct/priceCompareCustom?product_id='.$product->getId());?>
                    </div>
                </li>
                <li>
                    <div class="icon" style="float: left;">
                        <a style="background-image: url(<?php echo get_app_icon('/images/backend/main/icons/stGoogleShoppingPlugin.png');?>); background-size: 35px 35px;" href="<?php echo url_for('stProduct/googleShoppingEdit?product_id='.$product->getId());?>"></a>
                    </div>
                    <div class="name">
                        <?php echo link_to(__('Google Shopping'), 'stProduct/googleShoppingEdit?product_id='.$product->getId());?>
                    </div>
                </li>
                <li>
                    <div class="icon" style="float: left;">
                        <a style="background-image: url(<?php echo get_app_icon('/images/backend/main/icons/stCompatibilityPlugin.png');?>); background-size: 35px 35px;" href="<?php echo url_for('@stCompatibilityPlugin?action=productConfig&product_id='.$product->getId());?>"></a>
                    </div>
                    <div class="name">
                        <?php echo link_to(__('Moduł zgodności', null, 'stCompatibilityBackend'), '@stCompatibilityPlugin?action=productConfig&product_id='.$product->getId());?>
                    </div>
                </li>                
            </ul>
        </div>
    <?php else:?>
        <?php echo __('Brak dodatkowych opcji.');?>
    <?php endif;?>
</div>
<?php st_include_partial('stProduct/footer');?>
