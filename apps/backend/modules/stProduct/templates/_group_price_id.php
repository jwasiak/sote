<?php if ($sf_request->hasError('product{group_price_id}')): ?>
    <?php echo form_error('product{group_price_id}', array('class' => 'form-error-msg')) ?>
<?php endif; ?>

 <?php echo object_select_tag($product, 'getGroupPriceId', array (
  'related_class' => 'GroupPrice',
  'control_name' => 'product[group_price_id]',
  'include_custom' => __("---", null, 'stAdminGeneratorPlugin'),
  'include_blank' => false,
)); ?>
