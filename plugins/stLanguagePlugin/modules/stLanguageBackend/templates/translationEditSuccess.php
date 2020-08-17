<?php use_helper('stAdminGenerator', 'Object');?>
<?php st_include_partial('stLanguageBackend/header', array('related_object' => $related_object, 'title' => __('Edycja definicji językowych'), 'route' => 'stLanguageBackend/translationEdit?id='.$translation_cache->getId().'&id='.$forward_parameters['id']));?>
<?php st_include_component('stLanguageBackend', 'editMenu', array('forward_parameters' => $forward_parameters, 'related_object' => $related_object));?>
  

<div id="sf_admin_content">
   <?php st_include_partial('stLanguageBackend/edit_messages', array('translation_cache' => $translation_cache, 'labels' => $labels, 'forward_parameters' => $forward_parameters)) ?>

<?php echo form_tag('stLanguageBackend/translationEdit?id='.$forward_parameters['id'], array(
  'id'        => 'admin_edit_form',
  'name'      => 'admin_edit_form',
  'class'     => 'admin_form',
  'multipart' => true,
)) ?>

    <?php echo input_hidden_tag('id', $forward_parameters['id']);?>
    <?php echo input_hidden_tag('index', $sf_request->getParameter('index'));?>

    <fieldset>
        <div class="content">
            <div class="row">
                <label>
                    <?php echo __('Fraza');?>
                </label>
                <div class="field">
                    <?php echo $phrase['phrase'];?>
                    <div class="clr"></div>
                </div>
            </div>
            <div class="row">
                <label>
                    <?php echo __('Tłumaczenie oryginalne');?>
                </label>
                <div class="field">
                    <?php echo $phrase['shop'];?>
                    <div class="clr"></div>
                </div>
            </div>
            <div class="row">
                <label>
                    <?php echo __('Tłumaczenie w sklepie');?>
                </label>
                <div class="field">
                    <?php echo object_textarea_tag($translation_cache, 'getValue', array('size' => '75x3', 'control_name' => 'translation_cache[value]'));?> 
                    <div class="clr"></div>
                </div>
            </div>
        </div>
    </fieldset>
    <div id="edit_actions">
        <?php st_include_partial('translation_edit_actions', array('translation_cache' => $translation_cache, 'forward_parameters' => $forward_parameters));?>
    </div>
</form>

<script type="text/javascript">
jQuery(function($) {
    $(document).ready(function() {
        $('#edit_actions').stickyBox();
    });

});
</script>

</div>

<?php st_include_partial('stLanguageBackend/footer', array('related_object' => $related_object, 'forward_parameters' => $forward_parameters)) ?>