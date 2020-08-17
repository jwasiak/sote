<?php use_helper('stProgressBar'); ?>

<?php use_helper('Form', 'Validation', 'I18N', 'stAdminGenerator') ?>

<?php echo st_get_admin_head('stMigration') ?>

<?php echo progress_bar('stMigration', 'stMigrationProgressBar', $action, $record_count, __('Import produktów', null, 'stMigration')); ?>

<div id="stMigration-multiProgressBar"></div>

<?php echo st_get_admin_foot() ?>