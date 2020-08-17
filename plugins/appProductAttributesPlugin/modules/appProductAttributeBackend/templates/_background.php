
<?php if ($related_object->getType() == 'C'): ?>
<label for="app_product_attribute_variant_picture"><?php echo __('Obrazek') ?>:</label>
<div class="field">
   <?php if ($app_product_attribute_variant->isPictureType() && $app_product_attribute_variant->getPicturePath()): ?>
   <p><img src="<?php echo $app_product_attribute_variant->getPicturePath() ?>" alt="" style="max-height: 50px" /></p>
   <?php endif; ?>
   <?php echo input_file_tag('app_product_attribute_variant[picture]', array('disabled' => $app_product_attribute_variant->isColorType())); ?>
</div>
<?php endif ?>
