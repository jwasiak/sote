<?php use_helper('Helper','stOrder', 'stCurrency') ?> 
<?php $paid = $order->getPaidAmount() ?>
<?php $total = $order->getOptTotalAmount() - $paid; ?>


<table cellspacing="0" width="502">
    <?php if ($order->getDiscountCouponCode()): ?>
    <tr>
       <td align="right"><?php echo __('Kod rabatowy') ?>: <?php echo $order->getDiscountCouponCode()->getCode() ?> (<?php echo $order->getDiscountCouponCode()->getDiscount() ?>%)</td>
    </tr>      
    <?php endif; ?>
    <?php if ($order->getDiscount()): ?>
    <tr>
       <td align="right"><?php echo __('Udzielony rabat') ?>: <?php echo st_order_price_format($discount, $order->getOrderCurrency()) ?> <?php echo $order->getDiscount()->getName() ?></td>
    </tr>
    <?php endif ?>
    <tr>
       <td align="right"><?php echo __('Łączna wartość:') ?> <font size="16"><b><?php echo st_order_total_amount($order) ?><?php if($total_points_value > 0): echo "<br/>".$total_points_value." ".$config_points->get('points_shortcut', null, true); endif; ?></b></font></td>
    </tr>
</table>