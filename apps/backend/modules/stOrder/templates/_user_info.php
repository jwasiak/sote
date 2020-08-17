<div class="st_order-user-data">
    <h3><?php echo __('Dane bilingowe') ?></h3>
    <?php st_include_partial('user_data', array('user_data' => $order->getOrderUserDataBilling(), 'type' => 'billing')); ?>
</div>
<div class="st_order-user-data">
    <h3><?php echo __('Dane dostawy') ?></h3>
    <?php st_include_partial('user_data', array('user_data' => $order->getOrderUserDataDelivery(), 'type' => 'delivery')); ?>
</div>
<br class="st_clear_all" />