<?php use_helper('I18N', 'stAdminGenerator', 'Validation');?>
<?php echo st_get_admin_head(array('@stInBankBackend', __('RATY Inbank'), '/images/backend/main/icons/stInBankPlugin.png'), __('Konfiguracja'), null, array('stPayment')) ?>
    <div id="sf_admin_content">
        <?php st_include_partial('stAdminGenerator/message', array('labels' => $labels));?>
        <div id="sf_admin_content_config">
            <?php echo form_tag('@stInBankBackend', array('id' => 'sf_admin_config_form', 'name' => 'sf_admin_config_form', 'class' => 'admin_form', 'autocomlete' => 'off'));?>
                <?php if ($sf_request->hasParameter('debug')): ?>
                    <input type="hidden" name="debug" value="1">
                <?php endif ?>
                <fieldset>
                    <div class="content">
                        <?php echo st_admin_get_form_field('config[enabled]', __('Włącz'), 1, 'checkbox_tag', array('checked' => $config->get('enabled'))) ?>
                        <?php if (SF_ENVIRONMENT == 'dev' || $sf_request->hasParameter('debug')): ?>
                            <?php echo st_admin_get_form_field('config[sandbox]', __('Tryb testowy'), 1, 'checkbox_tag', array('checked' => $config->get('sandbox'))) ?>
                        <?php endif ?>
                        <?php echo st_admin_get_form_field('config[product_code]', __('Kod produktu'), $config->get('product_code'), 'input_tag', array('required' => true, 'autocomplete' => "off", 'size' => '40')) ?>
                        <?php echo st_admin_get_form_field('config[uuid]', __('UUID'), $config->get('uuid'), 'input_tag', array('required' => true, 'autocomplete' => "off", 'size' => '40')) ?>
                        <?php echo st_admin_get_form_field('config[api_key]', __('Klucz API'), $config->get('api_key'), 'input_password_tag', array('required' => true, 'size' => '40', 'autocomplete' => "new-password")) ?>
                        </div>
                </fieldset>
                <?php echo st_get_admin_actions_head('style="margin-top: 10px; float: right"');?>
                    <?php echo st_get_admin_action('save', __('Zapisz', array(), 'stAdminGeneratorPlugin'), null, array('name' => 'save'));?>
                <?php echo st_get_admin_actions_foot();?>
            </form>
        </div>
    </div>
    <br class="st_clear_all" />
<?php echo st_get_admin_foot();?>
