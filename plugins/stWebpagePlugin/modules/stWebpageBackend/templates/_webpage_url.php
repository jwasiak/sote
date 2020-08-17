<?php $webpage = $webpage_has_positioning->getWebpage();?>

<?php echo input_tag('webpage_has_positioning[webpage_url]', $webpage->getFriendlyUrl(), array('size' => '40')) ?>

<?php list($culture) = explode('_', $webpage->getCulture()); ?>

<p>
    <?php echo st_link_to(null, 'stWebpageFrontend/frontendIndex?url=' . $webpage->getFriendlyUrl(), array(
            'absolute' => true,
            'for_app' => 'frontend',
            'for_lang' => $culture,
            'no_script_name' => true,
            'class' => 'st_admin_external_link',
            'target' => '_blank')) ?>
</p>