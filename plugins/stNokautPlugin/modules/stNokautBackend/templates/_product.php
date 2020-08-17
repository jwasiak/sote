<?php if ($nokaut->getProductId()): ?>
    <?php echo st_external_link_to($nokaut->getProduct()->getName(), 'product/edit?id='.$nokaut->getProductId()); ?>
<?php endif; ?>