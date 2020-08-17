<?php use_helper('I18N', 'stAdminGenerator', 'Validation');?>
<?php echo st_get_admin_head('stLukasPlugin', __('Konfiguracja'), __('',array()),array('stPayment'));?>
    <div id="sf_admin_content">
        <?php st_include_partial('stAdminGenerator/message', array('labels' => $labels));?>
        <div id="sf_admin_content_config">
            <?php echo form_tag('lukas/index', array('id' => 'sf_admin_config_form', 'name' => 'sf_admin_config_form'));?>
                <fieldset>
                    <div class="st_header">
                        <div>
                            <h2><?php echo __('Ustawienia główne');?></h2>
                        </div>
                    </div>
                    <div class="st_fieldset-content">
                        <div class="form-row <?php if($sf_request->hasError('config{param_profile}')):?> form-error<?php endif;?>">
                            <?php echo label_for('config[param_profile]', __('Identyfikator'), array('class' => 'required'));?>
                            <?php if($sf_request->hasErrors()):?>
                                <?php echo input_tag('config[param_profile]', $sf_params->get('config[param_profile]'), array('size' => '10'));?>
                            <?php else:?>
                                <?php echo input_tag('config[param_profile]', $config->get('param_profile'), array('size' => '10'));?>
                            <?php endif;?>
                            <br class="st_clear_all" />
                        </div>
                        <div class="form-row <?php if($sf_request->hasError('config{shop_name}')):?> form-error<?php endif;?>">
                            <?php echo label_for('config[shop_name]', __('Nazwa sklepu'));?>
                            <?php if($sf_request->hasErrors()):?>
                                <?php echo input_tag('config[shop_name]', $sf_params->get('config[shop_name]'), array('size' => '30'));?>
                            <?php else:?>
                                <?php echo input_tag('config[shop_name]', $config->get('shop_name'), array('size' => '30'));?>
                            <?php endif;?>
                            <br class="st_clear_all" />
                        </div>
                    </div>
                </fieldset>
                <fieldset>
                    <div class="st_header">
                        <div>
                            <h2><?php echo __('Adresy powrotów i eWniosku');?></h2>
                        </div>
                    </div>
                    <div class="st_fieldset-content">
                        <div class="form-row">
                            <?php echo label_for('config[ewniosek]', __('Adres eWniosku, procedury i symulatora'), array());?>
                            <nobr>http://<?php echo $webRequest->getHost(); ?>/credit-agricole/ewniosek</nobr>
                            <br class="st_clear_all" />
                        </div>
                        <div class="form-row">
                            <?php echo label_for('config[url_success]', __('Adres powrotu po złożeniu wniosku'), array());?>
                            <nobr>http://<?php echo $webRequest->getHost(); ?>/credit-agricole/returnSuccess</nobr>
                            <br class="st_clear_all" />
                        </div>
                        <div class="form-row">
                            <?php echo label_for('config[url_fail]', __('Adres powrotu po rezygnacji'), array());?>
                            <nobr>http://<?php echo $webRequest->getHost(); ?>/credit-agricole/returnFail</nobr>
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
    <br class="st_clear_all" />
<?php echo st_get_admin_foot();?>