<?php use_helper('I18N', 'stAdminGenerator') ?>
<?php echo st_get_admin_head('stPriceCompare', __('Dodawanie produktów do porównywarek cen'), __('Zarządzanie produktami w porównywarkach cen, konfiguracja ustawień.'), NULL) ?>  
    <?php include_partial('menu', array()) ?>
    <div id="sf_admin_content_config" style="padding: 10px"> 
        <?php st_include_partial('stAdminGenerator/message') ?>
        <div id="sf_admin_content_config">
            <?php echo form_tag('price_compare/config', array('id' => 'sf_admin_config_form', 'name' => 'sf_admin_config_form'));?>
                <fieldset>
                    <div class="st_header">
                        <div>
                            <h2><?php echo __('Konfiguracja generowania plików');?></h2>
                        </div>
                    </div>
                    <div class="st_fieldset-content">
                        <div class="form-row">
                            <?php echo label_for('config[stock]', __('Nie eksportuj produktów ze stanem magazynowym równym 0'), array('style' => 'width: 360px'));?>
                            <?php if($sf_request->hasErrors()):?>
                                <?php echo checkbox_tag('config[stock]', true, $sf_params->get('config[stock]'));?>
                            <?php else:?>
                                <?php echo checkbox_tag('config[stock]', true, $config->get('stock'));?>
                            <?php endif;?>
                            <br class="st_clear_all" />
                        </div>
                        <div class="form-row">
                            <?php echo label_for('config[category_root]', __('Nie dodawaj nazw drzew kategorii w plikach dla porównywarek cen'), array('style' => 'width: 360px'));?>
                            <?php if($sf_request->hasErrors()):?>
                                <?php echo checkbox_tag('config[category_root]', true, $sf_params->get('config[category_root]'));?>
                            <?php else:?>
                                <?php echo checkbox_tag('config[category_root]', true, $config->get('category_root'));?>
                            <?php endif;?>
                            <br class="st_clear_all" />
                        </div>
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
