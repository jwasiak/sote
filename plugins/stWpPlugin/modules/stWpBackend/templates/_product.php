<?php if ($wp->getProductId()): ?>
    <?php echo st_external_link_to($wp->getProduct()->getName(), 'product/edit?id='.$wp->getProductId()); ?>
<?php endif; ?>