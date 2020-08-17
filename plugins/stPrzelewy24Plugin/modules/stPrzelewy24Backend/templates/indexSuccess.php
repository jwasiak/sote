<?php use_helper('I18N', 'stAdminGenerator');?>
<?php echo st_get_admin_head('stPrzelewy24Plugin', __('Konfiguracja'), '', array('stPayment'));?>
    <div id="sf_admin_content">
        <?php st_include_partial('stAdminGenerator/message', array('labels' => $labels));?>
        <div id="sf_admin_content_config">
            <?php echo form_tag('przelewy24/index', array('id' => 'sf_admin_config_form', 'class' => 'admin_form'));?>
                <fieldset>
                    <div class="content">
                        <?php echo st_admin_get_form_field('config[autoredirect]', $labels['config{autoredirect}'], true, 'checkbox_tag', array('checked' => $config->get('autoredirect'), 'help' => __('Przekierowuje automatycznie na stronę płatności po złożeniu zamówienia'))) ?>
                        <?php echo st_admin_get_form_field('config[test]', $labels['config{test}'], true, 'checkbox_tag', array('checked' => $config->get('test'))) ?>
                        <?php echo st_admin_get_form_field('config[przelewy24_id]', $labels['config{przelewy24_id}'], $config->get('przelewy24_id'), 'input_tag', array('required' => true)) ?>
                        <?php echo st_admin_get_form_field('config[salt]', $labels['config{salt}'], $config->get('salt'), 'input_tag', array('required' => true)) ?>
                    </div> 
                </fieldset>            
                <?php echo st_get_admin_actions_head('style="margin-top: 10px; float: right"');?>
                    <?php echo st_get_admin_action('save', __('Zapisz', null, 'stAdminGeneratorPlugin'), null, array('name' => 'save'));?>
                <?php echo st_get_admin_actions_foot();?>
            </form>
        </div>
    </div>
    <br class="st_clear_all" />
<?php echo st_get_admin_foot();?>