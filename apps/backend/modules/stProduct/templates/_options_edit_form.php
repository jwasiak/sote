<?php use_stylesheet('backend/stProductOptionsTree.css?v6'); ?>
<?php 
use_helper('stAdminGenerator', 'stJQueryTools'); 

      use_javascript('/jQueryTools/colorpicker/js/colorpicker.js');
      use_javascript('/jQueryTools/colorpicker/js/st_colorpicker.js');
      use_stylesheet('/jQueryTools/colorpicker/css/colorpicker.css');
      use_stylesheet('/jQueryTools/colorpicker/css/layout.css');
?>
<?php if_javascript(); ?>
<?php echo object_input_hidden_tag($product, 'getId') ?>

<div class="save-ok" id="top_green" style="display: none;">
<h2><?php echo __('Twoje zmiany zostały zapisane', null, 'stAdminGeneratorPlugin') ?></h2>
</div>

<div class="admin_form">
<fieldset style="padding: 10px">
<?php use_helper('stProductOptionsTree') ?>
<?php st_product_options_tree_include($sf_context->root, 'ProductOptionsValue', true, 'stProductOptionsTreeBackend', 'Ext.tree.stTreeNodeUI', array('root_name' => addslashes($product->getName()), 'templates'=>ProductOptionsTemplatePeer::getTemplateNames($sf_params->get('culture',stLanguage::getOptLanguage()))),true,true,true,'', $sf_params->get('culture',stLanguage::getOptLanguage())); ?>
<?php st_include_component('stProductOptionsBackend', 'showOption', array('model' => 'stProductOptionsValue')) ?>
</fieldset>

<?php st_include_partial('options_edit_actions', array('product' => $product)) ?>
<?php end_if_javascript(); ?>
<noscript>
<div class="java-error"><?php echo __('Twoja przeglądarka nie obsługuje Javascript.', null, 'stProductOptionsBackend') ?></div>
</noscript>

</div>
