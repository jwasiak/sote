<?php $product = ProductPeer::retrieveByPK($forward_parameters['product_id']);?>


<?php echo st_get_admin_actions_head('style="margin-top: 10px; float: right"') ?>
<?php if (!$product->getParentId()):?>
    <?php echo st_get_admin_action('duplicate', __('Zduplikuj produkt'), 'stProduct/duplicate?id='.$forward_parameters['product_id'], array ()) ?>
<?php else:?>
    <?php echo st_get_admin_action('duplicate', __('Zobacz orginalny produkt'), 'stProduct/edit?id='.$product->getParentId(), array ()) ?>
<?php endif;?>

<?php echo st_get_admin_actions_foot() ?>

