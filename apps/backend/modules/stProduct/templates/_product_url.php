<?php $product = $product_has_positioning->getProduct();?>

<?php echo input_tag('product_has_positioning[product_url]', $product->getFriendlyUrl(), array('size' => '40')) ?>

<?php list($culture) = explode('_', $product->getCulture()); ?>

<p>
    <?php echo st_link_to(null, 'stProduct/frontendShow?url=' . $product->getFriendlyUrl(), array(
            'absolute' => true,
            'for_app' => 'frontend',
            'for_lang' => $culture,
            'no_script_name' => true,
            'class' => 'st_admin_external_link',
            'target' => '_blank')) ?>
</p>