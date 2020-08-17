<?php if($payment->getOrderNumber()): ?>
    <?php echo st_external_link_to($payment->getOrderNumber(),'stOrder/edit?id='.$payment->getOrderId()) ?>
<?php else: ?>
    -
<?php endif; ?>