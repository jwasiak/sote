<?php use_helper('stAdminGenerator');?>
<?php use_stylesheet('backend/stMoneybookersPlugin.css');?>
<?php echo st_get_admin_head('stMoneybookersPlugin', __('Konfiguracja'), null, array('stPayment'));?>
    <div id="sf_admin_content">
        <?php st_include_partial('stAdminGenerator/message');?>
        <div id="sf_admin_content_config">
            <?php echo form_tag('moneybookers/index', array('id' => 'sf_admin_config_form', 'class' => "admin_form"));?>
                <fieldset>
                    <div class="st_fieldset-content">
                        <div class="form-row">
                            <?php echo label_for('moneybookers[pay_to_email]', __('Login'), array('class' => 'required'));?>
                            <?php echo input_tag('moneybookers[pay_to_email]', $config->get('pay_to_email'), array('size' => '10'));?>
                            <br class="st_clear_all" />
                        </div>
                        <div class="form-row">
                            <?php echo label_for('moneybookers[secret_word]', __('Słowo podpowiedzi'), array('class' => 'required'));?>
                            <?php echo input_tag('moneybookers[secret_word]', $config->get('secret_word'), array('size' => '10'));?>
                            <br class="st_clear_all" />
                        </div>
                        <div class="form-row">
                            <?php echo label_for('moneybookers[shop_description]', __('Opis sklepu').'<a href="#" class="help" title="'.__('Maksymalnie 30 znaków.').'"></a>', array('class' => 'required'));?>
                            <?php echo input_tag('moneybookers[shop_description]', $config->get('shop_description'), array('size' => '30', 'maxlength' => '30'));?>
                            <br class="st_clear_all" />
                        </div>
                        <div class="form-row">
                            <?php echo label_for('moneybookers[return_text]', __('Tekst przycisku powrotu do sklepu').'<a href="#" class="help" title="'.__('Maksymalnie 35 znaków.').'"></a>', array('class' => 'required'));?>
                            <?php echo input_tag('moneybookers[return_text]', $config->get('return_text'), array('size' => '30', 'maxlength' => '35'));?>
                            <br class="st_clear_all" />
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
