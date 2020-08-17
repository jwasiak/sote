<?php $category = $category_has_positioning->getCategory();?>

<?php echo input_tag('category_has_positioning[category_url]', $category->getFriendlyUrl(), array('size' => '80')) ?>

<?php list($culture) = explode('_', $category->getCulture()); ?>

<p>
    <?php echo st_link_to(null, 'stProduct/frontendList?url=' . $category->getFriendlyUrl(), array(
            'absolute' => true,
            'for_app' => 'frontend',
            'for_lang' => $culture,
            'no_script_name' => true,
            'class' => 'st_admin_external_link',
            'target' => '_blank')) ?>
</p>