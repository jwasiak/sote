<?php use_helper('I18N', 'stAdminGenerator', 'Validation') ?>
<?php echo st_get_admin_head(array('@stPayNowPlugin', __('Paynow'), '/images/backend/main/icons/stPayNowPlugin.png'), __('Konfiguracja')) ?> 
    <div id="sf_admin_content">
        <?php st_include_partial('stAdminGenerator/message', array('labels' => $labels));?>

            <?php echo form_tag('stPayNowBackend?action=index', array('id' => 'sf_admin_config_form', 'name' => 'sf_admin_config_form', 'class' => 'admin_form'));?>
                <?php if ($sf_request->hasParameter('debug')): ?>
                    <input type="hidden" name="debug" value="1">
                <?php endif ?>
                <fieldset>
                    <div class="content">
                        <?php echo st_admin_get_form_field('config[enabled]', $labels['config{enabled}'], 1, 'checkbox_tag', array('checked' => $config->get('enabled'))) ?>
                        <?php echo st_admin_get_form_field('config[autoredirect]', $labels['config{autoredirect}'], 1, 'checkbox_tag', array('checked' => $config->get('autoredirect'), 'help' => __('Przekieruj automatycznie na stronę płatności po złożeniu zamówienia', null, 'stPayment'))) ?>
                        <?php if (SF_ENVIRONMENT == 'dev' || $sf_request->hasParameter('debug')): ?>
                            <?php echo st_admin_get_form_field('config[sandbox]', $labels['config{sandbox}'], 1, 'checkbox_tag', array('checked' => $config->get('sandbox'))) ?>
                        <?php endif ?>
                        <?php echo st_admin_get_form_field('config[api_key]', $labels['config{api_key}'], $config->get('api_key'), 'input_password_tag', array('required' => true, 'autocomplete' => false, 'size' => 40)) ?>
                        <?php echo st_admin_get_form_field('config[api_signature_key]', $labels['config{api_signature_key}'], $config->get('api_signature_key'), 'input_password_tag', array('required' => true, 'autocomplete' => false, 'size' => 40)) ?>
                        <?php echo st_admin_get_form_field('ecard_notify_url', $labels['notify_url'], stPayNow::getNotifyUrl(), 'input_tag', array('readonly' => true, 'size' => 100, 'clipboard' => true)) ?>
                    </div>
                </fieldset>
                
                <?php echo st_get_admin_actions_head('style="margin-top: 10px; float: right"') ?>
                    <?php echo st_get_admin_action('save', __('Zapisz', array(), 'stAdminGeneratorPlugin'), null, array('name' => 'save')) ?>
                <?php echo st_get_admin_actions_foot() ?>
            </form>
       
    </div>
<?php echo st_get_admin_foot() ?>