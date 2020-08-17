<?php if ($discount_coupon_code->getOrderId() && $discount_coupon_code->getOrder()): ?>
    <a href="<?php echo st_url_for('@stOrder?action=edit&id='.$discount_coupon_code->getOrderId()) ?>"><?php echo __('Zamówienie') ?>: <?php echo $discount_coupon_code->getOrder()->getNumber() ?></a><br>
    <a href="<?php echo st_url_for('@stUser?action=edit&id='.$discount_coupon_code->getOrder()->getSfGuardUserId()) ?>"><?php echo $discount_coupon_code->getOrder()->getOptClientEmail() ?></a>
<?php endif ?>