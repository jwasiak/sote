<?php use_helper('I18N', 'stAdminGenerator', 'stJQueryTools', 'stPrice'); ?>
<?php echo st_get_admin_head('stCompatibilityPlugin', __('Konfiguracja'), array('culture' => $config -> getCulture()), array(0 => 'stWebpagePlugin')); ?>
    <div id="sf_admin_content">
        <?php st_include_partial('stAdminGenerator/message'); ?>
        <div id="sf_admin_content_config">
            <?php echo form_tag('stCompatibilityBackend/index?culture=' . $config -> getCulture(), array('id' => 'sf_admin_config_form', 'name' => 'sf_admin_config_form')); ?>
                                  
                
                  <fieldset>
                    <div class="st_header">
                        <div>
                            <h2><?php echo __('Cookie') ?></h2>
                        </div>
                    </div>
                    <div class="st_fieldset-content">
                        <div class="form-row">
                            <label for="config[cookies_info_on]"><?php echo __('Aktywny'); ?><a class="help" title="<?php echo __('Pokazuj w stopce sklepu - informację o cookies.') ?>" href="#"></a></label>
                            <?php echo checkbox_tag('config[cookies_info_on]', true, $config -> get('cookies_info_on')); ?>
                            
                            <br class="st_clear_all" />
                        </div>
                        <div class="form-row">
                            <?php echo label_for('config[cookies_info_color]', __('Kolor tekstu'), ''); ?>
                            <?php if($sf_request->hasErrors()):?>
                                <?php echo st_colorpicker_input_tag('config[cookies_info_color]', $sf_params->get('config[cookies_info_color]')) ?>
                            <?php else: ?>
                                
                                <?php echo st_colorpicker_input_tag('config[cookies_info_color]', $config->get('cookies_info_color')) ?>
                                
                            <?php endif; ?>
                            <br class="st_clear_all" />
                        </div>
                        <div class="form-row">
                            <?php echo label_for('config[cookies_info_background]', __('Kolor tła'), ''); ?>
                            <?php if($sf_request->hasErrors()):?>
                                <?php echo st_colorpicker_input_tag('config[cookies_info_background]', $sf_params->get('config[cookies_info_background]')) ?>
                            <?php else: ?>
                                <?php echo st_colorpicker_input_tag('config[cookies_info_background]', $config->get('cookies_info_background')) ?>
                            <?php endif; ?>
                            
                            <br class="st_clear_all" />
                        </div>
                        <div class="form-row">
                            <?php echo label_for('config[cookies_info_width]', __('Szerokość paska'), ''); ?>
                            <?php if($sf_request->hasErrors()):?>
                                <?php echo input_tag('config[cookies_info_width]', $sf_params -> get('config[cookies_info_width]')); ?>
                            <?php else: ?>
                                <?php echo input_tag('config[cookies_info_width]', $config -> get('cookies_info_width'), array("style" => "width:37px")); ?> px
                                <?php echo st_price_add_format_behavior('config_cookies_info_width', 0) ?>
                            <?php endif; ?>
                            <br class="st_clear_all" />
                        </div>
                        
                        <div class="form-row">
                            <?php echo label_for('config[description]', __('Tekst w pasku'), ''); ?>

                                <?php echo textarea_tag('config[description]', $config -> get('description', null, true), array('size' => '100x3')); ?>                                
                                <?php echo st_get_admin_culture_flag($config->getCulture()) ?>
                            <br class="st_clear_all" />
                        </div>
         
                    </div>
                </fieldset>
                
                <fieldset>
                    <div class="st_header">
                        <div>
                            <h2><?php echo __('Przetwarzanie danych osobowych') ?></h2>
                        </div>
                    </div>
                    <div class="st_fieldset-content">                        
                        
                        <div class="form-row">
                                <label for="config[terms_privacy_text]"><?php echo __('Tekst akceptacji'); ?><a class="help" title="<?php echo __('Pokazuj się w każdy miejscu gdzie zbierane są dane wrażliwe') ?>" href="#"></a></label>                                                        

                                <?php echo textarea_tag('config[terms_privacy_text]', $config -> get('terms_privacy_text', null, true), array('size' => '100x3')); ?>                                
                                <?php echo st_get_admin_culture_flag($config->getCulture()) ?>
                            <br class="st_clear_all" />
                        </div>
                    </div>
                    </fieldset>
                    
                    
                     <fieldset>
                    <div class="st_header">
                        <div>
                            <h2><?php echo __('Przetwarzanie danych osobowych - Newsletter') ?></h2>
                        </div>
                    </div>
                    <div class="st_fieldset-content">                        
                        
                        <div class="form-row">                            
                            <label for="config[terms_privacy_newsletter_text]"><?php echo __('Tekst akceptacji'); ?><a class="help" title="<?php echo __('Pokazuj się w module newslsettera') ?>" href="#"></a></label>

                                <?php echo textarea_tag('config[terms_privacy_newsletter_text]', $config -> get('terms_privacy_newsletter_text', null, true), array('size' => '100x3')); ?>                                
                                <?php echo st_get_admin_culture_flag($config->getCulture()) ?>
                            <br class="st_clear_all" />
                        </div>
                    </div>
                    </fieldset>
                    
                    <fieldset>
                    <div class="st_header">
                        <div>
                            <h2><?php echo __('Regulamin sklepu') ?></h2>
                        </div>
                    </div>
                    <div class="st_fieldset-content">                        
                        
                        <div class="form-row">                            
                            <label for="config[terms_shop_text]"><?php echo __('Tekst akceptacji'); ?><a class="help" title="<?php echo __('Pokazuj się na stronie koszyka') ?>" href="#"></a></label>

                                <?php echo textarea_tag('config[terms_shop_text]', $config -> get('terms_shop_text', null, true), array('size' => '100x3')); ?>                                
                                <?php echo st_get_admin_culture_flag($config->getCulture()) ?>
                            <br class="st_clear_all" />
                        </div>
                    </div>
                    </fieldset>
                    
                                    <fieldset>
                    <div class="st_header">
                        <div>
                            <h2><?php echo __('Prawo odstąpienia od umowy'); ?></h2>
                        </div>
                    </div>
                    <div class="st_fieldset-content">
                        <div class="form-row">
                            
                            <label for="config[terms_right_2_cancel]"><?php echo __('Aktywny'); ?><a class="help" title="<?php echo __('Pokazuj na stronie podsumowania zamówienia - prawo odstapienia od umowy.') ?>" href="#"></a></label>
                            
                                <?php echo checkbox_tag('config[terms_right_2_cancel]', true, $config -> get('terms_right_2_cancel'), array('style' => 'float:left')); ?>
                                <div style="margin-left: 5px;float:left;">
                                <?php echo link_to(__('Ustaw kraje'), 'stCompatibilityBackend/countries?section=terms_right_2_cancel_countrys'); ?>
                                </div>
                            
                            <br class="st_clear_all" />
                        </div>
                        <div class="form-row">
                            <?php echo label_for('config[terms_right_2_cancel_text]', __('Tekst odstąpienia od zamówienia'), ''); ?>

                                <?php echo textarea_tag('config[terms_right_2_cancel_text]', $config -> get('terms_right_2_cancel_text', null, true), array('size' => '100x3')); ?>                                
                                <?php echo st_get_admin_culture_flag($config->getCulture()) ?>
                            <br class="st_clear_all" />
                        </div>
                        
                    </div>
                </fieldset>
                
               
                <fieldset>
                    <div class="st_header">
                        <div>
                            <h2><?php echo __('Zbieranie opinii'); ?></h2>
                        </div>
                    </div>
                    <div class="st_fieldset-content">
                        <div class="form-row">
                            
                            <label for="config[basket_opinion_show]"><?php echo __('Aktywny'); ?><a class="help" title="<?php echo __('Pokazuj na stronie koszyka - infromacje o przetwarzaniu danych osobowych.') ?>" href="#"></a></label>
                            
                                <?php echo checkbox_tag('config[basket_opinion_show]', true, $config -> get('basket_opinion_show'), array('style' => 'float:left')); ?>
                                <div style="margin-left: 5px;float:left;">
                                <?php echo link_to(__('Ustaw kraje'), 'stCompatibilityBackend/countries?section=basket_opinion_show_countrys'); ?>
                                </div>
                            
                            <br class="st_clear_all" />
                        </div>
                        <div class="form-row">
                            <?php echo label_for('config[basket_opinion_text]', __('Tekst w koszyku'), ''); ?>

                                <?php echo textarea_tag('config[basket_opinion_text]', $config -> get('basket_opinion_text', null, true), array('size' => '100x3')); ?>                                
                                <?php echo st_get_admin_culture_flag($config->getCulture()) ?>
                            <br class="st_clear_all" />
                        </div>
                    </div>
                </fieldset>
                
                <fieldset>
                    <div class="st_header">
                        <div>
                            <h2><?php echo __('Treści cyfrowe'); ?></h2>
                        </div>
                    </div>
                    <div class="st_fieldset-content">
                        <div class="form-row">

                                <label for="config[terms_digital]"><?php echo __('Aktywny'); ?><a class="help" title="<?php echo __('Pokazuj na stronie podsumowania zamówienia - informację o treściach cyfrowych.') ?>" href="#"></a></label>
                            
                                <?php echo checkbox_tag('config[terms_digital]', true, $config -> get('terms_digital'), array('style' => 'float:left')); ?>
                                <div style="margin-left: 5px;float:left;">
                                <?php echo link_to(__('Ustaw kraje'), 'stCompatibilityBackend/countries?section=terms_digital_countrys'); ?>
                                </div>
                            
                            <br class="st_clear_all" />
                        </div>
                        <div class="form-row">
                            <?php echo label_for('config[terms_digital_show_online]', __('Pokazuj tylko dla zamówień z kodami, plikami online'), ''); ?>
                            <?php echo checkbox_tag('config[terms_digital_show_online]', true, $config -> get('terms_digital_show_online'), array('style' => 'float:left')); ?>
                            <br class="st_clear_all" />
                        </div>
                        <div class="form-row">
                            <?php echo label_for('config[terms_digital_text]', __('Tekst treści cyfrowych'), ''); ?>
                                <?php echo textarea_tag('config[terms_digital_text]', $config -> get('terms_digital_text', null, true), array('size' => '100x3')); ?>                                
                                <?php echo st_get_admin_culture_flag($config->getCulture()) ?>
                            <br class="st_clear_all" />
                        </div>
                           </div>
                </fieldset>
                
                <fieldset>
                    <div class="st_header">
                        <div>
                            <h2><?php echo __('Produkty usługowe'); ?></h2>
                        </div>
                    </div>
                    <div class="st_fieldset-content">
                        <div class="form-row">
                            
                            <label for="config[terms_service]"><?php echo __('Aktywny'); ?><a class="help" title="<?php echo __('Pokazuj na stronie podsumowania zamówienia - informację o produktach usługowych.') ?>" href="#"></a></label>
                            
                            <?php echo checkbox_tag('config[terms_service]', true, $config -> get('terms_service'), array('style' => 'float:left')); ?>
                            <div style="margin-left: 5px;float:left;">
                            <?php echo link_to(__('Ustaw kraje'), 'stCompatibilityBackend/countries?section=terms_service_countrys'); ?>
                            </div>
                            
                            <br class="st_clear_all" />
                        </div>
                        <div class="form-row">
                            <?php echo label_for('config[terms_service_products]', __('Pokazuj dla produktów oznaczonych jako usługa'), ''); ?>
                            <?php echo checkbox_tag('config[terms_service_products]', true, $config -> get('terms_service_products'), array('style' => 'float:left')); ?>
                            <br class="st_clear_all" />
                        </div>
                        <div class="form-row">
                            <?php echo label_for('config[terms_service_text]', __('Tekst produktów usługowych'), ''); ?>
                                <?php echo textarea_tag('config[terms_service_text]', $config -> get('terms_service_text', null, true), array('size' => '100x3')); ?>                                
                                <?php echo st_get_admin_culture_flag($config->getCulture()) ?>
                            <br class="st_clear_all" />
                        </div>
                           </div>
                </fieldset>
                
                <fieldset>
                    <div class="st_header">
                        <div>
                            <h2><?php echo __('Ceny brutto') ?></h2>
                        </div>
                    </div>
                    <div class="st_fieldset-content">
                        <div class="form-row">
                            
                            <label for="config[mode_de]"><?php echo __('Aktywny'); ?><a class="help" title="<?php echo __('Pokazuj na listach i karcie produktu - informacje o cenie brutto oraz kosztach wysyłki.') ?>" href="#"></a></label>
                            
                            <?php echo checkbox_tag('config[mode_de]', true, $config -> get('mode_de'), array('style' => 'float:left')); ?>
                            <div style="margin-left: 5px;float:left;">
                            <?php echo link_to(__('Ustaw kraje'), 'stCompatibilityBackend/countries?section=mode_de_countrys'); ?>
                            </div>
                            
                            <br class="st_clear_all" />
                        </div>
                        
                        <div class="form-row">
                            <?php echo label_for('config[star]', __('Tekst w stopce'), ''); ?>

                                <?php echo textarea_tag('config[star]', $config -> get('star', null, true), array('size' => '100x3')); ?>                                
                                <?php echo st_get_admin_culture_flag($config->getCulture()) ?>
                            <br class="st_clear_all" />
                        </div>
                    </div>
                </fieldset>
                
                <fieldset>
                    <div class="st_header">
                        <div>
                            <h2><?php echo __('Opłata dla kuriera'); ?></h2>
                        </div>
                    </div>
                    <div class="st_fieldset-content">
                        <div class="form-row">
                                
                                <label for="config[courier_fee]"><?php echo __('Aktywny'); ?><a class="help" title="<?php echo __('Pokazuj na stronie podsumowania zamówienia - dodatkową opłatę pobieraną przez kuriera.') ?>" href="#"></a></label>
                            
                                <?php echo checkbox_tag('config[courier_fee]', true, $config -> get('courier_fee'), array('style' => 'float:left')); ?>
                                <div style="margin-left: 5px;float:left;">
                                <?php echo link_to(__('Ustaw kraje'), 'stCompatibilityBackend/countries?section=courier_fee_countrys'); ?>
                                </div>
                            
                            <br class="st_clear_all" />
                        </div>
                           </div>
                </fieldset>
                
                <fieldset>
                    <div class="st_header">
                        <div>
                            <h2><?php echo __('E-mail z potwierdzeniem zamówienia'); ?></h2>
                        </div>
                    </div>
                    <div class="st_fieldset-content">
                        <div class="form-row">
                            <?php echo label_for('config[terms_in_mail_confirm_order]', __('Załącz regulamin'), ''); ?>
                            
                                <?php echo checkbox_tag('config[terms_in_mail_confirm_order]', true, $config -> get('terms_in_mail_confirm_order')); ?>
                                <span style="margin-left: 5px; vertical-align: middle">
                                <?php echo select_tag('config[terms_in_mail_confirm_order_format]', options_for_select(array('pdf' => __('W formacie PDF'), 'text' => __('W formacie tekstowym')), $config->get('terms_in_mail_confirm_order_format'))) ?>
                                </span>
                                <span style="margin-left: 5px; vertical-align: middle">
                                <?php echo link_to(__('Ustaw kraje'), 'stCompatibilityBackend/countries?section=terms_in_mail_confirm_order_countrys'); ?>
                                </span>
                            <br class="st_clear_all" />
                        </div>
                        <div class="form-row">
                            <?php echo label_for('config[right_2_cancel_in_mail_confirm_order]', __('Załącz odstąpienie od zamówienia'), ''); ?>
                            
                                <?php echo checkbox_tag('config[right_2_cancel_in_mail_confirm_order]', true, $config -> get('right_2_cancel_in_mail_confirm_order')); ?>
                                <span style="margin-left: 5px; vertical-align: middle">
                                <?php echo select_tag('config[right_2_cancel_in_mail_confirm_order_format]', options_for_select(array('pdf' => __('W formacie PDF'), 'text' => __('W formacie tekstowym')), $config->get('right_2_cancel_in_mail_confirm_order_format'))) ?>
                                </span>
                                <span style="margin-left: 5px; vertical-align: middle">
                                <?php echo link_to(__('Ustaw kraje'), 'stCompatibilityBackend/countries?section=right_2_cancel_in_mail_confirm_order_countrys'); ?>
                                </span>

                            <br class="st_clear_all" />
                        </div>
                    </div>
                </fieldset>
                
                
                <fieldset>
                    <div class="st_header">
                        <div>
                            <h2><?php echo __('Powiadomienie o zmianach w regulaminach') ?></h2>
                        </div>
                    </div>
                    <div class="st_fieldset-content">
                        <div class="form-row">
                            <label for="config[change_terms_on]"><?php echo __('Aktywny na 30 dni'); ?><a class="help" title="<?php echo __('Pokazuj w stopce sklepu - informację zamianach w regulaminach.') ?>" href="#"></a></label>
                            <?php echo checkbox_tag('config[change_terms_on]', true, $config -> get('change_terms_on')); ?>
                            
                            <br class="st_clear_all" />
                        </div>
                        <div class="form-row">
                            <?php echo label_for('config[change_terms_color]', __('Kolor tekstu'), ''); ?>
                            <?php if($sf_request->hasErrors()):?>
                                <?php echo st_colorpicker_input_tag('config[change_terms_color]', $sf_params->get('config[change_terms_color]')) ?>
                            <?php else: ?>
                                
                                <?php echo st_colorpicker_input_tag('config[change_terms_color]', $config->get('change_terms_color')) ?>
                                
                            <?php endif; ?>
                            <br class="st_clear_all" />
                        </div>
                        <div class="form-row">
                            <?php echo label_for('config[change_terms_background]', __('Kolor tła'), ''); ?>
                            <?php if($sf_request->hasErrors()):?>
                                <?php echo st_colorpicker_input_tag('config[change_terms_background]', $sf_params->get('config[change_terms_background]')) ?>
                            <?php else: ?>
                                <?php echo st_colorpicker_input_tag('config[change_terms_background]', $config->get('change_terms_background')) ?>
                            <?php endif; ?>
                            
                            <br class="st_clear_all" />
                        </div>
                        <div class="form-row">
                            <?php echo label_for('config[change_terms_width]', __('Szerokość paska'), ''); ?>
                            <?php if($sf_request->hasErrors()):?>
                                <?php echo input_tag('config[change_terms_width]', $sf_params -> get('config[change_terms_width]')); ?>
                            <?php else: ?>
                                <?php echo input_tag('config[change_terms_width]', $config -> get('change_terms_width'), array("style" => "width:37px")); ?> px
                                <?php echo st_price_add_format_behavior('config_change_terms_width', 0) ?>
                            <?php endif; ?>
                            <br class="st_clear_all" />
                        </div>
                        
                        <div class="form-row">
                            <?php echo label_for('config[change_terms_description]', __('Tekst wiadomości'), ''); ?>

                                <?php echo textarea_tag('config[change_terms_description]', $config -> get('change_terms_description', null, true), array('size' => '100x3')); ?>                                
                                <?php echo st_get_admin_culture_flag($config->getCulture()) ?>
                                <br/>
                                <?php 
                                $datetime1 = new DateTime($config -> get('change_terms_cookie_time'));
                                $datetime2 = new DateTime(date('Ymd'));
                                
                                $interval = $datetime2->diff($datetime1);                                
                                
                                if($config -> get('change_terms_on') == 1):
                                    if($config -> get('change_terms_cookie_time') >= date('Ymd')):
                                ?>
                                                                                                
                                    <div style="font-size: 11px; color:#ccc; margin-left: 250px;"><?php echo __('Komunikat zniknie za') ?> <?php echo $interval->format('%a'); ?> <?php echo __('dni') ?></div>
                                <?php else: ?>
                                    <div style="font-size: 11px; color:red; margin-left: 250px;"><?php echo __('Upłynął termin ważności komunikatu') ?></div>
                                <?php endif; ?>
                                
                                <?php endif; ?>
                                
                            <br class="st_clear_all" />
                        </div>
                        
                        <div class="form-row">
                            <input name="saveReset" value="<?php echo __('Zapisz i zresetuj') ?>" style="background-image: url(/images/backend/icons/save.png); padding-left: 27px; margin-left:250px;" onclick="return confirm('<?php echo __('Jesteś pewien?'); ?>');" type="submit">
                        </div>
         
                    </div>
                </fieldset>
                
                <fieldset>
                    <div class="st_header">
                        <div>
                            <h2><?php echo __('Ustawienia'); ?></h2>
                        </div>
                    </div>
                    <div class="st_fieldset-content">
                        <div class="form-row">
                                <?php echo label_for("", __('Zastosuj zmiany dla kraju Polska')); ?>
                            
                                
                                <input type="radio" name="config[save_for]" value="1" <?php if ($config -> get('save_for') == 1){ echo 'checked="checked"';} ?> />
                            
                                <br class="st_clear_all" />
                                    
                                <?php echo label_for("", __('Zastosuj zmiany dla całej Unii Europejskiej')); ?>
                            
                                <input type="radio" name="config[save_for]" value="2" <?php if ($config -> get('save_for') == 2){ echo 'checked="checked"';} ?> />
                            
                                <br class="st_clear_all" />
                                
                                <?php echo label_for("", __('Ustawienia indywidualne')); ?>
                                
                                <input type="radio" name="config[save_for]" value="3" <?php if ($config -> get('save_for') == 3){ echo 'checked="checked"';} ?> />
                        </div>
                    </div>
                    </fieldset>
                
                <?php echo st_get_admin_actions_head('style="margin-top: 10px; float: right"'); ?>
                    <?php echo st_get_admin_action('save', __('Zapisz', null, 'stAdminGeneratorPlugin'), null, array('name' => 'save')); ?>
                <?php echo st_get_admin_actions_foot(); ?>
            </form>
        </div>
    </div>
    <br class="st_clear_all" />
<?php echo st_get_admin_foot(); ?>