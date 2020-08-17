<?php use_helper('stCurrency');?>
<table class="st_record_list" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th><?php echo __('Id') ?></th>
            <th><?php echo __('Data dokonania płatności') ?></th>
            <th><?php echo __('Kwota') ?></th>
            <th><?php echo __('Typ płatności') ?></th>
            <th><?php echo __('Status') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($payments as $payment): ?>
        <tr>
            <td><?php echo $payment->getId() ?></td>
            <td><?php echo $payment->getPayedAt() ?></td>      
            <td><?php echo st_backend_front_symbol()?> <?php echo stCurrency::formatPrice($payment->getAmount())?> <?php echo st_backend_back_symbol()?></td>
            <td><?php echo $payment->getPaymentType() ?></td>      
            <td>
                <?php if ($payment->getStatus()): ?>
                    <?php echo __('Rozliczona') ?>
                <?php else: ?>
                    <?php echo link_to_remote(__('Nierozliczona'), array('update' => 'st_component-stOrderEdit_Payment', 'url' => 'stPayment/updatePaymentInOrderEdit?id='.$payment->getId().'&order_id='.$order->getId(), 'with' => "'id=' + ".$payment->getId())) ?>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>