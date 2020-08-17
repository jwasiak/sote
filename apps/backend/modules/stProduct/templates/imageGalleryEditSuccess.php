<?php use_helper('stProduct') ?>

<div class="close"><a href="#"><img src="/images/backend/beta/gadgets/close.png" alt="<?php echo __('Zamknij', null, 'stBackend') ?>" /></a></div>
<h2><?php echo __('Edycja opisu zdjęcia') ?></h2>
<div class="content">
   <form class="admin_form" action="<?php echo st_url_for('stProduct/imageGalleryEdit?culture='.$asset->getCulture()) ?>?image_id=<?php echo $asset->getId() ?>">  
      <div class="row">
         <label><?php echo __('Zdjęcie') ?>:</label>
         <div class="field">
            <?php echo st_product_image_tag($asset, 'icon') ?>
         </div>
      </div>
      <div class="row">
         <label><?php echo __('Opis') ?>:</label>
         <div class="field">
            <?php echo textarea_tag('plupload_edit[description]', $asset->getDescription(), array('style' => 'width: 100%; height: 150px')) ?>
         </div>
      </div>
      <div class="row">
         <ul class="admin_actions">
            <li class="action-save"><input type="submit" value="<?php echo __('Zapisz', null, 'stBackend') ?>" /></li>
         </ul>  
         <div class="clr"></div>   
      </div>
   </form>
</div>


<script type="text/javascript">
jQuery(function($) {
   $('#plupload_edit_overlay form').submit(function() {
      var overlay = $('#plupload_edit_overlay');

      overlay.addClass('preloader_160x24');

      $.post(this.action, $(this).serializeArray(), function() {
         overlay.removeClass('preloader_160x24');
         overlay.data('overlay').close();
      });

      return false;
   });
});
</script>