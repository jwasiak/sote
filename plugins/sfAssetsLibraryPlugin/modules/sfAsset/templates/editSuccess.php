<?php use_stylesheet('/sf/sf_admin/css/main') ?>
<?php use_helper('I18N', 'Date', 'Text', 'stAdminGenerator') ?>

<?php echo st_get_admin_head('sfAsset', __('Biblioteka mediów'), __('Zarządzanie mediami w sklepie'), array(1 => 'stProduct', 2 => 'stWebpagePlugin')) ?>

<?php use_stylesheet('/sf/sf_admin/css/main') ?>
<?php use_helper('I18N', 'Date')?>

<h1><?php echo __('Asset edition', null, 'sfAsset') ?></h1>

<?php include_partial('sfAsset/edit_header', array('sf_asset' => $sf_asset)) ?>

<div id="sf_asset_bar" style="border: none">
   <?php if ($sf_flash->has('notice')): ?>
   <br /><br />
   <?php endif; ?>
  <?php include_partial('sfAsset/sidebar_edit', array('sf_asset' => $sf_asset)) ?>
</div>

<div id="sf_asset_container">
  <?php include_partial('sfAsset/messages', array('sf_asset' => $sf_asset)) ?>
  <?php include_partial('sfAsset/edit_form', array('sf_asset' => $sf_asset)) ?>
</div>

<?php include_partial('sfAsset/edit_footer', array('sf_asset' => $sf_asset)) ?>

<?php echo st_get_admin_foot() ?>