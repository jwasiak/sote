<?php use_helper('Object', 'Validation', 'ObjectAdmin', 'I18N', 'Date', 'VisualEffect', 'stAdminGenerator') ?>

<?php echo st_get_admin_head(array('@stSantanderBackend?action=config', __('Santander Consumer Bank'), '/images/backend/main/icons/red/stSantanderRatyPlugin.png'), __('Konfiguracja')) ?>
<div id="sf_admin_content">
    <div id="sf_admin_content_config">
        <?php st_include_partial('stAdminGenerator/message') ?>
        <?php echo form_tag('@stSantanderBackend?action=save', array('id' => 'sf_admin_config_form', 'class' => 'admin_form')) ?>
        <fieldset>
            <div class="st_fieldset-content">
                <?php echo st_admin_get_form_field('config[shop_number]', __('Numer sklepu'), $config->get('shop_number'), 'input_tag', array('required' => true)); ?>           
            </div>
        </fieldset>
        <?php echo st_get_admin_actions_head('style="margin-top: 10px; float: right"') ?>
        <?php echo st_get_admin_action('save', __('Zapisz', null, 'stAdminGeneratorPlugin'), null, array ('name' => 'save')) ?>
        <?php echo st_get_admin_actions_foot() ?>
        </form>
    </div>
</div>
<br class="st_clear_all" />
<?php echo st_get_admin_foot() ?>