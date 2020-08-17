<?php use_helper('I18N', 'stAdminGenerator') ?>
<?php echo st_get_admin_head('stLockPlugin', __('Włączanie lub wyłączanie sklepu', 
array()), __('', 
array()),array()) ?>   
    <div id="sf_admin_content">
        <div id="sf_admin_content_config">
            <?php echo form_tag('lock/index', array('multipart'=>'true', 'id' => 'sf_admin_config_form', 'name' => 'sf_admin_config_form')) ?>
                <?php st_include_partial('stAdminGenerator/message') ?>
                <fieldset>
                    <div class="st_header">
                        <div>
                            <h2><?php echo __('Ustawienia główne') ?></h2>
                        </div>
                    </div>

                    <div class="st_fieldset-content">
                        <div class="form-row">
                            <?php echo label_for('lock[unlock]', __('Wyłącz sklep'), '') ?>
                            <?php echo checkbox_tag('lock[unlock]', 1, !stLock::check('frontend')) ?>
                            <br class="st_clear_all" />
                        </div>
                        <div class="form-row">
                            <?php echo label_for('lock[title]', __('Tytuł strony'), '') ?>
                            <?php echo input_tag('lock[title]',$error_title, array('size'=>'50')) ?>
                            <br class="st_clear_all" />
                        </div>
                        <div class="form-row">
                            <?php echo label_for('lock[content]', __('Opis'), '') ?>
                            <?php echo textarea_tag('lock[content]',$error_content, array('size'=>'50x10')) ?>
                            <br class="st_clear_all" />
                        </div>
                        <div class="form-row">
                            <?php echo label_for('lock[image]', __('Obrazek'), '') ?>
                            <?php echo input_file_tag('lock[image]') ?><br />
                            <?php echo checkbox_tag('lock[default_image]',1,false, array("style" => "margin-left: 326px; margin-right: 8px;"))?> <?php echo __("Przywróć domyślny obrazek") ?>
                            <br class="st_clear_all" />
                        </div>
                    </div>
                </fieldset>
                
                <?php echo st_get_admin_actions_head('style="margin-top: 10px; float: right"') ?>
                    <?php echo st_get_admin_action('save', __('Zapisz', null, 'stAdminGeneratorPlugin'), null, array('name' => 'save')) ?>
                <?php echo st_get_admin_actions_foot() ?>
            </form>
        </div>    
    </div>
    <br class="st_clear_all" />
<?php echo st_get_admin_foot() ?>