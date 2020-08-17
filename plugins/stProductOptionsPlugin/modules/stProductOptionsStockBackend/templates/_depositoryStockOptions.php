<?php use_helper('stAdminGenerator') ?>
<?php echo st_get_admin_actions_head() ?>  
    <?php echo st_get_admin_action('more', __('Stan magazynowy opcji'), 'stProduct/optionsStockList?id='.$product->getId()) ?>
<?php echo st_get_admin_actions_foot() ?>