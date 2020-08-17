<?php $product_group = $product_group_has_positioning->getProductGroup();?>

<?php echo input_tag('product_group_has_positioning[product_group_url]', $product_group->getFriendlyUrl(), array('size' => '40')) ?>

<?php list($culture) = explode('_', $product_group->getCulture()); ?>

<p>
    <?php echo st_link_to(null, 'stProduct/frontendGroupList?url=' . $product_group->getFriendlyUrl(), array(
            'absolute' => true,
            'for_app' => 'frontend',
            'for_lang' => $culture,
            'no_script_name' => true,
            'class' => 'st_admin_external_link',
            'target' => '_blank')) ?>
</p>
