<?php use_helper('I18N', 'stAdminGenerator', 'Validation') ?>
<?php echo st_get_admin_head('stNavigationPlugin', __('Konfiguracja'), array('culture' => $config->getCulture()), array()) ?>   
    <div id="sf_admin_content">
        <?php st_include_partial('stAdminGenerator/message', array('labels' => $labels));?>
        <div id="sf_admin_content_config">
            <?php echo form_tag('navigation/index?culture='.$config->getCulture(), array('id' => 'sf_admin_config_form', 'name' => 'sf_admin_config_form')) ?>
                <fieldset>
                    <div class="st_header">
                        <div>
                            <h2><?php echo __('Ustawienia paska nawigacji') ?></h2>
                        </div>
                    </div>
                    <div class="st_fieldset-content">
                        <div class="form-row">
                            <?php echo label_for('navigation[bar]', __('Włącz pasek nawigacji'), '') ?>
                            <?php if($sf_request->hasErrors()): ?>
                                <?php echo checkbox_tag('navigation[bar]', 1, $sf_params->get('navigation[bar]')) ?>
                            <?php else: ?>
                                <?php echo checkbox_tag('navigation[bar]', 1, $config->get('bar')) ?>
                            <?php endif; ?>
                            <br class="st_clear_all" />
                        </div>

