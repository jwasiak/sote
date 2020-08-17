<?php if ($sklepy24->getProductId()): ?>
    <?php echo st_external_link_to($sklepy24->getProduct()->getName(), 'product/edit?id='.$sklepy24->getProductId()); ?>
<?php endif; ?>