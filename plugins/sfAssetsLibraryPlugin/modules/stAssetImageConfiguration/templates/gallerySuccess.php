<?php if (!stTheme::hideOldConfiguration()): ?>
<?php
use_helper('stAdminGenerator', 'stJQueryTools');
?>

<?php st_include_partial('stAssetImageConfiguration/header', array('title' => __('Galeria'))); ?>

   <?php echo st_get_component('stAdminGenerator', 'menu', array('items' => $menu_items)) ?>
   <?php st_include_partial('stAssetImageConfiguration/message') ?>
   <?php echo form_tag('stAssetImageConfiguration/gallery', array('id' => 'sf_admin_config_form', 'class' => "admin_form", 'style' => "margin: 0 10px;")) ?>
   <fieldset>
   <div class="content">
      <div class="row">
        <label><?php echo __('Włącz zoom zdjęć') ?>:</label>
        <div class="field">
         <?php echo checkbox_tag('gallery[zoom_on]',true,$config['zoom_on']) ?>
         <br class="st_clear_all">
        </div>
      </div>
   </div>
   </fieldset>

   <?php echo st_get_admin_actions_head() ?>
   <?php echo st_get_admin_action('save', __('Zapisz', null, 'stAdminGeneratorPlugin'), null, array('name' => 'save')) ?>
   <?php echo st_get_admin_actions_foot() ?>
   </form>
   
<?php st_include_partial('stAssetImageConfiguration/footer'); ?>
<?php endif; ?>