<?php if (!stTheme::hideOldConfiguration()): ?>

                        <div class="form-row">
                            <?php echo label_for('navigation[view_type]', __('Tryb wyświetlania'), '') ?>
                            <?php if($sf_request->hasErrors()): ?>
                                <?php echo select_tag('navigation[view_type]', options_for_select(array(__('graficzny'), __('tekstowy')), $sf_params->get('navigation[view_type]'))) ?>
                            <?php else: ?>
                                <?php echo select_tag('navigation[view_type]', options_for_select(array(__('graficzny'), __('tekstowy')), $config->get('view_type'))) ?>
                            <?php endif; ?>
                            <br class="st_clear_all" />
                        </div>
                    </div>
                </fieldset>                       
                <fieldset>
                    <div class="st_header">
                        <div>
                            <h2><?php echo __('Ustawienia lokalizacji') ?></h2>
                        </div>
                    </div>
                    <div class="st_fieldset-content">
                        <div class="form-row">
                            <?php echo label_for('navigation[navigation]', __('Wyświetlaj lokalizację w pasku nawigacji'), '') ?>
                            <?php if($sf_request->hasErrors()): ?>
                                <?php echo checkbox_tag('navigation[navigation]', 1, $sf_params->get('navigation[navigation]')) ?>
                            <?php else: ?>
                                <?php echo checkbox_tag('navigation[navigation]', 1, $config->get('navigation')) ?>
                            <?php endif; ?>
                            <br class="st_clear_all" />
                        </div>
                        <div class="form-row">
                            <?php echo label_for('navigation[decrease]', __('Obcinaj nazwy produktów i kategorii'), '') ?>
                            <?php if($sf_request->hasErrors()): ?>
                                <?php echo checkbox_tag('navigation[decrease]', 1, $sf_params->get('navigation[decrease]')) ?>
                            <?php else: ?>
                                <?php echo checkbox_tag('navigation[decrease]', 1, $config->get('decrease')) ?>
                            <?php endif; ?>
                            <br class="st_clear_all" />
                        </div>
                        
                        <div class="form-row">
                            <?php echo label_for('navigation[decrease_last]', __('Obcinaj nazwę ostatniego elementu').'&nbsp;<a href="#" class="help" title="<b>'.__('Uwaga:').'</b>&nbsp;'.__('Opcja działa dopiero po włączeniu opcji "Obcinaj nazwy produktów i kategorii".').'"></a>', '') ?>
                            <?php if($sf_request->hasErrors()): ?>
                                <?php echo checkbox_tag('navigation[decrease_last]', 1, $sf_params->get('navigation[decrease_last]')) ?>
                            <?php else: ?>
                                <?php echo checkbox_tag('navigation[decrease_last]', 1, $config->get('decrease_last')) ?>
                            <?php endif; ?>
                            <br class="st_clear_all" />
                        </div>
                        <div class="form-row<?php if($sf_request->hasError('navigation{decrease_length}')): ?> form-error<?php endif; ?>">
                            <?php echo label_for('navigation[decrease_length]', __('Ilość znaków po obcięciu'), '') ?>
                            <?php if($sf_request->hasErrors()): ?>
                                <?php echo input_tag('navigation[decrease_length]', $sf_params->get('navigation[decrease_length]'), array("size" => 2)) ?>
                            <?php else: ?>
                                <?php echo input_tag('navigation[decrease_length]', $config->get('decrease_length'), array("size" => 2)) ?>
                            <?php endif; ?>
                            <br class="st_clear_all" />
                        </div>
                        <div class="form-row<?php if($sf_request->hasError('navigation{navigation_start_name}')): ?> form-error<?php endif; ?>">
                            <?php echo label_for('navigation[navigation_start_name]', __('Nazwa pierwszego elementu'), array('class' => 'required')) ?>
                            <?php if($sf_request->hasErrors()): ?>
                                <?php echo input_tag('navigation[navigation_start_name]', $sf_params->get('navigation[navigation_start_name]'), array("size" => 20)) ?>
                            <?php else: ?>
                                <?php echo input_tag('navigation[navigation_start_name]', $config->get('navigation_start_name', null, true), array("size" => 20)) ?>
                            <?php endif; ?>
                            <br class="st_clear_all" />
                        </div>
                    </div>
                </fieldset>
                <fieldset>
                    <div class="st_header">
                        <div>
                            <h2><?php echo __('Ustawienia historii') ?></h2>
                        </div>
                    </div>
                    <div class="st_fieldset-content">
                        <div class="form-row">
                            <?php echo label_for('navigation[historyOn]', __('Włącz moduł historii'), '') ?>
                            <?php if($sf_request->hasErrors()): ?>
                                <?php echo checkbox_tag('navigation[historyOn]', 1, $sf_params->get('navigation[historyOn]')) ?>
                            <?php else: ?>
                                <?php echo checkbox_tag('navigation[historyOn]', 1, $config->get('historyOn')) ?>
                            <?php endif; ?>
                            <br class="st_clear_all" />
                        </div>
                        <div class="form-row<?php if($sf_request->hasError('navigation{history_products}')): ?> form-error<?php endif; ?>">
                            <?php echo label_for('navigation[history_products]', __('Ilość ostatnio oglądanych produktów'), '') ?>
                            <?php if($sf_request->hasErrors()): ?>
                                <?php echo input_tag('navigation[history_products]', $sf_params->get('navigation[history_products]'), array("size" => 2)) ?>
                            <?php else: ?>
                                <?php echo input_tag('navigation[history_products]', $config->get('history_products'), array("size" => 2)) ?>
                            <?php endif; ?>
                            <br class="st_clear_all" />
                        </div>
                        <div class="form-row">
                            <?php echo label_for('navigation[history]', __('Wyświetlaj historię w pasku nawigacji'), '') ?>
                            <?php if($sf_request->hasErrors()): ?>
                                <?php echo checkbox_tag('navigation[history]', 1, $sf_params->get('navigation[history]')) ?>
                            <?php else: ?>
                                <?php echo checkbox_tag('navigation[history]', 1, $config->get('history')) ?>
                            <?php endif; ?>
                            <br class="st_clear_all" />
                        </div>
                        <div class="form-row">
                            <?php echo label_for('navigation[history_link]', __('Wyświetlaj link do historii w pasku nawigacji'), '') ?>
                            <?php if($sf_request->hasErrors()): ?>
                                <?php echo checkbox_tag('navigation[history_link]', 1, $sf_params->get('navigation[history_link]')) ?>
                            <?php else: ?>
                                <?php echo checkbox_tag('navigation[history_link]', 1, $config->get('history_link')) ?>
                            <?php endif; ?>
                            <br class="st_clear_all" />
                        </div>
                        <div class="form-row">
                            <?php echo label_for('navigation[history_box]', __('Wyświetlaj boks "Ostatnio oglądane"'), '') ?>
                            <?php if($sf_request->hasErrors()): ?>
                                <?php echo checkbox_tag('navigation[history_box]', 1, $sf_params->get('navigation[history_box]')) ?>
                            <?php else: ?>
                                <?php echo checkbox_tag('navigation[history_box]', 1, $config->get('history_box')) ?>
                            <?php endif; ?>
                            <br class="st_clear_all" />
                        </div>
                        <div class="form-row<?php if($sf_request->hasError('navigation{history_box_limit}')): ?> form-error<?php endif; ?>">
                            <?php echo label_for('navigation[history_box_limit]', __('Ilość wyświetlanych produktów w boksie'), '') ?>
                            <?php if($sf_request->hasErrors()): ?>
                                <?php echo input_tag('navigation[history_box_limit]', $sf_params->get('navigation[history_box_limit]'), array("size" => 2)) ?>
                            <?php else: ?>
                                <?php echo input_tag('navigation[history_box_limit]', $config->get('history_box_limit'), array("size" => 2)) ?>
                            <?php endif; ?>
                            <br class="st_clear_all" />
                        </div>
                        
<?php endif; ?>
                    </div>
                </fieldset>
                <?php echo st_get_admin_actions_head('style="margin-top: 10px; float: right"') ?>
                    <?php echo st_get_admin_action('save', __('Zapisz', array(), 'stAdminGeneratorPlugin'), null, array('name' => 'save')) ?>
                <?php echo st_get_admin_actions_foot() ?>
            </form>
        </div>
    </div>
    <br class="st_clear_all" />
<?php echo st_get_admin_foot() ?>