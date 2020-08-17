<?php use_helper('sfAsset') ?>
<div class="form-row" style="border: none">
  <?php $sort = $sf_user->getAttribute('sort', 'name', 'sf_admin/sf_asset/sort') ?>
  <label style="width: 150px">
    <?php echo image_tag('/plugins/sfAssetsLibraryPlugin/images/text_linespacing.png', 'align=top') ?>
    <?php if ($sort == 'name'): ?>
      <?php echo __('Sortuj po nazwie', null, 'sfAsset') ?>
      <?php echo link_to_asset(__('Sortuj po dacie', null, 'sfAsset'), 'sfAsset/'.$sf_params->get('action').'?dir='.$sf_params->get('dir'), array('query_string' => 'sort=date')) ?>
    <?php else: ?>
      <?php echo __('Sortuj po dacie', null, 'sfAsset') ?>
      <?php echo link_to_asset(__('Sortuj po nazwie', null, 'sfAsset'), 'sfAsset/'.$sf_params->get('action').'?dir='.$sf_params->get('dir'), array('query_string' => 'sort=name')) ?>
    <?php endif ?>
  </label>
</div>