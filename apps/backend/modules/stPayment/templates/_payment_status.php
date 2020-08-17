<?php if($payment->getCancel()): ?>
    <?php echo __('Anulowane') ?>
<?php elseif($payment->getStatus()): ?>
    <?php echo __('Zapłacono') ?>
    <?php if (!$payment->isValid()): ?>
        <?php echo image_tag('/images/backend/icons/warning.png', array('title' => __('Status płatności został zmieniony bezpośrednio w bazie danych', null, 'stPayment'), 'class' => 'list_tooltip', 'style' => 'vertical-align: middle')) ?>
    <?php endif ?>   
<?php else: ?>
    <?php echo __('Oczekuje na wpłatę') ?>
<?php endif; ?>