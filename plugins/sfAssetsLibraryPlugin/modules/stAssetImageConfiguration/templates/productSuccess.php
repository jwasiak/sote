<?php
use_helper('stAdminGenerator');
use_javascript('stPrice.js');
?>

<?php st_include_partial('stAssetImageConfiguration/header', array('title' => __('Produkty'))); ?>

   <?php echo st_get_component('stAdminGenerator', 'menu', array('items' => $menu_items)) ?>
   <?php st_include_partial('stAssetImageConfiguration/message') ?>
   <?php echo form_tag('stAssetImageConfiguration/product', array('id' => 'sf_admin_config_form', 'class' => "admin_form", 'style' => "margin: 0 10px;")) ?>
      <fieldset id="sf_fieldset-none">
         <div class="st_fieldset-content">
            <?php echo st_admin_get_form_field('product[small]', __('Lista pełna:'), $config['small'], '_image_config'); ?>
            <?php if (!stSoteshop::checkInstallVersion('6.6.4')): ?>
            <?php echo st_admin_get_form_field('product[icon]', __('Lista skrócona:'), $config['icon'], '_image_config'); ?>
            <?php echo st_admin_get_form_field('product[thumb]', __('Lista alternatywna:'), $config['thumb'], '_image_config'); ?>
           <?php endif;?>
            <?php echo st_admin_get_form_field('product[gallery]', __('Galeria:'), $config['gallery'], '_image_config'); ?>
            <?php echo st_admin_get_form_field('product[large]', __('Karta:'), $config['large'], '_image_config'); ?>
            <?php echo st_admin_get_form_field('product[big]', __('Powiększone:'), $config['big'], '_image_config'); ?>
            <?php echo st_admin_get_form_field('product[allegro]', __('Allegro:'), $config['allegro'], '_image_config'); ?>
         </div>
      </fieldset>
      <?php st_include_partial('stAssetImageConfiguration/actions', array('for' => 'product')) ?>
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