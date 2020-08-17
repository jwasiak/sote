<?php echo form_tag('stNokautBackend/config', array('id' => 'sf_admin_config_form', 'name' => 'sf_admin_config_form', 'multipart' => true));?>
    <fieldset id="sf_fieldset_none" class="">
        <div class="st_header">
            <div>
                <h2><?php echo __('Ustawienia generowania pliku xml');?></h2>
            </div>
        </div>
        <div class="st_fieldset-content" id="sf_fieldset_none_slide">
            <div class="form-row">
                <?php echo label_for('config[use_product_code]', __('Dodaj kod producenta na podstawie kodu produktu'), '');?>
                <div class="content<?php if ($sf_request->hasError('config{use_product_code}')):?> form-error<?php endif;?>">
                    <?php if($sf_request->hasError('config{use_product_code}')):?>
                        <?php echo form_error('config{use_product_code}', array('class' => 'form-error-msg'));?>
                    <?php endif;?>
                    <?php $value = checkbox_tag('config[use_product_code]', 1, $config->get('use_product_code'), array());?>
                    <?php echo $value ? $value : '&nbsp;';?>
                    <br class="st_clear_all" />
                </div>
            </div>
        </div>
    </fieldset>
    <fieldset id="sf_fieldset_none" class="">
        <div class="st_header">
            <div>
                <h2><?php echo __('Informacje o dostępności produktów');?></h2>
            </div>
        </div>
        <div class="st_fieldset-content" id="sf_fieldset_none_slide">
            <?php foreach(stNokaut::getAvailabilities() as $availability):?>
                <div class="form-row">
                    <?php echo label_for('config[availability_'.$availability->getId().']', __('Dostępność w sklepie').': "'.$availability->getAvailabilityName().'"', '');?>
                    <div class="content">
                        <?php echo __('Dostępność w Nokaut');?>:
                        <?php echo select_tag('config[availability_'.$availability->getId().']', options_for_select(stNokaut::getNokautAvailabilities(), $config->get('availability_'.$availability->getId())));?>
                        <br class="st_clear_all" />
                    </div>
                </div>
            <?php endforeach;?>
        </div>
    </fieldset>
    <?php st_include_partial('config_actions', array('config' => $config, 'forward_parameters' => $forward_parameters)) ?>
</form>
