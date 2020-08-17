<?php if ($bazzar->getProductId()): ?>
    <?php echo st_external_link_to($bazzar->getProduct()->getName(), 'product/edit?id='.$bazzar->getProductId()); ?>
<?php endif; ?>