<?php use_helper('stAsset', 'stTooltip') ?>
<?php include_tooltip(); ?>

<div class="assetImage" <?php echo get_tooltip($sf_asset->getFilename()) ?>>
  <div class="thumbnails">
    <?php echo link_to_asset_action(st_asset_image_tag($sf_asset, 'thumb', array('width' => 84), isset($folder) ? $folder->getRelativePath() : null), $sf_asset) ?>
  </div>

  <div class="assetComment">    
    <?php echo truncate_str($sf_asset->getFilename()) ?>
    <div class="details">
      <?php echo $sf_asset->getFilesize() ?> Kb
      <?php if (!$sf_user->hasAttribute('popup', 'sf_admin/sf_asset/navigation')): ?>
        <?php echo link_to(image_tag('/plugins/sfAssetsLibraryPlugin/images/delete.png', 'class=deleteImage align=top'), 'sfAsset/deleteAsset?id='.$sf_asset->getId(), array('title' => __('Komunikat'), 'confirm' => __('Czy na pewno usunąć ?'))); ?>
      <?php endif; ?>
    </div>
  </div>
</div>
