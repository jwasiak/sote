
[?php use_helper('I18N', 'Date', 'Text', 'stAdminGenerator') ?]
[?php use_stylesheet('backend/stProgressBarPlugin/stProgressBarPlugin.css'); ?] 

[?php echo st_get_admin_head('<?php echo $this->getParameterValue('head.package', $this->getModuleName())?>', __('<?php echo $this->getParameterValue('import.title', $this->getValueFromKey('title', '')) ?>'), __('<?php echo $this->getParameterValue('import.description', $this->getValueFromKey('description', '')) ?>'), <?php var_export($this->getValueFromKey('applications')) ?>) ?]
<?php if ($menu = $this->getMenuComponentBy('import.menu.use')): ?>
    [?php st_include_component('<?php echo $this->getModuleName() ?>', '<?php echo $menu ?>', array('<?php echo strtolower(sfInflector::underscore($this->params['model_class'])) ?>' => <?php echo $this->getForwardParameterBy('import.build_options.related_id') ?>)) ?]
<?php else: ?>
    [?php st_include_component('<?php echo $this->getModuleName() ?>', 'importMenu', array()) ?]
<?php endif; ?>  
                    <div id="sf_admin_header">
                    </div>

                    
                    <div id="sf_admin_content">
                    [?php st_include_partial('<?php echo $this->getModuleName() ?>/import_messages', array( 'labels' => array('filename' => __('Plik z danymi', array(), 'stImportExportBackend'), 'importer' => __('Wybierz format importu', array(), 'stImportExportBackend') ))) ?]
                        [?php if (!$import): ?]
                                [?php echo form_tag('<?php echo $this->getModuleName() ?>/import',array('multipart'=>true,'id'=>'sf_admin_config_form')) ?]
                                    <fieldset id="sf_fieldset_none" class="">
                                        <div id="sf_fieldset_none_slide" class="st_fieldset-content">
                                            <div class="form-row">
                                                <label for="product_import_format">[?php echo __("Wybierz format importu:", array(), 'stImportExportBackend') ?]</label>
                                                <div class="content">
                                                <ul>
                                                    <?php foreach ($this->getParameterValue('importers') as $methodName => $method): ?>
                                                        <?php if ((is_array($this->getParameterValue('import.classes')) && array_search($methodName, $this->getParameterValue('import.classes'))!==false) || !is_array($this->getParameterValue('import.classes'))): ?>
                                                            <li>[?php echo radiobutton_tag('importer','<?php echo $methodName ?>', array( <?php if($this->getParameterValue('import.default')==$methodName) {echo "'selected'=>true";}  ?>  )); ?] [?php echo __('<?php echo $method ?>', array(), 'stImportExportBackend') ?]</li>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </ul>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <label for="product_import_format">[?php echo __("Plik z danymi:", array(), 'stImportExportBackend') ?]</label>
                                                <div class="content">
                                                [?php echo input_file_tag('filename', array('accept' => '.csv,.xml')) ?]
                                                </div>
                                            </div>
                                            [?php if (count($importFiles)): ?]
                                            <div class="form-row">
                                                <label for="product_import_files">[?php echo __("Pliki na serwerze:", array(), 'stImportExportBackend') ?]</label>
                                                <div class="content">
                                                <ul>
                                                [?php foreach ($importFiles as $file): ?]
                                                    <li>
                                                    [?php echo radiobutton_tag('server_file',
                                                                                str_replace(sfConfig::get('sf_data_dir').DIRECTORY_SEPARATOR.'import'.DIRECTORY_SEPARATOR,'',$file),
                                                                                false);?]
                                                    [?php echo str_replace(sfConfig::get('sf_data_dir').DIRECTORY_SEPARATOR.'import'.DIRECTORY_SEPARATOR,'',$file) ?]
                                                    </li>                                                
                                                [?php endforeach; ?]
                                                </ul>                                                
                                                </div>
                                            </div>
                                            [?php endif;?]
                                        </div>
                                    </fieldset>
                                    [?php echo st_get_admin_actions_head('style="float: right"') ?]
                                            [?php echo st_get_admin_action('save', __('Pobierz przykładowy plik', array(), 'stImportExportBackend'), null, array (  'name' => 'sample_file',)) ?]
                                            [?php echo st_get_admin_action('save', __('Importuj', array(), 'stImportExportBackend'), null, array (  'name' => 'save',)) ?]
                                    [?php echo st_get_admin_actions_foot() ?]
                                </form>
                        [?php else: ?]
                            <div id="sf_admin_content_config">
                                [?php echo form_tag('<?php echo $this->getModuleName() ?>/import',array('multipart'=>true,'id'=>'sf_admin_config_form')) ?]
                                    <fieldset id="sf_fieldset_none" class="">
                                        <div id="sf_fieldset_none_slide" class="st_fieldset-content">
                                            <div class="form-row">
                                                [?php echo $pb->showProgressBar(0,true); ?]
                                            </div>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                        [?php endif; ?]                                                                                                            
                    </div>
                    <br class="st_clear_all" />
                    
                    <div id="sf_admin_footer">
                    </div>
[?php echo st_get_admin_foot() ?]


    
