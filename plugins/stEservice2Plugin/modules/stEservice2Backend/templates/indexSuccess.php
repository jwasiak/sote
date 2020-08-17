<?php use_helper('I18N', 'stAdminGenerator', 'Validation') ?>
<?php echo st_get_admin_head('stEservice2Plugin', __('Konfiguracja'), array('culture' => null), array('stPayment')) ?>   
    <div id="sf_admin_content">
        <?php st_include_partial('stAdminGenerator/message', array('labels' => $labels));?>

            <?php echo form_tag('@stEservice2Plugin?action=index', array('id' => 'sf_admin_config_form', 'name' => 'sf_admin_config_form', 'class' => 'admin_form'));?>
                <fieldset>
                    <div class="content">
                        <?php echo st_admin_get_form_field('config[enabled]', __('Włącz'), 1, 'checkbox_tag', array('checked' => $config->get('enabled'))) ?>
                        <?php echo st_admin_get_form_field('config[autoredirect]', __('Automatyczne przekierowanie', null, 'stPayment'), 1, 'checkbox_tag', array('checked' => $config->get('autoredirect'), 'help' => __('Przekieruj automatycznie na stronę płatności po złożeniu zamówienia', null, 'stPayment'))) ?>
                        <?php echo st_admin_get_form_field('config[test]', __('Tryb testowy'), 1, 'checkbox_tag', array('checked' => $config->get('test'))) ?>
                        <?php echo st_admin_get_form_field('config[client_id]', __('Identyfikator sprzedawcy'), $config->get('client_id'), 'input_tag', array('required' => true)) ?>
                        <?php echo st_admin_get_form_field('config[password]', __('Hasło'), $config->get('password'), 'input_password_tag', array('required' => true, 'autocomplete' => 'new-password')) ?>
                        <?php echo st_admin_get_form_field('config[brand_id]', __('Identyfikator marki'), $config->get('brand_id'), 'input_tag', array('required' => false)) ?>
                    </div>

                </fieldset>
                
                <?php echo st_get_admin_actions_head('style="margin-top: 10px; float: right"') ?>
                    <?php echo st_get_admin_action('save', __('Zapisz', array(), 'stAdminGeneratorPlugin'), null, array('name' => 'save')) ?>
                <?php echo st_get_admin_actions_foot() ?>
            </form>
       
    </div>
<?php echo st_get_admin_foot() ?>