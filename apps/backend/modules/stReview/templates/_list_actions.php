<?php use_helper('stAdminGenerator', 'I18N') ?>
<?php if (!$sf_request->getParameter('product_id')): ?>
    <?php echo st_get_admin_actions_head('style="margin-top: 10px; float: right"') ?>
        <?php echo st_get_admin_action('more', __('Recenzję można dodać z poziomu produktu'), 'product/list') ?>
    <?php echo st_get_admin_actions_foot() ?>
<?php endif; ?>