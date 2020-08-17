
[?php use_helper('I18N', 'Date', 'Text', 'stAdminGenerator') ?]
[?php use_stylesheet('backend/stProgressBarPlugin/stProgressBarPlugin.css'); ?] 

[?php echo st_get_admin_head('<?php echo $this->getParameterValue('head.package', $this->getModuleName())?>', __('<?php echo $this->getParameterValue('export.title', $this->getValueFromKey('title', '')) ?>'), __('<?php echo $this->getParameterValue('export.description', $this->getValueFromKey('description', '')) ?>'), <?php var_export($this->getValueFromKey('applications')) ?>) ?]
<?php if ($menu = $this->getMenuComponentBy('export.menu.use')): ?>
    [?php st_include_component('<?php echo $this->getModuleName() ?>', '<?php echo $menu ?>', array('forward_parameters' => $forward_parameters, '<?php echo strtolower(sfInflector::underscore($this->params['model_class'])) ?>' => <?php echo $this->getForwardParameterBy('export.build_options.related_id') ?>)) ?]
<?php else: ?>
    [?php st_include_component('<?php echo $this->getModuleName() ?>', 'exportMenu', array('forward_parameters' => $forward_parameters)) ?]
<?php endif; ?>  
                    <div id="sf_admin_header">

                    </div>

                    
                    <div id="sf_admin_content">
                    [?php if (!$export): ?]
                            [?php echo form_tag('<?php echo $this->getModuleName() ?>/export', array('id'=>'sf_admin_config_form')) ?]
                            <fieldset id="sf_fieldset_none" class="">
                                <div id="sf_fieldset_none_slide" class="st_fieldset-content">
                                    <div class="form-row">
                                            <label for="config_new_product_date">[?php echo __("Wybierz format exportu", array(), 'stImportExportBackend') ?]</label>
                                            <div class="content">
	                                            <ul>
	                                                <?php foreach ($this->getParameterValue('exporters') as $methodName => $method): ?>
	                                                    <?php if ((is_array($this->getParameterValue('export.classes')) && array_search($methodName, $this->getParameterValue('export.classes'))!==false) || !is_array($this->getParameterValue('export.classes'))): ?>
	                                                        <li>[?php echo radiobutton_tag('exporter','<?php echo $methodName ?>', array( <?php if($this->getParameterValue('export.default')==$methodName) {echo "'selected'=>true";}  ?>  )) ?] [?php echo __('<?php echo $method ?>', array(), 'stImportExportBackend'); ?]</li>
	                                                    <?php endif; ?>
	                                                <?php endforeach; ?>
	                                            </ul>
                                            </div>
                                    </div>
                                    <div class="form-row">
                                        <label for="config_new_product_date">[?php echo __("Wybierz Profil", array(), 'stImportExportBackend') ?]</label>
                                        <div class="content">[?php echo select_tag('profile',options_for_select($profiles)) ?]
                                            [?php echo link_to(__('Zarządzaj profilami', array(), 'stImportExportBackend'), 'stImportExportBackend/list?model=<?php echo $this->getClassName() ?>&for_module=<?php echo $this->getModuleName() ?>'); ?]
                                        </div>
                                    </div>
                                </div>                                                                                                            
                            </fieldset>
                            [?php echo st_get_admin_actions_head('style="float: right"') ?]
                                    [?php echo st_get_admin_action('save', __('Pobierz przykładowy plik', array(), 'stImportExportBackend'), null, array (  'name' => 'sample_file',)) ?]
                                    [?php echo st_get_admin_action('save', __('Eksportuj', array(), 'stImportExportBackend'), null, array (  'name' => 'save',)) ?]
                            [?php echo st_get_admin_actions_foot() ?]
                            </form>
                    [?php else: ?]
                        <div id="sf_admin_content_config">
                            [?php echo form_tag('<?php echo $this->getModuleName() ?>/export', array('id'=>'sf_admin_config_form')) ?]
                                <fieldset id="sf_fieldset_none" class="">
                                    <div id="sf_fieldset_none_slide" class="st_fieldset-content">
                                        <div class="form-row">
                                            [?php echo $pb->showProgressBar($actual_step,true); ?]
                                            [?php if ($errors):?]
                                                [?php echo link_to_remote(__('Wyświetl błędy eksportu', array(), 'stImportExportBackend'), array('update'=>'export_log', 'url'=>'stProduct/exportLog?file='.$logFile))?].
                                            [?php endif; ?]
                                            <div id="export_log"></div>
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


    
