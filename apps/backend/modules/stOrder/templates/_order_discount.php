<?php if ($order->hasDiscount()): $discount = $order->getTotalProductDiscountAmount(true, true) ?>
-<?php echo st_order_price_format($discount, $order->getOrderCurrency()) ?>
<?php if ($order->getDiscount()): ?>
 (<a target="_blank" href="<?php echo st_url_for('@stDiscountPlugin?action=edit&id='.$order->getDiscountId()) ?>"><?php echo $order->getDiscount()->getName() ?></a>)
<?php endif ?>
<?php else: ?>
&nbsp;<?php __('Brak') ?>
<?php endif ?>