<?php use_helper('I18N', 'Date', 'Text', 'stAdminGenerator') ?>
<?php use_stylesheet('backend/stProgressBarPlugin/stProgressBarPlugin.css'); ?> 

<?php st_include_partial('stProduct/header', array('related_object' => $related_object, 'title' => __('Import opisów w wersjach językowych', array(), 'stExtendImportExportBackend'), 'route' => 'stExtendImportExportBackend/import')) ?>

<?php st_include_component('stProduct', 'listMenu', array('forward_parameters' => $forward_parameters, 'related_object' => $related_object)) ?>


    <div id="sf_admin_content">
    <?php st_include_partial('stExtendImportExportBackend/import_messages', array( 'labels' => array('filename' => __('Plik z danymi', array(), 'stImportExportBackend'), 'importer' => __('Wybierz format importu', array(), 'stImportExportBackend') ))) ?>
        <?php if (!$import): ?>
            <?php echo form_tag('stExtendImportExportBackend/import',array('multipart'=>true,'id'=>'sf_admin_config_form')) ?>
                <fieldset id="sf_fieldset_none" class="">
                    <div id="sf_fieldset_none_slide" class="st_fieldset-content">
                        <div class="form-row">
                            <label for="product_import_format"><?php echo __("Wybierz format importu:", array(), 'stImportExportBackend') ?></label>
                            <div class="content">
                                <ul>
                                   <li><?php echo radiobutton_tag('importer','stImporterCsv', array( 'selected'=>true  )); ?> <?php echo __('Import pliku csv (UTF-8)', array(), 'stImportExportBackend') ?></li>
                                </ul>
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="product_import_format"><?php echo __("Plik z danymi:", array(), 'stImportExportBackend') ?></label>
                            <div class="content">
                                <?php echo input_file_tag('filename', 'filename') ?>
                            </div>
                        </div>
                        <?php if (count($importFiles)): ?>
                            <div class="form-row">
                                <label for="product_import_files"><?php echo __("Pliki na serwerze:", array(), 'stImportExportBackend') ?></label>
                                <div class="content">
                                    <ul>
                                    <?php foreach ($importFiles as $file): ?>
                                        <li>
                                            <?php echo radiobutton_tag('server_file',
                                            str_replace(sfConfig::get('sf_data_dir').DIRECTORY_SEPARATOR.'import'.DIRECTORY_SEPARATOR,'',$file),
                                            false);?>
                                            <?php echo str_replace(sfConfig::get('sf_data_dir').DIRECTORY_SEPARATOR.'import'.DIRECTORY_SEPARATOR,'',$file) ?>
                                        </li>                                                
                                    <?php endforeach; ?>
                                    </ul>                                                
                                </div>
                            </div>
                        <?php endif;?>
                    </div>
                </fieldset>
                <?php echo st_get_admin_actions_head('style="float: right"') ?>
                    <?php echo st_get_admin_action('save', __('Importuj', array(), 'stImportExportBackend'), null, array (  'name' => 'save',)) ?>
                <?php echo st_get_admin_actions_foot() ?>
            </form>
        <?php else: ?>
            <div id="sf_admin_content_config">
                <?php echo form_tag('stExtendImportExportBackend/import',array('multipart'=>true,'id'=>'sf_admin_config_form')) ?>
                    <fieldset id="sf_fieldset_none" class="">
                        <div id="sf_fieldset_none_slide" class="st_fieldset-content">
                            <div class="form-row">
                                <?php echo $pb->showProgressBar(0,true); ?>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        <?php endif; ?>                                                                                                            
    </div>

    <br class="st_clear_all" />

<?php st_include_partial('stProduct/footer', array('related_object' => $related_object)) ?>