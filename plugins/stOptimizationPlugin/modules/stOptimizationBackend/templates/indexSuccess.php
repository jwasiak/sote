<?php use_helper('stAdminGenerator');?>
<?php echo st_get_admin_head('stOptimizationPlugin', __('Zarządzanie optymalizacją sklepu'), null, array('stFastCacheSymfony'));?>
    <div id="sf_admin_content">
        <?php st_include_partial('stAdminGenerator/message');?>
        <div>
            <?php echo form_tag('optimization/index');?>
                <fieldset>
                    <div class="st_fieldset-content">
                        <div class="form-row">
                            <?php echo label_for('config[off]', __('Włącz optymalizacje sklepu').'<a href="#" class="help" title="'.__('Po wyłączeniu optymalizacji, wyświelane strony sklepu nie będą zapisywane do pamięci podręcznej.').'"></a>');?>
                            <?php echo checkbox_tag('config[off]', 1, !$config->get('off'));?>
                            <br class="st_clear_all" />
                        </div>
                    </div>
                </fieldset>
                <?php echo st_get_admin_actions_head('style="margin-top: 10px; float: right"');?>
                    <?php echo st_get_admin_action('reload', __('Wyczyść pamięć podręczną'), 'optimization/cleanCache');?>
                    <?php echo st_get_admin_action('save', __('Zapisz', null, 'stAdminGeneratorPlugin'), null, array('name' => 'save'));?>
                <?php echo st_get_admin_actions_foot();?>
            </form>
        </div>
    </div>
    <br class="st_clear_all" />
<?php echo st_get_admin_foot();?>
