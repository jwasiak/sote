<?php if ($radar->getProductId()): ?>
    <?php echo st_external_link_to($radar->getProduct()->getName(), 'product/edit?id='.$radar->getProductId()); ?>
<?php endif; ?>