<?php if ($order->getDiscountCouponCode()): ?>
&nbsp;<?php echo st_external_link_to($order->getDiscountCouponCode()->getCode(), 'stDiscountBackend/couponCodeEdit?id='.$order->getDiscountCouponCode()->getId()) ?> (<?php echo $order->getDiscountCouponCode()->getDiscount() ?>%)
<?php else: ?>
&nbsp;<?php echo __('Brak') ?>
<?php endif; ?>
