<?php if ($handelo->getProductId()): ?>
    <?php echo st_external_link_to($handelo->getProduct()->getName(), 'product/edit?id='.$handelo->getProductId()); ?>
<?php endif; ?>