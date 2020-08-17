<?php use_helper('I18N', 'stAdminGenerator');?>
<?php echo st_get_admin_head('stHtaccessPlugin', __('Konfiguracja', null, 'stBackend'), null, array());?>
    <div id="sf_admin_content">
        <?php if ($sf_request->hasErrors()):?>
            <div class="form-errors">
                <h2><?php echo __('Błąd podczas walidacji danych.') ?></h2>
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
                <h2><?php echo __($sf_flash->get('notice'));?></h2>
            </div>
        <?php elseif ($sf_flash->has('warning')):?>
            <div class="form-errors">
                <h2><?php echo __($sf_flash->get('warning'));?></h2>
            </div>
        <?php endif;?>
        <div id="sf_admin_content_config">
            <?php echo form_tag('htaccess/index', array('id' => 'sf_admin_config_form', 'name' => 'sf_admin_config_form'));?>
                <fieldset>
                    <div class="st_fieldset-content">
                        <div class="form-row <?php if($sf_request->hasError('config{error}')):?> form-error<?php endif;?>">
                            <?php echo label_for('config[top]', __('Początek pliku'));?>
                            <?php if($sf_request->hasErrors()):?>
                                <?php echo textarea_tag('config[top]', $sf_params->get('config[top]'), array('size' => '100x5'));?>
                            <?php else:?>
                                <?php echo textarea_tag('config[top]', $config->get('top'), array('size' => '100x5'));?>
                            <?php endif;?>
                            <br class="st_clear_all" />
                        </div>
                        <div class="form-row <?php if($sf_request->hasError('config{error}')):?> form-error<?php endif;?>">
                            <?php echo label_for('config[middle]', __('Środek pliku'));?>
                            <?php if($sf_request->hasErrors()):?>
                                <?php echo textarea_tag('config[middle]', $sf_params->get('config[middle]'), array('size' => '100x5'));?>
                            <?php else:?>
                                <?php echo textarea_tag('config[middle]', $config->get('middle'), array('size' => '100x5'));?>
                            <?php endif;?>
                            <br class="st_clear_all" />
                        </div>
                        <div class="form-row <?php if($sf_request->hasError('config{error}')):?> form-error<?php endif;?>">
                            <?php echo label_for('config[bottom]', __('Koniec pliku'));?>
                            <?php if($sf_request->hasErrors()):?>
                                <?php echo textarea_tag('config[bottom]', $sf_params->get('config[bottom]'), array('size' => '100x5'));?>
                            <?php else:?>
                                <?php echo textarea_tag('config[bottom]', $config->get('bottom'), array('size' => '100x5'));?>
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
    <br class="st_clear_all" />
<?php echo st_get_admin_foot();?>
