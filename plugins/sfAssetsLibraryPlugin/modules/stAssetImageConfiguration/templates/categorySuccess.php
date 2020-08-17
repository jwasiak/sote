<?php
use_helper('stAdminGenerator');
use_javascript('stPrice.js');
?>

<?php st_include_partial('stAssetImageConfiguration/header', array('title' => __('Kategorie'))); ?>

   <?php echo st_get_component('stAdminGenerator', 'menu', array('items' => $menu_items)) ?>
   <?php st_include_partial('stAssetImageConfiguration/message') ?>
   <?php echo form_tag('stAssetImageConfiguration/category', array('id' => 'sf_admin_config_form', 'class' => "admin_form", 'style' => "margin: 0 10px;")) ?>
      <fieldset id="sf_fieldset-none">
         <div class="st_fieldset-content">
            <?php echo st_admin_get_form_field('category[thumb]', __('Strona główna:'), $config['thumb'], '_image_config'); ?>
            <?php echo st_admin_get_form_field('category[small]', __('Strona kategorii:'), $config['small'], '_image_config'); ?>
         </div>
      </fieldset>
      <?php st_include_partial('stAssetImageConfiguration/actions', array('for' => 'category')) ?>
   </form>

<?php st_include_partial('stAssetImageConfiguration/footer'); ?>

<script type="text/javascript">
jQuery(function($) { 
   $('.st_record_list input.number').change(function() {  
      var input = $(this);    
      var value = stPrice.fixNumberFormat(input.val(), 0);

      if (!value) {
         value = input.prop('defaultValue');
      }

      input.val(value);
   });
});

</script>
