<?php if ($oferciak->getProductId()): ?>
    <?php echo st_external_link_to($oferciak->getProduct()->getName(), 'product/edit?id='.$oferciak->getProductId()); ?>
<?php endif; ?>