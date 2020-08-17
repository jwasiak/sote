<?php if ($related_object->getType() == 'C'): ?>
<label for="app_product_attribute_variant_name" class="required"><?php echo __('Nazwa') ?>:</label>
<div class="field">
   <?php echo input_tag('app_product_attribute_variant[name]', $app_product_attribute_variant->getName()) ?>
</div>
<?php endif ?>