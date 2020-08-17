<?php use_helper('stAsset'); ?>
<p style="text-align: left">
<?php if ($product->getOptImage()): ?>
<?php echo link_to(st_asset_image_tag($product->getOptImage(), 'icon'), 'stProduct/edit?id=' . $product->getId()) ?>
<?php endif; ?>
</p>