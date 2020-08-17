<?php $producer = $producer_has_positioning->getProducer();?>

<?php echo input_tag('producer_has_positioning[producer_url]', $producer->getFriendlyUrl(), array('size' => '80')) ?>

<?php list($culture) = explode('_', $producer->getCulture()); ?>

<p>
    <?php echo st_link_to(null, 'stProductFrontend/producerList?url=' . $producer->getFriendlyUrl(), array(
            'absolute' => true,
            'for_app' => 'frontend',
            'for_lang' => $culture,
            'no_script_name' => true,
            'class' => 'st_admin_external_link',
            'target' => '_blank')) ?>
</p>