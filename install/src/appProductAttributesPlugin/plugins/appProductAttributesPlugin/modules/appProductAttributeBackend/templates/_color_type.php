
<?php if ($related_object->getType() == 'C'): ?>
<label for="app_product_attribute_variant_type"><?php echo __('Rodzaj') ?>:</label>
<div class="field">
   <?php echo select_tag('app_product_attribute_variant[color_type]', options_for_select(appProductAttributeVariant::getTypes(), $app_product_attribute_variant->getType() ? $app_product_attribute_variant->getType() : $related_object->getType())) ?>
</div>
<script type="text/javascript">
//<![CDATA[
jQuery(function($) {
   $('#app_product_attribute_variant_color_type').change(function() {
      var option = this.options[this.selectedIndex];
      var color = $('#app_product_attribute_variant_color');
      var picture = $('#app_product_attribute_variant_picture');
      if (option.value == 'C') {
         color.removeAttr('disabled');
         if (!color.val()) {
            color.val('ffffff');
         }
         picture.attr('disabled', true);   
      } else { 
         color.attr('disabled', true);
         picture.removeAttr('disabled');              
      }
   });
});
//]]>   
</script>
<?php endif ?>
