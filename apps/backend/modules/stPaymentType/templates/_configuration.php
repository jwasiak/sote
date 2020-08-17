<?php if(is_object($payment_type)):?>
<?php if($payment_type->getModuleName() != '' && $payment_type->getModuleName() != 'stStandardPayment'):?>
        <?php echo st_link_to(__('Przejdź do konfiguracji'), '@'.$payment_type->getModuleName().'Plugin');?>
<?php if ($payment_type->checkPaymentConfiguration()): ?>
        (<?php echo __('Płatność skonfigurowana poprawnie') ?>)
<?php else: ?>
        (<?php echo __('Płatność nie została jeszcze skonfigurowana') ?>)
<?php endif; ?>
<?php else:?>
        <?php echo __('Płatność nie posiada konfiguracji.');?>
<?php endif;?>
<?php endif;?>