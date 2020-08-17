<?php echo $order->getIsPayed() ? image_tag('/images/backend/beta/icons/16x16/tick.png') :  '&nbsp;' ?>
<?php if ($order->getIsPayed() && !$order->hasValidPayment()): ?>
<?php echo image_tag('/images/backend/icons/warning.png', array('title' => __('Status płatności został zmieniony bezpośrednio w bazie danych', null, 'stPayment'), 'class' => 'list_tooltip', 'style' => 'margin-left: 3px')) ?>
<?php endif ?>