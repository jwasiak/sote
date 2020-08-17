<?php
use_helper('stAdminGenerator', 'stJQueryTools');
?>

<?php st_include_partial('stAssetImageConfiguration/header', array('title' => __('Znak wodny'))); ?>

   <?php echo st_get_component('stAdminGenerator', 'menu', array('items' => $menu_items)) ?>
   <?php st_include_partial('stAssetImageConfiguration/message') ?>

<form action="<?php echo st_url_for('stAssetImageConfiguration/watermark') ?>" method="post" id="admin_config_form" class="admin_form float_left" style="margin: 0 10px;">
   <fieldset id="image_config">
      <div class="content">
         <?php echo st_admin_get_form_field('watermark[text]', __('Tekst:'), $config['text'], 'input_tag', array('maxlength' => 30, 'style' => 'width: 185px')); ?>
         <?php echo st_admin_get_form_field('watermark[font]', __('Czcionka:'), sfThumbnail::getWatermarkFonts(), 'select_tag', array('selected' => $config['font'])); ?>
         <?php echo st_admin_get_form_field('watermark[color]', __('Kolor:'), $config['color'], 'st_colorpicker_input_tag'); ?>
         <?php echo st_admin_get_form_field('watermark[size]', __('Maksymalny rozmiar:'), array('' => __('Brak'), 8 => 8, 12 => 12, 16 => 16, 24 => 24, 36 => 36), 'select_tag', array('selected' => $config['size'])); ?>
         <?php echo st_admin_get_form_field('watermark[position]', __('Pozycja:'), sfThumbnail::getWatermarkPosition(), 'select_tag', array('selected' => $config['position'])); ?>
         <?php echo st_admin_get_form_field('watermark[alpha]', __('Stopień przezroczystości:'), array(0 => __('Brak'), 32 => '25%', 64 => '50%', 96 => '75%'), 'select_tag', array('selected' => $config['alpha'])); ?>
      </div>
   </fieldset>
   <div id="image_preview">
   <?php echo image_tag('/stThumbnailPlugin.php?i=media/shares/no_image.png&w=512&h=512&wp='.$config['position'].'&wt='.urlencode($config['text']).'&wc='.$config['color'].'&wa='.$config['alpha'].'&ws='.$config['size'].'&wf='.$config['font'], array('id' => 'watermark-preview')) ?>
   </div>
   <div class="clr"></div>
   <?php echo st_get_admin_actions_head() ?>
   <?php echo st_get_admin_action('save', __('Zapisz', null, 'stAdminGeneratorPlugin'), null, array('name' => 'save')) ?>
   <?php echo st_get_admin_actions_foot() ?>
</form>
<div class="clr"></div>

<?php st_include_partial('stAssetImageConfiguration/footer'); ?>

<script type="text/javascript">
   function reloadImagePreview()
   {
      var params = $H($('admin_config_form').serialize(true));

      var image = new Image();
      
        var src = '/stThumbnailPlugin.php?i=media/shares/no_image.png&w=512&h=512&wp='+params.get('watermark[position]')+'&wt='+encodeURIComponent(params.get('watermark[text]'))+'&wc='+params.get('watermark[color]')+'&wa='+params.get('watermark[alpha]')+'&ws='+params.get('watermark[size]')+'&wf='+params.get('watermark[font]');

      image.onload = function()
      {
         $('watermark-preview').src = src;
      }

      image.src = src;
   }

   $('watermark_text').observe('change', reloadImagePreview);
 
   $('watermark_font').observe('change', reloadImagePreview);

   $('watermark_color').observe('change', reloadImagePreview);

   $('watermark_size').observe('change', reloadImagePreview);

   $('watermark_position').observe('change', reloadImagePreview);

   $('watermark_alpha').observe('change', reloadImagePreview);

   jQuery(function($) {
      $('#watermark_color').bind('onHide', reloadImagePreview);
   });
</script>
