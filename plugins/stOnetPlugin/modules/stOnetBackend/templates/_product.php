<?php if ($onet->getProductId()): ?>
    <?php echo st_external_link_to($onet->getProduct()->getName(), 'product/edit?id='.$onet->getProductId()); ?>
<?php endif; ?>