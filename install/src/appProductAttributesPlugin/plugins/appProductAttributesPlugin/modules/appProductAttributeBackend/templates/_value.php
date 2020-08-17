<?php if ($related_object->getType() == 'T' || $related_object->getType() == 'S'): ?>
<style type="text/css">
	.row_color_type, .row_name, .row_background, .row_color {
		display: none;
	}
</style>
<label for="app_product_attribute_variant_value" class="required"><?php echo __('Wartość') ?>:</label>
<div class="field<?php if ($sf_request->hasError('app_product_attribute_variant{_value}')): ?> form-error<?php endif; ?>">
	<?php if ($sf_request->hasError('app_product_attribute_variant{_value}')): ?>
	    <?php echo form_error('app_product_attribute_variant{_value}', array('class' => 'form-error-msg')) ?>
	<?php endif; ?>
   <?php echo input_tag('app_product_attribute_variant[value]', $app_product_attribute_variant->getValue()) ?>
</div>
<?php else: ?>
	<style type="text/css">
	.row_value {
		display: none;
	}
</style>
<?php endif ?>