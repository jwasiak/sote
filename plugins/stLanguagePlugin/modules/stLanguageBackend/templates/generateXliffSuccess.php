<?php use_helper('stAdminGenerator', 'stProgressBar');?>
<?php st_include_partial('stLanguageBackend/header', array('related_object' => $language, 'title' => __('Zastosuj zmiany w definicjach językowych'), 'route' => 'stLanguageBackend/translationList'));?>
<?php st_include_component('stLanguageBackend', 'editMenu', array('forward_parameters' => $forward_parameters, 'related_object' => $language));?>

<div id="sf_admin_content">
    <div id="sf_admin_content_config">
        <?php echo form_tag('stLanguageBackend/list', array('id'=>'sf_admin_config_form'));?>
            <fieldset id="sf_fieldset_none" class="">
                <div id="sf_fieldset_none_slide" class="st_fieldset-content">
                    <div class="form-row">
                        <?php echo progress_bar('stLanguageGenerateXliff_'.$language->getId(), 'stLanguageGenerateXliffProgressBar', 'step', stLanguageGenerateXliffProgressBar::getSteps($language));?>
                        <?php echo st_get_admin_actions_head('style="float: left; margin: 0px; visibility: hidden;" id="progressbar-button"');?>
                            <?php echo st_get_admin_action('save', __('Dalej'), 'stLanguageBackend/translationList?id='.$language->getId(), array('name' => 'save'));?>
                        <?php echo st_get_admin_actions_foot();?>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>
<br class="st_clear_all" /> 

<?php st_include_partial('stLanguageBackend/footer', array('related_object' => $language, 'forward_parameters' => $forward_parameters));?>
