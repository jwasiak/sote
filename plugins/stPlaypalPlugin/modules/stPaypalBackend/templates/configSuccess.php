<?php use_helper('Object', 'Validation', 'ObjectAdmin', 'I18N', 'Date', 'VisualEffect', 'stAdminGenerator') ?>

<?php echo st_get_admin_head('stPaypalPlugin', __('Konfiguracja'), null,array('stPayment')) ?>
<div id="sf_admin_content">
    <div id="sf_admin_content_config">
        <?php st_include_partial('stAdminGenerator/message', array('labels' => $labels)) ?>
        <?php echo form_tag('stPaypalBackend/save', array('id' => 'sf_admin_config_form')) ?>
        <fieldset id="sf_fieldset-paypal-live">
            <div class="st_header">
                <div>
                    <h2><?php echo __('Konfiguracja ogólna') ?></h2>
                </div>
            </div>
            <div class="st_fieldset-content">
                <div class="form-row">
                    <?php echo label_for('config_test_mode', __('Tryb testowy')) ?>
                    <div class="content">
                        <?php echo checkbox_tag('config[test_mode]', true,  $config->get('test_mode')) ?>

                        <br class="st_clear_all"/>
                    </div>
                </div>
                <div class="form-row">
                    <?php echo label_for('config_show_shipping_info', __('Pokaż dane dostawy').' <a href="#" class="help" title="'.__('Wyświetla dane dostawy na stronie potwierdzenia płatności PayPal').'"></a>') ?>
                    <div class="content">
                        <?php echo checkbox_tag('config[show_shipping_info]', true,  $config->get('show_shipping_info')) ?>
                        <br class="st_clear_all"/>
                    </div>
                </div>                
            </div>
        </fieldset>
        <fieldset id="sf_fieldset-paypal-live">
            <div class="st_header">
                <div>
                    <h2><?php echo __('PayPal Express') ?></h2>
                </div>
            </div>
            <div class="st_fieldset-content">
                <div class="form-row">
                    <?php echo label_for('config_express', __('Włącz płatność na karcie produktu')) ?>
                    <div class="content">
                        <?php echo checkbox_tag('config[express]', true,  $config->get('express')) ?>

                        <br class="st_clear_all"/>
                    </div>
                </div>
                <div class="form-row">
                    <?php echo label_for('config_show_shipping_info', __('Domyślna dostawa'));?>
                    <div class="content">
                        <?php echo select_tag('config[express_delivery]', objects_for_select($deliveries, 'getId', 'getName', $config->get('express_delivery')));?>
                        <br class="st_clear_all"/>
                    </div>
                </div>                
            </div>
        </fieldset>
        <fieldset id="sf_fieldset-paypal-live">
            <div class="st_header">
                <div>
                    <h2><?php echo __('Dane dostępowe do API - Tryb produkcyjny') ?></h2>
                </div>
            </div>
            <div class="st_fieldset-content">
                <div class="form-row">
                    <?php echo label_for('config_live_api_username', __('Nazwa użytkownika API'), array('class' => 'required')) ?>

                    <div class="content<?php if ($sf_request->hasError('config{live_api_username}')): ?> form-error<?php endif; ?>">
                        <?php if ($sf_request->hasError('config{live_api_username}')): ?>
                            <?php echo form_error('config{live_api_username}', array('class' => 'form-error-msg')) ?>
                        <?php endif; ?>
                        <?php echo input_tag('config[live_api_username]', $config->get('live_api_username'), array('disabled' => $config->get('test_mode'), 'class' => 'st_paypal-live-field', 'size' => 30)) ?>

                        <br class="st_clear_all"/>
                    </div>
                </div>
                <div class="form-row">
                    <?php echo label_for('config_live_api_password', __('Hasło API'), array('class' => 'required')) ?>

                    <div class="content<?php if ($sf_request->hasError('config{live_api_password}')): ?> form-error<?php endif; ?>">
                        <?php if ($sf_request->hasError('config{live_api_password}')): ?>
                            <?php echo form_error('config{live_api_password}', array('class' => 'form-error-msg')) ?>
                        <?php endif; ?>
                        <?php echo input_password_tag('config[live_api_password]', $config->get('live_api_password'), array('disabled' => $config->get('test_mode'), 'class' => 'st_paypal-live-field')) ?>
                        <br class="st_clear_all"/>
                    </div>
                </div>
                <div class="form-row">
                    <?php echo label_for('config_live_api_signature', __('Podpis API'), array('class' => 'required')) ?>

                    <div class="content<?php if ($sf_request->hasError('config{live_api_signature}')): ?> form-error<?php endif; ?>">
                        <?php if ($sf_request->hasError('config{live_api_signature}')): ?>
                            <?php echo form_error('config{live_api_signature}', array('class' => 'form-error-msg')) ?>
                        <?php endif; ?>
                        <?php echo input_password_tag('config[live_api_signature]', $config->get('live_api_signature'), array('disabled' => $config->get('test_mode'), 'class' => 'st_paypal-live-field', 'size' => 55)) ?>
                        <br class="st_clear_all"/>
                    </div>
                </div>
            </div>
        </fieldset>
        <fieldset id="sf_fieldset-paypal-sandbox">
            <div class="st_header">
                <div>
                    <h2><?php echo __('Dane dostępowe do API - Tryb testowy') ?></h2>
                </div>
            </div>
            <div class="st_fieldset-content">
                <div class="form-row">
                    <?php echo label_for('config_sandbox_api_username', __('Nazwa użytkownika API'), array('class' => 'required')) ?>

                    <div class="content<?php if ($sf_request->hasError('config{sandbox_api_username}')): ?> form-error<?php endif; ?>">
                        <?php if ($sf_request->hasError('config{sandbox_api_username}')): ?>
                            <?php echo form_error('config{sandbox_api_username}', array('class' => 'form-error-msg')) ?>
                        <?php endif; ?>
                        <?php echo input_tag('config[sandbox_api_username]', $config->get('sandbox_api_username'), array('disabled' => !$config->get('test_mode'), 'class' => 'st_paypal-sandbox-field', 'size' => 30)) ?>
                        <br class="st_clear_all"/>
                    </div>
                </div>
                <div class="form-row">
                    <?php echo label_for('config_sandbox_api_password', __('Hasło API'), array('class' => 'required')) ?>

                    <div class="content<?php if ($sf_request->hasError('config{sandbox_api_password}')): ?> form-error<?php endif; ?>">
                        <?php if ($sf_request->hasError('config{sandbox_api_password}')): ?>
                            <?php echo form_error('config{sandbox_api_password}', array('class' => 'form-error-msg')) ?>
                        <?php endif; ?>
                        <?php echo input_password_tag('config[sandbox_api_password]', $config->get('sandbox_api_password'), array('disabled' => !$config->get('test_mode'), 'class' => 'st_paypal-sandbox-field')) ?>
                        <br class="st_clear_all"/>
                    </div>
                </div>
                <div class="form-row">
                    <?php echo label_for('config_sandbox_api_signature', __('Podpis API'), array('class' => 'required')) ?>

                    <div class="content<?php if ($sf_request->hasError('config{sandbox_api_signature}')): ?> form-error<?php endif; ?>">
                        <?php if ($sf_request->hasError('config{sandbox_api_signature}')): ?>
                            <?php echo form_error('config{sandbox_api_signature}', array('class' => 'form-error-msg')) ?>
                        <?php endif; ?>
                        <?php echo input_password_tag('config[sandbox_api_signature]', $config->get('sandbox_api_signature'), array('disabled' => !$config->get('test_mode'), 'class' => 'st_paypal-sandbox-field', 'size' => 55)) ?>
                        <br class="st_clear_all"/>
                    </div>
                </div>
            </div>
        </fieldset>
        <?php if ($config->get('configuration_verified')): ?>
        <fieldset id="sf_fieldset-paypal-account">
            <div class="st_header">
                <div>
                    <h2><?php echo __('Informacje o koncie') ?></h2>
                </div>
            </div>
            <div class="st_fieldset-content">
                <div class="form-row">
                    <div style="float: left; width: 250px"><?php echo __('Bilans konta') ?></div>

                    <div class="content" id="st_paypal-account-balance">
                        <?php echo image_tag('backend/stPaypalPlugin/ajax-loader.gif') ?>
                    </div>
                </div>
                <div class="form-row">
                    <div style="float: left; width: 250px"><?php echo __('Oczekujące płatności') ?></div>

                    <div class="content" id="st_paypal-pending-payments">
                        <?php echo image_tag('backend/stPaypalPlugin/ajax-loader.gif') ?>
                    </div>
                </div>

            </div>
        </fieldset>
        <?php endif; ?>
        <?php echo st_get_admin_actions_head('style="margin-top: 10px; float: right"') ?>
        <?php echo st_get_admin_action('save', __('Zapisz', null, 'stAdminGeneratorPlugin'), null, array ('name' => 'save')) ?>
        <?php echo st_get_admin_actions_foot() ?>
        </form>
    </div>
</div>
<br class="st_clear_all" />
<?php echo st_get_admin_foot() ?>

<script type="text/javascript">
    jQuery(function($) {

        $('#config_test_mode').on('change', function() {
            var input = $(this);

            if (input.prop('checked'))
            {
                $('.st_paypal-sandbox-field').prop('disabled', false);
                $('.st_paypal-live-field').prop('disabled', true);
            }
            else
            {
                $('.st_paypal-sandbox-field').prop('disabled', true);
                $('.st_paypal-live-field').prop('disabled', false);
            }
        });

        $.get('<?php echo url_for('stPaypalBackend/ajaxPaypalAccountBalance') ?>', function(response) {
            $('#st_paypal-account-balance').html(response);
        });

        $.get('<?php echo url_for('stPaypalBackend/ajaxPaypalPendingPayments') ?>', function(response) {
            $('#st_paypal-pending-payments').html(response);
        });
    });
</script>