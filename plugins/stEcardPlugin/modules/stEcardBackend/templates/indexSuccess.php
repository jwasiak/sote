<?php use_helper('I18N', 'stAdminGenerator', 'Validation') ?>
<?php $protocol = stConfig::getInstance('stSecurityBackend')->get('ssl') ? 'https' : 'http' ?>
<?php echo st_get_admin_head('stEcardPlugin', __('Konfiguracja', array()), __('', array()),array('stPayment')) ?>   
    <div id="sf_admin_content">
        <?php st_include_partial('stAdminGenerator/message', array('labels' => $labels, 'i18n_catalogue' => 'stEcardBackend'));?>
        <div id="sf_admin_content_config">
            <?php echo form_tag('ecard/index', array('id' => 'sf_admin_config_form', 'name' => 'sf_admin_config_form', 'class' => 'admin_form')) ?>
                <fieldset>
                    <div class="st_header">
                        <div>
                            <h2><?php echo __('') ?></h2>
                        </div>
                    </div>

                    <div class="st_fieldset-content">
                        <div class="form-row<?php if($sf_request->hasError('ecard{ecard_id}')): ?> form-error<?php endif; ?>">
                            <?php echo label_for('ecard[ecard_id]', __('Identyfikator'), array('class' => 'required')) ?>
                            
                            <?php if($sf_request->hasErrors()): ?>
                                <?php echo input_tag('ecard[ecard_id]', $sf_params->get('ecard[ecard_id]')) ?>
                            <?php else: ?>
                                <?php echo input_tag('ecard[ecard_id]', $config->get('ecard_id')) ?>
                            <?php endif; ?>
                            
                            <br class="st_clear_all" />
                        </div>

                        <div class="form-row<?php if($sf_request->hasError('ecard{ecard_password}')): ?> form-error<?php endif; ?>">
                            <?php echo label_for('ecard[ecard_password]', __('Hasło autoryzacji'), array('class' => 'required')) ?>
                            
                            <?php if($sf_request->hasErrors()): ?>
                                <?php echo input_password_tag('ecard[ecard_password]', $sf_params->get('ecard[ecard_password]')) ?>
                            <?php else: ?>
                                <?php echo input_password_tag('ecard[ecard_password]', $config->get('ecard_password')) ?>
                            <?php endif; ?>
                            
                            <br class="st_clear_all" />
                        </div>

                        <?php echo st_admin_get_form_field('ecard_notify_url', __('Adres powiadomienia POST'), $protocol.'://'.$sf_request->getHost().'/ecard/statusReport/'.stEcard::getPostSecureHash(), 'input_tag', array('readonly' => true, 'size' => 80, 'clipboard' => true)) ?>
                    </div>
                </fieldset>
                 <?php echo input_hidden_tag('ecard[transaction_fix]',$config->get('transaction_fix')) ?>
                <?php echo st_get_admin_actions_head('style="margin-top: 10px; float: right"') ?>
                    <?php echo st_get_admin_action('save', __('Zapisz', array(), 'stAdminGeneratorPlugin'), null, array('name' => 'save')) ?>
                <?php echo st_get_admin_actions_foot() ?>
            </form>
        </div>
    </div>
    <br class="st_clear_all" />
<?php echo st_get_admin_foot() ?>