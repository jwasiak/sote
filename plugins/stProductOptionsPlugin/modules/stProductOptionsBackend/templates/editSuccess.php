<?php use_helper('Object', 'Validation', 'I18N', 'Date', 'stAdminGenerator', 'stProductOptionsTree') ?>
<?php use_stylesheet('backend/stProductOptionsTree.css?v6'); ?>

<?php if_javascript(); ?>
    <?php echo st_get_admin_head('stProductOptionsPlugin', __(''), __(''),array (0 => 'stProduct',)) ?> 		
        <?php st_include_component('stProductOptionsTemplateBackend','listMenu') ?>
        <?php echo st_get_admin_horizontal_look_head() ?>
            <?php echo st_get_admin_horizontal_element_head('style="border: 0px;"') ?>
                <?php st_product_options_tree_include($sf_context->root, 'ProductOptionsDefaultValue', true, 'stProductOptionsTreeBackend', 'Ext.tree.stTreeNodeUI', array('root_name' => $product->getName())); ?>
                <?php st_include_component('stProductOptionsBackend', 'showOption', array('model' => 'stProductOptionsValue')) ?>
            <?php echo st_get_admin_horizontal_element_foot() ?>
        <?php echo st_get_admin_horizontal_look_foot() ?>
    <?php echo st_get_admin_foot() ?>
<?php end_if_javascript(); ?>

<noscript>
    <?php echo __('Twoja przeglądarka nie obsługuje Javascript.') ?>
</noscript>