<?php use_stylesheet('/sf/sf_admin/css/main') ?>
<?php use_stylesheet('/plugins/sfAssetsLibraryPlugin/css/backend.css') ?>
<?php use_helper('I18N', 'Date', 'Text', 'stAdminGenerator') ?>

<?php if (!$popup) : ?>
  <?php echo st_get_admin_head('sfAsset', __('Biblioteka mediów'), __('Zarządzanie mediami w sklepie'), array(1 => 'stProduct', 2 => 'stWebpagePlugin')) ?>
  <?php include_partial('list_header', array('folder' => $folder)) ?>
<?php endif; ?>

<div id="sf_asset_bar">
  <p><?php echo $folder->getName() ?></p>
  <?php if ($nb_dirs || $nb_files): ?>
    <?php if ($nb_dirs): ?>
      <p><?php echo format_number_choice('[1]Jeden katalog|(1,+Inf) Liczba katalogów: %nb%', array('%nb%' => $nb_dirs), $nb_dirs, 'sfAsset') ?></p>
    <?php endif; ?>
    <?php if ($nb_files): ?>
      <p><?php echo format_number_choice('[1]Jeden plik, %weight% Kb|(1,+Inf]plików: %nb% , %weight% Kb', array('%nb%' => $nb_files, '%weight%' => $total_size), $nb_files, 'sfAsset') ?></p>
    <?php endif; ?>
  <?php endif; ?>
  <?php include_partial('sfAsset/sidebar_sort') ?>
  <?php include_partial('sfAsset/sidebar_search') ?>
  <?php include_partial('sfAsset/sidebar_list', array('folder' => $folder, 'parent_folder' => $parent_folder)) ?>
</div>


<div id="sf_asset_container">
  <?php include_partial('sfAsset/messages') ?>
  <?php include_partial('sfAsset/list', array(
    'folder' => $folder,
    'dirs'   => $dirs,
    'files'  => $files
  )) ?>
</div>


<?php if (!$popup) : ?>
  <?php include_partial('sfAsset/list_footer', array('folder' => $folder)) ?>
  <?php echo st_get_admin_foot() ?>
<?php endif; ?>