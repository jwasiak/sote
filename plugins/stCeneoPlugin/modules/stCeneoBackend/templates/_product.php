<?php if ($ceneo->getProductId()): ?>
    <?php echo st_external_link_to($ceneo->getProduct()->getName(), 'product/priceCompareCustom?product_id='.$ceneo->getProductId()); ?>
<?php endif; ?>