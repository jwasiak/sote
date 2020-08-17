<?php $is_blocked =  ($order_status->getType() != 'ST_PENDING' || $order_status->getIsDefault()) ?>
<?php echo checkbox_tag('order_status[is_default]', true, $order_status->getIsDefault(), array('disabled' => $is_blocked)) ?>
<?php if ($is_blocked && $order_status->getIsDefault()): ?>
    <?php echo input_hidden_tag('order_status[is_default]', true) ?>
<?php endif; ?>