<?php use_helper('I18N', 'stAdminGenerator', 'Validation') ?>
<?php echo st_get_admin_head('stDotpayPlugin', __('Konfiguracja'), array('culture' => $config->getCulture()), array('stPayment')) ?>   
    <div id="sf_admin_content">
        <?php st_include_partial('stAdminGenerator/message', array('labels' => $labels));?>

            <?php echo form_tag('dotpay/index?culture='.$config->getCulture(), array('id' => 'sf_admin_config_form', 'name' => 'sf_admin_config_form', 'class' => 'admin_form'));?>
                <fieldset>
                    <div class="content">
                        <?php echo st_admin_get_form_field('config[test]', __('Tryb testowy'), 1, 'checkbox_tag', array('checked' => $config->get('test'))) ?>
                        <?php echo st_admin_get_form_field('config[dotpay_id]', __('Identyfikator'), $config->get('dotpay_id'), 'input_tag', array('required' => true)) ?>
                        <?php echo st_admin_get_form_field('config[pin]', __('Numer PIN do weryfikacji płatności'), $config->get('pin'), 'input_password_tag', array('required' => true)) ?>
                        <?php echo st_admin_get_form_field('config[shop_name]', __('Nazwa sklepu'), $config->get('shop_name')) ?>
                        <?php echo st_admin_get_form_field('config[button_back_text]', __('Tekst przycisku powrotu do sklepu'), $config->get('button_back_text')) ?>
                    </div>
                </fieldset>
                
                <?php echo st_get_admin_actions_head('style="margin-top: 10px; float: right"') ?>
                    <?php echo st_get_admin_action('save', __('Zapisz', array(), 'stAdminGeneratorPlugin'), null, array('name' => 'save')) ?>
                <?php echo st_get_admin_actions_foot() ?>
            </form>
       
    </div>
<?php echo st_get_admin_foot() ?>