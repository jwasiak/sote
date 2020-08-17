<?php echo checkbox_tag('payment[status]', 1, $payment->getStatus()) ?>
<?php if ($payment->getStatus() && !$payment->isValid()): ?>
    <?php echo image_tag('/images/backend/icons/warning.png', array('title' => __('Status płatności został zmieniony bezpośrednio w bazie danych', null, 'stPayment'), 'class' => 'list_tooltip', 'style' => 'vertical-align: middle')) ?>
<?php endif ?>