<?php use_helper('I18N', 'stAdminGenerator', 'Validation');?>
<?php echo st_get_admin_head('stEservicePlugin', __('Konfiguracja', array()), __('',array()),array('stPayment'));?>
    <div id="sf_admin_content">
        <?php st_include_partial('stAdminGenerator/message', array('labels' => $labels, 'i18n_catalogue' => 'stEcardBackend'));?>
        <div id="sf_admin_content_config">
            <?php echo form_tag('eservice/index', array('id' => 'sf_admin_config_form', 'name' => 'sf_admin_config_form', 'class' => 'admin_form'));?>
                <fieldset>
                    <div class="st_header">
                        <div>
                            <h2><?php echo __('Ustawienia główne');?></h2>
                        </div>
                    </div>
                    <div class="st_fieldset-content">
                        <?php echo st_admin_get_form_field('config[enabled]', __('Włącz'), 1, 'checkbox_tag', array('checked' => $config->get('enabled'))) ?>
                        <div class="form-row">
                            <?php echo label_for('config[test]', __('Tryb testowy'), array());?>
                            <?php if($sf_request->hasErrors()):?>
                                <?php echo checkbox_tag('config[test]', true, $sf_params->get('config[test]'));?>
                            <?php else:?>
                                <?php echo checkbox_tag('config[test]', true, $config->get('test'));?>
                            <?php endif;?>
                            <br class="st_clear_all" />
                        </div>
                        <div class="form-row <?php if($sf_request->hasError('config{client_id}')):?> form-error<?php endif;?>">
                            <?php echo label_for('config[client_id]', __('Numer sprzedawcy'), array('class' => 'required'));?>
                            <?php if($sf_request->hasErrors()):?>
                                <?php echo input_tag('config[client_id]', $sf_params->get('config[client_id]'), array('size' => '15'));?>
                            <?php else:?>
                                <?php echo input_tag('config[client_id]', $config->get('client_id'), array('size' => '15'));?>
                            <?php endif;?>
                            <br class="st_clear_all" />
                        </div>
                        <div class="form-row <?php if($sf_request->hasError('config{password}')):?> form-error<?php endif;?>">
                            <?php echo label_for('config[password]', __('Hasło sprzedawcy'), array('class' => 'required'));?>
                            <?php if($sf_request->hasErrors()):?>
                                <?php echo input_password_tag('config[password]', $sf_params->get('config[password]'), array('size' => '15'));?>
                            <?php else:?>
                                <?php echo input_password_tag('config[password]', $config->get('password'), array('size' => '15'));?>
                            <?php endif;?>
                            <br class="st_clear_all" />
                        </div>
                        <div class="form-row <?php if($sf_request->hasError('config{store_key}')):?> form-error<?php endif;?>">
                            <?php echo label_for('config[store_key]', __('Klucz sklepu'), array('class' => 'required'));?>
                            <?php if($sf_request->hasErrors()):?>
                                <?php echo input_password_tag('config[store_key]', $sf_params->get('config[store_key]'), array('size' => '15'));?>
                            <?php else:?>
                                <?php echo input_password_tag('config[store_key]', $config->get('store_key'), array('size' => '15'));?>
                            <?php endif;?>
                            <br class="st_clear_all" />
                        </div>
                    </div>
                </fieldset>
                <?php echo st_get_admin_actions_head('style="margin-top: 10px; float: right"');?>
                    <?php echo st_get_admin_action('save', __('Zapisz', null, 'stAdminGeneratorPlugin'), null, array('name' => 'save'));?>
                <?php echo st_get_admin_actions_foot();?>
            </form>
        </div>
    </div>
<?php echo st_get_admin_foot();?>