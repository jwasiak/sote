<?php use_helper('I18N', 'stAdminGenerator', 'Validation');?>
<?php use_stylesheet('backend/stShopInfoPlugin.css');?>
<?php echo st_get_admin_head('stShopInfoPlugin', __('Informacje o licencji'), __('Informacje o sklepie'), array());?>
<?php echo st_get_component('stAdminGenerator', 'menu', array('items' => $menu_items)) ?>
    <?php if ($sf_flash->has('notice')):?>
        <div class="save-ok" style="margin: 10px;">
            <h2><?php echo __($sf_flash->get('notice'), array(), 'stAdminGeneratorPlugin');?></h2>
        </div>
    <?php endif;?>
    <?php if ($sf_request->hasErrors()):?>
        <div class="form-errors" style="margin: 10px;">
            <h2><?php echo __('Popraw dane w formularzu.', array(), 'stAdminGeneratorPlugin');?></h2>
            <dl>
                <dd><?php echo $sf_request->getError('license_number');?></dd>
            </dl>
        </div>
    <?php endif;?>
    <?php echo form_tag('shop_info/changeLicense', array('id' => 'sf_admin_edit_form', 'name' => 'sf_admin_edit_form'));?>
    <div id="sf_admin_content_edit" style="margin: 10px; min-height: 50px; border: 1px solid #ccc; padding: 10px;">
        <div class=" <?php if($sf_request->hasError('license_number')):?> form-error<?php endif;?>" style="text-align: center; font-family: Helvetica,Arial,sans-serif; font-size: 12px; padding-top: 15px;">
            <?php echo label_for('license_number', __('Numer licencji'), array('class' => 'required'));?>:
            <?php if($sf_request->hasErrors()):?>
                <?php echo input_tag('license_number', $sf_params->get('license_number'), array('size' => 30, 'style' => 'vertical-align: middle'));?>
            <?php else:?>
                <?php echo input_tag('license_number', $config->get('license'), array('size' => 30, 'style' => 'vertical-align: middle'));?>
            <?php endif;?>
            <br class="st_clear_all" />
        </div>
        </div>
        <?php echo st_get_admin_actions_head('style="margin-top: 0px; margin-right: 10px; float: right"');?>
            <?php echo st_get_admin_action('save', __('Zapisz', array(), 'stAdminGeneratorPlugin'), null, array('name' => 'save'));?>
        <?php echo st_get_admin_actions_foot();?>
    </form>
    
<?php echo st_get_admin_foot();?>