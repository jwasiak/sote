<?php
if ($product_has_attachment->getSfAssetId())
{
   $ext = sfAssetsLibraryTools::getFileExtension($product_has_attachment->getSfAsset()->getFilename());
}
else
{
   $ext = sfAssetsLibraryTools::getFileExtension($sf_request->getFileName('product_has_attachment[attachment_edit_file]'));
}

echo input_tag('product_has_attachment[attachment_edit_filename]', $product_has_attachment->getAttachmentEditFilename());
?>
<span id="product_has_attachment_filename_ext"><?php echo $ext ? '.'.$ext : '' ?></span>
