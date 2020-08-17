<?php if ($zakupomat->getProductId()): ?>
    <?php echo st_external_link_to($zakupomat->getProduct()->getName(), 'product/edit?id='.$zakupomat->getProductId()); ?>
<?php endif; ?>