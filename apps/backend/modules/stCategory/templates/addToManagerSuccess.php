<?php use_helper('stAdminGenerator') ?>
<?php echo st_get_admin_head('stCategory', 'Test dodawania produktu', '') ?>
<?php st_include_component('stCategory', 'addToManager', array('product_id' => $product_id)) ?>
<?php echo st_get_admin_foot() ?>