<?php $protocol = stConfig::getInstance('stSecurityBackend')->get('ssl') ? 'https' : 'http' ?>
<?php use_helper('I18N', 'stAdminGenerator', 'Validation') ?>
<?php echo st_get_admin_head('stPolcardPlugin', __('Konfiguracja'), array('culture' => $config->getCulture()), array('stPayment')) ?>   
    <div id="sf_admin_content">
        <?php st_include_partial('stAdminGenerator/message', array('labels' => $labels));?>

            <?php echo form_tag('stPolcardBackend/index', array('id' => 'sf_admin_config_form', 'name' => 'sf_admin_config_form', 'class' => 'admin_form'));?>
                <fieldset>
                    <div class="content">
                        <?php echo st_admin_get_form_field('config[test]', __('Tryb testowy'), 1, 'checkbox_tag', array('checked' => $config->get('test'))) ?>
                        <?php echo st_admin_get_form_field('config[pos_id]', __('Identyfikator sprzedaży'), $config->get('pos_id'), 'input_tag', array('required' => true)) ?>
                        <?php echo st_admin_get_form_field('config[shared_key]', __('Klucz współdzielony'), $config->get('shared_key'), 'input_password_tag', array('required' => true)) ?>
                    </div>
                </fieldset>
                <fieldset>
                    <h2><?php echo __('Konfiguracja adresów') ?></h2>
                    <div class="content">
                        <?php echo st_admin_get_form_field('config[success]', __('Url dla odpowiedzi pozytywnej'), $protocol.'://'.$sf_request->getHost().'/polcard/returnSuccess', 'input_tag', array('readonly' => true, 'size' => 70, 'clipboard' => true)) ?>
                        <?php echo st_admin_get_form_field('config[fail]', __('Url dla odpowiedzi negatywnej'), $protocol.'://'.$sf_request->getHost().'/polcard/returnFail', 'input_tag', array('readonly' => true, 'size' => 70, 'clipboard' => true)) ?>
                        <?php echo st_admin_get_form_field('config[notify]', __('Url dla odpowiedzi potwierdzenia'), $protocol.'://'.$sf_request->getHost().'/polcard/statusReport', 'input_tag', array('readonly' => true, 'size' => 70, 'clipboard' => true)) ?>                       
                    </div>
                </fieldset>                
                <?php echo st_get_admin_actions_head('style="margin-top: 10px; float: right"') ?>
                    <?php echo st_get_admin_action('save', __('Zapisz', array(), 'stAdminGeneratorPlugin'), null, array('name' => 'save')) ?>
                <?php echo st_get_admin_actions_foot() ?>
            </form>
       
    </div>
<?php echo st_get_admin_foot() ?>