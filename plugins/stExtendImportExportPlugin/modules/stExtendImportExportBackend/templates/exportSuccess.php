<?php use_helper('I18N', 'Date', 'Text', 'stAdminGenerator') ?>
<?php use_stylesheet('backend/stProgressBarPlugin/stProgressBarPlugin.css'); ?> 

<?php st_include_partial('stProduct/header', array('related_object' => $related_object, 'title' => __('Eksport opisów w wersjach językowych', array(), 'stExtendImportExportBackend'), 'route' => 'stExtendImportExportBackend/export')) ?>

<?php st_include_component('stProduct', 'listMenu', array('forward_parameters' => $forward_parameters, 'related_object' => $related_object)) ?>

    <div id="sf_admin_content">
        <?php if (!$export): ?>
            <?php echo form_tag('stExtendImportExportBackend/export', array('id'=>'sf_admin_config_form')) ?>
                <fieldset id="sf_fieldset_none" class="">
                    <div id="sf_fieldset_none_slide" class="st_fieldset-content">
                        <div class="form-row">
                            <label for="config_new_product_date"><?php echo __("Wybierz format exportu:", array(), 'stImportExportBackend') ?></label>
                            <div class="content">
                                <ul>
                                    <li><?php echo radiobutton_tag('exporter','stExporterCsv', array( 'selected'=>true  )) ?> <?php echo __('Export do pliku csv (UTF-8)', array(), 'stImportExportBackend'); ?></li>
                                </ul>
                            </div>  
                        </div>
                    </div>                                                                                                            
                </fieldset>
                <?php echo st_get_admin_actions_head('style="float: right"') ?>
                    <?php echo st_get_admin_action('save', __('Eksportuj', array(), 'stImportExportBackend'), null, array (  'name' => 'save',)) ?>
                <?php echo st_get_admin_actions_foot() ?>
            </form>
        <?php else: ?>
            <div id="sf_admin_content_config">
                <?php echo form_tag('stExtendImportExportBackend/export', array('id'=>'sf_admin_config_form')) ?>
                    <fieldset id="sf_fieldset_none" class="">
                        <div id="sf_fieldset_none_slide" class="st_fieldset-content">
                            <div class="form-row">
                                <?php echo $pb->showProgressBar($actual_step,true); ?>
                                <?php if ($errors):?>
                                    <?php echo link_to_remote(__('Wyświetl błędy eksportu', array(), 'stImportExportBackend'), array('update'=>'export_log', 'url'=>'stProduct/exportLog?file='.$logFile))?>.
                                <?php endif; ?>
                                <div id="export_log"></div>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        <?php endif; ?>
    </div>

    <br class="st_clear_all" />

    <div id="sf_admin_footer"></div>

<?php st_include_partial('stProduct/footer', array('related_object' => $related_object)) ?>