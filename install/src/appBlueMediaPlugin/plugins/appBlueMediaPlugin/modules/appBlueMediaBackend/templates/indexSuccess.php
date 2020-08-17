<?php use_helper('I18N', 'stAdminGenerator', 'Validation', 'appBlueMediaBackend');?>
<?php echo st_get_admin_head(array('@appBlueMediaBackend', __('BlueMedia'), '/images/backend/main/icons/appBlueMediaPlugin.png'), __('Konfiguracja'), null, array('stPayment')) ?>
    <div id="sf_admin_content">
        <?php st_include_partial('stAdminGenerator/message', array('labels' => $labels));?>
        <div id="sf_admin_content_config">
            <?php echo form_tag('@appBlueMediaBackend', array('id' => 'sf_admin_config_form', 'name' => 'sf_admin_config_form', 'class' => 'admin_form'));?>
                <?php if ($sf_request->hasParameter('debug')): ?>
                    <input type="hidden" name="debug">
                <?php endif ?>
                <fieldset>
                    <div class="content">
                        <?php echo st_admin_get_form_field('config[enabled]', __('Włącz'), 1, 'checkbox_tag', array('checked' => $config->get('enabled'))) ?>
                        <?php echo st_admin_get_form_field('config[autoredirect]', __('Automatyczne przekierowanie'), 1, 'checkbox_tag', array('checked' => $config->get('autoredirect'), 'help' => __('Przekierowuje automatycznie na stronę płatności po złożeniu zamówienia'))) ?>
                        <?php echo st_admin_get_form_field('config[gateways_popup]', __('Pokazuj wybór płatności w okienku popup'), 1, 'checkbox_tag', array('checked' => $config->get('gateways_popup'))) ?>
                        <?php if (SF_ENVIRONMENT == 'dev' || $sf_request->hasParameter('debug')): ?>
                            <?php echo st_admin_get_form_field('config[sandbox]', __('Tryb testowy'), 1, 'checkbox_tag', array('checked' => $config->get('sandbox'))) ?>
                        <?php endif ?>
                        </div>
                </fieldset>
                <fieldset>
                    <h2><?php echo __('Konfiguracja konta') ?></h2>
                    <div class="content">
                        <?php echo st_admin_get_form_field('config[id]', __('ID'), $config->get('id'), 'input_tag', array('required' => true, 'autocomplete' => "off")) ?>
                        <?php echo st_admin_get_form_field('config[key]', __('Klucz'), $config->get('key'), 'input_password_tag', array('required' => true, 'size' => '40', 'autocomplete' => "off")) ?>
                        <?php if (isset($gateways) && $gateways): ?>
                            <?php echo st_admin_get_form_field('gateways', __('Kanały płatności'), $activeGateways, 'app_blue_media_channel_list', array('required' => true)) ?>
                        <?php endif ?>
                    </div>
                </fieldset>
                <fieldset>
                    <h2><?php echo __('Adresy dla konfiguracji usługi') ?></h2>
                    <div class="content">
                        <?php echo st_admin_get_form_field('bluemedia_return_url', __('Adres powrotu po płatności'), appBlueMedia::getSecureReturnUrl(), 'input_tag', array('readonly' => true, 'size' => 80, 'clipboard' => true)) ?>
                        <?php echo st_admin_get_form_field('bluemedia_itn_url', __('Adres na który jest wysyłany ITN'), appBlueMedia::getSecureItnUrl(), 'input_tag', array('readonly' => true, 'size' => 80, 'clipboard' => true)) ?>
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

<script>
jQuery(function($) {
    $('#config_gateways_popup').change(function() {
        $('#gateways').tokenInput('updateTokens'); 
    });
});
</script>
