<?php if ($okazje->getProductId()): ?>
    <?php echo st_external_link_to($okazje->getProduct()->getName(), 'product/edit?id='.$okazje->getProductId()); ?>
<?php endif; ?>