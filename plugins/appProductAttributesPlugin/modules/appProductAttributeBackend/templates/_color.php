<?php if ($related_object->getType() == 'C'): ?>
<?php 
$color = $app_product_attribute_variant->isPictureType() ? '' : $app_product_attribute_variant->getColor();

if (null === $color)
{
   $color = 'ffffff';
}
?>
<?php use_helper('stJQueryTools') ?>
<label for="app_product_attribute_variant_color"><?php echo __('Kolor') ?>:</label>
<div class="field">
   <?php echo st_colorpicker_input_tag('app_product_attribute_variant[color]', $color, array('disabled' => $app_product_attribute_variant->isPictureType())) ?>
</div>
<?php endif ?>