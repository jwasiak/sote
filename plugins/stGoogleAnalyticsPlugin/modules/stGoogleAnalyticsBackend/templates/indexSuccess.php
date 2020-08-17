<?php use_helper('Object', 'Validation', 'ObjectAdmin', 'I18N', 'VisualEffect', 'stAdminGenerator', 'stDate') ?>
<?php use_stylesheet('backend/stGoogleAnalyticsPlugin.css'); ?>
<?php echo st_get_admin_head('stGoogleAnalyticsPlugin', __('Statystyki'), __(''), array()) ?>
    <?php echo form_tag('stGoogleAnalyticsBackend/index', array()) ?>    
        
    <?php st_include_partial('stAdminGenerator/message', array('labels' => $labels));?>
    
    
    
        <fieldset id="sf_fieldset_none" class="" style="margin: 0 10px;">
        <div class="content" id="sf_fieldset_none_slide" style="padding: 10px">

            <?php if (($sf_request->hasError('google_analytics{analytics_part2}')) || ($sf_request->hasError('google_analytics{analytics_part3}'))): ?>
        <div class="google_show_error"><?php echo form_error('google_analytics{analytics_part2}', array('class' => 'form-error-msg')) ?></div>
        <div class="google_show_error"><?php echo form_error('google_analytics{analytics_part3}', array('class' => 'form-error-msg')) ?></div>
    <?php endif; ?>

        <div id="st_google" style="padding-bottom: 10px">
            <div class="st_row">
                <div class="st_label2">
                    <?php echo label_for('st_form-google-field',__('Numer w kodzie otrzymanym od Google')) ?>:
                </div>
                <div class="st_field">
                    <?php echo st_get_admin_horizontal_look_head('id=st_admin_generator-list') ?>
                        <b><?php echo __('UA') ?></b>
                        <?php if ($sf_request->hasError('google_analytics{analytics_part2}')):?>
                            -<?php echo input_tag('google_analytics[analytics_part2]',$config->get('analytics_part2'), array('style'=>'border: 1px solid red; width: 80px;')) ?>                
                        <?php else:?>
                            -<?php echo input_tag('google_analytics[analytics_part2]',$config->get('analytics_part2'), array('style'=>'width: 80px;')) ?>           
                        <?php endif;?>
                          
                        
                        <?php if ($sf_request->hasError('google_analytics{analytics_part3}')):?>
                            -<?php echo input_tag('google_analytics[analytics_part3]',$config->get('analytics_part3'),array('style'=>'border: 1px solid red; width: 30px;')) ?>
                        <?php else:?>
                            -<?php echo input_tag('google_analytics[analytics_part3]',$config->get('analytics_part3'),array('style'=>'width: 30px;')) ?>
                        <?php endif;?>
                    <?php echo st_get_admin_horizontal_look_foot() ?>
                </div>


                <br class="st_clear_all">
            </div>
            
            <div class="st_row">
                <div class="st_label2"> 
                        <?php echo label_for('st_form-google-field',__('Włącz Google Analytics w sklepie')) ?>:
                </div>
                <div class="st_field">
                    <div id="st_form-google-field-input">
                        <?php echo checkbox_tag('google_analytics[analytics]',true,$config->get('analytics')) ?>
                    </div>
                </div>
                <br class="st_clear_all">
            </div>
            
            <div class="st_row">
                <div class="st_label2"> 
                    <?php echo label_for('st_form-google-field',__('Włącz e-commerce w sklepie')) ?>:
                </div>
                <div class="st_field">
                    <div id="st_form-google-field-input">
                        <?php echo checkbox_tag('google_analytics[ecommerce]',true,$config->get('ecommerce')) ?>
                    </div>
                </div>
                <br class="st_clear_all">
            </div>
            
        </div>
        </div>
    </fieldset>
        <?php echo st_get_admin_actions_head('style="margin-right: 10px;"') ?>
            <?php echo st_get_admin_action('save', __('Zapisz', array(), 'stAdminGeneratorPlugin'), null, 'name=save') ?>
        <?php echo st_get_admin_actions_foot() ?>
    </form>
<?php echo st_get_admin_foot() ?>