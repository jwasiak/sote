<?php use_helper('I18N', 'stAdminGenerator');?>
<?php use_stylesheet('backend/stShopInfoPlugin.css');?>
<?php echo st_get_admin_head('stShopInfoPlugin', __('Informacje o licencji'), __('Informacje o sklepie'), array());?>
<?php echo st_get_component('stAdminGenerator', 'menu', array('items' => $menu_items)) ?>
    <div id="st_register" style="margin: 10px; min-height: 50px; border: 1px solid #ccc; padding: 10px;">
        <div class="st_row" style="text-align: center; font-family: Helvetica,Arial,sans-serif; font-size: 12px; padding-top: 15px;">
            <label><?php echo __('Numer licencji');?>:</label>
            <b><?php echo $config->get('license');?></b>
            <br class="st_clear_all">
        </div>

        <?php if($config->get('company')!=""):?>
        <div class="st_row">
            <label><?php echo __('Firma');?>:</label>
            <b><?php echo $config->get('company');?></b>
            <br class="st_clear_all">
        </div>
        <?php endif;?>

       <?php if($config->get('vatNumber')!=""):?>
        <div class="st_row">
            <label><?php echo __('NIP');?>:</label>
            <b><?php echo $config->get('vatNumber');?></b>
            <br class="st_clear_all">
        </div>
        <?php endif;?>

       <?php if($config->get('name')!="" || $config->get('surname')!=""):?>
        <div class="st_row">
            <label><?php echo __('Imie i nazwisko');?>:</label>
            <b><?php echo $config->get('name');?> <?php echo $config->get('surname');?></b>
            <br class="st_clear_all">
        </div>
        <?php endif;?>

        <?php if($config->get('street')!="" || $config->get('house')!="" || $config->get('flat')!=""):?>
        <div class="st_row">
            <label><?php echo __('Ulica, nr domu');?>:</label>
            <b>
                <?php echo $config->get('street');?> <?php echo $config->get('house');?>
                <?php if($config->get('flat')):?>
                    /<?php echo $config->get('flat');?>
                <?php endif;?>
            </b>
            <br class="st_clear_all">
        </div>
        <?php endif;?>

        <?php if($config->get('code')!="" || $config->get('town')!=""):?>
        <div class="st_row">
            <label><?php echo __('Kod, miasto');?>:</label>
            <b><?php echo $config->get('code');?> <?php echo $config->get('town');?></b>
            <br class="st_clear_all">
        </div>
       <?php endif;?>

       <?php if($config->get('phone')!=""):?>
       <div class="st_row">
            <label><?php echo __('Telefon');?>:</label>
            <b><?php echo $config->get('phone');?></b>
            <br class="st_clear_all">
       </div>
       <?php endif;?>

    </div>
    <?php if ($showChangeLicenseButton):?>
        <?php echo st_get_admin_actions_head('style="float: right; margin-right: 10px; margin-top: 0px;"');?>
            <?php echo st_get_admin_action('edit', __('Zmień numer licencji', null, 'stShopInfoBackend'), 'stShopInfoBackend/changeLicense');?>
        <?php echo st_get_admin_actions_foot();?>
    <?php endif;?>
<?php echo st_get_admin_foot();?>