<?php 
use_helper('stAdminGenerator', 'stJQueryTools'); 
      use_javascript('/jQueryTools/colorpicker/js/colorpicker.js');
      use_javascript('/jQueryTools/colorpicker/js/st_colorpicker.js');
      use_stylesheet('/jQueryTools/colorpicker/css/colorpicker.css');
      use_stylesheet('/jQueryTools/colorpicker/css/layout.css');
?>
    <?php echo form_tag('stProduct/optionsTemplatesSave', array(
      'id'        => 'sf_admin_edit_form',
      'name'      => 'sf_admin_edit_form',
      'multipart' => true,
    )) ?>


    <?php echo object_input_hidden_tag($product_options_template, 'getId') ?>
    <?php echo input_hidden_tag('culture',$sf_params->get('culture',stLanguage::getOptLanguage())) ?>

	
	<div class="save-ok" id="top_green" style="display: none;">
		<h2><?php echo __('Twoje zmiany zostały zapisane', null, 'stAdminGeneratorPlugin') ?></h2>
	</div>

    <fieldset id="sf_fieldset_szablon">
    <div class="st_fieldset-content" id="sf_fieldset_szablon_slide">
        <div class="form-row">
          <?php echo label_for('product_options_template[name]', __($labels['product_options_template{name}']), '') ?>
          <div class="content<?php if ($sf_request->hasError('product_options_template{name}')): ?> form-error<?php endif; ?>">
                <?php if ($sf_request->hasError('product_options_template{name}')): ?>
                    <?php echo form_error('product_options_template{name}', array('class' => 'form-error-msg', 'style' => 'text-align: left;')) ?>
                <?php endif; ?>
                <?php $value = object_input_tag($product_options_template, 'getName', array (
                'size' => 80,
                'control_name' => 'product_options_template[name]',
                )); echo $value ? $value : '&nbsp;' ?>
                <br class="st_clear_all" />
          </div>
        </div>
    </div>
    </fieldset>
    </form>
    
    <?php st_include_partial('options_templates_edit_actions', array('product_options_template' => $product_options_template)) ?>
    
    <?php if(!empty($sf_context->root)): ?>
    <div class="admin_form">
        <fieldset style="padding: 10px">
            <?php use_helper('stProductOptionsTree') ?>
            <?php use_stylesheet('backend/stProductOptionsTree.css?v6'); ?>
            <?php st_product_options_tree_include($sf_context->root, 'ProductOptionsDefaultValue', true, 'stProductOptionsTreeBackend', 'Ext.tree.stTreeNodeUI', array('root_name' => addslashes($product_options_template->getName()), 'templates'=>ProductOptionsTemplatePeer::getTemplateNames($sf_params->get('culture',stLanguage::getOptLanguage()))),true,true,true,'', $sf_params->get('culture',stLanguage::getOptLanguage())); ?>
            <?php st_include_component('stProductOptionsBackend', 'showOption', array('model' => 'stProductOptionsDefaultValue')) ?>
        </fieldset>
    </div>
    <?php endif; ?>

    <?php if (method_exists($product_options_template, 'getIsSystemDefault') == false || (method_exists($product_options_template, 'getIsSystemDefault') && !$product_options_template->getIsSystemDefault())): ?>
    <?php echo st_get_admin_actions_head('style="float: left"') ?>
      <?php echo st_get_admin_actions_head() ?>
    <?php endif; ?>
