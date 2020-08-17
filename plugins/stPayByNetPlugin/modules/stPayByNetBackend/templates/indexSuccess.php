<?php use_helper('I18N', 'stAdminGenerator', 'Validation', 'Object');?>
<?php $protocol = stConfig::getInstance('stSecurityBackend')->get('ssl') ? 'https' : 'http' ?>
<?php echo st_get_admin_head('stPayByNetPlugin', __('Konfiguracja', array()), __('',array()),array('stPayment'));?>
    <div id="sf_admin_content">
        <?php if ($sf_request->hasErrors()):?>
            <div class="form-errors">
                <h2><?php echo __('Correct the data in the form.', null, 'stAdminGeneratorPlugin');?></h2>
                <?php if (isset($labels)):?>
                    <dl>
                        <?php foreach ($sf_request->getErrorNames() as $name):?>
                            <dt><?php echo __($labels[$name])?></dt>
                            <dd><?php echo $sf_request->getError($name)?></dd>
                        <?php endforeach;?>
                    </dl>
                <?php endif;?>
            </div>
        <?php elseif ($sf_flash->has('notice')):?>
            <div class="save-ok">
                <h2><?php echo $sf_flash->get('notice');?></h2>
            </div>
        <?php elseif ($sf_flash->has('warning')):?>
            <div class="form-errors">
                <h2><?php echo $sf_flash->get('warning');?></h2>
            </div>
        <?php endif;?>
        <div id="sf_admin_content_config">
            <?php echo form_tag('paybynet/index', array('id' => 'sf_admin_config_form', 'name' => 'sf_admin_config_form', 'class' => 'admin_form'));?>
                <fieldset>
                    <div class="st_header">
                        <div>
                            <h2><?php echo __('Ustawienia główne');?></h2>
                        </div>
                    </div>
                    <div class="st_fieldset-content">
                        <div class="form-row <?php if($sf_request->hasError('config{id_client}')):?> form-error<?php endif;?>">
                            <?php echo label_for('config[id_client]', __('Identyfikator'), array('class' => 'required'));?>
                            <?php if($sf_request->hasErrors()):?>
                                <?php echo input_tag('config[id_client]', $sf_params->get('config[id_client]'), array('size' => '20'));?>
                            <?php else:?>
                                <?php echo input_tag('config[id_client]', $config->get('id_client'), array('size' => '20'));?>
                            <?php endif;?>
                            <br class="st_clear_all" />
                        </div>
                        <div class="form-row <?php if($sf_request->hasError('config{password}')):?> form-error<?php endif;?>">
                            <?php echo label_for('config[password]', __('Hasło'), array('class' => 'required'));?>
                            <?php if($sf_request->hasErrors()):?>
                                <?php echo input_password_tag('config[password]', $sf_params->get('config[password]'), array('size' => '20'));?>
                            <?php else:?>
                                <?php echo input_password_tag('config[password]', $config->get('password'), array('size' => '20'));?>
                            <?php endif;?>
                            <br class="st_clear_all" />
                        </div>
                        <div class="form-row">
                            <?php echo label_for('config[test]', __('Tryb testowy'), array());?>
                            <?php if($sf_request->hasErrors()):?>
                                <?php echo checkbox_tag('config[test]', true, $sf_params->get('config[test]'));?>
                            <?php else:?>
                                <?php echo checkbox_tag('config[test]', true, $config->get('test'));?>
                            <?php endif;?>
                            <br class="st_clear_all" />
                        </div>
                        <div class="form-row">
                            <?php echo label_for('config[card]', __('Włącz obsługę kart płatniczych'), array());?>
                            <?php if($sf_request->hasErrors()):?>
                                <?php echo checkbox_tag('config[card]', true, $sf_params->get('config[card]'));?>
                            <?php else:?>
                                <?php echo checkbox_tag('config[card]', true, $config->get('card'));?>
                            <?php endif;?>
                            <br class="st_clear_all" />
                        </div>
                    </div>
                </fieldset>
                <fieldset>
                    <div class="st_header">
                        <div>
                        	<h2><?php echo __('Ustawienia rachunku bankowego');?></h2>
                        </div>
                    </div>
                    <div class="st_fieldset-content">
                        <div class="form-row <?php if($sf_request->hasError('config{account}')):?> form-error<?php endif;?>">
                            <?php echo label_for('config[account]', __('Numer rachunku bankowego'), array('class' => 'required'));?>
                            <?php if($sf_request->hasErrors()):?>
                                <?php echo input_tag('config[account]', $sf_params->get('config[account]'), array('size' => '40'));?>
                            <?php else:?>
                                <?php echo input_tag('config[account]', $config->get('account'), array('size' => '40'));?>
                            <?php endif;?>
                            <br class="st_clear_all" />
                        </div>
                        <div class="form-row <?php if($sf_request->hasError('config{account_name}')):?> form-error<?php endif;?>">
                            <?php echo label_for('config[account_name]', __('Nazwa sprzedawcy'), array('class' => 'required'));?>
                            <?php if($sf_request->hasErrors()):?>
                                <?php echo input_tag('config[account_name]', $sf_params->get('config[account_name]'), array('size' => '40'));?>
                            <?php else:?>
                                <?php echo input_tag('config[account_name]', $config->get('account_name'), array('size' => '40'));?>
                            <?php endif;?>
                            <br class="st_clear_all" />
                        </div>
                        <div class="form-row <?php if($sf_request->hasError('config{account_code}')):?> form-error<?php endif;?>">
                            <?php echo label_for('config[account_code]', __('Kod pocztowy'), array('class' => 'required'));?>
                            <?php if($sf_request->hasErrors()):?>
                                <?php echo input_tag('config[account_code]', $sf_params->get('config[account_code]'), array('size' => '7'));?>
                            <?php else:?>
                                <?php echo input_tag('config[account_code]', $config->get('account_code'), array('size' => '7'));?>
                            <?php endif;?>
                            <br class="st_clear_all" />
                        </div>
                        <div class="form-row <?php if($sf_request->hasError('config{account_city}')):?> form-error<?php endif;?>">
                            <?php echo label_for('config[account_city]', __('Miasto'), array('class' => 'required'));?>
                            <?php if($sf_request->hasErrors()):?>
                                <?php echo input_tag('config[account_city]', $sf_params->get('config[account_city]'), array('size' => '15'));?>
                            <?php else:?>
                                <?php echo input_tag('config[account_city]', $config->get('account_city'), array('size' => '15'));?>
                            <?php endif;?>
                            <br class="st_clear_all" />
                        </div>
                        <div class="form-row <?php if($sf_request->hasError('config{account_street}')):?> form-error<?php endif;?>">
                            <?php echo label_for('config[account_street]', __('Adres'), array('class' => 'required'));?>
                            <?php if($sf_request->hasErrors()):?>
                                <?php echo input_tag('config[account_street]', $sf_params->get('config[account_street]'), array('size' => '40'));?>
                            <?php else:?>
                                <?php echo input_tag('config[account_street]', $config->get('account_street'), array('size' => '40'));?>
                            <?php endif;?>
                            <br class="st_clear_all" />
                        </div>
                        <div class="form-row <?php if($sf_request->hasError('config{account_country}')):?> form-error<?php endif;?>">
                            <?php echo label_for('config[account_country]', __('Kraj'), array('class' => 'required'));?>
                            <?php if($sf_request->hasErrors()):?>
                                <?php echo select_tag('config[account_country]', options_for_select(_get_options_from_objects(CountriesPeer::doSelectWithI18n(new Criteria(), $sf_user->getCulture())), $sf_params->get('config[account_country]')));?>
                            <?php else:?>
                                <?php echo select_tag('config[account_country]', options_for_select(_get_options_from_objects(CountriesPeer::doSelectWithI18n(new Criteria(), $sf_user->getCulture())), $config->get('account_country')));?>
                            <?php endif;?>
                            <br class="st_clear_all" />
                        </div>
                    </div>
                </fieldset>
                <fieldset>
                    <h2><?php echo __('Konfiguracja adresów') ?></h2>
                    <div class="content">
                        <?php echo st_admin_get_form_field('config[success]', __('Adres powiadomień'), $protocol.'://'.$sf_request->getHost().'/paybynet/statusReport', 'input_tag', array('readonly' => true, 'size' => 70, 'clipboard' => true)) ?>
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