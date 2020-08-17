<?php
use_helper('stAsset');
use_javascript('/sfAssetsLibraryPlugin/js/helper.js');
?>
<?php echo input_file_tag('product_has_attachment[attachment_edit_file]') ?>
<?php if ($product_has_attachment->getSfAssetId()): $pha = $product_has_attachment; $path = '/product/attachment/'.$pha->getProduct()->getAssetFolder().'/'.$pha->getAssetCulture().'/'.$pha->getFilename() ?>
   <p style="padding-top: 10px"><?php echo content_tag('a', $path, array('href' => $path)) ?></p>
<?php endif; ?>

<script type="text/javascript">
jQuery(function($) {
   $(document).ready(function() {
      var filename = $('#product_has_attachment_attachment_edit_filename');
      $('#product_has_attachment_attachment_edit_file').change(function() {
         var input = $(this);
         var value = input.val();
         if (value.indexOf("/") > 0) {
            var file = value.split("/");
         } else {
            var file = value.split("\\");
         }

         value = file.pop();

         console.log(value);

         var ext = stAssetsLibraryHelper.extractExtension(value);
         filename.val(stAssetsLibraryHelper.fixFilename(value, true));
         $('#product_has_attachment_filename_ext').html(ext ? '.'+ext : '');
      });
      filename.change(function() {
         var input = $(this);
         var value = input.val();
         
         input.val(stAssetsLibraryHelper.fixFilename(value, true));

         if (input.val() == '') {
            input.val(input.get(0).defaultValue);
         }
      });            
   });   
});
</script>