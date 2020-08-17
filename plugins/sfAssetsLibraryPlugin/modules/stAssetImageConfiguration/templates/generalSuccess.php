<?php
use_helper('stAdminGenerator', 'stJQueryTools');
?>

<?php st_include_partial('stAssetImageConfiguration/header', array('title' => __('Konfiguracja ogólna'))); ?>
<?php echo st_get_component('stAdminGenerator', 'menu', array('items' => $menu_items)) ?>
<div id="sf_admin_content">
   
   <?php st_include_partial('stAssetImageConfiguration/message') ?>

   <form action="<?php echo st_url_for('stAssetImageConfiguration/general') ?>" method="post" id="sf_admin_config_form" class="admin_form">
      <fieldset>
         <div class="content">
            <?php echo st_admin_get_form_field('general[adapter]', __('Biblioteka:'), sfThumbnail::getSupportedAdapters(), 'select_tag', array('selected' => $config['adapter'], 'help' => __('Biblioteka używana do obróbki zdjęć. Domyślnie ustawiania jest ImageMagick jeżeli jest dostępna.'))); ?>
            <?php echo st_admin_get_form_field('general[high_quality_images]', __('Generuj obrazy wysokiej jakości:'), 1, 'checkbox_tag', array('checked' => isset($config['high_quality_images']) ? $config['high_quality_images'] : false, 'help' => __('Opcja pozwala generować lepszej jakości zdjęcia kosztem większego obciążenia serwera. W przypadku problemów z wydajnością proszę odznaczyć tą opcję'))); ?>
            <?php echo st_admin_get_form_field('general[respect_exif_orientation]', __('Obracaj zdjęcie zgodnie z inf. EXIF:'), 1, 'checkbox_tag', array('checked' => isset($config['respect_exif_orientation']) ? $config['respect_exif_orientation'] : false)); ?>
         </div>
      </fieldset>

      <?php echo st_get_admin_actions_head() ?>
      <?php echo st_get_admin_action('save', __('Zapisz', null, 'stAdminGeneratorPlugin'), null, array('name' => 'save')) ?>
      <?php echo st_get_admin_actions_foot() ?>
   </form>
</div>
<?php st_include_partial('stAssetImageConfiguration/footer'); ?>
