<?php 
use_helper('stOrder');
$total_amount = $order->getOptTotalAmount(); 
?>
<?php if ($order->getOrderCurrency()->getExchange() != 1): $currency = stCurrency::getDefault() ?>
<spam class="list_tooltip" title="<?php echo st_order_price_format($order->getOrderCurrency()->exchange($total_amount, true), $currency) ?>">
   <?php echo st_order_price_format($total_amount, $order->getOrderCurrency()) ?>
</span>
<?php else: ?>
    <?php echo st_order_price_format($total_amount, $order->getOrderCurrency()) ?>
<?php endif; ?>