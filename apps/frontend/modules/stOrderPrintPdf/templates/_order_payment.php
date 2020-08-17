<?php use_helper('stCurrency');?>
<font size="8">
<table border="1" cellspacing="0" width="502">
<tr><td bgcolor="#ccc">
<b><?php echo __('Dane płatności') ?>: </b>
</td></tr>
<tr><td>
    <?php if($order->getOrderPayment()->getId()): ?>

    <table border="0" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th bgcolor="#eee"><?php echo __('Data dokonania płatności') ?></th>
                <th bgcolor="#eee"><?php echo __('Kwota') ?></th>
                <th bgcolor="#eee"><?php echo __('Typ płatności') ?></th>
                <th bgcolor="#eee"><?php echo __('Status') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($order->getOrderHasPaymentsJoinPayment() as $ohp): $payment = $ohp->getPayment(); ?>
            <tr>
                <td><?php echo $payment->getPayedAt() ?></td>
                <td><?php echo st_order_price_format($payment->getAmount(), $order->getOrderCurrency()) ?></td>
                <td><?php echo $payment->getGiftCard() ? __('Bon towarowy: %code%', array('%code%' => $payment->getGiftCard()->getCode())) : $payment->getPaymentType() ?></td>
                <td>
                    <?php if ($payment->getStatus()): ?>
                        <?php echo __('Rozliczona') ?>
                    <?php else: ?>
                        <?php echo __('Nierozliczona') ?>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
    <?php endif; ?>
</td></tr>
</table>
</font>